<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Password;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function create(array $data): User
    {
        return $this->authRepository->create($data);
    }

    public function login(array $credentials): User
    {
        return $this->authRepository->login($credentials);
    }

    public function logout(User $user): bool
    {
        return $this->authRepository->logout($user);
    }

    public function sendResetLink(array $data)
    {
        $response = $this->authRepository->sendResetLink($data);
        return $response;
    }


    public function resetPassword(array $data)
    {
        $status = $this->authRepository->resetPassword($data);

        if ($status === Password::PASSWORD_RESET) {
            return ['message' => 'Senha redefinida com sucesso.', 'status' => 200];
        }

        return ['message' => 'Falha ao redefinir a senha.', 'status' => 500];
    }
}
