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
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'top_category_id' => 'required|exists:top_categories,id',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images' => 'required|array|min:1|max:4',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'variants' => 'nullable|array',
            'variants.*.size' => 'nullable|string',
            'variants.*.stock' => 'nullable|integer|min:0',
        ]);

        try {
            $sku = 'GYM-' . strtoupper(Str::random(8));

            // Calculate GST amount
            $gstPercentage = $request->gst_percentage ?? 18;
            $price = $request->price ?? 0;
            $gstAmount = ($price * $gstPercentage) / 100;
            $totalPrice = $price + $gstAmount;
            $profit = ($request->mrp ?? 0) - $price;

            // Collect attributes
            $attributesData = $this->collectAttributes($request);
            $attributesJson = !empty($attributesData) ? json_encode($attributesData, JSON_UNESCAPED_SLASHES) : null;

            // Create product
            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . time(),
                'sku' => $sku,
                'top_category_id' => $request->top_category_id,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'product_type_id' => $request->product_type_id,
                'size_chart_id' => $request->size_chart_id,
                
                'price' => $price,
                'discount_price' => $request->discount_price,
                'mrp' => $request->mrp,
                'gst_percentage' => $gstPercentage,
                'gst_amount' => $gstAmount,
                'total_price' => $totalPrice,
                'profit' => $profit,
                
                'stock' => $request->stock,
                'min_stock_alert' => $request->min_stock_alert ?? 5,
                'weight' => $request->weight,
                'weight_unit' => $request->weight_unit ?? 'kg',
                'dimensions' => $request->dimensions,
                
                'video_url' => $request->video_url,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'description_title' => $request->description_title,
                'description_details' => $request->description_details,
                
                'attributes' => $attributesJson,
                'rating' => $request->rating ?? 0,
                'discount_type' => $request->discount_type ?? 'flat',
                'discount_value' => $request->discount_value ?? 0,
                
                'status' => $request->status ?? 'Draft',
                'return_days' => $request->return_days ?? 30,
                'warranty_months' => $request->warranty_months ?? 0,
                'shipping_info' => $request->shipping_info,
                'return_policy' => $request->return_policy,
                'created_by' => auth()->id(),
            ]);

            // ⭐ SAVE VARIANTS
            if ($request->has('variants') && is_array($request->variants)) {
                foreach ($request->variants as $variantData) {
                    if (!empty($variantData['size']) || !empty($variantData['color'])) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'size' => $variantData['size'] ?? null,
                            'color' => $variantData['color'] ?? null,
                            'value' => $variantData['value'] ?? null,
                            'price' => !empty($variantData['price']) ? $variantData['price'] : null,
                            'stock' => $variantData['stock'] ?? 0,
                        ]);
                    }
                }
            }

            // Save images
            $mainImagePath = null;
            $imageCount = 0;
            
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                
                foreach ($images as $index => $image) {
                    if ($image && $image->isValid()) {
                        $filename = time() . '_' . $index . '_' . $image->getClientOriginalName();
                        $path = $image->storeAs('products', $filename, 'public');
                        
                        $isMain = ($index == 0) ? 1 : 0;
                        if ($isMain) {
                            $mainImagePath = $path;
                        }
                        
                        $productImage = new ProductImage();
                        $productImage->product_id = $product->id;
                        $productImage->image_path = $path;
                        $productImage->is_main = $isMain;
                        $productImage->display_order = $index;
                        $productImage->save();
                        
                        $imageCount++;
                    }
                }
            }

            if ($mainImagePath) {
                $product->image = $mainImagePath;
                $product->save();
            }

            if ($imageCount == 0) {
                return back()->with('error', 'Please upload at least one image.')->withInput();
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'Product "' . $product->name . '" created successfully with ' . count($product->variants) . ' variants!');
                
        } catch (\Exception $e) {
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
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'variants' => 'nullable|array',
            'variants.*.size' => 'nullable|string',
            'variants.*.stock' => 'nullable|integer|min:0',
        ]);

        // Calculate GST amount
        $gstPercentage = $request->gst_percentage ?? 18;
        $price = $request->price ?? 0;
        $gstAmount = ($price * $gstPercentage) / 100;
        $totalPrice = $price + $gstAmount;
        $profit = ($request->mrp ?? 0) - $price;

        // Collect attributes
        $attributesData = $this->collectAttributes($request);
        $attributesJson = !empty($attributesData) ? json_encode($attributesData, JSON_UNESCAPED_SLASHES) : null;

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'top_category_id' => $request->top_category_id,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'product_type_id' => $request->product_type_id,
            'size_chart_id' => $request->size_chart_id,
            
            'price' => $price,
            'discount_price' => $request->discount_price,
            'mrp' => $request->mrp,
            'gst_percentage' => $gstPercentage,
            'gst_amount' => $gstAmount,
            'total_price' => $totalPrice,
            'profit' => $profit,
            
            'stock' => $request->stock,
            'min_stock_alert' => $request->min_stock_alert ?? 5,
            'weight' => $request->weight,
            'weight_unit' => $request->weight_unit ?? 'kg',
            'dimensions' => $request->dimensions,
            
            'video_url' => $request->video_url,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'description_title' => $request->description_title,
            'description_details' => $request->description_details,
            
            'attributes' => $attributesJson,
            'rating' => $request->rating ?? 0,
            'discount_type' => $request->discount_type ?? 'flat',
            'discount_value' => $request->discount_value ?? 0,
            
            'status' => $request->status ?? 'Draft',
            'return_days' => $request->return_days ?? 30,
            'warranty_months' => $request->warranty_months ?? 0,
            'shipping_info' => $request->shipping_info,
            'return_policy' => $request->return_policy,
        ]);

        // ⭐ UPDATE VARIANTS
        // Delete removed variants
        if ($request->has('deleted_variants')) {
            $deletedIds = json_decode($request->deleted_variants, true);
            if (is_array($deletedIds) && count($deletedIds) > 0) {
                ProductVariant::whereIn('id', $deletedIds)->delete();
            }
        }

        // Update or create variants
        if ($request->has('variants') && is_array($request->variants)) {
            foreach ($request->variants as $index => $variantData) {
                if (isset($variantData['id']) && !empty($variantData['id'])) {
                    // Update existing variant
                    $variant = ProductVariant::find($variantData['id']);
                    if ($variant) {
                        $variant->update([
                            'size' => $variantData['size'] ?? null,
                            'color' => $variantData['color'] ?? null,
                            'value' => $variantData['value'] ?? null,
                            'price' => !empty($variantData['price']) ? $variantData['price'] : null,
                            'stock' => $variantData['stock'] ?? 0,
                        ]);
                    }
                } elseif (!empty($variantData['size']) || !empty($variantData['color'])) {
                    // Create new variant
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size' => $variantData['size'] ?? null,
                        'color' => $variantData['color'] ?? null,
                        'value' => $variantData['value'] ?? null,
                        'price' => !empty($variantData['price']) ? $variantData['price'] : null,
                        'stock' => $variantData['stock'] ?? 0,
                    ]);
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
        
        // Delete variants
        ProductVariant::where('product_id', $id)->delete();
        
        // Delete images
        $images = ProductImage::where('product_id', $id)->get();
        foreach ($images as $img) {
            if (Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
            $img->delete();
        }
        
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    private function collectAttributes(Request $request)
    {
        $attributes = [];

        // CLOTHING ATTRIBUTES
        if ($request->has('attributes.clothing')) {
            $clothing = [];
            $fields = ['size', 'color', 'material', 'sleeve', 'fit', 'pattern', 'neck', 'gender', 'fabric_weight', 'care_instructions', 'clothing_type', 'waist_size', 'inseam_length'];
            foreach ($fields as $field) {
                $value = $request->input("attributes.clothing.{$field}");
                if ($value !== null && $value !== '' && $value !== '0') {
                    $clothing[$field] = $value;
                }
            }
            if (!empty($clothing)) {
                $attributes['clothing'] = $clothing;
            }
        }

        // FOOTWEAR ATTRIBUTES
        if ($request->has('attributes.footwear')) {
            $footwear = [];
            $fields = ['shoe_size', 'color', 'material', 'sole_type', 'cushioning', 'arch_support', 'closure_type', 'activity_type', 'weight'];
            foreach ($fields as $field) {
                $value = $request->input("attributes.footwear.{$field}");
                if ($value !== null && $value !== '' && $value !== '0') {
                    $footwear[$field] = $value;
                }
            }
            if (!empty($footwear)) {
                $attributes['footwear'] = $footwear;
            }
        }

        // GYM EQUIPMENT ATTRIBUTES
        if ($request->has('attributes.equipment')) {
            $equipment = [];
            $fields = ['equipment_type', 'weight_capacity', 'material', 'dimensions', 'product_weight', 'assembly', 'warranty', 'usage_type', 'color', 'resistance_level'];
            foreach ($fields as $field) {
                $value = $request->input("attributes.equipment.{$field}");
                if ($value !== null && $value !== '' && $value !== '0') {
                    $equipment[$field] = $value;
                }
            }
            if (!empty($equipment)) {
                $attributes['equipment'] = $equipment;
            }
        }

        // MASSAGERS ATTRIBUTES
        if ($request->has('attributes.massager')) {
            $massager = [];
            $fields = ['massager_type', 'power_source', 'battery_life', 'massage_modes', 'speed_settings', 'attachments', 'waterproof', 'heat_function', 'color', 'warranty'];
            foreach ($fields as $field) {
                $value = $request->input("attributes.massager.{$field}");
                if ($value !== null && $value !== '' && $value !== '0') {
                    $massager[$field] = $value;
                }
            }
            if (!empty($massager)) {
                $attributes['massager'] = $massager;
            }
        }

        // ACCESSORIES ATTRIBUTES
        if ($request->has('attributes.accessory')) {
            $accessory = [];
            $fields = ['accessory_type', 'material', 'color', 'size', 'weight', 'features', 'gender', 'warranty'];
            foreach ($fields as $field) {
                $value = $request->input("attributes.accessory.{$field}");
                if ($value !== null && $value !== '' && $value !== '0') {
                    $accessory[$field] = $value;
                }
            }
            if (!empty($accessory)) {
                $attributes['accessory'] = $accessory;
            }
        }

        // SUPPLEMENTS ATTRIBUTES
        if ($request->has('attributes.supplements')) {
            $supplements = [];
            $fields = ['supplement_type', 'weight', 'flavor', 'serving_size', 'servings_count', 'protein_per_serving', 'calories_per_serving', 'carbs_per_serving', 'fat_per_serving', 'dietary', 'expiry', 'usage_instructions', 'ingredients', 'caution'];
            foreach ($fields as $field) {
                $value = $request->input("attributes.supplements.{$field}");
                if ($value !== null && $value !== '' && $value !== '0') {
                    $supplements[$field] = $value;
                }
            }
            if (!empty($supplements)) {
                $attributes['supplements'] = $supplements;
            }
        }

        return $attributes;
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
         /**
     * Get GST rate for a top category (AJAX)
     */
    public function getGstRate($topCategoryId)
    {
        try {
            $topCategory = TopCategory::find($topCategoryId);
            if ($topCategory) {
                return response()->json([
                    'success' => true,
                    'gst_rate' => (float)($topCategory->gst_rate ?? 0)
                ]);
            }
            return response()->json([
                'success' => false,
                'gst_rate' => 0,
                'message' => 'Category not found'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'gst_rate' => 0,
                'message' => $e->getMessage()
            ]);
        }
    }
}