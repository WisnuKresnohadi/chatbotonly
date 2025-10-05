@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush

@php
$pageTitle = "Candidate Database";
@endphp

@section('content')
    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2 d-flex align-items-center">
                <div class="col-md-5">
                    <h1 class="mb-xs-2">{{ $pageTitle }}</h1>
                </div>
                <div class="col-md-7">
                    <ol class="breadcrumb float-sm-right mr-2 mt-xs-2">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="icon-home text-primary"></i></a></li>
                        <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('app.name')</th>
                                <th>City</th>
                                <th>Skills</th>
                                <th>Experience</th>
                                <th>@lang('app.action')</th>
                            </tr>
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
            ajax: '{!! route("admin.candidate.data") !!}',
            language: languageOptions(),
            "fnDrawCallback": function (oSettings) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [
                {data: 'DT_Row_Index'},
                {data: 'name', name: 'name'},
                {data: 'location', name: 'location'},
                {data: 'skills', name: 'skills'},
                {data: 'experience', name: 'experience'},
                {data: 'action', name: 'action'}
            ]
        });
        new $.fn.dataTable.FixedHeader(table);

    </script>
@endpush