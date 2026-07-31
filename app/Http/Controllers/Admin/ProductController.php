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
            $topCategory = TopCategory::find($request->top_category_id);
            $gstRate = $topCategory->gst_rate ?? 0;
            
            $sellingPrice = $request->mrp ?? 0;
            $costPrice = $request->price ?? 0;
            
            $gstAmount = ($sellingPrice * $gstRate) / 100;
            $totalPrice = $sellingPrice + $gstAmount;
            
            $discountType = $request->discount_type ?? 'flat';
            $discountValue = $request->discount_value ?? 0;
            $discountAmount = 0;
            
            if ($discountType === 'flat') {
                $discountAmount = $discountValue;
            } elseif ($discountType === 'percentage') {
                $discountAmount = ($sellingPrice * $discountValue) / 100;
            }
            
            $finalPrice = $totalPrice - $discountAmount;
            if ($finalPrice < 0) {
                $finalPrice = 0;
            }

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
                foreach ($request->variants as $variantKey => $variant) {
                    $color = $variant['color'] ?? null;
                    
                    if (isset($variant['sizes']) && is_array($variant['sizes'])) {
                        foreach ($variant['sizes'] as $sizeData) {
                            if (empty($sizeData['size']) && empty($sizeData['stock'])) {
                                continue;
                            }

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

                            $savedVariant = ProductVariant::create([
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
                            
                            // Save variant images
                            if (isset($variant['images']) && is_array($variant['images'])) {
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
                }
            }

            // Save Normal Product Images - limit to 4
            if ($request->hasFile('images')) {
                $imageCount = 0;
                foreach ($request->file('images') as $index => $image) {
                    if ($imageCount >= 4) break;
                    if ($image && $image->isValid()) {
                        $path = $image->store('products', 'public');
                        ProductImage::create([
                            'product_id' => $product->id,
                            'variant_id' => null,
                            'image_path' => $path,
                            'is_main' => $index == 0 ? 1 : 0,
                            'display_order' => $index,
                        ]);
                        $imageCount++;
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
        $product = Product::with([
            'variants',
            'variants.variantImages',
            'productImages'
        ])->findOrFail($id);
        
        $productImages = ProductImage::where('product_id', $id)
            ->whereNull('variant_id')
            ->orderBy('display_order')
            ->get();
            
        $topCategories = TopCategory::where('is_active', 1)->get();
        $brands = Brand::where('is_active', 1)->get();
        $sizeCharts = SizeChart::all();
        $categories = Category::where('is_active', 1)->get();
        $subCategories = SubCategory::where('is_active', 1)->get();
        $productTypes = ProductType::where('is_active', 1)->get();
        
        return view('admin.products.edit', compact(
            'product', 
            'productImages', 
            'topCategories', 
            'brands', 
            'sizeCharts', 
            'categories', 
            'subCategories', 
            'productTypes'
        ));
    }

    public function update(Request $request, $id)
    {
        $product = Product::with('variants')->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'variants' => 'nullable|array',
            'new_images' => 'nullable|array|max:4',
            'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $gstRate = $product->gst_percentage ?? 0;
        if ($request->has('top_category_id') && $request->top_category_id != $product->top_category_id) {
            $topCategory = TopCategory::find($request->top_category_id);
            $gstRate = $topCategory->gst_rate ?? 0;
        }

        // Update product basic info
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
            'gst_percentage' => $gstRate,
            'stock' => $request->stock ?? 0,
            'description' => $request->description,
            'status' => $request->status ?? 'Active',
            'return_days' => $request->return_days ?? 7,
            'cod_available' => $request->has('cod_available') ? 1 : 0,
            'delivery_days' => $request->delivery_days ?? 3,
        ]);

        // ===================== HANDLE VARIANTS =====================
        
        // 1. Get existing variant IDs from request
        $existingVariantIds = [];
        $variantKeys = [];
        
        if ($request->has('variants') && is_array($request->variants)) {
            foreach ($request->variants as $variantKey => $variantData) {
                $variantKeys[] = $variantKey;
                if (isset($variantData['sizes']) && is_array($variantData['sizes'])) {
                    foreach ($variantData['sizes'] as $sizeData) {
                        if (isset($sizeData['id']) && !empty($sizeData['id'])) {
                            $existingVariantIds[] = $sizeData['id'];
                        }
                    }
                }
            }
        }

        // 2. Delete variants that are not in the request
        if (!empty($existingVariantIds)) {
            $variantsToDelete = ProductVariant::where('product_id', $product->id)
                ->whereNotIn('id', $existingVariantIds)
                ->get();
        } else {
            // If no variants in request, delete all
            $variantsToDelete = ProductVariant::where('product_id', $product->id)->get();
        }

        foreach ($variantsToDelete as $variant) {
            // Delete variant images
            $images = ProductImage::where('variant_id', $variant->id)->get();
            foreach ($images as $img) {
                if (Storage::disk('public')->exists($img->image_path)) {
                    Storage::disk('public')->delete($img->image_path);
                }
                $img->delete();
            }
            $variant->delete();
        }

        // 3. Handle deleted variants from hidden field
        if ($request->has('deleted_variants')) {
            $deletedIds = json_decode($request->deleted_variants, true);
            if (is_array($deletedIds) && count($deletedIds) > 0) {
                $variantsToDelete = ProductVariant::whereIn('id', $deletedIds)->get();
                foreach ($variantsToDelete as $variant) {
                    $images = ProductImage::where('variant_id', $variant->id)->get();
                    foreach ($images as $img) {
                        if (Storage::disk('public')->exists($img->image_path)) {
                            Storage::disk('public')->delete($img->image_path);
                        }
                        $img->delete();
                    }
                    $variant->delete();
                }
            }
        }

        // 4. Handle deleted variant images
        if ($request->has('deleted_variant_images')) {
            $deletedImageIds = json_decode($request->deleted_variant_images, true);
            if (is_array($deletedImageIds) && count($deletedImageIds) > 0) {
                $imagesToDelete = ProductImage::whereIn('id', $deletedImageIds)->get();
                foreach ($imagesToDelete as $img) {
                    if (Storage::disk('public')->exists($img->image_path)) {
                        Storage::disk('public')->delete($img->image_path);
                    }
                    $img->delete();
                }
            }
        }

        // 5. Update or create variants
        if ($request->has('variants') && is_array($request->variants)) {
            foreach ($request->variants as $variantKey => $variantData) {
                $color = $variantData['color'] ?? null;
                
                if (isset($variantData['sizes']) && is_array($variantData['sizes'])) {
                    foreach ($variantData['sizes'] as $sizeData) {
                        // Skip empty sizes
                        if (empty($sizeData['size']) && empty($sizeData['stock'])) {
                            continue;
                        }

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
                        
                        // Check if this is an existing variant
                        if (isset($sizeData['id']) && !empty($sizeData['id'])) {
                            // Update existing variant
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
                            $newVariant = ProductVariant::create([
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
                            
                            // Save new variant images if any
                            if (isset($variantData['images']) && is_array($variantData['images'])) {
                                foreach ($variantData['images'] as $index => $image) {
                                    if ($image && $image->isValid()) {
                                        $path = $image->store('products', 'public');
                                        ProductImage::create([
                                            'product_id' => $product->id,
                                            'variant_id' => $newVariant->id,
                                            'image_path' => $path,
                                            'is_main' => $index == 0 ? 1 : 0,
                                            'display_order' => $index,
                                        ]);
                                    }
                }
            }
                        }
                    }
                }
            }
        }

        // ===================== HANDLE PRODUCT IMAGES =====================
        
        // Delete product images
        if ($request->has('deleted_images')) {
            $deletedIds = json_decode($request->deleted_images, true);
            if (is_array($deletedIds) && count($deletedIds) > 0) {
                $imagesToDelete = ProductImage::whereIn('id', $deletedIds)->whereNull('variant_id')->get();
                foreach ($imagesToDelete as $img) {
                    if (Storage::disk('public')->exists($img->image_path)) {
                        Storage::disk('public')->delete($img->image_path);
                    }
                    $img->delete();
                }
            }
        }

        // Add new product images - limit to 4 total
        $existingCount = ProductImage::where('product_id', $product->id)->whereNull('variant_id')->count();
        
        if ($request->hasFile('new_images')) {
            $imageCount = 0;
            foreach ($request->file('new_images') as $index => $image) {
                if (($existingCount + $imageCount) >= 4) break;
                if ($image && $image->isValid()) {
                    $path = $image->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'variant_id' => null,
                        'image_path' => $path,
                        'is_main' => ($existingCount == 0 && $imageCount == 0) ? 1 : 0,
                        'display_order' => $existingCount + $imageCount
                    ]);
                    $imageCount++;
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        $variants = ProductVariant::where('product_id', $id)->get();
        foreach ($variants as $variant) {
            $images = ProductImage::where('variant_id', $variant->id)->get();
            foreach ($images as $img) {
                if (Storage::disk('public')->exists($img->image_path)) {
                    Storage::disk('public')->delete($img->image_path);
                }
                $img->delete();
            }
        }
        ProductVariant::where('product_id', $id)->delete();
        
        $images = ProductImage::where('product_id', $id)->whereNull('variant_id')->get();
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
    
    public function getProductTypesByCategory($categoryId)
    {
        $productTypes = ProductType::where('category_id', $categoryId)
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
            $product = Product::with([
                'category', 
                'subCategory', 
                'brand', 
                'variants',
                'variants.variantImages',
                'productImages'
            ])->findOrFail($id);
            
            $totalStock = $product->stock;
            if ($product->variants) {
                foreach ($product->variants as $variant) {
                    $totalStock += $variant->stock ?? 0;
                }
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
                        'variant_images' => $variant->variantImages ? $variant->variantImages->map(function($img) {
                            return [
                                'id' => $img->id,
                                'image_path' => $img->image_path,
                            ];
                        }) : [],
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
        $category = TopCategory::find($categoryId);

        if (!$category) {
            return response()->json([
                'success' => false,
                'gst_rate' => 0
            ]);
        }

        return response()->json([
            'success' => true,
            'gst_rate' => $category->gst_rate ?? 0
        ]);
    }
}