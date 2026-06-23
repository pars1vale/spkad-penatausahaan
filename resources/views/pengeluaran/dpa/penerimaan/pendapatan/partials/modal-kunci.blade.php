<div class="modal fade" id="kunciModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered mw-400px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="kunciModalTitle">Konfirmasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-5 text-center">
        <p class="fs-6 fw-semibold" id="kunciModalMessage"></p>
        <p class="text-muted fs-7" id="kunciModalName"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <form id="kunciForm" method="POST" action="">
          @csrf
          @method('PATCH')
          <button type="submit" class="btn btn-active-light-primary" id="kunciSubmitBtn">
            Ya, Lanjutkan
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
  <script>
    // Delegasi klik tombol kunci/buka kunci
    document.addEventListener('click', function(e) {
      const btn = e.target.closest('.btn-toggle-kunci');
      if (!btn) return;

      const url = btn.dataset.url;
      const name = btn.dataset.name;
      const confirm = btn.dataset.confirm;

      document.getElementById('kunciModalMessage').textContent = confirm;
      document.getElementById('kunciModalName').textContent = name;
      document.getElementById('kunciForm').action = url;

      const modal = new bootstrap.Modal(document.getElementById('kunciModal'));
      modal.show();
    });
  </script>
@endpush
