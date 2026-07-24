<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipOrder;

class PaymentController extends Controller
{
    public function index()
    {
        $orders = MembershipOrder::orderBy('id', 'desc')->paginate(15);
        return view('admin.payment', compact('orders'));
    }
}