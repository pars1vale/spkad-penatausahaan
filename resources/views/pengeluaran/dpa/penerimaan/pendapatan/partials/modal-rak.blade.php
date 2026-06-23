<div class="modal fade" id="rakModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <div class="d-flex flex-column">
          <h5 class="modal-title fw-bold" id="rakModalNamaAkun">—</h5>
          <span class="text-muted fs-7" id="rakModalKodeAkun"></span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      {{-- Alert terkunci --}}
      <div id="rakLockedAlert" class="alert alert-danger d-flex align-items-center gap-2 mx-5 mt-4 mb-0 d-none">
        <i class="ki-solid ki-lock fs-1 text-danger">
          <span class="path1"></span><span class="path2"></span>
        </i>
        <span>Rencana Anggaran Kas (RAK) Sudah Terkunci</span>
      </div>

      <div class="modal-body py-5 px-7">

        {{-- Summary: Total Nilai Anggaran, Total RAK, Total Selisih, Total Realisasi --}}
        <div class="row g-4 mb-6">
          <div class="col-6">
            <div class="d-flex flex-column">
              <span class="text-muted fs-7">Total Nilai Anggaran</span>
              <span class="fw-bold fs-4 text-gray-800" id="rakSummaryNilai">Rp0,00</span>
            </div>
          </div>
          <div class="col-6">
            <div class="d-flex flex-column">
              <span class="text-muted fs-7">Total RAK</span>
              <span class="fw-bold fs-4 text-gray-800" id="rakSummaryRak">Rp0,00</span>
            </div>
          </div>
          <div class="col-6">
            <div class="d-flex flex-column">
              <span class="text-muted fs-7">Total Selisih</span>
              <span class="fw-bold fs-4 text-gray-800" id="rakSummarySelisih">Rp0,00</span>
            </div>
          </div>
          <div class="col-6">
            <div class="d-flex flex-column">
              <span class="text-muted fs-7">Total Realisasi</span>
              <span class="fw-bold fs-4 text-gray-800">Rp0,00</span>
            </div>
          </div>
        </div>

        <div class="separator mb-5"></div>

        {{-- Grid 12 bulan: 2 kolom (Januari-Juni kiri, Juli-Desember kanan) --}}
        <form id="rakForm">
          @csrf
          <input type="hidden" id="rakDetailId" name="_detail_id">
          <input type="hidden" id="rakUpdateUrl" name="_update_url">

          <div class="row g-4">
            @php
              $bulanList = [
                  ['januari', 'Januari'],
                  ['februari', 'Februari'],
                  ['maret', 'Maret'],
                  ['april', 'April'],
                  ['mei', 'Mei'],
                  ['juni', 'Juni'],
                  ['juli', 'Juli'],
                  ['agustus', 'Agustus'],
                  ['september', 'September'],
                  ['oktober', 'Oktober'],
                  ['november', 'November'],
                  ['desember', 'Desember'],
              ];
              $kiri = array_slice($bulanList, 0, 6);
              $kanan = array_slice($bulanList, 6, 6);
            @endphp

            <div class="col-6">
              @foreach ($kiri as [$field, $label])
                <div class="card border mb-3">
                  <div class="card-body py-3 px-4">
                    <div class="fw-semibold fs-6 mb-2">{{ $label }}</div>
                    <div class="d-flex justify-content-between text-muted fs-7 mb-1">
                      <span>RAK</span>
                      <span class="rak-bulan-display" data-bulan="{{ $field }}">Rp0,00</span>
                    </div>
                    <div class="d-flex justify-content-between text-muted fs-7 mb-2">
                      <span>Realisasi</span>
                      <span>Rp0,00</span>
                    </div>
                    <input type="number" name="{{ $field }}" id="rak_{{ $field }}" class="form-control form-control-sm rak-input"
                      data-bulan="{{ $field }}" min="0" value="0" placeholder="0">
                  </div>
                </div>
              @endforeach
            </div>

            <div class="col-6">
              @foreach ($kanan as [$field, $label])
                <div class="card border mb-3">
                  <div class="card-body py-3 px-4">
                    <div class="fw-semibold fs-6 mb-2">{{ $label }}</div>
                    <div class="d-flex justify-content-between text-muted fs-7 mb-1">
                      <span>RAK</span>
                      <span class="rak-bulan-display" data-bulan="{{ $field }}">Rp0,00</span>
                    </div>
                    <div class="d-flex justify-content-between text-muted fs-7 mb-2">
                      <span>Realisasi</span>
                      <span>Rp0,00</span>
                    </div>
                    <input type="number" name="{{ $field }}" id="rak_{{ $field }}" class="form-control form-control-sm rak-input"
                      data-bulan="{{ $field }}" min="0" value="0" placeholder="0">
                  </div>
                </div>
              @endforeach
            </div>

          </div>
        </form>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="rakSimpanBtn">
          <span class="indicator-label">Simpan</span>
          <span class="indicator-progress d-none">
            <span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...
          </span>
        </button>
      </div>

    </div>
  </div>
