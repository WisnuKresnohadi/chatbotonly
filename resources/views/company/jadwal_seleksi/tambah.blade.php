@extends('partials_admin.template')

@section('meta_header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_style')
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
<!-- date picker -->
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/pickr/pickr-themes.css') }}" />
<!-- <style>
    .swal2-icon {
        border-color: transparent !important;
    }

    .swal2-title {
        font-size: 20px !important;
        text-align: center !important;
        margin-top: 0px !important;
        margin-bottom: 0px !important;
    }

    .swal2-modal.swal2-popup .swal2-title {
        max-width: 100% !important;
    }

    .swal2-html-container {
        font-size: 16px !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: #4EA971;
    }

    .bootstrap-select .dropdown-menu.inner a[aria-selected=true] {
        background: #4EA971 !important;
    }

    .dropdown-toggle:after {
        display: none;
    }

    .dropdown-toggle::before {
        display: inline-block !important;
        margin-right: 0.5em !important;
        vertical-align: middle !important;
        content: "" !important;
        margin-top: -0.28em !important;
        width: 0.42em !important;
        height: 0.42em !important;
        border: 1px solid !important;
        border-top: 0 !important;
        border-left: 0 !important;
        transform: rotate(45deg) !important;
    }

    .bootstrap-select .dropdown-menu a:not([href]):not(.active):not(:active):not(.selected):hover {
        color: #4EA971 !important;
    }
</style> -->
@endsection

@section('main')
<div class="row">
    <div class="col-md-9 col-12">
        <button class="btn btn-outline-success my-2 waves-effect p-3 mb-4" type="button" id="back" style="width: 15%; height:12%;">
            <i class="bi bi-arrow-left text-success" style="font-size: medium;"> Kembali </i>
        </button>
        <div class="col-md-9 col-12">
            <h4 class="fw-bold"><span class="text-muted fw-light">Jadwal Seleksi / </span>Posisi
                {{ $lowongan->intern_position }} - Periode 21
                April
                -
                11 Mei 2023
            </h4>
        </div>
    </div>
    <div class="col-md-3 col-12 mb-3 d-flex justify-content-end align-items-center">
        {{-- <input type="text" class="form-control" id="flatpickr-range-filter" />
            <div class="invalid-feedback"></div> --}}
        <div class="ps-3">
            <button class="btn btn-success waves-effect" type="button" data-bs-toggle="offcanvas" data-bs-target="#modalSlide"><i class="tf-icons ti ti-filter"></i></button>
        </div>
    </div>
    <div class="nav-align-top">
        @can('only.mitra')
        <div class=" text-end">
            <div class="col-md-12 d-flex justify-content-end align-items-center mt-2 mb-3">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal">
                    <div class="d-flex align-items-center">
                        <i class="tf-icons ti ti-plus me-2"></i>
                        <span class="mt-1">Buat Jadwal Seleksi</span>
                    </div>
                </button>
            </div>
        </div>
        @endcan
        <div class="row">
            <div class="col-6">
                <ul class="nav nav-pills mb-3 " role="tablist">
                    @if ($lowongan->tahapan_seleksi == '1')
                    <li class="nav-item" style="font-size: small;">
                        <button type="button" class="nav-link active showSingle" target="1" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-tahap1" aria-controls="navs-pills-justified-tahap1" aria-selected="false" style="padding: 8px 9px;">
                            <i class="tf-icons ti ti-device-desktop-analytics ti-xs me-1"></i> Seleksi Tahap 1
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 ms-1" style="background-color: #DCEEE3; color: #4EA971;"></span>
                        </button>
                    </li>
                    @elseif ($lowongan->tahapan_seleksi == '2')
                    <li class="nav-item" style="font-size: small;">
                        <button type="button" class="nav-link active showSingle" target="1" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-tahap1" aria-controls="navs-pills-justified-tahap1" aria-selected="false" style="padding: 8px 9px;">
                            <i class="tf-icons ti ti-device-desktop-analytics ti-xs me-1"></i> Seleksi Tahap 1
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 ms-1" style="background-color: #DCEEE3; color: #4EA971;"></span>
                        </button>
                    </li>
                    <li class="nav-item" style="font-size: small;">
                        <button type="button" class="nav-link showSingle" target="2" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-tahap2" aria-controls="navs-pills-justified-tahap2" aria-selected="false" style="padding: 8px 9px;">
                            <i class="tf-icons ti ti-device-desktop-analytics ti-xs me-1"></i> Seleksi Tahap 2
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 ms-1" style="background-color: #DCEEE3; color: #4EA971;"></span>
                        </button>
                    </li>
                    @else
                    <li class="nav-item" style="font-size: small;">
                        <button type="button" class="nav-link active showSingle" target="1" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-tahap1" aria-controls="navs-pills-justified-tahap1" aria-selected="false" style="padding: 8px 9px;">
                            <i class="tf-icons ti ti-device-desktop-analytics ti-xs me-1"></i> Seleksi Tahap 1
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 ms-1" style="background-color: #DCEEE3; color: #4EA971;"></span>
                        </button>
                    </li>
                    <li class="nav-item" style="font-size: small;">
                        <button type="button" class="nav-link showSingle" target="2" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-tahap2" aria-controls="navs-pills-justified-tahap2" aria-selected="false" style="padding: 8px 9px;">
                            <i class="tf-icons ti ti-device-desktop-analytics ti-xs me-1"></i> Seleksi Tahap 2
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 ms-1" style="background-color: #DCEEE3; color: #4EA971;"></span>
                        </button>
                    </li>
                    <li class="nav-item" style="font-size: small;">
                        <button type="button" class="nav-link showSingle" target="3" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-tahap3" aria-controls="navs-pills-justified-tahap3" aria-selected="false" style="padding: 8px 9px;">
                            <i class="tf-icons ti ti-device-desktop-analytics ti-xs me-1"></i> Seleksi Tahap 3
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 ms-1" style="background-color: #DCEEE3; color: #4EA971;"></span>
                        </button>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="tab-content p-0">
    @foreach (['tahap1', 'tahap2', 'tahap3'] as $tableId)
    <div class="tab-pane fade show {{ $loop->iteration == 1 ? 'active' : '' }}" id="navs-pills-justified-{{ $tableId }}" role="tabpanel">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table table-jadwal-seleksi" id="{{ $tableId }}">
                    <thead>
                        <tr>
                            <th style="max-width:90px;">NOMOR</th>
                            <th style="min-width:110px;">NAMA</th>
                            <th style="min-width:120px;">TANGGAL PELAKSANAAN</th>
                            <th style="min-width:100px;">STATUS</th>
                            <th style="min-width:100px;">AKSI</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>
