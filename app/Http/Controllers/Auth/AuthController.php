<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        $user = $this->userService->login($credentials);

        if (!$user) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $token = $user->createToken('Token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 200);
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->userService->create($request->all());

        $token = $user->createToken('Token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($this->userService->logout($user)) {
            return response()->json(['message' => 'Logout realizado com sucesso'], 200);
        }

        return response()->json(['message' => 'Falha ao realizar logout'], 500);
    }

    public function sendResetLinkEmail(Request $request)
    {

        $request->validate(['email' => 'required|email']);

        $response = $this->userService->sendResetLink($request->only('email'));

        return response()->json(['message' => $response['message']], $response['status']);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $response = $this->userService->resetPassword(
            $request->only('email', 'password', 'password_confirmation', 'token')
        );

        return response()->json(['message' => $response['message']], $response['status']);
    }
}
