@extends('layouts.front_layout')
<!-- Banner Section-->
@section('content-main')
<title>Setup Profile</title>
<span class="header-span"></span>

<!--CheckOut Page-->
<section class="py-4">
    <div class="my-4 mx-5">
        <div class="row">
            <div class="column mr-lg-5 col-lg-4 col-md-12 col-sm-12">
                <!--Order Box-->
                <aside class="sidebar">
                    <div class="sidebar-widget p-4 d-flex align-content-center justify-content-center">
                        <div class="row w-100">
                            <div class="row w-100 mt-3">
                                <div class="col-lg-4 col-md-2 pt-2 d-flex align-content-center justify-content-center">
                                <span class="box-icon bg-primary"><i class="material-symbols-outlined" style="font-size: 30px;">check</i></span>
                                </div>
                                <div class="col-lg-8 col-md-10 d-flex align-content-center justify-content-center">
                                    <div class="row d-flex align-content-center h-100 p-1">
                                        <p class="text-muted col-12 mb-0" style="font-size: 14px;">Step 1</p>
                                        <label class="col-12 mb-0 text-primary" style="font-weight: 600; font-size: 18px;">Create Your Account</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row w-100 mt-3">
                                <div class="col-lg-4 col-md-2 pt-2 d-flex align-content-center justify-content-center">
                                <span class="box-icon bg-primary"><i class="material-symbols-outlined" style="font-size: 26px;">@if($user->profile) check @else file_copy @endif</i></span>
                                </div>
                                <div class="col-lg-8 col-md-10 d-flex align-content-center justify-content-center">
                                    <div class="row d-flex align-content-center h-100 p-1">
                                        <p class="text-muted col-12 mb-0" style="font-size: 14px;">Step 2</p>
                                        <label class="col-12 mb-0 @if($user->profile) text-primary @endif" style="font-weight: 600; font-size: 18px;">Complete Your Profile</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row w-100 my-3">
                                <div class="col-lg-4 col-md-2 pt-2 d-flex align-content-center justify-content-center">
                                <span class="box-icon @if($user->profile) bg-primary @else bg-white text-dark @endif"><i class="material-symbols-outlined @if(!$user->profile) text-muted @endif" style="font-size: 30px;">screen_search_desktop</i></span>
                                </div>
                                <div class="col-lg-8 col-md-10 d-flex align-content-center justify-content-center">
                                    <div class="row d-flex align-content-center h-100 p-1">
                                        <p class="text-muted col-12 mb-0" style="font-size: 14px;">Step 3</p>
                                        <label class="col-12 mb-0 @if(!$user->profile) text-muted @endif" style="font-weight: 600; font-size: 18px;">Find Your Dream Job</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
            <div class="column col-lg-7 col-md-12 col-sm-12">
                @if(!$user->profile)
                @include('sections.profile.setup')
                @else
                <div class="w-100 d-flex align-content-center justify-content-center">
                    <div>
                        <div class="d-flex align-content-center justify-content-center">
                            <img style="height: 400px; width: auto;" src="{{ asset('front/assets/img/done-1.png')}}" alt="">
                        </div>
                        <div class="mt-4 d-flex align-content-center justify-content-center">
                            <h5 class="text-primary" style="font-weight: 600;">Registration Completed!</h5>
                        </div>
                        <div class="mt-2 text-center">
                            <label class="p-0">We are now ready to help you find your dream job and career.<br>Anywhere, everywhere.</label>
                        </div>
                        <div class="d-flex align-content-center justify-content-center div-button">
                            <button class="btn btn-primary button-finish">Continue Applying</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!--End CheckOut Page-->
<script src="{{ asset('front/assets/landing/js/jquery.js') }}"></script> 
<script type="text/javascript">
    $(document).ready(function (e) {
        var goHome = '<?php 
            $previousUrl = url(Illuminate\Support\Facades\Session::get('previousUrl'));
            if($previousUrl && $previousUrl != url('/') && $previousUrl != route('profile.setup')){
                echo 'url';
            }
            else{
                echo 'home';
            }
        ?>';
        if(goHome == 'home'){
            $('.button-finish').remove();
            var html = '<button class="btn btn-primary button-finish">Explore Jobs</button>';
            $('.div-button').append(html);
            $('.button-finish').click(function () {
                window.location.href = '<?php 
                    $previousUrl = url(Illuminate\Support\Facades\Session::get('previousUrl'));
                    if(! $previousUrl){
                        $previousUrl = url('search');
                    }
                    else if($previousUrl == url('/') || $previousUrl == route('profile.setup') || $previousUrl == route('profile.index')){
                        $previousUrl = url('search');
                    }
                    echo $previousUrl;
                ?>';
            });
        }
    });
    $('.button-finish').click(function () {
        window.location.href = '<?php 
            $previousUrl = url(Illuminate\Support\Facades\Session::get('previousUrl'));
            if(! $previousUrl){
                $previousUrl = url('search');
            }
            else if($previousUrl == url('/') || $previousUrl == route('profile.setup') || $previousUrl == route('profile.index')){
                $previousUrl = url('search');
            }
            echo $previousUrl;
        ?>';
    });
</script>

@endsection