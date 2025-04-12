<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Periksa apakah pengguna memiliki salah satu peran yang diberikan
        if (! in_array($request->user()->role, $roles)) {
            return back()->withErrors('Akun tidak memiliki akses');
        }

        return $next($request);
    }
}
