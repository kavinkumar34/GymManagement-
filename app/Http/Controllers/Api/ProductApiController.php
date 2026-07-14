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
        $categories = Category::where('is_active', 1)
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($categories);
    }
    
    public function getProducts()
    {
        $products = Product::with([
            'category', 
            'productImages', 
            'variants'
        ])
        ->where('status', 'Active')
        ->whereHas('category', function ($query) {
            $query->where('is_active', 1);
        })
        ->orderBy('id', 'desc')
        ->get();
        
        return response()->json($products->map(function($product) {
            return $this->formatProduct($product);
        }));
    }
    
    public function getBestSellers()
    {
        $products = Product::with([
            'category', 
            'productImages', 
            'variants'
        ])
        ->where('status', 'Active')
        ->where('is_best_seller', 1)
        ->whereHas('category', function ($query) {
            $query->where('is_active', 1);
        })
        ->orderBy('id', 'desc')
        ->limit(3)
        ->get();
        
        return response()->json($products->map(function($product) {
            $formatted = $this->formatProduct($product);
            $formatted['sold_count'] = $product->sold_count ?? 100;
            return $formatted;
        }));
    }
    
    public function searchProducts(Request $request)
    {
        $query = $request->get('q', '');
        $products = Product::with([
            'category', 
            'productImages', 
            'variants'
        ])
        ->where('status', 'Active')
        ->whereHas('category', function ($query) {
            $query->where('is_active', 1);
        })
        ->where('name', 'like', "%{$query}%")
        ->limit(20)
        ->get();
        
        return response()->json($products->map(function($product) {
            return $this->formatProduct($product);
        }));
    }
    
    public function getProductsByCategory($id)
    {
        $products = Product::with([
            'category', 
            'productImages', 
            'variants'
        ])
        ->where('status', 'Active')
        ->whereHas('category', function ($query) {
            $query->where('is_active', 1);
        })
        ->where('category_id', $id)
        ->get();
        
        return response()->json($products->map(function($product) {
            return $this->formatProduct($product);
        }));
    }
    
    public function getProductsBySubCategory($id)
    {
        $products = Product::with([
            'category', 
            'productImages', 
            'variants'
        ])
        ->where('status', 'Active')
        ->whereHas('category', function ($query) {
            $query->where('is_active', 1);
        })
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
        $product = Product::with(['variants', 'productImages'])
            ->select('id', 'stock', 'image', 'rating', 'rating_count', 'total_price', 'final_price', 'discount_type', 'discount_value', 'mrp', 'price')
            ->find($id);
            
        if ($product) {
            // Get all images including variant images
            $allImages = [];
            
            // Add main product image
            if ($product->image) {
                $allImages[] = $product->image;
            }
            
            // Add gallery images
            if ($product->productImages && $product->productImages->count() > 0) {
                foreach ($product->productImages as $image) {
                    if ($image->image_path && !in_array($image->image_path, $allImages)) {
                        $allImages[] = $image->image_path;
                    }
                }
            }
            
            // Get variant images
            if ($product->variants && $product->variants->count() > 0) {
                foreach ($product->variants as $variant) {
                    if ($variant->image && !in_array($variant->image, $allImages)) {
                        $allImages[] = $variant->image;
                    }
                }
            }
            
            return response()->json([
                'stock' => $product->stock,
                'image' => $product->image,
                'all_images' => $allImages,
                'rating' => $product->rating ?? 0,
                'rating_count' => $product->rating_count ?? 0,
                'total_price' => $product->total_price,
                'final_price' => $product->final_price,
                'mrp' => $product->mrp,
                'price' => $product->price,
                'discount_type' => $product->discount_type,
                'discount_value' => $product->discount_value,
                'variants' => $product->variants,
            ]);
        }
        return response()->json(['stock' => 0, 'image' => null, 'rating' => 0, 'rating_count' => 0]);
    }
    
    // Helper method to format product with all images
    private function formatProduct($product)
    {
        $allImages = [];
        $variantImages = [];
        
        // 1. GET VARIANT IMAGES FIRST (for variant products)
        if ($product->variants && $product->variants->count() > 0) {
            // Get the first variant's images from product_images table
            $firstVariant = $product->variants->first();
            
            if ($product->productImages && $product->productImages->count() > 0) {
                // Filter images for this variant
                $variantImageObjs = $product->productImages->filter(function($img) use ($firstVariant) {
                    return $img->variant_id == $firstVariant->id;
                });
                
                if ($variantImageObjs->count() > 0) {
                    $sortedImages = $variantImageObjs->sort(function($a, $b) {
                        if ($a->is_main !== $b->is_main) return $b->is_main - $a->is_main;
                        return ($a->display_order ?? 0) - ($b->display_order ?? 0);
                    });
                    
                    foreach ($sortedImages as $image) {
                        if ($image->image_path) {
                            $variantImages[] = $image->image_path;
                        }
                    }
                }
            }
        }
        
        // If we have variant images, use them as the main images
        if (count($variantImages) > 0) {
            $allImages = $variantImages;
        }
        
        // 2. If no variant images, get normal product images
        if (count($allImages) === 0 && $product->productImages && $product->productImages->count() > 0) {
            // Filter images without variant_id or variant_id is null
            $normalImages = $product->productImages->filter(function($img) {
                return empty($img->variant_id) || $img->variant_id === null || $img->variant_id === 0;
            });
            
            if ($normalImages->count() > 0) {
                $sortedImages = $normalImages->sort(function($a, $b) {
                    if ($a->is_main !== $b->is_main) return $b->is_main - $a->is_main;
                    return ($a->display_order ?? 0) - ($b->display_order ?? 0);
                });
                
                foreach ($sortedImages as $image) {
                    if ($image->image_path) {
                        $allImages[] = $image->image_path;
                    }
                }
            } else {
                // If all images have variant_id but we have no variant images yet, use all images
                foreach ($product->productImages as $image) {
                    if ($image->image_path) {
                        $allImages[] = $image->image_path;
                    }
                }
            }
        }
        
        // 3. Add main product image if available and not already in list
        if ($product->image && !in_array($product->image, $allImages)) {
            $allImages[] = $product->image;
        }
        
        // 4. If still no images, try to get from all_images field (legacy)
        if (count($allImages) === 0) {
            // Check if product has all_images property (some older products might have this)
            if (isset($product->all_images) && is_array($product->all_images) && count($product->all_images) > 0) {
                $allImages = $product->all_images;
            }
        }
        
        // 5. If no images at all, add placeholder
        if (empty($allImages)) {
            // Create a colorful placeholder
            $colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD', '#FF8A5C', '#A29BFE'];
            $colorIndex = ($product->id ?? 1) % count($colors);
            $bgColor = $colors[$colorIndex];
            $text = $product->name ? strtoupper(substr($product->name, 0, 2)) : '?';
            
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300">
                <rect width="300" height="300" fill="#f0f0f0"/>
                <rect x="50" y="50" width="200" height="200" fill="' . $bgColor . '" rx="10" opacity="0.8"/>
                <text x="150" y="165" font-family="Arial" font-size="80" fill="white" text-anchor="middle" dominant-baseline="central">' . $text . '</text>
                <text x="150" y="245" font-family="Arial" font-size="14" fill="#999" text-anchor="middle">' . ($product->name ?? 'Product') . '</text>
            </svg>';
            
            $encoded = base64_encode($svg);
            $allImages[] = 'data:image/svg+xml;base64,' . $encoded;
        }
        
        // Get variant data
        $variantsData = [];
        if ($product->variants && $product->variants->count() > 0) {
            $variantsData = $product->variants->map(function($variant) use ($product) {
                // Get variant images
                $variantImages = [];
                if ($product->productImages && $product->productImages->count() > 0) {
                    $variantImageObjs = $product->productImages->filter(function($img) use ($variant) {
                        return $img->variant_id == $variant->id;
                    });
                    
                    if ($variantImageObjs->count() > 0) {
                        foreach ($variantImageObjs as $img) {
                            if ($img->image_path) {
                                $variantImages[] = $img->image_path;
                            }
                        }
                    }
                }
                
                return [
                    'id' => $variant->id,
                    'size' => $variant->size,
                    'color' => $variant->color,
                    'stock' => $variant->stock,
                    'price' => $variant->price,
                    'cost_price' => $variant->cost_price,
                    'mrp' => $variant->mrp,
                    'final_price' => $variant->final_price,
                    'total_price' => $variant->total_price,
                    'discount_type' => $variant->discount_type,
                    'discount_value' => $variant->discount_value,
                    'discount_amount' => $variant->discount_amount,
                    'gst_percentage' => $variant->gst_percentage,
                    'gst_amount' => $variant->gst_amount,
                    'images' => $variantImages,
                ];
            });
        }
        
        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'final_price' => $product->final_price,
            'discount_type' => $product->discount_type,
            'discount_value' => $product->discount_value,
            'discount_amount' => $product->discount_amount,
            'total_price' => $product->total_price,
            'mrp' => $product->mrp,
            'stock' => $product->stock ?? 0,
               // ADD THESE ↓↓↓
    'cod_available' => (int) $product->cod_available,
    'return_days' => $product->return_days,
    'delivery_days' => $product->delivery_days,

            'image' => $product->image,
            'all_images' => $allImages,
            'product_images' => $product->productImages ? $product->productImages->map(function($img) {
                return [
                    'id' => $img->id,
                    'variant_id' => $img->variant_id,
                    'image_path' => $img->image_path,
                    'is_main' => $img->is_main,
                    'display_order' => $img->display_order,
                ];
            }) : [],
            'variants' => $variantsData,
            'category' => $product->category,
            'brand' => $product->brand,
            'gender' => $product->gender ?? null,
            'size' => $product->size ?? null,
            'color' => $product->color ?? null,
            'status' => $product->status,
            'rating' => $product->rating ?? 0,
            'rating_count' => $product->rating_count ?? 0,
            'gst_percentage' => $product->gst_percentage,
            'gst_amount' => $product->gst_amount,
            'description' => $product->description,
        ];
    }
}