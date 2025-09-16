<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = Auth::user()->role;
        
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Redirect berdasarkan role user
        if ($userRole === 'superadmin') {
            return redirect('/superadmin');
        } elseif ($userRole === 'admin') {
            return redirect('/admin');
        }

        return redirect('/')->with('error', 'Akses ditolak.');
    }
}