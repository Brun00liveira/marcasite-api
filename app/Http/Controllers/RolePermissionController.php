<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolePermissionNameRequest;
use App\Http\Requests\RolePermissionRequest;
use App\Http\Requests\UserPermissionRequest;
use App\Http\Requests\UserRoleRequest;
use App\Services\RolePermissionService;
use Illuminate\Http\JsonResponse;

class RolePermissionController extends Controller
{
    protected $rolePermissionService;

    public function __construct(RolePermissionService $rolePermissionService)
    {
        $this->rolePermissionService = $rolePermissionService;
    }

    public function createRole(RolePermissionNameRequest $request): JsonResponse
    {
        $role = $this->rolePermissionService->createRole([
            'name' => $request->name,
            'guard_name' => 'api'
        ]);

        return response()->json(['message' => 'Papel criado com sucesso', 'role' => $role], 201);
    }

    public function createPermission(RolePermissionNameRequest $request): JsonResponse
    {
        $permission = $this->rolePermissionService->createPermission([
            'name' => $request->name,
            'guard_name' => 'api'
        ]);

        return response()->json(['message' => 'Permissão criada com sucesso', 'permission' => $permission], 201);
    }

    public function assignPermissionToRole(RolePermissionRequest $request): JsonResponse
    {

        $result = $this->rolePermissionService->assignPermissionToRole($request->role, $request->permission);

        if ($result) {
            return response()->json(['message' => 'Permissão atribuída ao papel com sucesso'], 200);
        }

        return response()->json(['message' => 'Papel não encontrado'], 404);
    }

    public function assignRoleToUser(UserRoleRequest $request): JsonResponse
    {
        $result = $this->rolePermissionService->assignRoleToUser($request->user_id, $request->role);

        if ($result) {
            return response()->json(['message' => 'Papel atribuído ao usuário com sucesso'], 200);
        }

        return response()->json(['message' => 'Usuário ou papel não encontrado'], 404);
    }

    public function assignPermissionToUser(UserPermissionRequest $request): JsonResponse
    {

        $result = $this->rolePermissionService->assignPermissionToUser($request->user_id, $request->permission); // Corrigir 'role' para 'permission'

        if ($result) {
            return response()->json(['message' => 'Permissão atribuída ao usuário com sucesso'], 200); // Mensagem de sucesso
        }

        return response()->json(['message' => 'Usuário ou permissão não encontrado'], 404); // Mensagem de erro
    }
}
