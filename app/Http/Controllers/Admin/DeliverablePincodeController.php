<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliverablePincode;
use Illuminate\Http\Request;

class DeliverablePincodeController extends Controller
{
    public function index()
    {
        $pincodes = DeliverablePincode::orderBy('pincode')->paginate(20);
        return view('admin.pincodes.index', compact('pincodes'));
    }
    
    public function create()
    {
        return view('admin.pincodes.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'pincode' => 'required|string|size:6|unique:deliverable_pincodes,pincode',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'delivery_days' => 'required|integer|min:1|max:15',
            'is_active' => 'boolean'
        ]);
        
        DeliverablePincode::create($request->all());
        
        return redirect()->route('admin.pincodes.index')
            ->with('success', 'Pincode added successfully!');
    }
    
    public function edit($id)
    {
        $pincode = DeliverablePincode::findOrFail($id);
        return view('admin.pincodes.edit', compact('pincode'));
    }
    
    public function update(Request $request, $id)
    {
        $pincode = DeliverablePincode::findOrFail($id);
        
        $request->validate([
            'pincode' => 'required|string|size:6|unique:deliverable_pincodes,pincode,' . $id,
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'delivery_days' => 'required|integer|min:1|max:15',
            'is_active' => 'boolean'
        ]);
        
        $pincode->update($request->all());
        
        return redirect()->route('admin.pincodes.index')
            ->with('success', 'Pincode updated successfully!');
    }
    
    public function destroy($id)
    {
        $pincode = DeliverablePincode::findOrFail($id);
        $pincode->delete();
        
        return redirect()->route('admin.pincodes.index')
            ->with('success', 'Pincode deleted successfully!');
    }
    
    public function bulkImport(Request $request)
    {
        $request->validate([
            'pincodes' => 'required|string'
        ]);
        
        $pincodes = explode("\n", $request->pincodes);
        $added = 0;
        $skipped = 0;
        
        foreach ($pincodes as $pincode) {
            $pincode = trim($pincode);
            if (strlen($pincode) === 6 && is_numeric($pincode)) {
                if (!DeliverablePincode::where('pincode', $pincode)->exists()) {
                    DeliverablePincode::create([
                        'pincode' => $pincode,
                        'delivery_days' => 3,
                        'is_active' => 1
                    ]);
                    $added++;
                } else {
                    $skipped++;
                }
            }
        }
        
        return redirect()->route('admin.pincodes.index')
            ->with('success', "$added pincodes added, $skipped skipped (already exist)");
    }
}