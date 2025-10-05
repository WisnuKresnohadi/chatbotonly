@extends('partials_mahasiswa.template')

@section('page_style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  .hidden {
    display: none;
  }

  .btn-success {
    color: #fff;
    background-color: #4EA971 !important;
    border-color: #4EA971 !important;
  }

  .light-style .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 2.25rem;
    color: #6f6b7d;
    padding-left: 0.875rem;
    width: 310px;
  }

  .content-wrapper {
    background-color: white;
  }

  .page-item.active .page-link,
  .pagination li.active>a:not(.page-link) {
    border-color: #4EA971 !important;
    background-color: #4EA971 !important;
    color: #fff;
  }

  .light-style .select2-container--default .select2-selection {
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    background-color: #fff;
    border: 1px solid #dbdade;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    border-left: 0px;
    border-bottom-right-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
  } 

  .menu-link {
    text-decoration: none !important;
  }

  .select2-results__option[role="option"][aria-selected="true"] {
    background-color: #4EA971;
    color: #fff;
  }

  .select2-container--default .select2-results__option--highlighted:not([aria-selected="true"]) {
    background-color: rgba(115, 103, 240, 0.08) !important;
    color: #4EA971 !important;
  }

  input[type="checkbox"]:focus {
    outline: 0px auto -webkit-focus-ring-color;
    outline-offset: -2px;
  }

  .form-check-input:checked,
  .form-check-input[type=checkbox]:indeterminate {
    background-color: #4EA971 !important;
    border-color: #4EA971 !important;
  }

  .light-style .flatpickr-input[readonly],
  .light-style .flatpickr-input~.form-control[readonly] {
    background: #F8F8F8
  }

  .light-style .select2-container--default .select2-selection--single {
    width: 530px;
  }
</style>

@endsection

