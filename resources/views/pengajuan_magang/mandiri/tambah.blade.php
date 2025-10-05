@extends('partials_mahasiswa.template')
@section('page_style')
<style>
    .bs-stepper .step.active .bs-stepper-circle {
        background-color: #4EA971 !important;
    }

    #repeater-form {
        display: none;
    }

    .flatpickr-wrapper {
        display: block;
    }
</style>
@endsection

@section('main')
<div class="container-xxl flex-grow-1 container-p-y">
    <a href="/pengajuan/surat" type="button" class="btn btn-outline-success mt-4 mb-3 waves-effect">
        <span class="ti ti-arrow-left me-2"></span>Kembali
    </a>
    <div class="row ">
        <div class="mb-2">
            <h4 class="fw-bold text-sm"><span class="text-muted fw-light text-xs"> Layanan LKM / </span>
                Pengajuan Magang
        </div>
    </div>

    <div class="col-12 mb-4">
        <div class="bs-stepper wizard-numbered mt-2">
            <div class="bs-stepper-header" style="justify-content: center;">
                <div class="step" data-target="#account-details">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Jenis Pengajuan Magang</span>
                            <span class="bs-stepper-subtitle">MBKM/Start-up/Kerja/Mandiri</span>
                        </span>
                    </button>
                </div>
                <div class="line">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step" data-target="#personal-info">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Informasi Pengajuan Magang</span>
                            <span class="bs-stepper-subtitle">Perusahaan/Posisi/Tanggal Mulai-Akhir</span>
                        </span>
                    </button>
                </div>
                <div class="line">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step" data-target="#social-links">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Dokumen Pengajuan Magang</span>
                            <span class="bs-stepper-subtitle">SPTJM/SR/Slip Gaji/Kontrak Kerja/Pitchdeck</span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="bs-stepper-content">
                <!-- <form onSubmit="return false"> -->
                <!-- Account Details -->
                <div id="account-details" class="content">
                    <div class="content-header mb-3">
                        <h5 class="mb-3">Jenis Pengajuan Magang</h5>
                        <div class="row g-3">
                            <div class="col-lg-12 col-sm-6">
                                <label class="form-label" for="jenis">Jenis Magang<span class="text-danger">*</span></label>
                                <select class="form-select select2" data-placeholder="Pilih Jenis Magang" id="jenisMagang" onchange="showDiv(this)">
                                    <option value="0" selected disabled>Pilih Jenis Magang</option>
                                    <option value="1">Magang Mandiri</option>
                                    <option value="2">Magang MSIB</option>
                                    <option value="3">Magang Kerja</option>
                                    <option value="4">Magang Start-Up</option>
                                </select>
                            </div>
                            <div class="col-12 text-end">
                                <button class="btn btn-success btn-next">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Selanjutnya</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Personal Info -->
                <div id="personal-info" class="content">
                    <div class="content-header mb-3">
                        <h5 class="mb-0">Informasi Pengajuan Magang</h5>
                    </div>
                    <div class="row g-3">
                        <!-- Form Repeater -->
                        <div id="form-msib" style="display:none;">
                            <form class="form-repeater">
                                <div data-repeater-list="group-a">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label class="form-label" for="nama">Nama Perusahaan<span class="text-danger">*</span></label>
                                                <input type="text" id="nama" class="form-control" placeholder="Masukkan Nama Perusahaan" />
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label class="form-label" for="bidang">Nama Posisi/Bidang<span class="text-danger">*</span></label>
                                                <input type="text" id="bidang" class="form-control" placeholder="Masukkan Nama Posisi/Bidang" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="" class="form-label">Tanggal Mulai Magang<span style="color: red;">*</span></label>
                                                <input type="text" class="form-control flatpickr-date" placeholder="YYYY-MM-DD" id="">
                                            </div>
                                            <div class="col-5">
                                                <label for="" class="form-label">Tanggal Berakhir Magang<span style="color: red;">*</span></label>
                                                <input type="text" class="form-control flatpickr-date" placeholder="YYYY-MM-DD" id="">
                                            </div>
                                            <div class="col-1">
                                                <button class="btn btn-label-danger mt-4" data-repeater-delete>
                                                    <i class="ti ti-trash ti-xs me-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <hr />
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <button class="btn btn-outline-success" data-repeater-create>
                                        <span class="align-middle">Tambah</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- /Form Repeater -->
                        <div id="form-mandiri" style="display:none;">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label" for="nama">Nama Perusahaan<span class="text-danger">*</span></label>
                                    <input type="text" id="nama" class="form-control" placeholder="Masukkan Nama Perusahaan" />
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label" for="bidang">Nama Posisi/Bidang<span class="text-danger">*</span></label>
                                    <input type="text" id="bidang" class="form-control" placeholder="Masukkan Nama Posisi/Bidang" />
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="" class="form-label">Tanggal Mulai Magang<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control flatpickr-date" placeholder="YYYY-MM-DD" id="">
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="" class="form-label">Tanggal Berakhir Magang<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control flatpickr-date" placeholder="YYYY-MM-DD" id="">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label" for="bagan">Bagian/Jabatan yang Dituju<span class="text-danger">*</span></label>
                                    <input type="text" id="bagan" class="form-control" placeholder="Masukkan Bagian/Jabatan yang Dituju" />
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label" for="alamat">Alamat Perusahaan<span class="text-danger">*</span></label>
                                    <input type="text" id="alamat" class="form-control" placeholder="Masukkan Alamat Perusahaan" />
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="no">No Telp Perusahaan<span class="text-danger">*</span></label>
                                    <input type="text" id="no" class="form-control" placeholder="083xxxxxxx" />
                                    <p class="mt-1" style="font-size: smaller;">Ex:083xxxxxxx</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label" for="email">Email Perusahaan<span class="text-danger">*</span></label>
                                    <input type="text" id="email" class="form-control" placeholder="abc.gmail.com" />
                                    <p class="mt-1" style="font-size: smaller;">Ex:abc.gmail.com</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between">
                            <button class="btn btn-label-secondary btn-prev">
                                <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                            </button>
                            <button class="btn btn-success btn-next">
                                <span class="align-middle d-sm-inline-block d-none me-sm-1"> Selanjutnya</span>
                                <i class="ti ti-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Social Links -->
                <div id="social-links" class="content">
                    <div class="content-header mb-3">
                        <h5 class="mb-0">Dokumen Pengajuan Magang</h5>
                    </div>
                    <div class="row g-3">
                        <div class="row" id="form-mbkm" style="display:none;">
                            <div class="col-sm-12 mt-3 mb-3">
                                <label class="form-label" for="">Upload SPTJM (Surat Pertanggungjawaban Mutlak)<span class="text-danger">*</span></label>
                                <input class="form-control" type="file" id="formFile">
                                <p class="mt-1 mb-0" style="font-size: smaller;">Tipe File: .PDF Maximum upload file size : 2 MB.</p>
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label" for="">Upload SR (Surat Rekomendasi)<span class="text-danger">*</span></label>
                                <input class="form-control" type="file" id="formFile">
                                <p class="mt-1 mb-0" style="font-size: smaller;">Tipe File: .PDF Maximum upload file size : 2 MB.</p>
                            </div>
                        </div>
                        <div class="row" id="form-kerja" style="display:none;">
                            <div class="col-sm-12 mt-3 mb-3">
                                <label class="form-label" for="">Upload Surat Kontrak Kerja<span class="text-danger">*</span></label>
                                <input class="form-control" type="file" id="formFile">
                                <p class="mt-1 mb-0" style="font-size: smaller;">Tipe File: .PDF Maximum upload file size : 2 MB.</p>
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label" for="">Upload Slip Gaji<span class="text-danger">*</span></label>
                                <input class="form-control" type="file" id="formFile">
                                <p class="mt-1 mb-0" style="font-size: smaller;">Tipe File: .PDF Maximum upload file size : 2 MB.</p>
                            </div>
                        </div>
                        <div class="row" id="form-startup" style="display:none;">
                            <div class="col-sm-12 mt-3">
                                <label class="form-label" for="">Upload Pitchdeck (Wajib Bertandatangan)<span class="text-danger">*</span></label>
                                <input class="form-control" type="file" id="formFile">
                                <p class="mt-1 mb-0" style="font-size: smaller;">Tipe File: .PDF Maximum upload file size : 2 MB.</p>
                            </div>
                        </div>
                        <div class="text-center mt-3" id="mandiri" style="display:none;">
                            <h4 style="color: #4EA971;">Anda Memilih Magang Mandiri! Tidak Perlu Melakukan Pengunggahan Dokumen.</h4>
                        </div>
                        <div class="col-12 d-flex justify-content-between">
                            <button class="btn btn-label-secondary btn-prev">
                                <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                            </button>
                            <button class="btn btn-success btn-submit">Kirim</button>
                        </div>
                    </div>
                </div>
                <!-- </form> -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_script')
