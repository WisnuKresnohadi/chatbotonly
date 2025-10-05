@extends('layouts.front_layout')
<!-- Banner Section-->
@section('content-main')
<title>My Profile</title>
<span class="header-span"></span>

<!--CheckOut Page-->
<section class="py-4">
    <div class="my-4 mx-5">
        <div class="row">
            <div class="column mr-lg-5 col-lg-4 col-md-12 col-sm-12 mb-4">
                <!--Order Box-->
                <h4 class="title text-primary">My Profile</h4>
                <div class="p-3 d-flex align-content-center justify-content-center">
                    <div class="row w-100">
                        <a href="{{ url('profile') }}" class="row w-100 p-1 py-2 {{(request()->segment(2) == null) ? 'text-primary' : 'text-dark' }}">
                            <div class="d-flex align-content-center justify-content-center">
                                <span class="d-flex align-content-center justify-content-center"><i class="material-symbols-outlined mt-1 mr-3" style="font-size: 20px;">person</i>Personal Information</span>
                            </div>
                        </a>
                        <a href="{{ url('profile/information') }}" class="row w-100 p-1 py-2 {{(request()->segment(2) == 'information') ? 'text-primary' : 'text-dark' }}">
                            <div class="d-flex align-content-center justify-content-center">
                                <span class="d-flex align-content-center justify-content-center"><i class="material-symbols-outlined mt-1 mr-3" style="font-size: 20px;">list</i>Additional Information</span>
                            </div>
                        </a>
                        <a href="{{ url('profile/educations') }}" class="row w-100 p-1 py-2 {{(request()->segment(2) == 'educations') ? 'text-primary' : 'text-dark' }}">
                            <div class="d-flex align-content-center justify-content-center">
                                <span class="d-flex align-content-center justify-content-center"><i class="material-symbols-outlined mt-1 mr-3" style="font-size: 20px;">school</i>Educations</span>
                            </div>
                        </a>
                        <a href="{{ url('profile/skills') }}" class="row w-100 p-1 py-2 {{(request()->segment(2) == 'skills') ? 'text-primary' : 'text-dark' }}">
                            <div class="d-flex align-content-center justify-content-center">
                                <span class="d-flex align-content-center justify-content-center"><i class="material-symbols-outlined mt-1 mr-3" style="font-size: 20px;">business_center</i>Experience & Skills</span>
                            </div>
                        </a>
                        <a href="{{ url('profile/languages') }}" class="row w-100 p-1 py-2 {{(request()->segment(2) == 'languages') ? 'text-primary' : 'text-dark' }}">
                            <div class="d-flex align-content-center justify-content-center">
                                <span class="d-flex align-content-center justify-content-center"><i class="material-symbols-outlined mt-1 mr-3" style="font-size: 20px;">speaker_notes</i>Languages</span>
                            </div>
                        </a>
                        <a href="{{ url('profile/portfolio') }}" class="row w-100 p-1 py-2 {{(request()->segment(2) == 'portfolio') ? 'text-primary' : 'text-dark' }}">
                            <div class="d-flex align-content-center justify-content-center">
                                <span class="d-flex align-content-center justify-content-center"><i class="material-symbols-outlined mt-1 mr-3" style="font-size: 20px;">attach_file</i>CV, Portfolio & Social Media</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="column col-lg-7 col-md-12 col-sm-12">
                @if(request()->segment(2) == 'information')
                @include('sections.profile.information')
                @elseif(request()->segment(2) == 'educations')
                @include('sections.profile.educations')
                @elseif(request()->segment(2) == 'skills')
                @include('sections.profile.skills')
                @elseif(request()->segment(2) == 'languages')
                @include('sections.profile.languages')
                @elseif(request()->segment(2) == 'portfolio')
                @include('sections.profile.portfolio')
                @else
                @include('sections.profile.personal')
                @endif
            </div>
        </div>
    </div>
</section>
<!--End CheckOut Page-->

@endsection