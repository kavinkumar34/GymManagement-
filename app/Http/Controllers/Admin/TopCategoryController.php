<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TopCategoryController extends Controller
{
    public function index()
    {
        $topCategories = TopCategory::orderBy('id', 'desc')->paginate(15);
        return view('admin.topcategories.index', compact('topCategories'));
    }

    public function create()
    {
        return view('admin.topcategories.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:top_categories,name',
            'gst_rate' => 'required|numeric|min:0|max:100',
        ]);

        TopCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'gst_rate' => $request->gst_rate,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.topcategories.index')->with('success', 'Top category created successfully!');
    }

    public function edit($id)
    {
        $topCategory = TopCategory::findOrFail($id);
        return view('admin.topcategories.form', compact('topCategory'));
    }

    public function update(Request $request, $id)
    {
        $topCategory = TopCategory::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:top_categories,name,' . $id,
            'gst_rate' => 'required|numeric|min:0|max:100',
        ]);

        $topCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'gst_rate' => $request->gst_rate,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.topcategories.index')->with('success', 'Top category updated successfully!');
    }

    public function destroy($id)
    {
        $topCategory = TopCategory::findOrFail($id);
        $topCategory->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('admin.topcategories.index')->with('success', 'Top category deleted!');
    }
}