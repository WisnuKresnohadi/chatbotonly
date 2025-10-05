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
    <h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
          <li class="breadcrumb-item">
            Profil
          </li>
          <li class="breadcrumb-item">
            <a href="{{ url("mahasiswa/profile/pribadi/" . Auth::user()->nim)}}">Informasi Pribadi</a>
          </li>
          <li class="breadcrumb-item active">Pengalaman dan Keahlian</li>
        </ol>
      </nav>
    </h4>
  </div>
  <!-- Pengalaman dan Keahlian -->

  <div class="card mb-4">
    <div class="d-flex justify-content-between pt-3 ps-3 pe-3">
      <h5 class="text-secondary">Keahlian</h5>
      <div class="text-end">
        <i class="menu-icon tf-icons ti ti-edit text-warning mt-2" data-bs-toggle="modal" data-bs-target="#modalEditKeahlian"></i>
      </div>
    </div>
    <div class="card-body pb-0 pt-0">
      <div>
        @foreach($skill as $s)
        <span class="btn rounded-pill btn-success waves-effect waves-light">{{$s?->skills??''}}</span>
        @endforeach
      </div>
      <div class="border-bottom mt-3"></div>
      <div class="d-flex justify-content-between pt-3 pb-3">
        <h5 class="text-secondary">Pengalaman</h5>
        <div class="text-end">
        </div>
      </div>
      <ul class="timeline mb-0">
        @foreach($pengalaman as $pe)
        <li class="timeline-item timeline-item-transparent">
          <span class="timeline-point timeline-point-success"></span>
          <div class="timeline-event">
            <div class="timeline-header mt-5">
              <h6 class="mb-0">{{$pe?->posisi??''}}</h6>
              <div>
                <i class="menu-icon tf-icons ti ti-edit text-warning" data-bs-toggle="modal" data-bs-target="#modalEditPengalaman"></i>
                <i class="menu-icon tf-icons ti ti-trash text-danger" data-bs-toggle="modal" data-bs-target="#deleteModalPengalaman"></i>
              </div>
            </div>
            <div class="border-bottom mb-3">
              <p class="mb-1">{{$pe?->name_intitutions??''}} - {{$pe?->jenis??''}}</p>
              <p style="font-size: small;">{{$pe?->startdate??''}} - {{$pe?->enddate??''}}</p>
              <div>
                <p class="mb-0">{{$pe?->deskripsi??''}}</p>
                {{-- <p class="content-new mb-0">driving digitalisation and sustainability for the energy, infrastructure and industrial sectors all over the world.</p>
                <u class="show_hide_new cursor-pointer" style="color:#4EA971">
                  See more
                </u> --}}
              </div>
            </div>
          </div>
        </li>
        @endforeach
        <li class="timeline-item timeline-item-transparent mb-5">
          <span class="timeline-point timeline-point-success"></span>
        </li>
      </ul>
    </div>
  </div>

  <!-- Modal Tambah Keahlian -->
  <div class="modal fade" id="modalTambahKeahlian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header d-block">
          <h5 class="modal-title" id="modal-title">Tambah Keahlian</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body border-top mt-3">
          <form id="" method="POST" onsubmit="return false">
            <div class="row">
              <div class="mb-3 col-md-12">
                <label for="TagifyCustomListSuggestion" class="form-label">Keahlian<span style="color: red;">*</span></label>
                <input id="keahlian" name="keahlian" class="form-control" placeholder="Masukkan Keahlian" value="" />
              </div>
            </div>
            <div class="modal-footer p-0">
              <button type="submit" class="btn btn-success m-0">Simpan Data</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Edit Keahlian -->
  <div class="modal fade" id="modalEditKeahlian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header d-block">
          <h5 class="modal-title" id="modal-title">Edit Keahlian</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body border-top mt-3">
          <form id="" method="POST" onsubmit="return false">
            <div class="row">
              <div class="mb-3 col-md-12">
                <label for="TagifyCustomListSuggestion" class="form-label">Keahlian<span style="color: red;">*</span></label>
                <input id="editkeahlian" name="keahlian" class="form-control" placeholder="Masukkan Keahlian" value="" />
              </div>
            </div>
            <div class="modal-footer p-0">
              <button type="submit" class="btn btn-success m-0">Simpan Data</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Tambah Pengalaman -->
  <div class="modal fade" id="modalTambahPengalaman" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header d-block">
          <h5 class="modal-title" id="modal-title">Tambah Pengalaman</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- Account -->
        <div class="modal-body border-top mt-3">
          <div class="d-flex align-items-start align-items-sm-center gap-4 mb-2">
          </div>
          <form id="formAccountSettings" method="POST" onsubmit="return false">
            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="posisi" class="form-label">Posisi / Bidang <span style="color: red;">*</span></label>
                <input class="form-control" type="text" id="posisi" name="posisi" placeholder="Ex: UI/UX Designer" />
              </div>
              <div class="mb-3 col-md-6">
                <label for="pekerjaan3" class="form-label">Jenis Pekerjaan <span style="color: red;">*</span></label>
                <select id="pekerjaan3" class="select2 form-select">
                  <option disabled selected>Pilih Jenis Pekerjaan</option>
                  <option value="Pekerjaan">Pekerjaan</option>
                  <option value="Pekerjaan">Pekerjaan</option>
                </select>
              </div>
              <div class="mb-3 col-md-12">
                <label for="namaperusahaan" class="form-label">Nama Perusahaan <span style="color: red;">*</span></label>
                <input class="form-control" type="text" id="namaperusahaan" name="namaperusahaan" placeholder="Ex: PT Techno Infinity" />
              </div>
              <div class="mb-3 col-md-12">
                <label for="" class="form-label">Tanggal Mulai<span style="color: red;">*</span></label>
                <input type="month" id="month" class="form-control" placeholder="Month" />
              </div>
              <div class="mb-3 col-md-12">
                <label for="" class="form-label">Tanggal Berakhir<span style="color: red;">*</span></label>
                <input type="month" id="month" class="form-control" placeholder="Month" />
              </div>
              <div class="mb-3 col-md-12">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" type="text" id="deskripsi" name="deskripsi" placeholder="Ketik di sini..."></textarea>
              </div>
            </div>
            <div class="modal-footer p-0">
              <button type="submit" class="btn btn-success m-0">Simpan Data</button>
            </div>
          </form>

        </div>
        <!-- /Account -->
      </div>
    </div>
  </div>

  <!-- Modal Edit Pengalaman -->
  <div class="modal fade" id="modalEditPengalaman" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header d-block">
          <h5 class="modal-title" id="modal-title">Edit Pengalaman</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- Account -->
        <div class="modal-body border-top mt-3">
          <div class="d-flex align-items-start align-items-sm-center gap-4 mb-2">
          </div>
          <form id="formAccountSettings" method="POST" onsubmit="return false">
            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="posisi" class="form-label">Posisi / Bidang <span style="color: red;">*</span></label>
                <input class="form-control" type="text" id="posisi" name="posisi" placeholder="Ex: UI/UX Designer" />
              </div>
              <div class="mb-3 col-md-6">
                <label for="pekerjaan4" class="form-label">Jenis Pekerjaan <span style="color: red;">*</span></label>
                <select id="pekerjaan4" class="select2 form-select">
                  <option disabled selected>Pilih Jenis Pekerjaan</option>
                  <option value="Pekerjaan">Pekerjaan</option>
                  <option value="Pekerjaan">Pekerjaan</option>
                </select>
              </div>
              <div class="mb-3 col-md-12">
                <label for="namaperusahaan" class="form-label">Nama Perusahaan <span style="color: red;">*</span></label>
                <input class="form-control" type="text" id="namaperusahaan" name="namaperusahaan" placeholder="Ex: PT Techno Infinity" />
              </div>
              <div class="mb-3 col-md-12">
                <label for="" class="form-label">Tanggal Mulai<span style="color: red;">*</span></label>
                <input type="month" id="month" class="form-control" placeholder="Month" />
              </div>
              <div class="mb-3 col-md-12">
                <label for="" class="form-label">Tanggal Berakhir<span style="color: red;">*</span></label>
                <input type="month" id="month" class="form-control" placeholder="Month" />
              </div>
              <div class="mb-3 col-md-12">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" type="text" id="deskripsi" name="deskripsi" placeholder="Ketik di sini..."></textarea>
              </div>
            </div>
            <div class="modal-footer p-0">
              <button type="submit" class="btn btn-success m-0">Simpan Data</button>
            </div>
          </form>

        </div>
        <!-- /Account -->
      </div>
    </div>
  </div>

  <!-- Modal Delete Pengalaman -->
  <div class="modal fade" id="deleteModalPengalaman" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <h5 class="modal-title" id="modal-title">Apakah Anda Ingin menghapus <br> Pengalaman Ini?</h5>
        </div>
        <div class="modal-footer" style="display: flex; justify-content:center;">
          <button type="submit" id="modal-button" class="btn btn-success">Iya</button>
          <button type="submit" id="modal-button" class="btn btn-danger">Tidak</button>
        </div>

      </div>
    </div>
  </div>


</div>

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