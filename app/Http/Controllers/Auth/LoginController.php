<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /** Tampilkan form login */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /** Proses login */
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'tahun_anggaran' => ['required', 'integer', 'min:2020', 'max:2099'],
        ], [
            'username.required' => 'Username atau NIP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'tahun_anggaran.required' => 'Tahun anggaran wajib dipilih.',
        ]);

        // Cari user by username ATAU nip
        $user = User::where('username', $request->username)
            ->orWhere('nip', $request->username)
            ->first();

        if (! $user) {
            return back()->withInput()
                ->withErrors(['username' => 'Username atau NIP tidak ditemukan.']);
        }

        if (Auth::attempt(['username' => $user->username, 'password' => $request->password], $request->boolean('remember'))) {

            $request->session()->regenerate();

            // Simpan session
            session([
                'user_id' => $user->id,
                'username' => $user->username,
                'nip' => $user->nip,
                'tahun_anggaran' => (int) $request->tahun_anggaran,
            ]);

            // Update last login
            $user->update(['last_login' => Carbon::now()]);

            return redirect()->route('home');
        }

        return back()->withInput()
            ->withErrors(['password' => 'Password salah.']);
    }

    /** Logout */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
