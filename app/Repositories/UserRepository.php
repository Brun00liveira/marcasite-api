<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return $this->user->paginate($perPage);
    }


    public function findById($id): User
    {
        return $this->user->findOrFail($id);
    }

    public function create(array $data): User
    {
        return $this->user->create($data);
    }

    public function update(User $user, array $data): User
    {

        $user->update($data);
        return $user;
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
