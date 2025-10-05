@extends('partials_admin.template')

@section('page_style')
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/tagify/tagify.css') }}" />
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: #4EA971;
    }

    .light-style .tagify__tag .tagify__tag-text {
        color: #4EA971 !important;
    }
</style>
@endsection

@section('main')
<div class="row pe-2 ps-2">
    <div class="col-md-9 col-12">
        <h4 class="fw-bold text-sm"><span class="text-muted fw-light text-xs">Data Mahasiswa Magang / </span>
            Mahasiswa Magang Mandiri Tahun Ajaran 2023/2024
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

    <div class="nav-align-top">
        <div class="row">
            <div class="col-6">
                <ul class="nav nav-pills mb-3 " role="tablist">
                    <li class="nav-item" style="font-size: small;">
                        <button type="button" class="nav-link active showSingle" target="1" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-diterima" aria-controls="navs-pills-justified-diterima" aria-selected="false" style="padding: 8px 9px;">
                            <i class="tf-icons ti ti-user-check ti-xs me-1"></i> Diterima
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 ms-1" style="background-color: #DCEEE3; color: #4EA971;"></span>
                        </button>
                    </li>
                    <li class="nav-item" style="font-size: small;">
                        <button type="button" class="nav-link showSingle" target="0" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-ditolak" aria-controls="navs-pills-justified-ditolak" aria-selected="false" style="padding: 8px 9px;">
                            <i class="tf-icons ti ti-user-x ti-xs me-1"></i> Ditolak
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 ms-1" style="background-color: #DCEEE3; color: #4EA971;"></span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-12 ">
                <div class="text-secondary mt-3 mb-3 ">Filter Berdasarkan : <i class='tf-icons ti ti-alert-circle text-primary pb-1' data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Prodi:D3 Sistem Informasi" id="tooltip-filter"></i></div>
            </div>
        </div>
    </div>

    <div class="tab-content p-0">
        <div class="tab-pane fade show active" id="navs-pills-justified-diterima" role="tabpanel">
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="table table-diterima" id="table-diterima" name="1">
                        <thead>
                            <tr>
                                <th style="min-width: 50px;">NOMOR</th>
                                <th style="min-width: 150px;">NAMA/NIM</th>
                                <th style="min-width: 200px;">PROGRAM STUDI</th>
                                <th style="min-width: 200px;">NAMA PERUSAHAAN</th>
                                <th style="min-width: 150px;">POSISI MAGANG</th>
                                <th style="min-width: 200px;">TANGGAL MAGANG</th>
                                <th style="min-width: 170px;">DOKUMEN</th>
                                <th style="min-width: 200px;">PEMBIMBING LAPANGAN</th>
                                <th style="min-width: 200px;">PEMBIMBING AKADEMIK</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade show" id="navs-pills-justified-ditolak" role="tabpanel">
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="table table-ditolak" id="table-ditolak" name="2">
                        <thead>
                            <tr>
                                <th style="min-width: 50px;">NOMOR</th>
                                <th style="min-width: 150px;">NAMA/NIM</th>
                                <th style="min-width: 200px;">PROGRAM STUDI</th>
                                <th style="min-width: 200px;">NAMA PERUSAHAAN</th>
                                <th style="min-width: 150px;">POSISI MAGANG</th>
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
                        <label for="nama/nim" class="form-label">Program Studi</label>
                        <select class="form-select select2" id="prodi" name="prodi" data-placeholder="Pilih Program Studi">
                            <option value="">Pilih Program Studi</option>
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

<!-- <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="modal-title" id="modalTambah">Assign Dosen Pembimbing Akademik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-2">
                        <label for="TagifyBasic1" class="form-label">Nama Dosen Pembimbing Akademik<span style="color: red;">*</span></label>
                        <input id="TagifyBasic1" class="form-control" name="TagifyBasic1" value="" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalalert">Simpan</button>
            </div>
        </div>
    </div>
</div> -->

<!-- Modal Alert-->
<!-- <div class="modal fade" id="modalalert" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="../../app-assets/img/alert.png" alt="">
                <h5 class="modal-title" id="modal-title">Apakah anda yakin ingin menetapkan dosen pembimbing akademik?</h5>
            </div>
            <div class="modal-footer" style="display: flex; justify-content:center;">
                <button type="submit" id="modal-button" class="btn btn-success">Ya, yakin</button>
                <button type="submit" id="modal-button" class="btn btn-danger">Batal</button>
            </div>
        </div>
    </div>
