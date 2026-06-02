<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TopCategory;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('topCategory')->orderBy('id', 'desc')->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $topCategories = TopCategory::where('is_active', 1)->get();
        $attributes = Attribute::where('status', 'Active')->get();
        return view('admin.categories.create', compact('topCategories', 'attributes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'top_category_id' => 'required|exists:top_categories,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'top_category_id' => $request->top_category_id,
            'image' => $imagePath,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $topCategories = TopCategory::where('is_active', 1)->get();
        $attributes = Attribute::where('status', 'Active')->get();
        return view('admin.categories.edit', compact('category', 'topCategories', 'attributes'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'top_category_id' => 'required|exists:top_categories,id',
        ]);

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'top_category_id' => $request->top_category_id,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }
        
        $category->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }

    // ========== IMPORTANT: This method MUST exist ==========
    public function getByTopCategory($topId)
    {
        try {
            $categories = Category::where('top_category_id', $topId)
                ->where('is_active', 1)
                ->select('id', 'name')
                ->get();
            
            // Return as JSON
            return response()->json($categories);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function quickStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);
        
        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'top_category_id' => $request->top_category_id ?? 1,
            'is_active' => 1,
        ]);
        
        return response()->json([
            'success' => true,
            'category' => $category,
            'message' => 'Category added!'
        ]);
    }

    public function showProducts($id)
    {
        $category = Category::with('products')->findOrFail($id);
        $products = $category->products()->paginate(20);
        return view('admin.categories.products', compact('category', 'products'));
    }
}