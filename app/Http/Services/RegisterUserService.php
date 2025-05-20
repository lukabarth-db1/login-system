<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUserService
{
    public function create(array $data): User
    {
        // Serviço responsável por criar novos usuários no banco de dados a partir da classe Model
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Gera token
        $token = $this->encodedTokenGenerate($user->id);

        // Salva o token no banco
        $user->remember_token = $token;
        $user->save();

        // Armazena user_id e token na sessão para manter o usuário autenticado
        session_start();
        $_SESSION['user_id'] = $user->id;
        $_SESSION['token'] = $user->remember_token;
        return $user;
    }

    private function encodedTokenGenerate(string $userId): string
    {
        $hash = 'token:' . $userId;
        $token = base64_encode($hash);

        return $token;
    }
}
