<?php

namespace App\Http\Services;

use App\Models\User;

class TokenService
{
    private string $sessionPath = __DIR__ . '/../../../storage/sessions';

    public function encodedTokenGenerate(string $userId): string
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

    public function saveSession(string $sessionId, array $data): void
    {
        if (!is_dir($this->sessionPath)) {
            mkdir($this->sessionPath, 0755, true);
        }

        $sessionFile = $this->sessionPath . '/' . $sessionId . '.json';

        file_put_contents($sessionFile, json_encode($data));
    }

    public function getSessionData(): ?array
    {
        if (!isset($_COOKIE['custom_session_id'])) {
            return null;
        }

        $sessionId = $_COOKIE['custom_session_id'];
        $sessionFile = $this->sessionPath . '/' . $sessionId . '.json';

        if (!file_exists($sessionFile)) {
            return null;
        }

        $data = json_decode(file_get_contents($sessionFile), true);
        return is_array($data) ? $data : null;
    }
}
