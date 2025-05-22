<?php

use App\Http\Services\TokenService;
use App\Models\User;

function user(): ?User
{
    if (!isset($_COOKIE['custom_session_id'])) {
        return null;
    }

    $sessionId = $_COOKIE['custom_session_id'];

    $token = new TokenService();

    $sessionData = $token->getSessionData($sessionId);

    if (!$sessionData || !isset($sessionData['user_id'])) {
        return null;
    }

    return User::find($sessionData['user_id']);
}
