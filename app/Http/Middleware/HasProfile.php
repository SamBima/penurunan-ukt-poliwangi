<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;

class HasProfile
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->role == 'mahasiswa') {
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

            if (!$mahasiswa) {
                return redirect()->route('profile')
                    ->with('warning', 'Silakan lengkapi data profil Anda terlebih dahulu.');
            }
        }

        return $next($request);
    }
}
