<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterUserService
{
    public function create(array $data): User
    {
        // Serviço responsável por criar novos usuários no banco de dados a partir da classe Model
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Armazena user_id na sessão para manter o usuário autenticado
        session(['user_id' => $user->id]);

        return $user;
    }
}
