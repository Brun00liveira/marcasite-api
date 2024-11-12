<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\PasswordResetToken;
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
            return null;
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

    public function sendResetLink(array $data): string
    {
        return Password::sendResetLink(['email' => $data['email']]);
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
