<?php
namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ProductRequest;
use App\Http\Resources\v1\ProductResource;
use App\Services\v1\ProductService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): JsonResponse
    {
        try {
            $products = $this->productService->getAll();
            return response()->json(ProductResource::collection($products));
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], $th->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $product = $this->productService->create($request->validated());
        return response()->json([
            'message' => 'Product created',
            'product' => new ProductResource($product)
        ], status: Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        $product = $this->productService->getById($id);
        return response()->json(new ProductResource($product));
    }

    public function update(ProductRequest $request, $id): JsonResponse
    {
        $product = $this->productService->update($id, $request->validated());
        return response()->json([
            'message' => 'Product updated',
            'product' => new ProductResource($product),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->productService->delete($id);
        return response()->json([
            'message' => 'Product deleted'
        ]);
    }
}
