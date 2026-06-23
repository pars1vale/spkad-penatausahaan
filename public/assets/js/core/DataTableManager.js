"use strict";

const DataTableManager = (() => {
    const _instances = {};
    // ─── Toastr options ─────────────────────────────────────────────────
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toastr-top-right",
        "preventDuplicates": false,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    // ─── Entry point ───────────────────────────────────────────────────
    const init = () => {
        document.querySelectorAll("table[data-ajax-url]").forEach((table) => {
            if (_isVisible(table)) {
                _boot(table);
            }
        });
        _bindDeleteModal();
    };

    // ─── Boot satu <table> ─────────────────────────────────────────────
    const boot = (table) => { _boot(table); };

    const _boot = (table) => {
        const id = table.id;

        if (!id) {
            toastr.warning("DataTableManager, <table> harus punya id.", table);
            console.warn("[DataTableManager] <table> harus punya id.", table);
            return;
        }

        if (_instances[id]) {
            toastr.warning(`DataTableManager, #${id} sudah di-init. Gunakan switchTab() atau destroy() dulu.`);
            console.warn(`[DataTableManager] #${id} sudah di-init. Gunakan switchTab() atau destroy() dulu.`);
            return;
        }

        const options = _parseJson(table.dataset.options, {});
        const columns = _columnsFromThead(table);

        if (!columns.length) {
            toastr.warning(`DataTableManager, tidak ada kolom valid pada #${id}.`);
            console.warn(`[DataTableManager] Tidak ada kolom valid pada #${id}.`);
            return;
        }

        const dt = $(`#${id}`).DataTable({
            searchDelay: 400,
            processing: true,
            serverSide: true,
            scrollX: true,
            order: options.order ?? [[1, "asc"]],
            pageLength: options.pageLength ?? 10,
            stateSave: options.stateSave ?? false,

            ajax: {
                url: table.dataset.ajaxUrl,
                type: "GET",
                data: function (d) {
                    if (table.dataset.tab) d.tab = table.dataset.tab;
                    const extra = _parseJson(table.dataset.params, {});
                    Object.assign(d, extra);
                    return d;
                },
                error: _onAjaxError,
            },

            columns,

            dom:
                "<'row align-items-center mb-5'" +
                "<'col-sm-12 col-md-6'l>" +
                "<'col-sm-12 col-md-6 d-flex justify-content-end'f>" +
                ">" +
                "t" +
                "<'row align-items-center mt-5'" +
                "<'col-sm-12 col-md-5'i>" +
                "<'col-sm-12 col-md-7 d-flex justify-content-end'p>" +
                ">",

            language: {
                search: "",
                searchPlaceholder: options.searchPlaceholder ?? "Cari data...",
                lengthMenu: "Tampilkan _MENU_ Data",
                info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
                infoEmpty: "Tidak Ada Data",
                infoFiltered: "(difilter dari _MAX_ total data)",
                zeroRecords: "Tidak ada data yang cocok",
                emptyTable: options.emptyText ?? "Belum Ada Data",
                processing:
                    `<span class="d-flex align-items-center gap-2 text-muted">
                        <span class="spinner-border spinner-border-sm"></span>
                        Memuat data...
                    </span>`,
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: `<i class="ki-duotone ki-right fs-6"><span class="path1"></span><span class="path2"></span></i>`,
                    previous: `<i class="ki-duotone ki-left fs-6"><span class="path1"></span><span class="path2"></span></i>`,
                },
            },

            responsive: false,
            autoWidth: false,
            createdRow: (row) => $(row).addClass("align-middle"),
            drawCallback: () => _stylePagination(),
            initComplete: () => {
                _styleControls(id);
                _overrideSearch(id);
            },
        });

        _instances[id] = dt;
    };

    // ─── Destroy ───────────────────────────────────────────────────────
    // DT v2: wrapper = .dt-container | DT v1: .dataTables_wrapper
    const destroy = (id) => {
        const dt = _instances[id];
        if (!dt) return;

        const tableEl = document.getElementById(id);
        dt.destroy(false);

        if (tableEl) {
            const wrapper = tableEl.closest(".dt-container") ?? tableEl.closest(".dataTables_wrapper");
            if (wrapper) wrapper.replaceWith(tableEl);
        }

        delete _instances[id];
    };

    // ─── Switch tab ────────────────────────────────────────────────────
    const switchTab = (tableId, tab) => {
        const tableEl = document.getElementById(tableId);
        if (!tableEl) {
            toastr.warning(`DataTableManager, switchTab: #${tableId} tidak ditemukan.`);
            console.warn(`[DataTableManager] switchTab: #${tableId} tidak ditemukan.`);
            return;
        }
        if (tableEl.dataset.tab === tab) return;
        destroy(tableId);
        tableEl.setAttribute("data-tab", tab);
        _boot(tableEl);
    };

    // ─── Build kolom dari <thead> ──────────────────────────────────────
    const _columnsFromThead = (table) => {
        return Array.from(table.querySelectorAll("thead th"))
            .map((th) => {
                const col = th.dataset.col;
                if (!col) return null;
                return {
                    data: col,
                    name: th.dataset.name ?? col,
                    orderable: th.dataset.orderable !== "false",
                    searchable: th.dataset.searchable !== "false",
                    width: th.dataset.width ?? undefined,
                };
            })
            .filter(Boolean);
    };

    // ─── Style kontrol ─────────────────────────────────────────────────
    const _styleControls = (tableId) => {

        const tableEl = document.getElementById(tableId);
        if (!tableEl) return;

        const $container = $(tableEl).closest(".dt-container, .dataTables_wrapper");
        if (!$container.length) {
            toastr.warning(`DataTableManager, _styleControls: container tidak ditemukan untuk #${tableId}.`);
            console.warn(`[DataTableManager] _styleControls: container tidak ditemukan untuk #${tableId}`);
            return;
        }

        // ── Length select ─────────────────────────────────────────────
        const $lengthCol = $container.find("select[id^='dt-length']").closest(".col-sm-12, .dataTables_length");

        if ($lengthCol.length && !$lengthCol.find(".dt-length-wrap").length) {
            const $select = $container.find("select[id^='dt-length'], .dataTables_length select").first();

            if ($select.length) {
                $select
                    .addClass("form-select form-select-solid form-select-sm")
                    .css({ display: "inline-block", width: "75px" });

                $select.detach();
                $lengthCol.empty();
                $lengthCol.append(
                    `<div class="dt-length-wrap d-flex align-items-center gap-2">
                        <span class="text-gray-700 fw-semibold fs-7">Tampilkan</span>
                    </div>`
                );
                const $wrap = $lengthCol.find(".dt-length-wrap");
                $wrap.append($select);
                $wrap.append('<span class="text-gray-700 fw-semibold fs-7">Data</span>');
            }
        }

        // ── Search input ──────────────────────────────────────────────
        $container.find("input[id^='dt-search'], .dataTables_filter input").each(function () {
            const $inp = $(this);
            if ($inp.closest(".dt-search-wrap").length) return;

            $inp.removeClass("form-control-sm");

            $inp.wrap('<div class="dt-search-wrap position-relative d-inline-flex align-items-center"></div>');

            $inp.parent().prepend(
                `<i class="ki-duotone ki-magnifier fs-3 position-absolute"
                    style="pointer-events:none;left:0.85rem;top:50%;transform:translateY(-50%);z-index:1;color:var(--bs-gray-500)">
                    <span class="path1"></span><span class="path2"></span>
                </i>`
            );

            $inp
                .addClass("form-control form-control-solid w-250px")
                .css("padding-left", "2.5rem");
        });
    };

    // ─── Style pagination ──────────────────────────────────────────────
    const _stylePagination = () => {
        $(".dt-paging .paginate_button, .dataTables_paginate .paginate_button")
            .addClass("btn btn-sm btn-light me-1 mb-1")
            .filter(".current, .active")
            .removeClass("btn-light")
            .addClass("btn-primary");
    };

    // ─── Override search dengan debounce ───────────────────────────────
    const _overrideSearch = (tableId) => {
        let timer;
        const ns = `spkad_search_${tableId}`;
        $(document).off(`.${ns}`);
        const tableEl = document.getElementById(tableId);
        const $container = $(tableEl).closest(".dt-container, .dataTables_wrapper");

        $container.on(`keyup.${ns} input.${ns} paste.${ns} cut.${ns}`,
            `input[type='search']`,
            function () {
                clearTimeout(timer);
                const val = $(this).val();
                timer = setTimeout(() => {
                    _instances[tableId]?.search(val).draw();
                }, 400);
                return false;
            }
        );
    };

    // ─── Delete modal global ───────────────────────────────────────────
    const _bindDeleteModal = () => {
        $(document).off("click.dtm-delete").on("click.dtm-delete", ".btn-delete", function () {
            const name = $(this).data("name");
            const url = $(this).data("url");
            $("#deleteTargetName").text(name);
            $("#deleteForm").attr("action", url);
            new bootstrap.Modal(document.getElementById("deleteModal")).show();
        });
    };

    // ─── AJAX error handler ────────────────────────────────────────────
    const _onAjaxError = (xhr) => {
        if (xhr.status === 401) { window.location.reload(); return; }
        if (xhr.status === 403) { window.toastr?.error("Akses ditolak."); return; }
        toastr.error(`Terjadi kesalahan saat memuat data. (HTTP ${xhr.status})`);
        console.error(`[DataTableManager] AJAX error ${xhr.status}:`, xhr.statusText);
    };

    // ─── Util ──────────────────────────────────────────────────────────
    const _isVisible = (el) => {
        return !!(el.offsetWidth || el.offsetHeight || el.getClientRects().length);
    };

    const _parseJson = (str, fallback) => {
        try { return str ? JSON.parse(str) : fallback; }
        catch { return fallback; }
    };

    // ─── Public API ────────────────────────────────────────────────────
    return {
        init,
        boot,
        destroy,
        switchTab,
        reload: (id) => _instances[id]?.ajax.reload(null, false),
        getInstance: (id) => _instances[id],
    };

})();

KTUtil.onDOMContentLoaded(() => DataTableManager.init());