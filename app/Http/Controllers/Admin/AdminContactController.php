<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('id', 'desc')->paginate(15);
        return view('admin.contacts.index', compact('contacts'));
    }
    
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        if ($contact->status == 'Pending') {
            $contact->update(['status' => 'Read']);
        }
        return view('admin.contacts.show', compact('contact'));
    }
    
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        
        return redirect()->route('admin.contacts')->with('success', 'Message deleted successfully!');
    }
    
    public function updateStatus(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', 'Status updated successfully!');
    }
}