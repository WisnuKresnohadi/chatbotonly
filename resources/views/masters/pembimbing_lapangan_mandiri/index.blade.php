@extends('partials.vertical_menu')

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

    .trash-icon {
        border: 2px solid red;
        border-radius: 5px;
        padding: 3px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-11 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Pembimbing Lapangan</h4>
    </div>
    <div id="div1" class="col-md-1 col-12 targetDiv" style="display: none;">
        <button class="btn btn-success waves-effect waves-light" data-bs-toggle="offcanvas" data-bs-target="#modalSlide"><i class="tf-icons ti ti-filter"></i>
        </button>
    </div>
    <div id="div2" class="col-md-4 col-12 targetDiv" style="display: none;">
        <div class="text-secondary mt-3 mb-3 ">Filter Berdasarkan : <i class='tf-icons ti ti-alert-circle text-primary pb-1' data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="All Status" id="tooltip-filter"></i></div>
    </div>
</div>

<div class="nav-align-top">
    <div class="row">
        <div class="col-6">
            <ul class="nav nav-pills mb-3 " role="tablist">
                <li class="nav-item" style="font-size: small;">
                    <button type="button" class="nav-link showSingle active " target="0" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-tertunda" aria-controls="navs-pills-justified-tertunda" aria-selected="false" style="padding: 8px 9px;">
                        <i class="tf-icons ti ti-clock ti-xs me-1"></i> Menunggu Persetujuan
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 ms-1" style="background-color: #DCEEE3; color: #4EA971;"></span>
                    </button>
                </li>
                <li class="nav-item" style="font-size: small;">
                    <button type="button" class="nav-link showSingle" target="1,2" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-diterima" aria-controls="navs-pills-justified-diterima" aria-selected="false" style="padding: 8px 9px;">
                        <i class="tf-icons ti ti-clipboard-check ti-xs me-1"></i> Diterima
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 ms-1" style="background-color: #DCEEE3; color: #4EA971;"></span>
                    </button>
                </li>
                <li class="nav-item" style="font-size: small;">
                    <button type="button" class="nav-link showSingle" target="0" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-ditolak" aria-controls="navs-pills-justified-ditolak" aria-selected="false" style="padding: 8px 9px;">
                        <i class="tf-icons ti ti-clipboard-x ti-xs me-1"></i> Ditolak
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 ms-1" style="background-color: #DCEEE3; color: #4EA971;"></span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="tab-content p-0">
    <div class="tab-pane fade show active" id="navs-pills-justified-tertunda" role="tabpanel">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table table-tertunda" id="table-tertunda">
                    <thead>
                        <tr>
                            <th>NOMOR</th>
                            <th>NAMA PEMBIMBING LAPANGAN</th>
                            <th>NIP</th>
                            <th>JABATAN</th>
                            <th>EMAIL</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade show" id="navs-pills-justified-diterima" role="tabpanel">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table table-diterima" id="table-diterima">
                    <thead>
                        <tr>
                            <th>NOMOR</th>
                            <th style="min-width:160px;">NAMA PEMBIMBING LAPANGAN</th>
                            <th>NIP</th>
                            <th>JABATAN</th>
                            <th>EMAIL</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade show" id="navs-pills-justified-ditolak" role="tabpanel">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table table-ditolak" id="table-ditolak">
                    <thead>
                        <tr>
                            <th>NOMOR</th>
                            <th style="min-width:160px;">NAMA PEMBIMBING LAPANGAN</th>
                            <th>NIP</th>
                            <th>JABATAN</th>
                            <th>EMAIL</th>
                        </tr>
                    </thead>
                </table>
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
                        <label for="nama" class="form-label">Status</label>
                        <select class="form-select select2" id="status" name="status" data-placeholder="Pilih Status">
                            <option value="">Pilih Status</option>
                            <option value="1">Aktif</option>
                            <option value="2">Non-Aktif</option>
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

<!-- modal -->
<div class="modal fade" id="modalTolak" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title" id="modalTolak">Alasan Penolakan Data Pembimbing Lapangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label for="TagifyBasic1" class="form-label">Alasan Penolakan Pembimbing Lapangan<span style="color: red;">*</span></label>
                        <textarea id="" class="form-control" placeholder="Masukkan alasan penolakan"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger">Batal</button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Alert-->
<div class="modal fade" id="modalalertsetuju" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="../../app-assets/img/alert.png" alt="">
                <h5 class="modal-title" id="modal-title">Apakah anda yakin ingin menyetujui data pembimbing lapangan?</h5>
                <p>Data terpilih akan secara otomatis berpindah ke tab disetujui!</p>
            </div>
            <div class="modal-footer" style="display: flex; justify-content:center;">
                <button type="submit" id="modal-button" class="btn btn-success">Ya, yakin</button>
                <button type="submit" id="modal-button" class="btn btn-danger">Batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalalertstatus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="../../app-assets/img/alert.png" alt="">
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

@endsection

@section('page_script')
<script>
    var jsonData = [{
            "nomor": "1",
            "nama_pembimbing": "Jennie Ruby Jane",
            "nip": "12345",
            "jabatan": "CEO",
            "email": "Jennie123@gmail.com",
            "aksi": "<a data-bs-toggle='modal' data-bs-target='#modalalertsetuju' class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-file-check'></i></a><a data-bs-toggle='modal' data-bs-target='#modalTolak' class='btn-icon text-danger waves-effect waves-light'><i class='tf-icons ti ti-file-x'></i></a>",
        },
        {
            "nomor": "2",
            "nama_pembimbing": "Jennie Ruby Jane",
            "nip": "12345",
            "jabatan": "CEO",
            "email": "Jennie123@gmail.com",
            "aksi": "<a data-bs-toggle='modal' data-bs-target='#modalalertsetuju' class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-file-check'></i></a><a data-bs-toggle='modal' data-bs-target='#modalTolak' class='btn-icon text-danger waves-effect waves-light'><i class='tf-icons ti ti-file-x'></i></a>",
        },
    ];

    var table = $('#table-tertunda').DataTable({
        "data": jsonData,
        columns: [{
                data: "nomor"
            },
            {
                data: "nama_pembimbing"
            },
            {
                data: "nip"
            },
            {
                data: "jabatan"
            },
            {
                data: "email"
            },
            {
                data: "aksi"
            }
        ]
    });

    var jsonData = [{
            "nomor": "1",
            "nama_pembimbing": "Jennie Ruby Jane",
            "nip": "12345",
            "jabatan": "CEO",
            "email": "Jennie123@gmail.com",
            "status": "<span class='badge bg-label-success'>Aktif</span>",
            "aksi": "<a data-bs-toggle='modal' data-bs-target='#modalalertstatus'  class='btn-icon text-danger waves-effect waves-light'><i class='tf-icons ti ti-circle-x'></i></a>",
        },
        {
            "nomor": "2",
            "nama_pembimbing": "Jennie Ruby Jane",
            "nip": "12345",
            "jabatan": "CEO",
            "email": "Jennie123@gmail.com",
            "status": "<span class='badge bg-label-danger'>Non-Aktif</span>",
            "aksi": "<a data-bs-toggle='modal' data-bs-target='' class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-circle-check'></i></a>",
        },
    ];

    var table = $('#table-diterima').DataTable({
        "data": jsonData,
        columns: [{
                data: "nomor"
            },
            {
                data: "nama_pembimbing"
            },
            {
                data: "nip"
            },
            {
                data: "jabatan"
            },
            {
                data: "email"
            },
            {
                data: "status"
            },
            {
                data: "aksi"
            }
        ]
    });

    var jsonData = [{
            "nomor": "1",
            "nama_pembimbing": "Jennie Ruby Jane",
            "nip": "12345",
            "jabatan": "CEO",
            "email": "Jennie123@gmail.com",
        },
        {
            "nomor": "2",
            "nama_pembimbing": "Jennie Ruby Jane",
            "nip": "12345",
            "jabatan": "CEO",
            "email": "Jennie123@gmail.com",
        },
    ];

    var table = $('#table-ditolak').DataTable({
        "data": jsonData,
        columns: [{
                data: "nomor"
            },
            {
                data: "nama_pembimbing"
            },
            {
                data: "nip"
            },
            {
                data: "jabatan"
            },
            {
                data: "email"
            }
        ]
    });

    // jQuery(function() {
    //     jQuery('.showSingle').click(function() {
    //         jQuery('.targetDiv').hide('.cnt');
    //         jQuery('#div' + $(this).attr('target')).slideToggle();
    //     });
    // });
    
    jQuery(function() {
        jQuery('.showSingle').click(function() {
            var tabTarget = $(this).attr('target');
            jQuery('.targetDiv').hide();
            if (tabTarget === "0") {
                jQuery('#div0').hide();
            } else {
                var targets = tabTarget.split(",");
                targets.forEach(function(target) {
                    jQuery('#div' + target).show();
                });
            }
        });
    });
</script>
<script src="../../app-assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script src="../../app-assets/js/extended-ui-sweetalert2.js"></script>
<script src="../../app-assets/js/forms-extras.js"></script>
<script src="../../app-assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
@endsection