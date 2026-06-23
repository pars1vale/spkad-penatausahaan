<?php

namespace App\Http\Controllers\Pengeluaran\Dpa\Penerimaan;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran\Dpa\Penerimaan\DpaPenerimaanPendapatan;
use Illuminate\Http\Request;

class DpaPenerimaanPendapatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dpa-pendapatan.view')->only(['index', 'data']);
        $this->middleware('permission:dpa-pendapatan.create')->only(['create', 'store']);
        $this->middleware('permission:dpa-pendapatan.edit')->only(['edit', 'update', 'toggleKunci']);
        $this->middleware('permission:dpa-pendapatan.delete')->only(['destroy']);
    }

    public function index()
    {
        $akumulasi = DpaPenerimaanPendapatan::where('tahun', session('tahun_anggaran'))
            ->selectRaw('SUM(nilai) as total_nilai, SUM(nilai_rak) as total_nilai_rak')
            ->first();
        $skpdTerkunci = DpaPenerimaanPendapatan::where('tahun', session('tahun_anggaran'))
            ->where('status', 1)
            ->count();
        $skpdTerbuka = DpaPenerimaanPendapatan::where('tahun', session('tahun_anggaran'))
            ->where('status', 0)
            ->count();

        $jumlahSkpd = DpaPenerimaanPendapatan::where('tahun', session('tahun_anggaran'))->count();
        $totalNilai = $akumulasi->total_nilai ?? 0;
        $totalNilaiRak = $akumulasi->total_nilai_rak ?? 0;

        return view('pengeluaran.dpa.penerimaan.pendapatan.index', compact(
            'jumlahSkpd',
            'skpdTerkunci',
            'skpdTerbuka',
            'totalNilai',
            'totalNilaiRak',
        ));
    }

    public function data(Request $request)
    {
        $tahun = session('tahun_anggaran');

        $query = DpaPenerimaanPendapatan::where('tahun', $tahun);

        // Search global
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_skpd', 'like', "%{$search}%")
                    ->orWhere('kode_skpd', 'like', "%{$search}%");
            });
        }

        $recordsTotal = DpaPenerimaanPendapatan::where('tahun', $tahun)->count();
        $recordsFiltered = $query->count();

        // Ordering
        $orderCol = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');
        $columns = ['id', 'kode_skpd', 'nilai', 'nilai_rak', 'status'];
        $sortColumn = $columns[$orderCol] ?? 'id';
        $query->orderBy($sortColumn, $orderDir);

        // Pagination
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        $items = $query->skip($start)->take($length)->get();

        $data = $items->map(function ($item, int $index) use ($start) {
            return [
                'DT_RowIndex' => $start + $index + 1,
                'skpd' => $this->_renderSkpd($item),
                'nilai' => $this->_renderNilai($item->nilai),
                'nilai_rak' => $this->_renderNilai($item->nilai_rak),
                'progres' => '—',
                'status' => $item->badge_status,
                'action' => $this->_buildAction($item),
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    // -------------------------------------------------------------------------
    // Create / Store
    // -------------------------------------------------------------------------

    public function create()
    {
        return view('dpa-pendapatan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_skpd' => 'required|integer',
            'kode_skpd' => 'nullable|string|max:50',
            'nama_skpd' => 'nullable|string|max:255',
            'nilai' => 'required|integer|min:0',
            'nilai_rak' => 'required|integer|min:0',
        ]);

        $validated['tahun'] = session('tahun_anggaran');
        $validated['id_daerah'] = session('id_daerah');

        DpaPenerimaanPendapatan::create($validated);

        return redirect()->route('dpa-pendapatan.index')
            ->with('success', 'Data DPA Pendapatan berhasil ditambahkan.');
    }

    // -------------------------------------------------------------------------
    // Edit / Update
    // -------------------------------------------------------------------------

    public function edit(DpaPenerimaanPendapatan $dpaPendapatan)
    {
        return view('dpa-pendapatan.edit', compact('dpaPendapatan'));
    }

    public function update(Request $request, DpaPenerimaanPendapatan $dpaPendapatan)
    {
        $validated = $request->validate([
            'nilai' => 'required|integer|min:0',
            'nilai_rak' => 'required|integer|min:0',
        ]);

        $dpaPendapatan->update($validated);

        return redirect()->route('dpa-pendapatan.index')
            ->with('success', 'Data DPA Pendapatan berhasil diperbarui.');
    }

    // -------------------------------------------------------------------------
    // Toggle Kunci
    // -------------------------------------------------------------------------

    public function toggleKunci(DpaPenerimaanPendapatan $dpaPendapatan)
    {
        $dpaPendapatan->update([
            'status' => $dpaPendapatan->status === 1 ? 0 : 1,
        ]);

        $label = $dpaPendapatan->fresh()->status === 1 ? 'dikunci' : 'dibuka kuncinya';

        return redirect()->route('dpa-pendapatan.index')
            ->with('success', "Data DPA Pendapatan berhasil {$label}.");
    }

    // -------------------------------------------------------------------------
    // Destroy
    // -------------------------------------------------------------------------

    public function destroy(DpaPenerimaanPendapatan $dpaPendapatan)
    {
        $dpaPendapatan->delete();

        return redirect()->route('dpa-pendapatan.index')
            ->with('success', 'Data DPA Pendapatan berhasil dihapus.');
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    private function _renderSkpd(DpaPenerimaanPendapatan $item): string
    {
        return '<div class="d-flex flex-column">'
            .'<span class="fw-bold">'.e($item->nama_skpd).'</span>'
            .'<span class="text-muted fs-7">'.e($item->kode_skpd).'</span>'
            .'</div>';
    }

    private function _renderNilai(int $nilai): string
    {
        return '<span class="text-end d-block">Rp '.number_format($nilai, 0, ',', '.').'</span>';
    }

    private function _buildAction(DpaPenerimaanPendapatan $item): string
    {
        $editUrl = route('dpa-pendapatan.edit', $item->id);
        $deleteUrl = route('dpa-pendapatan.destroy', $item->id);
        $kunciUrl = route('dpa-pendapatan.toggle-kunci', $item->id);
        $detailUrl = route('dpa-pendapatan.detail.show', $item->id_skpd);

        $isLocked = $item->status === 1;
        $kunciLabel = $isLocked ? 'Buka Kunci' : 'Kunci';
        $kunciIcon = $isLocked ? 'ki-lock-3' : 'ki-lock';
        $kunciClass = $isLocked ? 'btn-active-light-success' : 'btn-light-danger';
        $kunciConfirm = $isLocked
            ? 'Buka kunci data ini?'
            : 'Kunci data ini? Data yang terkunci tidak dapat diubah.';

        return '<div class="d-flex gap-1">'
            .'<a href="'.$detailUrl.'" class="btn btn-sm btn-active-light-primary btn-color-dark hover-scale" title="Detail">'
            .'<i class="ki-duotone ki-subtitle fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>'
            .'Detail'
            .'</a>'

            .'<button type="button"'
            .' class="btn btn-sm btn-color-dark '.$kunciClass.' btn-toggle-kunci hover-scale"'
            .' data-url="'.$kunciUrl.'"'
            .' data-name="'.e($item->nama_skpd).'"'
            .' data-confirm="'.$kunciConfirm.'"'
            .' title="'.$kunciLabel.'">'
            .'<i class="ki-duotone '.$kunciIcon.' fs-4"><span class="path1"></span><span class="path2"></span></i>'
            .''.$kunciLabel.''
            .'</button>'

            .'<a href="'.$editUrl.'" class="btn btn-sm btn-active-light-primary btn-color-dark hover-scale" title="Edit">'
            .'<i class="ki-duotone ki-pencil fs-5"><span class="path1"></span><span class="path2"></span></i>'
            .'Edit'
            .'</a>'

            .'<button type="button"'
            .' class="btn btn-sm btn-light-danger btn-delete hover-rotate-end"'
            .' data-url="'.$deleteUrl.'"'
            .' data-name="'.e($item->nama_skpd).'"'
            .' title="Hapu Data">'
            .'<i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>'
            .'Hapus'
            .'</button>'
            .'</div>';
    }
}
