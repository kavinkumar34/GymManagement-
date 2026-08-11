<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressApiController extends Controller
{
    public function getUser()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Not logged in'
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? ''
            ]
        ]);
    }


    public function getAddresses()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'addresses' => []
            ], 401);
        }

        $addresses = UserAddress::where('user_id', Auth::id())
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'addresses' => $addresses
        ]);
    }


    public function storeAddress(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User not logged in'
            ], 401);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:255',
            'area' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|digits:6',
            'phone' => 'required|string|max:15',
            'is_default' => 'nullable|boolean',
        ]);

        try {

            if (!empty($validated['is_default'])) {
                UserAddress::where('user_id', Auth::id())
                    ->update(['is_default' => 0]);
            }

            $address = UserAddress::create([
                'user_id' => Auth::id(),
                'name' => $validated['name'],
                'email' => $validated['email'] ?? Auth::user()->email,
                'address' => $validated['address'],
                'area' => $validated['area'] ?? '',
                'city' => $validated['city'],
                'state' => $validated['state'],
                'pincode' => $validated['pincode'],
                'phone' => $validated['phone'],
                'is_default' => $validated['is_default'] ?? 0,
            ]);

            return response()->json([
                'success' => true,
                'address' => $address->fresh(),
                'message' => 'Address saved successfully'
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function updateAddress(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User not logged in'
            ], 401);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:255',
            'area' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|digits:6',
            'phone' => 'required|string|max:15',
            'is_default' => 'nullable|boolean',
        ]);

        $address = UserAddress::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found'
            ], 404);
        }

        try {

            if (!empty($validated['is_default'])) {
                UserAddress::where('user_id', Auth::id())
                    ->where('id', '!=', $id)
                    ->update(['is_default' => 0]);
            }

            $address->update([
                'name' => $validated['name'],
                'email' => $validated['email'] ?? Auth::user()->email,
                'address' => $validated['address'],
                'area' => $validated['area'] ?? '',
                'city' => $validated['city'],
                'state' => $validated['state'],
                'pincode' => $validated['pincode'],
                'phone' => $validated['phone'],
                'is_default' => $validated['is_default'] ?? $address->is_default,
            ]);

            return response()->json([
                'success' => true,
                'address' => $address->fresh(),
                'message' => 'Address updated successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function deleteAddress($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User not logged in'
            ], 401);
        }

        $address = UserAddress::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found'
            ], 404);
        }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully'
        ]);
    }
}