<script src="{{ url('app-assets/js/forms-extras.js') }}"></script>
<script src="{{ url('app-assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>

<script>
    $(".flatpickr-date").flatpickr({
        altInput: true,
        altFormat: 'j F Y',
        dateFormat: 'Y-m-d',
        static: true,
    });
</script>

<script type="text/javascript">
    function showDiv(select) {
        if (select.value == 1) {
            document.getElementById('form-mandiri').style.display = "block";
            document.getElementById('form-msib').style.display = "none";
            document.getElementById('mandiri').style.display = "block";
            document.getElementById('form-mbkm').style.display = "none";
            document.getElementById('form-kerja').style.display = "none";
            document.getElementById('form-startup').style.display = "none";
        } else if (select.value == 2) {
            document.getElementById('form-mandiri').style.display = "none";
            document.getElementById('form-msib').style.display = "block";
            document.getElementById('form-mbkm').style.display = "block";
            document.getElementById('mandiri').style.display = "none";
            document.getElementById('form-kerja').style.display = "none";
            document.getElementById('form-startup').style.display = "none";
        }
        else if (select.value == 3) {
            document.getElementById('form-mandiri').style.display = "block";
            document.getElementById('form-msib').style.display = "none";
            document.getElementById('form-kerja').style.display = "block";
            document.getElementById('form-mbkm').style.display = "none";
            document.getElementById('mandiri').style.display = "none";
            document.getElementById('form-startup').style.display = "none";
        }
        else if (select.value == 4) {
            document.getElementById('form-mandiri').style.display = "block";
            document.getElementById('form-msib').style.display = "none";
            document.getElementById('form-startup').style.display = "block";
            document.getElementById('form-kerja').style.display = "none";
            document.getElementById('form-mbkm').style.display = "none";
            document.getElementById('mandiri').style.display = "none";
        }
        else {
        }
    }
</script>


@endsection