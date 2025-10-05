@extends('layouts.front_layout')


@section('content-main')
<section class="top-companies" style=" margin-top:80px; background-repeat: no-repeat;
    background-size: cover; background-image: url({{asset('assets/images/background.png')}});">
    <form class="form-inline" style="margin-left:100px; margin-top:40px; margin-bottom:40px;">
        <div class="row">
            <div class="col-5">
                <div class="input-group input-group-sm mb-3" style="width: 580px; margin-right: 150px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm" style="background-color: #FFFFFF; border-top-left-radius: 8px; border-bottom-left-radius: 8px;"><i class="flaticon-search-1"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Lowongan Magang" aria-describedby="inputGroup-sizing-sm" style="height: 50px; border-left:0px; border-top-right-radius: 8px; border-bottom-right-radius: 8px;">
                </div>
            </div>
            <div class="col-5">
                <div class="input-group input-group-sm mb-3" style="width: 450px; margin-left: 19px;">
                    <div class="input-group-prepend">    
                    <span class="input-group-text" id="inputGroup-sizing-sm" style="background-color: #FFFFFF; border-top-left-radius: 8px; border-bottom-left-radius: 8px; "><i class="flaticon-map-locator"></i></span>
                    </div>
                    <select id="single" class="js-states form-control">
                        <option selected disabled>Lowongan Magang</option>
                        <option>Bandung</option>
                        <option>Jakarta</option>
                        <option>Medan</option>
                        <option>Surabaya</option>
                    </select>
                </div>
            </div>
            <div class="col-2" style="padding-left: 0px;">
                <button class="btn btn-success my-2 my-sm-0" type="submit" style="width: 130px; height: 50px; border-radius: 8px;">Cari Sekarang</button>
            </div>
        </div>
    </form>


    <div class="logo-box mb-4 mt-0">
        <div class="row">
            <div class="col-3" style="max-width: 15%">
                <a class="dropdown" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 18px;">
                    Tanggal Posting
                    <i class="fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>

            <div class="col-2" style="max-width: 15%">
                <a class="dropdown" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 18px;">
                    Perusahaan
                    <i class="fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
            <div class="col-2" style="max-width: 15%">
                <a class="dropdown" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 18px;">
                    Benefit
                    <i class="fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
            <div class="col-3" style="max-width: 15%">
                <a class="dropdown" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 18px;">
                    Durasi Magang
                    <i class="fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
            <div class="col-2" style="max-width: 15%">
                <a class="dropdown" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 18px;">
                   Tipe Magang
                    <i class="fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
    </div>

</section>


@yield('content')

