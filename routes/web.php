<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Este arquivo define as rotas web da aplicação Laravel, separando as rotas públicas (login e registro) das rotas protegidas (páginas privadas acessíveis somente por usuários autenticados)

Route::get('/register', [AuthController::class, 'showRegister'])->name('register'); // Nomeando a rota "register" e definindo qual método dentro do "AuthController" será chamado ao bater nessa rota
Route::post('/register', [AuthController::class, 'register']); // valida, salva e loga o usuário

Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); // Nomeando a rota "login" e definindo qual método dentro do "AuthController" será chamado ao bater nessa rota
Route::post('/login', [AuthController::class, 'login']); // processa os dados do formulário e faz login

Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // faz logout do usuário e finaliza a sessão

// Agrupa as rotas protegidas pelo middleware 'auth'
Route::middleware('auth')->group(function () {
    Route::view('/page1', 'profile.page1')->name('page1');
    Route::view('/page2', 'profile.page2')->name('page2');
    Route::view('/page3', 'profile.page3')->name('page3');
});
