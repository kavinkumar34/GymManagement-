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
            
            // ===== FOOTER SETTINGS =====
            'footer_address' => Setting::get('footer_address', '123 Fitness Street, Chennai - 600001'),
            'footer_phone' => Setting::get('footer_phone', '+91 98765 43210'),
            'footer_email' => Setting::get('footer_email', 'info@fitforge.com'),
            'footer_whatsapp' => Setting::get('footer_whatsapp', '+91 90255 95190'),
            'footer_whatsapp_link' => Setting::get('footer_whatsapp_link', 'https://wa.me/919025595190?text=Hi%20FitForge%2C%20I%20need%20assistance.'),
            'footer_facebook' => Setting::get('footer_facebook', '#'),
            'footer_instagram' => Setting::get('footer_instagram', '#'),
            'footer_whatsapp_social' => Setting::get('footer_whatsapp_social', '#'),
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
            // ===== FOOTER VALIDATION =====
            'footer_address' => 'nullable|string|max:500',
            'footer_phone' => 'nullable|string|max:50',
            'footer_email' => 'nullable|email|max:100',
            'footer_whatsapp' => 'nullable|string|max:50',
            'footer_whatsapp_link' => 'nullable|url|max:255',
            'footer_facebook' => 'nullable|url|max:255',
            'footer_instagram' => 'nullable|url|max:255',
            'footer_whatsapp_social' => 'nullable|url|max:255',
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
        
        // ===== FOOTER SETTINGS =====
        Setting::set('footer_address', $request->footer_address ?: '123 Fitness Street, Chennai - 600001');
        Setting::set('footer_phone', $request->footer_phone ?: '+91 98765 43210');
        Setting::set('footer_email', $request->footer_email ?: 'info@fitforge.com');
        Setting::set('footer_whatsapp', $request->footer_whatsapp ?: '+91 90255 95190');
        Setting::set('footer_whatsapp_link', $request->footer_whatsapp_link ?: 'https://wa.me/919025595190?text=Hi%20FitForge%2C%20I%20need%20assistance.');
        Setting::set('footer_facebook', $request->footer_facebook ?: '#');
        Setting::set('footer_instagram', $request->footer_instagram ?: '#');
        Setting::set('footer_whatsapp_social', $request->footer_whatsapp_social ?: '#');
        
        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}