@extends('layouts.dashboard.master')

@section('content')
  <div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-7">
      <div>
        <h1 class="page-heading fw-bold fs-3 text-gray-900 my-0">Kebijakan SPD</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
          <li class="breadcrumb-item text-muted">
            <a href="{{ url('/') }}" class="text-muted text-hover-primary">Dashboard</a>
          </li>
          <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
          <li class="breadcrumb-item text-muted">SPD</li>
          <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
          <li class="breadcrumb-item text-muted">Kebijakan SPD</li>
        </ul>
      </div>
      @can('kebijakan-spd.create')
        <a href="{{ route('kebijakan-spd.create') }}" class="btn btn-primary hover-scale">
          <i class="ki-duotone ki-plus fs-2"></i> Tambah Data
        </a>
      @endcan
    </div>

    @include('components.flash-messages')

    <div class="card card-bordered ">
      <div class="card-body pt-6">
        <table id="kebijakanSpdTable" class="table align-middle table-bordered fs-6 gy-5" data-ajax-url="{{ route('kebijakan-spd.data') }}"
          data-options='{"searchPlaceholder":"Cari kebijakan SPD...","emptyText":"Belum ada data kebijakan SPD"}'>
          <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
              <th data-col="DT_RowIndex" data-orderable="false" data-searchable="false" data-width="50px">#</th>
              <th data-col="nama_periode">Periode SPD</th>
              <th data-col="tahun" data-width="130px">Tahun Anggaran</th>
              <th data-col="nama_penerbitan_spd">Penerbitan SPD</th>
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
