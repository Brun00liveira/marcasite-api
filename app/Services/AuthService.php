<?php

namespace App\Services;

use App\Models\User;
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

        $status = $this->authRepository->sendResetLink($data);

        if ($status === Password::RESET_LINK_SENT) {
            return ['message' => 'Link de redefinição de senha enviado para seu email.', 'status' => 200];
        }

        return ['message' => 'Não foi possível enviar o link de redefinição.', 'status' => 500];
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
