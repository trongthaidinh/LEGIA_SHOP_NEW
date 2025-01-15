<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

trait HandleUploadImage
{
    /**
     * Handle image upload.
     *
     * @param UploadedFile $image
     * @param string $folder
     * @param string|null $oldImage
     * @return string
     */
    protected function handleUploadImage(UploadedFile $image, string $folder, ?string $oldImage = null): string
    {
        // Delete old image if exists
        if ($oldImage && Storage::disk('public')->exists($oldImage)) {
            Storage::disk('public')->delete($oldImage);
        }

        // Create unique filename
        $filename = $this->generateUniqueSlug($image->getClientOriginalName()) . '-' . time() . '.' . $image->getClientOriginalExtension();
        
        // Store the image
        return $image->storeAs("images/{$folder}", $filename, 'public');
    }

    /**
     * Generate unique slug.
     *
     * @param string $name
     * @param string|null $model
     * @param int|null $excludeId
     * @return string
     */
    protected function generateUniqueSlug(string $name, ?string $model = null, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $count = 1;

        if ($model) {
            $query = $model::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            while ($query->exists()) {
                $newSlug = $slug . '-' . $count++;
                $query = $model::where('slug', $newSlug);
                if ($excludeId) {
                    $query->where('id', '!=', $excludeId);
                }
            }

            if ($count > 1) {
                $slug .= '-' . ($count - 1);
            }
        }

        return $slug;
    }

    /**
     * Delete image from storage.
     *
     * @param string|null $path
     * @return void
     */
    protected function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
} 