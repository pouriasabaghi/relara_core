<?php

namespace App\Services\v1;

use App\Models\DiscountCode;

class DiscountCodeService
{
    public function getAll()
    {
        $discountCodes = DiscountCode::all();

        return $discountCodes;
    }

    public function storeOrUpdate(array $data, ?DiscountCode $discountCode = null ){
        if (!empty($data['expires_at']))
            $data['expires_at'] = now()->addDays($data['expires_at']);

        if ($discountCode) {
            $discountCode->update($data);
            $discountCode->refresh();
        } else {
            $discountCode = DiscountCode::create($data);
        }

        return $discountCode;
    }

    public function destroyHandler(string $id)
    {
        $discountCode = DiscountCode::findOrFail($id);

        $discountCode->delete();
    }
}