@section('main')
<div class="auto-container" style="background-color: #F8F8F8;background-repeat: no-repeat; background-size: cover; background-image: url({{asset('assets/images/background.png')}});">
  <div class="row mt-5 mb-3" style="margin-left:70px;">
    <div class="col-5">
      <div class="input-group input-group-merge">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
        <input type="text" class="form-control" placeholder="Lowongan Magang" aria-label="Lowongan Magang" aria-describedby="basic-addon-search31" style="height: 37px;">
      </div>
    </div>
    <div class="col-5">
      <div class="input-group input-group-merge">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-map-pin"></i></span>
        <select class="select2 form-control" data-placeholder="Pilih lokasi Magang" aria-describedby="basic-addon-search31">
          <option disabled selected> Lokasi Magang </option>
          <option> Bandung </option>
          <option> Jakarta </option>
          <option> Medan </option>
          <option> Surabaya </option>
          <option> Yogyakarta </option>
        </select>
      </div>
    </div>
    <div class="col-2">
      <button class="btn btn-success" type="submit">Cari sekarang</button>
    </div>
  </div>
  <div class="row mt-4 mb-4">
    <div class="col-1 ms-5"></div>
    <div class="col-2">
      <p class="flatpickr-input" id="flatpickr-range">Tanggal Posting <i class=" ti ti-chevron-down" style="font-size: 15px;"></i></p>
    </div>
    <div class="col-2">
      <div class="dropdown cursor-pointer">
        <a class="dropdown-toogle" data-bs-toggle="dropdown" aria-expanded="false">
          Perusahaan
          <i class="ti ti-chevron-down pb-1" style="font-size: medium;"></i>
        </a>
        <ul class="dropdown-menu checkbox-menu allow-focus" aria-labelledby="dropdownMenu1">

          <li class="ps-2 pe-3">
            <input class="form-check-input" type="checkbox" style="margin-top: 0px; margin-right:3px" style="margin-top: 0px; margin-right:3px"> PT Techno Infinity
          </li>

          <li class="ps-2 pe-3">
            <input class="form-check-input" type="checkbox" style="margin-top: 0px; margin-right:3px"> Direktorat PUTI Tel-U
          </li>

          <li class="ps-2 pe-3">
            <input class="form-check-input" type="checkbox" style="margin-top: 0px; margin-right:3px"> PT Telkom Indonesia
          </li>

          <li class="ps-2 pe-3">
            <input class="form-check-input" type="checkbox" style="margin-top: 0px; margin-right:3px"> PT Inovasi Daya Solusi
          </li>

          <li class="ps-2 pe-3">
            <input class="form-check-input" type="checkbox" style="margin-top: 0px; margin-right:3px"> PT Indo Trans Teknologi
          </li>

          <li class="ps-2 pe-3">
            <input class="form-check-input" type="checkbox" style="margin-top: 0px; margin-right:3px"> Direktorat PUTI Tel-U
          </li>

          <li class="ps-2 pe-3">
            <input class="form-check-input" type="checkbox" style="margin-top: 0px; margin-right:3px"> Fakultas Ilmu Terapan
          </li>

        </ul>
      </div>
    </div>
    <div class="col-2">
      <div class="dropdown cursor-pointer">
        <a class="dropdown-toogle" data-bs-toggle="dropdown" aria-expanded="false">
          Benefit
          <i class="ti ti-chevron-down pb-1" style="font-size: medium;"></i>
        </a>
        <ul class="dropdown-menu checkbox-menu allow-focus" aria-labelledby="dropdownMenu1">
          <li class="ps-2 pe-5">
            <input class="form-check-input" type="checkbox" style="margin-top: 0px; margin-right:3px"> Berbayar
          </li>

          <li class="ps-2 pe-5">
            <input class="form-check-input" type="checkbox" style="margin-top: 0px; margin-right:3px"> Tidak Berbayar
          </li>
        </ul>
      </div>
    </div>
    <div class="col-2">
      <div class="dropdown cursor-pointer">
        <a class="dropdown-toogle" data-bs-toggle="dropdown" aria-expanded="false">
          Durasi Magang
          <i class="ti ti-chevron-down pb-1" style="font-size: medium;"></i>
        </a>
        <ul class="dropdown-menu checkbox-menu allow-focus" aria-labelledby="dropdownMenu1">
          <li class="ps-2 pe-5">
            <input class="form-check-input" type="checkbox" style="margin-top: 0px; margin-right:3px">Magang 1 Semester
          </li>

          <li class="ps-2 pe-5">
            <input class="form-check-input" type="checkbox" style="margin-top: 0px; margin-right:3px">Magang 2 Semester
          </li>
        </ul>
      </div>
    </div>
    <div class="col-2">
      <div class="dropdown cursor-pointer">
        <a class="dropdown-toogle" data-bs-toggle="dropdown" aria-expanded="false">
          Tipe Magang
          <i class="ti ti-chevron-down pb-1" style="font-size: medium;"></i>
        </a>
        <ul class="dropdown-menu checkbox-menu allow-focus" aria-labelledby="dropdownMenu1">
          <li class="ps-2 pe-5">
            <input class="form-check-input" type="checkbox" style="margin-top: 0px; margin-right:3px"> Onsite
          </li>

          <li class="ps-2 pe-5">
            <input class="form-check-input" type="checkbox" style="margin-top: 0px; margin-right:3px"> Hybrid
          </li>
          <li class="ps-2 pe-5">
            <input class="form-check-input" type="checkbox" style="margin-top: 0px; margin-right:3px"> Online
          </li>
        </ul>
      </div>
    </div>
    <div class="col-1"></div>
  </div>
