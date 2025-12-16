<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Process and store user profile image
     */
    public function storeProfileImage(UploadedFile $file, $userId = null)
    {
        // Validate file
        $this->validateImage($file);
        
        // Generate unique filename
        $filename = $this->generateFilename($file, $userId);
        
        // Create directories
        $this->createDirectories();
        
        // Process and store image
        $path = $this->processAndStoreImage($file, $filename);
        
        return $path;
    }

    /**
     * Delete existing profile image
     */
    public function deleteProfileImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
            
            // Also delete thumbnail if exists
            $thumbnailPath = $this->getThumbnailPath($imagePath);
            if (Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            
            return true;
        }
        
        return false;
    }


    /**
     * Get full URL for image path
     */
    public function getImageUrl($imagePath)
    {
        if (!$imagePath) {
            return null;
        }
        
        return asset('storage/' . $imagePath);
    }

    /**
     * Get thumbnail path for given image path
     */
    public function getThumbnailPath($imagePath)
    {
        $pathInfo = pathinfo($imagePath);
        return $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
    }

    /**
     * Validate uploaded image
     */
    private function validateImage(UploadedFile $file)
    {
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $maxSize = 2 * 1024 * 1024; // 2MB
        
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            throw new \Exception('Invalid file type. Only JPEG, PNG, JPG, and GIF are allowed.');
        }
        
        if ($file->getSize() > $maxSize) {
            throw new \Exception('File size must not exceed 2MB.');
        }
    }

    /**
     * Generate unique filename
     */
    private function generateFilename(UploadedFile $file, $userId = null)
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = now()->format('Y-m-d_H-i-s');
        $random = Str::random(8);
        $userPrefix = $userId ? "user_{$userId}_" : '';
        
        return "{$userPrefix}{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Create necessary directories
     */
    private function createDirectories()
    {
        $directories = [
            'profile-images',
            'profile-images/thumbnails'
        ];
        
        foreach ($directories as $directory) {
            $fullPath = storage_path("app/public/{$directory}");
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
        }
    }

    /**
     * Process and store image with optimization
     */
    private function processAndStoreImage(UploadedFile $file, $filename)
    {
        $sourcePath = $file->getPathname();
        
        // Get image info
        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            throw new \Exception('Invalid image file.');
        }
        
        [$width, $height, $type] = $imageInfo;
        
        // Create image resource based on type
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($sourcePath);
                break;
            default:
                throw new \Exception('Unsupported image type.');
        }
        
        // Calculate new dimensions (max 800px width/height)
        $maxSize = 800;
        $newDimensions = $this->calculateNewDimensions($width, $height, $maxSize);
        
        // Create resized image
        $resized = imagecreatetruecolor($newDimensions['width'], $newDimensions['height']);
        
        // Preserve transparency for PNG and GIF
        if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
            imagecolortransparent($resized, imagecolorallocatealpha($resized, 0, 0, 0, 127));
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
        }
        
        // Resize image
        imagecopyresampled(
            $resized, $source,
            0, 0, 0, 0,
            $newDimensions['width'], $newDimensions['height'],
            $width, $height
        );
        
        // Store main image
        $mainPath = "profile-images/{$filename}";
        $this->saveImage($resized, $mainPath, $type);
        
        // Create and store thumbnail
        $thumbnailDimensions = $this->calculateNewDimensions($newDimensions['width'], $newDimensions['height'], 150);
        $thumbnail = imagecreatetruecolor($thumbnailDimensions['width'], $thumbnailDimensions['height']);
        
        // Preserve transparency for thumbnail
        if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
            imagecolortransparent($thumbnail, imagecolorallocatealpha($thumbnail, 0, 0, 0, 127));
            imagealphablending($thumbnail, false);
            imagesavealpha($thumbnail, true);
        }
        
        imagecopyresampled(
            $thumbnail, $resized,
            0, 0, 0, 0,
            $thumbnailDimensions['width'], $thumbnailDimensions['height'],
            $newDimensions['width'], $newDimensions['height']
        );
        
        $thumbnailPath = "profile-images/thumbnails/{$filename}";
        $this->saveImage($thumbnail, $thumbnailPath, $type);
        
        // Note: imagedestroy is deprecated in PHP 8+ and will be removed in PHP 9
        // Modern PHP handles memory management automatically
        
        return $mainPath;
    }

    /**
     * Calculate new dimensions maintaining aspect ratio
     */
    private function calculateNewDimensions($width, $height, $maxSize)
    {
        if ($width > $height) {
            if ($width > $maxSize) {
                $ratio = $maxSize / $width;
                return [
                    'width' => $maxSize,
                    'height' => (int)($height * $ratio)
                ];
            }
        } else {
            if ($height > $maxSize) {
                $ratio = $maxSize / $height;
                return [
                    'width' => (int)($width * $ratio),
                    'height' => $maxSize
                ];
            }
        }
        
        return ['width' => $width, 'height' => $height];
    }

    /**
     * Save image to disk
     */
    private function saveImage($image, $path, $type)
    {
        $fullPath = storage_path("app/public/{$path}");
        
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($image, $fullPath, 85); // 85% quality
                break;
            case IMAGETYPE_PNG:
                imagepng($image, $fullPath, 8); // Compression level 8
                break;
            case IMAGETYPE_GIF:
                imagegif($image, $fullPath);
                break;
        }
    }
}
