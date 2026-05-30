<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainerController extends Controller
{
    public function create()
    {
        return view('admin.trainer-register');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:trainers,email',
            'address' => 'nullable|string',
            'experience' => 'nullable|integer',
            'specialization' => 'required',
            'salary' => 'nullable|numeric',
            'join_date' => 'required|date',
            'shift_timing' => 'required',
            'status' => 'required'
        ]);
        
        // Generate Trainer ID
        $lastTrainer = Trainer::orderBy('id', 'desc')->first();
        $trainerId = 'TR' . str_pad(($lastTrainer ? $lastTrainer->id + 1 : 1), 3, '0', STR_PAD_LEFT);
        
        // Calculate age from DOB
        $age = null;
        if ($request->dob) {
            $age = \Carbon\Carbon::parse($request->dob)->age;
        }
        
        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('trainer-photos', 'public');
        }
        
        $trainer = Trainer::create([
            'trainer_id' => $trainerId,
            'name' => $request->name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'age' => $age,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'experience' => $request->experience,
            'specialization' => $request->specialization,
            'salary' => $request->salary,
            'join_date' => $request->join_date,
            'shift_timing' => $request->shift_timing,
            'certification' => $request->certification,
            'photo' => $photoPath,
            'status' => $request->status
        ]);
        
        return redirect()->route('admin.trainers')->with('success', 'Trainer registered successfully! Trainer ID: ' . $trainerId);
    }
    
    public function index()
    {
        $trainers = Trainer::withCount('members')->orderBy('id', 'desc')->paginate(15);
        return view('admin.trainers-list', compact('trainers'));
    }
    
    public function edit($id)
    {
        $trainer = Trainer::findOrFail($id);
        return view('admin.trainer-edit', compact('trainer'));
    }
    
    public function update(Request $request, $id)
    {
        $trainer = Trainer::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:trainers,email,' . $id,
            'specialization' => 'required',
            'shift_timing' => 'required',
            'status' => 'required'
        ]);
        
        $trainer->update([
            'name' => $request->name,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'experience' => $request->experience,
            'specialization' => $request->specialization,
            'salary' => $request->salary,
            'shift_timing' => $request->shift_timing,
            'certification' => $request->certification,
            'status' => $request->status
        ]);
        
        return redirect()->route('admin.trainers')->with('success', 'Trainer updated successfully!');
    }
    
    public function destroy($id)
    {
        $trainer = Trainer::findOrFail($id);
        if ($trainer->photo) {
            Storage::disk('public')->delete($trainer->photo);
        }
        $trainer->delete();
        
        return redirect()->route('admin.trainers')->with('success', 'Trainer deleted successfully!');
    }
    public function show($id)
{
    $trainer = Trainer::withCount('members')->findOrFail($id);
    return view('admin.trainer-show', compact('trainer'));
}
}