<?php

namespace app\services;

use app\models\Users;

class AuthService
{
    public function register(array $data)
    {
        $user = new Users();

        $user->name = $data['name'] ?? null;
        $user->email = $data['email'] ?? null;
        $user->phone = $data['phone'] ?? null;

        if (empty($data['password_hash'])) {
            return [
                'status' => 'error',
                'message' => 'Пароль обязателен',
            ];
        }

        $user->password_hash = $data['password_hash'];
        $user->generateToken();

        if (!$user->save()) {
            return [
                'status' => 'error',
                'errors' => $user->errors,
            ];
        }

        return [
            'status' => 'ok',
            'token' => $user->access_token,
        ];
    }

    public function login(string $email, string $password)
    {
        $user = Users::findByEmail($email);

        if (!$user || !$user->validatePassword($password)) {
            return [
                'status' => 'error',
                'message' => 'Неверный email или пароль',
            ];
        }

        $user->generateToken();
        $user->save(false);

        return [
            'status' => 'ok',
            'token' => $user->access_token,
        ];
    }
}
