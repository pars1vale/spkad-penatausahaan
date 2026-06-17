<?php

namespace App\Http\Controllers\RekeningBank;

use App\Http\Controllers\Controller;
use App\Models\RekeningBank\PengajuanRekening;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkpdController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:rekening-bank-skpd.view')->only(['index', 'data']);
        $this->middleware('permission:rekening-bank-skpd.edit')->only(['nonaktifkan']);
    }

    public function index()
    {
        return view('rekeningbank.skpd.index');
    }

    public function data(Request $request): JsonResponse
    {
        $tab = $request->input('tab', 'pengajuan'); // pengajuan | belum_aktif | aktif
        $draw = (int) $request->input('draw', 1);
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        $search = $request->input('search.value', '');

        $query = match ($tab) {
            'belum_aktif' => PengajuanRekening::belumAktif(),
            'aktif' => PengajuanRekening::aktif(),
            default => PengajuanRekening::pengajuan(),
        };

        // Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_rekening', 'like', "%{$search}%")
                    ->orWhere('nama_skpd', 'like', "%{$search}%")
                    ->orWhere('nama_bank', 'like', "%{$search}%")
                    ->orWhere('nama_rekening', 'like', "%{$search}%");
            });
        }

        $total = PengajuanRekening::count();
        $filtered = $query->count();

        $data = $query
            ->orderBy('id', 'asc')
            ->skip($start)
            ->take($length)
            ->get()
            ->map(function (PengajuanRekening $item, int $index) use ($start, $tab) {
                return [
                    'DT_RowIndex' => $start + $index + 1,
                    'no_rekening' => $this->_renderRekening($item),
                    'nama_skpd' => $this->_renderSkpd($item),
                    'nama_bank' => $this->_renderBank($item),
                    'saldo_tunai' => $this->_renderSaldo($item),
                    'action' => $this->_buildAction($item, $tab),
                ];
            });

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data,
        ]);
    }

    // -------------------------------------------------------
    // Non-aktifkan Rekening
    // -------------------------------------------------------

    public function nonaktifkan(int $id)
    {
        $rekening = PengajuanRekening::findOrFail($id);

        $rekening->update([
            'is_aktif' => 0,
            'aktif_by' => Auth::id(),
            'aktif_by_nama' => Auth::user()->name ?? '-',
            'aktif_at' => now(),
        ]);

        return redirect()
            ->route('skpd.index')
            ->with('success', 'Rekening berhasil di-nonaktifkan.');
    }

    // -------------------------------------------------------
    // Private render helpers
    // -------------------------------------------------------

    private function _renderRekening(PengajuanRekening $item): string
    {
        $noRek = e($item->no_rekening ?? '-');
        $namaRek = e($item->nama_rekening ?? '');

        return <<<HTML
            <div class="d-flex align-items-center">
                <span class="ki-duotone ki-bank fs-2 text-primary me-2">
                    <span class="path1"></span><span class="path2"></span>
                </span>
                <div>
                    <span class="fw-bold text-gray-800">{$noRek}</span>
                    <div class="text-muted fs-7">{$namaRek}</div>
                </div>
            </div>
        HTML;
    }

    private function _renderSkpd(PengajuanRekening $item): string
    {
        $nama = e($item->nama_skpd ?? '-');

        return <<<HTML
            <div class="d-flex align-items-center">
                <span class="ki-duotone ki-office-bag fs-2 text-success me-2">
                    <span class="path1"></span><span class="path2"></span>
                </span>
                <span class="fw-semibold text-gray-700">{$nama}</span>
            </div>
        HTML;
    }

    private function _renderBank(PengajuanRekening $item): string
    {
        $nama = e($item->nama_bank ?? '-');

        return <<<HTML
            <div class="d-flex align-items-center">
                <span class="ki-duotone ki-financial-schedule fs-2 text-info me-2">
                    <span class="path1"></span><span class="path2"></span>
                </span>
                <span class="fw-semibold text-gray-700">{$nama}</span>
            </div>
        HTML;
    }

    private function _renderSaldo(PengajuanRekening $item): string
    {
        $tunai = e($item->saldo_tunai_formatted);
        $bank = e($item->saldo_bank_formatted);

        return <<<HTML
            <div>
                <div class="d-flex align-items-center mb-1">
                    <span class="text-muted fs-7 me-2 w-75px">Saldo Bank</span>
                    <span class="fw-bold text-gray-800">{$bank}</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="text-muted fs-7 me-2 w-75px">Saldo Tunai</span>
                    <span class="fw-bold text-gray-800">{$tunai}</span>
                </div>
            </div>
        HTML;
    }

    private function _buildAction(PengajuanRekening $item, string $tab): string
    {
        $nonaktifUrl = route('skpd.nonaktifkan', $item->id);

        // Tombol non-aktifkan hanya muncul di tab Rekening Aktif
        $nonaktifBtn = '';
        if ($tab === 'aktif') {
            $csrf = csrf_token();
            $nonaktifBtn = <<<HTML
                <form action="{$nonaktifUrl}" method="POST" class="d-inline"
                      onsubmit="return confirm('Non-aktifkan rekening ini?')">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{$csrf}">
                    <button type="submit"
                            class="btn btn-sm btn-light-warning fw-semibold">
                        <span class="ki-duotone ki-lock fs-4 me-1">
                            <span class="path1"></span><span class="path2"></span>
                        </span>
                        Non Aktifkan
                    </button>
                </form>
            HTML;
        }

        return <<<HTML
            <div class="d-flex gap-2">
                {$nonaktifBtn}
            </div>
        HTML;
    }
}
