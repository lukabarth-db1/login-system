<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUserService
{
    public function __construct(private TokenService $token) {}

    public function create(array $data): User
    {
        // Serviço responsável por criar novos usuários no banco de dados a partir da classe Model
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Gera token
        $generateToken = $this->token->encodedTokenGenerate($user->id);

        // Salva o token no banco
        $user->remember_token = $generateToken;
        $user->save();

        $session = $this->token->getSessionData();
        // Armazena user_id e token na sessão para manter o usuário autenticado
        session_start();
        $session['user_id'] = $user->id;
        $session['token'] = $user->remember_token;
        return $user;
    }
}
