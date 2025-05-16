@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<h2>Login</h2>

<!-- action="{{ route('login') }}" action definida dentro do arquivo "web.php" -->
<div class="register-form">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Senha:</label><br>
        <input type="password" name="password" id="password" required><br><br>

        <button class="button-submit" type="submit">Entrar</button>
    </form>
</div>
@endsection