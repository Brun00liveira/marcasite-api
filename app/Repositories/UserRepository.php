<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserRepository
{
    protected $user;
    protected $passwordResetToken;

    public function __construct(User $user, PasswordResetToken $passwordResetToken)
    {
        $this->user = $user;
        $this->passwordResetToken = $passwordResetToken;
    }

    public function create(array $data)
    {
        return $this->user->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function login(array $credentials)
    {
        $user = $this->user->where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        return $user;
    }

    public function logout($user)
    {
        return $user->currentAccessToken()->delete();
    }

    public function sendResetLink(array $data)
    {
        return Password::sendResetLink(['email' => $data['email']]);
    }

    public function resetPassword(array $data)
    {
        return Password::reset($data, function (User $user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
        });
    }
}
