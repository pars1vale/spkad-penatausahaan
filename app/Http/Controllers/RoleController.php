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

    // Render halaman index — tidak perlu kirim data apapun ke view
    public function index()
    {
        return view('roles.index');
    }

    /**
     * Endpoint AJAX untuk DataTableManager.js
     * GET /roles/data  (name: roles.data)
     *
     * Format response standar DataTables:
     * { draw, recordsTotal, recordsFiltered, data[] }
     */
    public function data(Request $request)
    {
        $draw = $request->integer('draw', 1);
        $start = $request->integer('start', 0);
        $length = $request->integer('length', 10);
        $search = $request->input('search.value', '');

        // ── Base query ───────────────────────────────────────────────
        $query = Role::withCount(['permissions', 'users']);

        // ── Search global ────────────────────────────────────────────
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        // ── Sorting ──────────────────────────────────────────────────
        // Mapping index kolom DT → nama kolom DB
        // Index sesuai urutan <th> di blade:
        // 0: DT_RowIndex, 1: name, 2: permissions_count, 3: users_count, 4: action
        $columnMap = [
            1 => 'name',
        ];

        $orderColIndex = $request->integer('order.0.column', 1);
        $orderDir = in_array($request->input('order.0.dir'), ['asc', 'desc'])
            ? $request->input('order.0.dir')
            : 'asc';
        $orderCol = $columnMap[$orderColIndex] ?? 'name';

        $query->orderBy($orderCol, $orderDir);

        // ── Count ────────────────────────────────────────────────────
        $total = Role::count();
        $filtered = (clone $query)->count();

        // ── Paginate ─────────────────────────────────────────────────
        $roles = $query->skip($start)->take($length)->get();

        // ── Format baris ─────────────────────────────────────────────
        $data = $roles->map(function (Role $role, int $index) use ($start) {
            return [
                'DT_RowIndex' => $start + $index + 1,
                'name' => '<span class="badge badge-light-secondary fw-bold fs-7">'
                    .e($role->name)
                    .'</span>',
                'permissions_count' => '<span class="badge badge-light-success">'
                    .$role->permissions_count
                    .'</span>',
                'users_count' => '<span class="badge badge-light-info">'
                    .$role->users_count
                    .'</span>',
                'action' => $this->_buildAction($role),
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
    private function _buildAction(Role $role): string
    {
        // Role superadmin tidak bisa diedit / dihapus
        if ($role->name === 'superadmin') {
            return '<span class="badge badge-light-warning">Terlindungi</span>';
        }

        $edit = '<a href="'.route('roles.edit', $role).'"
            class="btn btn-icon btn-light-warning btn-sm me-1"
            data-bs-toggle="tooltip-inverse" 
            data-bs-placement="top" 
            title="Edit Role Berikut">
            <i class="ki-duotone ki-pencil fs-4">
                <span class="path1"></span><span class="path2"></span>
            </i></a>';

        // Tombol hapus — DataTableManager.js akan handle modal konfirmasi
        $delete = '<button class="btn btn-icon btn-light-danger btn-sm btn-delete"
            data-url="'.route('roles.destroy', $role).'"
            data-name="'.e($role->name).'" 
            data-bs-toggle="tooltip-inverse" 
            data-bs-placement="top" 
            title="Hapus Role Berikut">
            <i class="ki-duotone ki-trash fs-4">
                <span class="path1"></span><span class="path2"></span>
                <span class="path3"></span><span class="path4"></span>
                <span class="path5"></span>
            </i></button>';

        return '<div class="d-flex">'.$edit.$delete.'</div>';
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(fn ($p) => explode('.', $p->name)[0]);

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
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')
            ->with('success', "Role '{$role->name}' berhasil dibuat.");
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(fn ($p) => explode('.', $p->name)[0]);
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        if ($role->name === 'superadmin') {
            return back()->with('error', 'Role superadmin tidak dapat diubah.');
        }

        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name,'.$role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

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
            return back()->with(
                'error',
                "Role '{$role->name}' masih digunakan oleh {$role->users()->count()} user."
            );
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', "Role '{$role->name}' berhasil dihapus.");
    }
}
