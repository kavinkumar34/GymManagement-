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
        $sizeCharts = SizeChart::orderBy('id', 'desc')->paginate(15);
        return view('admin.sizecharts.index', compact('sizeCharts'));
    }

    public function create()
    {
        return view('admin.sizecharts.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'gender' => 'nullable|string|in:men,women,kids,unisex',
            'category_type' => 'required|string|in:topwear,bottomwear,footwear',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'default_unit' => 'nullable|string|in:in,cm',
            'sizes' => 'nullable|array',
            'sizes.*.size' => 'required|string',
        ]);

        try {
            $data = [
                'title' => $request->title,
                'gender' => $request->gender ?? 'unisex',
                'category_type' => $request->category_type,
                'default_unit' => $request->default_unit ?? 'in',
            ];

            // Process sizes based on category type
            $sizes = [];
            if ($request->has('sizes')) {
                foreach ($request->sizes as $size) {
                    if (!empty($size['size'])) {
                        $sizeData = ['size' => $size['size']];
                        
                        // Add fields based on category type
                        if ($request->category_type == 'topwear') {
                            $sizeData['chest'] = $size['chest'] ?? null;
                            $sizeData['waist'] = $size['waist'] ?? null;
                            $sizeData['length'] = $size['length'] ?? null;
                            $sizeData['sleeve'] = $size['sleeve'] ?? null;
                        } elseif ($request->category_type == 'bottomwear') {
                            $sizeData['waist'] = $size['waist'] ?? null;
                            $sizeData['length'] = $size['length'] ?? null;
                            $sizeData['inseam'] = $size['inseam'] ?? null;
                        } elseif ($request->category_type == 'footwear') {
                            $sizeData['length'] = $size['length'] ?? null;
                            $sizeData['width'] = $size['width'] ?? null;
                            $sizeData['heel'] = $size['heel'] ?? null;
                        }
                        
                        $sizes[] = $sizeData;
                    }
                }
            }
            
            $data['sizes'] = json_encode($sizes);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . str_replace(' ', '_', $request->title) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('size-charts', $filename, 'public');
                $data['image'] = $path;
            }

            $sizeChart = SizeChart::create($data);

            return redirect()->route('admin.sizecharts.index')
                ->with('success', 'Size Chart "' . $request->title . '" created successfully with ' . count($sizes) . ' sizes!');

        } catch (\Exception $e) {
            \Log::error('Size Chart Store Error: ' . $e->getMessage());
            return back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $sizeChart = SizeChart::findOrFail($id);
        return view('admin.sizecharts.form', compact('sizeChart'));
    }

    public function update(Request $request, $id)
    {
        $sizeChart = SizeChart::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'gender' => 'nullable|string|in:men,women,kids,unisex',
            'category_type' => 'required|string|in:topwear,bottomwear,footwear',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'default_unit' => 'nullable|string|in:in,cm',
            'sizes' => 'nullable|array',
            'sizes.*.size' => 'required|string',
        ]);

        try {
            $data = [
                'title' => $request->title,
                'gender' => $request->gender ?? 'unisex',
                'category_type' => $request->category_type,
                'default_unit' => $request->default_unit ?? 'in',
            ];

            // Process sizes based on category type
            $sizes = [];
            if ($request->has('sizes')) {
                foreach ($request->sizes as $size) {
                    if (!empty($size['size'])) {
                        $sizeData = ['size' => $size['size']];
                        
                        if ($request->category_type == 'topwear') {
                            $sizeData['chest'] = $size['chest'] ?? null;
                            $sizeData['waist'] = $size['waist'] ?? null;
                            $sizeData['length'] = $size['length'] ?? null;
                            $sizeData['sleeve'] = $size['sleeve'] ?? null;
                        } elseif ($request->category_type == 'bottomwear') {
                            $sizeData['waist'] = $size['waist'] ?? null;
                            $sizeData['length'] = $size['length'] ?? null;
                            $sizeData['inseam'] = $size['inseam'] ?? null;
                        } elseif ($request->category_type == 'footwear') {
                            $sizeData['length'] = $size['length'] ?? null;
                            $sizeData['width'] = $size['width'] ?? null;
                            $sizeData['heel'] = $size['heel'] ?? null;
                        }
                        
                        $sizes[] = $sizeData;
                    }
                }
            }
            
            $data['sizes'] = json_encode($sizes);

            if ($request->hasFile('image')) {
                if ($sizeChart->image && Storage::disk('public')->exists($sizeChart->image)) {
                    Storage::disk('public')->delete($sizeChart->image);
                }
                $image = $request->file('image');
                $filename = time() . '_' . str_replace(' ', '_', $request->title) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('size-charts', $filename, 'public');
                $data['image'] = $path;
            }

            $sizeChart->update($data);

            return redirect()->route('admin.sizecharts.index')
                ->with('success', 'Size Chart "' . $request->title . '" updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Size Chart Update Error: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $sizeChart = SizeChart::findOrFail($id);
            
            if ($sizeChart->image && Storage::disk('public')->exists($sizeChart->image)) {
                Storage::disk('public')->delete($sizeChart->image);
            }
            
            $sizeChart->delete();

            return redirect()->route('admin.sizecharts.index')
                ->with('success', 'Size Chart deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Get size chart details for AJAX view modal
     */
   /**
 * Get size chart details for AJAX view modal
 */
public function getDetails($id)
{
    try {
        $sizeChart = SizeChart::findOrFail($id);
        
        $sizes = [];
        if ($sizeChart->sizes) {
            if (is_array($sizeChart->sizes)) {
                $sizes = $sizeChart->sizes;
            } else {
                $sizes = json_decode($sizeChart->sizes, true) ?: [];
            }
        }
        
        return response()->json([
            'success' => true,
            'sizeChart' => [
                'id' => $sizeChart->id,
                'title' => $sizeChart->title,
                'gender' => $sizeChart->gender,
                'category_type' => $sizeChart->category_type,
                'image' => $sizeChart->image,
                'default_unit' => $sizeChart->default_unit ?? 'in',
                'sizes' => $sizes,
                'created_at' => $sizeChart->created_at,
                'updated_at' => $sizeChart->updated_at,
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 404);
    }
}w
}