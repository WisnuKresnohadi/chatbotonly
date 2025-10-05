@extends('partials_admin.template')

@section('page_style')
<link rel="stylesheet" href="../../app-assets/vendor/libs/sweetalert2/sweetalert2.css" />
<style>
</style>
@endsection

@section('main')
<div class="row">
    <div class="col-md-9 col-12">
        <h4 class="fw-bold">Anggota Tim</h4>
    </div>
    <div class="col-md-12 d-flex justify-content-end align-items-center mb-4">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahAnggota">
            <div class="d-flex align-items-center">
                <i class="tf-icons ti ti-plus me-2"></i>
                <span class="mt-1">Tambah Anggota</span>
            </div>
        </button>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table" id="table-anggota-tim">
                    <thead>
                        <tr>
                            <th>NOMOR</th>
                            <th>NAMA</th>
                            <th>EMAIL</th>
                            <th>TELEPON</th>
                            <th>ROLE</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalTambahAnggota" tabindex="-1" aria-hidden="true">
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
                    <!-- <div class="col-12 mb-3">
                        <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                        <input type="text" id="nameWithTitle" class="form-control" placeholder="Masukkan Password" />
                    </div> -->
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
</div>

<!-- Modal -->
<div class="modal fade" id="modalEditAnggota" tabindex="-1" aria-hidden="true">
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
                    <!-- <div class="col-12 mb-3">
                        <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                        <input type="text" id="nameWithTitle" class="form-control" placeholder="Masukkan Password" />
                    </div> -->
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
</div>

@endsection

@section('page_script')
<script src="../../app-assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
<script src="../../app-assets/js/forms-extras.js"></script>

<script>
    var jsonData = [{
            "nomor": "1",
            "nama": "Arvin  Bagaskara",
            "email": "arvinbgskr@gmail.com",
            "telepon": "+6281298076589",
            "role": "Pembimbing Lapangan",
            "aksi": "<a data-bs-toggle='modal' data-bs-target='#modalEditAnggota' class='btn-icon text-warning waves-effect waves-light'><i class='tf-icons ti ti-edit' ></i><a onclick = active($(this))  class='btn-icon text-danger waves-effect waves-light'><i class='tf-icons ti ti-circle-x'></i></a>"
        },
        {
            "nomor": "2",
            "nama": "Kadavi Wijaya Saputra",
            "email": "kdviws@gmail.com",
            "telepon": "+6281298076589",
            "role": "Pembimbing Lapangan",
            "aksi": "<a data-bs-toggle='modal' data-bs-target='#modalEditAnggota' class='btn-icon text-warning waves-effect waves-light'><i class='tf-icons ti ti-edit' ></i><a onclick = active($(this))  class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-circle-check'></i></a>"
        },
        {
            "nomor": "3",
            "nama": "Kevin Nathaniel ",
            "email": "kevnath@gmail.com",
            "telepon": "+6281298076589",
            "role": "Pembimbing Lapangan",
            "aksi": "<a data-bs-toggle='modal' data-bs-target='#modalEditAnggota' class='btn-icon text-warning waves-effect waves-light'><i class='tf-icons ti ti-edit' ></i><a onclick = active($(this))  class='btn-icon text-danger waves-effect waves-light'><i class='tf-icons ti ti-circle-x'></i></a>"
        }
    ];
    var table = $('#table-anggota-tim').DataTable({
        "data": jsonData,
        columns: [{
                data: "nomor"
            },
            {
                data: "nama"
            },
            {
                data: "email"
            },
            {
                data: "telepon"
            },
            {
                data: "role"
            },
            {
                data: "aksi"
            }
        ],
        drawCallback: function () {
            $('[data-bs-toggle="tooltip"]').tooltip();
        },
    });
</script>


<script src="../../app-assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script src="../../app-assets/js/extended-ui-sweetalert2.js"></script>
@endsection