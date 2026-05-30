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
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|string|max:100',
            'primary_color' => 'nullable|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
        ]);
        
        Setting::set('company_name', $request->company_name);
        Setting::set('company_logo', $request->company_logo ?: 'fas fa-dumbbell');
        Setting::set('primary_color', $request->primary_color);
        Setting::set('secondary_color', $request->secondary_color);
        
        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
    
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);
        
        $file = $request->file('logo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('logos', $filename, 'public');
        
        Setting::set('company_logo_image', '/storage/' . $path);
        
        return response()->json(['success' => true, 'path' => '/storage/' . $path]);
    }
}