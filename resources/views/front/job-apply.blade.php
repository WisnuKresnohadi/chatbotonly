@extends('layouts.front_apply')

@section('content')
<div class="job-detail-outer">
        <div class="my-4 mx-5">
            <div class="row">
                <div class="column mr-lg-5 col-lg-4 col-md-12 col-sm-12">
                    <!--Order Box-->
                    <aside class="sidebar">
                        <div class="sidebar-widget">
                            <!-- Job Overview -->
                            <h4 class="widget-title">Job Overview</h4>
                            <div class="widget-content">
                                <ul class="job-overview">
                                    <li>
                                        <i class="icon icon-calendar"></i>
                                        <h5>Date Posted:</h5>
                                        <span>{{ ucwords(date_format($job->start_date,"F, d Y")) }}</span>
                                    </li>
                                    <li>
                                        <i class="icon icon-expiry"></i>
                                        <h5>Expiration date:</h5>
                                        <span>{{ ucwords(date_format($job->end_date,"F, d Y")) }}</span>
                                    </li>
                                    <li>
                                        <i class="icon icon-location"></i>
                                        <h5>Location:</h5>
                                        <span>{{ ucwords($job->location->location)}}</span>
                                    </li>
                                    <li>
                                        <i class="icon icon-user-2"></i>
                                        <h5>Required:</h5>
                                        <span>{{ ucwords($job->total_positions) }}</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Map Widget -->
                            {{-- <h4 class="widget-title">Job Location</h4>
                            <div class="widget-content">
                                <div class="map-outer">
                                    <div class="map-canvas"
                                        data-zoom="12"
                                        data-lat="-37.817085"
                                        data-lng="144.955631"
                                        data-type="roadmap"
                                        data-hue="#ffc400"
                                        data-title="Envato"
                                        data-icon-path="images/resource/map-marker.png"
                                        data-content="Melbourne VIC 3000, Australia<br><a href='mailto:info@youremail.com'>info@youremail.com</a>">
                                    </div>
                                </div>
                            </div> --}}

                            <!-- Job Skills -->
                            {{-- <h4 class="widget-title">Job Skills</h4>
                            <div class="widget-content">
                                <ul class="job-skills">
                                    <li><a href="#">{{ ucwords($job->skill) }}</a></li>
                                    <li><a href="#">administrative</a></li>
                                    <li><a href="#">android</a></li>
                                    <li><a href="#">wordpress</a></li>
                                    <li><a href="#">design</a></li>
                                    <li><a href="#">react</a></li>
                                </ul>
                            </div> --}}
                        </div>

                        <div class="sidebar-widget company-widget">
                            <div class="widget-content">
                                <div class="company-title">
                                    <div class="company-logo"><img src="{{ asset("user-uploads/company-logo/".$job->company->logo) }}" alt=""></div>
                                    <h5 class="company-name">{{ ucwords($job->company->company_name) }}</h5>
                                    {{-- <a href="{{ ucwords($job->company->website)}}" class="profile-link">View company profile</a> --}}
                                </div>

                                <ul class="company-info">
                                    <li>Primary industry: <span>{{ ucwords($job->category->name) }}</span></li>
                                    {{-- <li>Company size: <span>501-1,000</span></li>
                                    <li>Founded in: <span>2011</span></li> --}}
                                    <li>Phone: <span>{{ ucwords($job->company->company_phone)}}</span></li>
                                    <li>Email: <span>{{ ucwords($job->company->company_email)}}</span></li>
                                    <li>Location: <span>{{ ucwords($job->company->address)}}</span></li>
                                    <li>Social media: 
                                        <div class="social-links">
                                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                                            <a href="#"><i class="fab fa-twitter"></i></a>
                                            <a href="#"><i class="fab fa-instagram"></i></a>
                                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                        </div>
                                    </li>
                                </ul>

                                <div class="btn-box"><a href="{{ ucwords($job->company->website)}}" class="theme-btn btn-style-three">{{ ucwords($job->company->website)}}</a></div>
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="column col-lg-7 col-md-12 col-sm-12">
                    @if(isset($job_application_id))
                    <div class="sidebar-widget company-widget" style="display: flex; align-items: center; justify-content: center;">
                        <h5>your application has been submitted!</h5>
                        <div class="mx-4" style="display: flex; align-items: center; justify-content: center;">
                            <a href="{{ url('search') }}" style="display: flex; align-items: center; justify-content: center;">
                                <button type="button" class="btn" style="background-color: #EFEFEF;">
                                <i class="material-symbols-outlined" style="font-size: 14px;">arrow_back</i>&ensp;Explore Jobs
                                </button>
                            </a>
                        </div>
                    </div>
                    @else
                    @include('sections.profile.setup')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection