<?php

namespace App\Http\Middleware;

use Closure;

class SiswaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!session('siswa_login')){
            return redirect('/')->with("akses", "Gagal");
        }
        return $next($request);
    }
}
