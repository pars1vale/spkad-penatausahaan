<!DOCTYPE html>
<html lang="en">

<head>
  <title>SPKAD - Penatausahaan</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta property="og:title" content="SPKAD - Penatausahaan" />
  <meta property="og:site_name" content="SPKAD_Penatausahaan" />
  <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
  <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
</head>

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true"
  data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-aside-enabled="true"
  data-kt-app-aside-fixed="false" class="app-default">
  <script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
      if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
        themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
      } else {
        if (localStorage.getItem("data-bs-theme") !== null) {
          themeMode = localStorage.getItem("data-bs-theme");
        } else {
          themeMode = defaultThemeMode;
        }
      }
      if (themeMode === "system") {
        themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
      }
      document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
  </script>
  <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
      @include('layouts.dashboard.header')
      <div class="app-wrapper d-flex" id="kt_app_wrapper">
        @include('layouts.dashboard.sidebar')
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
          {{-- @yield('content') --}}
          <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content">
              <!--begin::Content container-->
              <div id="kt_app_content_container" class="app-container container-fluid">
                @yield('content')
                <!--end::Row-->
              </div>
              <!--end::Content container-->
            </div>
            <!--end::Content-->
          </div>
          @include('layouts.dashboard.footer')
        </div>
      </div>
    </div>
  </div>

  <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-outline ki-arrow-up"></i>
  </div>

  <script>
    var hostUrl = "assets/";
  </script>
  <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
  <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
  <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/radar." js"></script>
  <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
  <script src="{{ asset('assets/plugins/custom/typedjs/typedjs.bundle.js') }}"></script>
  <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
  <script src="{{ asset('assets/plugins/custom/typedjs/typedjs.bundle.js') }}"></script>
  <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
  <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
  <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
  <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
  <script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
  <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
  @stack('scripts')
</body>

</html>
