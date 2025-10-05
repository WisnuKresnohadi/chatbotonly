@extends('partials_admin.template')

@section('page_style')
    <link rel="stylesheet" href="../../app-assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <style>
    .tooltip-inner {
        max-width: 900px;
        /* If max-width does not work, try using width instead */
        width: 900px; 
    }
    </style>
@endsection

@section('main')
<div class="row">
    <div class="col-md-9 col-12"><nav aria-label="breadcrumb">
    <div class="row ">
    <div class="">
        <h4 class="fw-bold text-sm"><span class="text-muted fw-light text-xs">Lowongan Magang / </span>
            Lowongan Magang-Tahun Ajaran 2324
        </h4>
    </div>
    </div>
</div>
<div class="col-md-3 col-12 mb-3 ps-5 d-flex align-items-center justify-content-between">
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
    <div class="col-xl-12">
        <div class="nav-align-top">
            <ul class="nav nav-pills mb-3 " role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-justified-users" aria-controls="navs-pills-justified-users"
                        aria-selected="true">
                        <i class="ti ti-briefcase ti-sm"></i> Total Lowongan
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-success ms-1">2</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link showSingle" target="2" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-justified-pending" aria-controls="navs-pills-justified-pending"
                        aria-selected="false">
                        <i class="tf-icons ti ti-clock ti-xs me-1"></i> Menunggu Persetujuan
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-success ms-1">2</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-justified-verified" aria-controls="navs-pills-justified-verified"
                        aria-selected="false">
                        <i class="tf-icons ti ti-user-check ti-xs me-1"></i> Lowongan Disetujui
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-success ms-1">4</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-justified-rejected" aria-controls="navs-pills-justified-rejected"
                        aria-selected="false">
                        <i class="tf-icons ti ti-user-x ti-xs me-1"></i> Lowongan Ditolak
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-success ms-1">1</span>
                    </button>
                </li>
            </ul>
            <div class="row mb-4">
                <div class="col-md-8 col-12 ">
                <div class="text-secondary mt-4">Filter Berdasarkan : <i class='tf-icons ti ti-alert-circle text-primary pb-1'
                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Program Studi : D3 Rekayasa Perangkat Lunak Aplikasi, Durasi Magang : 2 Semester, Posisi Lowongan : UI/UX Designer" id="tooltip-filter"></i></div>
                </div>
                {{-- <div class="col-1"></div> --}}
                    <div class="col-md-4 d-flex justify-content-end align-items-center">
                        <a href='/tambah-lowongan-magang'>
                            <button class="btn btn-success" type="button">+ Tambah Lowongan
                                Magang</button>
                            </a>
                        </div>
               </div>
            <div class="tab-content mt-4">
                <div class="tab-pane fade show active" id="navs-pills-justified-users" role="tabpanel">
                    <div class="border border-green-500 py-2 px-3 fw-semibold rounded-2 w-10  col-3">
                        <span class="badge badge-center bg-label-success mr-10"><i class="ti ti-briefcase"></i></span>
                        Total lowongan : <span class="text-primary">50</span> <span class="text-success">Lowongan</span>
                    </div>

                    <div class="card-datatable table-responsive">
                        <table class="table" id="table-kelola-mitra1">
                            <thead>
                                <tr>
                                    <th>POSISI</th>
                                    <th style="min-width: 100px;">FAKULTAS</th>
                                    <th>JURUSAN</th>
                                    <th>TANGGAL</th>
                                    <th>DURASI MAGANG</th>
                                    <th>STATUS</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade " id="navs-pills-justified-pending" role="tabpanel">
                    <div class="border border-green-500 py-2 px-3 fw-semibold rounded-2 w-10  col-5">
                        <span class="badge badge-center bg-label-success mr-10"><i class="ti ti-briefcase"></i></span>
                        Total lowongan menunggu persetujuan : <span class="text-primary">50</span> <span
                            class="text-success">Lowongan</span>
                    </div>

                    <div class="card-datatable table-responsive">
                        <table class="table" id="table-kelola-mitra2">
                            <thead>
                                <tr>
                                    <th>POSISI</th>
                                    <th style="min-width: 100px;">FAKULTAS</th>
                                    <th>JURUSAN</th>
                                    <th>TANGGAL</th>
                                    <th>DURASI MAGANG</th>
                                    <th>STATUS</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="navs-pills-justified-verified" role="tabpanel">
                    <div class="border border-green-500 py-2 px-3 fw-semibold rounded-2 w-10  col-4">
                        <span class="badge badge-center bg-label-success mr-10"><i class="ti ti-briefcase"></i></span>
                        Total lowongan di setujui : <span class="text-primary">50</span> <span
                            class="text-success">Lowongan</span>
                    </div>

                    <div class="card-datatable table-responsive">
                        <table class="table" id="table-kelola-mitra3">
                            <thead>
                                <tr>
                                    <th>POSISI</th>
                                    <th style="min-width: 100px;">FAKULTAS</th>
                                    <th>JURUSAN</th>
                                    <th>TANGGAL</th>
                                    <th>DURASI MAGANG</th>
                                    <th>STATUS</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="navs-pills-justified-rejected" role="tabpanel">
                    <div class="border border-green-500 py-2 px-3 fw-semibold rounded-2 w-10  col-4">
                        <span class="badge badge-center bg-label-success mr-10"><i class="ti ti-briefcase"></i></span>
                        Total lowongan di tolak : <span class="text-primary">50</span> <span
                            class="text-success">Lowongan</span>
                    </div>

                    <div class="card-datatable table-responsive">
                        <table class="table" id="table-kelola-mitra4">
                            <thead>
                                <tr>
                                    <th>POSISI</th>
                                    <th style="min-width: 100px;">FAKULTAS</th>
                                    <th>JURUSAN</th>
                                    <th>TANGGAL</th>
                                    <th>DURASI MAGANG</th>
                                    <th>STATUS</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
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
                            <label for="fakultas" class="form-label">Program Studi</label>
                            <select class="form-select select2" id="prodi" name="prodi"
                                data-placeholder="Pilih Fakultas">
                                <option value="">Fakultas</option>

                            </select>
                        </div>
                        <div class="col-12 mb-2 form-input">
                            <label for="univ" class="form-label">Durasi Magang</label>
                            <select class="form-select select2" id="durasi" name="durasi"
                                data-placeholder="Pilih Prodi">
                                <option value="1 Semester">1 Semester</option>
                                <option value="2 Semester">2 Semester</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 mb-2 form-input">
                            <label for="univ" class="form-label">Posisi Lowongan Magang</label>
                            <select class="form-select select2" id="posisi" name="posisi"
                                data-placeholder="Pilih Universitas">
                                <option value="UI/UX Designer">UI/UX Designer</option>
                                <option value="Fullstack Developer">Fullstack Developer</option>
                                <option value="Quality Assurance">Quality Assurance</option>
                                <option value="Technical Writter">Technical Writter</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="row cnt">
                            <div id="div1" class="targetDiv">
                        <div class="col-12 mb-2 form-input">
                            <label for="univ" class="form-label">Status Lowongan Magang</label>
                            <select class="form-select select2" id="univ" name="univ"
                                data-placeholder="Pilih Universitas">
                                <option value="Diterima">Diterima</option>
                                <option value="Ditolak">Ditolak</option>
                                <option value="Kadaluarsa">Kadaluarsa</option>
                                <option value="Menunggu Persetujuan">Menunggu Persetujuan</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                            </div>
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

    {{-- <div class="modal fade" id="modalTambahMitra" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-center d-block">
                    <h5 class="modal-title" id="modalTambahMitra">Tambah Mitra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-2">
                            <label for="nama" class="form-label">Nama Perusahaan</label>
                            <input type="text" id="nama" class="form-control" placeholder="Nama Perusahaan" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" id="email" class="form-control" placeholder="Email" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('page_script')
    <script src="../../app-assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
    <script src="../../app-assets/js/forms-extras.js"></script>
    <script>
        var jsonData = [{
                "posisi": "UI/UX Designer",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-danger'>Non-aktif</span>",
                "aksi": "<a href='/edit'class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a href='/detail-lowongan' class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            },
            {
                "posisi": "UI/UX Designer",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-success'>Aktif</span>",
                "aksi": "<a class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            },
            {
                "posisi": "UI/UX Designer   ",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-danger'>Non-aktif</span>",
                "aksi": "<a class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            }
        ];

        var table = $('#table-kelola-mitra1').DataTable({
            "data": jsonData,
            columns: [{
                    data: "posisi"
                },
                {
                    data: "fakultas"
                },
                {
                    data: "jurusan"
                },

                {
                    data: "tanggal"
                },
                {
                    data: "durasi_magang"
                },
                {
                    data: "status"
                },
                {
                    data: "aksi"
                }
            ]
        });
    </script>

    <script>
        var jsonData = [{
                "posisi": "UI/UX Designer",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-danger'>Non-aktif</span>",
                "aksi": "<div class='d-flex'><a href='/edit'class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a href='/detail-lowongan' class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            },
            {
                "posisi": "UI/UX Designer",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-success'>Aktif</span>",
                "aksi": "<a href='/edit'class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a href='/detail-lowongan' class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            },
            {
                "posisi": "UI/UX Designer   ",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-danger'>Non-aktif</span>",
                "aksi": "<a href='/edit'class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a href='/detail-lowongan' class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            }
        ];

        var table = $('#table-kelola-mitra2').DataTable({
            "data": jsonData,
            columns: [{
                    data: "posisi"
                },
                {
                    data: "fakultas"
                },
                {
                    data: "jurusan"
                },

                {
                    data: "tanggal"
                },
                {
                    data: "durasi_magang"
                },
                {
                    data: "status"
                },
                {
                    data: "aksi"
                }
            ]
        });
    </script>

    <script>
        var jsonData = [{
                "posisi": "UI/UX Designer",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-danger'>Non-aktif</span>",
                "aksi": "<div class='d-flex'><a href='/edit'class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a href='/detail-lowongan' class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            },
            {
                "posisi": "UI/UX Designer",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-success'>Aktif</span>",
                "aksi": "<a href='/edit'class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a href='/detail-lowongan' class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            },
            {
                "posisi": "UI/UX Designer   ",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-danger'>Non-aktif</span>",
                "aksi": "<a href='/edit'class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a href='/detail-lowongan' class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            }
        ];

        var table = $('#table-kelola-mitra3').DataTable({
            "data": jsonData,
            columns: [{
                    data: "posisi"
                },
                {
                    data: "fakultas"
                },
                {
                    data: "jurusan"
                },

                {
                    data: "tanggal"
                },
                {
                    data: "durasi_magang"
                },
                {
                    data: "status"
                },
                {
                    data: "aksi"
                }
            ]
        });
    </script>
    <script>
        var jsonData = [{
                "posisi": "UI/UX Designer",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-danger'>Non-aktif</span>",
                "aksi": "<div class='d-flex'><a href='/edit'class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a href='/detail-lowongan' class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            },
            {
                "posisi": "UI/UX Designer",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-success'>Aktif</span>",
                "aksi": "<a href='/edit'class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a href='/detail-lowongan' class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            },
            {
                "posisi": "UI/UX Designer   ",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-danger'>Non-aktif</span>",
                "aksi": "<a href='/edit'class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a href='/detail-lowongan' class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            }
        ];

        var table = $('#table-kelola-mitra4').DataTable({
            "data": jsonData,
            columns: [{
                    data: "posisi"
                },
                {
                    data: "fakultas"
                },
                {
                    data: "jurusan"
                },

                {
                    data: "tanggal"
                },
                {
                    data: "durasi_magang"
                },
                {
                    data: "status"
                },
                {
                    data: "aksi"
                }
            ]
        });

        jQuery(function() {
        jQuery('.showSingle').click(function() {
            jQuery('.targetDiv').hide('.cnt');
            jQuery('#div' + $(this).attr('target')).slideToggle();
        });
    });
    </script>

    <script src="../../app-assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="../../app-assets/js/extended-ui-sweetalert2.js"></script>
@endsection
