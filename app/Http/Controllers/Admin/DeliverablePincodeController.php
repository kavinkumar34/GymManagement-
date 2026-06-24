<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliverablePincode;
use Illuminate\Http\Request;

class DeliverablePincodeController extends Controller
{
    public function index()
    {
        // Order by ID DESCENDING - Newest first (last added shows at top)
        $pincodes = DeliverablePincode::orderBy('id', 'desc')->get();
        return view('admin.pincodes.index', compact('pincodes'));
    }
    
    public function create()
    {
        return view('admin.pincodes.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'state' => 'required|string|max:100|unique:deliverable_pincodes,state',
            'shipping_charge' => 'required|numeric|min:0|max:1000',
            'is_active' => 'boolean'
        ]);
        
        DeliverablePincode::create($request->all());
        
        return redirect()->route('admin.pincodes.index')
            ->with('success', 'State added successfully!');
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
            'state' => 'required|string|max:100|unique:deliverable_pincodes,state,' . $id,
            'shipping_charge' => 'required|numeric|min:0|max:1000',
            'is_active' => 'boolean'
        ]);
        
        $pincode->update($request->all());
        
        return redirect()->route('admin.pincodes.index')
            ->with('success', 'State updated successfully!');
    }
    
    public function destroy($id)
    {
        $pincode = DeliverablePincode::findOrFail($id);
        $pincode->delete();
        
        return redirect()->route('admin.pincodes.index')
            ->with('success', 'State deleted successfully!');
    }
    
    public function bulkImport(Request $request)
    {
        $request->validate([
            'states' => 'required|string'
        ]);
        
        $lines = explode("\n", $request->states);
        $added = 0;
        $skipped = 0;
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            $parts = explode('|', $line);
            $state = trim($parts[0]);
            $shippingCharge = isset($parts[1]) ? floatval(trim($parts[1])) : 0;
            
            if (!empty($state)) {
                if (!DeliverablePincode::where('state', $state)->exists()) {
                    DeliverablePincode::create([
                        'state' => $state,
                        'shipping_charge' => $shippingCharge,
                        'is_active' => 1
                    ]);
                    $added++;
                } else {
                    $skipped++;
                }
            }
        }
        
        return redirect()->route('admin.pincodes.index')
            ->with('success', "$added states added, $skipped skipped (already exist)");
    }

    public function bulkUpdateShipping(Request $request)
    {
        $request->validate([
            'state_ids' => 'required|array',
            'state_ids.*' => 'exists:deliverable_pincodes,id',
            'shipping_charge' => 'required|numeric|min:0|max:1000'
        ]);
        
        $updated = DeliverablePincode::whereIn('id', $request->state_ids)
            ->update(['shipping_charge' => $request->shipping_charge]);
        
        return response()->json([
            'success' => true,
            'message' => "$updated states updated successfully"
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'state_ids' => 'required|array',
            'state_ids.*' => 'exists:deliverable_pincodes,id'
        ]);
        
        $deleted = DeliverablePincode::whereIn('id', $request->state_ids)->delete();
        
        return response()->json([
            'success' => true,
            'message' => "$deleted states deleted successfully"
        ]);
    }

    public function toggleStatus($id, Request $request)
    {
        $pincode = DeliverablePincode::findOrFail($id);
        $pincode->is_active = $request->is_active;
        $pincode->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'is_active' => $pincode->is_active
        ]);
    }

    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'state_ids' => 'required|array',
            'state_ids.*' => 'exists:deliverable_pincodes,id',
            'is_active' => 'required|boolean'
        ]);
        
        $updated = DeliverablePincode::whereIn('id', $request->state_ids)
            ->update(['is_active' => $request->is_active]);
        
        return response()->json([
            'success' => true,
            'message' => "$updated states updated successfully"
        ]);
    }
}