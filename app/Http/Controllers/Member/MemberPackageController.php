<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberPackageController extends Controller
{
    // Display Packages
    public function index()
    {
        $packages = Package::where('status', 'Active')
            ->orderBy('price', 'asc')
            ->paginate(9);
            
        return view('member.packages', compact('packages'));
    }

    // Buy Package
    public function buy(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id'
        ]);

        $package = Package::findOrFail($request->package_id);

        if ($package->status != 'Active') {
            return back()->with('error', 'This package is currently unavailable.');
        }

        // Here you can add:
        // 1. Check if user already has this package
        // 2. Create order/payment record
        // 3. Redirect to payment gateway
        // 4. Update user's package

        return back()->with('success', 'You have selected "' . $package->package_name . '" package! Proceed to payment.');
    }
}