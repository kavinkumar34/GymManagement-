<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopCategory;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ProductType;
use App\Models\SizeChart;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'subCategory', 'topCategory', 'variants'])
            ->orderBy('id', 'desc')
            ->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $topCategories = TopCategory::where('is_active', 1)->get();
        $brands = Brand::where('is_active', 1)->get();
        $sizeCharts = SizeChart::all();
        $categories = Category::where('is_active', 1)->get();
        $subCategories = SubCategory::where('is_active', 1)->get();
        $productTypes = ProductType::where('is_active', 1)->get();
        
        return view('admin.products.create', compact('topCategories', 'brands', 'sizeCharts', 'categories', 'subCategories', 'productTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'top_category_id' => 'required|exists:top_categories,id',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'price' => 'nullable|numeric|min:0',
            'mrp' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'images' => 'nullable|array|max:4',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
            'variants' => 'nullable|array',
            'variants.*.color' => 'nullable|string',
            'variants.*.sizes' => 'nullable|array',
        ]);

        try {
            // Get GST from top category
            $topCategory = TopCategory::find($request->top_category_id);
            $gstRate = $topCategory->gst_rate ?? 0;
            
            // Calculate values
            $sellingPrice = $request->mrp ?? 0;
            $costPrice = $request->price ?? 0;
            
            // 1. Calculate GST Amount on Selling Price
            $gstAmount = ($sellingPrice * $gstRate) / 100;
            
            // 2. Calculate Price with GST (Total Price)
            $totalPrice = $sellingPrice + $gstAmount;
            
            // 3. Calculate Discount
            $discountType = $request->discount_type ?? 'flat';
            $discountValue = $request->discount_value ?? 0;
            $discountAmount = 0;
            
            if ($discountType === 'flat') {
                $discountAmount = $discountValue;
            } elseif ($discountType === 'percentage') {
                $discountAmount = ($sellingPrice * $discountValue) / 100;
            }
            
            // 4. Calculate Final Price = Total Price - Discount Amount
            $finalPrice = $totalPrice - $discountAmount;
            
            // Ensure final price is not negative
            if ($finalPrice < 0) {
                $finalPrice = 0;
            }

            // Create product with all fields
            $product = Product::create([
                'name' => $request->name,
                'top_category_id' => $request->top_category_id,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'product_type_id' => $request->product_type_id,
                'size_chart_id' => $request->size_chart_id,
                'price' => $costPrice ?? 0,
                'mrp' => $sellingPrice ?? 0,
                'final_price' => $finalPrice,
                'discount_type' => $discountType,
                'discount_value' => $discountValue,
                'discount_amount' => $discountAmount,
                'gst_percentage' => $gstRate,
                'gst_amount' => $gstAmount,
                'total_price' => $totalPrice,
                'stock' => $request->stock ?? 0,
                'description' => $request->description,
                'status' => $request->status ?? 'Active',
                'return_days' => $request->return_days ?? 7,
                'cod_available' => $request->has('cod_available') ? 1 : 0,
                'delivery_days' => $request->delivery_days ?? 3,
                'created_by' => auth()->id(),
            ]);

            // ====== SAVE VARIANTS ======
            if ($request->has('variants') && is_array($request->variants)) {
                foreach ($request->variants as $variant) {
                    $color = $variant['color'] ?? null;

                    if (isset($variant['sizes']) && is_array($variant['sizes'])) {
                        foreach ($variant['sizes'] as $sizeData) {
                            // Skip if no size or no stock
                            if (empty($sizeData['size']) && empty($sizeData['stock'])) {
                                continue;
                            }

                            // Calculate GST and Final Price for each size
                            $sizeMrp = floatval($sizeData['mrp'] ?? 0);
                            $sizeCostPrice = floatval($sizeData['cost_price'] ?? 0);
                            $sizeDiscountType = $sizeData['discount_type'] ?? 'flat';
                            $sizeDiscountValue = floatval($sizeData['discount_value'] ?? 0);
                            
                            // Calculate GST Amount on MRP
                            $sizeGstAmount = ($sizeMrp * $gstRate) / 100;
                            
                            // Calculate Total Price (MRP + GST)
                            $sizeTotalPrice = $sizeMrp + $sizeGstAmount;
                            
                            // Calculate Discount Amount
                            $sizeDiscountAmount = 0;
                            if ($sizeDiscountType === 'flat') {
                                $sizeDiscountAmount = $sizeDiscountValue;
                            } elseif ($sizeDiscountType === 'percentage') {
                                $sizeDiscountAmount = ($sizeMrp * $sizeDiscountValue) / 100;
                            }
                            
                            // Calculate Final Price
                            $sizeFinalPrice = $sizeTotalPrice - $sizeDiscountAmount;
                            if ($sizeFinalPrice < 0) {
                                $sizeFinalPrice = 0;
                            }

                            // Create variant with all fields
                            ProductVariant::create([
                                'product_id' => $product->id,
                                'size' => $sizeData['size'] ?? null,
                                'color' => $color,
                                'price' => $sizeMrp,
                                'cost_price' => $sizeCostPrice,
                                'mrp' => $sizeMrp,
                                'gst_percentage' => $gstRate,
                                'gst_amount' => $sizeGstAmount,
                                'total_price' => $sizeTotalPrice,
                                'final_price' => $sizeFinalPrice,
                                'discount_type' => $sizeDiscountType,
                                'discount_value' => $sizeDiscountValue,
                                'discount_amount' => $sizeDiscountAmount,
                                'stock' => intval($sizeData['stock'] ?? 0),
                            ]);
                        }
                    }
                }
            }

            // Save Normal Product Images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    if ($image && $image->isValid()) {
                        $path = $image->store('products', 'public');
                        ProductImage::create([
                            'product_id' => $product->id,
                            'variant_id' => null,
                            'image_path' => $path,
                            'is_main' => $index == 0 ? 1 : 0,
                            'display_order' => $index,
                        ]);
                    }
                }
            }

            // Save Variant Images
            if ($request->has('variants')) {
                foreach ($request->variants as $variantIndex => $variant) {
                    $color = $variant['color'] ?? null;
                    
                    // Find the saved variant by color
                    $savedVariant = ProductVariant::where('product_id', $product->id)
                        ->where('color', $color)
                        ->first();

                    if ($savedVariant && isset($variant['images'])) {
                        foreach ($variant['images'] as $index => $image) {
                            if ($image && $image->isValid()) {
                                $path = $image->store('products', 'public');
                                ProductImage::create([
                                    'product_id' => $product->id,
                                    'variant_id' => $savedVariant->id,
                                    'image_path' => $path,
                                    'is_main' => $index == 0 ? 1 : 0,
                                    'display_order' => $index,
                                ]);
                            }
                        }
                    }
                }
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'Product "' . $product->name . '" created successfully!');
                
        } catch (\Exception $e) {
            \Log::error('Product Store Error: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $product = Product::with('variants')->findOrFail($id);
        $productImages = ProductImage::where('product_id', $id)->orderBy('display_order')->get();
        $topCategories = TopCategory::where('is_active', 1)->get();
        $brands = Brand::where('is_active', 1)->get();
        $sizeCharts = SizeChart::all();
        $categories = Category::where('is_active', 1)->get();
        $subCategories = SubCategory::where('is_active', 1)->get();
        $productTypes = ProductType::where('is_active', 1)->get();
        
        return view('admin.products.edit', compact('product', 'productImages', 'topCategories', 'brands', 'sizeCharts', 'categories', 'subCategories', 'productTypes'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::with('variants')->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'variants' => 'nullable|array',
            'variants.*.size' => 'nullable|string',
            'variants.*.stock' => 'nullable|integer|min:0',
        ]);

        // Get GST from product
        $gstRate = $product->gst_percentage ?? 0;

        $product->update([
            'name' => $request->name,
            'top_category_id' => $request->top_category_id,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'product_type_id' => $request->product_type_id,
            'size_chart_id' => $request->size_chart_id,
            'price' => $request->price ?? 0,
            'final_price' => $request->final_price ?? 0,
            'mrp' => $request->mrp ?? 0,
            'stock' => $request->stock ?? 0,
            'description' => $request->description,
            'status' => $request->status ?? 'Active',
            'return_days' => $request->return_days ?? 7,
            'cod_available' => $request->has('cod_available') ? 1 : 0,
            'delivery_days' => $request->delivery_days ?? 3,
        ]);

        // UPDATE VARIANTS
        if ($request->has('deleted_variants')) {
            $deletedIds = json_decode($request->deleted_variants, true);
            if (is_array($deletedIds) && count($deletedIds) > 0) {
                ProductVariant::whereIn('id', $deletedIds)->delete();
            }
        }

        if ($request->has('variants') && is_array($request->variants)) {
            foreach ($request->variants as $variantData) {
                $color = $variantData['color'] ?? null;
                
                if (isset($variantData['sizes']) && is_array($variantData['sizes'])) {
                    foreach ($variantData['sizes'] as $sizeData) {
                        // Calculate values for this size
                        $sizeMrp = floatval($sizeData['mrp'] ?? 0);
                        $sizeCostPrice = floatval($sizeData['cost_price'] ?? 0);
                        $sizeDiscountType = $sizeData['discount_type'] ?? 'flat';
                        $sizeDiscountValue = floatval($sizeData['discount_value'] ?? 0);
                        
                        $sizeGstAmount = ($sizeMrp * $gstRate) / 100;
                        $sizeTotalPrice = $sizeMrp + $sizeGstAmount;
                        
                        $sizeDiscountAmount = 0;
                        if ($sizeDiscountType === 'flat') {
                            $sizeDiscountAmount = $sizeDiscountValue;
                        } elseif ($sizeDiscountType === 'percentage') {
                            $sizeDiscountAmount = ($sizeMrp * $sizeDiscountValue) / 100;
                        }
                        
                        $sizeFinalPrice = $sizeTotalPrice - $sizeDiscountAmount;
                        if ($sizeFinalPrice < 0) {
                            $sizeFinalPrice = 0;
                        }
                        
                        // Check if variant exists (update) or create new
                        if (isset($sizeData['id']) && !empty($sizeData['id'])) {
                            $variant = ProductVariant::find($sizeData['id']);
                            if ($variant) {
                                $variant->update([
                                    'size' => $sizeData['size'] ?? null,
                                    'color' => $color,
                                    'price' => $sizeMrp,
                                    'cost_price' => $sizeCostPrice,
                                    'mrp' => $sizeMrp,
                                    'gst_percentage' => $gstRate,
                                    'gst_amount' => $sizeGstAmount,
                                    'total_price' => $sizeTotalPrice,
                                    'final_price' => $sizeFinalPrice,
                                    'discount_type' => $sizeDiscountType,
                                    'discount_value' => $sizeDiscountValue,
                                    'discount_amount' => $sizeDiscountAmount,
                                    'stock' => intval($sizeData['stock'] ?? 0),
                                ]);
                            }
                        } else {
                            // Create new variant
                            ProductVariant::create([
                                'product_id' => $product->id,
                                'size' => $sizeData['size'] ?? null,
                                'color' => $color,
                                'price' => $sizeMrp,
                                'cost_price' => $sizeCostPrice,
                                'mrp' => $sizeMrp,
                                'gst_percentage' => $gstRate,
                                'gst_amount' => $sizeGstAmount,
                                'total_price' => $sizeTotalPrice,
                                'final_price' => $sizeFinalPrice,
                                'discount_type' => $sizeDiscountType,
                                'discount_value' => $sizeDiscountValue,
                                'discount_amount' => $sizeDiscountAmount,
                                'stock' => intval($sizeData['stock'] ?? 0),
                            ]);
                        }
                    }
                }
            }
        }

        // Handle images
        if ($request->has('deleted_images')) {
            $deletedIds = json_decode($request->deleted_images, true);
            if (is_array($deletedIds) && count($deletedIds) > 0) {
                $imagesToDelete = ProductImage::whereIn('id', $deletedIds)->get();
                foreach ($imagesToDelete as $img) {
                    if (Storage::disk('public')->exists($img->image_path)) {
                        Storage::disk('public')->delete($img->image_path);
                    }
                    $img->delete();
                }
            }
        }

        $existingCount = ProductImage::where('product_id', $product->id)->count();
        
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $index => $image) {
                if ($existingCount + $index >= 4) break;
                if ($image && $image->isValid()) {
                    $path = $image->store('products', 'public');
                    $isMain = ($existingCount == 0 && $index == 0 && $product->image == null);
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_main' => $isMain ? 1 : 0,
                        'display_order' => $existingCount + $index
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        ProductVariant::where('product_id', $id)->delete();
        
        $images = ProductImage::where('product_id', $id)->get();
        foreach ($images as $img) {
            if (Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
            $img->delete();
        }
        
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    // AJAX Methods
    public function getCategories($topId)
    {
        $categories = Category::where('top_category_id', $topId)
            ->where('is_active', 1)
            ->select('id', 'name')
            ->get();
        return response()->json($categories);
    }
    
    public function getSubCategories($categoryId)
    {
        $subCategories = SubCategory::where('category_id', $categoryId)
            ->where('is_active', 1)
            ->select('id', 'name')
            ->get();
        return response()->json($subCategories);
    }

    public function getProductTypes($subCategoryId)
    {
        $productTypes = ProductType::where('sub_category_id', $subCategoryId)
            ->where('is_active', 1)
            ->select('id', 'name')
            ->get();
        return response()->json($productTypes);
    }

    public function updateStock(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $product->stock = $request->stock;
        $product->save();
        
        return response()->json(['success' => true]);
    }
    
    public function getProductDetails($id)
    {
        try {
            $product = Product::with(['category', 'subCategory', 'brand', 'variants', 'productImages'])
                ->findOrFail($id);
            
            $totalStock = $product->stock;
            if ($product->variants) {
                $totalStock += $product->variants->sum('stock');
            }
            
            $mainImage = null;
            if ($product->productImages && $product->productImages->count() > 0) {
                $mainImageObj = $product->productImages->where('is_main', 1)->first();
                if (!$mainImageObj) {
                    $mainImageObj = $product->productImages->first();
                }
                $mainImage = $mainImageObj ? $mainImageObj->image_path : null;
            }
            if (!$mainImage) {
                $mainImage = $product->image;
            }
            
            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => $mainImage,
                    'price' => $product->price,
                    'mrp' => $product->mrp,
                    'final_price' => $product->final_price,
                    'discount_type' => $product->discount_type,
                    'discount_value' => $product->discount_value,
                    'discount_amount' => $product->discount_amount,
                    'gst_percentage' => $product->gst_percentage,
                    'gst_amount' => $product->gst_amount,
                    'total_price' => $product->total_price,
                    'stock' => $product->stock,
                    'total_stock' => $totalStock,
                    'status' => $product->status,
                    'cod_available' => $product->cod_available,
                    'return_days' => $product->return_days,
                    'delivery_days' => $product->delivery_days,
                    'description' => $product->description,
                    'top_category_id' => $product->top_category_id,
                    'category_id' => $product->category_id,
                    'sub_category_id' => $product->sub_category_id,
                    'product_type_id' => $product->product_type_id,
                    'category_name' => $product->category ? $product->category->name : null,
                    'sub_category_name' => $product->subCategory ? $product->subCategory->name : null,
                    'brand_name' => $product->brand ? $product->brand->name : null,
                ],
                'variants' => $product->variants ? $product->variants->map(function($variant) {
                    return [
                        'id' => $variant->id,
                        'size' => $variant->size,
                        'color' => $variant->color,
                        'stock' => $variant->stock,
                        'price' => $variant->price,
                        'cost_price' => $variant->cost_price,
                        'mrp' => $variant->mrp,
                        'gst_percentage' => $variant->gst_percentage,
                        'gst_amount' => $variant->gst_amount,
                        'total_price' => $variant->total_price,
                        'final_price' => $variant->final_price,
                        'discount_type' => $variant->discount_type,
                        'discount_value' => $variant->discount_value,
                        'discount_amount' => $variant->discount_amount,
                    ];
                }) : [],
                'images' => $product->productImages ? $product->productImages->map(function($image) {
                    return [
                        'id' => $image->id,
                        'image_path' => $image->image_path,
                        'is_main' => $image->is_main,
                    ];
                }) : [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
    
    public function getGstRate($categoryId)
    {
        $category = \App\Models\Category::find($categoryId);

        if (!$category) {
            return response()->json([
                'gst_rate' => 0
            ]);
        }

        return response()->json([
            'gst_rate' => $category->gst_percentage ?? 0
        ]);
    }
}