</div> -->

@endsection

@section('page_script')
<script src="{{ asset('app-assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
<script src="{{ asset('app-assets/js/forms-extras.js') }}"></script>
<script>
    $('#table-diterima').each(function() {
        let idElement = $(this).attr('name');
        let url = `{{ url('/data-mahasiswa-magang/magang-mandiri/show/') }}?type=` + idElement;
        // console.log('idelement: ' + idElement);

        $(this).DataTable({

            ajax: url,
            scrollX: true,
            type: 'GET',
            columns: [{
                    data: "DT_RowIndex"
                },
                {
                    data: null,
                    name: 'combined_column',
                    render: function(data, type, row) {
                        return data.mahasiswa.namamhs + '<br>' + (data.mahasiswa.nim);
                    }
                },
                {
                    data: function(data, type, row) {
                        return data.mahasiswa.prodi.namaprodi;
                    },
                    name: 'prodi'
                },
                {
                    data: function(data, type, row) {
                        return data.nama_industri;
                    },
                    name: 'nama_perusahaan'
                },
                {
                    data: function(data, type, row) {
                        return data.posisi_magang;
                    },
                    name: 'posisi_magang'
                },
                {
                    data: 'tgl_magang',
                    name: "tanggal_magang"
                },
                {
                    data: 'doc_terima',
                    name: 'doc_magang'
                },
                {
                    data: null,
                    name: 'pbb_lapangan',
                    render: function(data, type, row) {
                        console.log(data);
                        if (data.mahasiswa_mandiri.id_pbb) {
                            return data.mahasiswa_mandiri.pbb.nama + '<br>' + (data.mahasiswa_mandiri.pbb.nip);
                        }
                        return '-';
                    },
                },
                {
                    data: null,
                    name: 'pbb_akademik',
                    render: function(data, type, row) {
                        if (data.mahasiswa_mandiri.nip) {
                            return data.mahasiswa_mandiri.dosen.namadosen + '<br>' + (data.mahasiswa_mandiri.dosen.nip);
                        }
                        return '-';
                    },
                }
            ],
            "columnDefs": [{
                    "width": "10px",
                    "targets": 0
                },
                {
                    "width": "170px",
                    "targets": 1
                },
                {
                    "width": "150px",
                    "targets": 2
                },
                {
                    "width": "170px",
                    "targets": 3
                },
                {
                    "width": "170px",
                    "targets": 4
                },
                {
                    "width": "200px",
                    "targets": 5
                },
                {
                    "width": "150px",
                    "targets": 6
                },
                {
                    "width": "200px",
                    "targets": 7
                },
                {
                    "width": "200px",
                    "targets": 8
                }
            ],
        });
    });

    $('#table-ditolak').each(function() {
        let idElement = $(this).attr('name');
        let url = `{{ url('/data-mahasiswa-magang/magang-mandiri/show/') }}?type=` + idElement;

        $(this).DataTable({

            ajax: url,
            type: 'GET',
            columns: [{
                    data: "DT_RowIndex"
                },
                {
                    data: null,
                    name: 'combined_column',
                    render: function(data, type, row) {
                        return data.mahasiswa.namamhs + '<br>' + (data.mahasiswa.nim);
                    }
                },
                {
                    data: function(data, type, row) {
                        return data.mahasiswa.prodi.namaprodi;
                    },
                    name: 'prodi'
                },
                {
                    data: function(data, type, row) {
                        return data.nama_industri;
                    },
                    name: 'nama_perusahaan'
                },
                {
                    data: function(data, type, row) {
                        return data.posisi_magang;
                    },
                    name: 'posisi_magang'
                }
            ],
            "columnDefs": [{
                    "width": "10px",
                    "targets": 0
                },
                {
                    "width": "170px",
                    "targets": 1
                },
                {
                    "width": "200px",
                    "targets": 2
                },
                {
                    "width": "200px",
                    "targets": 3
                },
                {
                    "width": "170px",
                    "targets": 4
                }
            ],
        });
    });

    jQuery(function() {
        jQuery('.showSingle').click(function() {
            jQuery('.targetDiv').hide('.cnt');
            jQuery('#div' + $(this).attr('target')).slideToggle();
        });
    });
</script>

<script src="{{ asset('app-assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('app-assets/js/extended-ui-sweetalert2.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/tagify/tagify.js') }}"></script>
<script src="{{ asset('app-assets/js/forms-tagify.js') }}"></script>
@endsection