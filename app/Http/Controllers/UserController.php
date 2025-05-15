<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Services\RegisterUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected RegisterUserService $userService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Problema que resolve: Permite criar usuários via API de forma segura e organizada

        // Valida os dados de entrada vindos de "StoreUserRequest"
        $validatedRequest = $request->validated();

        // Cria o usuário chamando o método de "RegisterUserService"
        $user = $this->userService->create($validatedRequest);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