@include('company.jadwal_seleksi.modal')
@endsection

@section('page_script')
<script src="{{ asset('app-assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
<script src="{{ asset('app-assets/js/forms-extras.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>

<script>
    $("#modalTambahJadwal").on("hide.bs.modal", function() {
        $('#modalTambahJadwal form')[0].reset();
        $('#modalTambahJadwal form #tahapan_seleksi').val('').trigger('change');
        $('#modalTambahJadwal form #subjek').val('').trigger('change');
        $('#modalTambahJadwal form #flatpickr-range').flatpickr({
            dateFormat: "d M Y",
            // disableMobile: "true",
            mode: "range",
            defaultDate: 'null'
        });
        $('#modalTambahJadwal form').attr('action', "{{ url('jadwal-seleksi/lanjutan/store') }}");
        $('.invalid-feedback').removeClass('d-block');
        $('.form-control').removeClass('is-invalid');
    });

    $('.table').each(function() {
        let idElement = $(this).attr('id');
        let idLowongan = '{{ $pendaftaran->id_lowongan ?? 0 }}';
        // console.log(idElement);
        let url = `{{ url('jadwal-seleksi/lanjutan/show/') }}/${idLowongan}?type=` + idElement;
        if ($(this).attr('id') == null) return;

        $(this).DataTable({
            ajax: url,
            serverSide: false,
            processing: true,
            deferRender: true,
            type: 'GET',
            columns: [{
                    data: "DT_RowIndex"
                },
                {
                    data: null,
                    name: "tahap",
                    render: function(data, type, row) {
                        if (data) {
                            return data.pendaftar.mahasiswa.namamhs + '<br>' +
                                (
                                    data.pendaftar.mahasiswa.nim);
                        }
                        return '-';
                    }
                },
                {
                    data: "start_date",
                    name: "mulai"
                },
                {
                    data: "status_seleksi",
                    name: "seleksi"
                },
                {
                    data: "action"
                }
            ]
        });
    })

    jQuery(function() {
        jQuery('.showSingle').click(function() {
            let idElement = $(this).attr('target');

            jQuery('.targetDiv').hide('.cnt');
            jQuery("#div" + idElement).slideToggle();

            // console.log(idElement);
        });
    });

    $('.display').DataTable({
        responsive: true
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
    });

    function progress(e) {
        var id = e.attr('data-id');
        var value = e.val();
        var type = e.attr('data-type');
        var tahap = e.attr('data-tahap');
        // console.log(id);
        $.ajax({
            method: "POST",
            data: {
                'id': id,
                'value': value,
                'type': type,
                'tahap': tahap
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/jadwal-seleksi/lanjutan/update/' + id,
            success: function(data) {
                if (data.error) {
                    Swal.fire({
                        type: "error",
                        title: 'Oops...',
                        text: data.message,
                        confirmButtonClass: 'btn btn-success',
                    })
                } else {
                    setTimeout(function() {
                        $('.table').DataTable().ajax.reload();
                    }, 1000);
                    // location.reload();
                }
            }
        });
    }

    document.getElementById("back").addEventListener("click", () => {
        history.back();
    });
</script>


<script src="{{ asset('app-assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('app-assets/js/extended-ui-sweetalert2.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/pickr/pickr.js') }}"></script>
<script src="{{ asset('app-assets/js/forms-pickers.js') }}"></script>
<script src="{{ asset('app-assets/js/forms-selects.js') }}"></script>
@endsection