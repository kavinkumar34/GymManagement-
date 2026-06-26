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
        $products = Product::with('category', 'productImages')
            ->where('status', 'Active')
            ->orderBy('id', 'desc')
            ->get();
        
        return response()->json($products->map(function($product) {
            return $this->formatProduct($product);
        }));
    }
    
    public function getBestSellers()
    {
        $products = Product::with('category', 'productImages')
            ->where('status', 'Active')
            ->where('is_best_seller', 1)
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();
        
        return response()->json($products->map(function($product) {
            $formatted = $this->formatProduct($product);
            $formatted['sold_count'] = $product->sold_count;
            return $formatted;
        }));
    }
    
    public function searchProducts(Request $request)
    {
        $query = $request->get('q');
        $products = Product::with('category', 'productImages')
            ->where('status', 'Active')
            ->where('name', 'like', "%{$query}%")
            ->limit(20)
            ->get();
        
        return response()->json($products->map(function($product) {
            return $this->formatProduct($product);
        }));
    }
    
    public function getProductsByCategory($id)
    {
        $products = Product::with('category', 'productImages')
            ->where('status', 'Active')
            ->where('category_id', $id)
            ->get();
        
        return response()->json($products->map(function($product) {
            return $this->formatProduct($product);
        }));
    }
    
    public function getProductsBySubCategory($id)
    {
        $products = Product::with('category', 'productImages')
            ->where('status', 'Active') 
            ->where('sub_category_id', $id)
            ->get();
        
        return response()->json($products->map(function($product) {
            return $this->formatProduct($product);
        }));
    }   
    
    public function getProductStocks()
    {
        $products = Product::select('id', 'stock')->get();
        return response()->json($products);
    }
    
    // Get single product stock with rating
    public function getProductStock($id)
    {
        $product = Product::select('id', 'stock', 'image', 'rating', 'rating_count')->find($id);
        if ($product) {
            return response()->json([
                'stock' => $product->stock,
                'image' => $product->image,
                'rating' => $product->rating ?? 0,
                'rating_count' => $product->rating_count ?? 0
            ]);
        }
        return response()->json(['stock' => 0, 'image' => null, 'rating' => 0, 'rating_count' => 0]);
    }
    
    // Helper method to format product with all images - INCLUDES RATING
    private function formatProduct($product)
    {
        $allImages = [];
        
        // Add main product image
        if ($product->image) {
            $allImages[] = $product->image;
        }
        
        // Add gallery images from product_images table
        if ($product->productImages && $product->productImages->count() > 0) {
            foreach ($product->productImages as $image) {
                if ($image->image_path && !in_array($image->image_path, $allImages)) {
                    $allImages[] = $image->image_path;
                }
            }
        }
        
        // If no images at all, add placeholder
        if (empty($allImages)) {
            $allImages[] = 'https://via.placeholder.com/300x300?text=No+Image';
        }
        
        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'discount_price' => $product->discount_price,
            'stock' => $product->stock ?? 0,
            'image' => $product->image,
            'all_images' => $allImages,
            'category' => $product->category,
            'brand' => $product->brand,
            'gender' => $product->gender ?? null,
            'size' => $product->size ?? null,
            'color' => $product->color ?? null,
            'status' => $product->status,
            // ===== RATING FIELDS ADDED =====
            'rating' => $product->rating ?? 0,
            'rating_count' => $product->rating_count ?? 0,
        ];
    }
}