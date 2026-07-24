<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    // List Packages
    public function index()
    {
        $packages = Package::latest()->paginate(10);
        return view('admin.package-list', compact('packages'));
    }

    // Create Page
    public function create()
    {
        return view('admin.package-create');
    }

    // Store Package
    public function store(Request $request)
    {
        $request->validate([
            'package_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'duration_type' => 'required|in:Days,Months,Years',
            'included_features' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('packages', 'public');
        }

        Package::create([
            'package_name' => $request->package_name,
            'image' => $image,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'duration_type' => $request->duration_type,
            'included_features' => $request->included_features,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.package.index')
            ->with('success', 'Package created successfully!');
    }

    // Edit Page
    public function edit($id)
    {
        $package = Package::findOrFail($id);
        return view('admin.package-edit', compact('package'));
    }

    // Update Package
    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $request->validate([
            'package_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'duration_type' => 'required|in:Days,Months,Years',
            'included_features' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        $image = $package->image;

        if ($request->hasFile('image')) {

            if ($package->image && Storage::disk('public')->exists($package->image)) {
                Storage::disk('public')->delete($package->image);
            }

            $image = $request->file('image')->store('packages', 'public');
        }

        $package->update([
            'package_name' => $request->package_name,
            'image' => $image,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'duration_type' => $request->duration_type,
            'included_features' => $request->included_features,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.package.index')
            ->with('success', 'Package updated successfully!');
    }

    // Delete Package
    public function destroy($id)
    {
        $package = Package::findOrFail($id);

        if ($package->image && Storage::disk('public')->exists($package->image)) {
            Storage::disk('public')->delete($package->image);
        }

        $package->delete();

        return redirect()->route('admin.package.index')
            ->with('success', 'Package deleted successfully!');
    }
}