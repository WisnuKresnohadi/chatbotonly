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
        <a href="{{ route('logbook_magang.mandiri') }}" type="button" class="btn btn-outline-primary mb-3">
            <span class="ti ti-arrow-left me-2"></span>Kembali
        </a>
    </div>
    <div class="col-10">
        <h4 class="fw-bold"><span class="text-muted fw-light"> Logbook Mahasiswa / </span>Detail Logbook Jennie Ruby Jane</h4>
    </div>
</div>
<div class="col-12">
    <div class="card">
        <div class="user-profile-header-banner">
            <img src="{{ asset('assets/logbookbg.png') }}" alt="Banner image" class="rounded-top" width="100%" style="height: 129px !important;" />
        </div>
        <div class="user-profile-header text-sm-start text-center mb-4" style="justify-content: space-between !important;">
            <div class="flex-shrink-0 mt-n5 mx-sm-0 mx-auto ms-0 ms-sm-5">
                <div class="row">
                    <div class="col-6">
                        <div class="card" style="max-width:210px">
                            <div class="card-body">
                                <img src="{{ asset('assets/images/wings.png') }}" alt="user image" class="d-block h-auto rounded user-profile-img" />
                            </div>
                        </div>
                        <div style="margin-top: 24px;">
                            <h4>Human Resources</h4>
                            <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                <li class="list-inline-item">PT. Wings Surya</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-6 mt-5 text-end">
                        <button class="btn btn-outline-success mt-5 me-5" tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog" aria-expanded="false"><span><i class="ti ti-download me-sm-1"></i> <span class="d-none d-sm-inline-block">Ekspor PDF</span></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-4 mt-4" style=" display: flex; justify-content: space-between !important;">
    <h4>Logbook Mahasiswa - Januari 2024</h4>
    <select class="select2 form-select" data-placeholder="Silahkan Pilih Bulan">
        <option value="">Silahkan Pilih Bulan</option>
        <option value="1">Januari</option>
        <option value="2">Februari</option>
        <option value="3">Maret</option>
        <option value="4">April</option>
        <option value="5">Mei</option>
    </select>
</div>

<a href="{{ route('logbook_magang.mandiri.detail') }}" style="color:#5d596c;">
    <div class="mb-4" style="display: flex; justify-content: space-between; border: 1px solid #D3D6DB; padding: 10px 30px; background-color: white; border-radius: 6px; ">
        <div class="mt-3">
            <span class="badge bg-label-warning mb-2">Belum Disetujui</span>
            <h5 class="mb-1">20 - 25 Januari 2023</h5>
            <p>Minggu ke - 1</p>
        </div>

        <div class="mt-3" style="display: flex !important;">
            <div class="text-center" style=" margin-left: 20px; ">
                <p>Senin</p>
                <img src="{{ asset('assets/images/smile.png') }}" alt="">
            </div>
            <div class="text-center" style=" margin-left: 20px; ">
                <p>Selasa</p>
                <img src="{{ asset('assets/images/love.png') }}" alt="">
            </div>
            <div class="text-center" style=" margin-left: 20px; ">
                <p>Rabu</p>
                <img src="{{ asset('assets/images/sad.png') }}" alt="">
            </div>
            <div class="text-center" style=" margin-left: 20px; ">
                <p>kamis</p>
                <img src="{{ asset('assets/images/kyaa.png') }}" alt="">
            </div>
            <div class="text-center" style=" margin-left: 20px; ">
                <p>Jumat</p>
                <img src="{{ asset('assets/images/jutek.png') }}" alt="">
            </div>
        </div>
    </div>
</a>

<a href="{{ route('logbook_magang.mandiri.detail') }}" style="color:#5d596c;">
    <div class="mb-4" style="display: flex; justify-content: space-between; border: 1px solid #D3D6DB; padding: 10px 30px; background-color: white; border-radius: 6px; ">
        <div class="mt-3">
            <span class="badge bg-label-success mb-2">Disetujui</span>
            <h5 class="mb-1">20 - 25 Januari 2023</h5>
            <p>Minggu ke - 1</p>
        </div>

        <div class="mt-3" style="display: flex !important;">
            <div class="text-center" style=" margin-left: 20px; ">
                <p>Senin</p>
                <img src="{{ asset('assets/images/smile.png') }}" alt="">
            </div>
            <div class="text-center" style=" margin-left: 20px; ">
                <p>Selasa</p>
                <img src="{{ asset('assets/images/love.png') }}" alt="">
            </div>
            <div class="text-center" style=" margin-left: 20px; ">
                <p>Rabu</p>
                <img src="{{ asset('assets/images/sad.png') }}" alt="">
            </div>
            <div class="text-center" style=" margin-left: 20px; ">
                <p>kamis</p>
                <img src="{{ asset('assets/images/kyaa.png') }}" alt="">
            </div>
            <div class="text-center" style=" margin-left: 20px; ">
                <p>Jumat</p>
                <img src="{{ asset('assets/images/jutek.png') }}" alt="">
            </div>
        </div>
    </div>
</a>

<a href="{{ route('logbook_magang.mandiri.detail') }}" style="color:#5d596c;">
    <div class="mb-4" style="display: flex; justify-content: space-between; border: 1px solid #D3D6DB; padding: 10px 30px; background-color: white; border-radius: 6px; ">
        <div class="mt-3">
            <span class="badge bg-label-danger mb-2">Ditolak</span>
            <h5 class="mb-1">20 - 25 Januari 2023</h5>
            <p>Minggu ke - 3</p>
        </div>

        <div class="mt-3" style="display: flex !important;">
            <div class="text-center" style=" margin-left: 20px; ">
                <p>Senin</p>
                <img src="{{ asset('assets/images/smile.png') }}" alt="">
            </div>
            <div class="text-center" style=" margin-left: 20px; ">
                <p>Selasa</p>
                <img src="{{ asset('assets/images/love.png') }}" alt="">
            </div>
            <div class="text-center" style=" margin-left: 20px; ">
                <p>Rabu</p>
                <img src="{{ asset('assets/images/sad.png') }}" alt="">
            </div>
            <div class="text-center" style=" margin-left: 20px; ">
                <p>kamis</p>
                <img src="{{ asset('assets/images/kyaa.png') }}" alt="">
            </div>
            <div class="text-center" style=" margin-left: 20px; ">
                <p>Jumat</p>
                <img src="{{ asset('assets/images/jutek.png') }}" alt="">
            </div>
        </div>
    </div>
</a>

@endsection

@section('page_script')
@endsection