@if (session('success'))
  <div class="alert alert-dismissible bg-light-success d-flex align-items-center p-5 mb-7">
    <i class="ki-duotone ki-check-circle fs-2hx text-success me-4">
      <span class="path1"></span><span class="path2"></span>
    </i>
    <span class="fw-semibold">{{ session('success') }}</span>
    <button type="button" class="position-absolute top-0 end-0 m-2 btn btn-icon" data-bs-dismiss="alert">
      <i class="ki-duotone ki-cross fs-2 text-success"><span class="path1"></span><span class="path2"></span></i>
    </button>
  </div>
@endif
@if (session('error'))
  <div class="alert alert-dismissible bg-light-danger d-flex align-items-center p-5 mb-7">
    <i class="ki-duotone ki-cross-circle fs-2hx text-danger me-4">
      <span class="path1"></span><span class="path2"></span>
    </i>
    <span class="fw-semibold">{{ session('error') }}</span>
    <button type="button" class="position-absolute top-0 end-0 m-2 btn btn-icon" data-bs-dismiss="alert">
      <i class="ki-duotone ki-cross fs-2 text-danger"><span class="path1"></span><span class="path2"></span></i>
    </button>
  </div>
@endif
