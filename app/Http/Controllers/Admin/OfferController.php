<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class OfferController extends Controller
{
    /**
     * Display a listing of the offers.
     */
    public function index(Request $request)
    {
        $query = Offer::query();
        
        // Filter by status
        if ($request->status && in_array($request->status, ['active', 'inactive', 'scheduled', 'expired'])) {
            $query->where('status', $request->status);
        }
        
        // Filter by type
        if ($request->type) {
            $query->where('offer_type', $request->type);
        }
        
        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('offer_name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('offer_code', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('offer_description', 'LIKE', '%' . $request->search . '%');
            });
        }
        
        $offers = $query->orderBy('created_at', 'desc')->paginate(12);
        
        return view('admin.offers.index', compact('offers'));
    }

    /**
     * Show the form for creating a new offer.
     */
    public function create()
    {
        $products = Product::where('status', 'Active')->orderBy('name')->get();
        $categories = Category::where('status', 'Active')->orderBy('name')->get();
        $brands = Brand::where('is_active', 1)->orderBy('name')->get();
        
        return view('admin.offers.create', compact('products', 'categories', 'brands'));
    }

    /**
     * Store a newly created offer in storage.
     */
    public function store(Request $request)
    {
        try {
            // Get array values from hidden inputs
            $applicableProducts = json_decode($request->input('applicable_products', '[]'), true);
            $applicableCategories = json_decode($request->input('applicable_categories', '[]'), true);
            $applicableBrands = json_decode($request->input('applicable_brands', '[]'), true);
            $excludedProducts = $request->input('excluded_products', []);
            $excludedCategories = $request->input('excluded_categories', []);
            $excludedBrands = $request->input('excluded_brands', []);
            $validDays = $request->input('valid_days', []);
            
            // Merge back into request
            $request->merge([
                'applicable_products' => $applicableProducts,
                'applicable_categories' => $applicableCategories,
                'applicable_brands' => $applicableBrands,
                'excluded_products' => $excludedProducts,
                'excluded_categories' => $excludedCategories,
                'excluded_brands' => $excludedBrands,
                'valid_days' => $validDays,
            ]);

            $validated = $request->validate([
                'offer_name' => 'required|string|max:255',
                'offer_code' => 'required|string|max:50|unique:offers,offer_code',
                'offer_description' => 'nullable|string',
                'offer_type' => 'required|in:product,category,brand,cart,bogo,bundle,flash_sale,new_user,festival',
                'discount_type' => 'required|in:percentage,fixed,buy_x_get_y,free_shipping',
                'discount_value' => 'nullable|numeric|min:0',
                'max_discount_amount' => 'nullable|numeric|min:0',
                'min_order_amount' => 'nullable|numeric|min:0',
                'buy_quantity' => 'nullable|integer|min:1',
                'get_quantity' => 'nullable|integer|min:1',
                'get_product_id' => 'nullable|exists:products,id',
                'get_category_id' => 'nullable|exists:categories,id',
                'brand_id' => 'nullable|exists:brands,id',
                'applicable_products' => 'nullable|array',
                'applicable_categories' => 'nullable|array',
                'applicable_brands' => 'nullable|array',
                'excluded_products' => 'nullable|array',
                'excluded_categories' => 'nullable|array',
                'excluded_brands' => 'nullable|array',
                'usage_limit_per_user' => 'nullable|integer|min:0',
                'usage_limit_total' => 'nullable|integer|min:0',
                'new_user_only' => 'nullable|boolean',
                'first_order_only' => 'nullable|boolean',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'valid_days' => 'nullable|array',
                'banner_image' => 'nullable|image|max:2048',
                'show_on_homepage' => 'nullable|boolean',
                'priority' => 'nullable|integer|min:0',
                'status' => 'required|in:active,inactive,scheduled,expired',
                'is_stackable' => 'nullable|boolean',
                'auto_apply' => 'nullable|boolean',
            ]);

            // Handle banner image
            if ($request->hasFile('banner_image')) {
                $path = $request->file('banner_image')->store('offers/banners', 'public');
                $validated['banner_image'] = $path;
            }

            // Convert arrays to JSON (handle empty arrays)
            $jsonFields = [
                'applicable_products', 
                'applicable_categories', 
                'applicable_brands', 
                'excluded_products', 
                'excluded_categories', 
                'excluded_brands', 
                'valid_days'
            ];
            
            foreach ($jsonFields as $field) {
                if (isset($validated[$field]) && is_array($validated[$field])) {
                    if (empty($validated[$field])) {
                        $validated[$field] = null;
                    } else {
                        $validated[$field] = json_encode(array_values($validated[$field]));
                    }
                } else {
                    $validated[$field] = null;
                }
            }

            // Set default values for boolean fields
            $validated['new_user_only'] = $request->has('new_user_only') ? 1 : 0;
            $validated['first_order_only'] = $request->has('first_order_only') ? 1 : 0;
            $validated['show_on_homepage'] = $request->has('show_on_homepage') ? 1 : 0;
            $validated['is_stackable'] = $request->has('is_stackable') ? 1 : 0;
            $validated['auto_apply'] = $request->has('auto_apply') ? 1 : 0;
            
            $validated['usage_count'] = 0;
            $validated['created_by'] = auth()->id();

            // Create the offer
            $offer = Offer::create($validated);

            return redirect()->route('admin.offers.index')
                ->with('success', 'Offer created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Offer Creation Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error creating offer: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified offer.
     */
    public function edit(Offer $offer)
    {
        $products = Product::where('status', 'Active')->orderBy('name')->get();
        $categories = Category::where('status', 'Active')->orderBy('name')->get();
        $brands = Brand::where('is_active', 1)->orderBy('name')->get();
        
        // FIX: Check if data is already array or string
        $offer->applicable_products = $this->decodeIfJson($offer->applicable_products);
        $offer->applicable_categories = $this->decodeIfJson($offer->applicable_categories);
        $offer->applicable_brands = $this->decodeIfJson($offer->applicable_brands);
        $offer->excluded_products = $this->decodeIfJson($offer->excluded_products);
        $offer->excluded_categories = $this->decodeIfJson($offer->excluded_categories);
        $offer->excluded_brands = $this->decodeIfJson($offer->excluded_brands);
        $offer->valid_days = $this->decodeIfJson($offer->valid_days);
        
        return view('admin.offers.edit', compact('offer', 'products', 'categories', 'brands'));
    }

    /**
     * Helper function to decode JSON if string, or return as is if array.
     */
    private function decodeIfJson($data)
    {
        if (is_null($data)) {
            return [];
        }
        
        if (is_array($data)) {
            return $data;
        }
        
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        return [];
    }

    /**
     * Update the specified offer in storage.
     */
    public function update(Request $request, Offer $offer)
    {
        try {
            // Get array values from hidden inputs
            $applicableProducts = json_decode($request->input('applicable_products', '[]'), true);
            $applicableCategories = json_decode($request->input('applicable_categories', '[]'), true);
            $applicableBrands = json_decode($request->input('applicable_brands', '[]'), true);
            $excludedProducts = $request->input('excluded_products', []);
            $excludedCategories = $request->input('excluded_categories', []);
            $excludedBrands = $request->input('excluded_brands', []);
            $validDays = $request->input('valid_days', []);
            
            $request->merge([
                'applicable_products' => $applicableProducts,
                'applicable_categories' => $applicableCategories,
                'applicable_brands' => $applicableBrands,
                'excluded_products' => $excludedProducts,
                'excluded_categories' => $excludedCategories,
                'excluded_brands' => $excludedBrands,
                'valid_days' => $validDays,
            ]);

            $validated = $request->validate([
                'offer_name' => 'required|string|max:255',
                'offer_code' => 'required|string|max:50|unique:offers,offer_code,' . $offer->id,
                'offer_description' => 'nullable|string',
                'offer_type' => 'required|in:product,category,brand,cart,bogo,bundle,flash_sale,new_user,festival',
                'discount_type' => 'required|in:percentage,fixed,buy_x_get_y,free_shipping',
                'discount_value' => 'nullable|numeric|min:0',
                'max_discount_amount' => 'nullable|numeric|min:0',
                'min_order_amount' => 'nullable|numeric|min:0',
                'buy_quantity' => 'nullable|integer|min:1',
                'get_quantity' => 'nullable|integer|min:1',
                'get_product_id' => 'nullable|exists:products,id',
                'get_category_id' => 'nullable|exists:categories,id',
                'brand_id' => 'nullable|exists:brands,id',
                'applicable_products' => 'nullable|array',
                'applicable_categories' => 'nullable|array',
                'applicable_brands' => 'nullable|array',
                'excluded_products' => 'nullable|array',
                'excluded_categories' => 'nullable|array',
                'excluded_brands' => 'nullable|array',
                'usage_limit_per_user' => 'nullable|integer|min:0',
                'usage_limit_total' => 'nullable|integer|min:0',
                'new_user_only' => 'nullable|boolean',
                'first_order_only' => 'nullable|boolean',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'valid_days' => 'nullable|array',
                'banner_image' => 'nullable|image|max:2048',
                'show_on_homepage' => 'nullable|boolean',
                'priority' => 'nullable|integer|min:0',
                'status' => 'required|in:active,inactive,scheduled,expired',
                'is_stackable' => 'nullable|boolean',
                'auto_apply' => 'nullable|boolean',
            ]);

            // Handle banner image
            if ($request->hasFile('banner_image')) {
                if ($offer->banner_image) {
                    \Storage::disk('public')->delete($offer->banner_image);
                }
                $path = $request->file('banner_image')->store('offers/banners', 'public');
                $validated['banner_image'] = $path;
            }

            // Convert arrays to JSON (handle empty arrays)
            $jsonFields = [
                'applicable_products', 
                'applicable_categories', 
                'applicable_brands', 
                'excluded_products', 
                'excluded_categories', 
                'excluded_brands', 
                'valid_days'
            ];
            
            foreach ($jsonFields as $field) {
                if (isset($validated[$field]) && is_array($validated[$field])) {
                    if (empty($validated[$field])) {
                        $validated[$field] = null;
                    } else {
                        $validated[$field] = json_encode(array_values($validated[$field]));
                    }
                } else {
                    $validated[$field] = null;
                }
            }

            // Set boolean fields
            $validated['new_user_only'] = $request->has('new_user_only') ? 1 : 0;
            $validated['first_order_only'] = $request->has('first_order_only') ? 1 : 0;
            $validated['show_on_homepage'] = $request->has('show_on_homepage') ? 1 : 0;
            $validated['is_stackable'] = $request->has('is_stackable') ? 1 : 0;
            $validated['auto_apply'] = $request->has('auto_apply') ? 1 : 0;

            $offer->update($validated);

            return redirect()->route('admin.offers.index')
                ->with('success', 'Offer updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Offer Update Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error updating offer: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified offer from storage.
     */
    public function destroy(Offer $offer)
    {
        try {
            if ($offer->banner_image) {
                \Storage::disk('public')->delete($offer->banner_image);
            }
            $offer->delete();

            return response()->json(['success' => true, 'message' => 'Offer deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Toggle offer status.
     */
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

    /**
     * Duplicate an offer.
     */
    public function duplicate(Offer $offer)
    {
        try {
            $newOffer = $offer->replicate();
            $newOffer->offer_code = $offer->offer_code . '-' . strtoupper(Str::random(4));
            $newOffer->offer_name = $offer->offer_name . ' (Copy)';
            $newOffer->status = 'inactive';
            $newOffer->usage_count = 0;
            $newOffer->created_at = now();
            $newOffer->updated_at = now();
            $newOffer->save();

            return response()->json([
                'success' => true,
                'message' => 'Offer duplicated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get offer statistics.
     */
    public function getStats()
    {
        try {
            $total = Offer::count();
            $active = Offer::where('status', 'active')->count();
            $inactive = Offer::where('status', 'inactive')->count();
            $scheduled = Offer::where('status', 'scheduled')->count();
            $expired = Offer::where('status', 'expired')->count();

            return response()->json([
                'success' => true,
                'total' => $total,
                'active' => $active,
                'inactive' => $inactive,
                'scheduled' => $scheduled,
                'expired' => $expired
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get products for AJAX.
     */
    public function getProducts(Request $request)
    {
        $search = $request->get('q', '');
        $products = Product::where('status', 'Active')
            ->where('name', 'LIKE', '%' . $search . '%')
            ->limit(20)
            ->get(['id', 'name', 'price', 'image']);
        
        return response()->json($products);
    }

    /**
     * Get categories for AJAX.
     */
    public function getCategories(Request $request)
    {
        $search = $request->get('q', '');
        $categories = Category::where('status', 'Active')
            ->where('name', 'LIKE', '%' . $search . '%')
            ->limit(20)
            ->get(['id', 'name']);
        
        return response()->json($categories);
    }

    /**
     * Get brands for AJAX.
     */
    public function getBrands(Request $request)
    {
        $search = $request->get('q', '');
        $brands = Brand::where('is_active', 1)
            ->where('name', 'LIKE', '%' . $search . '%')
            ->limit(20)
            ->get(['id', 'name', 'logo']);
        
        return response()->json($brands);
    }

    /**
     * Bulk delete offers.
     */
    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:offers,id'
            ]);

            $deleted = Offer::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => $deleted . ' offer(s) deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Bulk update offer status.
     */
    public function bulkStatus(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:offers,id',
                'status' => 'required|in:active,inactive,scheduled,expired'
            ]);

            $updated = Offer::whereIn('id', $request->ids)
                ->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => $updated . ' offer(s) updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}