<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class CaptchaController extends Controller
{
    public function generate()
    {
        // Generate random 6-digit number
        $captcha = rand(100000, 999999);
        
        // Store in session
        session(['captcha' => $captcha]);
        
        // Create image
        $width = 150;
        $height = 50;
        
        $image = imagecreatetruecolor($width, $height);
        
        // Colors
        $bgColor = imagecolorallocate($image, 240, 248, 255);
        $textColor = imagecolorallocate($image, 25, 25, 112);
        $lineColor = imagecolorallocate($image, 100, 149, 237);
        $pixelColor = imagecolorallocate($image, 70, 130, 180);
        
        // Fill background
        imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);
        
        // Add random lines
        for($i = 0; $i < 8; $i++) {
            imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $lineColor);
        }
        
        // Add random pixels
        for($i = 0; $i < 500; $i++) {
            imagesetpixel($image, rand(0, $width), rand(0, $height), $pixelColor);
        }
        
        // Add text
        $fontSize = 5;
        $textWidth = imagefontwidth($fontSize) * strlen($captcha);
        $x = ($width - $textWidth) / 2;
        $y = ($height - imagefontheight($fontSize)) / 2;
        
        imagestring($image, $fontSize, $x, $y, $captcha, $textColor);
        
        // Output as PNG
        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
}