</div>

@push('scripts')
  <script>
    (function() {
      const BULAN = [
        'januari', 'februari', 'maret', 'april', 'mei', 'juni',
        'juli', 'agustus', 'september', 'oktober', 'november', 'desember'
      ];

      const fmt = (n) => 'Rp ' + Number(n).toLocaleString('id-ID') + ',00';

      // Hitung ulang summary Total RAK & Selisih saat input berubah
      function recalcSummary() {
        const totalRak = BULAN.reduce((sum, b) => {
          return sum + (parseInt(document.getElementById('rak_' + b)?.value) || 0);
        }, 0);
        const totalNilai = parseInt(document.getElementById('rakSummaryNilai').dataset.raw) || 0;

        document.getElementById('rakSummaryRak').textContent = fmt(totalRak);
        document.getElementById('rakSummarySelisih').textContent = fmt(totalNilai - totalRak);

        // Update display per bulan di kartu
        BULAN.forEach(b => {
          const val = parseInt(document.getElementById('rak_' + b)?.value) || 0;
          const el = document.querySelector('.rak-bulan-display[data-bulan="' + b + '"]');
          if (el) el.textContent = fmt(val);
        });
      }

      // Populate modal saat row diklik
      document.addEventListener('click', function(e) {
        const row = e.target.closest('tr[data-raw]');
        if (!row) return;

        let raw;
        try {
          raw = JSON.parse(row.dataset.raw);
        } catch {
          return;
        }

        const isLocked = raw.is_locked;

        // Header
        document.getElementById('rakModalNamaAkun').textContent = raw.nama_akun ?? '—';
        document.getElementById('rakModalKodeAkun').textContent = raw.kode_akun ?? '';

        // Lock alert
        document.getElementById('rakLockedAlert').classList.toggle('d-none', !isLocked);

        // Summary
        const nilaiEl = document.getElementById('rakSummaryNilai');
        nilaiEl.textContent = fmt(raw.nilai ?? 0);
        nilaiEl.dataset.raw = raw.nilai ?? 0;

        // Hidden fields
        document.getElementById('rakDetailId').value = raw.id;
        document.getElementById('rakUpdateUrl').value = row.dataset.updateUrl;

        // Populate & lock/unlock inputs
        BULAN.forEach(b => {
          const input = document.getElementById('rak_' + b);
          if (!input) return;
          input.value = raw[b] ?? 0;
          input.disabled = isLocked;
          input.classList.toggle('bg-light', isLocked);
        });

        // Tombol simpan
        document.getElementById('rakSimpanBtn').disabled = isLocked;

        recalcSummary();

        new bootstrap.Modal(document.getElementById('rakModal')).show();
      });

      // Live recalc saat mengetik
      document.addEventListener('input', function(e) {
        if (e.target.classList.contains('rak-input')) recalcSummary();
      });

      // Reset form saat modal ditutup
      document.getElementById('rakModal')?.addEventListener('hidden.bs.modal', function() {
        document.getElementById('rakForm').reset();
        BULAN.forEach(b => {
          const input = document.getElementById('rak_' + b);
          if (input) {
            input.value = 0;
            input.disabled = false;
          }
        });
        document.getElementById('rakLockedAlert').classList.add('d-none');
        document.getElementById('rakSimpanBtn').disabled = false;
        document.getElementById('rakSummaryNilai').textContent = 'Rp0,00';
        document.getElementById('rakSummaryRak').textContent = 'Rp0,00';
        document.getElementById('rakSummarySelisih').textContent = 'Rp0,00';
      });

      // Submit
      document.getElementById('rakSimpanBtn')?.addEventListener('click', async function() {
        const btn = this;
        const url = document.getElementById('rakUpdateUrl').value;
        const csrfToken = document.querySelector('#rakForm [name="_token"]').value;

        const payload = {
          _method: 'PATCH'
        };
        BULAN.forEach(b => {
          payload[b] = parseInt(document.getElementById('rak_' + b)?.value) || 0;
        });

        // Loading state
        btn.querySelector('.indicator-label').classList.add('d-none');
        btn.querySelector('.indicator-progress').classList.remove('d-none');
        btn.disabled = true;

        try {
          const res = await fetch(url, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken,
              'Accept': 'application/json',
            },
            body: JSON.stringify(payload),
          });

          const json = await res.json();

          if (json.success) {
            // Tutup modal & reload DataTable
            bootstrap.Modal.getInstance(document.getElementById('rakModal')).hide();
            if (typeof DataTableManager !== 'undefined') {
              DataTableManager.reload('dpaPendapatanDetailTable');
            }
          } else {
            alert(json.message ?? 'Gagal menyimpan data.');
          }
        } catch {
          alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
        } finally {
          btn.querySelector('.indicator-label').classList.remove('d-none');
          btn.querySelector('.indicator-progress').classList.add('d-none');
          btn.disabled = false;
        }
      });
    })();
  </script>
@endpush
