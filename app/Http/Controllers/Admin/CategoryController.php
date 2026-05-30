<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('id', 'desc')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }
    
    public function create()
    {
        return view('admin.categories.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'icon' => 'nullable|string|max:50',
            'status' => 'required|in:Active,Inactive'
        ]);
        
        Category::create([
            'name' => $request->name,
            'icon' => $request->icon ?: 'fas fa-tag',
            'status' => $request->status
        ]);
        
        return redirect()->route('admin.categories')->with('success', 'Category added successfully!');
    }
    
    public function quickStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'icon' => 'nullable|string|max:50',
            'status' => 'required|in:Active,Inactive'
        ]);
        
        $category = Category::create([
            'name' => $request->name,
            'icon' => $request->icon ?: 'fas fa-tag',
            'status' => $request->status
        ]);
        
        return response()->json([
            'success' => true,
            'category' => $category,
            'message' => 'Category added successfully'
        ]);
    }
    
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }
    
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $id,
            'icon' => 'nullable|string|max:50',
            'status' => 'required|in:Active,Inactive'
        ]);
        
        $category->update([
            'name' => $request->name,
            'icon' => $request->icon ?: 'fas fa-tag',
            'status' => $request->status
        ]);
        
        return redirect()->route('admin.categories')->with('success', 'Category updated successfully!');
    }
    
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete category with products. Delete products first.');
        }
        
        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully!');
    }
    
// Show all products in a category
public function showProducts($id)
{
    $category = Category::findOrFail($id);
    $products = Product::where('category_id', $id)
        ->orderBy('id', 'desc')
        ->paginate(20);
    return view('admin.categories.category-products', compact('category', 'products'));
}
}