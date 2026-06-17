@extends('layouts.dashboard.master')

@section('content')
  <div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
      <div>
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
          Pegawai
        </h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
          <li class="breadcrumb-item text-muted">
            <a href="{{ url('/') }}" class="text-muted text-hover-primary">Beranda</a>
          </li>
          <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
          </li>
          <li class="breadcrumb-item text-muted">Pegawai</li>
        </ul>
      </div>

      @can('pegawai.create')
        <a href="{{ route('pegawai.create') }}" class="btn btn-primary hover-scale">
          <i class="ki-duotone ki-plus fs-4 me-1">
            <span class="path1"></span><span class="path2"></span>
          </i>
          Tambah Data
        </a>
      @endcan
    </div>

    @include('components.flash-messages')

    {{-- <div class="card shadow-sm"> --}}
    <div class="card card-bordered ">
      <div class="card-body pt-6">
        <table id="pegawaiTable" class="table table-bordered" data-ajax-url="{{ route('pegawai.data') }}"
          data-options='{"searchPlaceholder":"Cari nama pegawai atau jabatan...","emptyText":"Belum ada data pegawai"}'>
          <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
              <th data-col="DT_RowIndex" data-orderable="false" data-searchable="false" data-width="50px">#</th>
              <th data-col="nama_user">Nama Pegawai</th>
              <th data-col="nama_role" data-width="200px">Jabatan</th>
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
