<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login($email, $password)
    {
        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

        return $user->createToken('Personal Access Token')->plainTextToken;
    }

    public function register($data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $user->createToken('Personal Access Token')->plainTextToken;
    }

    public function logout($user)
    {
        $user->tokens()->delete();
        $user->currentAccessToken()->delete();
    }

    public function update($user, $data)
    {
        $user->name = $data['name'];
        if (isset($data['email'])) {
            $user->email = $data['email'];
        }
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return $user;
    }
}
