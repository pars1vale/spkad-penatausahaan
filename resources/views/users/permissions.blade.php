@extends('layouts.dashboard.master')

@section('content')
  <div class="container-fluid">
    <div class="row mb-3">
      <div class="col">
        <h4 class="fw-bold">
          Permission User:
          <span class="text-primary">{{ $user->name }}</span>
        </h4>
        <p class="text-muted mb-0">
          Role aktif:
          @foreach ($user->roles as $role)
            <span class="badge bg-primary">{{ $role->name }}</span>
          @endforeach
        </p>
      </div>
      <div class="col-auto">
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
      </div>
    </div>

    {{-- Info permission dari role --}}
    @if (count($rolePermissions) > 0)
      <div class="alert alert-info">
        <strong>Permission dari Role:</strong>
        Permission berikut sudah aktif otomatis karena role user ini.
        Centang di bawah adalah <u>tambahan permission langsung</u> di luar role.
        <div class="mt-2">
          @foreach ($rolePermissions as $rp)
            <span class="badge bg-info text-dark me-1">{{ $rp }}</span>
          @endforeach
        </div>
      </div>
    @endif

    <div class="card shadow-sm">
      <div class="card-body">
        <form action="{{ route('users.permissions.update', $user) }}" method="POST">
          @csrf @method('PUT')

          <div class="row">
            @foreach ($permissions as $group => $perms)
              <div class="col-md-4 mb-3">
                <div class="card border">
                  <div class="card-header py-2 bg-light d-flex justify-content-between align-items-center">
                    <strong class="text-capitalize">{{ $group }}</strong>
                    {{-- Tombol centang semua per group --}}
                    <button type="button" class="btn btn-outline-secondary btn-xs py-0 px-2" onclick="toggleGroup('group_{{ $group }}')">
                      Pilih Semua
                    </button>
                  </div>
                  <div class="card-body py-2" id="group_{{ $group }}">
                    @foreach ($perms as $permission)
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                          id="perm_{{ $permission->id }}" {{ in_array($permission->name, $directPermissions) ? 'checked' : '' }}
                          {{ in_array($permission->name, $rolePermissions) ? 'disabled' : '' }}>
                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                          {{ $permission->name }}
                          @if (in_array($permission->name, $rolePermissions))
                            <span class="text-info small">(dari role)</span>
                          @endif
                        </label>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <button type="submit" class="btn btn-primary mt-2">Simpan Permission</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    function toggleGroup(groupId) {
      const group = document.getElementById(groupId);
      const checkboxes = group.querySelectorAll('input[type="checkbox"]:not([disabled])');
      const allChecked = [...checkboxes].every(cb => cb.checked);
      checkboxes.forEach(cb => cb.checked = !allChecked);
    }
  </script>
@endsection
