<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
</head>

<body>

    <header>
        <nav>
            <a href="{{ route('page1') }}">Página 1</a>
            <a href="{{ route('page2') }}">Página 2</a>
            <a href="{{ route('page3') }}">Página 3</a>

            @if (user())
            <span>Bem-vindo, {{ user()->name }}!</span>
            @endif
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Sair</button>
            </form>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    @if (session('success'))
    <div class="success-message">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="error-message">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


</body>

</html>