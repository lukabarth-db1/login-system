<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginUserService
{
    public function __construct(private TokenService $token) {}

    public function execute(array $credentials): ?string
    {
        $user = User::where('email', $credentials['email'])->first();

        $passwordValid = $user && Hash::check($credentials['password'], $user->password);

        if ($passwordValid) {
            session_start();
            // Gera o token e salva no banco
            $token = $this->token->encodedTokenGenerate($user->id);

            $user->remember_token = $token;
            $user->save();

            // Gera identificador da sessão
            $sessionId = bin2hex(random_bytes(16));

            // Cria cookie com ID da sessão
            setcookie('custom_session_id', $sessionId, time() + 3600, '/');

            // Cria e salva os dados da sessão no arquivo
            $this->token->saveSession($sessionId, [
                'user_id' => $user->id,
                'token' => $token,
            ]);

            return $token;
        }

        return null;
    }
}
