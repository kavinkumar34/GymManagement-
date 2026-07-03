<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order', 'asc')->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }
    
    public function create()
    {
        return view('admin.banners.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
            'status' => 'required|in:Active,Inactive'
        ]);
        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
        }
        
        Banner::create([
            'image' => $imagePath,
            'link' => $request->link,
            'order' => $request->order ?? 0,
            'status' => $request->status
        ]);
        
        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully!');
    }
    
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }
    
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
            'status' => 'required|in:Active,Inactive'
        ]);
        
        if ($request->hasFile('image')) {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $banner->image = $request->file('image')->store('banners', 'public');
        }
        
        $banner->update([
            'link' => $request->link,
            'order' => $request->order ?? 0,
            'status' => $request->status
        ]);
        
        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully!');
    }
    
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }
        
        $banner->delete();
        
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully!');
    }
}