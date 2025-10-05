@extends('partials_admin.template')

@section('page_style')
    <link rel="stylesheet" href="{{ url('app-assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ url('app-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
    <link rel="stylesheet"
        href="{{ url('app-assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css ') }}" />
    <link rel="stylesheet" href="{{ url('app-assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
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
@can('btn.back.lkm')
<a href="{{url("/kelola/lowongan/lkm")}}" type="button" class="btn btn-outline-success mb-3 waves-effect">
    <span class="ti ti-arrow-left me-2"></span>Kembali
</a>
@endcan
@can('btn.back.mitra')
<a href="{{url("/kelola/lowongan/mitra", Auth::user()->id_industri)}}" type="button" class="btn btn-outline-success mb-3 waves-effect">
    <span class="ti ti-arrow-left me-2"></span>Kembali
</a>
@endcan
    <div class="row ">
        <div class="col-md-12 col-12">
            <nav aria-label="breadcrumb">
                <h4>
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item text-secondary">
                            Lowongan Magang
                        </li>
                        <li class="breadcrumb-item">
                            <a href="" class="text-secondary">Kelola Magang</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="" class="text-secondary">Edit Lowongan Magang</a>
                        </li>
                        <li class="breadcrumb-item active">{{$lowongan->intern_position}}</li>
                    </ol>
                </h4>
            </nav>
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
                        <form class="default-form" id="wizard-validation-form" onSubmit="return false" method="POST"
                            action="{{ url('kelola/lowongan/mitra/update') }}/{{ $lowongan->id_lowongan }}">
                            @csrf
                            <!-- Account Details -->
                            <div id="account-details-validation" class="content">
                                <div class="content-header mb-3">
                                    <h6 class="mb-0">Detail Lowongan</h6>
                                </div>
                                <div class="row g-3">
                                    <div class="col-lg-12 col-sm-6">
                                        <label class="form-label" for="jenismagang">Jenis Magang<span
                                                class="text-danger">*</span></label>
                                        <select name="id_jenismagang" id="jenismagang" class="select2 form-select"
                                            data-placeholder="Jenis Magang">
                                            <option value="" disabled>Select</option>
                                            @foreach ($jenismagang as $j)
                                                <option @if ($j->id_jenismagang == $lowongan->id_jenismagang) selected @endif
                                                    value="{{ $j->id_jenismagang }}">{{ $j->namajenis }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-sm-6">
                                        <label class="form-label" for="posisi">Posisi<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{ $lowongan->intern_position }}" name="posisi"
                                            id="posisi" class="form-control" placeholder="Masukan Posisi Pekerjaan"
                                            required />
                                    </div>
                                    <div class="col-lg-12 col-sm-6">
                                        <label class="form-label" for="kuota">Kuota Penerimaan<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{ $lowongan->kuota }}" name="kuota" id="kuota"
                                            class="form-control" placeholder="Masukan Kuota Penerimaan" required />
                                    </div>
                                    <div class="col-lg-12 col-sm-6">
                                        <label class="form-label" for="deskripsi">Deskripsi Pekerjaan<span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="2" id="deskripsi" name="deskripsi"
                                            placeholder="Masukan Deskripsi Pekerjaan">{{ $lowongan->deskripsi }}</textarea>
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
                                        <label for="kualifikasi" class="form-label">Requirements <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="2" id="kualifikasi" name="kualifikasi"
                                            placeholder="Masukan Kualifikasi Mahasiswa" required>{{ $lowongan->requirements }}</textarea>
                                    </div>
                                    <div class="col-lg-12 col-sm-6">
                                        <label for="jenis" class="form-label">Jenis
                                            kelamin<span class="text-danger">*</span></label>
                                        <div class="col mt-2">
                                            <div class="form-check form-check-inline">
                                                <input value="0"
                                                    {{ $lowongan->gender == '0' ? ' checked="checked"' : '' }}
                                                    name="jenis" id="jenis" class="form-check-input"
                                                    type="radio" />
                                                <label class="form-check-label" for="jenis">Laki-Laki</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input value="1"
                                                    {{ $lowongan->gender == '1' ? ' checked="checked"' : '' }}
                                                    name="jenis" id="jenis" class="form-check-input"
                                                    type="radio" />
                                                <label class="form-check-label" for="jenis">Perempuan</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input value="2"
                                                    {{ $lowongan->gender == '2' ? ' checked="checked"' : '' }}
                                                    name="jenis" id="jenis" class="form-check-input "
                                                    type="radio" />
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
                                                <label for="jenjang" class="form-label">Jenjang<span
                                                        class="text-danger">*</span></label>
                                                <select name="jenjang" id="jenjang" multiple="multiple"
                                                    class="select2-multiple form-select" data-placeholder="Pilih Jenjang">
                                                    <option value="{{ $lowongan->jenjang }}">D3</option>
                                                    <option value="{{ $lowongan->jenjang }}">S1</option>
                                                    <option value="{{ $lowongan->jenjang }}">S2</option>
                                                    <option value="{{ $lowongan->jenjang }}" selected>
                                                        {{ $lowongan->jenjang }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group" style="margin-top: 5px;">
                                                <label class="form-label" for="fakultas">Fakultas<span
                                                        class="text-danger">*</span></label>
                                                <select name="fakultas" id="fakultas" class="select2 form-select"
                                                    data-placeholder="Pilih Fakultas">
                                                    <option value="" disabled>Pilih Fakultas</option>
                                                    @foreach ($fakultas as $f)
                                                        <option @if ($f->id_fakultas == $lowongan->id_fakultas) selected @endif
                                                            value="{{ $f->id_fakultas }}">{{ $f->namafakultas }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- <div class="form-group" style="margin-top: 5px;">
                                                <label class="form-label" for="prodi">Prodi<span
                                                        class="text-danger">*</span></label>
                                                <select name="prodi" id="prodi" class="select2 form-select"
                                                    data-placeholder="Pilih Prodi">
                                                    <option value="" disabled>Pilih Prodi</option>
                                                    @foreach ($prodi as $p)
                                                        <option @if ($p->id_prodi == $lowongan->id_prodi) selected @endif
                                                            value="{{ $p->id_prodi }}">{{ $p->namaprodi }}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}
                                            @can('btn.pilih.prodi')
                                            <div class="form-group" style="margin-top: 5px;">
                                                <label class="form-label" for="fakultas">Fakultas<span
                                                        class="text-danger">*</span></label>
                                                <select name="prodi" id="prodi" class="select2 form-select"
                                                    data-placeholder="Pilih Fakultas">
                                                    <option value="" disabled>Pilih Prodi</option>
                                                    @foreach ($prodi as $f)
                                                        <option @if ($f->id_prodi == $lowongan->id_prodi) selected @endif
                                                            value="{{ $f->id_prodi }}">{{ $f->namaprodi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-6">
                                        <label for="keterampilan" class="form-label">Keterampilan<span
                                                class="text-danger">*</span></label>
                                        <select name="keterampilan" id="keterampilan" multiple="multiple"
                                            class="select2-multiple form-select" data-placeholder="Pilih Keterampilan">
                                            <option value="{{ $lowongan->keterampilan }}">Figma</option>
                                            <option value="{{ $lowongan->keterampilan }}">Teamwork</option>
                                            <option value="{{ $lowongan->keterampilan }}">Leadership</option>
                                            <option value="{{ $lowongan->keterampilan }}">Laravel</option>
                                            <option value="{{ $lowongan->keterampilan }}" selected>
                                                {{ $lowongan->keterampilan }}</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-sm-6">
                                        <label for="pelaksanaan" class="form-label">Pelaksanaan Magang<span
                                                class="text-danger">*</span></label>
                                        <div class="col mt-2">
                                            <div class="form-check form-check-inline">
                                                <input name="pelaksanaan" id="pelaksanaan" class="form-check-input"
                                                    type="radio" value="Online"
                                                    {{ $lowongan->pelaksanaan == 'Online' ? ' checked="checked"' : '' }} />
                                                <label class="form-check-label" for="pelaksanaan">Online</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input name="pelaksanaan" id="pelaksanaan" class="form-check-input"
                                                    type="radio" value="Onsite"
                                                    {{ $lowongan->pelaksanaan == 'Onsite' ? ' checked="checked"' : '' }} />
                                                <label class="form-check-label" for="pelaksanaan">Onsite</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input name="pelaksanaan" id="pelaksanaan" class="form-check-input "
                                                    type="radio" value="Hybird"
                                                    {{ $lowongan->pelaksanaan == 'Hybird' ? ' checked="checked"' : '' }} />
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
                                                <input name="gaji" id="gaji"class="form-check-input"
                                                    type="radio" value="1"
                                                    {{ $lowongan->paid == '1' ? ' checked="checked"' : '' }} />
                                                <label class="form-check-label" for="gaji">Ya</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input name="gaji" id="gaji" class="form-check-input"
                                                    type="radio" value="0"
                                                    {{ $lowongan->paid == '0' ? ' checked="checked"' : '' }} />
                                                <label class="form-check-label" for="gaji">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-6">
                                        <label class="form-label" for="nominal">Nominal Uang Saku<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{ $lowongan->nominal_salary }}" name="nominal"
                                            id="nominal" class="form-control" />
                                    </div>
                                    <div class="col-lg-12 col-sm-6">
                                        <label for="benefit" class="form-label">Benefits (Addtional)<span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="2" id="benefit" name="benefit" placeholder="Masukan Benefits">{{ $lowongan->benefitmagang }}</textarea>
                                    </div>
                                    <div class="col-lg-12 col-sm-6">
                                        <label for="lokasi" class="form-label">Lokasi Penempatan<span
                                                class="text-danger">*</span></label>
                                        <select name="lokasi" id="id_lokasi" multiple="multiple"
                                            class="select2-multiple form-select wizard-required"
                                            data-placeholder="Masukan Lokasi Pekerjaan">
                                            <option value="" disabled>Select</option>
                                            <option value="{{$lowongan->lokasi}}" selected>{{$lowongan->lokasi}}</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-sm-6">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <div style="flex: 1;">
                                                <label for="tanggal" class="form-label">Tanggal Lowongan Ditayangkan
                                                    <span class="text-danger">*</span></label>
                                                <input class="form-control flatpickr-date wizard-required" type="date"
                                                    value="{{ $lowongan->startdate }}" id="tanggal" name="tanggal"
                                                    placeholder="YYYY-MM-DD" readonly="readonly">
                                            </div>
                                            <div class = "mt-3"
                                                style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px">
                                            </div>
                                            <div style="flex: 1;">
                                                <label for="tanggalakhir" class="form-label">Tanggal Lowongan Diturunkan
                                                    <span class="text-danger">*</span></label>
                                                <input class="form-control flatpickr-date wizard-required" type="date"
                                                    value="{{ $lowongan->enddate }}" id="tanggalakhir"
                                                    name="tanggalakhir" placeholder="YYYY-MM-DD" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-6">
                                        <label for="durasimagang" class="form-label">Durasi Magang<span
                                                class="text-danger">*</span></label>
                                        <select name="durasimagang" id="durasimagang" multiple="multiple"
                                            class="select2-multiple form-select wizard-required"
                                            data-placeholder="Pilih Durasi Magang">
                                            <option value="{{ $lowongan->durasimagang }}">1 Semester</option>
                                            <option value="{{ $lowongan->durasimagang }}">2 Semester</option>
                                            <option value="{{ $lowongan->durasimagang }}" selected>
                                                {{ $lowongan->durasimagang }}</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-sm-6">
                                        <label for="tahapan" class="form-label">Tahapan
                                            Magang<span class="text-danger">*</span></label>
                                        <div class="col mt-2">
                                            <div class="form-check form-check-inline">
                                                <input name="tahapan" class="form-check-input" type="radio"
                                                    value="0"
                                                    {{ $lowongan->tahapan_seleksi == '0' ? ' checked="checked"' : '' }} />
                                                <label class="form-check-label" for="tahapan">1</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input name="tahapan" class="form-check-input" type="radio"
                                                    value="1"
                                                    {{ $lowongan->tahapan_seleksi == '1' ? ' checked="checked"' : '' }} />
                                                <label class="form-check-label" for="tahapan">2</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input name="tahapan" class="form-check-input " type="radio"
                                                    value="2"
                                                    {{ $lowongan->tahapan_seleksi == '2' ? ' checked="checked"' : '' }} />
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
                                        <label for="select2Disabled" class="form-label">Jenis Seleksi Tahap Lanjut<span
                                                class="text-danger">*</span></label>
                                        <select id="select2Disabled" class="select2 form-select" disabled>
                                            <option value="1"selected>Seleksi Tahap 1</option>
                                            <option value="2">Option2</option>
                                            <option value="3">Option3</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-sm-6 mt-3">
                                        <label for="deskripsiseleksi" class="form-label">Deskripsi Seleksi<span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="2" id="deskripsiseleksi" name="deskripsiseleksi[]"
                                            placeholder="Masukan Deskripsi Tahapan">{{ $seleksi[0]->deskripsi ?? '' }}</textarea>
                                    </div>
                                    <div class="col-lg-12 col-sm-6 mt-3">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <div style="flex: 1;">
                                                <label for="mulai" class="form-label">Tanggal Mulai Pelaksanaan
                                                    <span class="text-danger">*</span></label>
                                                <input class="form-control flatpickr-date wizard-required" type="date"
                                                    value="{{ $seleksi[0]->tgl_mulai ?? '' }}" id="mulai"
                                                    name="mulai[]" placeholder="YYYY-MM-DD" readonly="readonly">
                                            </div>
                                            <div class = "mt-3"
                                                style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px">
                                            </div>
                                            <div style="flex: 1;">
                                                <label for="akhir" class="form-label">Tanggal Akhir Pelaksanaan
                                                    <span class="text-danger">*</span></label>
                                                <input class="form-control flatpickr-date wizard-required" type="date"
                                                    value="{{ $seleksi[0]->tgl_akhir ?? '' }}" id="akhir"
                                                    name="akhir[]" placeholder="YYYY-MM-DD" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tahap-lanjut-2"
                                        @if ($lowongan->tahapan_seleksi == 0) style="display: none;" @endif>
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
                                            <label for="deskripsiseleksi1" class="form-label">Deskripsi Seleksi<span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" rows="2" id="deskripsiseleksi1" name="deskripsiseleksi[]"
                                                placeholder="Masukan Deskripsi Tahapan">{{ $seleksi[1]->deskripsi ?? '' }}</textarea>
                                        </div>
                                        <div class="col-lg-12 col-sm-6 mt-3">
                                            <div
                                                style="display: flex; justify-content: space-between; align-items: center;">
                                                <div style="flex: 1;">
                                                    <label for="mulai" class="form-label">Tanggal Mulai Pelaksanaan
                                                        <span class="text-danger">*</span></label>
                                                    <input class="form-control flatpickr-date wizard-required"
                                                        type="date" value="{{ $seleksi[1]->tgl_mulai ?? '' }}"
                                                        id="mulai1" name="mulai[]" placeholder="YYYY-MM-DD"
                                                        readonly="readonly">
                                                </div>
                                                <div class = "mt-3"
                                                    style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px">
                                                </div>
                                                <div style="flex: 1;">
                                                    <label for="akhir" class="form-label">Tanggal Akhir Pelaksanaan
                                                        <span class="text-danger">*</span></label>
                                                    <input class="form-control flatpickr-date wizard-required"
                                                        type="date" value="{{ $seleksi[1]->tgl_akhir ?? '' }}"
                                                        id="akhir1" name="akhir[]" placeholder="YYYY-MM-DD"
                                                        readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tahap-lanjut-3"
                                        @if ($lowongan->tahapan_seleksi != 2) style="display: none;" @endif>
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
                                                <label for="deskripsiseleksi" class="form-label">Deskripsi Seleksi<span
                                                        class="text-danger">*</span></label>
                                                <textarea class="form-control" rows="2" id="deskripsiseleksi1" name="deskripsiseleksi[]"
                                                    placeholder="Masukan Deskripsi Tahapan">{{ $seleksi[2]->deskripsi ?? '' }}</textarea>
                                            </div>
                                            <div class="col-lg-12 col-sm-6 mt-3">
                                                <div
                                                    style="display: flex; justify-content: space-between; align-items: center;">
                                                    <div style="flex: 1;">
                                                        <label for="mulai" class="form-label">Tanggal Mulai Pelaksanaan
                                                            <span class="text-danger">*</span></label>
                                                        <input class="form-control flatpickr-date wizard-required"
                                                            type="date" value="{{ $seleksi[2]->tgl_mulai ?? '' }}"
                                                            id="mulai2" name="mulai[]" placeholder="YYYY-MM-DD"
                                                            readonly="readonly">
                                                    </div>
                                                    <div class = "mt-3"
                                                        style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label for="akhir1" class="form-label">Tanggal Akhir Pelaksanaan
                                                            <span class="text-danger">*</span></label>
                                                        <input class="form-control flatpickr-date wizard-required"
                                                            type="date" value="{{ $seleksi[2]->tgl_akhir ?? '' }}"
                                                            id="akhir2" name="akhir[]" placeholder="YYYY-MM-DD"
                                                            readonly="readonly">
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
                                        <button type="submit" class="btn btn-success btn-submit"
                                            id="modal-button">Update</button>
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
        <script src="{{ url('app-assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
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
