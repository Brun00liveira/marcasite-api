<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        $user = $this->authService->login($credentials);

        if (!$user) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $token = $user->createToken('Token')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token
        ], 200);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->create($request->all());

        $token = $user->createToken('Token')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token
        ], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($this->authService->logout($user)) {
            return response()->json(['message' => 'Logout realizado com sucesso'], 200);
        }

        return response()->json(['message' => 'Falha ao realizar logout'], 500);
    }

    public function sendResetLinkEmail(Request $request): JsonResponse
    {

        $request->validate(['email' => 'required|email']);

        $response = $this->authService->sendResetLink($request->only('email'));

        return response()->json(['message' => $response['message']], $response['status']);
    }

    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $response = $this->authService->resetPassword(
            $request->only('email', 'password', 'password_confirmation', 'token')
        );

        return response()->json(['message' => $response['message']], $response['status']);
    }
}
