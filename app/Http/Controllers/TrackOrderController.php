<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackOrderController extends Controller
{
    public function index(Request $request)
    {
        $order = null;
        
        if ($request->order_number) {
            $order = Order::with('items')->where('order_number', $request->order_number)->first();
        }
        
        return view('track-order', compact('order'));
    }
}