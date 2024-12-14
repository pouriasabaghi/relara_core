<?php

namespace App\Services\v1;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;

class ImageService
{
    public function resize(string|array $imagePaths, string $folder): array
    {
        // nested destination path
        $folder = $this->prepareStorageFolder($folder);

        $imagePathsToProcess = is_string($imagePaths) ? [$imagePaths] : $imagePaths;

        $allResizedImages = [];
        foreach ($imagePathsToProcess as $path) {
            $allResizedImages[] = $this->processSingleImage($path, $folder);
        }

        return is_string($imagePaths) ? $allResizedImages[0] : $allResizedImages;
    }

    /**
     * Prepare the storage folder and return its path.
     */
    private function prepareStorageFolder(string $folder): string
    {
        $nestedFolder = "$folder/" . date('Y/m');
        $storagePath = storage_path("app/public/$nestedFolder/");

        if (!File::isDirectory($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        return $nestedFolder;
    }

    /**
     * Process a single image and create all resized versions.
     */
    private function processSingleImage(string $path, string $folder): array
    {
        $sizes = config('image.sizes');

        $filename = pathinfo($path, PATHINFO_FILENAME);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $resizedImages = [];
        foreach ($sizes as $key => $size) {
            $croppedName = "$filename-{$size['width']}x{$size['height']}.$extension";
            $storagePath = storage_path("app/public/$folder/$croppedName");

            Image::read("storage/$path")
                ->cover(width: $size['width'], height: $size['height'], position: 'center')
                ->save($storagePath);

            $resizedImages[] = ["size" => $key, "path" => "$folder/$croppedName"];
        }

        return $resizedImages;
    }


    /**
     * Upload an image to the given folder, and return its path.
     * The image is stored in a folder with the current year and month.
     * The filename is a unique id followed by the original filename.
     *
     * @param  \Illuminate\Http\UploadedFile  $imageFile
     * @param  string  $folder
     * @return string
     */
    public function upload($imageFile, string $folder): bool|string
    {
        $filename = uniqid() . "_" . $imageFile->getClientOriginalName();

        $folder = "$folder/" . date('Y/m');

        $path = $imageFile->storeAs($folder, $filename, 'public');

        return $path;
    }

    public function move(string $imagePath, string $folder): bool|string
    {
        $filename = pathinfo($imagePath, PATHINFO_BASENAME);  // with extension
        
        $folder = "$folder/" . date('Y/m');

        $destination = "$folder/$filename";

        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->move($imagePath, $destination);
            return $destination;
        }

        return false;
    }
}