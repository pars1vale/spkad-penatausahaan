@extends('layouts.auth.app')

@section('content')
  <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
    <form class="form w-100" method="POST" novalidate="novalidate" id="kt_sign_up_form" action="{{ route('register') }}">
      @csrf

      {{-- Heading --}}
      <div class="text-center mb-11">
        <h1 class="text-gray-900 fw-bolder mb-3">REGISTRASI</h1>
        <div class="text-gray-500 fw-semibold fs-6">
          Buat akun baru untuk menggunakan Modul Penatausahaan
        </div>
      </div>

      {{-- Success message --}}
      @if (session('success'))
        <div class="alert alert-success d-flex align-items-center p-3 mb-8">
          <i class="ki-outline ki-shield-tick fs-2 text-success me-3"></i>
          <div class="text-success fw-semibold">{{ session('success') }}</div>
        </div>
      @endif

      {{-- Username --}}
      <div class="fv-row mb-8">
        <label class="required form-label">Username</label>
        <div class="input-group">
          <span class="input-group-text border-end-0" style="background:#F9F9F9; border: 1px solid #E4E6EF; border-radius: 0.475rem 0 0 0.475rem;">
            <i class="ki-outline ki-profile-circle fs-3 text-primary"></i>
          </span>
          <input type="text" name="username" placeholder="Masukkan username unik" value="{{ old('username') }}" autocomplete="off" autofocus
            class="form-control border-start-0 @error('username') is-invalid @enderror" style="border: 1px solid #E4E6EF; border-left: none;" />
          @error('username')
            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
          @enderror
        </div>
        <div class="text-muted fs-8 mt-1">Username digunakan untuk login ke sistem.</div>
      </div>

      {{-- NIP --}}
      <div class="fv-row mb-8">
        <label class="required form-label">NIP</label>
        <div class="input-group">
          <span class="input-group-text border-end-0" style="background:#F9F9F9; border: 1px solid #E4E6EF; border-radius: 0.475rem 0 0 0.475rem;">
            <i class="ki-outline ki-badge fs-3 text-primary"></i>
          </span>
          <input type="text" name="nip" placeholder="Masukkan NIP (angka saja)" value="{{ old('nip') }}" autocomplete="off"
            inputmode="numeric" class="form-control border-start-0 @error('nip') is-invalid @enderror"
            style="border: 1px solid #E4E6EF; border-left: none;" />
          @error('nip')
            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
          @enderror
        </div>
        <div class="text-muted fs-8 mt-1">NIP dapat digunakan sebagai alternatif login.</div>
      </div>

      {{-- Password --}}
      <div class="fv-row mb-8">
        <label class="required form-label">Kata Sandi</label>
        <div class="position-relative">
          <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" autocomplete="new-password"
            class="form-control @error('password') is-invalid @enderror" style="border: 1px solid #E4E6EF; padding-right: 45px;" />
          <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer" id="togglePassword">
            <i class="ki-outline ki-eye-slash fs-3 text-gray-400" id="eyeIcon"></i>
          </span>
          @error('password')
            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
          @enderror
        </div>

        {{-- Password strength meter --}}
        <div class="d-flex align-items-center mt-2 gap-1" id="passwordMeter">
          <div class="flex-grow-1 rounded h-5px bg-secondary" id="meter1"></div>
          <div class="flex-grow-1 rounded h-5px bg-secondary" id="meter2"></div>
          <div class="flex-grow-1 rounded h-5px bg-secondary" id="meter3"></div>
          <div class="flex-grow-1 rounded h-5px bg-secondary" id="meter4"></div>
        </div>
        <div class="text-muted fs-8 mt-1">Gunakan minimal 8 karakter dengan kombinasi huruf dan angka.</div>
      </div>

      {{-- Konfirmasi Password --}}
      <div class="fv-row mb-8">
        <label class="required form-label">Konfirmasi Kata Sandi</label>
        <div class="position-relative">
          <input type="password" name="password_confirmation" id="passwordConfirm" placeholder="Ulangi kata sandi" autocomplete="new-password"
            class="form-control" style="border: 1px solid #E4E6EF; padding-right: 45px;" />
          <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer" id="togglePasswordConfirm">
            <i class="ki-outline ki-eye-slash fs-3 text-gray-400" id="eyeIconConfirm"></i>
          </span>
        </div>
        <div class="text-muted fs-8 mt-1" id="passwordMatchInfo"></div>
      </div>

      {{-- Submit --}}
      <div class="d-grid mb-8">
        <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
          <span class="indicator-label">Buat Akun</span>
          <span class="indicator-progress">Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
          </span>
        </button>
      </div>

      {{-- Link ke login --}}
      <div class="text-gray-500 text-center fw-semibold fs-6">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="link-primary fw-semibold">Login di sini</a>
      </div>

    </form>
  </div>
@endsection

@section('js')
  <script src="{{ asset('js/auth/register.js') }}"></script>
@endsection
