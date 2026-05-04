@extends('layouts.dashboard.master')

@section('content')
  <!--begin::Row-->
  <div class="row gy-5 gx-xl-10">

    <!--begin::Col - Pendapatan Daerah-->
    <div class="col-sm-6 col-xl-3 mb-xl-10">
      <!--begin::Card widget 2-->
      <div class="card h-lg-100">
        <!--begin::Body-->
        <div class="card-body d-flex justify-content-between align-items-start flex-column">
          <!--begin::Icon-->
          <div class="m-0">
            <i class="ki-outline ki-shield-tick fs-2hx text-gray-600"></i>
          </div>
          <!--end::Icon-->
          <!--begin::Section-->
          <div class="d-flex flex-column my-7">
            <!--begin::Number-->
            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">1,921 M</span>
            <!--end::Number-->
            <!--begin::Label-->
            <div class="m-0">
              <span class="fw-semibold fs-6 text-gray-500">Pendapatan Daerah</span>
            </div>
            <!--end::Label-->
            <!--begin::Sub-->
            <div class="m-0 mt-1">
              <span class="fw-semibold fs-8 text-gray-400">Realisasi Rill Rp0,00</span>
            </div>
            <div class="m-0">
              <span class="fw-semibold fs-8 text-gray-400">(Realisasi Rencana Rp0,00)</span>
            </div>
            <!--end::Sub-->
          </div>
          <!--end::Section-->
          <!--begin::Badge-->
          <span class="badge badge-light-primary fs-base">
            <i class="ki-outline ki-minus fs-5 text-primary ms-n1"></i>0.00%
          </span>
          <!--end::Badge-->
        </div>
        <!--end::Body-->
      </div>
      <!--end::Card widget 2-->
    </div>
    <!--end::Col-->

    <!--begin::Col - Belanja Daerah-->
    <div class="col-sm-6 col-xl-3 mb-xl-10">
      <!--begin::Card widget 2-->
      <div class="card h-lg-100">
        <!--begin::Body-->
        <div class="card-body d-flex justify-content-between align-items-start flex-column">
          <!--begin::Icon-->
          <div class="m-0">
            <i class="ki-outline ki-basket fs-2hx text-gray-600"></i>
          </div>
          <!--end::Icon-->
          <!--begin::Section-->
          <div class="d-flex flex-column my-7">
            <!--begin::Number-->
            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">1,891 M</span>
            <!--end::Number-->
            <!--begin::Label-->
            <div class="m-0">
              <span class="fw-semibold fs-6 text-gray-500">Belanja Daerah</span>
            </div>
            <!--end::Label-->
            <!--begin::Sub-->
            <div class="m-0 mt-1">
              <span class="fw-semibold fs-8 text-gray-400">Realisasi Rill Rp720.796.574.618</span>
            </div>
            <div class="m-0">
              <span class="fw-semibold fs-8 text-gray-400">(Realisasi Rencana Rp899.013.208.467)</span>
            </div>
            <!--end::Sub-->
          </div>
          <!--end::Section-->
          <!--begin::Badge-->
          <span class="badge badge-light-warning fs-base">
            <i class="ki-outline ki-arrow-up fs-5 text-warning ms-n1"></i>38.11%
          </span>
          <!--end::Badge-->
        </div>
        <!--end::Body-->
      </div>
      <!--end::Card widget 2-->
    </div>
    <!--end::Col-->

    <!--begin::Col - Penerimaan Pembiayaan-->
    <div class="col-sm-6 col-xl-3 mb-xl-10">
      <!--begin::Card widget 2-->
      <div class="card h-lg-100">
        <!--begin::Body-->
        <div class="card-body d-flex justify-content-between align-items-start flex-column">
          <!--begin::Icon-->
          <div class="m-0">
            <i class="ki-outline ki-setting-2 fs-2hx text-gray-600"></i>
          </div>
          <!--end::Icon-->
          <!--begin::Section-->
          <div class="d-flex flex-column my-7">
            <!--begin::Number-->
            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">451 Jt</span>
            <!--end::Number-->
            <!--begin::Label-->
            <div class="m-0">
              <span class="fw-semibold fs-6 text-gray-500">Penerimaan Pembiayaan</span>
            </div>
            <!--end::Label-->
            <!--begin::Sub-->
            <div class="m-0 mt-1">
              <span class="fw-semibold fs-8 text-gray-400">Realisasi Rill Rp0,00</span>
            </div>
            <div class="m-0">
              <span class="fw-semibold fs-8 text-gray-400">(Realisasi Rencana Rp0,00)</span>
            </div>
            <!--end::Sub-->
          </div>
          <!--end::Section-->
          <!--begin::Badge-->
          <span class="badge badge-light-primary fs-base">
            <i class="ki-outline ki-minus fs-5 text-primary ms-n1"></i>0.00%
          </span>
          <!--end::Badge-->
        </div>
        <!--end::Body-->
      </div>
      <!--end::Card widget 2-->
    </div>
    <!--end::Col-->

    <!--begin::Col - Pengeluaran Pembiayaan-->
    <div class="col-sm-6 col-xl-3 mb-xl-10">
      <!--begin::Card widget 2-->
      <div class="card h-lg-100">
        <!--begin::Body-->
        <div class="card-body d-flex justify-content-between align-items-start flex-column">
          <!--begin::Icon-->
          <div class="m-0">
            <i class="ki-outline ki-minus-circle fs-2hx text-gray-600"></i>
          </div>
          <!--end::Icon-->
          <!--begin::Section-->
          <div class="d-flex flex-column my-7">
            <!--begin::Number-->
            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">50 M</span>
            <!--end::Number-->
            <!--begin::Label-->
            <div class="m-0">
              <span class="fw-semibold fs-6 text-gray-500">Pengeluaran Pembiayaan</span>
            </div>
            <!--end::Label-->
            <!--begin::Sub-->
            <div class="m-0 mt-1">
              <span class="fw-semibold fs-8 text-gray-400">Realisasi Rill Rp0,00</span>
            </div>
            <div class="m-0">
              <span class="fw-semibold fs-8 text-gray-400">(Realisasi Rencana Rp12.250.000.000)</span>
            </div>
            <!--end::Sub-->
          </div>
          <!--end::Section-->
          <!--begin::Badge-->
          <span class="badge badge-light-primary fs-base">
            <i class="ki-outline ki-minus fs-5 text-primary ms-n1"></i>0.00%
          </span>
          <!--end::Badge-->
        </div>
        <!--end::Body-->
      </div>
      <!--end::Card widget 2-->
    </div>
    <!--end::Col-->

  </div>
  <!--end::Row-->
@endsection
