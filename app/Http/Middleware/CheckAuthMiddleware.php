<?php

namespace App\Http\Middleware;

use Closure;

class CheckAuthMiddleware
{
    /**
     * Handle an incoming request.
     * Mencegah user yang sudah login (baik siswa maupun admin)
     * untuk mengakses halaman yang tidak seharusnya (misal: halaman login).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session('siswa_login')) {
            // Jika ya, arahkan kembali ke dashboard siswa
            return redirect()->route('dashboard.siswa.index');
        }

        if (session('berhasil_login')) {
            // Jika ya, arahkan kembali ke dashboard admin
            return redirect()->route('dashboard_admin');
        }

        return $next($request);
    }
}