<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function getCategories()
    {
        $categories = Category::where('status', 'Active')->get();
        return response()->json($categories);
    }
    
    public function getProducts()
    {
        $products = Product::with('category')
            ->where('status', 'Active')
            ->orderBy('id', 'desc')
            ->limit(12)
            ->get();
        return response()->json($products);
    }
    
    public function getBestSellers()
    {
        $products = Product::where('status', 'Active')
            ->where('is_best_seller', 1)
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();
        return response()->json($products);
    }
    
    public function searchProducts(Request $request)
    {
        $query = $request->get('q');
        $products = Product::with('category')
            ->where('status', 'Active')
            ->where('name', 'like', "%{$query}%")
            ->limit(20)
            ->get();
        return response()->json($products);
    }
    
    public function getProductsByCategory($id)
    {
        $products = Product::with('category')
            ->where('status', 'Active')
            ->where('category_id', $id)
            ->get();
        return response()->json($products);
    }
    public function getProductStocks()
{
    $products = \App\Models\Product::select('id', 'stock')->get();
    return response()->json($products);
}
    
}