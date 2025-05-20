<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginUserService
{
    public function execute(array $credentials): ?string
    {
        $user = User::where('email', $credentials['email'])->first();

        $passwordValid = $user && Hash::check($credentials['password'], $user->password);

        if ($passwordValid) {
            // Gera o token e salva no banco
            $token = $this->encodedTokenGenerate($user->id);
            $user->remember_token = $token;
            $user->save();

            // Salva os dados na sessão
            session_start();
            $_SESSION['user_id'] = $user->id;
            $_SESSION['token'] = $token;

            return $token;
        }

        return null;
    }

    private function encodedTokenGenerate(string $userId): string
    {
        $hash = 'token:' . $userId;
        $token = base64_encode($hash);

        return $token;
    }

    public function validateToken(string $tokenFromRequest): bool
    {
        $user = User::where('remember_token', $tokenFromRequest)->first();

        return $user;
    }
}
