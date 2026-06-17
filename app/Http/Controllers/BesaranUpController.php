<?php

namespace App\Http\Controllers;

use App\Models\BesaranUp;
use Illuminate\Http\Request;

class BesaranUpController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:besaran-up.view')->only(['index', 'data']);
        $this->middleware('permission:besaran-up.create')->only(['create', 'store']);
        $this->middleware('permission:besaran-up.edit')->only(['edit', 'update']);
        $this->middleware('permission:besaran-up.delete')->only(['destroy']);
    }

    public function index()
    {
        return view('besaranup.index');
    }

    public function data(Request $request)
    {
        $draw = (int) $request->input('draw', 1);
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        $search = $request->input('search.value', '');
        $orderCol = (int) $request->input('order.0.column', 1);
        $orderDir = $request->input('order.0.dir', 'asc');

        $columns = ['id', 'nama_skpd', 'pagu', 'besaran_up', 'besaran_up_kkpd'];

        $query = BesaranUp::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_skpd', 'like', "%{$search}%")
                    ->orWhere('kode_skpd', 'like', "%{$search}%");
            });
        }

        $total = BesaranUp::count();
        $filtered = $query->count();

        $sortColumn = $columns[$orderCol] ?? 'nama_skpd';
        $items = $query->orderBy($sortColumn, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        $data = $items->map(function (BesaranUp $item, int $index) use ($start) {
            return [
                'DT_RowIndex' => $start + $index + 1,
                'nama_skpd' => $item->nama_skpd,
                'pagu' => $this->_renderPagu($item),
                'besaran_up' => $this->_renderBesaranUp($item),
                'besaran_up_kkpd' => $this->_renderBesaranUpKkpd($item),
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
        return view('besaran-up.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_besaran_up' => 'nullable|integer',
            'id_daerah' => 'nullable|integer',
            'tahun' => 'nullable|integer',
            'id_unit' => 'nullable|integer',
            'id_skpd' => 'nullable|integer',
            'id_sub_skpd' => 'nullable|integer|unique:besaran_up,id_sub_skpd',
            'kode_skpd' => 'nullable|string|max:50',
            'nama_skpd' => 'required|string|max:255',
            'pagu' => 'required|integer|min:0',
            'besaran_up' => 'required|integer|min:0',
            'besaran_up_kkpd' => 'required|integer|min:0',
        ]);

        BesaranUp::create($validated);

        return redirect()->route('besaran-up.index')
            ->with('success', 'Data Besaran UP berhasil ditambahkan.');
    }

    public function show(BesaranUp $besaranUp)
    {
        return view('besaran-up.show', compact('besaranUp'));
    }

    public function edit(BesaranUp $besaranUp)
    {
        return view('besaran-up.edit', compact('besaranUp'));
    }

    public function update(Request $request, BesaranUp $besaranUp)
    {
        $validated = $request->validate([
            'id_besaran_up' => 'nullable|integer',
            'id_daerah' => 'nullable|integer',
            'tahun' => 'nullable|integer',
            'id_unit' => 'nullable|integer',
            'id_skpd' => 'nullable|integer',
            'id_sub_skpd' => 'nullable|integer|unique:besaran_up,id_sub_skpd,'.$besaranUp->id,
            'kode_skpd' => 'nullable|string|max:50',
            'nama_skpd' => 'required|string|max:255',
            'pagu' => 'required|integer|min:0',
            'besaran_up' => 'required|integer|min:0',
            'besaran_up_kkpd' => 'required|integer|min:0',
        ]);

        $besaranUp->update($validated);

        return redirect()->route('besaran-up.index')
            ->with('success', 'Data Besaran UP berhasil diperbarui.');
    }

    public function destroy(BesaranUp $besaranUp)
    {
        $besaranUp->delete();

        return redirect()->route('besaran-up.index')
            ->with('success', 'Data Besaran UP berhasil dihapus.');
    }

    // -------------------------------------------------------------------------
    // Private render helpers
    // -------------------------------------------------------------------------

    private function _renderPagu(BesaranUp $item): string
    {
        return '<span class="text-end d-block">'.$item->pagu_format.'</span>';
    }

    private function _renderBesaranUp(BesaranUp $item): string
    {
        return '
            <div class="d-flex flex-column align-items-end">
                <span>'.$item->besaran_up_format.'</span>
                <span class="badge badge-light-primary mt-1">'.$item->persentase_up.'</span>
            </div>';
    }

    private function _renderBesaranUpKkpd(BesaranUp $item): string
    {
        return '
            <div class="d-flex flex-column align-items-end">
                <span>'.$item->besaran_up_kkpd_format.'</span>
                <span class="badge badge-light-success mt-1">'.$item->persentase_up_kkpd.'</span>
            </div>';
    }

    private function _buildAction(BesaranUp $item): string
    {
        $editUrl = route('besaran-up.edit', $item->id);
        $deleteUrl = route('besaran-up.destroy', $item->id);
        $name = e($item->nama_skpd);

        $editBtn = '';
        $deleteBtn = '';

        if (auth()->user()->can('besaran-up.edit')) {
            $editBtn = '
                <a href="'.$editUrl.'" class="btn btn-icon btn-sm btn-light-warning" title="Edit">
                    <i class="ki-duotone ki-pencil fs-4">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                </a>';
        }

        if (auth()->user()->can('besaran-up.delete')) {
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
