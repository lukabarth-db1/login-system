<?php

namespace App\Http\Services;

use App\Models\UserRegistry;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create(array $data): UserRegistry
    {
        $data['password'] = Hash::make($data['password']);

        return UserRegistry::create($data);
    }
}
