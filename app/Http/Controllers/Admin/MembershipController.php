<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MembershipController extends Controller
{
    // Membership List
    public function index()
    {
        $memberships = Membership::latest()->paginate(10);

        return view('admin.membership-list', compact('memberships'));
    }

    // Create Page
    public function create()
    {
        return view('admin.membership-create');
    }

    // Store Membership
    public function store(Request $request)
    {
        $request->validate([
            'plan_name'      => 'required|string|max:255',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'duration'       => 'required|numeric',
            'duration_type'  => 'required',
            'price'          => 'required|numeric',
            'discount_type'  => 'required',
            'discount'       => 'nullable|numeric',
            'description'    => 'nullable|string',
            'status'         => 'required'
        ]);

        // Upload Image
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('membership-images', 'public');
        }

        // Calculate Final Price
        $price = $request->price;
        $discount = $request->discount ?? 0;

        if ($request->discount_type == 'Flat') {

            $finalPrice = $price - $discount;

        } else {

            $finalPrice = $price - (($price * $discount) / 100);

        }

        if ($finalPrice < 0) {
            $finalPrice = 0;
        }

        Membership::create([
            'plan_name'      => $request->plan_name,
            'image'          => $imagePath,
            'duration'       => $request->duration,
            'duration_type'  => $request->duration_type,
            'price'          => $price,
            'discount_type'  => $request->discount_type,
            'discount'       => $discount,
            'final_price'    => $finalPrice,
            'description'    => $request->description,
            'status'         => $request->status,
        ]);

        return redirect()->route('admin.membership.index')
            ->with('success', 'Membership created successfully.');
    }

    // Edit Page
    public function edit($id)
    {
        $membership = Membership::findOrFail($id);

        return view('admin.membership-edit', compact('membership'));
    }

    // Update Membership
    public function update(Request $request, $id)
    {
        $membership = Membership::findOrFail($id);

        $request->validate([
            'plan_name'      => 'required|string|max:255',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'duration'       => 'required|numeric',
            'duration_type'  => 'required',
            'price'          => 'required|numeric',
            'discount_type'  => 'required',
            'discount'       => 'nullable|numeric',
            'description'    => 'nullable|string',
            'status'         => 'required'
        ]);

        $imagePath = $membership->image;

        if ($request->hasFile('image')) {

            if ($membership->image) {
                Storage::disk('public')->delete($membership->image);
            }

            $imagePath = $request->file('image')->store('membership-images', 'public');
        }

        $price = $request->price;
        $discount = $request->discount ?? 0;

        if ($request->discount_type == 'Flat') {

            $finalPrice = $price - $discount;

        } else {

            $finalPrice = $price - (($price * $discount) / 100);

        }

        if ($finalPrice < 0) {
            $finalPrice = 0;
        }

        $membership->update([
            'plan_name'      => $request->plan_name,
            'image'          => $imagePath,
            'duration'       => $request->duration,
            'duration_type'  => $request->duration_type,
            'price'          => $price,
            'discount_type'  => $request->discount_type,
            'discount'       => $discount,
            'final_price'    => $finalPrice,
            'description'    => $request->description,
            'status'         => $request->status,
        ]);

        return redirect()->route('admin.membership.index')
            ->with('success', 'Membership updated successfully.');
    }

    // Delete Membership
    public function destroy($id)
    {
        $membership = Membership::findOrFail($id);

        if ($membership->image) {
            Storage::disk('public')->delete($membership->image);
        }

        $membership->delete();

        return redirect()->route('admin.membership.index')
            ->with('success', 'Membership deleted successfully.');
    }
}