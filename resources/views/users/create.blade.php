@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row mb-3">
      <div class="col">
        <h4 class="fw-bold">Tambah User</h4>
      </div>
      <div class="col-auto">
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
      </div>
    </div>

    <div class="card shadow-sm">
      <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}">
                @error('username')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">NIP</label>
                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}">
                @error('nip')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Role</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror">
                  <option value="">-- Pilih Role --</option>
                  @foreach ($roles as $role)
                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                      {{ $role->name }}
                    </option>
                  @endforeach
                </select>
                @error('role')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Simpan User</button>
        </form>
      </div>
    </div>
  </div>
@endsection
