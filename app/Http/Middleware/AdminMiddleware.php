<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté');
        }

        // Vérifier si l'utilisateur est le premier utilisateur (admin)
        // OU vous pouvez ajouter un champ is_admin dans la table users
        if (Auth::id() == 1) {
            return $next($request);
        }

        // Rediriger les non-admins
        return redirect()->route('dashboard')->with('error', 'Accès réservé aux administrateurs');
    }
}