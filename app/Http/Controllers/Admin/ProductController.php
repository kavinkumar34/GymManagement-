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
use App\Models\Attribute;
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
        // Ensure stock is not negative
        $stock = max(0, $request->stock);
        
        // Validate
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
            // Handle images - First image becomes main image
            $mainImagePath = null;
            
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $index => $image) {
                    if ($image && $image->isValid()) {
                        $path = $image->store('products', 'public');
                        if ($index == 0) {
                            $mainImagePath = $path;
                        }
                    }
                }
            }

            // If no images found, return error
            if (!$mainImagePath) {
                return back()->with('error', 'Please upload at least one valid image.')->withInput();
            }

            // Generate SKU
            $sku = 'GYM-' . strtoupper(Str::random(8));

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
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'mrp' => $request->mrp,
                'stock' => $stock,
                'image' => $mainImagePath,
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

            // Save variants (for clothing products)
            if ($request->has('variants') && is_array($request->variants)) {
                foreach ($request->variants as $variantData) {
                    if (!empty($variantData['color']) || !empty($variantData['size'])) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'color' => $variantData['color'] ?? 'Default',
                            'images' => null,
                        ]);
                    }
                }
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'Product "' . $product->name . '" created successfully!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $topCategories = TopCategory::where('is_active', 1)->get();
        $brands = Brand::where('is_active', 1)->get();
        $sizeCharts = SizeChart::all();
        $categories = Category::where('is_active', 1)->get();
        $subCategories = SubCategory::where('is_active', 1)->get();
        $productTypes = ProductType::where('is_active', 1)->get();
        
        return view('admin.products.edit', compact('product', 'topCategories', 'brands', 'sizeCharts', 'categories', 'subCategories', 'productTypes'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

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

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
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