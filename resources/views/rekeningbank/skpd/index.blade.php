@extends('layouts.dashboard.master')

@section('content')
  <div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-6">
      <div>
        <h1 class="page-heading d-flex fw-bold fs-3 flex-column justify-content-center text-gray-900">
          Rekening Bank
        </h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
          <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
          </li>
          <li class="breadcrumb-item text-muted">Rekening Bank</li>
          <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
          </li>
          <li class="breadcrumb-item text-gray-500">SKPD</li>
        </ul>
      </div>
    </div>

    @include('components.flash-messages')

    <div class="card shadow-sm">
      <div class="card-body pt-6">

        {{-- Tab navigation --}}
        <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-transparent fs-6 fw-bold mb-6" id="rekeningTabs">
          <li class="nav-item">
            <a class="nav-link text-active-primary pb-4 active" href="#" data-tab-value="pengajuan">
              Data Rekening Bank
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-active-primary pb-4" href="#" data-tab-value="belum_aktif">
              Rekening Belum Aktif
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-active-primary pb-4" href="#" data-tab-value="aktif">
              Rekening Aktif
            </a>
          </li>
        </ul>

        {{-- Satu tabel, tab dikontrol via DataTableManager.switchTab() --}}
        <table id="skpdTable" data-ajax-url="{{ route('skpd.data') }}" data-tab="pengajuan"
          data-options='{"searchPlaceholder":"Cari rekening, SKPD, bank...","emptyText":"Tidak ada data"}'>
          <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
              <th data-col="DT_RowIndex" data-orderable="false" data-searchable="false" data-width="50px">#</th>
              <th data-col="no_rekening">Rekening</th>
              <th data-col="nama_skpd">SKPD</th>
              <th data-col="nama_bank">Bank</th>
              <th data-col="saldo_tunai" data-orderable="false" data-searchable="false">Saldo</th>
              <th data-col="action" data-orderable="false" data-searchable="false" data-width="160px">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-gray-600 fw-semibold"></tbody>
        </table>

      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      (function() {
        document.querySelectorAll('#rekeningTabs a[data-tab-value]').forEach(function(link) {
          link.addEventListener('click', function(e) {
            e.preventDefault();

            // Active state
            document.querySelectorAll('#rekeningTabs a[data-tab-value]').forEach(function(el) {
              el.classList.remove('active');
            });
            this.classList.add('active');

            // Ganti tab → DTM handle destroy + re-boot otomatis
            DataTableManager.switchTab('skpdTable', this.dataset.tabValue);
          });
        });
      })();
    </script>
  @endpush
@endsection
