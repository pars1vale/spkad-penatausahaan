@extends('layouts.dashboard.master')

@section('content')
  <div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-7">
      <div>
        <h1 class="page-heading fw-bold fs-3 text-gray-900 my-0">Manajemen User</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
          <li class="breadcrumb-item text-muted">
            <a href="{{ url('/') }}" class="text-muted text-hover-primary">Dashboard</a>
          </li>
          <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
          <li class="breadcrumb-item text-muted">Manajemen User</li>
        </ul>
      </div>
      @can('user.create')
        <a href="{{ route('users.create') }}" class="btn btn-primary hover-scale">
          <i class="ki-duotone ki-plus fs-2"></i> Tambah User
        </a>
      @endcan
    </div>

    @include('components.flash-messages')

    <div class="card card-bordered ">
      <div class="card-body pt-6">
        {{-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
             DATATABLE — konfigurasi 100% di sini, nol JS di view ini.

             Pada <table>:
               data-ajax-url  = endpoint JSON controller
               data-options   = opsi tambahan (JSON, opsional)

             Pada <th>:
               data-col        = nama key dari JSON server (wajib)
               data-orderable  = "false" jika kolom tidak sortable
               data-searchable = "false" jika kolom tidak searchable
               data-width      = lebar kolom (opsional)
        ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ --}}

        <table id="usersTable" class="table table align-middle table-bordered" data-ajax-url="{{ route('users.data') }}"
          data-options='{"searchPlaceholder":"Cari user...","emptyText":"Belum ada data user"}'>
          <thead>
            <tr class="text-start text-gray-800 fw-bold fs-7 text-uppercase gs-0">
              <th data-col="DT_RowIndex" data-orderable="false" data-searchable="false" data-width="50px">#</th>
              <th data-col="name">Nama</th>
              <th data-col="username">Username</th>
              <th data-col="nip">NIP</th>
              <th data-col="role" data-orderable="false" data-searchable="false">Role</th>
              <th data-col="last_login" data-orderable="false" data-searchable="false">Login Terakhir</th>
              <th data-col="action" data-orderable="false" data-searchable="false" data-width="130px">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-gray-600 fw-semibold"></tbody>
        </table>

      </div>
    </div>

  </div>

  @include('components.delete-modal')
@endsection
