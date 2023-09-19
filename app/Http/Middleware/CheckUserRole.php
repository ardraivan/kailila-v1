<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Check if the user is authenticated and has a role assigned
        if (!$user || !$user->role || !$user->hasRole($roles)) {
            $allowedRoles = implode(' or ', $roles);
            $errorMessage = "Only users with roles $allowedRoles can perform this action. Please log in with the appropriate role.";
            return back()->with('error', $errorMessage);
        }

        return $next($request);
    }
}
