@extends('partials_mahasiswa.template')

@section('page_style')
<style>
    .hidden {
        display: none;
    }

    .page-item>.page-link.active {
        border-color: #4EA971 !important;
        background-color: #4EA971 !important;
        color: #fff;
    }

    .btn-success {
        color: #fff;
        background-color: #4EA971 !important;
        border-color: #4EA971 !important;
    }

    .select2-results__option[role="option"][aria-selected="true"] {
        background-color: #4EA971 !important;
        color: #fff;
    }

    .select2-container--default .select2-results__option--highlighted:not([aria-selected="true"]) {
        background-color: rgba(115, 103, 240, 0.08) !important;
        color: #4EA971 !important;
    }

    .text-success {
        --bs-text-opacity: 1;
        color: #4EA971 !important;
    }
</style>
@endsection

@section('main')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-12 col-12 mt-4 mb-4">
        <h4 class="fw-bold"><span class="text-muted fw-light">Kegiatan Saya /</span> Status Magang Aktif</h4>
    </div>

    {{-- Belum melakukan konfirmasi lowongan magang --}}
    <div class="col-12 mt-5 text-center">
        <img class="image" style="border-radius: 0%; width:430px;" src="{{ asset('front/assets/img/nodata.png') }}" alt="admin.upload">
    </div>
    <div class="sec-title mt-5 mb-4 text-center">
        <h4>Anda belum memiliki riwayat magang aktif </h4>
        <p> Silakan lakukan konfirmasi magang aktif <a href="" class="text-success cursor-pointer"> Disini </a></p>
    </div>

    {{-- Sudah melakukan konfirmasi lowongan magang --}}
    {{-- <div class="row ms-1 text-center">
        <div class="col-4 border me-5" style="border-radius: 8px; background-color: #fff;">
            <div class="user-avatar-section">
                <div class="d-flex align-items-center flex-column">
                    <img class="img-fluid rounded mb-3 pt-1 mt-4" src="../../app-assets/img/avatars/15.png" height="100" width="100" alt="User avatar" />
                    <div class="user-info text-center">
                        <h4 class="mb-2">Violet Mendoza</h4>
                        <span class="badge bg-label-success mt-1" style="font-size: medium;">Mahasiswa</span>
                    </div>
                </div>
            </div>
            <div class="row text-start mt-4">
                <div class="col-6">
                    <ul>
                        <li class="mb-2 pt-1">
                            <span class="fw-semibold me-1">Universitas:</span>
                        </li>
                        <li class="mb-2 pt-1">
                            <span class="fw-semibold me-1">Fakultas:</span>
                        </li>
                        <li class="mb-2 pt-1">
                            <span class="fw-semibold me-1">Program Studi:</span>
                        </li>
                        <li class="mb-2 pt-1">
                            <span class="fw-semibold me-1">IPK:</span>
                        </li>
                        <li class="mb-2 pt-1">
                            <span class="fw-semibold me-1">Semester:</span>
                        </li>
                    </ul>
                </div>
                <div class="col-6">
                    <ul class="list-unstyled">
                        <li class="mb-2 pt-1">
                            <span>Universitas Telkom</span>
                        </li>
                        <li class="mb-2 pt-1">
                            <span>Fakultas Ilmu Terapan</span>
                        </li>
                        <li class="mb-2 pt-1">
                            <span>D3 Sistem Informasi</span>
                        </li>
                        <li class="mb-2 pt-1">
                            <span>3.74/4.00</span>
                        </li>
                        <li class="mb-2 pt-1">
                            <span>5</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-7 border" style="border-radius: 8px; background-color: #fff; width: 63.22222222% !important;">
            <div class=" mt-4 d-flex justify-content-between">
                <h4 class="mb-0 ps-3">Informasi Penerimaan Magang</h4>
                <!-- <i class="menu-icon tf-icons ti ti-edit text-warning" data-bs-toggle="modal" data-bs-target="#modalKonfirmasi"></i> -->
            </div>

            <div class="row text-start mt-4">
                <div class="col-4">
                    <ul class="list-unstyled ps-3">
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">Nama Perusahaan:</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">Program Magang:</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">Jenis Magang:</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">Status Magang:</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">Tanggal Mulai Magang:</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">Tanggal Akhir Magang:</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">Bukti Penerimaan Magang:</span>
                        </li>
                    </ul>
                </div>
                <div class="col-8">
                    <ul class="list-unstyled">
                        <li class="mb-4 pt-1">
                            <span>Techno Infinity</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span>Technical Writer</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span>Magang Mandiri</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span>Diterima</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span>03 Juli 2023</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span>03 Juni 2024</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span><a href="" class="text-info">Buktipenerimaanmagang.pdf</a></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div> 

    <div class="row mt-4 mb-4 ms-1 border" style="border-radius: 8px; background-color: #fff;">
        <div class="col-6 border-end">
            <div class=" mt-4 d-flex justify-content-between">
                <h4 class="mb-0 ps-3">Informasi Pembimbing Akademik</h4>
            </div>

            <div class="row text-start mt-4">
                <div class="col-5">
                    <ul class="list-unstyled ps-3">
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">Pembimbing Akademik:</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">NIP:</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">Jabatan:</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">Email:</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">No. Telepon:</span>
                        </li>
                    </ul>
                </div>
                <div class="col-7">
                    <ul class="list-unstyled">
                        <li class="mb-4 pt-1">
                            <span>Rizza Indah Mega Mandasari, S.Kom., M.T.</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span>158XXXXXX</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span>Kepala Program Studi D3 RPLA</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span>rizza@gmail.com</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span>081xxxxxxxxx</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class=" mt-4 d-flex justify-content-between">
                <h4 class="mb-0 ps-3">Informasi Pembimbing Lapangan</h4>
                {{--magang mandiri icon + aktif dan status pembimbing aktif-}}
                <!-- <i class="menu-icon tf-icons ti ti-plus text-success" data-bs-toggle="modal" data-bs-target="#modaltambah"></i> -->
            </div>

            <div class="row text-start mt-4">
                <div class="col-5">
                    <ul class="list-unstyled ps-3">
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">Pembimbing Lapangan:</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">NIP:</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">Jabatan:</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">Email:</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">No. Telepon:</span>
                        </li>
                        <!-- <li class="mb-4 pt-1">
                            <span class="fw-semibold me-1">Status Pembimbing:</span>
                        </li> -->
                    </ul>
                </div>
                <div class="col-7">
                    <ul class="list-unstyled">
                        <li class="mb-4 pt-1">
                            <span>Nauval Faksi Erlansyah, S.Kom</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span>2258XXXXXX</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span>Supervisi UI/UX Designer</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span>nauval@gmail.com</span>
                        </li>
                        <li class="mb-4 pt-1">
                            <span>081xxxxxxxxx</span>
                        </li>
                        <!-- <li class="mb-4 pt-1">
                        <span class="badge bg-label-warning mb-2">Belum Disetujui</span>
                        </li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Modal -->
    <!-- <div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Edit Status Magang Aktif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label" for="bahasa">Jenis Magang <span style="color: red;">*</span></label>
                            <select id="jenis" class="form-select select2">
                                <option disabled selected>Pilih Jenis Magang</option>
                                <option value="jenis">Magang Fakultas</option>
                                <option value="jenis">Magang Mandiri</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="namaperusahaan" class="form-label">Nama Perusahaan <span style="color: red;">*</span></label>
                            <input type="text" id="namaperusahaan" class="form-control" placeholder="PT. Techno Infinity" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="namaposisi" class="form-label">Nama Posisi Magang <span style="color: red;">*</span></label>
                            <input type="text" id="namaperusahaan" class="form-control" placeholder="UIUX Designer" />
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col mb-0">
                            <label for="tanggalmulai" class="form-label">Tanggal Mulai<span style="color: red;">*</span></label>
                            <input type="text" class="form-control flatpickr-date" id="tanggalmulai" placeholder="YYYY-MM-DD" readonly="readonly">
                        </div>
                        <div class="mt-5" style="text-align: center; background-color: black; width: 14px; height: 1px; margin: 0 20px">
                        </div>
                        <div class="col mb-0">
                            <label for="tanggalakhir" class="form-label">Tanggal Akhir<span style="color: red;">*</span></label>
                            <input type="text" class="form-control  flatpickr-date" id="tanggalakhir" placeholder="YYYY-MM-DD" readonly="readonly">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-0">
                            <label for="formFile" class="form-label">Bukti Penerimaan Magang</label>
                            <input class="form-control" type="file" id="formFile">
                            <p style="font-size: 11px; margin-top:5px;">Allowed PDF, PNG, JPG, JPEG. Max size 1 GB</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Modal -->
    <div class="modal fade" id="modaltambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Konfirmasi Pembimbing Lapangan Magang Mandiri </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nama" class="form-label">Nama Pembimbing Lapangan <span style="color: red;">*</span></label>
                            <input type="text" id="nama" class="form-control" placeholder="Masukkan nama pembimbing lapangan anda" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nip" class="form-label">NIP/NIK<span style="color: red;">*</span></label>
                            <input type="text" id="nip" class="form-control" placeholder="Masukkan NIP pembimbing lapangan anda" />
                            <p class="mb-0" style="font-size: 11px; margin-top:5px;">Ex : 278xxxxxx</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="jabatan" class="form-label">Jabatan<span style="color: red;">*</span></label>
                            <input type="text" id="jabatan" class="form-control" placeholder="Masukkan jabatan pembimbing lapangan anda" />
                            <p class="mb-0" style="font-size: 11px; margin-top:5px;">Ex : Staff UI/UX Designer</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="email" class="form-label">Email<span style="color: red;">*</span></label>
                            <input type="text" id="email" class="form-control" placeholder="Masukkan email pembimbing lapangan anda" />
                            <p class="mb-0" style="font-size: 11px; margin-top:5px;">Ex : nama@email.com</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="no" class="form-label">No Telpon<span style="color: red;">*</span></label>
                            <input type="text" id="no" class="form-control" placeholder="Masukkan no.telepon pembimbing lapangan anda" />
                            <p class="mb-0" style="font-size: 11px; margin-top:5px;">Ex : 628xxxxxxxxx</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('page_script')
<script>
    $(".flatpickr-date").flatpickr({
        altInput: true,
        altFormat: 'j F Y',
        dateFormat: 'Y-m-d',
        static: true,
    });
</script>
@endsection