<?php

namespace App\Services\v1;

use App\Models\AttributeValue;

class AttributeValueService
{
    public function getAll()
    {
        return AttributeValue::with('attribute')->get();
    }

    public function create(array $data): AttributeValue
    {
        return AttributeValue::create($data);
    }

    public function getById(int $id): AttributeValue
    {
        return AttributeValue::with('attribute')->findOrFail($id);
    }

    public function update(int $id, array $data): AttributeValue
    {
        $value = $this->getById($id);
        $value->update($data);
        return $value;
    }

    public function delete(int $id): void
    {
        $value = $this->getById($id);
        $value->delete();
    }
}
