<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

/**
 * @group Auth
 *
 *  Регистрация и авторизация пользователей
 */
class AuthController extends Controller
{
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
        $user = User::where('email', $request->get('email'))->first();
        if (!$user || !Hash::check($request->get('password'), $user->password)) {
            return response()->json(['message' => 'Неверный логин или пароль'], 401);
        }
        $token = $user->createToken('Personal Access Token')->plainTextToken;

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
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json(compact('token'));
    }


    /**
     * Me
     *
     * Получить информацию о текущем авторизованном пользователе.
     * <aside class="notice">Для определения пользователя используется текущий bearer-токен</aside>
     */
    public function me(Request $request): UserResource
    {
        $user = $request->user();
        return new UserResource($user);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $request->user()->currentAccessToken()->delete();

        return response()->json(['success' => 'true']);
    }
}
