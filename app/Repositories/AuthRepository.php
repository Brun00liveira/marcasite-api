<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\PasswordResetToken;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthRepository
{
    protected $user;
    protected $passwordResetToken;

    public function __construct(User $user, PasswordResetToken $passwordResetToken)
    {
        $this->user = $user;
        $this->passwordResetToken = $passwordResetToken;
    }

    public function create(array $data): User
    {
        return $this->user->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function login(array $credentials): ?User
    {
        $user = $this->user->where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            // Lançar exceção personalizada ou retornar null
            throw new AuthenticationException('Credenciais inválidas');
        }

        return $user;
    }


    public function logout(object $user): bool
    {
        if ($user && $user->currentAccessToken()) {
            return $user->currentAccessToken()->delete();
        }

        return false;
    }

    public function sendResetLink(array $data)
    {
        $user = $this->user->where('email', $data['email'])->first();

        if (!$user) {
            return ['message' => 'Não foi possível encontrar o usuário com esse e-mail.', 'status' => 404];
        }

        $token = app('auth.password.broker')->createToken($user);

        $user->notify(new ResetPasswordNotification($token, $data['email']));

        return ['message' => 'Link de redefinição de senha enviado para seu email.', 'status' => 200];
    }

    public function resetPassword(array $data): string
    {
        return Password::reset($data, function (User $user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
        });
    }
}
