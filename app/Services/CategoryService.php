<?php

namespace App\Services;

use App\Models\Category;
use App\Models\User;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllUsers(): Collection
    {
        return $this->categoryRepository->getAll();
    }

    public function getUserById(int $id): ?Category
    {
        return $this->categoryRepository->findById($id);
    }

    public function createUser(array $data): Category
    {
        return $this->categoryRepository->create($data);
    }

    public function updateUser(int $id, array $data): Category
    {

        $user = $this->categoryRepository->findById($id);

        return $this->categoryRepository->update($user, $data);
    }

    public function deleteUser(int $id): bool
    {
        $user = $this->categoryRepository->findById($id);

        return $this->categoryRepository->delete($user);
    }
}
