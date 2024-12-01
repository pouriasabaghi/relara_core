<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CategoryRequest;
use App\Http\Resources\v1\CategoryResource;
use App\Services\v1\CategoryService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getCategoriesWithChildren();
        return response()->json(CategoryResource::collection($categories));
    }


    public function store(CategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->saveCategory($request->validated());
        return response()->json($category, Response::HTTP_CREATED);
    }

    public function show(int $id)
    {
        $category = $this->categoryService->getCategoryById($id);
        return response()->json(new CategoryResource($category));
    }

    public function update(CategoryRequest $request, $id): JsonResponse
    {
        $category = $this->categoryService->saveCategory($request->validated(), $id);
        return response()->json($category);
    }

    public function destroy($id): JsonResponse
    {
        $this->categoryService->deleteCategory($id);
        return response()->json(['message' => 'Category deleted successfully.']);
    }
}

