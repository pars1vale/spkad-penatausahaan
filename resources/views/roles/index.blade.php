@extends('layouts.dashboard.master')

@section('content')
  <div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-7">
      <div>
        <h1 class="page-heading fw-bold fs-3 text-gray-900 my-0">Manajemen Role</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
          <li class="breadcrumb-item text-muted">
            <a href="{{ url('/') }}" class="text-muted text-hover-primary">Dashboard</a>
          </li>
          <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
          <li class="breadcrumb-item text-muted">Manajemen Role</li>
        </ul>
      </div>
      <a href="{{ route('roles.create') }}" class="btn btn-primary hover-scale">
        <i class="ki-duotone ki-plus fs-2"></i> Tambah Role
      </a>
    </div>

    @include('components.flash-messages')

    <div class="card card-bordered ">
      <div class="card-body pt-6">
        <table id="rolesTable" class="table align-middle table-bordered" data-ajax-url="{{ route('roles.data') }}"
          data-options='{"searchPlaceholder":"Cari role...","emptyText":"Belum ada data role"}'>
          <thead>
            <tr class="text-start text-gray-800 fw-bold fs-7 text-uppercase gs-0">
              <th data-col="DT_RowIndex" data-orderable="false" data-searchable="false" data-width="50px">#</th>
              <th data-col="name">Nama Role</th>
              <th data-col="permissions_count" data-orderable="false" data-searchable="false">Jumlah Permission</th>
              <th data-col="users_count" data-orderable="false" data-searchable="false">Jumlah User</th>
              <th data-col="action" data-orderable="false" data-searchable="false" data-width="120px">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-gray-600 fw-semibold"></tbody>
        </table>

      </div>
    </div>

  </div>

  @include('components.delete-modal')
@endsection
