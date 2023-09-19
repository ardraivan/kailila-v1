<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPasswordChanged
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user adalah therapist atau admin
        if (auth()->check() && in_array(auth()->user()->role->name, ['therapist', 'admin', 'superadmin'])) {
            // Cek apakah password telah diubah
            $currentPassword = auth()->user()->password;
            if (auth()->user()->wasChanged('password')) {
                // Jika password telah diubah, logout user dan redirect ke halaman login
                auth()->logout();
                return redirect()->route('login')->with('info', 'Your password has been changed. Please login again.');
            }
        }

        return $next($request);
    }
}
