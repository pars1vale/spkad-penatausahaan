<?php

namespace App\Http\Controllers;

use App\Models\AkunPenerimaan;
use App\Models\PerangkatDaerah;
use Illuminate\Http\Request;

class RekeningPenerimaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:rekening-penerimaan.view')->only(['index', 'data']);
        $this->middleware('permission:rekening-penerimaan.edit')->only(['update', 'updateBatch']);
    }

    public function index()
    {
        $skpdList = PerangkatDaerah::select('id', 'id_skpd', 'kode_skpd', 'nama_skpd')
            ->orderBy('kode_skpd')
            ->get();

        return view('rekeningpenerimaan.index', compact('skpdList'));
    }

    public function data(Request $request)
    {
        $idSkpd = $request->input('id_skpd');

        if (! $idSkpd) {
            return response()->json([
                'draw' => intval($request->input('draw', 1)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
            ]);
        }

        $draw = intval($request->input('draw', 1));
        $start = intval($request->input('start', 0));
        $length = intval($request->input('length', 25));
        $search = $request->input('search.value', '');

        $query = AkunPenerimaan::where('id_skpd', $idSkpd);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_akun', 'like', "%{$search}%")
                    ->orWhere('nama_akun', 'like', "%{$search}%");
            });
        }

        $recordsTotal = AkunPenerimaan::where('id_skpd', $idSkpd)->count();
        $recordsFiltered = $query->count();

        $data = $query->orderBy('kode_akun')
            ->skip($start)
            ->take($length)
            ->get();

        $metodeOptions = AkunPenerimaan::METODE_OPTIONS;

        $result = $data->map(function ($item, int $index) use ($start, $metodeOptions) {
            return [
                'DT_RowIndex' => $start + $index + 1,
                'DT_RowId' => 'row-'.$item->id,
                'id' => $item->id,
                'kode_akun' => $item->kode_akun,
                'nama_akun' => $item->nama_akun,
                'metode_input' => $item->metode_input,
                'metode_select' => $this->_renderMetodeSelect($item, $metodeOptions),
            ];
        });

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $result,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validValues = implode(',', array_keys(AkunPenerimaan::METODE_OPTIONS));

        $request->validate([
            'metode_input' => ['nullable', "in:,{$validValues}"],
        ]);

        $akun = AkunPenerimaan::findOrFail($id);
        $akun->metode_input = $request->metode_input ?: null;
        $akun->save();

        return response()->json(['success' => true, 'message' => 'Metode input berhasil diperbarui.']);
    }

    // Bulk update — multiple rows
    public function updateBatch(Request $request)
    {
        $validValues = implode(',', array_keys(AkunPenerimaan::METODE_OPTIONS));

        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:akun_penerimaan,id'],
            'metode_input' => ['nullable', "in:,{$validValues}"],
        ]);

        AkunPenerimaan::whereIn('id', $request->ids)
            ->update(['metode_input' => $request->metode_input ?: null]);

        return response()->json([
            'success' => true,
            'message' => count($request->ids).' akun berhasil diperbarui.',
        ]);
    }

    private function _renderMetodeSelect($item, array $options): string
    {
        $opts = '';
        foreach ($options as $value => $label) {
            $selected = $item->metode_input === $value ? ' selected' : '';
            $opts .= "<option value=\"{$value}\"{$selected}>{$label}</option>";
        }

        return '<select class="form-select form-select-sm metode-select" '
            .'data-id="'.$item->id.'" '
            .'data-original="'.e($item->metode_input).'">'
            .'<option value="">-- Pilih --</option>'
            .$opts
            .'</select>'
            .'<span class="save-indicator ms-2" style="display:none;"></span>';
    }
}
