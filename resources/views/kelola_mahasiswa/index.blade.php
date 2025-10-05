@extends('partials.vertical_menu')

@section('page_style')
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/datatables-fixedcolumns-bs5/fixedcolumns.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/datatables-fixedheader-bs5/fixedheader.bootstrap5.css') }}" />
@endsection

@section('content')
<div class="row">
    <div class="col-md-9 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Kelola Mahasiswa</span></h4>
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
            <table class="table" id="table-akademik">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA</th>
                        <th>PROGRAM STUDI</th>
                        <th>POSISI MAGANG</th>
                        <th>PERUSAHAAN</th>
                        <th>DURASI MAGANG</th>
                        <th>JENIS MAGANG</th>
                        <th>BERKAS AKHIR MAGANG</th>
                        <th>NILAI AKHIR</th>
                        <th>INDEKS</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="modalSlide" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Filter Berdasarkan</h5>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form class="pt-0" id="filter_form" onsubmit="return false;">
            <div class="col-12 mb-2">
                <div class="row">
                    <div class="mb-2">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select select2" id="prodi" name="prodi" data-placeholder="Pilih Program Studi">
                            <option value="">Pilih Program Studi</option>
                            @foreach ($programStudi as $item)
                                <option value="{{ $item->id_prodi }}">{{ $item->namaprodi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="magang" class="form-label">Jenis Magang</label>
                        <select class="form-select select2" id="magang" name="magang" data-placeholder="Pilih Jenis Magang">
                            <option value="">Pilih Jenis Magang</option>
                            @foreach ($jenisMagang as $item)
                                <option value="{{ $item->id_jenismagang }}">{{ $item->namajenis }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="mt-3 text-end">
                <button type="reset" class="btn btn-label-danger data-reset">Reset</button>
                <button type="submit" class="btn btn-primary">Terapkan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('page_script')
<script src="{{ asset('app-assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
<script src="{{ asset('app-assets/js/forms-extras.js') }}"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.0/js/dataTables.fixedColumns.js"></script>
<script>
    let dataFilter = {};
    $(document).ready(function() {
        loadData();
    });

    $('#tahun_ajaran_filter').on('change', function () {
        loadData();
    });

    $('#filter_form').on('submit', function () {
        dataFilter['prodi'] = $('#prodi').val();
        dataFilter['magang'] = $('#magang').val();
        loadData();
    });

    $('#filter_form').on('reset', function () {
        $('#prodi').val(null).change();
        $('#magang').val(null).change();

        dataFilter = {};
        loadData();
    });

    function loadData() {
        dataFilter['tahun_ajaran'] = $('#tahun_ajaran_filter').val();

        $('#table-akademik').DataTable({
            scrollX: true,
            destroy: true,
            ajax: {
                url: "{{ route('kelola_mhs_pemb_akademik.get_data') }}",
                type: 'GET',
                data: dataFilter
            },
            drawCallback: function () {
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    defaultContent: ''
                },
                {
                    data: 'namamhs',
                    name: 'namamhs',
                    defaultContent: '-'
                },
                {
                    data: 'namaprodi',
                    name: 'namaprodi',
                    defaultContent: '-'
                },
                {
                    data: 'intern_position',
                    name: 'intern_position',
                    defaultContent: '-'
                },
                {
                    data: 'namaindustri',
                    name: 'namaindustri',
                    defaultContent: '-'
                },
                {
                    data: 'durasimagang',
                    name: 'durasimagang',
                    defaultContent: '-'
                },
                {
                    data: 'jenis_magang',
                    name: 'jenis_magang',
                    defaultContent: '-'
                },
                {
                    data: 'berkas_akhir',
                    name: 'berkas_akhir',
                    defaultContent: '-'
                },
                {
                    data: 'nilai_akademik',
                    name: 'nilai_akademik',
                    defaultContent: '0'
                },
                {
                    data: 'indeks_nilai_akademik',
                    name: 'indeks_nilai_akademik',
                    defaultContent: '-'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    defaultContent: ''
                },
            ],
            fixedColumns: true,
        });
    }
</script>
@endsection