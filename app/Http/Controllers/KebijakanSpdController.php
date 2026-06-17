<?php

namespace App\Http\Controllers;

use App\Models\KebijakanSpd;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KebijakanSpdController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kebijakan-spd.view')->only(['index', 'data']);
        $this->middleware('permission:kebijakan-spd.create')->only(['create', 'store']);
        $this->middleware('permission:kebijakan-spd.edit')->only(['edit', 'update']);
        $this->middleware('permission:kebijakan-spd.delete')->only(['destroy']);
    }

    public function index()
    {
        return view('kebijakanspd.index');
    }

    public function data(Request $request): JsonResponse
    {
        $draw = $request->integer('draw', 1);
        $start = $request->integer('start', 0);
        $length = $request->integer('length', 10);
        $search = $request->input('search.value', '');

        // ── Base query ───────────────────────────────────────────────
        $query = KebijakanSpd::query();

        // ── Search global ────────────────────────────────────────────
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_periode', 'like', "%{$search}%")
                    ->orWhere('tahun', 'like', "%{$search}%")
                    ->orWhere('nama_penerbitan_spd', 'like', "%{$search}%");
            });
        }

        // ── Sorting ──────────────────────────────────────────────────
        // Mapping index kolom DT → nama kolom DB
        // 0: DT_RowIndex, 1: nama_periode, 2: tahun, 3: nama_penerbitan_spd, 4: action
        $columnMap = [
            1 => 'nama_periode',
            2 => 'tahun',
            3 => 'nama_penerbitan_spd',
        ];

        $orderColIndex = $request->integer('order.0.column', 1);
        $orderDir = in_array($request->input('order.0.dir'), ['asc', 'desc'])
            ? $request->input('order.0.dir')
            : 'asc';
        $orderCol = $columnMap[$orderColIndex] ?? 'nama_periode';

        $query->orderBy($orderCol, $orderDir);

        // ── Count ────────────────────────────────────────────────────
        $total = KebijakanSpd::count();
        $filtered = (clone $query)->count();

        // ── Paginate ─────────────────────────────────────────────────
        $rows = $query->skip($start)->take($length)->get();

        // ── Format baris ─────────────────────────────────────────────
        $data = $rows->map(function (KebijakanSpd $item, int $index) use ($start) {
            return [
                'DT_RowIndex' => $start + $index + 1,
                'nama_periode' => $this->_renderPeriode($item),
                'tahun' => '<span class="badge badge-light-success fw-semibold">'
                    .e($item->tahun ?? '-')
                    .'</span>',
                'nama_penerbitan_spd' => '<span class="text-gray-800 fw-semibold">'
                    .e($item->nama_penerbitan_spd ?? '-')
                    .'</span>',
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

    private function _renderPeriode(KebijakanSpd $item): string
    {
        $badge = $item->badge_periode;

        $badgeHtml = sprintf(
            '<span class="badge badge-light-%s fs-8 fw-semibold">%s</span>',
            e($badge['color']),
            e($badge['label'])
        );

        return sprintf(
            '<div class="d-flex flex-column gap-1">'
                .'<span class="text-gray-800 fw-bold">%s</span>'
                .'%s'
                .'</div>',
            e($item->nama_periode ?? '-'),
            $badgeHtml
        );
    }

    private function _buildAction(KebijakanSpd $item): string
    {
        $btn = '';

        if (auth()->user()->can('kebijakan-spd.edit')) {
            $btn .= '<a href="'.route('kebijakan-spd.edit', $item).'"
                class="btn btn-icon btn-light-warning btn-sm me-1" title="Edit">
                <i class="ki-duotone ki-pencil fs-4">
                    <span class="path1"></span><span class="path2"></span>
                </i></a>';
        }

        if (auth()->user()->can('kebijakan-spd.delete')) {
            $btn .= '<button class="btn btn-icon btn-light-danger btn-sm btn-delete"
                data-url="'.route('kebijakan-spd.destroy', $item).'"
                data-name="'.e($item->nama_penerbitan_spd ?? 'data ini').'"
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
        return view('kebijakan-spd.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kebijakan_spd' => 'required|integer',
            'id_daerah' => 'nullable|integer',
            'tahun' => 'nullable|integer|digits:4',
            'id_periode' => 'nullable|exists:periode,id',
            'nama_periode' => 'nullable|string|max:100',
            'id_penerbitan_spd' => 'nullable|exists:penerbitan_spd,id',
            'nama_penerbitan_spd' => 'nullable|string|max:255',
        ]);

        $item = KebijakanSpd::create($request->only([
            'id_kebijakan_spd',
            'id_daerah',
            'tahun',
            'id_periode',
            'nama_periode',
            'id_penerbitan_spd',
            'nama_penerbitan_spd',
        ]));

        return redirect()
            ->route('kebijakan-spd.index')
            ->with('success', "Kebijakan SPD '{$item->nama_penerbitan_spd}' berhasil ditambahkan.");
    }

    public function edit(KebijakanSpd $kebijakanSpd)
    {
        return view('kebijakan-spd.edit', compact('kebijakanSpd'));
    }

    public function update(Request $request, KebijakanSpd $kebijakanSpd)
    {
        $request->validate([
            'id_kebijakan_spd' => 'required|integer',
            'id_daerah' => 'nullable|integer',
            'tahun' => 'nullable|integer|digits:4',
            'id_periode' => 'nullable|exists:periode,id',
            'nama_periode' => 'nullable|string|max:100',
            'id_penerbitan_spd' => 'nullable|exists:penerbitan_spd,id',
            'nama_penerbitan_spd' => 'nullable|string|max:255',
        ]);

        $kebijakanSpd->update($request->only([
            'id_kebijakan_spd',
            'id_daerah',
            'tahun',
            'id_periode',
            'nama_periode',
            'id_penerbitan_spd',
            'nama_penerbitan_spd',
        ]));

        return redirect()
            ->route('kebijakan-spd.index')
            ->with('success', "Kebijakan SPD '{$kebijakanSpd->nama_penerbitan_spd}' berhasil diperbarui.");
    }

    public function destroy(KebijakanSpd $kebijakanSpd)
    {
        $nama = $kebijakanSpd->nama_penerbitan_spd;
        $kebijakanSpd->delete();

        return redirect()
            ->route('kebijakan-spd.index')
            ->with('success', "Kebijakan SPD '{$nama}' berhasil dihapus.");
    }
}
