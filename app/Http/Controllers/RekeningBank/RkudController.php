<?php

namespace App\Http\Controllers\RekeningBank;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\JenisRkud;
use App\Models\RekeningBank\Rkud;
use Illuminate\Http\Request;

class RkudController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:rkud.view')->only(['index', 'data']);
        $this->middleware('permission:rkud.create')->only(['create', 'store']);
        $this->middleware('permission:rkud.edit')->only(['edit', 'update']);
        $this->middleware('permission:rkud.delete')->only(['destroy']);
    }

    // Render halaman index — view tidak butuh data apapun
    public function index()
    {
        return view('rekeningbank.rkud.index');
    }

    /**
     * Endpoint AJAX untuk DataTableManager.js
     * GET /rekening-bank/rkud/data  (name: rkud.data)
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
        $query = Rkud::with(['bank', 'jenisRkud']);

        // ── Search global ────────────────────────────────────────────
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_rekening', 'like', "%{$search}%")
                    ->orWhere('nama_rekening', 'like', "%{$search}%")
                    ->orWhereHas(
                        'bank',
                        fn ($b) => $b->where('nama_bank', 'like', "%{$search}%")
                    )
                    ->orWhereHas(
                        'jenisRkud',
                        fn ($j) => $j->where('nama_jenis_rkud', 'like', "%{$search}%")
                    );
            });
        }

        // ── Sorting ──────────────────────────────────────────────────
        // Mapping index kolom DT → nama kolom DB
        // 0: DT_RowIndex, 1: no_rekening, 2: nama_rekening, 3: bank, 4: jenis_rkud, 5: status, 6: action
        $columnMap = [
            1 => 'no_rekening',
            2 => 'nama_rekening',
        ];

        $orderColIndex = $request->integer('order.0.column', 1);
        $orderDir = in_array($request->input('order.0.dir'), ['asc', 'desc'])
            ? $request->input('order.0.dir')
            : 'asc';
        $orderCol = $columnMap[$orderColIndex] ?? 'no_rekening';

        $query->orderBy($orderCol, $orderDir);

        // ── Count ────────────────────────────────────────────────────
        $total = Rkud::count();
        $filtered = (clone $query)->count();

        // ── Paginate ─────────────────────────────────────────────────
        $rkuds = $query->skip($start)->take($length)->get();

        // ── Format baris ─────────────────────────────────────────────
        $data = $rkuds->map(function (Rkud $rkud, int $index) use ($start) {
            return [
                'DT_RowIndex' => $start + $index + 1,
                'no_rekening' => '<span class="text-gray-800 fw-bold font-monospace">'
                    .e($rkud->no_rekening)
                    .'</span>',
                'nama_rekening' => '<span class="text-gray-800 fw-bold">'
                    .e($rkud->nama_rekening)
                    .'</span>',
                'bank' => $rkud->bank
                    ? '<span class="text-gray-700">'.e($rkud->bank->nama_bank).'</span>'
                    : '<span class="text-muted">-</span>',
                'jenis_rkud' => $rkud->jenisRkud
                    ? '<span class="badge badge-light-primary">'
                    .e($rkud->jenisRkud->nama_jenis_rkud)
                    .'</span>'
                    : '<span class="text-muted">-</span>',
                'status' => $rkud->is_locked
                    ? '<span class="badge badge-light-danger">Terkunci</span>'
                    : '<span class="badge badge-light-success">Aktif</span>',
                'action' => $this->_buildAction($rkud),
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
    private function _buildAction(Rkud $rkud): string
    {
        $btn = '';

        if (auth()->user()->can('rkud.edit')) {
            $btn .= '<a href="'.route('rkud.edit', $rkud).'"
                class="btn btn-icon btn-light-warning btn-sm me-1" title="Edit RKUD">
                <i class="ki-duotone ki-pencil fs-4">
                    <span class="path1"></span><span class="path2"></span>
                </i></a>';
        }

        if (auth()->user()->can('rkud.delete') && ! $rkud->is_locked) {
            $btn .= '<button class="btn btn-icon btn-light-danger btn-sm btn-delete"
                data-url="'.route('rkud.destroy', $rkud).'"
                data-name="'.e($rkud->nama_rekening).'"
                title="Hapus RKUD">
                <i class="ki-duotone ki-trash fs-4">
                    <span class="path1"></span><span class="path2"></span>
                    <span class="path3"></span><span class="path4"></span>
                    <span class="path5"></span>
                </i></button>';
        }

        // Jika rekening terkunci, tampilkan indikator
        if ($rkud->is_locked) {
            $btn .= '<span class="btn btn-icon btn-light-secondary btn-sm" title="Rekening terkunci">
                <i class="ki-duotone ki-lock fs-4">
                    <span class="path1"></span><span class="path2"></span>
                </i></span>';
        }

        return '<div class="d-flex">'.$btn.'</div>';
    }

    public function create()
    {
        $banks = Bank::orderBy('nama_bank')->get();
        $jenisRkuds = JenisRkud::orderBy('nama_jenis_rkud')->get();

        return view('rekening-bank.rkud.create', compact('banks', 'jenisRkuds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bank' => 'required|exists:banks,id_bank',
            'id_jenis_rkud' => 'required|exists:jenis_rkud,id_jenis_rkud',
            'no_rekening' => 'required|string|unique:rkud,no_rekening|max:50',
            'nama_rekening' => 'required|string|max:100',
        ]);

        $rkud = Rkud::create([
            'id_bank' => $request->id_bank,
            'id_jenis_rkud' => $request->id_jenis_rkud,
            'no_rekening' => $request->no_rekening,
            'nama_rekening' => $request->nama_rekening,
            'is_locked' => false,
        ]);

        return redirect()->route('rkud.index')
            ->with('success', "RKUD '{$rkud->nama_rekening}' berhasil dibuat.");
    }

    public function edit(Rkud $rkud)
    {
        if ($rkud->is_locked) {
            return back()->with('error', 'Rekening ini terkunci dan tidak dapat diedit.');
        }

        $banks = Bank::orderBy('nama_bank')->get();
        $jenisRkuds = JenisRkud::orderBy('nama_jenis_rkud')->get();

        return view('rekening-bank.rkud.edit', compact('rkud', 'banks', 'jenisRkuds'));
    }

    public function update(Request $request, Rkud $rkud)
    {
        if ($rkud->is_locked) {
            return back()->with('error', 'Rekening ini terkunci dan tidak dapat diedit.');
        }

        $request->validate([
            'id_bank' => 'required|exists:banks,id_bank',
            'id_jenis_rkud' => 'required|exists:jenis_rkud,id_jenis_rkud',
            'no_rekening' => 'required|string|max:50|unique:rkud,no_rekening,'.$rkud->id,
            'nama_rekening' => 'required|string|max:100',
        ]);

        $rkud->update([
            'id_bank' => $request->id_bank,
            'id_jenis_rkud' => $request->id_jenis_rkud,
            'no_rekening' => $request->no_rekening,
            'nama_rekening' => $request->nama_rekening,
        ]);

        return redirect()->route('rkud.index')
            ->with('success', "RKUD '{$rkud->nama_rekening}' berhasil diupdate.");
    }

    public function destroy(Rkud $rkud)
    {
        if ($rkud->is_locked) {
            return back()->with('error', 'Rekening ini terkunci dan tidak dapat dihapus.');
        }

        $nama = $rkud->nama_rekening;
        $rkud->delete();

        return redirect()->route('rkud.index')
            ->with('success', "RKUD '{$nama}' berhasil dihapus.");
    }
}
