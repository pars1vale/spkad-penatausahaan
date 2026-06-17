@extends('layouts.dashboard.master')

@section('content')
  <div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-6">
      <div>
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
          Rekening Penerimaan
        </h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
          <li class="breadcrumb-item text-muted">Penatausahaan</li>
          <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
          </li>
          <li class="breadcrumb-item text-muted">Penerimaan</li>
          <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
          </li>
          <li class="breadcrumb-item text-muted">Konfigurasi Rekening</li>
        </ul>
      </div>
    </div>

    @include('components.flash-messages')

    <div class="card card-bordered mb-6">
      <div class="card-body py-5">
        <div class="row align-items-center g-4">
          <div class="col-md-8">
            <label class="form-label fw-bold text-gray-700 mb-2">
              Pilih SKPD
            </label>
            <div class="input-group flex-nowrap">
              <span class="input-group-text">
                <i class="ki-duotone ki-office-bag fs-3">
                  <span class="path1"></span><span class="path2"></span>
                  <span class="path3"></span><span class="path4"></span>
                </i>
              </span>
              <div class="overflow-hidden flex-grow-1">
                <select id="skpdSelect" class="form-select rounded-start-0" data-control="select2"
                  data-placeholder="-- Pilih Satuan Kerja Perangkat Daerah --" data-allow-clear="true">
                  <option></option>
                  @foreach ($skpdList as $skpd)
                    <option value="{{ $skpd->id_skpd }}" data-kode="{{ $skpd->kode_skpd }}" data-nama="{{ $skpd->nama_skpd }}">
                      {{ $skpd->kode_skpd }} — {{ $skpd->nama_skpd }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div id="skpdInfo" class="d-none">
              <div class="d-flex align-items-center gap-3 p-4 bg-light-primary rounded">
                <i class="ki-duotone ki-bank fs-2x text-primary">
                  <span class="path1"></span><span class="path2"></span>
                </i>
                <div>
                  <div class="fw-bold text-gray-900 fs-6" id="skpdInfoNama">—</div>
                  <div class="text-muted fs-7" id="skpdInfoKode">—</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="emptyState" class="card card-bordered">
      <div class="card-body py-20 text-center">
        <i class="ki-duotone ki-document fs-5x text-gray-300 mb-4">
          <span class="path1"></span><span class="path2"></span>
        </i>
        <div class="text-gray-500 fs-5 fw-semibold">Pilih SKPD terlebih dahulu</div>
        <div class="text-muted fs-7 mt-2">Data rekening penerimaan akan tampil setelah SKPD dipilih</div>
      </div>
    </div>

    <div id="tableCard" class="card card-bordered d-none">
      <div class="card-header border-0 pt-6">
        <div class="card-title">
          <span class="text-gray-700 fw-semibold fs-6">
            Akun Penerimaan — <span id="tableSkpdLabel" class="text-primary"></span>
          </span>
        </div>
        <div class="card-toolbar gap-3">
          {{-- Bulk action bar (hidden until rows selected) --}}
          <div id="bulkBar" class="d-none align-items-center gap-3">
            <span class="text-muted fs-7">
              <span id="selectedCount">0</span> baris dipilih
            </span>
            <button type="button" id="btnBulkMetode" class="btn btn-sm btn-primary">
              <i class="ki-duotone ki-pencil fs-5">
                <span class="path1"></span><span class="path2"></span>
              </i>
              Atur Metode
            </button>
            <button type="button" id="btnClearSelection" class="btn btn-sm btn-light-danger">
              Batal
            </button>
          </div>
          <div class="position-relative">
            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-3 top-50 translate-middle-y" style="pointer-events:none">
              <span class="path1"></span><span class="path2"></span>
            </i>
            <input type="text" id="tableSearch" class="form-control form-control-solid w-250px ps-10" placeholder="Cari kode atau nama akun...">
          </div>
        </div>
      </div>
      <div class="card-body pt-0">
        <div class="table-responsive">
          <table id="rekeningPenerimaanTable" class="table table-bordered" data-ajax-url="{{ route('rek-penerimaan.data') }}"
            data-options='{"searchPlaceholder":"Cari kode atau nama akun...","emptyText":"Tidak ada data akun penerimaan"}'>
            <thead>
              <tr class="text-start text-gray-700 fw-bold fs-7 text-uppercase gs-0 border-bottom border-gray-400">
                <th data-col="DT_RowIndex" data-orderable="false" data-searchable="false" data-width="50px">#</th>
                <th data-col="kode_akun" data-width="180px">Kode Akun</th>
                <th data-col="nama_akun">Nama Akun</th>
                <th data-col="metode_select" data-orderable="false" data-searchable="false" data-width="220px">Metode Input</th>
                <th data-col="bulk_check" data-orderable="false" data-searchable="false" data-width="50px" class="text-center">
                  <input type="checkbox" id="checkAll" class="form-check-input form-check-input-sm">
                </th>
              </tr>
            </thead>
            <tbody class="text-gray-600 fw-semibold"></tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

  @include('rekeningpenerimaan.modal-metode-input')
@endsection

@push('scripts')
  <script>
    (function() {
      'use strict';

      // ─── State ───────────────────────────────────────────────────────────────
      let currentSkpdId = null;
      let dtTable = null;
      let selectedIds = new Set();

      // ─── Metode label map ─────────────────────────────────────────────────────
      const metodeLabel = {
        harian: 'Harian',
        mingguan: 'Mingguan',
        bulanan: 'Bulanan',
        per_wajib_pajak: 'Per Wajib Pajak',
        per_wajib_retribusi: 'Per Wajib Retribusi',
      };

      // ─── SKPD Select2 ─────────────────────────────────────────────────────────
      function handleSkpdChange(id, nama, kode) {
        currentSkpdId = id || null;
        selectedIds.clear();

        if (!id) {
          $('#emptyState').removeClass('d-none');
          $('#tableCard').addClass('d-none');
          $('#skpdInfo').addClass('d-none');
          destroyTable();
          return;
        }

        $('#skpdInfoNama').text(nama);
        $('#skpdInfoKode').text(kode);
        $('#skpdInfo').removeClass('d-none');
        $('#tableSkpdLabel').text(nama);
        $('#emptyState').addClass('d-none');
        $('#tableCard').removeClass('d-none');

        initOrReloadTable(id);
      }

      $('#skpdSelect').on('select2:select', function(e) {
        const opt = e.params.data.element;
        const id = e.params.data.id;
        const nama = $(opt).data('nama') || e.params.data.text;
        const kode = $(opt).data('kode') || '';
        handleSkpdChange(id, nama, kode);
      });

      $('#skpdSelect').on('select2:clear', function() {
        handleSkpdChange(null, '', '');
      });

      // ─── DataTable init ───────────────────────────────────────────────────────
      // Simpan referensi tabel asli sekali saat halaman load
      const $tableOriginal = $('#rekeningPenerimaanTable').clone(true, true);

      function destroyTable() {
        if ($.fn.DataTable.isDataTable('#rekeningPenerimaanTable')) {
          // destroy(false) — hapus instance JS tapi jaga DOM
          $('#rekeningPenerimaanTable').DataTable().destroy(false);

          // Hapus wrapper yang dibuat DataTables, restore tabel ke card-body
          const $wrapper = $('#rekeningPenerimaanTable_wrapper');
          if ($wrapper.length) {
            // Lepas tabel dari dalam wrapper, taruh sebelum wrapper
            $wrapper.before($('#rekeningPenerimaanTable'));
            $wrapper.remove();
          }
        }

        dtTable = null;

        // Bersihkan tbody dan atribut sisa DataTables
        $('#rekeningPenerimaanTable tbody').empty();
        $('#rekeningPenerimaanTable')
          .removeClass('dataTable no-footer')
          .removeAttr('aria-describedby style role');
        $('#rekeningPenerimaanTable thead th')
          .removeClass('sorting sorting_asc sorting_desc sorting_asc_disabled sorting_desc_disabled')
          .removeAttr('tabindex aria-controls aria-label aria-sort style');
      }

      function initOrReloadTable(skpdId) {
        destroyTable();
        updateBulkBar();

        const $table = $('#rekeningPenerimaanTable');
        const ajaxUrl = $table.data('ajax-url');

        dtTable = $table.DataTable({
          processing: true,
          serverSide: true,
          pageLength: 5,
          lengthMenu: [
            [5, 10, 25, 50, 100],
            [5, 10, 25, 50, 100]
          ],
          language: {
            processing: '<span class="spinner-border spinner-border-sm text-primary"></span>',
            search: '',
            searchPlaceholder: 'Cari kode atau nama akun...',
            zeroRecords: 'Tidak ada data akun penerimaan',
            emptyTable: 'Tidak ada data akun penerimaan',
            lengthMenu: 'Tampilkan _MENU_ data',
            info: 'Menampilkan _START_–_END_ dari _TOTAL_ akun',
            infoEmpty: 'Tidak ada data',
            paginate: {
              previous: '<i class="ki-duotone ki-left fs-6"></i>',
              next: '<i class="ki-duotone ki-right fs-6"></i>',
            },
          },
          ajax: {
            url: ajaxUrl,
            type: 'GET',
            data: function(d) {
              d.id_skpd = skpdId;
            },
          },
          columns: [{
              data: 'DT_RowIndex',
              orderable: false,
              searchable: false,
              width: '50px'
            },
            {
              data: 'kode_akun',
              width: '180px'
            },
            {
              data: 'nama_akun'
            },
            {
              data: 'metode_select',
              orderable: false,
              searchable: false,
              width: '220px'
            },
            {
              data: null,
              orderable: false,
              searchable: false,
              width: '50px',
              className: 'text-center',
              render: function(data) {
                const checked = selectedIds.has(data.id) ? 'checked' : '';
                return `<input type="checkbox" class="form-check-input row-check"
                                       data-id="${data.id}" ${checked}>`;
              },
            },
          ],
          initComplete: function() {
            _applyKeenStyles();
          },
          drawCallback: function() {
            // Restore check state after redraw
            $('#rekeningPenerimaanTable tbody .row-check').each(function() {
              const id = parseInt($(this).data('id'));
              $(this).prop('checked', selectedIds.has(id));
            });
            syncCheckAll();
            _applyKeenStyles();
          },
          dom: `<"row mb-4"<"col-sm-6"l>>
                  <"row"<"col-12"tr>>
                  <"row mt-4"<"col-sm-5"i><"col-sm-7"p>>`,
        });
      }

      // ─── KeenThemes DataTable styling ────────────────────────────────────────
      function _applyKeenStyles() {
        $("select[id^='dt-length'], .dataTables_length select, .dt-length select")
          .addClass("form-select form-select-solid form-select-sm w-75px");

        $("label[for^='dt-length'], .dataTables_length label")
          .addClass("mb-0")
          .css({
            display: "inline-flex",
            flexDirection: "row",
            alignItems: "center",
            gap: "8px",
            whiteSpace: "nowrap",
          });
      }

      $(document).on('change', '.metode-select', function() {
        const $select = $(this);
        const id = $select.data('id');
        const newVal = $select.val();
        const $indicator = $select.siblings('.save-indicator');

        $indicator.html('<span class="spinner-border spinner-border-sm text-primary"></span>').show();
        $select.prop('disabled', true);

        $.ajax({
          url: `/rek-penerimaan/${id}`,
          method: 'PATCH',
          data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            metode_input: newVal,
          },
          success: function() {
            $select.data('original', newVal);
            $indicator.html(
              '<i class="ki-duotone ki-check-circle fs-4 text-success"><span class="path1"></span><span class="path2"></span></i>'
            ).show();
            setTimeout(() => $indicator.fadeOut(), 2000);
          },
          error: function() {
            $select.val($select.data('original'));
            $indicator.html(
              '<i class="ki-duotone ki-cross-circle fs-4 text-danger"><span class="path1"></span><span class="path2"></span></i>'
            ).show();
            setTimeout(() => $indicator.fadeOut(), 3000);
          },
          complete: function() {
            $select.prop('disabled', false);
          },
        });
      });

      // ─── Checkbox — row ───────────────────────────────────────────────────────
      $(document).on('change', '.row-check', function() {
        const id = parseInt($(this).data('id'));
        if ($(this).is(':checked')) {
          selectedIds.add(id);
        } else {
          selectedIds.delete(id);
        }
        syncCheckAll();
        updateBulkBar();
      });

      // ─── Checkbox — check all (current page) ─────────────────────────────────
      $(document).on('change', '#checkAll', function() {
        const checked = $(this).is(':checked');
        $('#rekeningPenerimaanTable tbody .row-check').each(function() {
          const id = parseInt($(this).data('id'));
          $(this).prop('checked', checked);
          if (checked) {
            selectedIds.add(id);
          } else {
            selectedIds.delete(id);
          }
        });
        updateBulkBar();
      });

      function syncCheckAll() {
        const total = $('#rekeningPenerimaanTable tbody .row-check').length;
        const checked = $('#rekeningPenerimaanTable tbody .row-check:checked').length;
        $('#checkAll').prop('indeterminate', checked > 0 && checked < total);
        $('#checkAll').prop('checked', total > 0 && checked === total);
      }

      // ─── Bulk bar ─────────────────────────────────────────────────────────────
      function updateBulkBar() {
        const count = selectedIds.size;
        if (count > 0) {
          $('#selectedCount').text(count);
          $('#bulkBar').removeClass('d-none').addClass('d-flex');
        } else {
          $('#bulkBar').removeClass('d-flex').addClass('d-none');
        }
      }

      $('#btnClearSelection').on('click', function() {
        selectedIds.clear();
        $('#rekeningPenerimaanTable tbody .row-check').prop('checked', false);
        $('#checkAll').prop('checked', false).prop('indeterminate', false);
        updateBulkBar();
      });

      // ─── Custom search input ──────────────────────────────────────────────────
      let searchTimer = null;
      $('#tableSearch').on('input', function() {
        const val = $(this).val();
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
          if (dtTable) {
            dtTable.search(val).draw();
          }
        }, 400);
      });

      // ─── Bulk modal ───────────────────────────────────────────────────────────
      $('#btnBulkMetode').on('click', function() {
        $('#modalSelectedCount').text(selectedIds.size);
        // Reset Select2 di modal
        $('#bulkMetodeSelect').val(null).trigger('change');
        $('#bulkMetodeSelect').removeClass('is-invalid');
        $('#bulkMetodeModal').modal('show');
      });

      $('#btnTerapkan').on('click', function() {
        const metode = $('#bulkMetodeSelect').val();
        if (!metode) {
          $('#bulkMetodeSelect').next('.select2-container').find('.select2-selection').addClass('border-danger');
          return;
        }
        $('#bulkMetodeSelect').next('.select2-container').find('.select2-selection').removeClass('border-danger');

        const $btn = $(this);
        $btn.find('.indicator-label').addClass('d-none');
        $btn.find('.indicator-progress').removeClass('d-none');
        $btn.prop('disabled', true);

        $.ajax({
          url: '/rek-penerimaan/batch-update',
          method: 'POST',
          data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            _method: 'PATCH',
            ids: Array.from(selectedIds),
            metode_input: metode,
          },
          success: function(res) {
            $('#bulkMetodeModal').modal('hide');

            // Update select values on visible rows
            selectedIds.forEach(function(id) {
              const $row = $(`#rekeningPenerimaanTable [data-id="${id}"]`).closest('tr');
              const $select = $row.find('.metode-select');
              if ($select.length) {
                $select.val(metode).data('original', metode);
              }
            });

            // Clear selection
            selectedIds.clear();
            $('#rekeningPenerimaanTable tbody .row-check').prop('checked', false);
            $('#checkAll').prop('checked', false).prop('indeterminate', false);
            updateBulkBar();

            // Show toast
            toastr.success(res.message || 'Berhasil diperbarui.');
          },
          error: function() {
            toastr.error('Gagal memperbarui. Silakan coba lagi.');
          },
          complete: function() {
            $btn.find('.indicator-label').removeClass('d-none');
            $btn.find('.indicator-progress').addClass('d-none');
            $btn.prop('disabled', false);
          },
        });
      });
    })();
  </script>
@endpush
