@extends('layouts.app') 
@push('head-script')
<link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css"> 
@endpush 
@permission('manage_master_data') 
@section('create-button')
<a href="{{ route('admin.jobs.create') }}" class="btn btn-dark btn-sm m-l-15"><i class="fa fa-plus-circle"></i> @lang('app.createNew')</a>
@endsection
@endpermission 
@section('content')
@php
$pageTitle = $company->company_name."'s Vacancies";
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
                <span class="float-sm-right">@yield('create-button')</span>
                <ol class="breadcrumb float-sm-right mr-2 mt-xs-2">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="icon-home text-primary"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.company.index') }}">Companies</a></li>
                    <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<div class="row d-flex align-items-center justify-content-center">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box info-box-custom">
            <div class="info-box-header">
                <span class="info-box-icon bg-primary"><i class="material-symbols-outlined" style="font-size: 22px;">draft</i></span>
            </div>
            <div class="d-flex align-items-center">
                <div class="info-box-content pb-0">
                    <span class="info-box-text">Total Vacancies</span>
                    <span class="info-box-number" style="font-size: 18px;">{{ count($company->jobs) }}</span>
                </div>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box info-box-custom">
            <div class="info-box-header">
                <span class="info-box-icon bg-primary"><i class="material-symbols-outlined" style="font-size: 22px;">search</i></span>
            </div>
            <div class="d-flex align-items-center">
                <div class="info-box-content pb-0">
                    <span class="info-box-text">Total Applicants</span>
                    <span class="info-box-number" style="font-size: 18px;">{{ count($company->job_applications) }}</span>
                </div>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table">
                        <thead>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 @push('footer-script')
<script src="//cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

<script>
    var table = $('#myTable').dataTable({
        responsive: true,
        // processing: true,
        serverSide: true,
        ajax: "{!! route('admin.company.dataJobs', $company->id) !!}",
        language: languageOptions(),
        "fnDrawCallback": function( oSettings ) {
            $("body").tooltip({
                selector: '[data-toggle="tooltip"]'
            });
        },
        columns: [
            { data: 'title', name: 'title', searchable: true, visible: false },
            { data: 'category_name', name: 'category_name', searchable: true, visible: false },
            { data: 'status', name: 'status', searchable: true, visible: false },
            { data: 'jobs', name: 'jobs' },
        ]
    });

    new $.fn.dataTable.FixedHeader( table );
</script>

@endpush