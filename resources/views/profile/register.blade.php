@extends('layouts.guest')

@section('title', 'Registro')

@section('content')
<h2>Cadastro</h2>

<form action="{{ route('register') }}" method="POST">
    @csrf
    <div class="register-form">
        <div>
            <label for="name">Nome:</label><br>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label for="email">E-mail:</label><br>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label for="password">Senha:</label><br>
            <input type="password" name="password" id="password" required>
        </div>

        <div>
            <label for="password_confirmation">Confirme a senha:</label><br>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <button class="button-submit" type="submit">Cadastrar</button>
    </div>
</form>

<div class="footer">
    <p>
        Já tem uma conta? <a href="{{ route('login') }}">Faça login</a>
    </p>
</div>
@endsection