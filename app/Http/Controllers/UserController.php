<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\StandardResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): StandardResource
    {
        $users = $this->userService->getAllUsers();
        return new StandardResource($users);
    }

    public function show($id): StandardResource
    {
        $user = $this->userService->getUserById($id);
        return new StandardResource($user);
    }

    public function store(UserRequest $request): StandardResource
    {
        $user = $this->userService->createUser($request->validated());
        return new StandardResource(
            [
                'message' => 'Usuário criado com sucesso',
                'data' => $user
            ]
        );
    }

    public function update(UserRequest $request, $id): StandardResource
    {
        $user = $this->userService->updateUser($id, $request->validated());
        return new StandardResource(
            [
                'message' => 'Usuário atualizado com sucesso',
                'data' => $user
            ]
        );
    }

    public function destroy($id): JsonResponse
    {
        $this->userService->deleteUser($id);
        return response()->json(['message' => 'Usuário excluído com sucesso'], 200);
    }
}
