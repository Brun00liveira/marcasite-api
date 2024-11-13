<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\StandardResource;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(): StandardResource
    {
        $categories = $this->categoryService->getAllUsers();
        return new StandardResource($categories);
    }

    public function show($id): StandardResource
    {
        $category = $this->categoryService->getUserById($id);

        if ($category) {
            return new StandardResource($category);
        }
    }

    public function store(CategoryRequest $request): StandardResource
    {
        $category = $this->categoryService->createUser($request->validated());

        return new StandardResource($category);
    }

    public function update(CategoryRequest $request, $id): StandardResource
    {

        $user = $this->categoryService->updateUser($id, $request->validated());

        return new StandardResource($user);
    }

    public function destroy($id): JsonResponse
    {
        $deleted = $this->categoryService->deleteUser($id);

        if ($deleted) {
            return response()->json(['message' => 'Categoria deletada com sucesso']);
        }

        return response()->json(['message' => 'Categoria não encontrada'], 404);
    }
}
