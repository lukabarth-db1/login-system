<?php

namespace App\Http\Services;

class LogoutUserService
{
    public function __construct(private TokenService $token) {}

    public function execute(): void
    {
        session_start();

        $session = $this->token->getSessionData();

        // Remove o ID e token da sessão do usuário
        unset($session['user_id']);
        unset($session['token']);

        // Remove o arquivo de sessão
        session_destroy();

        // Regenera a sessão para segurança
        session_start();
        session_regenerate_id(true);
    }
}
