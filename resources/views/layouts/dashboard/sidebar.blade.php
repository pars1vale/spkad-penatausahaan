<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
  data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="start"
  data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
  <div id="kt_app_sidebar_wrapper" class="app-sidebar-wrapper hover-scroll-y mx-3 my-2" data-kt-scroll="true" data-kt-scroll-activate="true"
    data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_header" data-kt-scroll-offset="5px">
    <div id="kt_app_sidebar_menu" class="menu menu-sub-indention menu-rounded menu-column fw-semibold fs-6 py-4 py-lg-6 px-2" data-kt-menu="true">

      {{-- Dashboard --}}
      <div class="menu-item">
        <a class="menu-link" href="#">
          <span class="menu-icon">
            <i class="ki-outline ki-element-11 fs-2"></i>
          </span>
          <span class="menu-title">Dashboard</span>
        </a>
      </div>

      {{-- PENGATURAN --}}
      <div class="menu-item">
        <div class="menu-content">
          <span class="menu-section fs-7 fw-bolder ps-1 py-1">PENGATURAN</span>
        </div>
      </div>

      {{-- Jadwal --}}
      <div class="menu-item">
        <a class="menu-link" href="#">
          <span class="menu-icon">
            <i class="ki-outline ki-calendar fs-2"></i>
          </span>
          <span class="menu-title">Jadwal</span>
        </a>
      </div>

      {{-- Kebijakan SPD --}}
      <div class="menu-item">
        <a class="menu-link" href="#">
          <span class="menu-icon">
            <i class="ki-outline ki-document fs-2"></i>
          </span>
          <span class="menu-title">Kebijakan SPD</span>
        </a>
      </div>

      {{-- Rekening Bank --}}
      <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
        <span class="menu-link">
          <span class="menu-icon">
            <i class="ki-outline ki-bank fs-2"></i>
          </span>
          <span class="menu-title">Rekening Bank</span>
          <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion">
          <div class="menu-item">
            <a class="menu-link" href="authentication/extended/multi-steps-sign-up.html">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">RKUD</span>
            </a>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">SKPD</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">
              <div class="menu-item">
                <a class="menu-link" href="authentication/layouts/corporate/sign-in.html">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Pembuatan</span>
                </a>
              </div>
            </div>
          </div>
          <div class="menu-item">
            <a class="menu-link" href="authentication/extended/multi-steps-sign-up.html">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">KKPD</span>
            </a>
          </div>
        </div>
      </div>

      {{-- Besaran UP --}}
      <div class="menu-item">
        <a class="menu-link" href="#">
          <span class="menu-icon">
            <i class="ki-outline ki-dollar fs-2"></i>
          </span>
          <span class="menu-title">Besaran UP</span>
        </a>
      </div>

      {{-- Pengguna --}}
      <div class="menu-item">
        <a class="menu-link" href="#">
          <span class="menu-icon">
            <i class="ki-outline ki-profile-circle fs-2"></i>
          </span>
          <span class="menu-title">Pengguna</span>
        </a>
      </div>

      {{-- Pegawai --}}
      <div class="menu-item">
        <a class="menu-link" href="#">
          <span class="menu-icon">
            <i class="ki-outline ki-people fs-2"></i>
          </span>
          <span class="menu-title">Pegawai</span>
        </a>
      </div>

      {{-- Perangkat Daerah --}}
      <div class="menu-item">
        <a class="menu-link" href="#">
          <span class="menu-icon">
            <i class="ki-outline ki-office-bag fs-2"></i>
          </span>
          <span class="menu-title">Perangkat Daerah</span>
        </a>
      </div>

      {{-- Akun Penerimaan --}}
      <div class="menu-item">
        <a class="menu-link" href="#">
          <span class="menu-icon">
            <i class="ki-outline ki-wallet fs-2"></i>
          </span>
          <span class="menu-title">Akun Penerimaan</span>
        </a>
      </div>

      {{-- Blokir Rekening --}}
      <div class="menu-item">
        <a class="menu-link" href="#">
          <span class="menu-icon">
            <i class="ki-outline ki-lock fs-2"></i>
          </span>
          <span class="menu-title">Blokir Rekening</span>
        </a>
      </div>

      {{-- Sistem --}}
      <div class="menu-item">
        <a class="menu-link" href="#">
          <span class="menu-icon">
            <i class="ki-outline ki-setting-2 fs-2"></i>
          </span>
          <span class="menu-title">Sistem</span>
        </a>
      </div>

      {{-- PENATAUSAHAAN --}}
      <div class="menu-item">
        <div class="menu-content">
          <span class="menu-section fs-7 fw-bolder ps-1 py-1">PENATAUSAHAAN</span>
        </div>
      </div>

      {{-- Pengeluaran --}}
      <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
        <span class="menu-link">
          <span class="menu-icon">
            <i class="ki-outline ki-exit-up fs-2"></i>
          </span>
          <span class="menu-title">Pengeluaran</span>
          <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion">
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">DPA</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2: Penerimaan (accordion) --}}
              <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <span class="menu-link">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Penerimaan</span>
                  <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion menu-active-bg">

                  {{-- LEVEL 3: Leaf item (tanpa arrow, tanpa accordion) --}}
                  <div class="menu-item">
                    <a class="menu-link" href="#">
                      <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                      </span>
                      <span class="menu-title">Pendapatan</span>
                    </a>
                  </div>

                  {{-- LEVEL 3: Leaf item (tanpa arrow, tanpa accordion) --}}
                  <div class="menu-item">
                    <a class="menu-link" href="#">
                      <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                      </span>
                      <span class="menu-title">Penerimaan Pembiayaan</span>
                    </a>
                  </div>
                </div>
              </div>

              <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <span class="menu-link">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Penarikan</span>
                  <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion menu-active-bg">

                  {{-- LEVEL 3: Leaf item (tanpa arrow, tanpa accordion) --}}
                  <div class="menu-item">
                    <a class="menu-link" href="#">
                      <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                      </span>
                      <span class="menu-title">Belanja</span>
                    </a>
                  </div>

                  {{-- LEVEL 3: Leaf item (tanpa arrow, tanpa accordion) --}}
                  <div class="menu-item">
                    <a class="menu-link" href="#">
                      <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                      </span>
                      <span class="menu-title">Pengeluaran Pembiayaan</span>
                    </a>
                  </div>
                </div>
              </div>

              <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <span class="menu-link">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Validasi</span>
                  <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion menu-active-bg">

                  {{-- LEVEL 3: Leaf item (tanpa arrow, tanpa accordion) --}}
                  <div class="menu-item">
                    <a class="menu-link" href="#">
                      <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                      </span>
                      <span class="menu-title">Pendapatan</span>
                    </a>
                  </div>

                  {{-- LEVEL 3: Leaf item (tanpa arrow, tanpa accordion) --}}
                  <div class="menu-item">
                    <a class="menu-link" href="#">
                      <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                      </span>
                      <span class="menu-title">Belanja</span>
                    </a>
                  </div>
                  <div class="menu-item">
                    <a class="menu-link" href="#">
                      <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                      </span>
                      <span class="menu-title">Pembiayaan</span>
                    </a>
                  </div>
                </div>
              </div>

              <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <span class="menu-link">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Laporan</span>
                  <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion menu-active-bg">

                  {{-- LEVEL 3: Leaf item (tanpa arrow, tanpa accordion) --}}
                  <div class="menu-item">
                    <a class="menu-link" href="#">
                      <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                      </span>
                      <span class="menu-title">Anggaran Kas</span>
                    </a>
                  </div>

                  {{-- LEVEL 3: Leaf item (tanpa arrow, tanpa accordion) --}}
                  <div class="menu-item">
                    <a class="menu-link" href="#">
                      <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                      </span>
                      <span class="menu-title">DPA</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">SPD</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2: Otorisasi (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Otorisasi</span>
                </a>
              </div>

            </div>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Pengajuan</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2:  (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">TU</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">DPR KKPD</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">DPT KKPD</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">NPD</span>
                </a>
              </div>
              {{-- LEVEL 2:  (accordion) --}}
              <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <span class="menu-link">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Data Pegawai</span>
                  <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion menu-active-bg">

                  {{-- LEVEL 3: Leaf item (tanpa arrow, tanpa accordion) --}}
                  <div class="menu-item">
                    <a class="menu-link" href="#">
                      <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                      </span>
                      <span class="menu-title">Gaji</span>
                    </a>
                  </div>

                  {{-- LEVEL 3: Leaf item (tanpa arrow, tanpa accordion) --}}
                  <div class="menu-item">
                    <a class="menu-link" href="#">
                      <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                      </span>
                      <span class="menu-title">TPP</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="menu-item">
            <a class="menu-link" href="authentication/extended/multi-steps-sign-up.html">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Pertanggung Jawaban <br> NPD</span>
            </a>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Kontraktual</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2:  (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Kontrak</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Adendum</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Uang Muka / <br> Berita Acara</span>
                </a>
              </div>
            </div>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">SPP</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2:  (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">UP</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">GU</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">TU</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">LS</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">KKPD</span>
                </a>
              </div>
            </div>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">SPM</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2:  (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Pembuatan</span>
                </a>
              </div>
            </div>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">SP2D</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2:  (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Pembuatan</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Verifikasi</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Pencairan</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Pencairan KKPD</span>
                </a>
              </div>
            </div>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Pengembalian Belanja</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2:  (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">UP / GU</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">GU KKPD</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">TU</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">LS</span>
                </a>
              </div>
            </div>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">STS</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2:  (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">UP / GU</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">TU</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">TYL</span>
                </a>
              </div>
            </div>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">BKU</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2:  (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Pemda</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">SKPD</span>
                </a>
              </div>
            </div>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">LPJ</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">
              {{-- LEVEL 2:  (accordion) --}}
              <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <span class="menu-link">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">UP / GU</span>
                  <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion menu-active-bg">

                  {{-- LEVEL 3: Leaf item (tanpa arrow, tanpa accordion) --}}
                  <div class="menu-item">
                    <a class="menu-link" href="#">
                      <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                      </span>
                      <span class="menu-title">Pembuatan</span>
                    </a>
                  </div>
                </div>
              </div>

              {{-- LEVEL 2:  (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">TU</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Administratif</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Fungsional</span>
                </a>
              </div>
            </div>
          </div>
          <div class="menu-item">
            <a class="menu-link" href="authentication/extended/multi-steps-sign-up.html">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Daftar Rekanan</span>
            </a>
          </div>
          <div class="menu-item">
            <a class="menu-link" href="authentication/extended/multi-steps-sign-up.html">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Tracking Dokumen</span>
            </a>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Laporan</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2: Otorisasi (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Tematik</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Realisasi</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">LPKH</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Register</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Rekonsiliasi Pajak</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Penutupan Kas</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Penerimaan --}}
      <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
        <span class="menu-link">
          <span class="menu-icon">
            <i class="ki-outline ki-entrance-right fs-2"></i>
          </span>
          <span class="menu-title">Penerimaan</span>
          <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion">
          <div class="menu-item">
            <a class="menu-link" href="authentication/extended/multi-steps-sign-up.html">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Rekening</span>
            </a>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">STBP</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2: Otorisasi (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Pendapatan</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Pembiayaan</span>
                </a>
              </div>

            </div>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">STS</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2: Otorisasi (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">TYL</span>
                </a>
              </div>
            </div>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Laporan</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2: Otorisasi (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">BKU Penerimaan</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Register</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">LPJ</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Pembiayaan --}}
      <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
        <span class="menu-link">
          <span class="menu-icon">
            <i class="ki-outline ki-finance-calculator fs-2"></i>
          </span>
          <span class="menu-title">Pembiayaan</span>
          <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion">
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">SPD</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2: Otorisasi (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Otorisasi</span>
                </a>
              </div>
            </div>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">SPP</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2: Otorisasi (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Pembuatan</span>
                </a>
              </div>
            </div>
          </div>
          <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">SP2D</span>
              <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">

              {{-- LEVEL 2: Otorisasi (leaf - tanpa arrow, tanpa accordion) --}}
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Pembuatan</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Verifikasi</span>
                </a>
              </div>
              <div class="menu-item">
                <a class="menu-link" href="#">
                  <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                  </span>
                  <span class="menu-title">Pencairan</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- AKPD --}}
      <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
        <span class="menu-link">
          <span class="menu-icon">
            <i class="ki-outline ki-book-open fs-2"></i>
          </span>
          <span class="menu-title">AKPD</span>
          <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion">
          <div class="menu-item">
            <a class="menu-link" href="authentication/extended/multi-steps-sign-up.html">
              <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
              </span>
              <span class="menu-title">Belanja</span>
            </a>
          </div>
        </div>
      </div>

      {{-- LAPORAN --}}
      <div class="menu-item">
        <div class="menu-content">
          <span class="menu-section fs-7 fw-bolder ps-1 py-1">Laporan</span>
        </div>
      </div>

      {{-- Akuntansi --}}
      <div class="menu-item">
        <a class="menu-link" href="#">
          <span class="menu-icon">
            <i class="ki-outline ki-chart-line fs-2"></i>
          </span>
          <span class="menu-title">Akuntansi</span>
        </a>
      </div>

    </div>
  </div>
</div>
