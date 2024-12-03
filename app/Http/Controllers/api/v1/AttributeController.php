<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\AttributeRequest;
use App\Http\Resources\v1\AttributeResource;
use App\Services\v1\AttributeService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AttributeController extends Controller
{
    protected $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    public function index(): JsonResponse
    {
        $attributes = $this->attributeService->getAll();
        return response()->json(AttributeResource::collection($attributes));
    }


    public function store(AttributeRequest $request): JsonResponse
    {
        $attribute = $this->attributeService->create($request->validated());
        return response()->json([
            'message' => 'Attribute created',
            'attribute' => new AttributeResource($attribute)
        ], Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        $attribute = $this->attributeService->getById($id);
        return response()->json(new AttributeResource($attribute));
    }

    public function update(AttributeRequest $request, $id): JsonResponse
    {
        $attribute = $this->attributeService->update($id, $request->validated());
        return response()->json([
            'message' => 'Attribute updated',
            'attribute' => new AttributeResource($attribute)
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->attributeService->delete($id);
        return response()->json([
            'message' => 'Attribute deleted'
        ]);
    }
}
