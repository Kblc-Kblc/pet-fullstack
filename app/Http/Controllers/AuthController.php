<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


/**
 * @group Auth
 *
 *  Регистрация и авторизация пользователей
 */

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Вход в систему
     *
     * @param  LoginRequest  $request
     * @unauthenticated
     * @bodyParam recaptchaToken string No-example
     *
     * @return JsonResponse
     */

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request->email, $request->password);
        if (!$token) {
            return response()->json(['message' => 'Неверный логин или пароль'], 401);
        }
        return response()->json(compact('token'));
    }

    /**
     * Регистрация пользователя
     *
     * @param  RegisterRequest  $request
     *
     * @return JsonResponse
     */

    public function register(RegisterRequest $request): JsonResponse
    {
        $token = $this->authService->register($request->validated());
        return response()->json(compact('token'));
    }

    public function me(Request $request): UserResource
    {
        return new UserResource($request->user());
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());
        return response()->json(['success' => 'true']);
    }

    /**
    * Обновить данные пользователя
    *
    * @param  UpdateUserRequest  $request
    * @return JsonResponse
    */

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = $this->authService->update($request->user(), $request->validated());
        return response()->json(new UserResource($user));
    }
}

