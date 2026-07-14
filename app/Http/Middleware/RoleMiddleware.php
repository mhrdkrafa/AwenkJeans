<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user() || !$request->user()->role) {
            abort(403, 'Unauthorized.');
        }

        $userRole = $request->user()->role->name;

        if (!in_array($userRole, $roles)) {
            // Redirect to appropriate dashboard based on role
            if ($userRole === 'administrator') {
                return redirect()->route('administrator.dashboard');
            } elseif ($userRole === 'karyawan') {
                return redirect()->route('karyawan.dashboard');
            } elseif ($userRole === 'kasir') {
                return redirect()->route('kasir.dashboard');
            } elseif ($userRole === 'owner') {
                return redirect()->route('owner.dashboard');
            } elseif ($userRole === 'pelanggan') {
                return redirect()->route('catalog.index');
            }

            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
