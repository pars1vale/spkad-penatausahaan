@extends('layouts.dashboard.masters')

@section('content')
  <div class="container-fluid">
    <div class="row mb-3">
      <div class="col">
        <h4 class="fw-bold">Manajemen Role</h4>
      </div>
      <div class="col-auto">
        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">
          <i class="bi bi-plus-lg"></i> Tambah Role
        </a>
      </div>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card shadow-sm">
      <div class="card-body p-0">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th width="50">#</th>
              <th>Nama Role</th>
              <th>Jumlah Permission</th>
              <th>Jumlah User</th>
              <th width="150">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($roles as $role)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  <span class="badge bg-secondary">{{ $role->name }}</span>
                </td>
                <td>{{ $role->permissions_count }}</td>
                <td>{{ $role->users()->count() }}</td>
                <td>
                  @if ($role->name !== 'superadmin')
                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Hapus role {{ $role->name }}?')">
                      @csrf @method('DELETE')
                      <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                  @else
                    <span class="text-muted small">Terlindungi</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">Belum ada role.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
