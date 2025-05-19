<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

        return $next($request);
    }
}
