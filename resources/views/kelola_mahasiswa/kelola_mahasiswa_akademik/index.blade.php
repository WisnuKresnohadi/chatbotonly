@extends('partials.vertical_menu')

@section('page_style')
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/datatables-fixedcolumns-bs5/fixedcolumns.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/datatables-fixedheader-bs5/fixedheader.bootstrap5.css') }}" />
@endsection

@section('content')
<div class="row pe-2 ps-2">
    <div class="col-md-9 col-12">
        <h4 class="fw-bold text-sm"><span class="text-muted fw-light text-xs">Logbook Mahasiswa / </span>
        Magang Fakultas Tahun Ajaran <span id="tahun_akademik_picked"></span>
        </h4>
    </div>
    <div class="col-md-3 col-12 mb-3 d-flex align-items-center justify-content-end">
        <select class="select2 form-select" data-placeholder="Pilih Tahun Ajaran" id="tahun_akademil_select">
            {!! tahunAjaranMaker() !!}
        </select>
        <button class="btn btn-primary btn-icon ms-2" data-bs-toggle="offcanvas" data-bs-target="#modalSlide"><i class="tf-icons ti ti-filter"></i></button>
    </div>
    <div class="row">
        <div class="col-md-12 col-12 ">
            <div class="text-secondary mt-3 mb-3 ">Filter Berdasarkan : <i class='tf-icons ti ti-alert-circle text-primary pb-1' data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Prodi: D3 Sistem Informasi" id="tooltip-filter"></i></div>
        </div>
    </div>
</div>

<div class="row ps-2 pe-3">
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="table" id="table-lapangan">
                <thead>
                    <tr>
                        <th style="">NOMOR</th>
                        <th style="">NAMA</th>
                        <th style="">PROGRAM STUDI</th>
                        <th style="">PERUSAHAAN</th>
                        <th style="">POSISI MAGANG</th>
                        <th style="">NILAI PBB LAPANGAN</th>
                        <th style="">NILAI PBB AKADEMIK</th>
                        <th style="">NILAI AKHIR</th>
                        <th style="">STATUS MAGANG</th>
                        <th style="">AKSI</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@include('kelola_mahasiswa.kelola_mahasiswa_akademik.modal')
@endsection

@section('page_script')
<script>
    let dataFilter = {};
    $(document).ready(function () {
        dataFilter['tahun_akademik'] = $('#tahun_akademil_select').val();
        loadData();
    });

    $('#tahun_akademil_select').on('change', function () {
        dataFilter['tahun_akademik'] = $(this).val();
        loadData();
    });

    function loadData() {
        $('#tahun_akademik_picked').text($('#tahun_akademil_select :selected').text());
        $('#table-lapangan').DataTable({
            ajax: {
                url: `{{ route('logbook_magang.fakultas.get_data') }}`,
                type: 'GET',
                data: dataFilter
            },
            destroy: true,
            scrollX: true,
            columns: [
                { data: "DT_RowIndex" },
                { data: "namamhs" },
                { data: "namaprodi" },
                { data: "namaindustri" },
                { data: "intern_position" },
                { data: "nilai_lap" },
                { data: "nilai_akademik" },
                { data: "nilai_akhir_magang" },
                { data: "status" },
                { data: "aksi" }
            ],
            columnDefs: [
                { "width": "50px", "targets": 0 },
                { "width": "200px", "targets": [1, 2, 3, 4, 8] },
                { "width": "100px", "targets": [5, 6, 7], className: "text-center" },
                { "width": "50px", "targets": 9 }
            ],
            fixedColumns: { left: 2, right: 1 },
        });
    }
</script>
@endsection