@extends('layouts.dashboard.master')

@section('content')
  <div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
      <div>
        <h1 class="page-heading d-flex fw-bold fs-3 flex-column justify-content-center my-0">
          Detail Dokumen Pelaksanaan Anggaran (DPA) | Pendapatan
        </h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
          <li class="breadcrumb-item text-muted">Pengeluaran</li>
          <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
          <li class="breadcrumb-item text-muted">DPA</li>
          <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
          <li class="breadcrumb-item text-muted">Penerimaan</li>
          <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
          <li class="breadcrumb-item text-muted">
            <a href="{{ route('dpa-pendapatan.index') }}" class="text-muted text-hover-primary">Pendapatan</a>
          </li>
          <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
          <li class="breadcrumb-item text-muted">Detail</li>
        </ul>
      </div>
      <a href="{{ route('dpa-pendapatan.index') }}" class="btn btn-light">
        <i class="ki-duotone ki-arrow-left fs-2"><span class="path1"></span><span class="path2"></span></i>
        Kembali
      </a>
    </div>

    @include('components.flash-messages')

    <div class="card card-bordered mb-5">
      <div class="card-body py-5">
        <div class="d-flex align-items-center gap-5 flex-wrap">

          <div class="d-flex flex-column flex-grow-1">
            <span class="fw-bold fs-4 text-gray-800">{{ $induk->nama_skpd }}</span>
            <span class="text-muted fs-7">Kode: {{ $induk->kode_skpd }}</span>
          </div>

          <div class="d-flex flex-column align-items-end border-start ps-5">
            <div class="d-flex align-items-center gap-2">
              <i class="ki-duotone ki-chart-line-up fs-2 text-primary">
                <span class="path1"></span><span class="path2"></span>
              </i>
              <span class="fw-bold fs-5 text-gray-800">
                Rp {{ number_format($totalNilai, 0, ',', '.') }}
              </span>
            </div>
            <span class="text-muted fs-7">Akumulasi Alokasi Anggaran</span>
          </div>

          <div class="d-flex flex-column align-items-end border-start ps-5">
            <div class="d-flex align-items-center gap-2">
              <i class="ki-duotone ki-bill fs-2 text-info">
                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                <span class="path4"></span><span class="path5"></span><span class="path6"></span>
              </i>
              <span class="fw-bold fs-5 text-gray-800">
                Rp {{ number_format($totalNilaiRak, 0, ',', '.') }}
              </span>
            </div>
            <span class="text-muted fs-7">Akumulasi RAK</span>
          </div>

          <div class="d-flex flex-column align-items-end border-start ps-5">
            <div class="d-flex align-items-center gap-2">
              <i class="ki-duotone ki-minus-circle fs-2 text-danger">
                <span class="path1"></span><span class="path2"></span>
              </i>
              <span class="fw-bold fs-5 {{ $totalSelisih > 0 ? 'text-danger' : 'text-success' }}">
                Rp {{ number_format($totalSelisih, 0, ',', '.') }}
              </span>
            </div>
            <span class="text-muted fs-7">Akumulasi Selisih</span>
          </div>

        </div>
      </div>
    </div>

    {{-- Tabel Detail --}}
    <div class="card card-bordered">
      <div class="card-body pt-6">
        <table class="table table-bordered table-hover" id="dpaPendapatanDetailTable"
          data-ajax-url="{{ route('dpa-pendapatan.detail.data', $induk->id_skpd) }}"
          data-options='{"searchPlaceholder":"Cari akun...","emptyText":"Tidak ada data detail"}'
          data-update-base-url="{{ url('dpa-pendapatan/' . $induk->id_skpd . '/detail') }}">
          <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
              <th data-col="DT_RowIndex" data-orderable="false" data-searchable="false" data-width="40px">#</th>
              <th data-col="akun" data-width="370px">Uraian</th>
              <th data-col="nilai" data-orderable="true" data-searchable="false" data-width="140px">Alokasi Anggaran</th>
              <th data-col="nilai_rak" data-orderable="true" data-searchable="false" data-width="140px">RAK</th>
              <th data-col="selisih" data-orderable="false" data-searchable="false" data-width="140px">Selisih</th>
              <th data-col="januari" data-orderable="false" data-searchable="false" data-width="140px">Januari</th>
              <th data-col="februari" data-orderable="false" data-searchable="false" data-width="140px">Februari</th>
              <th data-col="maret" data-orderable="false" data-searchable="false" data-width="140px">Maret</th>
              <th data-col="april" data-orderable="false" data-searchable="false" data-width="140px">April</th>
              <th data-col="mei" data-orderable="false" data-searchable="false" data-width="140px">Mei</th>
              <th data-col="juni" data-orderable="false" data-searchable="false" data-width="140px">Juni</th>
              <th data-col="juli" data-orderable="false" data-searchable="false" data-width="140px">Juli</th>
              <th data-col="agustus" data-orderable="false" data-searchable="false" data-width="140px">Agustus</th>
              <th data-col="september" data-orderable="false" data-searchable="false" data-width="140px">September</th>
              <th data-col="oktober" data-orderable="false" data-searchable="false" data-width="140px">Oktober</th>
              <th data-col="november" data-orderable="false" data-searchable="false" data-width="140px">November</th>
              <th data-col="desember" data-orderable="false" data-searchable="false" data-width="140px">Desember</th>
            </tr>
          </thead>
          <tbody class="text-gray-600 fw-semibold"></tbody>
        </table>
      </div>
    </div>

  </div>

  @include('pengeluaran.dpa.penerimaan.pendapatan.partials.modal-rak')
@endsection

@push('scripts')
  <script>
    (function() {
      const tableEl = document.getElementById('dpaPendapatanDetailTable');
      const baseUrl = tableEl?.dataset.updateBaseUrl ?? '';

      $('#dpaPendapatanDetailTable').on('draw.dt', function() {
        const dt = DataTableManager.getInstance('dpaPendapatanDetailTable');
        if (!dt) return;

        dt.rows({
          page: 'current'
        }).every(function() {
          const raw = this.data()?._raw;
          if (!raw) return;

          const tr = this.node();
          tr.dataset.raw = JSON.stringify(raw);
          // URL: /dpa-pendapatan/{idSkpd}/detail/{id}
          tr.dataset.updateUrl = baseUrl + '/' + raw.id;
          tr.style.cursor = 'pointer';
        });
      });
    })();
  </script>
@endpush
