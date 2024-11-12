<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Password;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Cria um novo usuário através do repositório.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function login(array $credentials)
    {
        return $this->userRepository->login($credentials);
    }

    public function logout($user)
    {
        return $this->userRepository->logout($user);
    }

    public function sendResetLink(array $data)
    {

        $status = $this->userRepository->sendResetLink($data);

        if ($status === Password::RESET_LINK_SENT) {
            return ['message' => 'Link de redefinição de senha enviado para seu email.', 'status' => 200];
        }

        return ['message' => 'Não foi possível enviar o link de redefinição.', 'status' => 500];
    }

    public function resetPassword(array $data)
    {
        $status = $this->userRepository->resetPassword($data);

        if ($status === Password::PASSWORD_RESET) {
            return ['message' => 'Senha redefinida com sucesso.', 'status' => 200];
        }

        return ['message' => 'Falha ao redefinir a senha.', 'status' => 500];
    }
}
