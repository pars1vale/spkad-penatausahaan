<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
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

    // Render halaman index — view tidak butuh data apapun
    public function index()
    {
        return view('users.index');
    }

    /**
     * Endpoint AJAX untuk DataTableManager.js
     * GET /users/data
     *
     * Mengembalikan format JSON standar DataTables:
     * { draw, recordsTotal, recordsFiltered, data[] }
     */
    public function data(Request $request)
    {
        $draw = $request->integer('draw', 1);
        $start = $request->integer('start', 0);
        $length = $request->integer('length', 10);
        $search = $request->input('search.value', '');

        // ── Base query ───────────────────────────────────────────────
        $query = User::with('roles');

        // ── Search global ────────────────────────────────────────────
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        // ── Sorting ──────────────────────────────────────────────────
        $columnMap = [
            1 => 'name',
            2 => 'username',
            3 => 'nip',
        ];

        $orderColIndex = $request->integer('order.0.column', 1);
        $orderDir = $request->input('order.0.dir', 'asc');
        $orderCol = $columnMap[$orderColIndex] ?? 'name';

        $query->orderBy($orderCol, $orderDir);

        // ── Count ────────────────────────────────────────────────────
        $total = User::count();
        $filtered = $query->count();

        // ── Paginate ─────────────────────────────────────────────────
        $users = $query->skip($start)->take($length)->get();

        // ── Format data ──────────────────────────────────────────────
        $data = $users->map(function ($user, $index) use ($start) {
            // Tombol aksi
            $action = $this->_buildAction($user);

            // Badge role
            $role = $user->roles->map(
                fn ($r) => '<span class="badge badge-light-primary fw-bold">'.e($r->name).'</span>'
            )->implode(' ') ?: '<span class="text-muted">-</span>';

            return [
                'DT_RowIndex' => $start + $index + 1,
                'name' => '<span class="text-gray-800 fw-bold">'.e($user->name).'</span>',
                'username' => '<span class="text-gray-600 fw-semibold font-monospace">'.e($user->username).'</span>',
                'nip' => e($user->nip),
                'role' => $role,
                'last_login' => $user->last_login
                    ? $user->last_login->format('d/m/Y H:i')
                    : '<span class="text-muted">-</span>',
                'action' => $action,
            ];
        });

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data,
        ]);
    }

    // ── Builder tombol aksi per baris ────────────────────────────────
    private function _buildAction(User $user): string
    {
        $btn = '';

        if (auth()->user()->can('user.edit')) {
            $btn .= '<a href="'.route('users.edit', $user).'"
                class="btn btn-icon btn-light-warning btn-sm me-1" title="Edit">
                <i class="ki-duotone ki-pencil fs-4">
                    <span class="path1"></span><span class="path2"></span>
                </i></a>';
        }

        if (auth()->user()->hasRole('superadmin')) {
            $btn .= '<a href="'.route('users.permissions', $user).'"
                class="btn btn-icon btn-light-info btn-sm me-1" title="Permission">
                <i class="ki-duotone ki-shield-tick fs-4">
                    <span class="path1"></span><span class="path2"></span>
                </i></a>';
        }

        if (
            auth()->user()->can('user.delete')
            && ! $user->hasRole('superadmin')
            && $user->id !== auth()->id()
        ) {
            $btn .= '<button class="btn btn-icon btn-light-danger btn-sm btn-delete"
                data-url="'.route('users.destroy', $user).'"
                data-name="'.e($user->name).'" title="Hapus">
                <i class="ki-duotone ki-trash fs-4">
                    <span class="path1"></span><span class="path2"></span>
                    <span class="path3"></span><span class="path4"></span>
                    <span class="path5"></span>
                </i></button>';
        }

        return '<div class="d-flex">'.$btn.'</div>';
    }

    public function create()
    {
        return view('users.create', ['roles' => Role::all()]);
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
            'password' => $request->password,
        ]);
        $user->assignRole($request->role);

        return redirect()->route('users.index')
            ->with('success', "User '{$user->name}' berhasil dibuat.");
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'roles' => Role::all(),
            'userRole' => $user->roles->first()?->name,
        ]);
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
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', "User '{$user->name}' berhasil dihapus.");
    }

    public function editPermissions(User $user)
    {
        $permissions = Permission::all()->groupBy(fn ($p) => explode('.', $p->name)[0]);
        $directPermissions = $user->getDirectPermissions()->pluck('name')->toArray();
        $rolePermissions = $user->getPermissionsViaRoles()->pluck('name')->toArray();

        return view('users.permissions', compact('user', 'permissions', 'directPermissions', 'rolePermissions'));
    }

    public function updatePermissions(Request $request, User $user)
    {
        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('users.index')
            ->with('success', "Permission user '{$user->name}' berhasil diupdate.");
    }
}
