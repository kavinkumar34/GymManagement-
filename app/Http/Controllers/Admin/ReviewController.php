<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = ProductReview::with(['user', 'product', 'order'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function pending()
    {
        $reviews = ProductReview::with(['user', 'product', 'order'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approved()
    {
        $reviews = ProductReview::with(['user', 'product', 'order'])
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function rejected()
    {
        $reviews = ProductReview::with(['user', 'product', 'order'])
            ->where('status', 'rejected')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Review approved successfully!');
    }

    public function reject($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Review rejected successfully!');
    }

    public function destroy($id)
    {
        $review = ProductReview::findOrFail($id);
        // Delete images
        if ($review->images) {
            $images = is_string($review->images) ? json_decode($review->images, true) : $review->images;
            if (is_array($images)) {
                foreach ($images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
        }
        // Delete videos
        if ($review->videos) {
            $videos = is_string($review->videos) ? json_decode($review->videos, true) : $review->videos;
            if (is_array($videos)) {
                foreach ($videos as $video) {
                    Storage::disk('public')->delete($video);
                }
            }
        }
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully!');
    }
   /**
 * Get review details for AJAX
 */
public function getDetails($id)
{
    try {
        $review = ProductReview::with(['user', 'product'])->find($id);
        
        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'review' => [
                'id' => $review->id,
                'rating' => $review->rating,
                'description' => $review->description,
                'status' => $review->status,
                'images' => $review->images,
                'videos' => $review->videos,
                'created_at' => $review->created_at,
                'product_name' => $review->product->name ?? 'N/A',
                'user_name' => $review->user->name ?? 'N/A',
                'user_email' => $review->user->email ?? 'N/A',
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}
}