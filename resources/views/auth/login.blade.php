@extends('layouts.auth.app')

@section('content')
  <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
    <form class="form w-100" method="POST" novalidate="novalidate" id="kt_sign_in_form" action="{{ route('login') }}">
      @csrf

      {{-- Heading --}}
      <div class="text-center mb-11">
        <h1 class="text-gray-900 fw-bolder mb-3">LOG IN</h1>
        <div class="text-gray-500 fw-semibold fs-6">
          Mohon masukan informasi akun Anda untuk menggunakan Modul Penatausahaan
        </div>
      </div>

      {{-- Tahun Anggaran --}}
      <div class="fv-row mb-8">
        <label class="required form-label">Tahun</label>
        <div class="dropdown">

          {{-- Trigger --}}
          <div class="d-flex align-items-center justify-content-between p-3" id="tahunDropdown" data-bs-toggle="dropdown" aria-expanded="false"
            style="border: 1px solid #E4E6EF; border-radius: 0.475rem; background: #fff; cursor: pointer;">
            <div class="d-flex align-items-center gap-3">
              <div class="d-flex align-items-center justify-content-center" style="width:36px; height:36px; background:#F1F3FF; border-radius:8px;">
                <i class="ki-outline ki-calendar fs-3 text-primary"></i>
              </div>
              <div class="d-flex flex-column">
                <span class="fw-bold text-gray-900 fs-6" id="selectedTahunLabel">
                  Tahun Anggaran {{ date('Y') }}
                </span>
                <span class="fw-semibold fs-8 text-success">
                  <span class="bullet bullet-dot bg-success me-1 h-6px w-6px"></span>
                  Tahun Anggaran
                </span>
              </div>
            </div>
            <i class="ki-outline ki-down fs-4 text-gray-500"></i>
          </div>

          {{-- Menu --}}
          <div class="dropdown-menu w-100 p-2 shadow" style="border-radius: 0.475rem; border: 1px solid #E4E6EF;">
            @php
              $tahunAktif = (int) date('Y');
              $tahunList = range($tahunAktif + 1, $tahunAktif - 3);
            @endphp
            @foreach ($tahunList as $tahun)
              <div class="tahun-option d-flex align-items-center gap-3 p-3 rounded mb-1" data-tahun="{{ $tahun }}"
                style="cursor: pointer; transition: background 0.15s;">
                <div class="tahun-icon-box d-flex align-items-center justify-content-center"
                  style="width:36px; height:36px; border-radius:8px; flex-shrink:0;">
                  <i class="ki-outline ki-calendar fs-3"></i>
                </div>
                <div class="d-flex flex-column">
                  <span class="tahun-label fw-bold fs-6">
                    Tahun Anggaran {{ $tahun }}
                  </span>
                  <span class="tahun-sublabel fw-semibold fs-8">
                    <span class="tahun-bullet bullet bullet-dot me-1 h-6px w-6px" style="display:inline-block; border-radius:50%;"></span>
                    Tahun Anggaran
                  </span>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <input type="hidden" name="tahun_anggaran" id="tahunAnggaranInput" value="{{ date('Y') }}">
        @error('tahun_anggaran')
          <span class="text-danger fs-7">{{ $message }}</span>
        @enderror
      </div>

      {{-- Username / NIP --}}
      <div class="fv-row mb-8">
        <label class="required form-label">Username / NIP</label>
        <input type="text" name="username" placeholder="Username atau NIP" value="{{ old('username') }}" autocomplete="off" autofocus
          class="form-control @error('username') is-invalid @enderror" />
        @error('username')
          <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
      </div>

      {{-- Password --}}
      <div class="fv-row mb-8">
        <label class="required form-label">Kata Sandi</label>
        <input type="password" name="password" placeholder="8 karakter atau lebih" autocomplete="off"
          class="form-control @error('password') is-invalid @enderror" />
        @error('password')
          <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
      </div>

      {{-- Submit --}}
      <div class="d-grid mb-10">
        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
          <span class="indicator-label">Masuk Ke Sistem</span>
          <span class="indicator-progress">Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
          </span>
        </button>
      </div>

    </form>
  </div>
@endsection

@section('js')
  <script src="{{ asset('js/auth/login.js') }}"></script>
@endsection