<section class="top-companies mt-1" style="background: #FFFFFF;">
    <div class="auto-container">
        <div class="sec-title text-left">
            <h4 class="">Magang Fakultas (1 & 2 Semester)</h4>
        </div>

        <div class="carousel-outer wow fadeInUp" style="margin-top: -15px;">

            <div class="row">
                <div class="col-4">
                    <!-- Company-Block  -->
                    <div class="company-block">
                        <div class="inner-box" style="display: flex; width: 420px; height:280px; flex-direction: column; flex-shrink: 0;">
                            <div class="row card-header" style="background-color: #FFFFFF; padding:0px;">
                                <div class="col-3 text-left">
                                    <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                                    </figure>
                                </div>
                                <div class="col-7">
                                    <h5 class="mb-1" style="text-align: left !important; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Human Resources</h5>
                                    <p style="text-align: left !important; font-size:18px; margin-bottom: 0px;">PT Wings Surya</p>
                                </div>
                                <div class="col-2">
                                    <!-- <img src="{{ asset('front/assets/img/bookmark-outline.svg')}}" onclick="changeImage(this)" /> -->

                                    <img src="{{ asset('front/assets/img/bookmark-outline.svg')}}" id="getImage" onclick="imagefun()">
                                </div>
                            </div>
                            <div class="location mt-3 mb-3"  ><i class="flaticon-map-locator"></i>Jl. Gatot Soebroto No 577,
                                Tangerang</div>
                            <div class="location mb-3" style="margin-left: 3px;"><i class="fa fa-dollar"></i>IDR 4.300.000 - 5.500.000
                            </div>
                            <div class="location mb-3" style="margin-left: 3px;"><i class="flaticon-briefcase"></i>2 Semester</div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="location" style="margin-left: 3px;"><i class="fas fa-user-friends"></i>5 Kouta Penerimaan</div>
                                </div>
                                <div class="col-6 d-flex justify-content-end" style="padding: 0px;">
                                    <div class="location" >8 hari lalu <i class="flaticon-clock"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <!-- Company-Block  -->
                    <div class="company-block">
                        <div class="inner-box" style="display: flex; width: 420px; height:280px; flex-direction: column; flex-shrink: 0;">
                            <div class="row card-header" style="background-color: #FFFFFF; padding:0px;">
                                <div class="col-3 text-left">
                                    <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                                    </figure>
                                </div>
                                <div class="col-7">
                                    <h5 class="mb-1" style="text-align: left !important; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Human Resources</h5>
                                    <p style="text-align: left !important; font-size:18px; margin-bottom: 0px;">PT Wings Surya</p>
                                </div>
                                <div class="col-2">
                                    <!-- <img src="{{ asset('front/assets/img/bookmark-outline.svg')}}" onclick="changeImage(this)" /> -->

                                    <img src="{{ asset('front/assets/img/bookmark-outline.svg')}}" id="getImage1" onclick="imagefun1()">
                                </div>
                            </div>
                            <div class="location mt-3 mb-3"   ><i class="flaticon-map-locator"></i>Jl. Gatot Soebroto No 577,
                                Tangerang</div>
                            <div class="location mb-3" style="margin-left: 3px;"><i class="fa fa-dollar"></i>Unpaid
                            </div>
                            <div class="location mb-3" style="margin-left: 3px;"><i class="flaticon-briefcase"></i>2 Semester</div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="location" style="margin-left: 3px;"><i class="fas fa-user-friends"></i>5 Kouta Penerimaan</div>
                                </div>
                                <div class="col-6 d-flex justify-content-end" style="padding: 0px;">
                                    <div class="location">8 hari lalu <i class="flaticon-clock"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <!-- Company-Block  -->
                    <div class="company-block">
                        <div class="inner-box" style="display: flex; width: 420px; height:280px; flex-direction: column; flex-shrink: 0;">
                            <div class="row card-header" style="background-color: #FFFFFF; padding:0px;">
                                <div class="col-3 text-left">
                                    <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                                    </figure>
                                </div>
                                <div class="col-7">
                                    <h5 class="mb-1" style="text-align: left !important; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Human Resources</h5>
                                    <p style="text-align: left !important; font-size:18px; margin-bottom: 0px;">PT Wings Surya</p>
                                </div>
                                <div class="col-2">
                                    <!-- <img src="{{ asset('front/assets/img/bookmark-outline.svg')}}" onclick="changeImage(this)" /> -->

                                    <img src="{{ asset('front/assets/img/bookmark-outline.svg')}}" id="getImage2" onclick="imagefun2()">
                                </div>
                            </div>
                            <div class="location mt-3 mb-3"  ><i class="flaticon-map-locator"></i>Jl. Gatot Soebroto No 577,
                                Tangerang</div>
                            <div class="location mb-3" style="margin-left: 3px;"><i class="fa fa-dollar"></i>IDR 4.300.000 - 5.500.000
                            </div>
                            <div class="location mb-3"  style="margin-left: 3px;"><i class="flaticon-briefcase"></i>2 Semester</div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="location"  style="margin-left: 3px;"><i class="fas fa-user-friends"></i>5 Kouta Penerimaan</div>
                                </div>
                                <div class="col-6 d-flex justify-content-end" style="padding: 0px;">
                                    <div class="location">8 hari lalu <i class="flaticon-clock"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <!-- Company-Block  -->
                    <div class="company-block">
                        <div class="inner-box" style="display: flex; width: 420px; height:280px; flex-direction: column; flex-shrink: 0;">
                            <div class="row card-header" style="background-color: #FFFFFF; padding:0px;">
                                <div class="col-3 text-left">
                                    <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                                    </figure>
                                </div>
                                <div class="col-7">
                                    <h5 class="mb-1" style="text-align: left !important; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Human Resources</h5>
                                    <p style="text-align: left !important; font-size:18px; margin-bottom: 0px;">PT Wings Surya</p>
                                </div>
                                <div class="col-2">
                                    <!-- <img src="{{ asset('front/assets/img/bookmark-outline.svg')}}" onclick="changeImage(this)" /> -->

                                    <img src="{{ asset('front/assets/img/bookmark-outline.svg')}}" id="getImage3" onclick="imagefun3()">
                                </div>
                            </div>
                            <div class="location mt-3 mb-3"  ><i class="flaticon-map-locator"></i>Jl. Gatot Soebroto No 577,
                                Tangerang</div>
                            <div class="location mb-3" style="margin-left: 3px;"><i class="fa fa-dollar"></i>IDR 4.300.000 - 5.500.000
                            </div>
                            <div class="location mb-3" style="margin-left: 3px;"><i class="flaticon-briefcase"></i>2 Semester</div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="location" style="margin-left: 3px;"><i class="fas fa-user-friends"></i>5 Kouta Penerimaan</div>
                                </div>
                                <div class="col-6 d-flex justify-content-end" style="padding: 0px;">
                                    <div class="location">8 hari lalu <i class="flaticon-clock"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <!-- Company-Block  -->
                    <div class="company-block">
                        <div class="inner-box" style="display: flex; width: 420px; height:280px; flex-direction: column; flex-shrink: 0;">
                            <div class="row card-header" style="background-color: #FFFFFF; padding:0px;">
                                <div class="col-3 text-left">
                                    <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                                    </figure>
                                </div>
                                <div class="col-7">
                                    <h5 class="mb-1" style="text-align: left !important; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Human Resources</h5>
                                    <p style="text-align: left !important; font-size:18px; margin-bottom: 0px;">PT Wings Surya</p>
                                </div>
                                <div class="col-2">
                                    <!-- <img src="{{ asset('front/assets/img/bookmark-outline.svg')}}" onclick="changeImage(this)" /> -->

                                    <img src="{{ asset('front/assets/img/bookmark-outline.svg')}}" id="getImage4" onclick="imagefun4()">
                                </div>
                            </div>
                            <div class="location mt-3 mb-3"  ><i class="flaticon-map-locator"></i>Jl. Gatot Soebroto No 577,
                                Tangerang</div>
                            <div class="location mb-3" style="margin-left: 3px;"><i class="fa fa-dollar"></i>IDR 4.300.000 - 5.500.000
                            </div>
                            <div class="location mb-3" style="margin-left: 3px;"><i class="flaticon-briefcase"></i>2 Semester</div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="location" style="margin-left: 3px;"><i class="fas fa-user-friends"></i>5 Kouta Penerimaan</div>
                                </div>
                                <div class="col-6 d-flex justify-content-end" style="padding: 0px;">
                                    <div class="location">8 hari lalu <i class="flaticon-clock"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <!-- Company-Block  -->
                    <div class="company-block">
                        <div class="inner-box" style="display: flex; width: 420px; height:280px; flex-direction: column; flex-shrink: 0;">
                            <div class="row card-header" style="background-color: #FFFFFF; padding:0px;">
                                <div class="col-3 text-left">
                                    <figure class="image" style="border-radius: 0%; margin-left: -15px;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload">
                                    </figure>
                                </div>
                                <div class="col-7">
                                    <h5 class="mb-1" style="text-align: left !important; -webkit-line-clamp: 2;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word;">Human Resources</h5>
                                    <p style="text-align: left !important; font-size:18px; margin-bottom: 0px;">PT Wings Surya</p>
                                </div>
                                <div class="col-2">
                                    <!-- <img src="{{ asset('front/assets/img/bookmark-outline.svg')}}" onclick="changeImage(this)" /> -->

                                    <img src="{{ asset('front/assets/img/bookmark-outline.svg')}}" id="getImage5" onclick="imagefun5()">
                                </div>
                            </div>
                            <div class="location mt-3 mb-3"><i class="flaticon-map-locator" "></i>Jl. Gatot Soebroto No 577,
                                Tangerang</div>
                            <div class="location mb-3" style="margin-left: 3px;"><i class="fa fa-dollar"></i>Unpaid
                            </div>
                            <div class="location mb-3" style="margin-left: 3px;"><i class="flaticon-briefcase"></i>2 Semester</div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="location" style="margin-left: 3px;"><i class="fas fa-user-friends"></i>5 Kouta Penerimaan</div>
                                </div>
                                <div class="col-6 d-flex justify-content-end" style="padding: 0px;">
                                    <div class="location">8 hari lalu <i class="flaticon-clock"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <nav aria-label="">
        <ul class="pagination d-flex justify-content-end" style="margin-right: 74px;">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Previous</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item">
                <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>
</section>
@endsection