{{-- Modal Atur Metode Input Bulk --}}
<div class="modal fade" id="bulkMetodeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered mw-400px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Atur Metode Input</h5>
        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
          <i class="ki-duotone ki-cross fs-1">
            <span class="path1"></span><span class="path2"></span>
          </i>
        </div>
      </div>
      <div class="modal-body py-6">
        <div class="text-muted fs-7 mb-4">
          Akan diterapkan ke <strong id="modalSelectedCount">0</strong> akun yang dipilih.
        </div>
        <label class="form-label fw-semibold required">Metode Input</label>
        <select id="bulkMetodeSelect" class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#bulkMetodeModal"
          data-placeholder="-- Pilih Metode --" data-allow-clear="true">
          <option></option>
          <option value="harian">Harian</option>
          <option value="mingguan">Mingguan</option>
          <option value="bulanan">Bulanan</option>
          <option value="per_wajib_pajak">Per Wajib Pajak</option>
          <option value="per_wajib_retribusi">Per Wajib Retribusi</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="button" id="btnTerapkan" class="btn btn-primary">
          <span class="indicator-label">Terapkan</span>
          <span class="indicator-progress d-none">
            <span class="spinner-border spinner-border-sm me-2"></span>Memproses...
          </span>
        </button>
      </div>
    </div>
  </div>
</div>
