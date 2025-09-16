<?php

namespace App\Helpers;

use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ImageHelper
{
    // CONSTANTS untuk optimization
    const MAX_WIDTH = 1920;
    const MAX_HEIGHT = 1080;
    const PROFILE_MAX_WIDTH = 400;
    const PROFILE_MAX_HEIGHT = 400;
    const JPEG_QUALITY = 85;
    const WEBP_QUALITY = 80;
    const MAX_FILE_SIZE = 25 * 1024 * 1024; 
    const PROFILE_MAX_SIZE = 25 * 1024 * 1024; 

    public static function uploadImage(
        UploadedFile $file, 
        $model, 
        string $imageType = 'main', 
        int $order = 0
    ) {
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new \Exception('File terlalu besar. Maksimal 25MB.');
        }
        
        // UBAH: Gunakan compression sebelum base64
        $compressedImageData = self::compressAndEncode($file);
        
        return $model->images()->create([
            'filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => strlen($compressedImageData), // Size setelah compression
            'original_size' => $file->getSize(), // Size asli
            'image_data' => $compressedImageData,
            'uploaded_by' => Auth::id(),
            'image_type' => $imageType,
            'order' => $order
        ]);
    }

    /**
     * TAMBAH: Method baru untuk compress image dan convert ke base64
     */
    private static function compressAndEncode(UploadedFile $file)
    {
        $imagePath = $file->getRealPath();
        $imageInfo = getimagesize($imagePath);
        
        if (!$imageInfo) {
            // Fallback untuk non-image files
            return base64_encode(file_get_contents($imagePath));
        }
        
        $mime = $imageInfo['mime'];
        
        // Create image resource berdasarkan type
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($imagePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($imagePath);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($imagePath);
                break;
            default:
                // Fallback untuk format lain
                return base64_encode(file_get_contents($imagePath));
        }
        
        if (!$image) {
            throw new \Exception('Cannot process image');
        }
        
        // Resize jika terlalu besar
        $width = imagesx($image);
        $height = imagesy($image);
        
        $maxWidth = ($width > self::MAX_WIDTH) ? self::MAX_WIDTH : $width;
        $maxHeight = ($height > self::MAX_HEIGHT) ? self::MAX_HEIGHT : $height;
        
        // Calculate new dimensions
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = intval($width * $ratio);
        $newHeight = intval($height * $ratio);
        
        // Create resized image
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preserve transparency untuk PNG
        if ($mime === 'image/png') {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
            imagefill($resizedImage, 0, 0, $transparent);
        }
        
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        
        // Save to temporary file
        $tempFile = tempnam(sys_get_temp_dir(), 'compressed_');
        
        switch ($mime) {
            case 'image/jpeg':
                imagejpeg($resizedImage, $tempFile, self::JPEG_QUALITY);
                break;
            case 'image/png':
                imagepng($resizedImage, $tempFile, 6); // Compression level 6
                break;
            case 'image/webp':
                imagewebp($resizedImage, $tempFile, self::WEBP_QUALITY);
                break;
        }
        
        // Clean up memory
        imagedestroy($image);
        imagedestroy($resizedImage);
        
        // Read compressed file dan convert ke base64
        $compressedData = file_get_contents($tempFile);
        unlink($tempFile); // Delete temp file
        
        return base64_encode($compressedData);
    }

    public static function replaceImage(
        UploadedFile $file, 
        $model, 
        string $imageType = 'main'
    ) {
        $model->images()->where('image_type', $imageType)->delete();
        return self::uploadImage($file, $model, $imageType);
    }

    public static function uploadMultipleImages(
        array $files, 
        $model, 
        string $imageType = 'gallery'
    ) {
        // UBAH: Tambah memory management
        $originalLimit = ini_get('memory_limit');
        ini_set('memory_limit', '1024M');
        
        $images = [];
        try {
            foreach ($files as $index => $file) {
                try {
                    $images[] = self::uploadImage($file, $model, $imageType, $index);
                    
                    // Force garbage collection
                    if (function_exists('gc_collect_cycles')) {
                        gc_collect_cycles();
                    }
                } catch (\Exception $e) {
                    Log::error("Upload failed for file {$index}: " . $e->getMessage());
                    continue;
                }
            }
        } finally {
            // Restore memory limit
            ini_set('memory_limit', $originalLimit);
        }
        
        return $images;
    }
}