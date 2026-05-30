<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannerApiController extends Controller
{
    public function getBanners()
    {
        $banners = Banner::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();
        
        foreach ($banners as $banner) {
            if ($banner->image) {
                $banner->image_url = asset('storage/' . $banner->image);
            }
        }
        
        return response()->json($banners);
    }
}