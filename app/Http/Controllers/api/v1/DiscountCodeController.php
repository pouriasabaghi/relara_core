<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\DiscountCodeRequest;
use App\Models\DiscountCode;
use App\Services\v1\DiscountCodeService;
use Illuminate\Http\Request;

class DiscountCodeController extends Controller
{
    public function __construct(protected DiscountCodeService $discountCodeService)
    {
    }

    public function index()
    {
        $discountCodes = $this->discountCodeService->getAll();

        return response()->json($discountCodes);
    }

    public function store(DiscountCodeRequest $request)
    {
        $discountCode = $this->discountCodeService->storeOrUpdate($request->validated());

        return response()->json([
            'discount_code' => $discountCode,
            'message' => 'Discount Code Created Successfully.'
        ]);
    }

    public function show(DiscountCode $discountCode)
    {
        return response()->json($discountCode);
    }

    public function update(DiscountCodeRequest $request, DiscountCode $discountCode)
    {
        $discountCode = $this->discountCodeService->storeOrUpdate($request->validated(), $discountCode);

        return response()->json([
            'discount_code' => $discountCode,
            'message' => 'Discount Code Updated Successfully.'
        ]);
    }

    public function destroy(string $id)
    {
        $this->discountCodeService->destroyHandler($id);

        return response()->json([
            'message' => 'Discount Code Deleted Successfully.'
        ]);
    }
}
