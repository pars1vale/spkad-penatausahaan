@extends('layouts.dashboard.master')

@section('content')
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6 text-center">
        <h1 class="display-1 text-danger">403</h1>
        <h4>Akses Ditolak</h4>
        <p class="text-muted">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ url('/home') }}" class="btn btn-primary">Kembali ke Dashboard</a>
      </div>
    </div>
  </div>
@endsection
