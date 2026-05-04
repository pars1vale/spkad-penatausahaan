<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class EnsureTahunAnggaranSelected
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && ! session()->has('tahun_anggaran')) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['username' => 'Sesi habis, silakan login ulang.']);
        }

        return $next($request);
    }
}
