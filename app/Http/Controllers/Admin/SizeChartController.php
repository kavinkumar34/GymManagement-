<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SizeChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SizeChartController extends Controller
{
    public function index()
    {
        $sizeCharts = SizeChart::orderBy('id', 'desc')->paginate(12);
        return view('admin.sizecharts.index', compact('sizeCharts'));
    }

    public function create()
    {
        return view('admin.sizecharts.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'gender' => 'required|in:men,women,kids,unisex',
            'category_type' => 'required|in:topwear,bottomwear,footwear',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sizecharts', 'public');
        }

        $sizes = [];
        if ($request->has('sizes')) {
            foreach ($request->sizes as $size) {
                if (!empty($size['size'])) {
                    $sizes[] = $size;
                }
            }
        }

        SizeChart::create([
            'title' => $request->title,
            'gender' => $request->gender,
            'category_type' => $request->category_type,
            'image' => $imagePath,
            'default_unit' => $request->default_unit ?? 'in',
            'sizes' => json_encode($sizes),
        ]);

        return redirect()->route('admin.sizecharts.index')->with('success', 'Size chart created successfully!');
    }

    public function edit($id)
    {
        $sizeChart = SizeChart::findOrFail($id);
        return view('admin.sizecharts.form', compact('sizeChart'));
    }

    public function update(Request $request, $id)
    {
        $sizeChart = SizeChart::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'gender' => 'required|in:men,women,kids,unisex',
            'category_type' => 'required|in:topwear,bottomwear,footwear',
        ]);

        if ($request->hasFile('image')) {
            if ($sizeChart->image && Storage::disk('public')->exists($sizeChart->image)) {
                Storage::disk('public')->delete($sizeChart->image);
            }
            $imagePath = $request->file('image')->store('sizecharts', 'public');
            $sizeChart->image = $imagePath;
        }

        $sizes = [];
        if ($request->has('sizes')) {
            foreach ($request->sizes as $size) {
                if (!empty($size['size'])) {
                    $sizes[] = $size;
                }
            }
        }

        $sizeChart->update([
            'title' => $request->title,
            'gender' => $request->gender,
            'category_type' => $request->category_type,
            'default_unit' => $request->default_unit ?? 'in',
            'sizes' => json_encode($sizes),
        ]);

        return redirect()->route('admin.sizecharts.index')->with('success', 'Size chart updated successfully!');
    }

    public function destroy($id)
    {
        $sizeChart = SizeChart::findOrFail($id);
        
        if ($sizeChart->image && Storage::disk('public')->exists($sizeChart->image)) {
            Storage::disk('public')->delete($sizeChart->image);
        }
        
        $sizeChart->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('admin.sizecharts.index')->with('success', 'Size chart deleted!');
    }
}