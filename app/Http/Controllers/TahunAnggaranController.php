<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TahunAnggaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Ganti tahun anggaran dari navbar */
    public function ganti(Request $request)
    {
        $request->validate([
            'tahun_anggaran' => ['required', 'integer', 'min:2020', 'max:2099'],
        ], [
            'tahun_anggaran.required' => 'Tahun anggaran wajib dipilih.',
        ]);

        session(['tahun_anggaran' => (int) $request->tahun_anggaran]);

        return back()->with('success', 'Tahun anggaran berhasil diganti.');
    }
}
