<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

class LogoutUserService
{
    public function execute(Request $request): void
    {
        // Remove o ID do usuário da sessão
        $request->session()->forget('user_id');

        // Invalida a sessão atual
        $request->session()->invalidate();

        // Regenera o token CSRF para evitar ataques
        $request->session()->regenerateToken();
    }
}
