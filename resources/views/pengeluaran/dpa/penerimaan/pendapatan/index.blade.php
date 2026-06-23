@extends('layouts.dashboard.master')

@section('content')
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <div>
        <h1 class="page-heading d-flex fw-bold fs-3 flex-column justify-content-center my-0">
          Dokumen Pelaksanaan Anggaran (DPA) | Pendapatan
        </h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
          <li class="breadcrumb-item text-muted">Pengeluaran</li>
          <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
          </li>
          <li class="breadcrumb-item text-muted">DPA</li>
          <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
          </li>
          <li class="breadcrumb-item text-muted">Penerimaan</li>
          <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
          </li>
          <li class="breadcrumb-item text-muted">Pendapatan</li>
        </ul>
      </div>
      @can('dpa-pendapatan.create')
        <a href="{{ route('dpa-pendapatan.create') }}" class="btn btn-primary hover-scale">
          <i class="ki-duotone ki-plus fs-2"></i>
          Tambah Data
        </a>
      @endcan
    </div>

    @include('components.flash-messages')
    <div class="card card-bordered mb-5">
      <div class="card-body py-5">
        <div class="d-flex align-items-center gap-5 flex-wrap">
          <div class="d-flex flex-column align-items-start border-start ps-5">
            <div class="d-flex align-items-center gap-2">
              <i class="ki-duotone ki-office-bag fs-2 text-warning">
                <span class="path1"></span><span class="path2"></span>
              </i>
              <span class="fw-bold fs-5 text-gray-800">
                {{ $jumlahSkpd }}
              </span>
            </div>
            <span class="text-muted fs-7">Jumalh SKPD</span>
          </div>

          <div class="d-flex flex-column align-items-start border-start ps-5">
            <div class="d-flex align-items-center gap-2">
              <i class="ki-duotone ki-key fs-2 text-success">
                <span class="path1"></span><span class="path2"></span>
              </i>
              <span class="fw-bold fs-5 text-gray-800">
                {{ $skpdTerbuka }}
              </span>
            </div>
            <span class="text-muted fs-7">Terbuka</span>
          </div>

          <div class="d-flex flex-column align-items-start border-start ps-5">
            <div class="d-flex align-items-center gap-2">
              <i class="ki-duotone ki-lock-3 fs-2 text-danger">
                <span class="path1"></span><span class="path2"></span>
              </i>
              <span class="fw-bold fs-5 text-gray-800">
                {{ $skpdTerkunci }}
              </span>
            </div>
            <span class="text-muted fs-7">Terkunci</span>
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
        </div>
      </div>
    </div>
    <div class="card card-bordered">
      <div class="card-body pt-6">
        <table id="dpaPendapatanTable" data-ajax-url="{{ route('dpa-pendapatan.data') }}"
          data-options='{"searchPlaceholder":"Cari SKPD...","emptyText":"Tidak ada data DPA Pendapatan"}' class="table table-bordered">
          <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
              <th data-col="DT_RowIndex" data-orderable="false" data-searchable="false" data-width="40px">#</th>
              <th data-col="skpd">SKPD</th>
              <th data-col="nilai" data-orderable="true" data-searchable="false">Alokasi Anggaran</th>
              <th data-col="nilai_rak" data-orderable="true" data-searchable="false">RAK</th>
              <th data-col="progres" data-orderable="false" data-searchable="false">Progres</th>
              <th data-col="status" data-orderable="false" data-searchable="false">Status</th>
              <th data-col="action" data-orderable="false" data-searchable="false" data-width="400px">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-gray-600 fw-semibold"></tbody>
        </table>
      </div>
    </div>

  </div>

  @include('components.delete-modal')
  @include('pengeluaran.dpa.penerimaan.pendapatan.partials.modal-kunci')
@endsection
