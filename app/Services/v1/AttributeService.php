<?php
namespace App\Services\v1;

use App\Models\Attribute;

class AttributeService
{
    public function getAll()
    {
        return Attribute::with('values')->get();
    }

    public function create(array $data): Attribute
    {
        return Attribute::create($data);
    }

    public function getById(int $id): Attribute
    {
        return Attribute::with('values')->findOrFail($id);
    }

    public function update(int $id, array $data): Attribute
    {
        $attribute = $this->getById($id);
        $attribute->update($data);
        return $attribute;
    }

    public function delete(int $id): void
    {
        $attribute = $this->getById($id);
        $attribute->delete();
    }
}
