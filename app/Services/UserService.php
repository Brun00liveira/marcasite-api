<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers(): Collection
    {
        return $this->userRepository->getAll();
    }

    public function getUserById($id): ?User
    {
        return $this->userRepository->findById($id);
    }

    public function createUser(array $data): User
    {
        return $this->userRepository->create($data);
    }

    public function updateUser($id, array $data): User
    {
        $user = $this->userRepository->findById($id);

        return $this->userRepository->update($user, $data);
    }

    public function deleteUser($id): bool
    {
        $user = $this->userRepository->findById($id);
        return $this->userRepository->delete($user);
    }
}
