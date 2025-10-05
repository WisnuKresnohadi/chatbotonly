
@extends('layouts.front')

<style>
    .jobs-all a:hover,
    .jobs-all a:focus,
    .jobs-all a:visited {
        text-decoration: none;
        outline: none;
    }
</style>

@section('header-text')
    {{-- <h1 class="hidden-sm-down"><i class="icon-ribbon"></i> @lang('modules.front.homeHeader') </h1>
    <h4 class="hidden-sm-up"><i class="icon-ribbon"></i> @lang('modules.front.homeHeader') </h4>--}}
    <div class="" data-wow-delay="1000ms">
       
        <form action="{{url("/search")}}" method="GET">
            <div class="job-search-form wow fadeInUp " stPle="border-radius: 10px; border: 2px solid var(--primary-500-base, #4EA971); background: #FFF; height: 69px; width: 834px;;">
                <div class="row">
                
                <div class="form-group col-lg-3 col-md-12 col-sm-12">
                    <span class="icon flaticon-search-1"></span>
                    <input type="text" class="form-control autocomplete" name="job" autocomplete="off" placeholder="Job Vacancy" data-url="{{url('/fetch-jobs')}}"  value="{{request()->job}}">
                </div>
                
                <!-- Form Group - Locations -->
                <div class="form-group col-lg-3 col-md-12 col-sm-12 location">
                    <span class="icon flaticon-map-locator"></span>
                    <input type="text" class="form-control autocomplete" name="loc" autocomplete="off" placeholder="Locations" data-url="{{url('/fetch-locations')}}"  value="{{request()->loc}}">
                </div>
                
                <!-- Form Group - Job Type -->
                <div class="form-group col-lg-3 col-md-12 col-sm-12 briefcase">
                    <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="auto" height="auto" viewBox="0 0 24 24" fill="none"><rect x="3" y="7" width="18" height="13" rx="2" stroke="#4EA971" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7" stroke="#4EA971" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 12V12.01" stroke="#4EA971" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 13C8.66095 15.8526 15.339 15.8526 21 13" stroke="#4EA971" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                    <input type="text" class="form-control autocomplete" name="type" autocomplete="off" placeholder="Jobs Type" data-url="{{url('/fetch-briefcase')}}"  value="{{request()->job}}">
                </div>

            
                    
                    <!-- Form Group -->
                    {{-- <div class="form-group col-lg-3 col-md-12 col-sm-12 category">
                        <span class="icon flaticon-briefcase"></span>
                        <select class="chosen-select">
                            <option value="">All Categories</option>
                            <option value="44">Accounting / Finance</option>
                            <option value="106">Automotive Jobs</option>
                            <option value="46">Customer</option>
                            <option value="48">Design</option>
                            <option value="47">Development</option>
                            <option value="45">Health and Care</option>
                            <option value="105">Marketing</option>
                            <option value="107">Project Management</option>
                        </select>
                    </div> --}}

                    <!-- Form Group -->
                    <div class="form-group" style=" margin: 7px">
                        <button  class="btn-success btn-style-two">Find Jobs</button>
                    </div>
                </div>
            </div>
           
       
        </form>
    </div>
 @endsection


