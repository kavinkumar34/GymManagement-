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
use App\Models\VariantSize;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'subCategory', 'topCategory'])
            ->orderBy('id', 'desc')
            ->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        // Get all data for dropdowns
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
        // Log incoming request
        \Log::info('Product Store Request', $request->all());
        
        // Validation - only required fields
        $request->validate([
            'name' => 'required|string|max:255',
            'top_category_id' => 'required|exists:top_categories,id',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        
        try {
            // Handle main image
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
                \Log::info('Image uploaded: ' . $imagePath);
            }

            // Generate SKU
            $sku = 'GYM-' . strtoupper(Str::random(8));
            
            // Create product - using only columns that exist in your table
            $product = new Product();
            $product->name = $request->name;
            $product->slug = Str::slug($request->name) . '-' . time();
            $product->sku = $sku;
            $product->top_category_id = $request->top_category_id;
            $product->brand_id = $request->brand_id ?? null;
            $product->category_id = $request->category_id;
            $product->sub_category_id = $request->sub_category_id;
            $product->product_type_id = $request->product_type_id ?? null;
            $product->size_chart_id = $request->size_chart_id ?? null;
            $product->price = $request->price;
            $product->discount_price = $request->discount_price ?? null;
            $product->mrp = $request->mrp ?? null;
            $product->stock = $request->stock;
            $product->image = $imagePath;
            $product->description_title = $request->description_title ?? null;
            $product->description_details = $request->description_details ?? null;
            $product->short_description = $request->short_description ?? null;
            $product->description = $request->description ?? null;
            $product->is_featured = $request->has('is_featured') ? 1 : 0;
            $product->is_best_seller = $request->has('is_best_seller') ? 1 : 0;
            $product->is_new_arrival = $request->has('is_new_arrival') ? 1 : 0;
            $product->is_trending = $request->has('is_trending') ? 1 : 0;
            $product->status = $request->status ?? 'Draft';
            $product->return_days = $request->return_days ?? 30;
            $product->warranty_months = $request->warranty_months ?? 0;
            $product->gst_percentage = $request->gst_percentage ?? 0;
            $product->min_stock_alert = $request->min_stock_alert ?? 5;
            $product->weight = $request->weight ?? null;
            $product->weight_unit = $request->weight_unit ?? 'kg';
            $product->dimensions = $request->dimensions ?? null;
            
            $product->save();
            
            \Log::info('Product saved with ID: ' . $product->id);
            
            // Save gallery images if any
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $galleryPath = $image->store('product_gallery', 'public');
                    \Log::info('Gallery image saved: ' . $galleryPath);
                    // You can create a ProductImage model here if needed
                }
            }

            DB::commit();
            
            return redirect()->route('admin.products.index')
                ->with('success', 'Product "' . $product->name . '" created successfully!');
                
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Product Save Error: ' . $e->getMessage());
            \Log::error('Error Line: ' . $e->getLine());
            \Log::error('Error File: ' . $e->getFile());
            
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
            'description_title' => $request->description_title,
            'description_details' => $request->description_details,
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
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
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

    public function getCategoryAttributes($categoryId)
    {
        $attributes = Attribute::whereHas('categories', function($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        })->with('values')->get();
        
        return response()->json($attributes);
    }

    public function getSubCategoryAttributes($subCategoryId)
    {
        $attributes = Attribute::whereHas('subCategories', function($q) use ($subCategoryId) {
            $q->where('sub_category_id', $subCategoryId);
        })->with('values')->get();
        
        return response()->json($attributes);
    }

    public function updateStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'stock' => 'required|integer|min:0'
        ]);
        
        $product = Product::findOrFail($request->product_id);
        $product->stock = $request->stock;
        $product->save();
        
        return response()->json(['success' => true]);
    }
}