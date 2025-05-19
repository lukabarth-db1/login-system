<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Services\RegisterUserService;
use Illuminate\Http\Request;
use App\Http\Services\LoginUserService;
use App\Http\Services\LogoutUserService;

class AuthController extends Controller
{
    public function showRegister()
    {
        // Problema que resolve: Permite o acesso à interface de criação de conta para novos usuários

        // Função: Retorna a view que contém o formulário de cadastro
        return view('profile.register');
    }

    public function register(StoreUserRequest $request, RegisterUserService $service)
    {
        // Problema que resolve: Trata o fluxo de cadastro de forma segura e desacoplada (usando service e form request)

        // Valida os dados do formulário
        $validated = $request->validated();

        // Cria o usuário no banco de dados
        $service->create($validated);

        // Flash message de sucesso no cadastro e redireciona para a primeira página protegida
        return redirect()->route('page1')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function showLogin()
    {
        // Problema que resolve: Permite o usuário inserir suas credenciais para acessar áreas protegidas

        // Exibe a tela de login
        return view('profile.login');
    }

    public function login(LoginUserRequest $request, LoginUserService $service)
    {
        // Problema que resolve: Faz login seguro e limpo, separado por responsabilidade (request + service)

        // Extrai os dados validados do formulário de login
        $credentials = $request->only('email', 'password');

        // Tenta autenticar o usuário usando o serviço de login
        $authenticated = $service->execute($credentials);

        if ($authenticated) {
            // Regera sessão para evitar ataques de sessão fixa
            $request->session()->regenerate();

            // Redireciona o usuário para a 'page1'
            return redirect()->intended('page1')->with('success', 'Login realizado com sucesso!');
        }

        // Caso falhe a autenticação, será retornado mensagem de erro
        return back()->withErrors(['email' => 'Credenciais inválidas.']);
    }

    public function logout(Request $request, LogoutUserService $service)
    {
        // Problema que resolve: Encapsula a lógica de logout e limpa a sessão corretamente

        // Executa o serviço de logout
        $service->execute($request);

        // Flash message de sucesso no logout
        return redirect('/login')->with('success', 'Você saiu com sucesso.');
    }
}
