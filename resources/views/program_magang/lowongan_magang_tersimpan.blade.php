@extends('partials_mahasiswa.template')

@section('page_style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .page-item.active .page-link,
    .pagination li.active>a:not(.page-link) {
        border-color: #FFFFFF !important;
        background-color: #4EA971 !important;
    }

    .btn-success {
        color: #fff;
        background-color: #4EA971 !important;
        border-color: #4EA971 !important;
    }
    .menu-link {
    text-decoration: none !important;
  }
  .pagination>li>a,
  .pagination>li>span {
    position: relative;
    float: left;
    padding: 6px 12px;
    margin-left: -1px;
    line-height: 1.42857143;
    color: #333;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #ddd;
  }
</style>
@endsection

@section('main')
    {{-- balum ada lowongan tersimpan --}}
    {{-- <div class="col-3 text-left">
    <img class="image" style="border-radius: 0%; margin-left: 400px; justify-content-center" src="{{ asset('front/assets/img/belum_ada_lowongan.png')}}" alt="admin.upload">
</div>
<div class="sec-title mt-5 mb-4" style="text-align:center">
    <p style="text-align: center">
    <h4><b> Belum Ada Lowongan Tersimpan </b></h4>
    </p>
    <div class="mt-4">
        <a href="javascript:void(0)" class="btn btn-success" type="submit">Cari Lowongan</a>
    </div>
</div> --}}

<div class="container-xxl flex-grow-1 container-p-y">
<div class="sec-title mt-3 mb-4">
    <h4><b>Lowongan Tersimpan</b></h4>
</div>
<form class="d-flex" onsubmit="return false">
    <div class="input-group input-group-merge" style="margin-right: 15px;">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
        <input type="text" class="form-control" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31" style="height:40px">
    </div>
    <button class="btn btn-success" type="submit" style="width: 160px">Cari sekarang</button>
</form>
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
                        <h5 class="mb-1" style="text-align: left !important; font-size: 20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                        <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                    </div>
                    <div class="col-2">
                        <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
                    </div>
                </div>
                <div class="border"></div>
                <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                <div class="row">
                    <div class="col-6">
                        <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                    </div>
                    <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                        <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                        <h5 class="mb-1" style="text-align: left !important; font-size: 20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                        <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                    </div>
                    <div class="col-2">
                        <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;"></i>
                    </div>
                </div>
                <div class="border"></div>
                <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                <div class="row">
                    <div class="col-6">
                        <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                    </div>
                    <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                        <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                        <h5 class="mb-1" style="text-align: left !important; font-size: 20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                        <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                    </div>
                    <div class="col-2">
                        <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;"></i>
                    </div>
                </div>
                <div class="border"></div>
                <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                <div class="row">
                    <div class="col-6">
                        <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                    </div>
                    <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                        <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                        <h5 class="mb-1" style="text-align: left !important; font-size: 20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                        <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                    </div>
                    <div class="col-2">
                        <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;"></i>
                    </div>
                </div>
                <div class="border"></div>
                <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                <div class="row">
                    <div class="col-6">
                        <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                    </div>
                    <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                        <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                        <h5 class="mb-1" style="text-align: left !important; font-size: 20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                        <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                    </div>
                    <div class="col-2">
                        <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;"></i>
                    </div>
                </div>
                <div class="border"></div>
                <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                <div class="row">
                    <div class="col-6">
                        <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                    </div>
                    <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                        <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                        <h5 class="mb-1" style="text-align: left !important; font-size: 20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                        <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                    </div>
                    <div class="col-2">
                        <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;"></i>
                    </div>
                </div>
                <div class="border"></div>
                <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                <div class="row">
                    <div class="col-6">
                        <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                    </div>
                    <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                        <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row card-header" style="background-color: #FFFFFF; padding:0px;">
                        <div class="col-3 text-left">
                            <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                            </figure>
                        </div>
                        <div class="col-7">
                            <h5 class="mb-1" style="text-align: left !important; font-size: 20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                            <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                        </div>
                        <div class="col-2">
                            

                            <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
                        </div>
                    </div>
                    <div class="border"></div>
                    <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                    <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                    <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                    <div class="row">
                        <div class="col-6">
                            <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                        </div>
                        <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                            <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                            <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                            </figure>
                        </div>
                        <div class="col-7">
                            <h5 class="mb-1" style="text-align: left !important; font-size: 20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                            <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                        </div>
                        <div class="col-2">
                            <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
                        </div>
                    </div>
                    <div class="border"></div>
                    <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                    <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                    <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                    <div class="row">
                        <div class="col-6">
                            <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                        </div>
                        <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                            <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                            <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                            </figure>
                        </div>
                        <div class="col-7">
                            <h5 class="mb-1" style="text-align: left !important; font-size: 20px;-webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                            <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                        </div>
                        <div class="col-2">
                            

                            <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
                        </div>
                    </div>
                    <div class="border"></div>
                    <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                    <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                    <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                    <div class="row">
                        <div class="col-6">
                            <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                        </div>
                        <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                            <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                            <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                            </figure>
                        </div>
                        <div class="col-7">
                            <h5 class="mb-1" style="text-align: left !important; font-size: 20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                            <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                        </div>
                        <div class="col-2">
                            

                            <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
                        </div>
                    </div>
                    <div class="border"></div>
                    <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                    <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                    <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                    <div class="row">
                        <div class="col-6">
                            <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                        </div>
                        <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                            <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                            <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                            </figure>
                        </div>
                        <div class="col-7">
                            <h5 class="mb-1" style="text-align: left !important; font-size:20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                            <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                        </div>
                        <div class="col-2">
                            

                            <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
                        </div>
                    </div>
                    <div class="border"></div>
                    <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                    <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                    <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                    <div class="row">
                        <div class="col-6">
                            <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                        </div>
                        <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                            <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                            <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                            </figure>
                        </div>
                        <div class="col-7">
                            <h5 class="mb-1" style="text-align: left !important; font-size:20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                            <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                        </div>
                        <div class="col-2">
                            

                            <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
                        </div>
                    </div>
                    <div class="border"></div>
                    <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                    <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                    <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                    <div class="row">
                        <div class="col-6">
                            <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                        </div>
                        <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                            <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                            <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                            </figure>
                        </div>
                        <div class="col-7">
                            <h5 class="mb-1" style="text-align: left !important; font-size:20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                            <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                        </div>
                        <div class="col-2">
                            

                            <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
                        </div>
                    </div>
                    <div class="border"></div>
                    <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                    <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                    <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                    <div class="row">
                        <div class="col-6">
                            <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                        </div>
                        <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                            <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                            <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                            </figure>
                        </div>
                        <div class="col-7">
                            <h5 class="mb-1" style="text-align: left !important; font-size:20px;-webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                            <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                        </div>
                        <div class="col-2">
                            

                            <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
                        </div>
                    </div>
                    <div class="border"></div>
                    <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                    <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                    <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                    <div class="row">
                        <div class="col-6">
                            <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                        </div>
                        <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                            <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                            <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                            </figure>
                        </div>
                        <div class="col-7">
                            <h5 class="mb-1" style="text-align: left !important; font-size:20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                            <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                        </div>
                        <div class="col-2">
                            

                            <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
                        </div>
                    </div>
                    <div class="border"></div>
                    <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                    <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                    <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                    <div class="row">
                        <div class="col-6">
                            <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                        </div>
                        <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                            <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                            <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                            </figure>
                        </div>
                        <div class="col-7">
                            <h5 class="mb-1" style="text-align: left !important; font-size:20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                            <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                        </div>
                        <div class="col-2">
                            

                            <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
                        </div>
                    </div>
                    <div class="border"></div>
                    <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                    <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                    <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                    <div class="row">
                        <div class="col-6">
                            <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                        </div>
                        <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                            <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                            <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                            </figure>
                        </div>
                        <div class="col-7">
                            <h5 class="mb-1" style="text-align: left !important; font-size:20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                            <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                        </div>
                        <div class="col-2">
                            

                            <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
                        </div>
                    </div>
                    <div class="border"></div>
                    <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                    <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                    <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                    <div class="row">
                        <div class="col-6">
                            <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                        </div>
                        <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                            <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                            <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                            </figure>
                        </div>
                        <div class="col-7">
                            <h5 class="mb-1" style="text-align: left !important; font-size:20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                            <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                        </div>
                        <div class="col-2">
                            

                            <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
                        </div>
                    </div>
                    <div class="border"></div>
                    <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                    <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                    <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                    <div class="row">
                        <div class="col-6">
                            <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                        </div>
                        <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                            <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                            <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                            </figure>
                        </div>
                        <div class="col-7">
                            <h5 class="mb-1" style="text-align: left !important; font-size:20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                            <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                        </div>
                        <div class="col-2">
                            <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
                        </div>
                    </div>
                    <div class="border"></div>
                    <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                    <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                    <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                    <div class="row">
                        <div class="col-6">
                            <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                        </div>
                        <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                            <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                            <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                            </figure>
                        </div>
                        <div class="col-7">
                            <h5 class="mb-1" style="text-align: left !important; font-size:20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                            <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                        </div>
                        <div class="col-2">
                            <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
                        </div>
                    </div>
                    <div class="border"></div>
                    <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                    <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                    <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                    <div class="row">
                        <div class="col-6">
                            <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                        </div>
                        <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                            <div class="location" style=""> 8 hari lalu <i class="ti ti-clock"></i></div>
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
                            <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                            </figure>
                        </div>
                        <div class="col-7">
                            <h5 class="mb-1" style="text-align: left !important; font-size:20px; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Back End Developer</h5>
                            <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">PT Wings Surya</p>
                        </div>
                        <div class="col-2">
                            <i onclick="myFunction(this)" class="fa fa-bookmark ms-4" style="font-size: 40px; color:#4ea971;color:#4EA971; "></i>
                        </div>
                    </div>
                    <div class="border"></div>
                    <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px"></i>Jakarta Selatan, Indonesis</div>
                    <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-currency-dollar" style="margin-right: 10px"></i>IDR 4.300.000 - 5.500.000</div>
                    <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-briefcase" style="margin-right: 10px"></i>2 Semester</div>
                    <div class="row">
                        <div class="col-6">
                            <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px"></i>2 Semester</div>
                        </div>
                        <div class="col-6 d-flex justify-content-end" style="padding: 0px; margin-left: -10px;">
                            <div class="location"> 8 hari lalu <i class="ti ti-clock"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
</div>
<!-- Basic Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-end">
        <li class="page-item prev">
            <a class="page-link" href="javascript:void(0);" style="height: 36px;">Previous</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="javascript:void(0);">1</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="javascript:void(0);">2</a>
        </li>
        <li class="page-item active">
            <a class="page-link" href="javascript:void(0);">3</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="javascript:void(0);">Next</a>
        </li>
    </ul>
</nav>
{{-- <i class="ti ti-chevron-left ti-xs"></i> --}}
<!--/ Basic Pagination -->

</div>
@endsection

@section('page_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
<script>
    function myFunction(x) {
        x.classList.toggle("fa-bookmark");
        x.classList.toggle("fa-bookmark-o");
    }
</script>
@endsection