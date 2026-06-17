<?php

namespace App\Http\Controllers;

use App\Models\PerangkatDaerah;
use Illuminate\Http\Request;

class PerangkatDaerahController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:perangkat-daerah.view')->only(['index', 'data']);
        $this->middleware('permission:perangkat-daerah.create')->only(['create', 'store']);
        $this->middleware('permission:perangkat-daerah.edit')->only(['edit', 'update']);
        $this->middleware('permission:perangkat-daerah.delete')->only(['destroy']);
    }

    // Render halaman index — view tidak butuh data apapun
    public function index()
    {
        return view('perangkatdaerah.index');
    }

    /**
     * Endpoint AJAX untuk DataTableManager.js
     * GET /perangkat-daerah/data  (name: perangkat-daerah.data)
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
        $query = PerangkatDaerah::query();

        // ── Search global ────────────────────────────────────────────
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_skpd', 'like', "%{$search}%")
                    ->orWhere('kode_skpd', 'like', "%{$search}%")
                    ->orWhere('tahun', 'like', "%{$search}%");
            });
        }

        // ── Sorting ──────────────────────────────────────────────────
        // Mapping index kolom DT → nama kolom DB
        // 0: DT_RowIndex, 1: kode_skpd, 2: nama_skpd, 3: tahun,
        // 4: nilai, 5: nilai_rak, 6: status, 7: action
        $columnMap = [
            1 => 'kode_skpd',
            2 => 'nama_skpd',
            3 => 'tahun',
            4 => 'nilai',
            5 => 'nilai_rak',
        ];

        $orderColIndex = $request->integer('order.0.column', 2);
        $orderDir = in_array($request->input('order.0.dir'), ['asc', 'desc'])
            ? $request->input('order.0.dir')
            : 'asc';
        $orderCol = $columnMap[$orderColIndex] ?? 'nama_skpd';

        $query->orderBy($orderCol, $orderDir);

        // ── Count ────────────────────────────────────────────────────
        $total = PerangkatDaerah::count();
        $filtered = (clone $query)->count();

        // ── Paginate ─────────────────────────────────────────────────
        $rows = $query->skip($start)->take($length)->get();

        // ── Format baris ─────────────────────────────────────────────
        $data = $rows->map(function (PerangkatDaerah $pd, int $index) use ($start) {
            return [
                'DT_RowIndex' => $start + $index + 1,
                'kode_skpd' => '<span class="text-gray-700 fw-semibold font-monospace">'
                    .e($pd->kode_skpd)
                    .'</span>',
                'nama_skpd' => '<span class="text-gray-800 fw-bold">'
                    .e($pd->nama_skpd)
                    .'</span>',
                'tahun' => '<span class="badge badge-light-info fw-bold">'
                    .e($pd->tahun)
                    .'</span>',
                'nilai' => '<span class="text-gray-700">'
                    .'Rp '.number_format($pd->nilai, 0, ',', '.')
                    .'</span>',
                'nilai_rak' => '<span class="text-gray-700">'
                    .'Rp '.number_format($pd->nilai_rak, 0, ',', '.')
                    .'</span>',
                'status' => $this->_renderStatus($pd->status),
                'action' => $this->_buildAction($pd),
            ];
        });

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data,
        ]);
    }

    // ── Render badge status ──────────────────────────────────────────
    private function _renderStatus(?string $status): string
    {
        return match ($status) {
            'aktif' => '<span class="badge badge-light-success">Aktif</span>',
            'nonaktif' => '<span class="badge badge-light-danger">Nonaktif</span>',
            'draft' => '<span class="badge badge-light-warning">Draft</span>',
            default => '<span class="badge badge-light-secondary">'.e($status ?? '-').'</span>',
        };
    }

    // ── Builder tombol aksi per baris ────────────────────────────────
    private function _buildAction(PerangkatDaerah $pd): string
    {
        $btn = '';

        if (auth()->user()->can('perangkat-daerah.edit')) {
            $btn .= '<a href="'.route('perangkat-daerah.edit', $pd).'"
                class="btn btn-icon btn-light-warning btn-sm me-1" title="Edit">
                <i class="ki-duotone ki-pencil fs-4">
                    <span class="path1"></span><span class="path2"></span>
                </i></a>';
        }

        if (auth()->user()->can('perangkat-daerah.delete')) {
            $btn .= '<button class="btn btn-icon btn-light-danger btn-sm btn-delete"
                data-url="'.route('perangkat-daerah.destroy', $pd).'"
                data-name="'.e($pd->nama_skpd).'"
                title="Hapus">
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
        return view('perangkat-daerah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_daerah' => 'required|string|max:50',
            'tahun' => 'required|digits:4|integer',
            'id_skpd' => 'required|string|max:50',
            'nama_skpd' => 'required|string|max:200',
            'kode_skpd' => 'required|string|max:50',
            'nilai' => 'required|numeric|min:0',
            'nilai_rak' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,nonaktif,draft',
        ]);

        $pd = PerangkatDaerah::create($request->only([
            'id_daerah',
            'tahun',
            'id_skpd',
            'nama_skpd',
            'kode_skpd',
            'nilai',
            'nilai_rak',
            'status',
        ]));

        return redirect()->route('perangkat-daerah.index')
            ->with('success', "Perangkat Daerah '{$pd->nama_skpd}' berhasil ditambahkan.");
    }

    public function edit(PerangkatDaerah $perangkatDaerah)
    {
        return view('perangkat-daerah.edit', compact('perangkatDaerah'));
    }

    public function update(Request $request, PerangkatDaerah $perangkatDaerah)
    {
        $request->validate([
            'id_daerah' => 'required|string|max:50',
            'tahun' => 'required|digits:4|integer',
            'id_skpd' => 'required|string|max:50',
            'nama_skpd' => 'required|string|max:200',
            'kode_skpd' => 'required|string|max:50',
            'nilai' => 'required|numeric|min:0',
            'nilai_rak' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,nonaktif,draft',
        ]);

        $perangkatDaerah->update($request->only([
            'id_daerah',
            'tahun',
            'id_skpd',
            'nama_skpd',
            'kode_skpd',
            'nilai',
            'nilai_rak',
            'status',
        ]));

        return redirect()->route('perangkat-daerah.index')
            ->with('success', "Perangkat Daerah '{$perangkatDaerah->nama_skpd}' berhasil diupdate.");
    }

    public function destroy(PerangkatDaerah $perangkatDaerah)
    {
        $nama = $perangkatDaerah->nama_skpd;
        $perangkatDaerah->delete();

        return redirect()->route('perangkat-daerah.index')
            ->with('success', "Perangkat Daerah '{$nama}' berhasil dihapus.");
    }
}
