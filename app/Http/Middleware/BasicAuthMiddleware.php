<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $username = env('BASIC_AUTH_USER');
        $password = env('BASIC_AUTH_PASSWORD');

        if (
            !isset($_SERVER['PHP_AUTH_USER']) ||
            !isset($_SERVER['PHP_AUTH_PW']) ||
            $_SERVER['PHP_AUTH_USER'] !== $username ||
            $_SERVER['PHP_AUTH_PW'] !== $password
        ) {
            header('WWW-Authenticate: Basic realm="Restrict area"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Access denied.';
            exit;
        }

        session_start();
        $notUser = !isset($_SESSION['user_id']);
        $notToken = !isset($_SESSION['token']);

        if ($notUser || $notToken) {
            return redirect()->route('login');
        }

        $user = User::find($_SESSION['user_id']);
        $validToken = $user->remember_token !== $_SESSION['token'];

        if (!$user || $validToken) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
