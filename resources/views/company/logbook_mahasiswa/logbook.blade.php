@extends('partials_admin.template')

@section('page_style')
<link rel="stylesheet" href="../../app-assets/vendor/libs/sweetalert2/sweetalert2.css" />
<link rel="stylesheet" href="../../app-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="../../app-assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="../../app-assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
<link rel="stylesheet" href="../../app-assets/vendor/libs/pickr/pickr-themes.css" />
<link rel="stylesheet" href="../../app-assets/vendor/libs/flatpickr/flatpickr.css" />
<style>
</style>
@endsection

@section('main')
<div class="row">
    <div class="col-9">
        <h4 class="fw-bold">Logbook Mahasiswa Periode 24 April - 11 Mei 2023</h4>
    </div>
    <div class="col-3 pe-2 ms-4" style="width: 22%;">
        <input type="text" class="form-control flatpickr-input active" placeholder="YYYY-MM-DD to YYYY-MM-DD" id="flatpickr-range" readonly="readonly">
    </div>
    <div class="col-2 mb-3">
        <select class="select2 form-select" data-placeholder="Filter Status">
            <option value="0" disabled>Filter Status</option>
            <option value="1">Disetujui</option>
            <option value="2">Ditolak</option>
            <option value="3">Belum Disetujui</option>
        </select>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table" id="table-logbook">
                    <thead>
                        <tr>
                            <th>NOMOR</th>
                            <th>NAMA</th>
                            <th>POSISI</th>
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

<!-- Modal -->
<!-- <div class="modal fade" id="modalTambahAnggota" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahAnggotaTitle">Tambah Anggota Tim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="nama" class="form-label">Nama Anggota<span class="text-danger">*</span></label>
                        <input type="text" id="nameWithTitle" class="form-control" placeholder="Masukkan Nama Anggota" />
                    </div>
                    <div class="col-12 mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" id="nameWithTitle" class="form-control" placeholder="Masukkan No Telepon" />
                    </div>
                    <div class="col-12 mb-3">
                        <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                        <input type="text" id="nameWithTitle" class="form-control" placeholder="Masukkan Email" />
                    </div>
                    <div class="col-12 mb-3">
                        <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                        <input type="text" id="nameWithTitle" class="form-control" placeholder="Masukkan Password" />
                    </div>
                </div>

                <div class="row">
                    <div class="col form-input">
                        <label for="role" class="form-label">Role<span class="text-danger">*</span></label>
                        <select class="form-select select2" id="role" name="durasimagang" data-placeholder="Pilih Role">
                            <option disabled selected>Pilih Role</option>
                            <option value="1">Pembimbing Lapangan</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success text-left">Simpan Data</button>
            </div>
        </div>
    </div>
</div> -->

<!-- Modal -->
<!-- <div class="modal fade" id="modalEditAnggota" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditAnggotaTitle">Edit Anggota Tim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="nama" class="form-label">Nama Anggota<span class="text-danger">*</span></label>
                        <input type="text" id="nameWithTitle" class="form-control" placeholder="Masukkan Nama Anggota" />
                    </div>
                    <div class="col-12 mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" id="nameWithTitle" class="form-control" placeholder="Masukkan No Telepon" />
                    </div>
                    <div class="col-12 mb-3">
                        <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                        <input type="text" id="nameWithTitle" class="form-control" placeholder="Masukkan Email" />
                    </div>
                    <div class="col-12 mb-3">
                        <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                        <input type="text" id="nameWithTitle" class="form-control" placeholder="Masukkan Password" />
                    </div>
                </div>

                <div class="row">
                    <div class="col form-input">
                        <label for="role" class="form-label">Role<span class="text-danger">*</span></label>
                        <select class="form-select select2" id="role" name="durasimagang" data-placeholder="Pilih Role">
                            <option disabled selected>Pilih Role</option>
                            <option value="1">Pembimbing Lapangan</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success text-left">Simpan Data</button>
            </div>
        </div>
    </div>
</div> -->

@endsection

@section('page_script')
<script src="../../app-assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
<script src="../../app-assets/js/forms-extras.js"></script>

<script>
    var jsonData = [{
            "nomor": "1",
            "nama": "Arvin  Bagaskara",
            "posisi": "UI/UX Design",
            "durasi": "2 Semester",
            "status": "<span class='badge bg-label-success'>Disetujui</span>",
            "aksi": "<a href='/logbook/detail' class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-file-text' ></i>"
        },
        {
            "nomor": "2",
            "nama": "Kadavi Wijaya Saputra",
            "posisi": "UI/UX Design",
            "durasi": "2 Semester",
            "status": "<span class='badge bg-label-danger'>Ditolak</span>",
            "aksi": "<a href='/logbook/detail' class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-file-text' ></i>"
        },
        {
            "nomor": "3",
            "nama": "Kevin Nathaniel ",
            "posisi": "UI/UX Design",
            "durasi": "2 Semester",
            "status": "<span class='badge bg-label-warning'>Belum Disetujui</span>",
            "aksi": "<a href='/logbook/detail' class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-file-text' ></i>"
        }
    ];
    var table = $('#table-logbook').DataTable({
        "data": jsonData,
        columns: [{
                data: "nomor"
            },
            {
                data: "nama"
            },
            {
                data: "posisi"
            },
            {
                data: "durasi"
            },
            {
                data: "status"
            },
            {
                data: "aksi"
            }
        ],
    });
</script>

<script src="../../app-assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script src="../../app-assets/js/extended-ui-sweetalert2.js"></script>
<script src="../../app-assets/vendor/libs/flatpickr/flatpickr.js"></script>
<script src="../../app-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="../../app-assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
<script src="../../app-assets/vendor/libs/jquery-timepicker/jquery-timepicker.js"></script>
<script src="../../app-assets/vendor/libs/pickr/pickr.js"></script>
<script src="../../app-assets/js/forms-pickers.js"></script>

@endsection