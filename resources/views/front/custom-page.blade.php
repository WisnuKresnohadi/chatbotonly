@extends('layouts.front')

@section('header-text')
    <button type="button" class="btn btn-light px-5" style="font-size: 32px;">{{ $pageTitle }}</button>

@endsection

@push('style')
<style>
    .header {
        padding: 43px 100px !important;
    }
    .min-height-section{
        min-height: 400px;
    }
</style>
@endpush

@section('content')
    <!--
    |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
    | Working at TheThemeio
    |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
    !-->
    <section class="section bg-gray py-5 mb-5 min-height-section">
        <div class="container">
            <div class="row gap-y align-items-center">
                <div class="col-12">
                    <h3>@if(!is_null($customPage->name)) {{ $customPage->name }}  @endif</h3>
                    <p>@if(!is_null($customPage->description)) {!! $customPage->description !!}  @endif</p>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('foryou')
    @foreach($companies as $company) 
        <div class="company-block">
            <div class="inner-box">
                <figure class="image"><img src="{{ asset("user-uploads/company-logo/".$company->logo) }}" alt=""></figure>
                <h4 class="name">{{ ucwords($company->company_name) }}</h4>
                <div class="location"><i class="flaticon-map-locator"></i>{{ ucwords($company->address)}}</div>
                <a onclick="goToSearch('<?php echo $company->company_name ?>')" class="theme-btn btn-style-three">Available Jobs</a>
            </div>
        </div>
    @endforeach
@endsection