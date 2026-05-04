<!DOCTYPE html>
<html lang="en">

<head>
  <title>SPKAD - Penatausahaan</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
  <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
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
  <div class="d-flex flex-column flex-root" id="kt_app_root">
    <style>
      body {
        background-image: url('assets/media/auth/bg10.jpeg');
      }

      [data-bs-theme="dark"] body {
        background-image: url('assets/media/auth/bg10-dark.jpeg');
      }
    </style>
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
      <!--begin::Aside-->
      <div class="d-flex flex-lg-row-fluid">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
          <!--begin::Image-->
          <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="assets/media/auth/agency.png" alt="" />
          <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="assets/media/auth/agency-dark.png" alt="" />
          <!--end::Image-->
          <!--begin::Title-->
          <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">Cepat, Efisien and Terintegrasi</h1>
          <!--end::Title-->
          <!--begin::Text-->
          <div class="text-gray-600 fs-base text-center fw-semibold">katanya sih buat ngatur duid, tapi ga tauh juga sih<br>cobain aja sendiri modul
            penatausahaan nya<br>barangkali jadi suka kita suka semusa suka.... cair welll.

          </div>
          <!--end::Text-->
        </div>
        <!--end::Content-->
      </div>
      <!--begin::Aside-->
      <!--begin::Body-->
      <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
        <!--begin::Wrapper-->
        <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
          <!--begin::Content-->
          <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
            <!--begin::Wrapper-->
            @yield('content')
            <!--end::Wrapper-->
            @include('layouts.auth.footer')
          </div>
          <!--end::Content-->
        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Body-->
    </div>
  </div>
  @yield('js')
  <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
  <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
</body>

</html>
