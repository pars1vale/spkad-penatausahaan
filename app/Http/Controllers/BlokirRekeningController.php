<?php

namespace App\Http\Controllers;

use App\Models\PerangkatDaerah;
use App\Models\StatistikBelanjaAkun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlokirRekeningController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:blokir-rekening.view')->only(['index', 'tree']);
        $this->middleware('permission:blokir-rekening.edit')->only(['update']);
    }

    public function index()
    {
        $skpdList = PerangkatDaerah::select('id_skpd', 'nama_skpd', 'kode_skpd')
            ->orderBy('kode_skpd')
            ->get();

        return view('blokir-rekening.index', compact('skpdList'));
    }

    public function tree(Request $request)
    {
        $request->validate([
            'id_skpd' => ['required', 'integer'],
        ]);

        $tahun = session('tahun_anggaran');
        $idSkpd = $request->integer('id_skpd');

        $rows = StatistikBelanjaAkun::where('id_skpd', $idSkpd)
            ->where('tahun', $tahun)
            ->select([
                'id',
                'id_skpd',
                'kode_skpd',
                'nama_skpd',
                'kode_sub_skpd',
                'nama_sub_skpd',
                'kode_bidang_urusan',
                'nama_bidang_urusan',
                'kode_program',
                'nama_program',
                'kode_giat',
                'nama_giat',
                'kode_sub_giat',
                'nama_sub_giat',
                'kode_akun',
                'nama_akun',
                'is_blokir',
            ])
            ->orderBy('kode_bidang_urusan')
            ->orderBy('kode_program')
            ->orderBy('kode_giat')
            ->orderBy('kode_sub_giat')
            ->orderBy('kode_akun')
            ->get();

        if ($rows->isEmpty()) {
            return response()->json(['tree' => [], 'skpd' => null]);
        }

        $first = $rows->first();
        $tree = $this->_buildTree($rows, $first);

        return response()->json(['tree' => $tree, 'skpd' => [
            'kode_skpd' => $first->kode_skpd,
            'nama_skpd' => $first->nama_skpd,
            'kode_sub_skpd' => $first->kode_sub_skpd ?: $first->kode_skpd,
            'nama_sub_skpd' => $first->nama_sub_skpd ?: $first->nama_skpd,
        ]]);
    }

    /**
     * Bulk update is_blokir.
     * Request: { blokir: [id, ...] } — semua id yang dicentang.
     * Semua id_skpd+tahun yang tidak ada di array akan di-reset ke 0.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id_skpd' => ['required', 'integer'],
            'blokir' => ['nullable', 'array'],
            'blokir.*' => ['integer'],
        ]);

        $tahun = session('tahun_anggaran');
        $idSkpd = $request->integer('id_skpd');
        $blokir = $request->input('blokir', []);

        DB::transaction(function () use ($idSkpd, $tahun, $blokir) {
            // Reset semua ke 0 dulu
            StatistikBelanjaAkun::where('id_skpd', $idSkpd)
                ->where('tahun', $tahun)
                ->update(['is_blokir' => 0]);

            // Set yang dicentang ke 1
            if (! empty($blokir)) {
                StatistikBelanjaAkun::where('id_skpd', $idSkpd)
                    ->where('tahun', $tahun)
                    ->whereIn('id', $blokir)
                    ->update(['is_blokir' => 1]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Data blokir rekening berhasil disimpan.',
        ]);
    }

    private function _buildTree($rows, $first): array
    {
        $tree = [];

        // Level 1 — SKPD (tunggal, dari filter)
        $skpdNode = [
            'label' => $first->nama_skpd,
            'kode' => $first->kode_skpd,
            'level' => 'skpd',
            'children' => [],
        ];

        // Level 2 — Unit SKPD
        // Jika nama_sub_skpd null → gunakan nilai SKPD dengan label "Unit SKPD"
        $unitGroups = [];
        foreach ($rows as $row) {
            $kodeUnit = $row->kode_sub_skpd ?: $row->kode_skpd;
            $namaUnit = $row->nama_sub_skpd ?: $row->nama_skpd;
            $unitGroups[$kodeUnit]['label'] = $namaUnit;
            $unitGroups[$kodeUnit]['kode'] = $kodeUnit;
            $unitGroups[$kodeUnit]['level'] = 'unit_skpd';
            $unitGroups[$kodeUnit]['rows'][] = $row;
        }

        foreach ($unitGroups as $unitKey => $unitData) {
            $unitNode = [
                'label' => $unitData['label'],
                'kode' => $unitData['kode'],
                'level' => 'unit_skpd',
                'children' => $this->_groupBidang($unitData['rows']),
            ];
            $skpdNode['children'][] = $unitNode;
        }

        $tree[] = $skpdNode;

        return $tree;
    }

    private function _groupBidang(array $rows): array
    {
        $groups = [];
        foreach ($rows as $row) {
            $key = $row->kode_bidang_urusan;
            $groups[$key]['label'] = $row->nama_bidang_urusan;
            $groups[$key]['kode'] = $row->kode_bidang_urusan;
            $groups[$key]['level'] = 'bidang_urusan';
            $groups[$key]['rows'][] = $row;
        }

        $nodes = [];
        foreach ($groups as $data) {
            $nodes[] = [
                'label' => $data['label'],
                'kode' => $data['kode'],
                'level' => 'bidang_urusan',
                'children' => $this->_groupProgram($data['rows']),
            ];
        }

        return $nodes;
    }

    private function _groupProgram(array $rows): array
    {
        $groups = [];
        foreach ($rows as $row) {
            $key = $row->kode_program;
            $groups[$key]['label'] = $row->nama_program;
            $groups[$key]['kode'] = $row->kode_program;
            $groups[$key]['level'] = 'program';
            $groups[$key]['rows'][] = $row;
        }

        $nodes = [];
        foreach ($groups as $data) {
            $nodes[] = [
                'label' => $data['label'],
                'kode' => $data['kode'],
                'level' => 'program',
                'children' => $this->_groupKegiatan($data['rows']),
            ];
        }

        return $nodes;
    }

    private function _groupKegiatan(array $rows): array
    {
        $groups = [];
        foreach ($rows as $row) {
            $key = $row->kode_giat;
            $groups[$key]['label'] = $row->nama_giat;
            $groups[$key]['kode'] = $row->kode_giat;
            $groups[$key]['level'] = 'kegiatan';
            $groups[$key]['rows'][] = $row;
        }

        $nodes = [];
        foreach ($groups as $data) {
            $nodes[] = [
                'label' => $data['label'],
                'kode' => $data['kode'],
                'level' => 'kegiatan',
                'children' => $this->_groupSubKegiatan($data['rows']),
            ];
        }

        return $nodes;
    }

    private function _groupSubKegiatan(array $rows): array
    {
        $groups = [];
        foreach ($rows as $row) {
            $key = $row->kode_sub_giat;
            $groups[$key]['label'] = $row->nama_sub_giat;
            $groups[$key]['kode'] = $row->kode_sub_giat;
            $groups[$key]['level'] = 'sub_kegiatan';
            $groups[$key]['rows'][] = $row;
        }

        $nodes = [];
        foreach ($groups as $data) {
            $nodes[] = [
                'label' => $data['label'],
                'kode' => $data['kode'],
                'level' => 'sub_kegiatan',
                'children' => $this->_buildAkunLeaves($data['rows']),
            ];
        }

        return $nodes;
    }

    private function _buildAkunLeaves(array $rows): array
    {
        $leaves = [];
        foreach ($rows as $row) {
            $leaves[] = [
                'id' => $row->id,
                'label' => $row->nama_akun,
                'kode' => $row->kode_akun,
                'level' => 'akun',
                'is_blokir' => (bool) $row->is_blokir,
            ];
        }

        return $leaves;
    }
}
