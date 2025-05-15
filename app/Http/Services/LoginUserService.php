<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;

class LoginUserService
{
    public function execute(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }
}
