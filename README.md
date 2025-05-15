## Login system

### 🧭 Rotas nomeadas com Laravel
1. web.php define a URL, o método HTTP e o nome da rota.

2. AuthController define a lógica que deve acontecer quando aquela rota for acessada.

3. route('login') no Blade resolve para a URL da rota nomeada (neste caso, /login).
___

### 🧪 Exemplo de fluxo completo com Blade
1. register.blade.php estende layouts.guest

2. Dentro de layouts.guest, há @yield('content') → Blade substitui pelo conteúdo da seção definida na view filha

3. Formulário envia para a rota register via {{ route('register') }}
4. Rota mapeia para o método register() do AuthController

5. Dados são processados, e caso haja sucesso ou erro, são exibidos no próprio layout com session('success') ou $errors
