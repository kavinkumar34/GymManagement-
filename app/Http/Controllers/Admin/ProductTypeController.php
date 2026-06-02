<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::with('subCategory.category')->orderBy('id', 'desc')->paginate(15);
        return view('admin.producttypes.index', compact('productTypes'));
    }

    public function create()
    {
        $subCategories = SubCategory::with('category')->where('is_active', 1)->get();
        return view('admin.producttypes.form', compact('subCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sub_category_id' => 'required|exists:sub_categories,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('producttypes', 'public');
        }

        ProductType::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sub_category_id' => $request->sub_category_id,
            'image' => $imagePath,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.producttypes.index')->with('success', 'Product type created successfully!');
    }

    public function edit($id)
    {
        $productType = ProductType::findOrFail($id);
        $subCategories = SubCategory::with('category')->where('is_active', 1)->get();
        return view('admin.producttypes.form', compact('productType', 'subCategories'));
    }

    public function update(Request $request, $id)
    {
        $productType = ProductType::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'sub_category_id' => 'required|exists:sub_categories,id',
        ]);

        if ($request->hasFile('image')) {
            if ($productType->image && Storage::disk('public')->exists($productType->image)) {
                Storage::disk('public')->delete($productType->image);
            }
            $imagePath = $request->file('image')->store('producttypes', 'public');
            $productType->image = $imagePath;
        }

        $productType->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sub_category_id' => $request->sub_category_id,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.producttypes.index')->with('success', 'Product type updated successfully!');
    }

    public function destroy($id)
    {
        $productType = ProductType::findOrFail($id);
        
        if ($productType->image && Storage::disk('public')->exists($productType->image)) {
            Storage::disk('public')->delete($productType->image);
        }
        
        $productType->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('admin.producttypes.index')->with('success', 'Product type deleted!');
    }

    // ========== IMPORTANT: This method MUST exist ==========
    public function getBySubCategory($subCategoryId)
    {
        try {
            $productTypes = ProductType::where('sub_category_id', $subCategoryId)
                ->where('is_active', 1)
                ->select('id', 'name')
                ->get();
            
            return response()->json($productTypes);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}