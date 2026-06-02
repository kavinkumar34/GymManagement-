<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category')->orderBy('id', 'desc')->paginate(15);
        return view('admin.subcategories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('admin.subcategories.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('subcategories', 'public');
        }

        SubCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'image' => $imagePath,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.subcategories.index')->with('success', 'Sub category created successfully!');
    }

    public function edit($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $categories = Category::where('is_active', 1)->get();
        return view('admin.subcategories.form', compact('subCategory', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            if ($subCategory->image && Storage::disk('public')->exists($subCategory->image)) {
                Storage::disk('public')->delete($subCategory->image);
            }
            $imagePath = $request->file('image')->store('subcategories', 'public');
            $subCategory->image = $imagePath;
        }

        $subCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.subcategories.index')->with('success', 'Sub category updated successfully!');
    }

    public function destroy($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        
        if ($subCategory->image && Storage::disk('public')->exists($subCategory->image)) {
            Storage::disk('public')->delete($subCategory->image);
        }
        
        $subCategory->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('admin.subcategories.index')->with('success', 'Sub category deleted!');
    }

    // ========== IMPORTANT: This method MUST exist ==========
    public function getByCategory($categoryId)
    {
        try {
            $subCategories = SubCategory::where('category_id', $categoryId)
                ->where('is_active', 1)
                ->select('id', 'name')
                ->get();
            
            return response()->json($subCategories);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}