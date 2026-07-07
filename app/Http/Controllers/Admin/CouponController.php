<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::query();
        
        // Filter by status
        if ($request->status == 'active') {
            $query->where('is_active', 1)
                  ->where(function($q) {
                      $q->whereNull('end_date')
                        ->orWhere('end_date', '>=', Carbon::now());
                  });
        } elseif ($request->status == 'expired') {
            $query->where('is_active', 1)
                  ->where('end_date', '<', Carbon::now());
        } elseif ($request->status == 'inactive') {
            $query->where('is_active', 0);
        }
        
        $coupons = $query->orderBy('id', 'desc')->get();
        
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'name' => 'nullable|string|max:100',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:0',
            'per_user_limit' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean'
        ]);

        $coupon = Coupon::create([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount ?? 0,
            'max_discount' => $request->max_discount,
            'usage_limit' => $request->usage_limit,
            'per_user_limit' => $request->per_user_limit ?? 1,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->is_active ?? 1,
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully!');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $id,
            'name' => 'nullable|string|max:100',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:0',
            'per_user_limit' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'boolean'
        ]);

        $coupon->update([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount ?? 0,
            'max_discount' => $request->max_discount,
            'usage_limit' => $request->usage_limit,
            'per_user_limit' => $request->per_user_limit ?? 1,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->is_active ?? 1,
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully!');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon status updated!');
    }

    public function checkCode(Request $request)
    {
        $code = $request->input('code');
        $exists = Coupon::where('code', strtoupper($code))->exists();
        
        return response()->json(['exists' => $exists]);
    }

    public function view($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'coupon' => [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'name' => $coupon->name,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'min_order_amount' => $coupon->min_order_amount,
                    'max_discount' => $coupon->max_discount,
                    'usage_limit' => $coupon->usage_limit,
                    'used_count' => $coupon->used_count,
                    'per_user_limit' => $coupon->per_user_limit,
                    'start_date' => $coupon->start_date,
                    'end_date' => $coupon->end_date,
                    'is_active' => $coupon->is_active,
                    'created_at' => $coupon->created_at,
                    'updated_at' => $coupon->updated_at
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
}