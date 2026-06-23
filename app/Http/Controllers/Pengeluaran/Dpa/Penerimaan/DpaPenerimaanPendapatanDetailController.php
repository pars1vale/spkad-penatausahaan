<?php

namespace App\Http\Controllers\Pengeluaran\Dpa\Penerimaan;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran\Dpa\Penerimaan\DpaPenerimaanPendapatan;
use App\Models\Pengeluaran\Dpa\Penerimaan\DpaPenerimaanPendapatanDetail;
use Illuminate\Http\Request;

class DpaPenerimaanPendapatanDetailController extends Controller
{
    private array $BULAN = [
        'januari',
        'februari',
        'maret',
        'april',
        'mei',
        'juni',
        'juli',
        'agustus',
        'september',
        'oktober',
        'november',
        'desember',
    ];

    public function __construct()
    {
        $this->middleware('permission:dpa-pendapatan.view')->only(['show', 'data']);
        $this->middleware('permission:dpa-pendapatan.edit')->only(['update']);
    }

    public function show(int $idSkpd)
    {
        $tahun = session('tahun_anggaran');

        $induk = DpaPenerimaanPendapatan::where('id_skpd', $idSkpd)
            ->where('tahun', $tahun)
            ->firstOrFail();

        $akumulasi = DpaPenerimaanPendapatanDetail::where('id_skpd', $idSkpd)
            ->where('tahun', $tahun)
            ->selectRaw('SUM(nilai) as total_nilai, SUM(nilai_rak) as total_nilai_rak')
            ->first();

        $totalNilai = $akumulasi->total_nilai ?? 0;
        $totalNilaiRak = $akumulasi->total_nilai_rak ?? 0;
        $totalSelisih = $totalNilai - $totalNilaiRak;

        return view('pengeluaran.dpa.penerimaan.pendapatan.detail', compact(
            'induk',
            'totalNilai',
            'totalNilaiRak',
            'totalSelisih',
        ));
    }

    // -------------------------------------------------------------------------
    // Data — server-side DataTable
    // -------------------------------------------------------------------------

    public function data(Request $request, int $idSkpd)
    {
        $tahun = session('tahun_anggaran');

        // Cek status kunci dari tabel induk — dikirim ke frontend
        $induk = DpaPenerimaanPendapatan::where('id_skpd', $idSkpd)
            ->where('tahun', $tahun)
            ->first();
        $isLocked = $induk ? $induk->status === 1 : false;

        $query = DpaPenerimaanPendapatanDetail::where('id_skpd', $idSkpd)
            ->where('tahun', $tahun);

        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_akun', 'like', "%{$search}%")
                    ->orWhere('kode_akun', 'like', "%{$search}%")
                    ->orWhere('nama_sub_skpd', 'like', "%{$search}%");
            });
        }

        $recordsTotal = DpaPenerimaanPendapatanDetail::where('id_skpd', $idSkpd)
            ->where('tahun', $tahun)->count();
        $recordsFiltered = $query->count();

        $orderCol = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');
        $columns = ['id', 'kode_akun', 'nilai', 'nilai_rak'];
        $sortColumn = $columns[$orderCol] ?? 'kode_akun';
        $query->orderBy($sortColumn, $orderDir);

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        $items = $query->skip($start)->take($length)->get();

        $data = $items->map(function ($item, int $index) use ($start, $isLocked) {
            return [
                'DT_RowIndex' => $start + $index + 1,
                'akun' => $this->_renderAkun($item),
                'nilai' => $this->_renderRupiah($item->nilai),
                'nilai_rak' => $this->_renderRupiah($item->nilai_rak),
                'selisih' => $this->_renderRupiah($item->nilai - $item->nilai_rak),
                'januari' => $this->_renderRupiah($item->januari),
                'februari' => $this->_renderRupiah($item->februari),
                'maret' => $this->_renderRupiah($item->maret),
                'april' => $this->_renderRupiah($item->april),
                'mei' => $this->_renderRupiah($item->mei),
                'juni' => $this->_renderRupiah($item->juni),
                'juli' => $this->_renderRupiah($item->juli),
                'agustus' => $this->_renderRupiah($item->agustus),
                'september' => $this->_renderRupiah($item->september),
                'oktober' => $this->_renderRupiah($item->oktober),
                'november' => $this->_renderRupiah($item->november),
                'desember' => $this->_renderRupiah($item->desember),
                // Raw values untuk populate modal — tidak dirender di tabel
                '_raw' => [
                    'id' => $item->id,
                    'is_locked' => $isLocked,
                    'nama_akun' => $item->nama_akun,
                    'kode_akun' => $item->kode_akun,
                    'nilai' => $item->nilai,
                    'nilai_rak' => $item->nilai_rak,
                    'januari' => $item->januari,
                    'februari' => $item->februari,
                    'maret' => $item->maret,
                    'april' => $item->april,
                    'mei' => $item->mei,
                    'juni' => $item->juni,
                    'juli' => $item->juli,
                    'agustus' => $item->agustus,
                    'september' => $item->september,
                    'oktober' => $item->oktober,
                    'november' => $item->november,
                    'desember' => $item->desember,
                ],
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
    // Update — PATCH 12 field bulan sekaligus
    // -------------------------------------------------------------------------

    public function update(Request $request, int $idSkpd, int $id)
    {
        $tahun = session('tahun_anggaran');

        // Guard: cek status kunci dari induk sebelum apapun
        $induk = DpaPenerimaanPendapatan::where('id_skpd', $idSkpd)
            ->where('tahun', $tahun)
            ->firstOrFail();

        if ($induk->status === 1) {
            return response()->json([
                'success' => false,
                'message' => 'Data terkunci. Tidak dapat melakukan perubahan.',
            ], 403);
        }

        $detail = DpaPenerimaanPendapatanDetail::where('id', $id)
            ->where('id_skpd', $idSkpd)
            ->where('tahun', $tahun)
            ->firstOrFail();

        $rules = [];
        foreach ($this->BULAN as $bulan) {
            $rules[$bulan] = 'required|integer|min:0';
        }

        $validated = $request->validate($rules);

        // Hitung ulang nilai_rak dari total semua bulan
        $totalRak = array_sum(array_map(fn ($b) => $validated[$b], $this->BULAN));
        $validated['nilai_rak'] = $totalRak;

        $detail->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data RAK berhasil disimpan.',
            'nilai_rak' => $totalRak,
        ]);
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    private function _renderAkun(DpaPenerimaanPendapatanDetail $item): string
    {
        return '<div class="d-flex flex-column">'
            .'<span class="fw-bold">'.e($item->nama_akun).'</span>'
            .'<span class="text-muted fs-7">'.e($item->kode_akun).'</span>'
            .'</div>';
    }

    private function _renderRupiah(int $nilai): string
    {
        return '<span class="text-end d-block">Rp '.number_format($nilai, 0, ',', '.').'</span>';
    }
}