@section('foryou')
    @foreach($companies as $company) 
    <div class="row">

         <!-- Company-Block  -->
        <div class="company-block">
            <div class="inner-box" style="display: flex; width: 343px; height: 427px; padding: 40px 28px 41px 28px; flex-direction: column; justify-content: center; align-items: center; flex-shrink: 0;">
                <div>
                    <figure class="image" style="border-radius: 0%;"><img style="border-radius: 0%;" src="{{ asset("user-uploads/company-logo/".$company->logo) }}" alt=""></figure>
                    <h4 class="name">{{ ucwords($company->company_name) }}</h4>
                   
                    <div class="location"><i class="flaticon-map-locator"></i>{{ ucwords($company->address)}}</div>
                    <div class="button-container" >
                        <a onclick="goToSearch('<?php echo $company->company_name ?>')" class="btn btn-success text-white" style="margin-left : 20px; border-radius: 8px;">Lamar</a>
                        <a onclick="goToSearch('<?php echo $company->company_name ?>')" class="btn btn-outline-success" style="margin-left: 20px; border-radius: 8px;">Detail</a>
                        
                    </div>
                </div>
                  
            </div>
            
        </div>

        <!-- Company-Block  -->
        <div class="company-block">
            <div class="inner-box" style=" display: flex; width: 343px; height: 427px; padding: 40px 28px 41px 28px; flex-direction: column; justify-content: center; align-items: center; flex-shrink: 0;">
                <div>
                    <figure class="image" style="border-radius: 0%;"><img style="border-radius: 0%;" src="{{ asset("user-uploads/company-logo/".$company->logo) }}" alt=""></figure>
                    <h4 class="name">{{ ucwords($company->company_name) }}</h4>
                   
                    <div class="location"><i class="flaticon-map-locator"></i>{{ ucwords($company->address)}}</div>
                    <div class="button-container" >
                        <a onclick="goToSearch('<?php echo $company->company_name ?>')" class="btn btn-success text-white" style="margin-left : 20px; border-radius: 8px;">Lamar</a>
                        <a onclick="goToSearch('<?php echo $company->company_name ?>')" class="btn btn-outline-success" style="margin-left: 20px; border-radius: 8px;">Detail</a>
                        
                    </div>
                </div>
                    
            </div>
        </div>
        
         <!-- Company-Block  -->
        <div class="company-block">
            <div class="inner-box" style="display: flex; width: 343px; height: 427px; padding: 40px 28px 41px 28px; flex-direction: column; justify-content: center; align-items: center; flex-shrink: 0;">
                <div>
                    <figure class="image" style="border-radius: 0%;"><img style="border-radius: 0%;" src="{{ asset("user-uploads/company-logo/".$company->logo) }}" alt=""></figure>
                    <h4 class="name">{{ ucwords($company->company_name) }}</h4>
                   
                    <div class="location"><i class="flaticon-map-locator"></i>{{ ucwords($company->address)}}</div>
                    <div class="button-container" >
                        <a onclick="goToSearch('<?php echo $company->company_name ?>')" class="btn btn-success text-white" style="margin-left : 20px; border-radius: 8px;">Lamar</a>
                        <a onclick="goToSearch('<?php echo $company->company_name ?>')" class="btn btn-outline-success" style="margin-left: 20px; border-radius: 8px;">Detail</a>
                        
                    </div>
                </div>
                 
            </div>
        </div>

         <!-- Company-Block  -->
        <div class="company-block">
            <div class="inner-box" style="display: flex; width: 343px; height: 427px; padding: 40px 28px 41px 28px; flex-direction: column; justify-content: center; align-items: center; flex-shrink: 0;">
                <div>
                    <figure class="image" style="border-radius: 0%;"><img style="border-radius: 0%;" src="{{ asset("user-uploads/company-logo/".$company->logo) }}" alt=""></figure>
                    <h4 class="name">{{ ucwords($company->company_name) }}</h4>
                   
                    <div class="location"><i class="flaticon-map-locator"></i>{{ ucwords($company->address)}}</div>
                    <div class="button-container" >
                        <a onclick="goToSearch('<?php echo $company->company_name ?>')" class="btn btn-success text-white" style="margin-left : 20px; border-radius: 8px;">Lamar</a>
                        <a onclick="goToSearch('<?php echo $company->company_name ?>')" class="btn btn-outline-success" style="margin-left: 20px; border-radius: 8px;">Detail</a>
                        
                    </div>
                </div>
                  
            </div>
        </div>

         <!-- Company-Block  -->
        <div class="company-block">
            <div class="inner-box" style="display: flex; width: 343px; height: 427px; padding: 40px 28px 41px 28px; flex-direction: column; justify-content: center; align-items: center; flex-shrink: 0;">
                <div>
                    <figure class="image" style="border-radius: 0%;"><img style="border-radius: 0%;" src="{{ asset("user-uploads/company-logo/".$company->logo) }}" alt=""></figure>
                    <h4 class="name">{{ ucwords($company->company_name) }}</h4>
                   
                    <div class="location"><i class="flaticon-map-locator"></i>{{ ucwords($company->address)}}</div>
                    <div class="button-container" >
                        <a onclick="goToSearch('<?php echo $company->company_name ?>')" class="btn btn-success text-white" style="margin-left : 20px; border-radius: 8px;">Lamar</a>
                        <a onclick="goToSearch('<?php echo $company->company_name ?>')" class="btn btn-outline-success" style="margin-left: 20px; border-radius: 8px;">Detail</a>
                        
                    </div>
                </div>
                   
            </div>
        </div>

         <!-- Company-Block  -->
        <div class="company-block">
            <div class="inner-box" style="display: flex; width: 343px; height: 427px; padding: 40px 28px 41px 28px; flex-direction: column; justify-content: center; align-items: center; flex-shrink: 0;">
                <div>
                    <figure class="image" style="border-radius: 0%;"><img style="border-radius: 0%;" src="{{ asset("user-uploads/company-logo/".$company->logo) }}" alt=""></figure>
                    <h4 class="name">{{ ucwords($company->company_name) }}</h4>
                   
                    <div class="location"><i class="flaticon-map-locator"></i>{{ ucwords($company->address)}}</div>
                    <div class="button-container" >
                        <a onclick="goToSearch('<?php echo $company->company_name ?>')" class="btn btn-success text-white" style="margin-left : 20px; border-radius: 8px;">Lamar</a>
                        <a onclick="goToSearch('<?php echo $company->company_name ?>')" class="btn btn-outline-success" style="margin-left: 20px; border-radius: 8px;">Detail</a>
                        
                    </div>
                </div>
                  
            </div>
            
        </div> 
    </div>

    <div class="text-center">
        <a onclick="goToSearch('<?php echo $company->company_name ?>')" class="" style="margin-top: 20px">lihat Perusahaan Lainya</a> 
    </div>

    @endforeach
@endsection

@section('partners')
    @foreach($companies as $company) 
        <div class="company-block">
            <div class="inner-box">
                <figure class="image" style="border-radius: 0%;"><img style="border-radius: 0%;" src="{{ asset("user-uploads/company-logo/".$company->logo) }}" alt=""></figure>
                <h4 class="name">{{ ucwords($company->company_name) }}</h4>
                <div class="location"><i class=""></i>{{ ucwords($company->address)}}</div>
                <a class="btn btn-outline-success me-2 ml-2 " onclick="goToSearch('<?php echo $company->company_name ?>')" type="button" class="">Lihat Perusahaan</a>           
            </div>
        </div>
    @endforeach
@endsection


@push('footer-script')
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>
    <script>
        $('.autocomplete').autoComplete({minLength:2});
    </script>

    <script>
        function goToSearch(company){	
            if(company != null){
                window.location.href = "/search?company=" + company;
            }
            else{
                window.location.href = "/search";
            }
        }
    </script>
@endpush