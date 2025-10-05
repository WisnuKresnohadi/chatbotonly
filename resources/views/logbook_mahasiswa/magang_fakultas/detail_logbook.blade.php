@extends('partials.vertical_menu')

@section('page_style')
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

    .form-check-success .form-check-input:checked,
    .form-check-success .form-check-input[type=checkbox]:indeterminate {
        background-color: #4EA971 !important;
        border-color: #4EA971 !important;
    }

    .light-style .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 2.25rem;
        color: #4EA971 !important;
        padding-left: 0.875rem;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="">
        <a href="{{ route('logbook_magang.fakultas.view') }}" type="button" class="btn btn-outline-primary mb-3">
            <span class="ti ti-arrow-left me-2"></span>Kembali
        </a>
    </div>
    <div class="col-10">
        <h4 class="fw-bold"><span class="text-muted fw-light">Logbook Mahasiswa / </span>Detail Logbook Jennie Ruby Jane</h4>
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
                            <h4 class="mb-2 ms-3">Jennie Ruby Jane</h4>
                            <h6 class="ms-3">UI/UX Design</h6>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex mt-4">
            <div style="min-width: 360px;">
            {{--Jika status ditolak--}}
            <!-- <div style="max-width: 360px;"> -->
                
                <div class="text-center" style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 15px; margin-right: 10px; height: fit-content !important;">
                    <div class="d-flex justify-content-between">
                        <div class="col-7">
                            <p class="fw-bold mb-0 mt-2 me-2">Silahkan Pilih Bulan</p>
                        </div>
                        <div class="col-5"> <select class="select2 form-select text-outline-success" data-placeholder="Filter Status">
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
                            <div class="col-7">
                                <div class="form-check form-check-success text-start ps-0">
                                    <input name="customRadioSuccess" class="form-check-input ms-1 mt-2" type="radio" value="" id="customRadioSuccess" checked="" style="font-size: x-large;">
                                    <label class="form-check-label ms-2 ms-3" for="customRadioSuccess">
                                        <h6 class="mb-1">Minggu Ke 1</h6>
                                        <p class="mb-0" style="font-size: small;">2 - 7 Januari 2023</p>
                                    </label>
                                </div>
                            </div>
                            <div class="col-2 p-0 ms-5">
                                <span class='badge bg-label-success '>Disetujui</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3" style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 10px;">
                        <div class="row">
                            <div class="col-7">
                                <div class="form-check form-check-success text-start ps-0">
                                    <input name="customRadioSuccess" class="form-check-input ms-1 mt-2" type="radio" value="" id="customRadioSuccess" style="font-size: x-large;">
                                    <label class="form-check-label ms-2 ms-3" for="customRadioSuccess">
                                        <h6 class="mb-1">Minggu Ke 2</h6>
                                        <p class="mb-0" style="font-size: small;">2 - 7 Januari 2023</p>
                                    </label>
                                </div>
                            </div>
                            <div class="col-2 p-0 ms-5">
                                <span class='badge bg-label-success '>Disetujui</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3" style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 10px;">
                        <div class="row">
                            <div class="col-7">
                                <div class="form-check form-check-success text-start ps-0">
                                    <input name="customRadioSuccess" class="form-check-input ms-1 mt-2" type="radio" value="" id="customRadioSuccess" style="font-size: x-large;">
                                    <label class="form-check-label ms-2 ms-3" for="customRadioSuccess">
                                        <h6 class="mb-1">Minggu Ke 3</h6>
                                        <p class="mb-0" style="font-size: small;">2 - 7 Januari 2023</p>
                                    </label>
                                </div>
                            </div>
                            <div class="col-2 p-0 ms-5">
                                <span class='badge bg-label-success '>Disetujui</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3" style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 10px;">
                        <div class="row">
                            <div class="col-7">
                                <div class="form-check form-check-success text-start ps-0">
                                    <input name="customRadioSuccess" class="form-check-input ms-1 mt-2" type="radio" value="" id="customRadioSuccess" style="font-size: x-large;">
                                    <label class="form-check-label ms-2 ms-3" for="customRadioSuccess">
                                        <h6 class="mb-1">Minggu Ke 4</h6>
                                        <p class="mb-0" style="font-size: small;">2 - 7 Januari 2023</p>
                                    </label>
                                </div>
                            </div>
                            <div class="col-2 p-0 ms-5">
                                <span class='badge bg-label-success '>Disetujui</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{--Jika status ditolak--}}
                <!-- <div class="text-start" style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 15px; margin-right: 10px; height: fit-content !important; margin-top: 25px;">
                    <h6>Alasan penolakan logbook :</h6>
                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque iaculis lacinia erat in auctor. In venenatis nisl vel nisl laoreet, in feugiat nibh tincidunt. Donec fermentum interdum nunc, ac viverra tellus molestie in. Suspendisse blandit maximus mauris, vitae pharetra risus gravida eu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                </div> -->
            </div>

            <div>
                <div>
                    <h5>Logbook Minggu Ke-1 Januari 2023</h5>
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
                    </div>
                    <p style="color: #B6BAC3; margin-top: 15px;">Kamu melakukan Pekerjaan Apa Hari Ini ?</p>
                    <p style="color: #23314B">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque
                        iaculis lacinia erat in auctor. In venenatis nisl vel nisl laoreet, in feugiat nibh
                        tincidunt.
                        Donec fermentum interdum nunc, ac viverra tellus molestie in. Suspendisse blandit maximus
                        mauris, vitae pharetra risus gravida eu. Lorem ipsum dolor sit amet, consectetur adipiscing
                        elit.</p>
                    <hr>
                    <b style="margin-top: 15px;">Alasan Logbook Ditolak :</b>
                    <p style="color: #23314B; margin-top:10px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque
                        iaculis lacinia erat in auctor. In venenatis nisl vel nisl laoreet, in feugiat nibh
                        tincidunt.</p>
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
                    </div>
                    <p style="color: #B6BAC3; margin-top: 15px;">Kamu melakukan Pekerjaan Apa Hari Ini ?</p>
                    <p style="color: #23314B">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque
                        iaculis lacinia erat in auctor. In venenatis nisl vel nisl laoreet, in feugiat nibh
                        tincidunt.
                        Donec fermentum interdum nunc, ac viverra tellus molestie in. Suspendisse blandit maximus
                        mauris, vitae pharetra risus gravida eu. Lorem ipsum dolor sit amet, consectetur adipiscing
                        elit.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page_script')
@endsection