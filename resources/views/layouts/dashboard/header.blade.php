      <div id="kt_app_header" class="app-header">
        <!--begin::Header logo-->
        <div class="app-header-logo d-flex align-items-center ps-lg-10 gap-4 gap-lg-6">
          <!--begin::Logo image-->
          <a href="index.html">
            <img alt="Logo" src="assets/media/logos/demo49-small.svg" class="h-20px d-sm-none d-inline theme-light-show" />
            <img alt="Logo" src="assets/media/logos/demo49.svg" class="h-20px h-lg-25px theme-light-show d-none d-sm-inline" />
            <img alt="Logo" src="assets/media/logos/demo49-dark.svg" class="h-20px h-lg-25px theme-dark-show" />
          </a>
          <!--end::Logo image-->
        </div>
        <!--end::Header logo-->
        <!--begin::Header wrapper-->
        <div class="app-header-wrapper">
          <div class="app-container container-fluid">
            <!--begin::Header Toolbar left-->
            <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1 me-1 me-lg-0">

            </div>
            <!--end::Header Toolbar left-->
            <!--begin::Header Toolbar Right-->
            <div class="app-navbar flex-shrink-0">
              <!--begin::User menu-->
              <div class="app-navbar-item ms-1 ms-lg-3 me-2 me-lg-6" id="kt_header_user_menu_toggle">
                <!--begin::Menu wrapper-->
                <div class="cursor-pointer symbol symbol-35px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                  data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                  <img class="symbol symbol-circle symbol-35px symbol-md-40px" src="https://api.dicebear.com/9.x/fun-emoji/svg?seed=Brian"
                    alt="user" />
                </div>
                <!--begin::User account menu-->
                <div
                  class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                  data-kt-menu="true">
                  <!--begin::Menu item-->
                  <div class="menu-item px-3">
                    <div class="menu-content d-flex align-items-center px-3">
                      <!--begin::Avatar-->
                      <div class="symbol symbol-50px me-5">
                        <img alt="Logo" src="https://api.dicebear.com/9.x/fun-emoji/svg?seed=Brian" />
                      </div>
                      <!--end::Avatar-->
                      <!--begin::Username-->
                      <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-5">nama user
                          <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">BUD</span>
                          {{-- <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">KBUD</span> --}}
                          {{-- <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">BP</span> --}}
                          {{-- <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">PA</span> --}}
                          {{-- <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">KPA</span> --}}
                          {{-- <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">PPTK</span> --}}
                        </div>
                        <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">nama skpd</a>
                      </div>
                      <!--end::Username-->
                    </div>
                  </div>
                  <!--end::Menu item-->
                  <!--begin::Menu separator-->
                  <div class="separator my-2"></div>
                  <!--end::Menu separator-->
                  <!--begin::Menu item-->
                  <div class="menu-item px-5">
                    <a href="account/overview.html" class="menu-link px-5">My Profile</a>
                  </div>
                  <!--end::Menu item-->
                  <!--begin::Menu item-->
                  <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start"
                    data-kt-menu-offset="-15px, 0">
                    <a href="#" class="menu-link px-5">
                      <span class="menu-title position-relative">Mode
                        <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                          <i class="ki-outline ki-night-day theme-light-show fs-2"></i>
                          <i class="ki-outline ki-moon theme-dark-show fs-2"></i>
                        </span></span>
                    </a>
                    <!--begin::Menu-->
                    <div
                      class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                      data-kt-menu="true" data-kt-element="theme-mode-menu">
                      <!--begin::Menu item-->
                      <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                          <span class="menu-icon" data-kt-element="icon">
                            <i class="ki-outline ki-night-day fs-2"></i>
                          </span>
                          <span class="menu-title">Light</span>
                        </a>
                      </div>
                      <!--end::Menu item-->
                      <!--begin::Menu item-->
                      <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                          <span class="menu-icon" data-kt-element="icon">
                            <i class="ki-outline ki-moon fs-2"></i>
                          </span>
                          <span class="menu-title">Dark</span>
                        </a>
                      </div>
                      <!--end::Menu item-->
                      <!--begin::Menu item-->
                      <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                          <span class="menu-icon" data-kt-element="icon">
                            <i class="ki-outline ki-screen fs-2"></i>
                          </span>
                          <span class="menu-title">System</span>
                        </a>
                      </div>
                      <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                  </div>
                  <!--end::Menu item-->
                  <!--begin::Menu item-->
                  <div class="menu-item px-5">
                    <a href="authentication/layouts/corporate/sign-in.html" class="menu-link px-5">Sign Out</a>
                  </div>
                  <!--end::Menu item-->
                </div>
                <!--end::User account menu-->
                <!--end::Menu wrapper-->
              </div>
              <!--end::User menu-->
              <div class="app-navbar-item ms-1 ms-lg-3">
                <a href="#" class="btn btn-flex btn-sm fw-bold btn-secondary px-2 px-md-5 py-3" data-bs-toggle="modal"
                  data-bs-target="#kt_modal_upgrade_plan">
                  <span class="d-none d-sm-inline ps-1">tahun anggaran</span></a>
              </div>
              <div class="app-navbar-item ms-1 ms-lg-3 me-n4 d-flex d-lg-none">
                <!--begin::Sidebar toggle-->
                <button id="kt_app_sidebar_mobile_toggle" class="btn btn-icon w-35px h-35px w-md-40px h-md-40px">
                  <i class="ki-outline ki-burger-menu-2 fs-2"></i>
                </button>
                <!--end::Sidebar toggle-->
              </div>
            </div>
            <!--end::Header Toolbar Right-->
          </div>
        </div>
      </div>
