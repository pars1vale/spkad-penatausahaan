<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadmin');
    }

    public function index()
    {
        $roles = Role::withCount('permissions')->get();

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($item) {
            return explode('.', $item->name)[0]; // group by prefix: user, role, dst
        });

        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name|max:50',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')
            ->with('success', "Role '{$role->name}' berhasil dibuat.");
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function ($item) {
            return explode('.', $item->name)[0];
        });
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name,'.$role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        // Proteksi: nama superadmin tidak boleh diubah
        if ($role->name === 'superadmin') {
            return back()->with('error', 'Role superadmin tidak dapat diubah.');
        }

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')
            ->with('success', "Role '{$role->name}' berhasil diupdate.");
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'superadmin') {
            return back()->with('error', 'Role superadmin tidak dapat dihapus.');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', "Role '{$role->name}' masih digunakan oleh {$role->users()->count()} user.");
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', "Role '{$role->name}' berhasil dihapus.");
    }
}
