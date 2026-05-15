<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait CompressesImages
{
    /**
     * Compress and store an uploaded image.
     *
     * @param UploadedFile $file      The uploaded image file
     * @param string       $directory The storage directory (e.g. 'gallery', 'news')
     * @param int          $quality   JPEG/WebP quality (1-100), default 75
     * @param int          $maxWidth  Max width in pixels, default 1920
     * @return string The public storage path (e.g. '/storage/gallery/abc123.jpg')
     */
    protected function compressAndStore(UploadedFile $file, string $directory, int $quality = 75, int $maxWidth = 1920): string
    {
        $manager = new ImageManager(new Driver());

        // Read the uploaded image
        $image = $manager->read($file->getRealPath());

        // Scale down if wider than maxWidth (maintains aspect ratio)
        if ($image->width() > $maxWidth) {
            $image->scaleDown(width: $maxWidth);
        }

        // Generate a unique filename preserving extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
            $extension = 'jpg';
        }
        $filename = $directory . '/' . Str::random(40) . '.' . $extension;

        // Encode with compression quality
        if (in_array($extension, ['jpg', 'jpeg'])) {
            $encoded = $image->toJpeg($quality);
        } elseif ($extension === 'png') {
            // PNG uses compression level 0-9, we convert quality to that scale
            // Higher quality = lower compression. quality 75 -> level ~2
            $encoded = $image->toPng();
        } elseif ($extension === 'webp') {
            $encoded = $image->toWebp($quality);
        } else {
            $encoded = $image->toJpeg($quality);
        }

        // Store the compressed image to public disk
        Storage::disk('public')->put($filename, (string) $encoded);

        return '/storage/' . $filename;
    }

    /**
     * Delete an old image from storage if it exists and is a local file.
     *
     * @param string|null $imagePath The current image path (e.g. '/storage/gallery/abc.jpg')
     */
    protected function deleteOldImage(?string $imagePath): void
    {
        if ($imagePath && !str_starts_with($imagePath, 'http')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $imagePath));
        }
    }
}
