<?php

namespace App\Http\Services;

class LogoutUserService
{
    public function execute(): void
    {
        session_start();

        // Remove o ID e token da sessão do usuário
        unset($_SESSION['user_id']);
        unset($_SESSION['token']);

        // Remove o arquivo de sessão
        session_destroy();

        // Regenera a sessão para segurança
        session_start();
        session_regenerate_id(true);
    }
}
