@extends('partials_mahasiswa.template')

@section('page_style')
<link rel="stylesheet" href="{{ url('assets/css/yearpicker.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('assets/css/monthpicker.css') }}">
<style>
  .btn-success {
    color: #fff;
    background-color: #4EA971 !important;
    border-color: #4EA971 !important;
  }

  .breadcrumb-item,
  .breadcrumb-item a {
    color: #4b465c !important;
  }

  .select2-results__option[role="option"][aria-selected="true"] {
    background-color: #4EA971 !important;
    color: #fff;
  }

  .select2-container--default .select2-results__option--highlighted:not([aria-selected="true"]) {
    background-color: rgba(115, 103, 240, 0.08) !important;
    color: #4EA971 !important;
  }
</style>

@endsection

@section('main')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="sec-title mt-4 mb-4">
    <div class="sec-title mt-4 mb-4">
      <h4>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
              Profil
            </li>
            <li class="breadcrumb-item">
              <a href="{{ url("mahasiswa/profile/dokumen-pendukung/" . Auth::user()->nim)}}">Informasi Pribadi</a>
            </li>
            <li class="breadcrumb-item active">Dokumen Pendukung</li>
          </ol>
        </nav>
      </h4>
    </div>
  </div>
  <!-- Dokumen Pendukung -->

  <div class="card mb-4">
    <div class="d-flex justify-content-between border-bottom pt-3 ps-3 pe-3">
      <h5 class="text-secondary">Dokumen Pendukung</h5>
    </div>
    <div class="card-body">
      <ul class="timeline">
        @foreach($dokumen1 as $dok)
        <li class="timeline-item timeline-item-transparent">
          <span class="timeline-point timeline-point-success"></span>
          <div class="timeline-event">
            <div class="timeline-header">
              <h6 class="mb-0">{{$dok?->nama_sertif??''}}</h6>
              <div>
                <i class="menu-icon tf-icons ti ti-edit text-warning" data-bs-toggle="modal" data-bs-target="#modalEditDokumen"></i>
                <i class="menu-icon tf-icons ti ti-trash text-danger" data-bs-toggle="modal" data-bs-target="#ModalDelete"></i>
              </div>
            </div>
            <div class="border-bottom mb-3">
              <p class="mb-1">Penerbit : {{$dok?->penerbit??''}}</p>
              <p style="font-size: small;">{{$dok?->startdate??''}} sampai {{$dok?->enddate??''}}
              <div>
                <p class="mb-0">{{$dok?->deskripsi??''}}</p>
                <p class="content-new mb-0">driving digitalisation and sustainability for the energy, infrastructure and industrial sectors all over the world.</p>
                <u class="show_hide_new cursor-pointer" style="color:#4EA971">
                  See more
                </u>
              </div>
              <div class="d-flex align-items-start mt-3 mb-3">
                <div>
                  {{-- <img src="{{ url("app-assets/img/avatars/2.png")}}"> --}}
                  <img src="{{ url('storage/' .$dok?->file_sertif??'assets/images/no-pictures.png')}}" width="250" height="auto" alt="img">
                </div>
                <div class="me-2 ms-4">
                  <h6 class="mt-5"><a href="{{$dok?->link_sertif??''}}" target="_blank">Lihat Dokumen</a></h6>
                </div>
              </div>
            </div>
          </div>
        </li>
        @endforeach
        <li class="timeline-item timeline-item-transparent">
          <span class="timeline-point timeline-point-success"></span>
        </li>
      </ul>
    </div>
  </div>
</div>
@include('profile.modal_dok_pendukung')
@include('profile.modal_destroy')
@endsection

@section('page_script')
<script>
  $(document).ready(function() {
    $(".content-new").hide();
    $(".show_hide_new").on("click", function() {
      var content = $(this).prev('.content-new');
      content.slideToggle(100);
      if ($(this).text().trim() == "See more") {
        $(this).text("See less");
      } else {
        $(this).text("See more");
      }
    });
  });
  $(document).ready(function() {
    $(".yearpicker").yearpicker({
      startYear: new Date().getFullYear() - 10,
      endYear: new Date().getFullYear() + 10,
    });
  });

  $('#month').flatpickr({
    altInput: true,
    altFormat: 'F Y',
    plugins: [
      new monthSelectPlugin({
        dateFormat: "Y-m",
      })
    ]
  });
</script>
<script src="{{ url('assets/js/yearpicker.js') }}"></script>
<script src="{{ url('assets/js/monthpicker.js') }}"></script>
@endsection