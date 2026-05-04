@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row mb-3">
      <div class="col">
        <h4 class="fw-bold">Edit Role: <span class="text-primary">{{ $role->name }}</span></h4>
      </div>
      <div class="col-auto">
        <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
      </div>
    </div>

    <div class="card shadow-sm">
      <div class="card-body">
        <form action="{{ route('roles.update', $role) }}" method="POST">
          @csrf @method('PUT')

          <div class="mb-4">
            <label class="form-label fw-semibold">Nama Role</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role->name) }}">
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold">Permissions</label>
            <div class="row">
              @foreach ($permissions as $group => $perms)
                <div class="col-md-4 mb-3">
                  <div class="card border">
                    <div class="card-header py-2 bg-light">
                      <strong class="text-capitalize">{{ $group }}</strong>
                    </div>
                    <div class="card-body py-2">
                      @foreach ($perms as $permission)
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            id="perm_{{ $permission->id }}" {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                          <label class="form-check-label" for="perm_{{ $permission->id }}">
                            {{ $permission->name }}
                          </label>
                        </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <button type="submit" class="btn btn-warning">Update Role</button>
        </form>
      </div>
    </div>
  </div>
@endsection
