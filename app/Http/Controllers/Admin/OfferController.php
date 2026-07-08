<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $query = Offer::query();
        
        if ($request->status && in_array($request->status, ['active', 'inactive', 'scheduled', 'expired'])) {
            $query->where('status', $request->status);
        }
        
        if ($request->type) {
            $query->where('offer_type', $request->type);
        }
        
        if ($request->combo_type) {
            $query->where('combo_type', $request->combo_type);
        }
        
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('offer_name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('offer_code', 'LIKE', '%' . $request->search . '%');
            });
        }
        
        $offers = $query->orderBy('created_at', 'desc')->paginate(12);
        $products = Product::where('status', 'Active')->orderBy('name')->get();
        
        return view('admin.offers.index', compact('offers', 'products'));
    }

    public function create()
    {
        $products = Product::where('status', 'Active')->orderBy('name')->get();
        return view('admin.offers.create', compact('products'));
    }

public function store(Request $request)
{
    try {
        \Log::info('Offer Store Request:', $request->all());
        
        $validated = $request->validate([
            'offer_name' => 'required|string|max:255',
            'offer_type' => 'required|in:combo,bogo,flash_sale,seasonal',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit_total' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'required|date',
            'status' => 'nullable|in:active,inactive',
        ]);

        // Handle product selection
        if ($request->offer_type === 'bogo' && $request->single_product_id) {
            $validated['applicable_products'] = json_encode([(int)$request->single_product_id]);
            $validated['combo_type'] = 'single_product';
        } elseif ($request->offer_type === 'combo' && $request->has('applicable_products')) {
            $productIds = array_map('intval', $request->applicable_products);
            if (count($productIds) < 2) {
                return redirect()->back()
                    ->with('error', 'Please select at least 2 products for combo offer')
                    ->withInput();
            }
            $validated['applicable_products'] = json_encode(array_values($productIds));
            $validated['combo_type'] = 'multiple_products';
        } else {
            return redirect()->back()
                ->with('error', 'Please select products for the offer')
                ->withInput();
        }

        // Generate offer code
        $validated['offer_code'] = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $validated['offer_name']), 0, 10)) . '-' . rand(100, 999);
        $validated['start_date'] = $validated['start_date'] ?? now();
        $validated['status'] = $request->has('status') && $request->status === 'active' ? 'active' : 'inactive';
        $validated['usage_limit_per_user'] = 1;
        $validated['usage_count'] = 0;
        $validated['created_by'] = auth()->id();

        \Log::info('Offer Data to save:', $validated);

        $offer = Offer::create($validated);

        return redirect()->route('admin.offers.index')
            ->with('success', 'Combo created successfully!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validation Error:', $e->errors());
        return redirect()->back()
            ->withErrors($e->errors())
            ->withInput();
    } catch (\Exception $e) {
        \Log::error('Offer Creation Error: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'Error: ' . $e->getMessage())
            ->withInput();
    }
}

    public function edit(Offer $offer)
    {
        $products = Product::where('status', 'Active')->orderBy('name')->get();
        return view('admin.offers.edit', compact('offer', 'products'));
    }

  public function update(Request $request, Offer $offer)
{
    try {
        \Log::info('Offer Update Request:', $request->all());

        $validated = $request->validate([
            'offer_name' => 'required|string|max:255',
            'offer_type' => 'required|in:combo,bogo,flash_sale,seasonal',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit_total' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'required|date',
            'status' => 'nullable|in:active,inactive,scheduled,expired',
            'usage_limit_per_user' => 'nullable|integer|min:0',
        ]);

        // Handle product selection
        if ($request->offer_type === 'bogo' && $request->single_product_id) {
            $validated['applicable_products'] = json_encode([(int)$request->single_product_id]);
            $validated['combo_type'] = 'single_product';
        } elseif ($request->offer_type === 'combo' && $request->has('applicable_products')) {
            $productIds = array_map('intval', $request->applicable_products);
            if (count($productIds) < 2) {
                return redirect()->back()
                    ->with('error', 'Please select at least 2 products for combo offer')
                    ->withInput();
            }
            $validated['applicable_products'] = json_encode(array_values($productIds));
            $validated['combo_type'] = 'multiple_products';
        } else {
            return redirect()->back()
                ->with('error', 'Please select products for the offer')
                ->withInput();
        }

        // Generate offer code if not provided
        if (empty($request->offer_code)) {
            $validated['offer_code'] = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $validated['offer_name']), 0, 10)) . '-' . rand(100, 999);
        } else {
            $validated['offer_code'] = strtoupper($request->offer_code);
        }

        $validated['start_date'] = $validated['start_date'] ?? now();
        $validated['usage_limit_per_user'] = $validated['usage_limit_per_user'] ?? 1;

        \Log::info('Offer Data to update:', $validated);

        $offer->update($validated);

        return redirect()->route('admin.offers.index')
            ->with('success', 'Combo updated successfully!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validation Error:', $e->errors());
        return redirect()->back()
            ->withErrors($e->errors())
            ->withInput();
    } catch (\Exception $e) {
        \Log::error('Offer Update Error: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'Error: ' . $e->getMessage())
            ->withInput();
    }
}

    public function destroy(Offer $offer)
    {
        try {
            $offer->delete();
            return response()->json(['success' => true, 'message' => 'Offer deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function toggle(Offer $offer)
    {
        try {
            $newStatus = $offer->status === 'active' ? 'inactive' : 'active';
            $offer->update(['status' => $newStatus]);
            return response()->json([
                'success' => true,
                'message' => 'Offer ' . ($newStatus === 'active' ? 'activated' : 'deactivated') . ' successfully!',
                'status' => $newStatus
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function duplicate(Offer $offer)
    {
        try {
            $newOffer = $offer->replicate();
            $newOffer->offer_code = $offer->offer_code . '-' . strtoupper(Str::random(4));
            $newOffer->offer_name = $offer->offer_name . ' (Copy)';
            $newOffer->status = 'inactive';
            $newOffer->usage_count = 0;
            $newOffer->save();
            return response()->json(['success' => true, 'message' => 'Offer duplicated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getStats()
    {
        try {
            return response()->json([
                'success' => true,
                'total' => Offer::count(),
                'active' => Offer::where('status', 'active')->count(),
                'inactive' => Offer::where('status', 'inactive')->count(),
                'scheduled' => Offer::where('status', 'scheduled')->count(),
                'expired' => Offer::where('status', 'expired')->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getProducts(Request $request)
    {
        $search = $request->get('q', '');
        $products = Product::where('status', 'Active')
            ->where('name', 'LIKE', '%' . $search . '%')
            ->limit(20)
            ->get(['id', 'name', 'price', 'image']);
        return response()->json($products);
    }

    public function bulkDelete(Request $request)
    {
        try {
            $request->validate(['ids' => 'required|array', 'ids.*' => 'exists:offers,id']);
            $deleted = Offer::whereIn('id', $request->ids)->delete();
            return response()->json(['success' => true, 'message' => $deleted . ' offer(s) deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function bulkStatus(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:offers,id',
                'status' => 'required|in:active,inactive,scheduled,expired'
            ]);
            $updated = Offer::whereIn('id', $request->ids)->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => $updated . ' offer(s) updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
 * Apply offer to cart
 */
public function applyOffer(Request $request)
{
    try {
        $request->validate([
            'offer_id' => 'required|exists:offers,id',
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id'
        ]);

        $offer = Offer::findOrFail($request->offer_id);

        if (!$offer->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Offer is not valid or expired'
            ]);
        }

        // Check if all products are applicable
        $applicableProducts = $offer->applicable_products;
        $productIds = $request->product_ids;

        foreach ($productIds as $productId) {
            if (!in_array($productId, $applicableProducts)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Some products are not applicable for this offer'
                ]);
            }
        }

        // Calculate discount
        $totalPrice = 0;
        foreach ($productIds as $productId) {
            $product = Product::find($productId);
            if ($product) {
                $totalPrice += $product->price;
            }
        }

        $discount = $offer->calculateDiscount($totalPrice);

        return response()->json([
            'success' => true,
            'discount' => $discount,
            'total_price' => $totalPrice,
            'final_price' => $totalPrice - $discount,
            'offer' => $offer
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

/**
 * Validate offer by code
 */
public function validateOffer($code)
{
    try {
        $offer = Offer::where('offer_code', strtoupper($code))->first();

        if (!$offer) {
            return response()->json([
                'success' => false,
                'message' => 'Offer not found'
            ]);
        }

        $isValid = $offer->isValid();

        return response()->json([
            'success' => true,
            'offer' => $offer,
            'is_valid' => $isValid,
            'discount_text' => $offer->getDiscountText(),
            'product_count' => count($offer->applicable_products ?? [])
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}