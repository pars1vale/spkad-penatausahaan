@extends('layouts.dashboard.master')

@section('content')
  <div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-7">
      <div>
        <h1 class="page-heading fw-bold fs-3 text-gray-900 my-0">Perangkat Daerah</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
          <li class="breadcrumb-item text-muted">
            <a href="{{ url('/') }}" class="text-muted text-hover-primary">Dashboard</a>
          </li>
          <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
          <li class="breadcrumb-item text-muted">Perangkat Daerah</li>
        </ul>
      </div>
      @can('perangkat-daerah.create')
        <a href="{{ route('perangkat-daerah.create') }}" class="btn btn-primary hover-scale">
          <i class="ki-duotone ki-plus fs-2"></i> Tambah Data
        </a>
      @endcan
    </div>

    @include('components.flash-messages')

    <div class="card card-bordered ">
      <div class="card-body pt-6">
        <table id="perangkatDaerahTable" class="table align-middle table-bordered fs-6 gy-5" data-ajax-url="{{ route('perangkat-daerah.data') }}"
          data-options='{"searchPlaceholder":"Cari SKPD...","emptyText":"Belum ada data perangkat daerah"}'>
          <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
              <th data-col="DT_RowIndex" data-orderable="false" data-searchable="false" data-width="50px">#</th>
              <th data-col="kode_skpd" data-width="120px">Kode SKPD</th>
              <th data-col="nama_skpd">Nama SKPD</th>
              <th data-col="tahun" data-width="80px">Tahun</th>
              <th data-col="nilai" data-orderable="false" data-searchable="false">Nilai Anggaran</th>
              <th data-col="nilai_rak" data-orderable="false" data-searchable="false">Nilai RAK</th>
              <th data-col="status" data-orderable="false" data-searchable="false" data-width="100px">Status</th>
              <th data-col="action" data-orderable="false" data-searchable="false" data-width="100px">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-gray-600 fw-semibold"></tbody>
        </table>
      </div>
    </div>

  </div>

  @include('components.delete-modal')
@endsection
