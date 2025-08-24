<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        $rolesToCheck = explode(':', $roles);

        if (Auth::check()) {
            foreach ($rolesToCheck as $r) {
                if (Auth::user()->role === trim($r)) {
                    return $next($request);
                }
            }
        }

        abort(403, 'Nemate pristup ovoj stranici.');
    }
}
