<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAll(): Collection
    {
        return $this->category->all();
    }

    public function findById($id): ?Category
    {

        return $this->category->find($id);
    }

    public function create(array $data): Category
    {
        return $this->category->create($data);
    }

    public function update(Category $category, array $data): Category
    {

        $category->update($data);
        return $category;
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}
