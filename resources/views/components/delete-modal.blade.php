<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered mw-400px">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h2 class="fw-bold">Konfirmasi Hapus</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center py-10">
        <i class="ki-duotone ki-trash fs-5x text-danger mb-5 d-block">
          <span class="path1"></span><span class="path2"></span>
          <span class="path3"></span><span class="path4"></span>
          <span class="path5"></span>
        </i>
        <p class="fs-5 text-gray-700 mb-1">Apakah Anda yakin ingin menghapus:</p>
        <p class="fs-4 fw-bold text-gray-900 mb-0" id="deleteTargetName"></p>
      </div>
      <div class="modal-footer justify-content-center border-0 pt-0">
        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
        <form id="deleteForm" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>
