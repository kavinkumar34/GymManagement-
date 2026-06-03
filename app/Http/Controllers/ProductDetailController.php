<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductDetailController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['category', 'subCategory'])->findOrFail($id);
        
        // Get related products from same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();
        
        return view('product-detail', compact('product', 'relatedProducts'));
    }
}