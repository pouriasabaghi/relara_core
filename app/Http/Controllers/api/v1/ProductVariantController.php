<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ProductVariantRequest;
use App\Http\Resources\v1\ProductVariantResource;
use App\Services\v1\ProductVariantService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductVariantController extends Controller
{
    protected $productVariantService;

    public function __construct(ProductVariantService $service)
    {
        $this->productVariantService = $service;
    }

    public function index(): JsonResponse
    {
        $variants = $this->productVariantService->getAll();
        return response()->json(ProductVariantResource::collection($variants));
    }

    public function store(ProductVariantRequest $request): JsonResponse
    {
        $variant = $this->productVariantService->create($request->validated());
        return response()->json(new ProductVariantResource($variant), Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        $variant = $this->productVariantService->getById($id);
        return response()->json(new ProductVariantResource($variant));
    }

    public function update(ProductVariantRequest $request, $id): JsonResponse
    {
        try {
            $variant = $this->productVariantService->update($id, $request->validated());
            return response()->json(new ProductVariantResource($variant));
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], $th->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id): JsonResponse
    {
        $this->productVariantService->delete($id);
        return response()->json(data: [
            'message' => 'Product variant deleted',
        ]);
    }
}
