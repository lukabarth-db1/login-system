<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginUserService
{
    public function execute(array $credentials): bool
    {
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            session(['user_id' => $user->id]);

            return true;
        }

        return false;
    }
}
