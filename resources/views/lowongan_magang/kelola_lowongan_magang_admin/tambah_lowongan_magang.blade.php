@extends('partials_admin.template')

@section('page_style')
<link rel="stylesheet" href="{{ url('app-assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ url('app-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
<link rel="stylesheet" href="{{ url('app-assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css ') }}" />
<link rel="stylesheet" href="{{ url('app-assets/vendor/libs/pickr/pickr-themes.css') }}" />
<style>
    .form-error {
        color: red;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: #4EA971;
    }

    .bs-stepper .step.active .bs-stepper-circle {
        background-color: #4EA971
    }
</style>
@endsection

@section('main')
<a href="{{url('kelola/lowongan/mitra', Auth::user()->id_industri)}}" type="button" class="btn btn-outline-success mb-3 waves-effect">
    <span class="ti ti-arrow-left me-2"></span>Kembali
</a>
<div class="row ">
    <div class="mb-2">
        <h4 class="fw-bold text-sm"><span class="text-muted fw-light text-xs">Lowongan Magang / </span>
            Tambah Lowongan Magang
        </h4>
    </div>
</div>

<!-- Validation Wizard -->
<div class="modal-body">
    <div class="col-12 mb-4">
        <div id="wizard-validation" class="bs-stepper mt-2">
            <div class="bs-stepper-header" style="justify-content: center">
                <div class="step" data-target="#account-details-validation">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label mt-1">
                            <span class="bs-stepper-title">Detail Lowongan</span>
                            <span class="bs-stepper-subtitle">Posisi/Kuota/Deskripsi</span>
                        </span>
                    </button>
                </div>
                <div class="line">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step" data-target="#personal-info-validation">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Kualifikasi Lowongan</span>
                            <span class="bs-stepper-subtitle">Keterampilan/Requriement/Benefit</span>
                        </span>
                    </button>
                </div>
                <div class="line">
                    <i class="ti ti-chevron-right"></i>
                </div>
                <div class="step" data-target="#social-links-validation">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Proses Seleksi</span>
                            <span class="bs-stepper-subtitle">Tahap1/Tahap2/Tahap3</span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="bs-stepper-content">
                <form class="default-form" id="wizard-validation-form" onSubmit="return false" method="POST" action="{{ url('kelola/lowongan/mitra/store') }}">
                    @csrf
                    <!-- Account Details -->
                    <div id="account-details-validation" class="content">
                        <div class="content-header mb-3">
                            <h6 class="mb-0">Detail Lowongan</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-lg-12 col-sm-6">
                                <label class="form-label" for="jenismagang">Jenis Magang<span class="text-danger">*</span></label>
                                <select name="jenismagang" id="jenismagang" class="select2 form-select" data-placeholder="Jenis Magang">
                                    <option value="" disabled selected>Jenis Magang</option>
                                    @foreach ($jenismagang as $j)
                                    <option value="{{ $j->id_jenismagang }}">{{ $j->namajenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <label class="form-label" for="posisi">Posisi<span class="text-danger">*</span></label>
                                <input type="text" name="posisi" id="posisi" class="form-control" placeholder="Masukan Posisi Pekerjaan" required />
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <label class="form-label" for="kuota">Kuota Penerimaan<span class="text-danger">*</span></label>
                                <input type="text" name="kuota" id="kuota" class="form-control" placeholder="Masukan Kuota Penerimaan" required />
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <label class="form-label" for="deskripsi">Deskripsi Pekerjaan<span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="2" id="deskripsi" name="deskripsi" placeholder="Masukan Deskripsi Pekerjaan"></textarea>
                            </div>
                            <div class="col-12 d-flex justify-content-between">
                                <button type="button" class="btn btn-label-secondary btn-prev" disabled>
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button class="btn btn-success btn-next" type="button">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Personal Info -->
                    <div id="personal-info-validation" class="content">
                        <div class="content-header mb-3">
                            <h4 class="mb-0">Kualifikasi Lowongan </h4>
                        </div>
                        <div class="row g-3">
                            <div class="col-lg-12 col-sm-6">
                                <label for="kualifikasi" class="form-label">Requirements <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="2" id="kualifikasi" name="kualifikasi" placeholder="Masukan Kualifikasi Mahasiswa" required></textarea>
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <label for="jenis" class="form-label">Jenis
                                    kelamin<span class="text-danger">*</span></label>
                                <div class="col mt-2">
                                    <div class="form-check form-check-inline">
                                        <input name="jenis" id="jenis" class="form-check-input" type="radio" value="Laki-Laki" />
                                        <label class="form-check-label" for="jenis">Laki-Laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="jenis" id="jenis" class="form-check-input" type="radio" value="Perempuan" />
                                        <label class="form-check-label" for="jenis">Perempuan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="jenis" id="jenis" class="form-check-input " type="radio" value="Laki-Laki & Perempuan" />
                                        <label class="form-check-label" for="jenis">Laki-Laki &
                                            Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <div class="border py-2 px-3 rounded-3">
                                    <label class="form-label" for="basic-default-company">
                                        Kualifikasi Pendidikan
                                    </label>
                                    <div class="form-group" style="margin-top: 5px;">
                                        <label for="jenjang" class="form-label">Jenjang<span class="text-danger">*</span></label>
                                        <select name="jenjang" id="jenjang" multiple="multiple" class="select2-multiple form-select" data-placeholder="Pilih Jenjang">
                                            <option value="D3">D3</option>
                                            <option value="S1">S1</option>
                                            <option value="S2">S2</option>
                                        </select>
                                    </div>
                                    <div class="form-group" style="margin-top: 5px;">
                                        <label class="form-label" for="fakultas">Fakultas<span class="text-danger">*</span></label>
                                        <select name="fakultas" id="fakultas" class="select2 form-select" data-placeholder="Pilih Fakultas">
                                            @foreach ($fakultas as $f)
                                            <option value="{{ $f->id_fakultas }}">{{ $f->namafakultas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-sm-6">
                                        <label for="select2Disabled" class="form-label">Prodi<span class="text-danger">*</span></label>
                                        <select name="id_prodi" id="select2Disabled" class="select2 form-select" disabled>
                                            <option value="1" selected>Pilih Prodi</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <label for="keterampilan" class="form-label">Keterampilan<span class="text-danger">*</span></label>
                                <select name="keterampilan" id="keterampilan" multiple="multiple" class="select2-multiple form-select" data-placeholder="Pilih Keterampilan">
                                    <option value="Figma">Figma</option>
                                    <option value="Teamwork">Teamwork</option>
                                    <option value="Leadership">Leadership</option>
                                    <option value="Laravel">Laravel</option>
                                </select>
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <label for="pelaksanaan" class="form-label">Pelaksanaan Magang<span class="text-danger">*</span></label>
                                <div class="col mt-2">
                                    <div class="form-check form-check-inline">
                                        <input name="pelaksanaan" id="pelaksanaan" class="form-check-input" type="radio" value="Online" />
                                        <label class="form-check-label" for="pelaksanaan">Online</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="pelaksanaan" id="pelaksanaan" class="form-check-input" type="radio" value="Onsite" />
                                        <label class="form-check-label" for="pelaksanaan">Onsite</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="pelaksanaan" id="pelaksanaan" class="form-check-input " type="radio" value="Hybird" />
                                        <label class="form-check-label" for="pelaksanaan">Hybird</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <label for="gaji" class="form-label d-block">Uang
                                    Saku
                                    <span class="text-danger">*</span></label>
                                <div class="col mt-2">
                                    <div class="form-check form-check-inline">
                                        <input name="gaji" id="gaji" class="form-check-input" type="radio" value="1" />
                                        <label class="form-check-label" for="gaji">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="gaji" id="gaji" class="form-check-input" type="radio" value="0" />
                                        <label class="form-check-label" for="gaji">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <label class="form-label" for="nominal">Nominal Uang Saku<span class="text-danger">*</span></label>
                                <input type="text" name="nominal" id="nominal" class="form-control" />
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <label for="benefit" class="form-label">Benefits (Addtional)<span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="2" id="benefit" name="benefit" placeholder="Masukan Benefits"></textarea>
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <label for="lokasi" class="form-label">Lokasi Penempatan<span class="text-danger">*</span></label>
                                <select name="lokasi" id="lokasi" multiple="multiple" class="select2-multiple form-select wizard-required" data-placeholder="Masukan Lokasi Pekerjaan">

                                </select>
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="flex: 1;">
                                        <label for="tanggal" class="form-label">Tanggal Lowongan Ditayangkan
                                            <span class="text-danger">*</span></label>
                                        <input class="form-control flatpickr-date wizard-required" type="date" id="tanggal" name="tanggal" placeholder="YYYY-MM-DD" readonly="readonly">
                                    </div>
                                    <div class="mt-3" style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px">
                                    </div>
                                    <div style="flex: 1;">
                                        <label for="tanggalakhir" class="form-label">Tanggal Lowongan Diturunkan
                                            <span class="text-danger">*</span></label>
                                        <input class="form-control flatpickr-date wizard-required" type="date" id="tanggalakhir" name="tanggalakhir" placeholder="YYYY-MM-DD" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <label for="durasimagang" class="form-label">Durasi Magang<span class="text-danger">*</span></label>
                                <select name="durasimagang" id="durasimagang" multiple="multiple" class="select2-multiple form-select wizard-required" data-placeholder="Pilih Durasi Magang">
                                    <option value="1 Semester">1 Semester</option>
                                    <option value="2 Semester">2 Semester</option>
                                </select>
                            </div>
                            <div class="col-lg-12 col-sm-6">
                                <label for="tahapan" class="form-label">Tahapan
                                    Magang<span class="text-danger">*</span></label>
                                <div class="col mt-2">
                                    <div class="form-check form-check-inline">
                                        <input name="tahapan" class="form-check-input" type="radio" value="0" />
                                        <label class="form-check-label" for="tahapan">1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="tahapan" class="form-check-input" type="radio" value="1" />
                                        <label class="form-check-label" for="tahapan">2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="tahapan" class="form-check-input " type="radio" value="2" />
                                        <label class="form-check-label" for="tahapan">3</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-between">
                                <button type="button" class="btn btn-label-secondary btn-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button class="btn btn-success btn-next" type="button">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Social Links -->
                    <div id="social-links-validation" class="content">
                        <div class="content-header mb-3">
                            <h4 class="mb-0">Proses Seleksi</h4>
                        </div>
                        <div class="row g-3">
                            <div class="col-lg-12 col-sm-6">
                                <label for="select2Disabled" class="form-label">Jenis Seleksi Tahap Lanjut<span class="text-danger">*</span></label>
                                <select id="select2Disabled" class="select2 form-select" disabled>
                                    <option value="1" selected>Seleksi Tahap 1</option>
                                    <option value="2">Option2</option>
                                    <option value="3">Option3</option>
                                </select>
                            </div>
                            <div class="col-lg-12 col-sm-6 mt-3">
                                <label for="deskripsiseleksi" class="form-label">Deskripsi Seleksi<span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="2" id="deskripsiseleksi" name="deskripsiseleksi[]" placeholder="Masukan Deskripsi Tahapan"></textarea>
                            </div>
                            <div class="col-lg-12 col-sm-6 mt-3">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="flex: 1;">
                                        <label for="mulai" class="form-label">Tanggal Mulai Pelaksanaan
                                            <span class="text-danger">*</span></label>
                                        <input class="form-control flatpickr-date wizard-required" type="date" id="mulai" name="mulai[]" placeholder="YYYY-MM-DD" readonly="readonly">
                                    </div>
                                    <div class="mt-3" style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px">
                                    </div>
                                    <div style="flex: 1;">
                                        <label for="akhir" class="form-label">Tanggal Akhir Pelaksanaan
                                            <span class="text-danger">*</span></label>
                                        <input class="form-control flatpickr-date wizard-required" type="date" id="akhir" name="akhir[]" placeholder="YYYY-MM-DD" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <div id="tahap-lanjut-2" style="display: none;">
                                <hr>
                                <div class="col-lg-12 col-sm-6">
                                    <label for="select2Disabled" class="form-label">Jenis Seleksi Tahap
                                        Lanjut<span class="text-danger">*</span></label>
                                    <select id="select2Disabled" class="select2 form-select" disabled>
                                        <option value="1">Seleksi Tahap 1</option>
                                        <option value="2" selected>Seleksi Tahap 2</option>
                                        <option value="3">Option3</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 col-sm-6 mt-3">
                                    <label for="deskripsiseleksi" class="form-label">Deskripsi Seleksi<span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="2" id="deskripsiseleksi1" name="deskripsiseleksi[]" placeholder="Masukan Deskripsi Tahapan"></textarea>
                                </div>
                                <div class="col-lg-12 col-sm-6 mt-3">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <div style="flex: 1;">
                                            <label for="mulai" class="form-label">Tanggal Mulai Pelaksanaan
                                                <span class="text-danger">*</span></label>
                                            <input class="form-control flatpickr-date wizard-required" type="date" id="mulai1" name="mulai[]" placeholder="YYYY-MM-DD" readonly="readonly">
                                        </div>
                                        <div class="mt-3" style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px">
                                        </div>
                                        <div style="flex: 1;">
                                            <label for="akhir" class="form-label">Tanggal Akhir Pelaksanaan
                                                <span class="text-danger">*</span></label>
                                            <input class="form-control flatpickr-date wizard-required" type="date" id="akhir1" name="akhir[]" placeholder="YYYY-MM-DD" readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tahap-lanjut-3" style="display: none;">
                                <div class="mb-2">
                                    <hr>
                                    <div class="col-lg-12 col-sm-6">
                                        <label for="select2Disabled" class="form-label">Jenis Seleksi Tahap
                                            Lanjut<span class="text-danger">*</span></label>
                                        <select id="select2Disabled" class="select2 form-select" disabled>
                                            <option value="1">Seleksi Tahap 1</option>
                                            <option value="2">Seleksi Tahap 2</option>
                                            <option value="3" selected>Seleksi Tahap 3</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-sm-6 mt-3">
                                        <label for="deskripsiseleksi" class="form-label">Deskripsi Seleksi<span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="2" id="deskripsiseleksi2" name="deskripsiseleksi[]" placeholder="Masukan Deskripsi Tahapan"></textarea>
                                    </div>
                                    <div class="col-lg-12 col-sm-6 mt-3">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <div style="flex: 1;">
                                                <label for="mulai" class="form-label">Tanggal Mulai Pelaksanaan
                                                    <span class="text-danger">*</span></label>
                                                <input class="form-control flatpickr-date wizard-required" type="date" id="mulai2" name="mulai[]" placeholder="YYYY-MM-DD" readonly="readonly">
                                            </div>
                                            <div class="mt-3" style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px">
                                            </div>
                                            <div style="flex: 1;">
                                                <label for="akhir" class="form-label">Tanggal Akhir Pelaksanaan
                                                    <span class="text-danger">*</span></label>
                                                <input class="form-control flatpickr-date wizard-required" type="date" id="akhir2" name="akhir[]" placeholder="YYYY-MM-DD" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-between">
                                <button type="button" class="btn btn-label-secondary btn-prev">
                                    <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="submit" class="btn btn-success btn-submit" id="modal-button">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Validation Wizard -->
@endsection

@section('page_script')
<script src="{{ url('app-assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ url('app-assets/js/extended-ui-sweetalert2.js') }}"></script>
<script src="{{ url('app-assets/js/app-stepper.js') }}"></script>
<script src="{{ url('app-assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ url('app-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ url('app-assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
<script src="{{ url('app-assets/vendor/libs/pickr/pickr.js') }}"></script>
<script src="{{ url('app-assets/js/forms-pickers.js') }}"></script>
<script>
    $(".flatpickr-date").flatpickr({
        altInput: true,
        altFormat: 'j F Y',
        dateFormat: 'Y-m-d'
    });
</script>
@endsection