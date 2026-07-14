<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::with('category')
            ->orderBy('id', 'desc')
            ->paginate(15);
        
        return view('admin.producttypes.index', compact('productTypes'));
    }

    public function create()
    {
        $categories = Category::where('is_active', 1)->orderBy('name')->get();
        return view('admin.producttypes.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_types,name',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'nullable|boolean'
        ]);

        try {
            $data = [
                'name' => $request->name,
                'category_id' => $request->category_id,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . $request->name . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('product-types', $filename, 'public');
                $data['image'] = $path;
            }

            // Remove any slug generation here
            $productType = ProductType::create($data);

            return redirect()->route('admin.producttypes.index')
                ->with('success', 'Product Type "' . $request->name . '" created successfully!');

        } catch (\Exception $e) {
            \Log::error('Product Type Store Error: ' . $e->getMessage());
            return back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $productType = ProductType::findOrFail($id);
        $categories = Category::where('is_active', 1)->orderBy('name')->get();
        
        return view('admin.producttypes.form', compact('productType', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $productType = ProductType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_types,name,' . $id,
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'nullable|boolean'
        ]);

        try {
            $data = [
                'name' => $request->name,
                'category_id' => $request->category_id,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ];

            if ($request->hasFile('image')) {
                if ($productType->image && Storage::disk('public')->exists($productType->image)) {
                    Storage::disk('public')->delete($productType->image);
                }

                $image = $request->file('image');
                $filename = time() . '_' . $request->name . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('product-types', $filename, 'public');
                $data['image'] = $path;
            }

            // Remove any slug update here
            $productType->update($data);

            return redirect()->route('admin.producttypes.index')
                ->with('success', 'Product Type "' . $request->name . '" updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Product Type Update Error: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $productType = ProductType::findOrFail($id);
            
            if ($productType->image && Storage::disk('public')->exists($productType->image)) {
                Storage::disk('public')->delete($productType->image);
            }
            
            $productType->delete();

            return redirect()->route('admin.producttypes.index')
                ->with('success', 'Product Type deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function getByCategory($categoryId)
    {
        $productTypes = ProductType::where('category_id', $categoryId)
            ->where('is_active', 1)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        
        return response()->json($productTypes);
    }
}