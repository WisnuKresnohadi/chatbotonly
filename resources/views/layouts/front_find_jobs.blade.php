@extends('layouts.front_layout')
<!-- Banner Section-->
@section('content-main')
<title>Find Jobs</title>
<span class="header-span"></span>

<!--Page Title-->
<section class="page-title style-three" style="background-image: url({{asset('assets/images/background/bgEllipse.png')}});">
    <div class="auto-container">
        <form>
            <div class="row">
                <!-- Form Group -->
                <div class="form m-3">
                    <div class="job-search-form" data-wow-delay="1000ms" style="border-radius: 10px; border: 2px solid #D3D6DB; background: var(--neutral-color-white-color, #FFF); height: auto; width: 480px;">
                        <div class="form-group col-md-12 col-sm-12">
                            <span class="icon flaticon-search-1"></span>
                            <input type="text" class="form-control autocomplete" name="job" autocomplete="off" placeholder="Search jobs" data-url="{{url('/fetch-jobs')}}"  value="{{request()->job}}">
                        </div>
                    </div>
                </div>
                
                <!-- Form Group -->
                <div class="form m-3">
                    <div class="job-search-form" data-wow-delay="1000ms" style="border-radius: 10px; border: 2px solid #D3D6DB; background: var(--neutral-color-white-color, #FFF); height: auto; width: 480px;">
                        <div class="form-group col-md-12 col-sm-12 location">
                            <span class="icon flaticon-map-locator"></span>
                            <input type="text" class="form-control autocomplete" name="loc" autocomplete="off" placeholder="Search locations" data-url="{{url('/fetch-locations')}}"  value="{{request()->loc}}">
                        </div>
                    </div>
                </div>
                <!-- Form Group -->
                <div class="form m-3">
                    <div class="form-group col-lg-2 col-md-12 col-sm-12 text-right m-1">
                        <button  class="btn-success btn-style-two">Find Jobs</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<div class="row">
   
    <div class="dropdown-find">
        <button class="btn dropdown-toggle dropdown-toggle-find" type="button" data-toggle="dropdown">
        Tanggal Unggah
        </button>
        <ul class="dropdown-menu" style="height: 120px;" >
                <li><a class="dropdown-item" href="#">7 Hari Lalu</a></li>
                <li><a class="dropdown-item" href="#">30 Hari Lalu</a></li>
                <li><a class="dropdown-item" href="#">365 Hari Lalu</a></li>
        </ul>
    </div>
    <div class="dropdown-find">
        <button class="btn dropdown-toggle dropdown-toggle-find" type="button" data-toggle="dropdown">
        Perusahaan
        </button>
        <ul class="dropdown-menu"style="height: 220px ;">
                <div class="dropdown-item" style="width: 95%; border-radius: 6px 6px 6px 6px;border: 1px solid var(--primary-500-base, #4EA971);background: var(--light-solid-color-extra-card-background, #FFF); margin: 5px">
                    <input class="input" type="text" value="" id="flexCheckDefault" placeholder="Input Perusahan" autocomplete="off">
                    <!-- <input type="text" class="form-control autocomplete" name="loc" autocomplete="off" placeholder="Search locations"> -->
                </div>
                <div class="form-check dropdown-item" style="width: 95%; border-radius: 6px 6px 6px 6px;border: 1px solid var(--primary-500-base, #4EA971);background: var(--light-solid-color-extra-card-background, #FFF); margin: 5px">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                    PT ABC
                    </label>
                </div>
                <div class="form-check dropdown-item" style="width: 95%; border-radius: 6px 6px 6px 6px;border: 1px solid var(--primary-500-base, #4EA971);background: var(--light-solid-color-extra-card-background, #FFF); margin: 5px">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        PT DEF
                    </label>
                </div>
                <div class="form-check dropdown-item" style="width: 95%; border-radius: 6px 6px 6px 6px;border: 1px solid var(--primary-500-base, #4EA971);background: var(--light-solid-color-extra-card-background, #FFF); margin: 5px">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                    PT GHI
                    </label>
                </div>
                <div class="form-check dropdown-item" style="width: 95%; border-radius: 6px 6px 6px 6px;border: 1px solid var(--primary-500-base, #4EA971);background: var(--light-solid-color-extra-card-background, #FFF); margin: 5px">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        PT JKL
                    </label>
                </div>  
               
        </ul>
    </div>
    <div class="dropdown-find">
        <button class="btn dropdown-toggle dropdown-toggle-find" type="button" data-toggle="dropdown">
        Gaji
        </button>
        <ul class="dropdown-menu" style="height: 230px ;">
            <div class="text-center dropdown-item-find">
                <li><a class="">Silahkan Masukkan rentang Gaji Perbulan Pada Posisi Yang Anda Inginkan</a></li>
            </div>
            <div class="btn-dropdown-gaji">
                <button type="button" class="" disabled>Rp. 0</button>
            </div>
            <div class="btn-right-dropdown-gaji">
                <button type="button" class="" disabled>Rp. 100 juta</button>
            </div>
            <div>
                <li><a><label for="customRange3" class="form-label"></label>
                    <input type="range" class="form-range-find" min="0" max="5" step="0.5" id="customRange3">
                </label></a></li> 
            </div>
            <div class="btn btn-outline-warning" style="padding">
                <button type="button" class="" disabled>Terapkan</button>
            </div>   
        </ul>
    </div>
    <div class="dropdown-find">
        <button class="btn dropdown-toggle dropdown-toggle-find" type="button" data-toggle="dropdown">
        Tingkat Pengalaman
        </button>
        <ul class="dropdown-menu"style="height: 140px ;">
                <div class="form-check dropdown-item" style="width: 95%; border-radius: 6px 6px 6px 6px;border: 1px solid var(--primary-500-base, #4EA971);background: var(--light-solid-color-extra-card-background, #FFF); margin: 5px">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                    Beginner
                    </label>
                </div>
                <div class="form-check dropdown-item" style="width: 95%; border-radius: 6px 6px 6px 6px;border: 1px solid var(--primary-500-base, #4EA971);background: var(--light-solid-color-extra-card-background, #FFF); margin: 5px">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                    Intermediate
                    </label>
                </div>
                <div class="form-check dropdown-item" style="width: 95%; border-radius: 6px 6px 6px 6px;border: 1px solid var(--primary-500-base, #4EA971);background: var(--light-solid-color-extra-card-background, #FFF); margin: 5px">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                    Advanced
                    </label>
                </div>               
        </ul>
    </div>
    <div class="dropdown-find">
        <button class="btn dropdown-toggle dropdown-toggle-find" type="button" data-toggle="dropdown">
        Tipe Pekerjaan
        </button>
        <ul class="dropdown-menu"style="height: 180px ;">
                <div class="form-check dropdown-item" style="width: 95%; border-radius: 6px 6px 6px 6px;border: 1px solid var(--primary-500-base, #4EA971);background: var(--light-solid-color-extra-card-background, #FFF); margin: 5px">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Magang
                    </label>
                </div>
                <div class="form-check dropdown-item" style="width: 95%; border-radius: 6px 6px 6px 6px;border: 1px solid var(--primary-500-base, #4EA971);background: var(--light-solid-color-extra-card-background, #FFF); margin: 5px">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                    Penuh Waktu
                    </label>
                </div>
                <div class="form-check dropdown-item" style="width: 95%; border-radius: 6px 6px 6px 6px;border: 1px solid var(--primary-500-base, #4EA971);background: var(--light-solid-color-extra-card-background, #FFF); margin: 5px">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                    Paruh Waktu
                    </label>
                </div>
                <div class="form-check dropdown-item" style="width: 95%; border-radius: 6px 6px 6px 6px;border: 1px solid var(--primary-500-base, #4EA971);background: var(--light-solid-color-extra-card-background, #FFF); margin: 5px">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                    Kontrak
                    </label>
                </div>  
               
        </ul>
    </div>
    
