<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AksesKms
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // 1. Akun staf tidak boleh masuk ke dashboard admin
        if ($user && ($user->peran ?? 'admin') === 'staf'
            && $request->is('admin', 'admin/*', 'dashboard')
            && ! $request->is('admin/login', 'admin/logout')) {
            return redirect()->route('kms.index');
        }

        // 2. Pedoman hanya untuk yang sudah login (staf atau admin)
        if (! $user && $request->is('pedoman', 'pedoman/*')) {
            if ($request->isMethod('GET')) {
                $request->session()->put('url.intended', $request->fullUrl());
            }
            return redirect()->route('staf.login');
        }

        return $next($request);
    }
}