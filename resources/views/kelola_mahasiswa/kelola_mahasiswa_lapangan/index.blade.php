@extends('partials.vertical_menu')

@section('page_style')
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/datatables-fixedcolumns-bs5/fixedcolumns.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/datatables-fixedheader-bs5/fixedheader.bootstrap5.css') }}" />
@endsection

@section('content')
<div class="row">
    <div class="col-md-9 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Kelola Mahasiswa</h4>
    </div>
    <div class="col-md-3 col-12 mb-3 d-flex align-items-center justify-content-end">
        <select class="select2 form-select" data-placeholder="Pilih Tahun Ajaran" id="tahun_ajaran_filter">
            {!! tahunAjaranMaker() !!}
        </select>
        <button class="btn btn-primary btn-icon ms-2" data-bs-toggle="offcanvas" data-bs-target="#modalSlide"><i class="tf-icons ti ti-filter"></i></button>
    </div>
</div>  

<div class="row ps-2 pe-3">
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="table" id="table-lapangan">
                <thead>
                    <tr>
                        <th style="min-width: 50px;">NOMOR</th>
                        <th style="min-width:150px;">NAMA</th>
                        <th style="min-width:150px;">PROGRAM STUDI</th>
                        <th style="min-width:150px;">POSISI MAGANG</th>
                        <th style="min-width:150px;">DURASI MAGANG</th>
                        <th style="min-width:150px;">JENIS MAGANG</th>
                        <th style="min-width:100px;text-align:center;">NILAI AKHIR</th>
                        <th style="min-width:100px;text-align:center;">INDEKS</th>
                        <th style="min-width:150px;text-align:center;">STATUS MAGANG</th>
                        <th style="min-width:130px;text-align:center;">AKSI</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@include('kelola_mahasiswa/kelola_mahasiswa_lapangan/components/modal')
@endsection

@section('page_script')
<script>
    let dataFilter = {};
    $(document).ready(function () {
        loadData();
    });

    $('#tahun_ajaran_filter').on('change', function () {
        loadData();
    });

    function loadData() {
        dataFilter['tahun_akademik'] = $('#tahun_ajaran_filter').val();
        
        $('#table-lapangan').DataTable({
            ajax: {
                url: `{{ route('kelola_magang_pemb_lapangan.get_data') }}`,
                type: 'GET',
                data: dataFilter
            },
            destroy: true,
            scrollX: true,
            drawCallback: function () {
                initTooltips();
            },
            columns: [
                { data: "DT_RowIndex" },
                { data: "namamhs" },
                { data: "namaprodi" },
                { data: "intern_position" },
                { data: "durasimagang" },
                { data: "namajenis" },
                { data: "nilai_akhir" },
                { data: "indeks" },
                { data: "status" },
                { data: "aksi" }
            ],
            columnDefs: [
                { "width": "50px", "targets": 0 },
                { "width": "150px", "targets": 1 },
                { "width": "150px", "targets": 2 },
                { "width": "150px", "targets": 3 },
                { "width": "150px", "targets": 4 },
                { "width": "150px", "targets": 5 },
                { "width": "100px", "targets": 6 },
                { "width": "100px", "targets": 7 },
                { "width": "150px", "targets": 8 },
                { "width": "130px", "targets": 9 }
            ],
            fixedColumns: { left: 2, right: 1 },
        })
    }

    $('#filter_form').on('submit', function () {
        let form = $(this).serializeArray();
        form.forEach(function (item) {
            dataFilter[item.name] = item.value; 
        });
        loadData();
    });

    $('#filter_form').on('reset', function () {
        dataFilter = {};
        loadData();
    });

    function deleteMhsMagang(e) {
        
        let dataId = e.attr('data-id');
        let modal = $('#modalDipulangkan');

        modal.find('form').attr('action', `{{ route('kelola_magang_pemb_lapangan.delete_mhs', ['id' => ':id']) }}`.replace(':id', dataId));
        modal.find('.modal-title').html('Anda memulangkan '+e.attr('data-mahasiswa')+', Silahkan memberikan alasan dan bukti!');
        modal.modal('show');
    }

    $(document).on('click', '#submitPemulanganMahasiswa', function () {
        sweetAlertConfirm({
            title: 'Apakah anda yakin ingin memulangkan mahasiswa?',
            text: 'Pilihan Anda akan secara otomatis memperbarui data dan membatasi akses yang tersedia bagi mahasiswa.',
            icon: 'warning',
            confirmButtonText: 'Ya, saya yakin!',
            cancelButtonText: 'Batal',
        }, function () {
            let button = $('#submitPemulanganMahasiswa');
            let form = button.parents('form');

            button.attr('type', 'submit');
            form.submit();
            button.attr('type', 'button');
        });
    });

    function afterDeleteMhs(res) {
        loadData()
        $('#modalDipulangkan').modal('hide');
    }
</script>
@endsection