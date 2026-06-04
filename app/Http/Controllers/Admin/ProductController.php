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
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
        // Debug - Uncomment to see what files are coming
        // dd($request->all(), $request->file('images'));
        
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
        ]);

        try {
            // Generate SKU
            $sku = 'GYM-' . strtoupper(Str::random(8));

            // Create product first
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
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'mrp' => $request->mrp,
                'stock' => $request->stock,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'is_featured' => $request->has('is_featured') ? 1 : 0,
                'is_best_seller' => $request->has('is_best_seller') ? 1 : 0,
                'is_new_arrival' => $request->has('is_new_arrival') ? 1 : 0,
                'is_trending' => $request->has('is_trending') ? 1 : 0,
                'status' => $request->status ?? 'Draft',
                'return_days' => $request->return_days ?? 30,
                'warranty_months' => $request->warranty_months ?? 0,
                'gst_percentage' => $request->gst_percentage ?? 0,
                'min_stock_alert' => $request->min_stock_alert ?? 5,
                'weight' => $request->weight,
                'weight_unit' => $request->weight_unit ?? 'kg',
                'dimensions' => $request->dimensions,
            ]);

            // ========== SAVE MULTIPLE IMAGES ==========
            $mainImagePath = null;
            $imageCount = 0;
            
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                
                foreach ($images as $index => $image) {
                    if ($image && $image->isValid()) {
                        // Generate unique filename
                        $filename = time() . '_' . $index . '_' . $image->getClientOriginalName();
                        $path = $image->storeAs('products', $filename, 'public');
                        
                        // First image is main
                        $isMain = ($index == 0) ? 1 : 0;
                        if ($isMain) {
                            $mainImagePath = $path;
                        }
                        
                        // Save to product_images table
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

            // Update product with main image
            if ($mainImagePath) {
                $product->image = $mainImagePath;
                $product->save();
            }

            if ($imageCount == 0) {
                return back()->with('error', 'Please upload at least one image.')->withInput();
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'Product "' . $product->name . '" created successfully with ' . $imageCount . ' images!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
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
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update([
            'name' => $request->name,
            'top_category_id' => $request->top_category_id,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'product_type_id' => $request->product_type_id,
            'size_chart_id' => $request->size_chart_id,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'mrp' => $request->mrp,
            'stock' => $request->stock,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'is_best_seller' => $request->has('is_best_seller') ? 1 : 0,
            'is_new_arrival' => $request->has('is_new_arrival') ? 1 : 0,
            'is_trending' => $request->has('is_trending') ? 1 : 0,
            'status' => $request->status,
        ]);

        // Delete removed images
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

        // Add new images
        $existingCount = ProductImage::where('product_id', $product->id)->count();
        
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $index => $image) {
                if ($existingCount + $index >= 4) {
                    break;
                }
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
        
        // Delete all product images
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

    // ============ AJAX METHODS ============
    
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
}