@extends('partials.vertical_menu')

@section('page_style')
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/datatables-fixedcolumns-bs5/fixedcolumns.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/datatables-fixedheader-bs5/fixedheader.bootstrap5.css') }}" />
<style>
    .detail-card-berkas:hover {
        cursor: pointer;
        transform: scale(1.009);
        transition: 0.3s;
        z-index: 1;
    }
</style>

@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h4 class="fw-bold"><span class="text-muted fw-light">Berkas Akhir Magang / </span>Magang Fakultas Tahun Ajaran <span id="tahun_akademik_picked"></span></h4>
    </div>
    <div class="d-none d-sm-flex">
        <select class="select2 form-select" data-placeholder="Filter Status" id="filter_tahun_ajaran">
            {!! tahunAjaranMaker() !!}
        </select>
    </div>
</div>

<div class="mb-4">
    <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active load-data-table" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-pending" aria-controls="navs-pills-pending" aria-selected="true">
                <i class="ti ti-clock pe-1"></i> Menunggu Diverifikasi
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link load-data-table" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-incomplete" aria-controls="navs-pills-incomplete" aria-selected="false">
                <i class="ti ti-clipboard-x pe-1"></i> Tidak Lengkap
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link load-data-table" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-complete" aria-controls="navs-pills-complete" aria-selected="false">
                <i class="ti ti-clipboard-check pe-1"></i>Lengkap
            </button>
        </li>
    </ul>
    <div class="alert alert-info d-flex align-items-center" role="alert">
        <i class="ti ti-alert-triangle ti-xs me-2"></i>
        <span style="padding-left:10px; color:#322F3D;"> Silahkan klik nama berkas untuk mengubah status verifikasi.</span>
    </div>
    <div class="tab-content p-0">
        @foreach (['pending', 'incomplete', 'complete'] as $key => $item)
        <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="navs-pills-{{ $item }}" role="tabpanel">
            <div class="card">
                <div class="card-datatable">
                    <div class="table-responsive">
                        <table class="table dt-table" id="{{ $item }}">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama/NIM</th>
                                    <th class="text-center">Aksi</th>
                                    <th class="text-center text-nowrap">Berkas Akhir Magang</th>
                                    <th class="text-center text-nowrap">Waktu Pengumpulan</th>
                                    <th>Pengurangan Nilai</th>
                                    <th class="text-center text-nowrap">Nilai Akhir</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@include('berkas_akhir_magang/magang_fakultas/components/modal')
@endsection

@section('page_script')
<script>
    let typeGot = {
        pending: false,
        incomplete: false,
        complete: false
    };

    let dataFilter = {};

    $(document).ready(function () {
        dataFilter['type'] = 'pending';
        loadData();
    });

    $('#filter_tahun_ajaran').on('change', function () {
        dataFilter['type'] = $('.load-data-table.active').attr('data-bs-target').replace('#navs-pills-', '');
        typeGot = {
            pending: false,
            incomplete: false,
            complete: false
        };
        loadData();
    });

    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        $('.dt-table').DataTable().columns.adjust().draw();
    });

    $('.load-data-table').on('click', function () {
        dataFilter['type'] = $(this).attr('data-bs-target').replace('#navs-pills-', '');
        loadData();
    });

    function loadData() {
        dataFilter['tahun_akademik'] = $('#filter_tahun_ajaran').val();
        $('#tahun_akademik_picked').text($('#filter_tahun_ajaran :selected').text());

        if(typeGot[dataFilter['type']] == true) return;

        let table = $('#' + dataFilter['type']).DataTable({
            destroy: true,
            ajax: {
                url: `{{ route('berkas_akhir_magang.fakultas.get_data') }}`,
                type: 'GET',
                data: dataFilter
            },
            scrollX: true,
            drawCallback: function () {
                initTooltips();
            },
            columns: [
                { data: (data) => "<span class='text-center'>" + data.DT_RowIndex + "</span>" },
                { data: "namamhs" },
                { data: "action" },
                { data: "berkas_akhir_magang" },
                { data: "waktu_pengumpulan" },
                { data: "adjustment_nilai" },
                { data: "nilai_akhir" },
            ],
            fixedColumns: { left: 3}

        });

        if (table != null) typeGot[dataFilter['type']] = true;
    }

    function adjustmentNilai(e) {
        let dataId = e.attr('data-id');
        let modal = $('#modal-adjustment-nilai');

        modal.modal('show');
        let urlAction = `{{ route('berkas_akhir_magang.fakultas.adjustment_nilai', ['id' => ':id']) }}`.replace(':id', dataId);

        $.ajax({
            url: `{{ route('berkas_akhir_magang.fakultas') }}`,
            type: `GET`,
            data: { section: 'get_data_nilai', data_id: dataId },
            success: function (res) {
                modal.find('form').attr('action', urlAction);
                $.each(res.data, function ( key, value ) {
                    modal.find('form').find(`[name=${key}]`).val(value).change();
                });
            },
            error: function (err) {
                showSweetAlert({
                    type: 'error',
                    title: 'Gagal',
                    text: err.responseJSON.message
                });
            }
        });
    }

    function afterAction(response) {
        let modal = $('#modal-adjustment-nilai');

        dataFilter['type'] = $('.load-data-table.active').attr('data-bs-target').replace('#navs-pills-', '');
        typeGot = {
            pending: false,
            incomplete: false,
            complete: false
        };
        loadData();

        modal.modal('hide');
    }

    function viewMhs(e) {
        let dataId = e.attr('data-id');
        let modal = $('#modalDetail');

        $.ajax({
            url: `{{ route('berkas_akhir_magang.fakultas.detail_mhs', ['id' => ':id']) }}`.replace(':id', dataId),
            type: 'GET',
            success: function (res) {
                modal.find('.modal-dialog').html(res);
                modal.modal('show');
            }
        });
    }

    $('#modalDetail').on('hidden.bs.modal', function () {
        $('#modalDetail .modal-dialog').html(`{{ $default_detail_mhs }}`);
    });

</script>
@endsection