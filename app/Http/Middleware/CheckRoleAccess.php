<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleAccess
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Memeriksa apakah pengguna sudah terotentikasi
        if (Auth::check()) {
            $user = Auth::user();

            // Memeriksa apakah peran pengguna sesuai dengan salah satu dari peran yang diperbolehkan
            foreach ($roles as $role) {
                if ($user->level == $role) {
                    // Jika peran pengguna cocok, maka izinkan akses ke rute
                    return $next($request);
                }
            }
        }

        // Jika peran pengguna tidak sesuai, kembalikan kode status 403 (Unauthorized)
        abort(403, 'Unauthorized');
    }
}
