@extends('layouts.app') 
@push('head-script')
<link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css"> 
@endpush 
@section('content')
@php
$pageTitle = "Candidate Details";
@endphp

<style>
    .table >thead {
        display: none;
    }

    .table > tbody > tr > td,
    .table > thead > tr > th {
        border: 0 !important
    }

    .card a {
        text-decoration: none;
        color: #000;
    }
</style>

<section class="content-header">
    <div class="container-fluid">

        <div class="row mb-2 d-flex align-items-center">
            <div class="col-md-5">
                <h1 class="mb-xs-2">{{ $pageTitle }}</h1>
            </div>
            <div class="col-md-7">
                <ol class="breadcrumb float-sm-right mr-2 mt-xs-2">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="icon-home text-primary"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.candidate.index') }}">Candidate Database</a></li>
                    <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

@include('sections.profile.details')

@endsection