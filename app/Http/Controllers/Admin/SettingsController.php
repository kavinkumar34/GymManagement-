<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'company_name' => Setting::get('company_name', 'GYMMANAGEMENT'),
            'company_logo' => Setting::get('company_logo', 'fas fa-dumbbell'),
            'primary_color' => Setting::get('primary_color', '#667eea'),
            'secondary_color' => Setting::get('secondary_color', '#764ba2'),
        ];
        
        return view('admin.settings', compact('settings'));
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_logo' => 'nullable|image|mimes:png,jpg,jpeg,gif,webp|max:2048',
            'primary_color' => 'nullable|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
        ]);
        
        // Update company name (allow null)
        if ($request->has('company_name')) {
            Setting::set('company_name', $request->company_name ?: null);
        }
        
        // Upload company logo image - STORE IN company_logo FIELD
        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $filename = time() . '_logo.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('logos', $filename, 'public');
            Setting::set('company_logo', '/storage/' . $path);
        }
        
        // Remove logo if requested
        if ($request->has('remove_logo')) {
            Setting::set('company_logo', 'fas fa-dumbbell');
        }
        
        Setting::set('primary_color', $request->primary_color);
        Setting::set('secondary_color', $request->secondary_color);
        
        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}