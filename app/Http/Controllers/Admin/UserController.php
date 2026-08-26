<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }

    /**
     * Export users to CSV.
     * Phone numbers are formatted as text to prevent scientific notation.
     * Dates are formatted properly.
     */
    public function export(Request $request)
    {
        // Get filter values from request
        $search = $request->get('search');
        $verified = $request->get('verified');

        // Build query with filters
        $query = User::query();

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // Apply verified filter
        if ($verified === 'yes') {
            $query->where('is_verified', true);
        } elseif ($verified === 'no') {
            $query->where('is_verified', false);
        }

        // Get all users (no pagination)
        $users = $query->orderBy('created_at', 'desc')->get();

        // Create filename with timestamp
        $filename = 'users_list_' . date('Y-m-d_H-i-s') . '.csv';

        // Create CSV content
        $callback = function() use ($users) {
            
            // Open output stream
            $handle = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fputs($handle, "\xEF\xBB\xBF");
            
            // ==========================================
            // WRITE HEADERS - Match Table Columns
            // ==========================================
            fputcsv($handle, [
                'S.No',
                'Name',
                'Email',
                'Phone',
                'Is Verified',
                'Created At'
            ]);
            
            // ==========================================
            // WRITE DATA ROWS - Format for Excel
            // ==========================================
            foreach ($users as $index => $user) {
                
                // ===== FIX 1: Phone Number as TEXT =====
                // Add '=' before phone number to force Excel to treat it as text
                // This prevents scientific notation (8.9E+09)
                $phone = $user->phone ?? '-';
                if ($phone !== '-' && !empty($phone)) {
                    // Clean phone number (remove spaces, special chars)
                    $phone = preg_replace('/[^0-9]/', '', $phone);
                    // Format as text with equals sign
                    $phone = '="' . $phone . '"';
                }
                
                // ===== FIX 2: Date Format =====
                // Format date as d-m-Y h:i A (same as web table)
                $createdAt = $user->created_at 
                    ? $user->created_at->format('d M Y, h:i A') 
                    : 'N/A';
                // Force date as text to prevent Excel auto-formatting
                $createdAt = '="' . $createdAt . '"';
                
                fputcsv($handle, [
                    $index + 1,
                    $user->name ?? 'N/A',
                    $user->email ?? 'N/A',
                    $phone,  // Now shows as full number, not scientific notation
                    $user->is_verified ? 'Yes' : 'No',
                    $createdAt  // Now shows proper date format
                ]);
            }
            
            fclose($handle);
        };

        // Return as downloadable response
        return response()->streamDownload(
            $callback,
            $filename,
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]
        );
    }
}