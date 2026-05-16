<?php
namespace App\Traits;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
trait CompressesImages
{
    protected function compressAndStore(UploadedFile $file, string $directory, int $quality = 75, int $maxWidth = 1920): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
            $extension = 'jpg';
        }
        $filename = $directory . '/' . Str::random(40) . '.' . $extension;
        Storage::disk('public')->put($filename, file_get_contents($file->getRealPath()));
        return '/storage/' . $filename;
    }
    protected function deleteOldImage(?string $imagePath): void
    {
        if ($imagePath && !str_starts_with($imagePath, 'http')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $imagePath));
        }
    }
}
