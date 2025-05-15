<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutUserService
{
    public function execute(Request $request): void
    {
        Auth::logout(); // Remove o usuário da sessão
        $request->session()->invalidate(); // Invalida todos os dados da sessão
        $request->session()->regenerateToken(); // Gera novo token CSRF
    }
}
