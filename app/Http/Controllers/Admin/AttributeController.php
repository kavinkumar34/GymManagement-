<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::with('values')->orderBy('id', 'desc')->paginate(20);
        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.attributes.create');
    }

    public function store(Request $request)
    {
        // Debug - See what data is coming
        // dd($request->all());
        
        $request->validate([
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255|unique:attributes,name',
            'type' => 'required|in:text,select,radio,checkbox,color,size,weight',
        ]);

        try {
            // Create attribute with slug
            $attribute = Attribute::create([
                'name' => $request->name,
                'label' => $request->label,
                'slug' => Str::slug($request->name),  // Generate slug from name
                'type' => $request->type,
                'placeholder' => $request->placeholder,
                'required' => $request->has('required') ? 1 : 0,
                'status' => 'Active'
            ]);

            // Save values if type is select/radio/checkbox and values exist
            if ($request->has('values') && is_array($request->values)) {
                foreach ($request->values as $index => $value) {
                    if (!empty($value)) {
                        AttributeValue::create([
                            'attribute_id' => $attribute->id,
                            'value' => $value,
                            'additional_price' => $request->additional_prices[$index] ?? 0,
                            'display_order' => $index
                        ]);
                    }
                }
            }

            return redirect()->route('admin.attributes.index')
                ->with('success', 'Attribute "' . $attribute->label . '" created successfully!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $attribute = Attribute::with('values')->findOrFail($id);
        return view('admin.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);
        
        $request->validate([
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255|unique:attributes,name,' . $id,
            'type' => 'required|in:text,select,radio,checkbox,color,size,weight',
        ]);

        try {
            $attribute->update([
                'name' => $request->name,
                'label' => $request->label,
                'slug' => Str::slug($request->name),
                'type' => $request->type,
                'placeholder' => $request->placeholder,
                'required' => $request->has('required') ? 1 : 0,
            ]);

            // Update values - delete old and create new
            if ($request->has('values') && is_array($request->values)) {
                // Delete old values
                AttributeValue::where('attribute_id', $attribute->id)->delete();
                
                foreach ($request->values as $index => $value) {
                    if (!empty($value)) {
                        AttributeValue::create([
                            'attribute_id' => $attribute->id,
                            'value' => $value,
                            'additional_price' => $request->additional_prices[$index] ?? 0,
                            'display_order' => $index
                        ]);
                    }
                }
            }

            return redirect()->route('admin.attributes.index')
                ->with('success', 'Attribute updated successfully!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute deleted successfully!');
    }

    // AJAX methods for dynamic attributes
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
}