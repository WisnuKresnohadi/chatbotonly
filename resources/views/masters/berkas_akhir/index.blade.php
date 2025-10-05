@extends('partials.vertical_menu')
@section('meta_header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_style')
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/pickr/pickr-themes.css') }}" />
<link rel="stylesheet" href="{{ url('app-assets/vendor/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
<style>
    .bootstrap-tagsinput {
        margin: 0;
        width: 100%;
        padding: 0.5rem 0.75rem 0;
        font-size: 1rem;
        line-height: 1.25;
        transition: border-color 0.15s ease-in-out;

        &.has-focus {
            background-color: #fff;
            border-color: #5cb3fd;
        }

        .label-info {
            display: inline-block;
            background-color: #24B364;
            padding: 0 .4em .15em;
            border-radius: .25rem;
            margin-bottom: 0.4em;
        }

        input {
            margin-bottom: 0.5em;
        }
    }

    .bootstrap-tagsinput .tag [data-role="remove"]:after {
        content: '\00d7';
    }

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

    .trash-icon {
        border: 2px solid red;
        border-radius: 5px;
        padding: 3px;
    }

    .flatpickr-wrapper {
        display: block;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Laporan Akhir</h4>
    </div>
</div>

<div class=" row">
    <!-- <select class="select2 form-select" data-placeholder="Filter Status">
        <option value="0">2023/2024 Ganjil</option>
        <option value="1">2024/2025 Genap</option>
        <option value="2">2025/2026 Ganjil</option>
        <option value="3">2026/2027 Genap</option>
    </select> -->
    <!-- <div class="col-md-6 col-12 text-end">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Laporan Akhir </button>
    </div> -->
    <div class=" text-end">
        <div class="col-md-12 d-flex justify-content-end align-items-center mt-2 mb-3">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <div class="d-flex align-items-center">
                    <i class="tf-icons ti ti-plus me-2"></i>
                    <span class="mt-1">Tambah Laporan Akhir</span>
                </div>
            </button>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-datatable table-responsive">
        <table class="table" id="table-laporan-akhir">
            <thead>
                <tr>
                    <th style="min-width:50px;">NOMOR</th>
                    <th style="min-width:150px;">JENIS MAGANG</th>
                    <th style="min-width:150px;">DURASI MAGANG</th>
                    <th style="min-width:170px;">BERKAS MAGANG</th>
                    <th style="min-width:200px;">TENGGAT PENGUMPULAN BERKAS MAGANG</th>
                    <th style="min-width:200px;">TENGGAT PENILAIAN MAGANG</th>
                    <th style="min-width:50px;">STATUS</th>
                    <th style="min-width:100px;">AKSI</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@include('masters.berkas_akhir.modal')

<!-- Modal Alert
<div class="modal fade" id="modalalertnonaktif" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="app-assets/img/alert.png" alt="">
                <h5 class="modal-title" id="modal-title">Apakah anda yakin ingin menonaktifkan data?</h5>
                <p>Data yang dipilih akan non-aktif!</p>
            </div>
            <div class="modal-footer" style="display: flex; justify-content:center;">
                <button type="submit" id="modal-button" class="btn btn-success">Ya, yakin</button>
                <button type="submit" id="modal-button" class="btn btn-danger">Batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalalertaktif" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="app-assets/img/alert.png" alt="">
                <h5 class="modal-title" id="modal-title">Apakah anda yakin ingin mengaktifkan data?</h5>
                <p>Data yang dipilih akan aktif!</p>
            </div>
            <div class="modal-footer" style="display: flex; justify-content:center;">
                <button type="submit" id="modal-button" class="btn btn-success">Ya, yakin</button>
                <button type="submit" id="modal-button" class="btn btn-danger">Batal</button>
            </div>
        </div>
    </div>
</div> -->

@endsection

@section('page_script')
<script>
    $('#table-laporan-akhir').DataTable({
        ajax: '{{ route("laporan-akhir.show")}}',
        scrollX: true,
        processing: true,
        type: 'GET',
        columns: [{
                data: "DT_RowIndex"
            },
            {
                data: "jenis_magang.namajenis"
            },
            {
                data: "durasi_magang"
            },
            {
                data: "berkas_magang"
            },
            {
                data: "tgl_pengumpulan"
            },
            {
                data: "tgl_penilaian"
            },
            {
                data: "status"
            },
            {
                data: "action"
            }
        ],
        "columnDefs": [{
                "width": "50px",
                "targets": 0
            },
            {
                "width": "150px",
                "targets": 1
            },
            {
                "width": "150px",
                "targets": 2
            },
            {
                "width": "170px",
                "targets": 3
            },
            {
                "width": "200px",
                "targets": 4
            },
            {
                "width": "200px",
                "targets": 5
            },
            {
                "width": "50px",
                "targets": 6
            },
            {
                "width": "100px",
                "targets": 7
            }
        ],
    });

    function edit(e) {
        let id = e.attr('data-id');

        let action = `{{ url('master/laporan-akhir/update/') }}/${id}`;
        var url = `{{ url('master/laporan-akhir/edit/') }}/${id}`;
        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                console.log(response.file);
                $("#modal-title").html("Edit Master Laporan Akhir Magang");
                $("#modal-button").html("Update Data")
                $('#modalTambah form').attr('action', action);
                $('#jenismagang').val(response.laporan.id_jenismagang).trigger('change');
                $('#durasimagang').val(response.laporan.durasi_magang).trigger('change');
                response.file.forEach(function(item) {
                    $('#modalTambah form #berkas_magang').append(`<option selected value="
                                    ${item} ">${item}</option>`);

                });
                $('#flatpickr-datetime').val(moment(response.laporan.deadline_pengumpulan).format('DD MMMM YYYY HH:mm')).trigger('change');
                $('#flatpickr-datetime2').val(moment(response.laporan.deadline_penilaian).format('DD MMMM YYYY HH:mm')).trigger('change');

                $('#modalTambah').modal('show');
                // console.log(response.berkas_magang);
            }
        });
    }

    $("#modalTambah").on("hide.bs.modal", function() {

        $("#modal-title").html("Tambah Master Laporan Akhir Magang");
        $("#modal-button").html("Simpan")
        $('#modalTambah form')[0].reset();
        $('#modalTambah form #jenismagang').val('').trigger('change');
        $('#modalTambah form #durasimagang').val('').trigger('change');
        $('#modalTambah form #berkas_magang').val('').trigger("change");
        $('#modalTambah form #flatpickr-datetime').val('').trigger('change');
        $('#modalTambah form #flatpickr-datetime2').val('').trigger('change');
        $('#modalTambah form').attr('action', "{{ url('master/laporan-akhir/store') }}");
        $('.invalid-feedback').removeClass('d-block');
        $('.form-control').removeClass('is-invalid');

        $(".flatpickr-input").flatpickr({
            enableTime: true,
            dateFormat: 'd F Y H:i',
            minDate: "today",
            defaultDate: null,
        });
    });



    // Tag input multiple

    $(document).ready(function() {



        $('#berkas_magang').select2({
            tags: true,
            dropdownParent: $("#modalTambah .modal-body"),
        });

    });
</script>
<script src="{{ asset('app-assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ url('app-assets/vendor/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
<script src="{{ asset('app-assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('app-assets/js/extended-ui-sweetalert2.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/pickr/pickr.js') }}"></script>
<script src="{{ asset('app-assets/js/forms-pickers.js') }}"></script>
@endsection