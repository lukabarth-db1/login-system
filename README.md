## Login system

### 🧭 Rotas nomeadas com Laravel
1. ``web.php`` define a URL, o método HTTP e o nome da rota.

2. ``AuthController`` define a lógica que deve acontecer quando aquela rota for acessada.

3. ``route('login')`` no Blade resolve para a URL da rota nomeada (neste caso, /login).
___

### 🧪 Exemplo de fluxo completo com Blade
1. ``register.blade.php`` estende `layouts.guest`

2. Dentro de ``layouts.guest``, há ``@yield('content')`` → Blade substitui pelo conteúdo da seção definida na view filha

3. Formulário envia para a rota register via ``{{ route('register') }}``
4. Rota mapeia para o método ``register()`` do ``AuthController``

5. Dados são processados, e caso haja sucesso ou erro, são exibidos no próprio layout com ``session('success')`` ou ``$errors``
___

### 🔐 Como funciona a autenticação no Laravel
O Laravel oferece um sistema de autenticação completo e seguro, pronto para uso, que pode ser usado tanto com sessões quanto com tokens (para APIs).

✅ Nessa aplicação (aplicação com Blade e sessões)
Está sendo usado o sistema de autenticação baseado em sessão, que funciona assim:

### ⚙️ Fluxo da autenticação baseada em sessão
1. **Formulário de login**
- O usuário insere e envia email e senha
- O formulário envia os dados via POST para a rota login

2. **Controller chama o serviço**
- O ``AuthController`` chama ``LoginUserService``, que usa:
```php
Auth::attempt($credentials);
```
- Isso valida se o email existe e se a senha bate com a hash do banco de dados.

3. **Sessão iniciada**
- Se as credenciais forem válidas, o Laravel autentica o usuário e armazena seu ID na sessão, com um cookie no navegador.

4. **Middleware** ``auth``
- Quando o usuário tenta acessar páginas protegidas (``/page1``, ``/page2`` etc.), o middleware auth verifica se há um usuário autenticado.
- Se sim, carrega a página. Se não, redireciona para a tela de login.

5. **Logout**
- Quando o usuário clica em "Sair", o método ``logout()`` limpa a sessão e redireciona para o login.

### 🔍 Funções principais usadas
- ``Auth::attempt($credentials)`` – Tenta autenticar o usuário.

- ``Auth::check()`` – Verifica se alguém está logado.

- ``Auth::user()`` – Retorna o usuário autenticado.

- ``Auth::logout()`` – Desloga o usuário e invalida a sessão.