<?php
namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\AttributeValueRequest;
use App\Http\Resources\v1\AttributeValueResource;
use App\Services\v1\AttributeValueService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AttributeValueController extends Controller
{
    protected $attributeValueService;

    public function __construct(AttributeValueService $service)
    {
        $this->attributeValueService = $service;
    }

    public function index(): JsonResponse
    {
        $values = $this->attributeValueService->getAll();
        return response()->json(AttributeValueResource::collection($values));
    }

    public function store(AttributeValueRequest $request): JsonResponse
    {
        $value = $this->attributeValueService->create($request->validated());
        return response()->json([
            'message' => 'Attribute value created',
            'value' => new AttributeValueResource($value)
        ], Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        $value = $this->attributeValueService->getById($id);
        return response()->json(new AttributeValueResource($value));
    }

    public function update(AttributeValueRequest $request, $id): JsonResponse
    {
        $value = $this->attributeValueService->update($id, $request->validated());
        return response()->json([
            'message'=>'Attribute value updated',
            'value'=>new AttributeValueResource($value),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->attributeValueService->delete($id);
        return response()->json([
            'message' => 'Attribute value deleted'
        ]);
    }
}
