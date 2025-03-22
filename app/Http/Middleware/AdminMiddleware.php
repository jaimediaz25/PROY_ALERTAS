<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (session('user.rol') !== 'admin') {
            return redirect('/home')->with('error', 'No tienes permisos de administrador');
        }

        return $next($request);
    }
}
