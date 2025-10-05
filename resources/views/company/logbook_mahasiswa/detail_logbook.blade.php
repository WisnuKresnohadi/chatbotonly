@extends('partials_admin.template')

@section('page_style')
<link rel="stylesheet" href="../../app-assets/vendor/libs/sweetalert2/sweetalert2.css" />
<style>
    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-right: 86px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        right: 10px !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        overflow: visible !important;
    }
    .form-check-success .form-check-input:checked, .form-check-success .form-check-input[type=checkbox]:indeterminate {
    background-color: #4EA971 !important;
    border-color: #4EA971 !important;
}
</style>
@endsection

@section('main')
<div class="row">
    <div class="">
        <a href="/logbook/mahasiswa" type="button" class="btn btn-outline-success mb-3 waves-effect">
            <span class="ti ti-arrow-left me-2"></span>Kembali
        </a>
    </div>
    <div class="col-10">
        <h4 class="fw-bold"><span class="text-muted fw-light">Logbook Mahasiswa /</span> Detail Logbook Leonie Artaputri</h4>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 20px; height: fit-content !important; min-width: 320px !important;">
            <div class="row">
                <div class="col-10">
                    <div class="d-flex align-items-left">
                        <img class="img-fluid rounded" src="../../app-assets/img/avatars/15.png" height="80" width="80" alt="User avatar" />
                        <span class="pt-3">
                            <h4 class="mb-2 ms-3">Leonie Artaputri</h4>
                            <h6 class="ms-3">UI/UX Design</h6>
                        </span>
                    </div>
                </div>
                <div class="col-2 text-end">
                    <span class='badge bg-label-warning'>Belum Disetujui</span>
                </div>
            </div>
        </div>

        <div class="d-flex mt-4">
            <div class="text-center" style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 20px; margin-right: 20px; height: fit-content !important; min-width: 320px !important;">
                <div class="d-flex justify-content-between">
                    <div class="col-7">
                        <p class="fw-bold mb-0 mt-2 me-2">Silahkan Pilih Bulan</p>
                    </div>
                    <div class="col-5"> <select class="select2 form-select" data-placeholder="Filter Status">
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                </div>
                <div class="border-bottom mt-3 mb-3"></div>
                <div style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 10px;">
                    <div class="row">
                        <div class="col-8">
                            <div class="form-check form-check-success text-start ps-0">
                                <input name="customRadioSuccess" class="form-check-input ms-1 mt-2" type="radio" value="" id="customRadioSuccess" checked="" style="font-size: x-large;">
                                <label class="form-check-label ms-2 ms-3" for="customRadioSuccess">
                                    <h6 class="mb-1">Minggu Ke 1</h6>
                                    <p class="mb-0" style="font-size: small;">2 - 7 Januari 2023</p>
                                </label>
                            </div>
                        </div>
                        {{--sesudah diterima dan ditolak--}}
                        <!-- <div class="col-2">
                            <span class='badge bg-label-success'>Disetujui</span>
                        </div> -->
                    </div>
                </div>
                <div class="mt-3" style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 10px;">
                    <div class="form-check form-check-success text-start ps-0">
                        <input name="customRadioSuccess" class="form-check-input ms-1 mt-2" type="radio" value="" id="customRadioSuccess" style="font-size: x-large;">
                        <label class="form-check-label ms-2 ms-3" for="customRadioSuccess">
                            <h6 class="mb-1">Minggu Ke 2</h6>
                            <p class="mb-0" style="font-size: small;">2 - 7 Januari 2023</p>
                        </label>
                    </div>
                </div>
                <div class="mt-3" style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 10px;">
                    <div class="form-check form-check-success text-start ps-0">
                        <input name="customRadioSuccess" class="form-check-input ms-1 mt-2" type="radio" value="" id="customRadioSuccess" style="font-size: x-large;">
                        <label class="form-check-label ms-2 ms-3" for="customRadioSuccess">
                            <h6 class="mb-1">Minggu Ke 3</h6>
                            <p class="mb-0" style="font-size: small;">2 - 7 Januari 2023</p>
                        </label>
                    </div>
                </div>
                <div class="mt-3" style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 10px;">
                    <div class="form-check form-check-success text-start ps-0">
                        <input name="customRadioSuccess" class="form-check-input ms-1 mt-2" type="radio" value="" id="customRadioSuccess" style="font-size: x-large;">
                        <label class="form-check-label ms-2 ms-3" for="customRadioSuccess">
                            <h6 class="mb-1">Minggu Ke 4</h6>
                            <p class="mb-0" style="font-size: small;">2 - 7 Januari 2023</p>
                        </label>
                    </div>
                </div>
            </div>
            <div>
                <div style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 20px; margin-bottom: 30px;">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="rounded-pill d-flex flex-column align-items-center justify-content-center" style="background-color: #C4E2D0; width: 70px; height: 70px;">
                                <img src="../assets/images/smile.png" alt="">
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Senin</h6>
                                <p class="fw-normal mb-0">2 Januari 2023</p>
                            </div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalalert"><i class="ti ti-check"></i></button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalDitolak"><i class="ti ti-x"></i></button>
                        </div>
                    </div>
                    <p style="color: #B6BAC3; margin-top: 15px;">Kamu melakukan Pekerjaan Apa Hari Ini ?</p>
                    <p style="color: #23314B">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque
                        iaculis lacinia erat in auctor. In venenatis nisl vel nisl laoreet, in feugiat nibh
                        tincidunt.
                        Donec fermentum interdum nunc, ac viverra tellus molestie in. Suspendisse blandit maximus
                        mauris, vitae pharetra risus gravida eu. Lorem ipsum dolor sit amet, consectetur adipiscing
                        elit.</p>
                </div>
                <div style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 20px; margin-bottom: 30px;">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="rounded-pill d-flex flex-column align-items-center justify-content-center" style="background-color: #C4E2D0; width: 70px; height: 70px;">
                                <img src="../assets/images/smile.png" alt="">
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Senin</h6>
                                <p class="fw-normal mb-0">2 Januari 2023</p>
                            </div>
                        </div>
                        <div>
                            {{--sebelum diterima dan ditolak--}}
                            <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalalert"><i class="ti ti-check"></i></button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalDitolak"><i class="ti ti-x"></i></button>
                            {{--sesudah diterima dan ditolak--}}
                            <!-- <span class='badge bg-label-success'>Disetuju</span> -->
                        </div>
                    </div>
                    <p style="color: #B6BAC3; margin-top: 15px;">Kamu melakukan Pekerjaan Apa Hari Ini ?</p>
                    <p style="color: #23314B">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque
                        iaculis lacinia erat in auctor. In venenatis nisl vel nisl laoreet, in feugiat nibh
                        tincidunt.
                        Donec fermentum interdum nunc, ac viverra tellus molestie in. Suspendisse blandit maximus
                        mauris, vitae pharetra risus gravida eu. Lorem ipsum dolor sit amet, consectetur adipiscing
                        elit.</p>
                </div>
                <div style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 20px; margin-bottom: 30px;">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="rounded-pill d-flex flex-column align-items-center justify-content-center" style="background-color: #C4E2D0; width: 70px; height: 70px;">
                                <img src="../assets/images/smile.png" alt="">
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Senin</h6>
                                <p class="fw-normal mb-0">2 Januari 2023</p>
                            </div>
                        </div>
                        <div>
                            <span class='badge bg-label-secondary'>Belum Mengisi Logbook</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Alert-->
        <div class="modal fade" id="modalalert" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center pb-0">
                        <img src="../../app-assets/img/alert.png" alt="">
                        <h5 class="modal-title" id="modal-title">Apakah logbook mahasiswa sedah sesuai dengan yang dikerjakan?</h5>
                        <p>Status logbook akan otomatis berubah!</p>
                        <div class="swal2-html-container" id="swal2-html-container" style="display: block;"></div>
                    </div>
                    <div class="modal-footer" style="display: flex; justify-content:center;">
                        <button type="submit" id="modal-button" class="btn btn-success">Ya, Sudah</button>
                        <button type="submit" id="modal-button" class="btn btn-danger">Batal</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ditolak-->
        <div class="modal fade" id="modalDitolak" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title" id="modalDitolak">Anda Menolak Logbook 2 Januari 2023, Silahkan Memberikan Komentar !!!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-3">
                        <div class="row">
                            <div class="col mb-0">
                                <label for="defaultFormControlInput" class="form-label pb-1">Komentar <span class="text-danger">*</span> </label>
                                <textarea class="form-control" id="defaultFormControlInput" placeholder="Tulis komentar disini" aria-describedby="defaultFormControlHelp"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success">Kirim Komentar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('page_script')
<script src="../../app-assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
<script src="../../app-assets/js/forms-extras.js"></script>
<script src="../../app-assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script src="../../app-assets/js/extended-ui-sweetalert2.js"></script>
@endsection