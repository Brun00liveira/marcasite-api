<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionRepository
{
    protected $user;
    protected $permission;
    protected $role;

    public function __construct(User $user, Permission $permission, Role $role)
    {
        $this->user = $user;
        $this->permission = $permission;
        $this->role = $role;
    }


    public function createRole(array $data): Role
    {
        return $this->role->create($data);
    }

    public function createPermission(array $data): Permission
    {
        return $this->permission->create($data);
    }

    public function assignPermissionToRole(Role $role, string $permission): Role
    {
        return $role->givePermissionTo($permission);
    }

    public function getRoleByName(string $name): ?Role
    {
        return $this->role->findByName($name, 'api');
    }

    public function getRoleByNameAndGuard(string $name, array $guards): ?Role
    {

        return $this->role->where('name', $name)
            ->whereIn('guard_name', $guards)
            ->first();
    }

    public function getPermissionByNameAndGuard(string $name, array $guards): ?Permission
    {
        return $this->permission->where('name', $name)
            ->whereIn('guard_name', $guards)
            ->first();
    }


    public function getUserById(int $userId): ?User
    {
        return $this->user->find($userId);
    }
}
