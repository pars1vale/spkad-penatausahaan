@extends('layouts.dashboard.master')

@section('content')
  <div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
      <div>
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
          Besaran UP
        </h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
          <li class="breadcrumb-item text-muted">
            <a href="{{ url('/') }}" class="text-muted text-hover-primary">Beranda</a>
          </li>
          <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
          </li>
          <li class="breadcrumb-item text-muted">Besaran UP</li>
        </ul>
      </div>

      @can('besaran-up.create')
        <a href="{{ route('besaran-up.create') }}" class="btn btn-primary hover-scale">
          <i class="ki-duotone ki-plus fs-4 me-1">
            <span class="path1"></span><span class="path2"></span>
          </i>
          Tambah Data
        </a>
      @endcan
    </div>

    @include('components.flash-messages')

    <div class="card card-bordered ">
      <div class="card-body pt-6">
        <table id="besaranUpTable" data-ajax-url="{{ route('besaran-up.data') }}"
          data-options='{"searchPlaceholder":"Cari SKPD...","emptyText":"Belum Ada Data Besaran UP"}'>
          <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
              <th data-col="DT_RowIndex" data-orderable="false" data-searchable="false" data-width="50px">#</th>
              <th data-col="nama_skpd">SKPD</th>
              <th data-col="pagu" data-orderable="true" data-class-name="text-start" data-width="180px">Pagu</th>
              <th data-col="besaran_up" data-orderable="true" data-class-name="text-start" data-width="180px">Besaran UP</th>
              <th data-col="besaran_up_kkpd" data-orderable="true" data-class-name="text-start" data-width="210px">Besaran UP KKPD</th>
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
