<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user.view')->only(['index', 'show']);
        $this->middleware('permission:user.create')->only(['create', 'store']);
        $this->middleware('permission:user.edit')->only(['edit', 'update']);
        $this->middleware('permission:user.delete')->only(['destroy']);
    }

    public function index()
    {
        $users = User::with('roles')->latest()->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|unique:users,username|max:50',
            'nip' => 'required|string|unique:users,nip|max:18',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'nip' => $request->nip,
            'password' => $request->password, // auto hashed via cast
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')
            ->with('success', "User '{$user->name}' berhasil dibuat.");
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $userRole = $user->roles->first()?->name;

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,'.$user->id,
            'nip' => 'required|string|max:18|unique:users,nip,'.$user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'nip' => $request->nip,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => $request->password]);
        }

        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')
            ->with('success', "User '{$user->name}' berhasil diupdate.");
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('superadmin')) {
            return back()->with('error', 'User superadmin tidak dapat dihapus.');
        }

        // Cegah hapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', "User '{$user->name}' berhasil dihapus.");
    }
}
