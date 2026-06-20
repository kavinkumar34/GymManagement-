<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Log the incoming request data for debugging
            Log::info('Review submission data:', $request->all());

            // Get the product_id from request
            $productId = $request->input('product_id');
            $orderId = $request->input('order_id');
            $rating = $request->input('rating');
            $description = $request->input('description');

            // Validate manually to get better error messages
            $errors = [];

            if (empty($orderId)) {
                $errors[] = 'Order ID is required';
            }

            if (empty($productId)) {
                $errors[] = 'Product ID is required';
            }

            if (empty($rating) || $rating < 1 || $rating > 5) {
                $errors[] = 'Rating must be between 1 and 5';
            }

            if (empty($description) || strlen($description) < 5) {
                $errors[] = 'Description must be at least 5 characters';
            }

            // Check if product exists
            if (!empty($productId)) {
                $product = Product::withTrashed()->find($productId);
                if (!$product) {
                    $errors[] = 'Product not found in database. Product ID: ' . $productId;
                } elseif ($product->deleted_at !== null) {
                    $errors[] = 'Product has been deleted.';
                }
            }

            // Check if order exists and belongs to user
            if (!empty($orderId)) {
                $order = Order::with('items')->where('id', $orderId)->where('user_id', auth()->id())->first();
                if (!$order) {
                    $errors[] = 'Order not found or does not belong to you';
                }
            }

            if (!empty($errors)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error: ' . implode(', ', $errors)
                ]);
            }

            // Check if product belongs to the order
            $productExists = false;
            foreach ($order->items as $item) {
                if ((int)$item->product_id === (int)$productId) {
                    $productExists = true;
                    break;
                }
            }

            if (!$productExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'This product is not in your order'
                ]);
            }

            // Check if user already reviewed this product
            $existingReview = ProductReview::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->first();

            if ($existingReview) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already reviewed this product'
                ]);
            }

            // Handle file uploads
            $images = [];
            $videos = [];

            if ($request->hasFile('review_files')) {
                foreach ($request->file('review_files') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('reviews/' . date('Y/m'), 'public');
                        if (str_starts_with($file->getMimeType(), 'image/')) {
                            $images[] = $path;
                        } elseif (str_starts_with($file->getMimeType(), 'video/')) {
                            $videos[] = $path;
                        }
                    }
                }
            }

            // Create the review
            $review = ProductReview::create([
                'user_id' => auth()->id(),
                'order_id' => $orderId,
                'product_id' => $productId,
                'rating' => $rating,
                'description' => $description,
                'images' => !empty($images) ? json_encode($images) : null,
                'videos' => !empty($videos) ? json_encode($videos) : null,
                'status' => 'pending'
            ]);

            Log::info('Review created successfully:', ['review_id' => $review->id]);

            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully! Waiting for admin approval.',
                'review' => $review
            ]);

        } catch (\Exception $e) {
            Log::error('Review submission error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}