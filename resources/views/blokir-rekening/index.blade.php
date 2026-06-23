@extends('layouts.dashboard.master')

@section('content')
  <style>
    .blokir-branch[data-level]:not([data-level="0"]) {
      border-left: 2px solid #dee2e6;
      margin-left: 15px;
    }

    .blokir-leaf {
      border-left: 2px solid #e9ecef;
      margin-left: 2px;
    }

    .blokir-branch-header:hover {
      background-color: #f9f9f9 !important;
    }

    .branch-chevron {
      transition: transform 0.2s ease;
      flex-shrink: 0;
    }
  </style>

  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <div>
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
          Blokir Rekening
        </h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
          <li class="breadcrumb-item text-muted">Beranda</li>
          <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
          </li>
          <li class="breadcrumb-item text-muted">Blokir Rekening</li>
        </ul>
      </div>
    </div>

    @include('components.flash-messages')

    <div class="card card-bordered">
      <div class="card-header border-0 pt-6">
        <div class="card-title w-100">
          <div class="d-flex align-items-center gap-3 w-100">
            <div class="flex-grow-1" style="max-width: 480px;">
              <select id="selectSkpd" class="form-select form-select-solid">
                <option value="">-- Pilih SKPD (opsional) --</option>
                @foreach ($skpdList as $skpd)
                  <option value="{{ $skpd->id_skpd }}">
                    {{ $skpd->kode_skpd }} — {{ $skpd->nama_skpd }}
                  </option>
                @endforeach
              </select>
            </div>
            <button type="button" id="btnBackToList" class="btn btn-light btn-sm d-none">
              <i class="ki-duotone ki-arrow-left fs-4 me-1">
                <span class="path1"></span><span class="path2"></span>
              </i>
              Kembali ke Daftar
            </button>
          </div>
        </div>
      </div>

      <div class="card-body pt-4">

        <div id="stateLoading" class="d-none text-center py-10">
          <span class="spinner-border spinner-border-sm text-primary me-2"></span>
          <span class="text-muted fs-6">Memuat data rekening...</span>
        </div>

        <div id="stateNoData" class="d-none text-center py-10">
          <i class="ki-duotone ki-information-5 fs-3x text-warning mb-3">
            <span class="path1"></span><span class="path2"></span><span class="path3"></span>
          </i>
          <p class="text-muted fs-6 mt-2">Tidak ada data rekening untuk SKPD ini.</p>
        </div>

        <div id="stateSkpdList">
          <div class="d-flex align-items-center justify-content-between mb-4 gap-3">
            <div class="d-flex align-items-center gap-2">
              <span class="text-muted fs-7">Tampilkan</span>
              <select id="skpdPerPage" class="form-select form-select-sm w-auto">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
              </select>
              <span class="text-muted fs-7">data</span>
            </div>
            <div class="position-relative">
              <i class="ki-duotone ki-magnifier fs-4 text-gray-500 position-absolute top-50 translate-middle-y ms-3">
                <span class="path1"></span><span class="path2"></span>
              </i>
              <input type="text" id="skpdSearch" class="form-control form-control-sm form-control-solid ps-10" placeholder="Cari SKPD..."
                style="min-width: 220px;" />
            </div>
          </div>

          <div id="skpdListItems"></div>

          <div class="d-flex align-items-center justify-content-between mt-4 pt-3 border-top">
            <div id="skpdPaginationInfo" class="text-muted fs-7"></div>
            <div id="skpdPaginationBtns" class="d-flex gap-2"></div>
          </div>
        </div>

        <div id="stateTree" class="d-none">
          <div id="treeContainer"></div>
        </div>

      </div>
    </div>
  </div>

  <div id="floatingActions" class="d-none position-fixed" style="bottom: 32px; right: 32px; z-index: 999;">
    <div class="d-flex flex-column gap-3 align-items-end">
      <button type="button" id="btnScrollTop" class="btn btn-icon btn-light btn-sm shadow" title="Scroll ke atas">
        <i class="ki-duotone ki-up fs-4">
          <span class="path1"></span><span class="path2"></span>
        </i>
      </button>
      <button type="button" id="btnBatal" class="btn btn-light-danger shadow" title="Batalkan perubahan">
        <i class="ki-duotone ki-cross fs-4 me-1">
          <span class="path1"></span><span class="path2"></span>
        </i>
        Batalkan
      </button>
      <button type="button" id="btnSimpan" class="btn btn-primary shadow" title="Simpan blokir rekening">
        <i class="ki-duotone ki-lock-3 fs-4 me-1">
          <span class="path1"></span><span class="path2"></span>
        </i>
        Blokir Rekening
      </button>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    (function() {
      'use strict';

      const URL_TREE = '{{ route('blokir-rekening.tree') }}';
      const URL_UPDATE = '{{ route('blokir-rekening.update') }}';
      const CSRF = '{{ csrf_token() }}';
      const ALL_SKPD = @json($skpdList);

      const $selectSkpd = $('#selectSkpd');
      const $btnBackToList = $('#btnBackToList');
      const $stateLoading = $('#stateLoading');
      const $stateNoData = $('#stateNoData');
      const $stateSkpdList = $('#stateSkpdList');
      const $stateTree = $('#stateTree');
      const $treeContainer = $('#treeContainer');
      const $floatingActions = $('#floatingActions');
      const $btnBatal = $('#btnBatal');
      const $btnSimpan = $('#btnSimpan');
      const $btnScrollTop = $('#btnScrollTop');
      const $skpdSearch = $('#skpdSearch');
      const $skpdPerPage = $('#skpdPerPage');
      const $skpdListItems = $('#skpdListItems');
      const $skpdPagInfo = $('#skpdPaginationInfo');
      const $skpdPagBtns = $('#skpdPaginationBtns');

      let _currentIdSkpd = null;
      let _originalBlokir = [];
      let _skpdPage = 1;
      let _skpdPerPage = 10;
      let _skpdQuery = '';

      _renderSkpdList();
      _initSelect2();

      // ── Select2 ──────────────────────────────────────────────────────
      function _initSelect2() {
        $selectSkpd.select2({
          placeholder: '-- Pilih SKPD (opsional) --',
          allowClear: true,
          width: '100%',
        });
        $selectSkpd.on('change', function() {
          const idSkpd = $(this).val();
          if (!idSkpd) {
            _showMode('list');
            return;
          }
          _loadTree(parseInt(idSkpd));
        });
      }

      // ── SKPD list ─────────────────────────────────────────────────────
      function _renderSkpdList() {
        const query = _skpdQuery.toLowerCase();
        const filtered = ALL_SKPD.filter(s =>
          (s.nama_skpd + ' ' + s.kode_skpd).toLowerCase().includes(query)
        );

        const total = filtered.length;
        const totalPage = Math.max(1, Math.ceil(total / _skpdPerPage));
        if (_skpdPage > totalPage) _skpdPage = 1;

        const start = (_skpdPage - 1) * _skpdPerPage;
        const paged = filtered.slice(start, start + _skpdPerPage);

        $skpdListItems.empty();
        if (paged.length === 0) {
          $skpdListItems.html('<p class="text-muted fs-6 text-center py-6">Tidak ada SKPD ditemukan.</p>');
        } else {
          paged.forEach(function(skpd) {
            const $row = $(`
              <div class="d-flex align-items-center justify-content-between
                          py-3 px-4 mb-2 rounded border border-gray-200 bg-hover-light"
                   style="cursor:pointer;" data-id="${skpd.id_skpd}">
                <div>
                  <div class="fw-bold text-gray-800 fs-6">${_esc(skpd.nama_skpd)}</div>
                  <div class="text-muted fs-7">SKPD Kode: ${_esc(skpd.kode_skpd)}</div>
                </div>
                <i class="ki-duotone ki-arrow-right fs-4 text-gray-400">
                  <span class="path1"></span><span class="path2"></span>
                </i>
              </div>
            `);
            $row.on('click', function() {
              _loadTree(parseInt(skpd.id_skpd));
              $selectSkpd.val(skpd.id_skpd).trigger('change.select2');
            });
            $skpdListItems.append($row);
          });
        }

        const from = total === 0 ? 0 : start + 1;
        const to = Math.min(start + _skpdPerPage, total);
        $skpdPagInfo.text(`Menampilkan ${from}–${to} dari ${total} SKPD`);

        $skpdPagBtns.empty();
        if (totalPage > 1) {
          const $prev = $(`<button class="btn btn-sm btn-light ${_skpdPage === 1 ? 'disabled' : ''}">
            <i class="ki-duotone ki-arrow-left fs-5"><span class="path1"></span><span class="path2"></span></i>
          </button>`);
          $prev.on('click', function() {
            if (_skpdPage > 1) {
              _skpdPage--;
              _renderSkpdList();
            }
          });
          $skpdPagBtns.append($prev);

          _pageRange(_skpdPage, totalPage).forEach(function(p) {
            if (p === '...') {
              $skpdPagBtns.append('<span class="px-2 text-muted align-self-center">…</span>');
              return;
            }
            const $btn = $(`<button class="btn btn-sm ${p === _skpdPage ? 'btn-primary' : 'btn-light'}">${p}</button>`);
            $btn.on('click', function() {
              _skpdPage = p;
              _renderSkpdList();
            });
            $skpdPagBtns.append($btn);
          });

          const $next = $(`<button class="btn btn-sm btn-light ${_skpdPage === totalPage ? 'disabled' : ''}">
            <i class="ki-duotone ki-arrow-right fs-5"><span class="path1"></span><span class="path2"></span></i>
          </button>`);
          $next.on('click', function() {
            if (_skpdPage < totalPage) {
              _skpdPage++;
              _renderSkpdList();
            }
          });
          $skpdPagBtns.append($next);
        }
      }

      function _pageRange(current, total) {
        if (total <= 7) return Array.from({
          length: total
        }, (_, i) => i + 1);
        const pages = [1];
        if (current > 3) pages.push('...');
        for (let i = Math.max(2, current - 1); i <= Math.min(total - 1, current + 1); i++) pages.push(i);
        if (current < total - 2) pages.push('...');
        pages.push(total);
        return pages;
      }

      $skpdSearch.on('input', function() {
        _skpdQuery = $(this).val();
        _skpdPage = 1;
        _renderSkpdList();
      });
      $skpdPerPage.on('change', function() {
        _skpdPerPage = parseInt($(this).val());
        _skpdPage = 1;
        _renderSkpdList();
      });

      // ── Load tree ─────────────────────────────────────────────────────
      function _loadTree(idSkpd) {
        _currentIdSkpd = idSkpd;
        _showMode('loading');
        $.ajax({
          url: URL_TREE,
          method: 'GET',
          data: {
            id_skpd: idSkpd
          },
          headers: {
            'X-CSRF-TOKEN': CSRF
          },
          success: function(res) {
            if (!res.tree || res.tree.length === 0) {
              _showMode('nodata');
              return;
            }
            _renderTree(res.tree);
            _snapshotBlokir();
            _showMode('tree');
          },
          error: function() {
            _showMode('list');
            Swal.fire('Gagal', 'Terjadi kesalahan saat memuat data.', 'error');
          },
        });
      }

      // ── Tree renderer ─────────────────────────────────────────────────
      const LEVEL_META = {
        skpd: {
          label: 'SKPD',
          dotClass: 'bg-danger',
          level: 0
        },
        unit_skpd: {
          label: 'Unit SKPD',
          dotClass: 'bg-success',
          level: 1
        },
        bidang_urusan: {
          label: 'Bidang Urusan',
          dotClass: 'bg-warning',
          level: 2
        },
        program: {
          label: 'Program',
          dotClass: 'bg-danger',
          level: 3
        },
        kegiatan: {
          label: 'Kegiatan',
          dotClass: 'bg-primary',
          level: 4
        },
        sub_kegiatan: {
          label: 'Sub Kegiatan',
          dotClass: 'bg-info',
          level: 5
        },
        akun: {
          label: 'Belanja',
          dotClass: '',
          level: 6
        },
      };

      // 28px per level — cukup terlihat tanpa terlalu jauh ke kanan
      const INDENT_BASE = 28;

      function _renderTree(tree) {
        $treeContainer.empty();
        tree.forEach(node => $treeContainer.append(_buildNode(node)));
      }

      function _buildNode(node) {
        const meta = LEVEL_META[node.level] || {
          label: '',
          dotClass: 'bg-secondary',
          level: 0
        };
        const lvl = meta.level;
        const indent = lvl * INDENT_BASE;

        // ── Leaf: akun ──────────────────────────────────────────────────
        if (node.level === 'akun') {
          const checked = node.is_blokir ? 'checked' : '';
          return $(`
            <div class="blokir-leaf d-flex align-items-start py-2 px-3 border-bottom border-gray-100"
                 style="padding-left: calc(${indent}px + 16px);">
              <div class="flex-grow-1">
                <div class="fw-semibold text-gray-800 fs-6">${_esc(node.label)}</div>
                <div class="text-muted fs-7">Belanja Kode: ${_esc(node.kode)}</div>
              </div>
              <div class="ms-3 pt-1">
                <input type="checkbox"
                       class="form-check-input akun-checkbox"
                       data-id="${node.id}"
                       ${checked} />
              </div>
            </div>
          `);
        }

        // ── Branch: collapsible ──────────────────────────────────────────
        const uid = 'node-' + Math.random().toString(36).slice(2, 8);

        // border-left sebagai connector line — inline style agar tidak
        // bergantung pada @stack('styles') yang tidak ada di master layout
        const connectorStyle = lvl > 0 ?
          'border-left: 2px solid #dee2e6; margin-left: 15px;' :
          '';

        const $wrapper = $(`<div class="blokir-branch" data-level="${lvl}" style="${connectorStyle}"></div>`);

        const $header = $(`
          <div class="blokir-branch-header d-flex align-items-center py-3 px-3 border-bottom border-gray-200"
               style="padding-left: calc(${indent}px + 12px); cursor: pointer;"
               data-target="${uid}">
            <span class="bullet bullet-dot ${meta.dotClass} me-3" style="flex-shrink:0;"></span>
            <div class="flex-grow-1">
              <div class="fw-bold text-gray-900 fs-6 text-uppercase lh-sm">${_esc(node.label)}</div>
              <div class="text-muted fs-7">${meta.label} Kode: ${_esc(node.kode)}</div>
            </div>
            <i class="ki-duotone ki-down fs-5 text-gray-400 branch-chevron ms-2"
               style="transition: transform 0.2s ease; flex-shrink: 0;">
              <span class="path1"></span><span class="path2"></span>
            </i>
          </div>
        `);

        const $children = $(`<div id="${uid}" class="blokir-branch-body" style="display:none;"></div>`);

        if (node.children && node.children.length) {
          node.children.forEach(child => $children.append(_buildNode(child)));
        }

        $header.on('click', function() {
          const $body = $('#' + uid);
          const $chevron = $(this).find('.branch-chevron');
          const open = $body.is(':visible');
          $body.slideToggle(160);
          $chevron.css('transform', open ? 'rotate(0deg)' : 'rotate(-180deg)');
        });

        $wrapper.append($header).append($children);
        return $wrapper;
      }

      // ── Snapshot & helpers ────────────────────────────────────────────
      function _snapshotBlokir() {
        _originalBlokir = _getCheckedIds();
      }

      function _getCheckedIds() {
        return $('.akun-checkbox:checked').map(function() {
          return parseInt($(this).data('id'));
        }).get();
      }

      // ── Back to list ──────────────────────────────────────────────────
      $btnBackToList.on('click', function() {
        _currentIdSkpd = null;
        $selectSkpd.val('').trigger('change.select2');
        _showMode('list');
      });

      // ── Batalkan ──────────────────────────────────────────────────────
      $btnBatal.on('click', function() {
        Swal.fire({
          title: 'Batalkan perubahan?',
          text: 'Semua perubahan yang belum disimpan akan direset.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, batalkan',
          cancelButtonText: 'Kembali',
          confirmButtonColor: '#f1416c',
        }).then(function(result) {
          if (!result.isConfirmed) return;
          $('.akun-checkbox').each(function() {
            const id = parseInt($(this).data('id'));
            $(this).prop('checked', _originalBlokir.includes(id));
          });
        });
      });

      // ── Simpan ────────────────────────────────────────────────────────
      $btnSimpan.on('click', function() {
        if (!_currentIdSkpd) return;
        const blokirIds = _getCheckedIds();
        Swal.fire({
          title: 'Konfirmasi Blokir Rekening',
          html: `<p class="text-muted mb-2">Rekening yang dicentang akan diblokir.<br>
                               Rekening yang tidak dicentang akan diaktifkan kembali.</p>
                               <p class="fw-bold fs-5">${blokirIds.length} rekening akan diblokir.</p>`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Simpan',
          cancelButtonText: 'Batal',
          confirmButtonColor: '#009ef7',
        }).then(function(result) {
          if (!result.isConfirmed) return;
          $btnSimpan.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...'
          );
          $.ajax({
            url: URL_UPDATE,
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': CSRF
            },
            data: {
              id_skpd: _currentIdSkpd,
              blokir: blokirIds
            },
            success: function(res) {
              if (res.success) {
                _snapshotBlokir();
                Swal.fire('Berhasil', res.message, 'success');
              }
            },
            error: function(xhr) {
              Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
            },
            complete: function() {
              $btnSimpan.prop('disabled', false).html(
                '<i class="ki-duotone ki-lock-3 fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>Blokir Rekening'
              );
            },
          });
        });
      });

      // ── Scroll to top ─────────────────────────────────────────────────
      $btnScrollTop.on('click', function() {
        $('html, body').animate({
          scrollTop: 0
        }, 300);
      });

      // ── Mode switcher ─────────────────────────────────────────────────
      function _showMode(mode) {
        $stateLoading.addClass('d-none');
        $stateNoData.addClass('d-none');
        $stateSkpdList.addClass('d-none');
        $stateTree.addClass('d-none');
        $floatingActions.addClass('d-none');
        $btnBackToList.addClass('d-none');

        if (mode === 'loading') {
          $stateLoading.removeClass('d-none');
        } else if (mode === 'nodata') {
          $stateNoData.removeClass('d-none');
          $btnBackToList.removeClass('d-none');
        } else if (mode === 'list') {
          $stateSkpdList.removeClass('d-none');
          _renderSkpdList();
        } else if (mode === 'tree') {
          $stateTree.removeClass('d-none');
          $floatingActions.removeClass('d-none');
          $btnBackToList.removeClass('d-none');
        }
      }

      // ── HTML escape ───────────────────────────────────────────────────
      function _esc(str) {
        if (!str) return '';
        return String(str)
          .replace(/&/g, '&amp;')
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
          .replace(/"/g, '&quot;');
      }

    })();
  </script>
@endpush
