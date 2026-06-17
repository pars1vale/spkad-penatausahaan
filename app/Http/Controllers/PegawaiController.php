<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pegawai.view')->only(['index', 'data']);
        $this->middleware('permission:pegawai.create')->only(['create', 'store']);
        $this->middleware('permission:pegawai.edit')->only(['edit', 'update']);
        $this->middleware('permission:pegawai.delete')->only(['destroy']);
    }

    public function index()
    {
        return view('pegawai.index');
    }

    public function data(Request $request)
    {
        $draw = (int) $request->input('draw', 1);
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        $search = $request->input('search.value', '');
        $orderCol = (int) $request->input('order.0.column', 1);
        $orderDir = $request->input('order.0.dir', 'asc');

        $columns = ['id', 'nama_user', 'nama_role'];

        $query = Pegawai::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_user', 'like', "%{$search}%")
                    ->orWhere('nama_role', 'like', "%{$search}%")
                    ->orWhere('nip_user', 'like', "%{$search}%");
            });
        }

        $total = Pegawai::count();
        $filtered = $query->count();

        $sortColumn = $columns[$orderCol] ?? 'nama_user';
        $items = $query->orderBy($sortColumn, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        $data = $items->map(function (Pegawai $item, int $index) use ($start) {
            return [
                'DT_RowIndex' => $start + $index + 1,
                'nama_user' => $this->_renderNamaUser($item),
                'nama_role' => $this->_renderNamaRole($item),
                'action' => $this->_buildAction($item),
            ];
        });

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data,
        ]);
    }

    public function create()
    {
        return view('pegawai.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pegawai' => 'required|integer|unique:pegawai,id_pegawai',
            'id_daerah' => 'nullable|integer',
            'id_skpd' => 'nullable|integer',
            'id_user' => 'nullable|integer',
            'id_role' => 'nullable|integer',
            'nama_role' => 'nullable|string|max:100',
            'tahun_pegawai' => 'nullable|integer',
            'id_pegawai_kpa' => 'nullable|integer',
            'status' => 'nullable|string|max:20',
            'id_pegawai_ref' => 'nullable|string|max:20',
            'id_user_kpa' => 'nullable|integer',
            'nama_user' => 'required|string|max:255',
            'nip_user' => 'nullable|string|max:50',
        ]);

        Pegawai::create($validated);

        return redirect()->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function show(Pegawai $pegawai)
    {
        return view('pegawai.show', compact('pegawai'));
    }

    public function edit(Pegawai $pegawai)
    {
        return view('pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'id_pegawai' => 'required|integer|unique:pegawai,id_pegawai,'.$pegawai->id,
            'id_daerah' => 'nullable|integer',
            'id_skpd' => 'nullable|integer',
            'id_user' => 'nullable|integer',
            'id_role' => 'nullable|integer',
            'nama_role' => 'nullable|string|max:100',
            'tahun_pegawai' => 'nullable|integer',
            'id_pegawai_kpa' => 'nullable|integer',
            'status' => 'nullable|string|max:20',
            'id_pegawai_ref' => 'nullable|string|max:20',
            'id_user_kpa' => 'nullable|integer',
            'nama_user' => 'required|string|max:255',
            'nip_user' => 'nullable|string|max:50',
        ]);

        $pegawai->update($validated);

        return redirect()->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();

        return redirect()->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil dihapus.');
    }

    // -------------------------------------------------------------------------
    // Private render helpers
    // -------------------------------------------------------------------------

    private function _renderNamaUser(Pegawai $item): string
    {
        $nip = $item->nip_user
            ? '<span class="text-muted fs-7 d-block">'.e($item->nip_user).'</span>'
            : '';

        return '<span class="fw-bold">'.e($item->nama_user).'</span>'.$nip;
    }

    private function _renderNamaRole(Pegawai $item): string
    {
        return $item->nama_role
            ? '<span class="badge badge-light-info">'.e($item->nama_role).'</span>'
            : '<span class="text-muted">—</span>';
    }

    private function _buildAction(Pegawai $item): string
    {
        $editUrl = route('pegawai.edit', $item->id);
        $deleteUrl = route('pegawai.destroy', $item->id);
        $name = e($item->nama_user);

        $editBtn = '';
        $deleteBtn = '';

        if (auth()->user()->can('pegawai.edit')) {
            $editBtn = '
                <a href="'.$editUrl.'" class="btn btn-icon btn-sm btn-light-warning" title="Edit">
                    <i class="ki-duotone ki-pencil fs-4">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                </a>';
        }

        if (auth()->user()->can('pegawai.delete')) {
            $deleteBtn = '
                <button type="button"
                        class="btn btn-icon btn-sm btn-light-danger btn-delete"
                        data-url="'.$deleteUrl.'"
                        data-name="'.$name.'"
                        title="Hapus">
                    <i class="ki-duotone ki-trash fs-4">
                        <span class="path1"></span><span class="path2"></span>
                        <span class="path3"></span><span class="path4"></span><span class="path5"></span>
                    </i>
                </button>';
        }

        return '<div class="d-flex gap-1">'.$editBtn.$deleteBtn.'</div>';
    }
}
