@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row mb-3">
      <div class="col">
        <h4 class="fw-bold">Manajemen User</h4>
      </div>
      <div class="col-auto">
        @can('user.create')
          <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah User
          </a>
        @endcan
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
              <th>Nama</th>
              <th>Username</th>
              <th>NIP</th>
              <th>Role</th>
              <th>Login Terakhir</th>
              <th width="150">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $user)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->nip }}</td>
                <td>
                  @foreach ($user->roles as $role)
                    <span class="badge bg-primary">{{ $role->name }}</span>
                  @endforeach
                </td>
                <td>
                  {{ $user->last_login ? $user->last_login->format('d/m/Y H:i') : '-' }}
                </td>
                <td>
                  @can('user.edit')
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                  @endcan
                  @can('user.delete')
                    @if (!$user->hasRole('superadmin') && $user->id !== auth()->id())
                      <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                      </form>
                    @endif
                  @endcan
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-4">Belum ada user.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
