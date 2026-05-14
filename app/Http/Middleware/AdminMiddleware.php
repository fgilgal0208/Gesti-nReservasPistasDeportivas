<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
        {
            // Si no está autenticado o no es admin, lo echamos al dashboard normal
            if (!auth()->check() || !auth()->user()->is_admin) {
                abort(403, 'Acceso denegado. Área exclusiva para personal del Ayuntamiento.');
            }

            return $next($request);
        }
}
