@extends('partials_admin.template')

@section('page_style')
    <link rel="stylesheet" href="../../app-assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <style>
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
    </style>
@endsection

@section('main')
    <div class="row">
        <div class="col-md-9 col-12">
            <h4 class="fw-bold">Jadwal Seleksi</h4>
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
            <button class="btn btn-success waves-effect" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#modalSlide"><i class="tf-icons ti ti-filter"></i></button>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="table" id="table-jadwal-seleksi">
                        <thead>
                            <tr>
                                <th>NOMOR</th>
                                <th>NAMA</th>
                                <th>TANGGAL SELEKSI</th>
                                <th>WAKTU SELESAI</th>
                                <th>JENIS SELEKSI</th>
                                <th>PELAKSANAAN</th>
                                <th>STATUS</th>
                                <th style="min-width:100px;">AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

      {{-- Modal Slide --}}
      <div class="offcanvas offcanvas-end" tabindex="-1" id="modalSlide" aria-labelledby="offcanvasAddUserLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Filter Berdasarkan</h5>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
            <form class="add-new-user pt-0" id="filter">
                <div class="col-12 mb-2">
                    <div class="row">
                        <div class="mb-2">
                            <label for="jenis" class="form-label">Jenis Seleksi</label>
                            <select class="form-control select2" data-placeholder="Pilih Jenis Seleksi">
                                <option value="Seleksi Tahap 1">Seleksi Tahap 1</option>
                                <option value="Seleksi Tahap 2">Seleksi Tahap 2</option>
                                <option value="Seleksi Tahap 3">Seleksi Tahap 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2">
                            <label for="pelaksanaan" class="form-label">Pelaksanaan Seleksi</label>
                            <select class="form-select select2" id="pelaksanaan" name="pelaksanaan"
                                data-placeholder="Pilih Pelaksanaan Seleksi">
                                <option value="Onsite">Onsite</option>
                                <option value="Online">Online</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <label for="mulai" class="form-label">Tanggal Seleksi Mulai</label>
                            <input class="form-control" type="date" value="0000-00-00" id="mulai">
                        </div>
                        <div class="col-6 mb-2">
                            <label for="pelaksanaan" class="form-label">Tanggal Seleksi Akhir</label>
                            <input class="form-control" type="date" value="0000-00-00" id="mulai">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2">
                            <label for="seleksi" class="form-label">Status Seleksi</label>
                            <select class="form-select select2" id="seleksi" name="seleksi"
                                data-placeholder="Pilih Status Seleksi">
                                <option value="Sudah Seleksi Tahap 1">Sudah Seleksi Tahap 1</option>
                                <option value="Belum Seleksi Tahap 1">Belum Seleksi Tahap 1</option>
                                <option value="Sudah Seleksi Tahap 2">Sudah Seleksi Tahap 2</option>
                                <option value="Belum Seleksi Tahap 2">Belum Seleksi Tahap 2</option>
                                <option value="Sudah Seleksi Tahap 3">Sudah Seleksi Tahap 3</option>
                                <option value="Belum Seleksi Tahap 3">Belum Seleksi Tahap 3</option>
                            </select>
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
    
    {{-- Modal CV Onsite --}}
    <div class="modal fade" id="modalCV" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header d-block border-bottom">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="modal-title">Jadwal Seleksi Tahap 1</h5>
                        <button for="upload"
                            class="btn btn-outline-success waves-effect me-2 mb-3 waves-effect waves-light" tabindex="0">
                            <i class="ti ti-download d-block pe-2"></i>
                            <span class="d-none d-sm-block">Unduh CV</span>
                            <input type="file" id="upload" class="account-file-input" hidden=""
                                accept="image/png, image/jpeg">
                        </button>
                    </div>
                </div>
                <form class="default-form">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4 mt-2 border-end">
                                <div class="text-center border-bottom pb-2">
                                    <img src="../../app-assets/img/avatars/14.png" alt="user image"
                                        class="rounded user-profile-img mb-2" width="70px">
                                    <h4 class="mb-1">John Doe</h4>
                                    <span>UX Designer</span>
                                </div>
                                <div class="mt-3 ms-4">
                                    <p class="card-text text-uppercase">Biodata Singkat</p>
                                    <div class="row">
                                        <div class="col-5">
                                            <span class="fw-bold">Universitas:</span>
                                        </div>
                                        <div class="col-7">
                                            <span>Universitas Telkom</span><br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <span class="fw-bold">Fakultas:</span>
                                        </div>
                                        <div class="col-7">
                                            <span>Ilmu Terapan</span><br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <span class="fw-bold">Jurusan:</span>
                                        </div>
                                        <div class="col-7">
                                            <span>Sistem Informasi</span><br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <span class="fw-bold">Jenjang:</span>
                                        </div>
                                        <div class="col-7">
                                            <span>S1</span><br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <span class="fw-bold">IPK:</span>
                                        </div>
                                        <div class="col-7">
                                            <span>3.77/4.0</span><br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <span class="fw-bold">Semester:</span>
                                        </div>
                                        <div class="col-7">
                                            <span>5</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <div class="col-6 ms-4">
                                    <span class="text-secondary">Jenis Seleksi</span>
                                    <p class="fw-bold mt-1">Seleksi Tahap 1</p>
                                </div>
                                <div class="col-8 ms-4">
                                    <span class="text-secondary">Jadwal Seleksi Mulai</span>
                                    <p class="fw-bold mt-1">Selasa, 30 Juli 2023, 08.00</p>
                                </div>
                                <div class="col-6 ms-4">
                                    <span class="text-secondary">Tempat Pelaksanaan</span>
                                    <p class="fw-bold mt-1">Gedung Merah Putih Interview Room Lt.15</p>
                                </div>
                                <div class="col-6 ms-4">
                                    <span class="text-secondary">Respon Kandidat</span>
                                    <span class="badge bg-label-success mt-1">Approved</span>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <div class="col-6">
                                    <span class="text-secondary">Jenis Pelaksanaan</span>
                                    <p class="fw-bold mt-1">Onsite</p>
                                </div>
                                <div class="col-6">
                                    <span class="text-secondary">Jadwal Seleksi Berakhir</span>
                                    <p class="fw-bold mt-1">Rabu, 31 Juli 2023, 23.59</p>
                                </div>
                                <div class="col-8">
                                    <span class="text-secondary">Penanggungjawab Seleksi</span>
                                    <p class="fw-bold mt-1">Kadavi Bagaskara</p>
                                </div>
                                <div class="col-8">
                                    <span class="text-secondary">Status Seleksi</span>
                                    <div class="mt-2">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="customCheckTemp4" disabled>
                                        <span class="custom-option-headear">Sudah Seleksi Tahap 1</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal CV Online --}}
    <div class="modal fade" id="modalCVOnline" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header d-block border-bottom">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="modal-title">Jadwal Seleksi Tahap 1</h5>
                        <button for="upload"
                            class="btn btn-outline-success waves-effect me-2 mb-3 waves-effect waves-light"
                            tabindex="0">
                            <i class="ti ti-download d-block pe-2"></i>
                            <span class="d-none d-sm-block">Unduh CV</span>
                            <input type="file" id="upload" class="account-file-input" hidden=""
                                accept="image/png, image/jpeg">
                        </button>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="default-form">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4 mt-2 border-end">
                                <div class="text-center border-bottom pb-2">
                                    <img src="../../app-assets/img/avatars/14.png" alt="user image"
                                        class="rounded user-profile-img mb-2" width="70px">
                                    <h4 class="mb-1">John Doe</h4>
                                    <span>UX Designer</span>
                                </div>
                                <div class="mt-3 ms-4">
                                    <p class="card-text text-uppercase">Biodata Singkat</p>
                                    <div class="row">
                                        <div class="col-5">
                                            <span class="fw-bold">Universitas:</span>
                                        </div>
                                        <div class="col-7">
                                            <span>Universitas Telkom</span><br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <span class="fw-bold">Fakultas:</span>
                                        </div>
                                        <div class="col-7">
                                            <span>Ilmu Terapan</span><br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <span class="fw-bold">Jurusan:</span>
                                        </div>
                                        <div class="col-7">
                                            <span>Sistem Informasi</span><br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <span class="fw-bold">Jenjang:</span>
                                        </div>
                                        <div class="col-7">
                                            <span>S1</span><br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <span class="fw-bold">IPK:</span>
                                        </div>
                                        <div class="col-7">
                                            <span>3.77/4.0</span><br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <span class="fw-bold">Semester:</span>
                                        </div>
                                        <div class="col-7">
                                            <span>5</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <div class="col-6 ms-4">
                                    <span class="text-secondary">Jenis Seleksi</span>
                                    <p class="fw-bold mt-1">Seleksi Tahap 1</p>
                                </div>
                                <div class="col-6 ms-4">
                                    <span class="text-secondary">Jadwal Seleksi Mulai</span>
                                    <p class="fw-bold mt-1">Selasa, 30 Juli 2023, 08.00</p>
                                </div>
                                <div class="col-6 ms-4">
                                    <span class="text-secondary">Tempat Pelaksanaan</span>
                                    <p class="fw-bold mt-1">https://zoom.us/test</p>
                                </div>
                                <div class="col-6 ms-4">
                                    <span class="text-secondary">Respon Kandidat</span>
                                    <span class="badge bg-label-success mt-1">Approved</span>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <div class="col-6">
                                    <span class="text-secondary">Jenis Pelaksanaan</span>
                                    <p class="fw-bold mt-1">Onsite</p>
                                </div>
                                <div class="col-6">
                                    <span class="text-secondary">Jadwal Seleksi Berakhir</span>
                                    <p class="fw-bold mt-1">Rabu, 31 Juli 2023, 23.59</p>
                                </div>
                                <div class="col-8">
                                    <span class="text-secondary">Penanggungjawab Seleksi</span>
                                    <p class="fw-bold mt-1">Kadavi Bagaskara</p>
                                </div>
                                <div class="col-6">
                                    <span class="text-secondary">Status Seleksi</span>
                                    <span class="badge bg-label-info mt-1">Sudah Interview</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page_script')
    <script src="../../app-assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
    <script src="../../app-assets/js/forms-extras.js"></script>

    <script>
        var jsonData = [{
                "nomor": "1",
                "nama": "<span class='fw-bold'>Andika Alatas</span> <br> 6701228083",
                "tanggal": "<span class='text-secondary'>Mulai</span><br>20 Juli 2023<br><span class='text-secondary'>Berakhir</span><br>22 Juli 2023",
                "waktu": "<span class='text-secondary'>Jam Dimulai</span><br>08.00<br><span class='text-secondary'>Jam Berakhir</span><br>23.59",
                "jenis": "Seleksi Tahap 1",
                "pelaksanaan": "Online",
                "status": "<span class='badge bg-label-success me-1'>Sudah Seleksi</span>",
                "aksi": "<a data-bs-toggle='modal' data-bs-target='#modalCVOnline' class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-file-invoice' ></i>"
            },
            {
                "nomor": "2",
                "nama": "<span class='fw-bold'>Andika Alatas</span> <br> 6701228083",
                "tanggal": "<span class='text-secondary'>Mulai</span><br>20 Juli 2023<br><span class='text-secondary'>Berakhir</span><br>22 Juli 2023",
                "waktu": "<span class='text-secondary'>Jam Dimulai</span><br>08.00<br><span class='text-secondary'>Jam Berakhir</span><br>23.59",
                "jenis": "Seleksi Tahap 1",
                "pelaksanaan": "Onsite",
                "status": "<span class='badge bg-label-secondary me-1'>Belum Seleksi</span>",
                "aksi": "<a data-bs-toggle='modal' data-bs-target='#modalCV' class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-file-invoice' ></i>"
            },
            {
                "nomor": "3",
                "nama": "<span class='fw-bold'>Andika Alatas</span> <br> 6701228083",
                "tanggal": "<span class='text-secondary'>Mulai</span><br>20 Juli 2023<br><span class='text-secondary'>Berakhir</span><br>22 Juli 2023",
                "waktu": "<span class='text-secondary'>Jam Dimulai</span><br>08.00<br><span class='text-secondary'>Jam Berakhir</span><br>23.59",
                "jenis": "Seleksi Tahap 1",
                "pelaksanaan": "Onsite",
                "status": "<span class='badge bg-label-success me-1'>Sudah Seleksi</span>",
                "aksi": "<a data-bs-toggle='modal' data-bs-target='#modalCVOnline' class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-file-invoice' ></i>"

            }
        ];
        var table = $('#table-jadwal-seleksi').DataTable({
            "data": jsonData,
            columns: [{
                    data: "nomor"
                },
                {
                    data: "nama"
                },
                {
                    data: "tanggal"
                },
                {
                    data: "waktu"
                },
                {
                    data: "jenis"
                },
                {
                    data: "pelaksanaan"
                },
                {
                    data: "status"
                },
                {
                    data: "aksi"
                }
            ],
            // columnDefs: [{
            //         // For Responsive
            //         className: 'control',
            //         orderable: false,
            //         searchable: false,
            //         responsivePriority: 2,
            //         targets: 0,
            //         render: function(data, type, full, meta) {
            //             return '';
            //         }
            //     },
            //     {
            //         targets: 1,
            //         orderable: false,
            //         searchable: false,
            //         responsivePriority: 3,
            //     },
            // ]
        });
    </script>


    <script src="../../app-assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="../../app-assets/js/extended-ui-sweetalert2.js"></script>
@endsection
