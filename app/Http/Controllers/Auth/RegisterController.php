<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /** Tampilkan form register */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /** Proses register */
    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'nip' => ['required', 'string', 'max:50', 'regex:/^[0-9]+$/', 'unique:users,nip'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.regex' => 'NIP hanya boleh berisi angka.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            User::create([
                'name' => $request->username,
                'username' => $request->username,
                'nip' => $request->nip,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('login')
                ->with('success', 'Akun berhasil dibuat, silakan login.');
        } catch (\Exception $e) {
            \Log::error($e);

            return back()->withInput()
                ->withErrors(['username' => 'Gagal membuat akun, coba lagi.']);
        }
    }
}
