<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AksesKms
{
    // true  = akun staf otomatis keluar begitu membuka halaman di luar Pedoman
    // false = akun staf tetap login sampai menekan Keluar atau menutup browser
    private const KELUAR_SAAT_PINDAH = true; // KELUAR_SAAT_PINDAH

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $staf = $user && ($user->peran ?? 'admin') === 'staf';

        // Staf yang meninggalkan area Pedoman otomatis dikeluarkan
        if ($staf && self::KELUAR_SAAT_PINDAH && $request->isMethod('GET')
            && ! $request->is('pedoman', 'pedoman/*', 'login-staf')) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $user = null;
            $staf = false;
            if ($request->is('admin', 'admin/*', 'dashboard')) {
                return redirect()->route('kms.index');
            }
        }

        // Akun staf tidak boleh masuk ke dashboard admin
        if ($staf && $request->is('admin', 'admin/*', 'dashboard')
            && ! $request->is('admin/login', 'admin/logout')) {
            return redirect()->route('kms.index');
        }

        // Pedoman hanya untuk yang sudah login (staf atau admin)
        if (! $user && $request->is('pedoman', 'pedoman/*')) {
            if ($request->isMethod('GET')) {
                $request->session()->put('url.intended', $request->fullUrl());
            }
            return redirect()->route('staf.login');
        }

        return $next($request);
    }
}