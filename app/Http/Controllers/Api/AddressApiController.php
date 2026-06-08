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
        if (Auth::check()) {
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
        return response()->json(['success' => false, 'message' => 'Not logged in']);
    }

    public function getAddresses()
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'addresses' => []]);
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
            return response()->json(['success' => false, 'message' => 'User not logged in']);
        }

        try {
            $address = UserAddress::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'email' => $request->email ?? Auth::user()->email,
                'address' => $request->address,
                'area' => $request->area,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'phone' => $request->phone,
                'is_default' => $request->is_default ?? false
            ]);

            return response()->json([
                'success' => true,
                'address' => $address,
                'message' => 'Address saved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deleteAddress($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false]);
        }

        $address = UserAddress::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
        
        if ($address) {
            $address->delete();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false]);
    }
}