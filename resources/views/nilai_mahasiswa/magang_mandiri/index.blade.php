@extends('partials.vertical_menu')

@section('page_style')
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: #4EA971;
    }

    .light-style .tagify__tag .tagify__tag-text {
        color: #4EA971 !important;
    }
</style>
@endsection

@section('content')
<div class="row pe-2 ps-2">
    <div class="col-md-9 col-12">
        <h4 class="fw-bold text-sm"><span class="text-muted fw-light text-xs">Nilai Mahasiswa / </span>
        Magang Mandiri Tahun Ajaran 2023/2024
        </h4>
    </div>
    <div class="col-md-3 col-12 mb-3  d-flex align-items-center justify-content-between">
        <select class="select2 form-select" data-placeholder="Pilih Tahun Ajaran">
            <option value="1">2023/2024 Genap</option>
            <option value="2">2023/2024 Ganjil</option>
            <option value="3">2022/2023 Genap</option>
            <option value="4">2022/2023 Ganjil</option>
            <option value="5">2021/2022 Genap</option>
            <option value="6">2021/2022 Ganjil</option>
        </select>
        <button class="btn btn-success waves-effect waves-light" data-bs-toggle="offcanvas" data-bs-target="#modalSlide"><i class="tf-icons ti ti-filter"></i>
        </button>
    </div>

    <div class="row">
        <div class="col-md-12 col-12 ">
            <div class="text-secondary mt-3 mb-3 ">Filter Berdasarkan : <i class='tf-icons ti ti-alert-circle text-primary pb-1' data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Prodi: D3 Sistem Informasi" id="tooltip-filter"></i></div>
        </div>
    </div>

    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="table table-mandiri" id="table-mandiri">
                <thead>
                    <tr>
                        <th style="min-width: 50px;">NOMOR</th>
                        <th style="min-width: 125px;">NAMA/NIM</th>
                        <th style="min-width: 170px;">PROGRAM STUDI</th>
                        <th style="min-width: 150px;">PERUSAHAAN</th>
                        <th style="min-width: 150px;">POSISI MAGANG</th>
                        <th style="min-width: 100px;">NILAI PBB LAPANGAN</th>
                        <th style="min-width: 100px;">NILAI PBB AKADEMIK</th>
                        <th style="min-width: 100px;">NILAI AKHIR</th>
                        <th style="min-width: 100px;">INDEKS NILAI AKHIR</th>
                        <th style="min-width: 50px;">AKSI</th>
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
        <form class="add-new-user pt-0" id="filter">
            <div class="col-12 mb-2">
                <div class="row">
                    <div class="mb-2">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select select2" id="prodi" name="prodi" data-placeholder="Pilih Program Studi">
                            <option value="">Pilih Program Studi</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2">
                        <label for="perusahaan" class="form-label">Masukkan Nama Perusahaan</label>
                        <input type="text" id="" class="form-control" placeholder="Masukkan Nama Perusahaan" />
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2">
                        <label for="posisi" class="form-label">Masukkan Posisi Magang</label>
                        <input type="text" id="" class="form-control" placeholder="Masukkan Posisi Magang" />
                    </div>
                </div>
            </div>
            <div class="mt-3 text-end">
                <button type="reset" class="btn btn-label-danger data-reset">Reset</button>
                <button type="submit" class="btn btn-success">Terapkan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('page_script')
<script src="../../app-assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
<script src="../../app-assets/js/forms-extras.js"></script>
<script>
    var jsonData = [{
            "nomor": "1",
            "nama/nim": "Jennie Ruby Jane <br> 6701250405",
            "program_studi": "D3 Sistem Informasi",
            "perusahaan": "Techno Infinity",
            "posisi_magang": "UI/UX Designer",
            "nilai_pbb_lapangan": "98",
            "nilai_pbb_akademik": "96",
            "nilai_akhir": "97",
            "indeks_nilai_akhir": "A",
            "aksi": "<a href='{{ route('nilai_mahasiswa.mandiri.detail') }}' class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-file-invoice'></i></a>",
        },
        {
            "nomor": "2",
            "nama/nim": "Jennie Ruby Jane <br> 6701250405",
            "program_studi": "D3 Sistem Informasi",
            "perusahaan": "Techno Infinity",
            "posisi_magang": "UI/UX Designer",
            "nilai_pbb_lapangan": "98",
            "nilai_pbb_akademik": "96",
            "nilai_akhir": "97",
            "indeks_nilai_akhir": "A",
            "aksi": "<a href='{{ route('nilai_mahasiswa.mandiri.detail') }}' class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-file-invoice'></i></a>",
        },
    ];

    var table = $('#table-mandiri').DataTable({
        "data": jsonData,
        scrollX: true,
        columns: [{
                data: "nomor"
            },
            {
                data: "nama/nim"
            },
            {
                data: "program_studi"
            },
            {
                data: "perusahaan"
            },
            {
                data: "posisi_magang"
            },
            {
                data: "nilai_pbb_lapangan"
            },
            {
                data: "nilai_pbb_akademik"
            },
            {
                data: "nilai_akhir"
            },
            {
                data: "indeks_nilai_akhir"
            },
            {
                data: "aksi"
            }
        ],
        "columnDefs": [{
                "width": "50px",
                "targets": 0
            },
            {
                "width": "125px",
                "targets": 1
            },
            {
                "width": "170px",
                "targets": 2
            },
            {
                "width": "150px",
                "targets": 3
            },
            {
                "width": "150px",
                "targets": 4
            },
            {
                "width": "100px",
                "targets": 5
            },
            {
                "width": "100px",
                "targets": 6
            },
            {
                "width": "100px",
                "targets": 7
            },
            
            {
                "width": "100px",
                "targets": 8
            },
            {
                "width": "50px",
                "targets": 9
            },
        ],
    });
</script>

<script src="../../app-assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script src="../../app-assets/js/extended-ui-sweetalert2.js"></script>
<script src="../../app-assets/vendor/libs/tagify/tagify.js"></script>
<script src="../../app-assets/js/forms-tagify.js"></script>
@endsection