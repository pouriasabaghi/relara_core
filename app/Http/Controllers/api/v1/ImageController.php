<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Services\v1\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function store(Request $request, ImageService $imageService)
    {
        $data = $request->validate([
            'image' => 'required|image|max:10240', // 10MB
        ]);

        $path = $imageService->upload($data['image'], 'temp');

        return response()->json(['url' => url("storage/$path"), 'path' => $path]);
    }
}
