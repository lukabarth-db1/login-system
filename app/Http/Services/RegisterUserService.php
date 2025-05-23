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
        $token = $this->token->encodedTokenGenerate($user->id);

        // Salva o token no banco
        $user->remember_token = $token;
        $user->save();

        session_start();
        // Gera identificador de sessão
        $sessionId = bin2hex(random_bytes(16));

        // Cria cookie com o ID da sessão
        setcookie('custom_session_id', $sessionId, time() + 300, '/');

        // Salva dados da sessão
        $this->token->saveSession($sessionId, [
            'user_id' => $user->id,
            'token' => $token,
        ]);

        return $user;
    }
}
