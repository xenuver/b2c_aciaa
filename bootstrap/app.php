<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
        
        $middleware->validateCsrfTokens(except: [
            'midtrans/notification',
        ]);

        // Daftarkan middleware dengan alias 'admin'
        $middleware->alias([
            'admin' => AdminMiddleware::class,
        ]);
        
        // ========== TAMBAHKAN INI UNTUK REDIRECT SETELAH LOGIN ==========
        // Redirect jika guest (belum login) mengakses halaman yang membutuhkan auth
        $middleware->redirectGuestsTo(fn (Request $request) => route('login'));
        
        // Redirect jika user sudah login tapi mengakses halaman guest (seperti halaman login)
        $middleware->redirectUsersTo(function (Request $request) {
            $user = auth()->user();
            
            if ($user && $user->role === 'admin') {
                return route('admin.dashboard');
            }
            
            return route('home');
        });
        // ========== SAMPAI SINI ==========
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();