</div>
</section>

<section class="ls-section">
    <div class="auto-container">
        <div class="showing-result container">
            <div class="text">300+ <strong></strong> Lowongan <strong></strong> Terserdia</div>
        </div>
            <div class="row">
                <div class="job-view">
                    <div class="company-block" >
                        <div class="inner-box" style="text-align: left; border-radius: 4px; margin-top: 10px; width: 561px; height: 299px; flex-shrink: 0;">
                            <div class="row">
                                <div class="center-text-icon">
                                    <figure class="image-vacancies"><img src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload"></figure>
                                    <div class="descrip-job">
                                        <h3  class="title">Human Resources</h3>
                                        <div class="text">PT Wings Surya</div>
                                        <div class="text">Jl. Gatot Soebroto No 577, Tangerang.</div>
                                    </div>
                                </div>
                                <p style="margin: 3px">8 hari lalu</p>
                                <figure><img src="{{ asset('front/assets/img/clock.png')}}" alt="admin.upload"></figure>
                            </div>
                            <div class="text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque iaculis lacinia erat in auctor. In venenatis nisl vel nisl laoreet, in feugiat nibh tincidunt. Donec fermentum interdum nunc, ac viverra tellus molestie in. Suspendisse blandit maximus mauris, vitae pharetra risus gravida eu. 
                            </div>
                            <div class="row custom-line">
                                
                                <div class="text m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M16.7 8C16.2928 6.84458 15.2239 6.05285 14 6H10C8.34315 6 7 7.34315 7 9C7 10.6569 8.34315 12 10 12H14C15.6569 12 17 13.3431 17 15C17 16.6569 15.6569 18 14 18H10C8.77606 17.9472 7.70722 17.1554 7.3 16" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12.75 3C12.75 2.58579 12.4142 2.25 12 2.25C11.5858 2.25 11.25 2.58579 11.25 3H12.75ZM11.25 6C11.25 6.41421 11.5858 6.75 12 6.75C12.4142 6.75 12.75 6.41421 12.75 6H11.25ZM12.75 18C12.75 17.5858 12.4142 17.25 12 17.25C11.5858 17.25 11.25 17.5858 11.25 18H12.75ZM11.25 21C11.25 21.4142 11.5858 21.75 12 21.75C12.4142 21.75 12.75 21.4142 12.75 21H11.25ZM11.25 3V6H12.75V3H11.25ZM11.25 18V21H12.75V18H11.25Z" fill="#23314B"/>
                                    </svg>
                                    <span>IDR 4.300.000 - 5.500.000</span>
                                </div>
                                <div class="text m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect x="3" y="7" width="18" height="13" rx="2" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 12V12.01" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3 13C8.66095 15.8526 15.339 15.8526 21 13" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>Full time</span>
                                </div>
                                <div class="text m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <circle cx="9" cy="7" r="4" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3 21V19C3 16.7909 4.79086 15 7 15H11C13.2091 15 15 16.7909 15 19V21" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16 3.12988C17.7699 3.58305 19.0078 5.17787 19.0078 7.00488C19.0078 8.83189 17.7699 10.4267 16 10.8799" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M21 20.9999V18.9999C20.9896 17.1845 19.7578 15.6037 18 15.1499" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>Full time</span>
                                </div>
                                
                            </div>
                        </div>
                        <div class="inner-box" style="text-align: left; border-radius: 4px; margin-top: 10px;  width: 561px; height: 299px; flex-shrink: 0;">
                            <div class="row">
                                <div class="center-text-icon">
                                    <figure class="image-vacancies"><img src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload"></figure>
                                    <div class="descrip-job">
                                        <h3  class="title">Human Resources</h3>
                                        <div class="text">PT Wings Surya</div>
                                        <div class="text">Jl. Gatot Soebroto No 577, Tangerang.</div>
                                    </div>
                                </div>
                                <p style="margin: 3px">8 hari lalu</p>
                                <figure><img src="{{ asset('front/assets/img/clock.png')}}" alt="admin.upload"></figure>
                            </div>
                            <div class="text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque iaculis lacinia erat in auctor. In venenatis nisl vel nisl laoreet, in feugiat nibh tincidunt. Donec fermentum interdum nunc, ac viverra tellus molestie in. Suspendisse blandit maximus mauris, vitae pharetra risus gravida eu. 
                            </div>
                            <div class="row custom-line">
                                
                                <div class="text m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M16.7 8C16.2928 6.84458 15.2239 6.05285 14 6H10C8.34315 6 7 7.34315 7 9C7 10.6569 8.34315 12 10 12H14C15.6569 12 17 13.3431 17 15C17 16.6569 15.6569 18 14 18H10C8.77606 17.9472 7.70722 17.1554 7.3 16" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12.75 3C12.75 2.58579 12.4142 2.25 12 2.25C11.5858 2.25 11.25 2.58579 11.25 3H12.75ZM11.25 6C11.25 6.41421 11.5858 6.75 12 6.75C12.4142 6.75 12.75 6.41421 12.75 6H11.25ZM12.75 18C12.75 17.5858 12.4142 17.25 12 17.25C11.5858 17.25 11.25 17.5858 11.25 18H12.75ZM11.25 21C11.25 21.4142 11.5858 21.75 12 21.75C12.4142 21.75 12.75 21.4142 12.75 21H11.25ZM11.25 3V6H12.75V3H11.25ZM11.25 18V21H12.75V18H11.25Z" fill="#23314B"/>
                                    </svg>
                                    <span>IDR 4.300.000 - 5.500.000</span>
                                </div>
                                <div class="text m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect x="3" y="7" width="18" height="13" rx="2" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 12V12.01" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3 13C8.66095 15.8526 15.339 15.8526 21 13" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>Full time</span>
                                </div>
                                <div class="text m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <circle cx="9" cy="7" r="4" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3 21V19C3 16.7909 4.79086 15 7 15H11C13.2091 15 15 16.7909 15 19V21" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16 3.12988C17.7699 3.58305 19.0078 5.17787 19.0078 7.00488C19.0078 8.83189 17.7699 10.4267 16 10.8799" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M21 20.9999V18.9999C20.9896 17.1845 19.7578 15.6037 18 15.1499" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>Full time</span>
                                </div>
                                
                            </div>
                        </div>
                        <div class="inner-box" style="text-align: left; border-radius: 4px; margin-top: 10px;  width: 561px; height: 299px; flex-shrink: 0;">
                            <div class="row">
                                <div class="center-text-icon">
                                    <figure class="image-vacancies"><img src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload"></figure>
                                    <div class="descrip-job">
                                        <h3  class="title">Human Resources</h3>
                                        <div class="text">PT Wings Surya</div>
                                        <div class="text">Jl. Gatot Soebroto No 577, Tangerang.</div>
                                    </div>
                                </div>
                                <p style="margin: 3px">8 hari lalu</p>
                                <figure><img src="{{ asset('front/assets/img/clock.png')}}" alt="admin.upload"></figure>
                            </div>
                            <div class="text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque iaculis lacinia erat in auctor. In venenatis nisl vel nisl laoreet, in feugiat nibh tincidunt. Donec fermentum interdum nunc, ac viverra tellus molestie in. Suspendisse blandit maximus mauris, vitae pharetra risus gravida eu. 
                            </div>
                            <div class="row custom-line">
                                
                                <div class="text m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M16.7 8C16.2928 6.84458 15.2239 6.05285 14 6H10C8.34315 6 7 7.34315 7 9C7 10.6569 8.34315 12 10 12H14C15.6569 12 17 13.3431 17 15C17 16.6569 15.6569 18 14 18H10C8.77606 17.9472 7.70722 17.1554 7.3 16" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12.75 3C12.75 2.58579 12.4142 2.25 12 2.25C11.5858 2.25 11.25 2.58579 11.25 3H12.75ZM11.25 6C11.25 6.41421 11.5858 6.75 12 6.75C12.4142 6.75 12.75 6.41421 12.75 6H11.25ZM12.75 18C12.75 17.5858 12.4142 17.25 12 17.25C11.5858 17.25 11.25 17.5858 11.25 18H12.75ZM11.25 21C11.25 21.4142 11.5858 21.75 12 21.75C12.4142 21.75 12.75 21.4142 12.75 21H11.25ZM11.25 3V6H12.75V3H11.25ZM11.25 18V21H12.75V18H11.25Z" fill="#23314B"/>
                                    </svg>
                                    <span>IDR 4.300.000 - 5.500.000</span>
                                </div>
                                <div class="text m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect x="3" y="7" width="18" height="13" rx="2" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 12V12.01" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3 13C8.66095 15.8526 15.339 15.8526 21 13" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>Full time</span>
                                </div>
                                <div class="text m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <circle cx="9" cy="7" r="4" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3 21V19C3 16.7909 4.79086 15 7 15H11C13.2091 15 15 16.7909 15 19V21" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16 3.12988C17.7699 3.58305 19.0078 5.17787 19.0078 7.00488C19.0078 8.83189 17.7699 10.4267 16 10.8799" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M21 20.9999V18.9999C20.9896 17.1845 19.7578 15.6037 18 15.1499" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>Full time</span>
                                </div>
                                
                            </div>
                        </div>
                        <div class="inner-box" style="text-align: left; border-radius: 4px; margin-top: 10px;  width: 561px; height: 299px; flex-shrink: 0;">
                            <div class="row">
                                <div class="center-text-icon">
                                    <figure class="image-vacancies"><img src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload"></figure>
                                    <div class="descrip-job">
                                        <h3  class="title">Human Resources</h3>
                                        <div class="text">PT Wings Surya</div>
                                        <div class="text">Jl. Gatot Soebroto No 577, Tangerang.</div>
                                    </div>
                                </div>
                                <p style="margin: 3px">8 hari lalu</p>
                                <figure><img src="{{ asset('front/assets/img/clock.png')}}" alt="admin.upload"></figure>
                            </div>
                            <div class="text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque iaculis lacinia erat in auctor. In venenatis nisl vel nisl laoreet, in feugiat nibh tincidunt. Donec fermentum interdum nunc, ac viverra tellus molestie in. Suspendisse blandit maximus mauris, vitae pharetra risus gravida eu. 
                            </div>
                            <div class="row custom-line">
                                
                                <div class="text m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M16.7 8C16.2928 6.84458 15.2239 6.05285 14 6H10C8.34315 6 7 7.34315 7 9C7 10.6569 8.34315 12 10 12H14C15.6569 12 17 13.3431 17 15C17 16.6569 15.6569 18 14 18H10C8.77606 17.9472 7.70722 17.1554 7.3 16" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12.75 3C12.75 2.58579 12.4142 2.25 12 2.25C11.5858 2.25 11.25 2.58579 11.25 3H12.75ZM11.25 6C11.25 6.41421 11.5858 6.75 12 6.75C12.4142 6.75 12.75 6.41421 12.75 6H11.25ZM12.75 18C12.75 17.5858 12.4142 17.25 12 17.25C11.5858 17.25 11.25 17.5858 11.25 18H12.75ZM11.25 21C11.25 21.4142 11.5858 21.75 12 21.75C12.4142 21.75 12.75 21.4142 12.75 21H11.25ZM11.25 3V6H12.75V3H11.25ZM11.25 18V21H12.75V18H11.25Z" fill="#23314B"/>
                                    </svg>
                                    <span>IDR 4.300.000 - 5.500.000</span>
                                </div>
                                <div class="text m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect x="3" y="7" width="18" height="13" rx="2" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 12V12.01" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3 13C8.66095 15.8526 15.339 15.8526 21 13" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>Full time</span>
                                </div>
                                <div class="text m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <circle cx="9" cy="7" r="4" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3 21V19C3 16.7909 4.79086 15 7 15H11C13.2091 15 15 16.7909 15 19V21" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16 3.12988C17.7699 3.58305 19.0078 5.17787 19.0078 7.00488C19.0078 8.83189 17.7699 10.4267 16 10.8799" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M21 20.9999V18.9999C20.9896 17.1845 19.7578 15.6037 18 15.1499" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>Full time</span>
                                </div>
                                
                            </div>
                        </div>
                        <div class="inner-box" style="text-align: left; border-radius: 4px; margin-top: 10px;  width: 561px; height: 299px; flex-shrink: 0;">
                            <div class="row">
                                <div class="center-text-icon">
                                    <figure class="image-vacancies"><img src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="admin.upload"></figure>
                                    <div class="descrip-job">
                                        <h3  class="title">Human Resources</h3>
                                        <div class="text">PT Wings Surya</div>
                                        <div class="text">Jl. Gatot Soebroto No 577, Tangerang.</div>
                                    </div>
                                </div>
                                <p style="margin: 3px">8 hari lalu</p>
                                <figure><img src="{{ asset('front/assets/img/clock.png')}}" alt="admin.upload"></figure>
                            </div>
                            <div class="text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque iaculis lacinia erat in auctor. In venenatis nisl vel nisl laoreet, in feugiat nibh tincidunt. Donec fermentum interdum nunc, ac viverra tellus molestie in. Suspendisse blandit maximus mauris, vitae pharetra risus gravida eu. 
                            </div>
                            <div class="row custom-line">
                                
                                <div class="text m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M16.7 8C16.2928 6.84458 15.2239 6.05285 14 6H10C8.34315 6 7 7.34315 7 9C7 10.6569 8.34315 12 10 12H14C15.6569 12 17 13.3431 17 15C17 16.6569 15.6569 18 14 18H10C8.77606 17.9472 7.70722 17.1554 7.3 16" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12.75 3C12.75 2.58579 12.4142 2.25 12 2.25C11.5858 2.25 11.25 2.58579 11.25 3H12.75ZM11.25 6C11.25 6.41421 11.5858 6.75 12 6.75C12.4142 6.75 12.75 6.41421 12.75 6H11.25ZM12.75 18C12.75 17.5858 12.4142 17.25 12 17.25C11.5858 17.25 11.25 17.5858 11.25 18H12.75ZM11.25 21C11.25 21.4142 11.5858 21.75 12 21.75C12.4142 21.75 12.75 21.4142 12.75 21H11.25ZM11.25 3V6H12.75V3H11.25ZM11.25 18V21H12.75V18H11.25Z" fill="#23314B"/>
                                    </svg>
                                    <span>IDR 4.300.000 - 5.500.000</span>
                                </div>
                                <div class="text m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect x="3" y="7" width="18" height="13" rx="2" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 12V12.01" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3 13C8.66095 15.8526 15.339 15.8526 21 13" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>Full time</span>
                                </div>
                                <div class="text m-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <circle cx="9" cy="7" r="4" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M3 21V19C3 16.7909 4.79086 15 7 15H11C13.2091 15 15 16.7909 15 19V21" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16 3.12988C17.7699 3.58305 19.0078 5.17787 19.0078 7.00488C19.0078 8.83189 17.7699 10.4267 16 10.8799" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M21 20.9999V18.9999C20.9896 17.1845 19.7578 15.6037 18 15.1499" stroke="#23314B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>Full time</span>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="company-block" >
                        <div class="inner-box" style="text-align: center; margin-top: 10px;  border-radius: 4px; width: 561px; height: 600px; flex-shrink: 0;">
                            <div>
                                <figure class="image-vacancies-not-found" style="border-radius: 0%;"><img style="border-radius: 0%;" src="{{ asset('front/assets/img/icon_tidak_ditemukan.png')}}" alt="admin.upload"></figure>
                                <h4>Belum Ada Lowongan terpilih</h4>
                                
                                <div class="text">Silahkan pilih lowongan yang tersedia untuk mendapatkan detail informasi</div>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<input type="hidden" id="request_url" value="{{json_encode(request()->all())}}">
@endsection