</div>

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="sec-title text-start mb-5 mt-4">
    <h4 class="">Magang Fakultas (1 & 2 Semester)</h4>
  </div>
  <div class="row mt-3 mb-2">
    <div class="col-md-6 col-lg-4 mb-3">
      <div class="card">
        <div class="card-body">
          <div class="row card-header" style="background-color: #FFFFFF; padding:0px;">
            <div class="col-3 text-left">
              <figure class="image" style="border-radius: 0%;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
              </figure>
            </div>
            <div class="col-6 ms-3 ">
              <h5 class="mb-1" style="text-align: left !important; font-size: 20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;"> Human Resources</h5>
              <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
            </div>
            <div class="col-2">
              <i onclick="myFunction(this)" class="fa fa-bookmark-o ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
            </div>
          </div>
          <div class="border"></div>
          <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px;margin-bottom:5px;"></i>Jakarta Selatan, Indonesis</div>
          <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px;margin-bottom:5px;"></i>Berbayar</div>
          <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-calendar-time" style="margin-right: 10px;margin-bottom:5px;"></i>2 Semester</div>
          <div class="row">
            <div class="col-6">
              <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px;margin-bottom:5px;"></i>5 Kuota Penerimaan</div>
            </div>
            <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
              <div class="location"> 8 hari lalu</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-4 mb-3">
      <a href="/detail/lowongan/magang" style="color: #6f6b7d; text-decoration:none;">
        <div class="card">
          <div class="card-body">
            <div class="row card-header" style="background-color: #FFFFFF; padding:0px;">
              <div class="col-3 text-left">
                <figure class="image" style="border-radius: 0%;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                </figure>
              </div>
              <div class="col-6 ms-3 ">
                <h5 class="mb-1" style="text-align: left !important; font-size: 20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;"> Human Resources</h5>
                <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
              </div>
              <div class="col-2">
                <i onclick="myFunction(this)" class="fa fa-bookmark-o ms-4" style="font-size: 40px; color:#4ea971;"></i>
              </div>
            </div>
            <div class="border"></div>
            <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px;margin-bottom:5px;"></i>Jakarta Selatan, Indonesis</div>
            <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px;margin-bottom:5px;"></i>Berbayar</div>
            <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-calendar-time" style="margin-right: 10px;margin-bottom:5px;"></i>2 Semester</div>
            <div class="row">
              <div class="col-6">
                <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px;margin-bottom:5px;"></i>5 Kuota Penerimaan</div>
              </div>
              <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                <div class="location"> 8 hari lalu</div>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-lg-4 mb-3">
      <div class="card">
        <div class="card-body">
          <div class="row card-header" style="background-color: #FFFFFF; padding:0px;">
            <div class="col-3 text-left">
              <figure class="image" style="border-radius: 0%;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
              </figure>
            </div>
            <div class="col-6 ms-3 ">
              <h5 class="mb-1" style="text-align: left !important; font-size: 20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;"> Human Resources</h5>
              <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
            </div>
            <div class="col-2">
              <i onclick="myFunction(this)" class="fa fa-bookmark-o ms-4" style="font-size: 40px; color:#4ea971;"></i>
            </div>
          </div>
          <div class="border"></div>
          <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px;margin-bottom:5px;"></i>Jakarta Selatan, Indonesis</div>
          <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px;margin-bottom:5px;"></i>Berbayar</div>
          <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-calendar-time" style="margin-right: 10px;margin-bottom:5px;"></i>2 Semester</div>
          <div class="row">
            <div class="col-6">
              <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px;margin-bottom:5px;"></i>5 Kuota Penerimaan</div>
            </div>
            <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
              <div class="location"> 8 hari lalu</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-4 mb-3">
      <div class="card">
        <div class="card-body">
          <div class="row card-header" style="background-color: #FFFFFF; padding:0px;">
            <div class="col-3 text-left">
              <figure class="image" style="border-radius: 0%;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
              </figure>
            </div>
            <div class="col-6 ms-3 ">
              <h5 class="mb-1" style="text-align: left !important; font-size: 20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;"> Human Resources</h5>
              <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
            </div>
            <div class="col-2">
              <i onclick="myFunction(this)" class="fa fa-bookmark-o ms-4" style="font-size: 40px; color:#4ea971;"></i>
            </div>
          </div>
          <div class="border"></div>
          <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px;margin-bottom:5px;"></i>Jakarta Selatan, Indonesis</div>
          <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px;margin-bottom:5px;"></i>Berbayar</div>
          <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-calendar-time" style="margin-right: 10px;margin-bottom:5px;"></i>2 Semester</div>
          <div class="row">
            <div class="col-6">
              <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px;margin-bottom:5px;"></i>5 Kuota Penerimaan</div>
            </div>
            <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
              <div class="location"> 8 hari lalu</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-4 mb-3">
      <div class="card">
        <div class="card-body">
          <div class="row card-header" style="background-color: #FFFFFF; padding:0px;">
            <div class="col-3 text-left">
              <figure class="image" style="border-radius: 0%;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
              </figure>
            </div>
            <div class="col-6 ms-3 ">
              <h5 class="mb-1" style="text-align: left !important; font-size: 20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;"> Human Resources</h5>
              <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
            </div>
            <div class="col-2">
              <i onclick="myFunction(this)" class="fa fa-bookmark-o ms-4" style="font-size: 40px; color:#4ea971;"></i>
            </div>
          </div>
          <div class="border"></div>
          <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px;margin-bottom:5px;"></i>Jakarta Selatan, Indonesis</div>
          <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px;margin-bottom:5px;"></i>Berbayar</div>
          <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-calendar-time" style="margin-right: 10px;margin-bottom:5px;"></i>2 Semester</div>
          <div class="row">
            <div class="col-6">
              <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px;margin-bottom:5px;"></i>5 Kuota Penerimaan</div>
            </div>
            <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
              <div class="location"> 8 hari lalu</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-4 mb-3">
      <div class="card">
        <div class="card-body">
          <div class="row card-header" style="background-color: #FFFFFF; padding:0px;">
            <div class="col-3 text-left">
              <figure class="image" style="border-radius: 0%;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
              </figure>
            </div>
            <div class="col-6 ms-3 ">
              <h5 class="mb-1" style="text-align: left !important; font-size: 20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;"> Human Resources</h5>
              <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
            </div>
            <div class="col-2">
              <i onclick="myFunction(this)" class="fa fa-bookmark-o ms-4" style="font-size: 40px; color:#4ea971;"></i>
            </div>
          </div>
          <div class="border"></div>
          <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px;margin-bottom:5px;"></i>Jakarta Selatan, Indonesis</div>
          <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px;margin-bottom:5px;"></i>Berbayar</div>
          <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-calendar-time" style="margin-right: 10px;margin-bottom:5px;"></i>2 Semester</div>
          <div class="row">
            <div class="col-6">
              <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px;margin-bottom:5px;"></i>5 Kuota Penerimaan</div>
            </div>
            <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
              <div class="location"> 8 hari lalu</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-end">
      <li class="page-item">
        <a class="page-link" href="javascript:void(0);">Previous</a>
      </li>
      <li class="page-item active">
        <a class="page-link" href="javascript:void(0);">1</a>
      </li>
      <li class="page-item">
        <a class="page-link" href="javascript:void(0);">2</a>
      </li>
      <li class="page-item">
        <a class="page-link" href="javascript:void(0);">3</a>
      </li>
      <li class="page-item">
        <a class="page-link" href="javascript:void(0);">Next</a>
      </li>
    </ul>
  </nav>
</div>

@endsection

@section('page_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
<script>
  $(".checkbox-menu").on("change", "input[type='checkbox']", function() {
    $(this).closest("li").toggleClass("active", this.checked);
  });

  $(document).on('click', '.allow-focus', function(e) {
    e.stopPropagation();
  });

  function myFunction(x) {
    x.classList.toggle("fa-bookmark");
    x.classList.toggle("fa-bookmark-o");
  }
</script>
@endsection