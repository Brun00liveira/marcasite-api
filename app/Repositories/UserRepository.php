<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll(): Collection
    {
        return $this->user->all();
    }

    public function findById($id): User
    {
        return $this->user->findOrFail($id);
    }

    public function create(array $data): User
    {
        return $this->user->create($data);
    }

    public function update(int $id, array $data): User
    {
        $user = $this->user->findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete(int $id): bool
    {
        $user = $this->user->findOrFail($id);
        return $user->delete();
    }
}
