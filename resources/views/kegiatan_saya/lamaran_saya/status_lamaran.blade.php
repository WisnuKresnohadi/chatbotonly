@extends('partials.horizontal_menu')

@section('page_style')
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
<style>
    .col-1-5 {
        flex: 0 0 12.5%;
        max-width: 12.5%;
    }

    .page-item.active .page-link,
    .pagination li.active>a:not(.page-link) {
        border-color: #FFFFFF !important;
        background-color: #4EA971 !important;
    }

    .btn-secondary {
        background-color: #D3D6DB !important;
        border-color: #D3D6DB !important;
    }

    .btn-success {
        background-color: #4EA971 !important;
        border-color: #4EA971 !important;
    }

    .light-style .bs-stepper .bs-stepper-header {
        border-bottom: 0px solid #dbdade !important;
    }

    .light-style .bs-stepper {
        background-color: #f8f7fa;
    }

    .light-style .bs-stepper:not(.wizard-modern) {
        box-shadow: none;
    }

    .breadcrumb-item,
    .breadcrumb-item a {
        color: #4b465c !important;
    }

    /* coba */

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    @font-face {
        font-family: pop;
        src: url(./Fonts/Poppins-Medium.ttf);
    }

    .main {
        width: 100%;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: pop;
        flex-direction: column;
    }

    .head {
        text-align: center;
    }

    .head_1 {
        font-size: 30px;
        font-weight: 600;
        color: #333;
    }

    .head_1 span {
        color: #ff4732;
    }

    .head_2 {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-top: 3px;
    }

    ul {
        display: flex;
        margin-top: 80px;
    }

    ul li {
        list-style: none;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    ul li .icon {
        font-size: 35px;
        color: #ff4732;
        margin: 0 60px;
    }

    ul li .text {
        font-size: 14px;
        font-weight: 600;
        color: #ff4732;
    }

    /* Progress Div Css  */

    ul li .progress {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: rgba(68, 68, 68, 0.781);
        margin: 14px 0;
        display: grid;
        place-items: center;
        color: #fff;
        position: relative;
        cursor: pointer;
    }

    .progress::after {
        content: " ";
        position: absolute;
        width: 125px;
        height: 5px;
        background-color: rgba(68, 68, 68, 0.781);
        right: 30px;
    }

    .one::after {
        width: 0;
        height: 0;
    }

    ul li .progress .uil {
        display: none;
    }

    ul li .progress p {
        font-size: 13px;
    }

    /* Active Css  */

    ul li .active {
        background-color: #24B364;
        display: grid;
        place-items: center;
    }

    li .active::after {
        background-color: #ff4732;
    }

    ul li .active p {
        display: none;
    }

    ul li .active .uil {
        font-size: 20px;
        display: flex;
    }

    /* Responsive Css  */

    @media (max-width: 980px) {
        ul {
            flex-direction: column;
        }

        ul li {
            flex-direction: row;
        }

        ul li .progress {
            margin: 0 30px;
        }

        .progress::after {
            width: 5px;
            height: 55px;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: -1;
        }

        .one::after {
            height: 0;
        }

        ul li .icon {
            margin: 15px 0;
        }
    }

    @media (max-width:600px) {
        .head .head_1 {
            font-size: 24px;
        }

        .head .head_2 {
            font-size: 16px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-9 col-12">
        <button class="btn btn-outline-success mt-4 mb-3 waves-effect" type="button">
            <i class="ti ti-arrow-left me-2 text-success"> Kembali </i>
        </button>
        <h4 class="fw-bold"><span class="text-muted fw-light">Kegiatan Saya / Status Lamaran Magang / </span>Detail Status lamaran Magang </h4>
    </div>

    <div class="bs-stepper wizard-icons wizard-icons-example mt-4">
        <div class="bs-stepper-header">
            <div class="step d-flex flex-column align-items-center">
                <button type="button" class="btn rounded-pill btn-icon btn-{{$color1}} waves-effect waves-light mb-3">
                    1
                </button>
                <p>Screening</p>
            </div>
            <hr style="width: 15%; height:60px;" class="border-secondary border-2">
            <div class="step d-flex flex-column align-items-center">
                <button type="button" class="btn rounded-pill btn-icon btn-{{$color2}} waves-effect waves-light mb-3">
                    2
                </button>
                <p>Seleksi</p>
            </div>
            <hr style="width: 15%; height:60px;" class="border-secondary border-2">
            <div class="step d-flex flex-column align-items-center">
                <button type="button" class="btn rounded-pill btn-icon btn-{{$color3}} waves-effect waves-light mb-3">
                    3
                </button>
                <p>Penawaran</p>
            </div>
            <hr style="width: 15%; height:60px;" class="border-secondary border-2">
            <div class="step d-flex flex-column align-items-center">
                <button type="button" class="btn rounded-pill btn-icon btn-{{$color4}} waves-effect waves-light mb-3">
                    4
                </button>
                <p>Diterima/Ditolak</p>
            </div>
        </div>
    </div>

    <div class="card mb-5">
        <div class="card-body">
            <div class="row card-header" style="background-color: #FFFFFF; padding:0px;">
                <div class="col-3 text-start">
                    <figure class="image mx-1" style="border-radius: 0%;"><img style="border-radius: 0%; width: 70%; height:auto;" src="{{$img ?? '\assets\images\no-pictures.png'}}" alt="Logo">
                    </figure>
                </div>
                <div class="col-3 ms-sm-0 text-start" style="margin-left:-100px;">
                    <h3>{{$pendaftar->lowongan_magang->intern_position}}</h3>
                    <p style="font-size:15px;">{{$pendaftar->lowongan_magang->industri->namaindustri}}</p>
                </div>
                <div class="col-6 ms-sm-0 text-end" style="margin-left:100px;">
                    <div class="waktu"> Lamaran terkirim pada {{($pendaftar->tanggaldaftar?->format('d F Y'))}}</div>
                    @if($now->lessThan($pendaftar->lowongan_magang->date_confirm_closing))
                    <div><span class="badge bg-label-success me-1 text-end mt-3" style="height:35px; font-size:16px;">Lowongan Masih bisa diambil</span></div>
                    @else
                    <div><span class="badge bg-label-secondary me-1 text-end mt-3" style="height:35px; font-size:16px;">Lowongan Sudah di tutup</span></div>
                    @endif
                    <div><span class="badge bg-label-{{$color}} me-1 text-end mt-3" style="height:30px; font-size:16px;">{{$step}}</span></div>
                </div>
            </div>
            <div class="map-pin mt-3 mb-3"><i class="ti ti-map-pin" style="margin-right: 10px; margin-bottom:5px;"></i>{{$pendaftar->lowongan_magang->lokasi}}</div>
            @if(empty($pendaftar->lowongan_magang->nominal_salary))
            <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-cash" style="margin-right: 10px; margin-bottom:5px;"></i>Tidak Diberi Uang Saku</div>
            @else
            <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px"><i class="ti ti-cash" style="margin-right: 10px; margin-bottom:5px;"></i>Diberi Uang Saku</div>
            @endif
            <div class="briefcase mb-3" style="margin-left: 1px;"><i class="ti ti-calendar-time" style="margin-right: 10px; margin-bottom:5px;"></i>{{$pendaftar->lowongan_magang->durasimagang}}</div>
            <div class="location" style="margin-left: 2px;"><i class="ti ti-users" style="margin-right: 10px; margin-bottom:5px;"></i>{{$pendaftar->lowongan_magang->kuota}} Kuota Penerimaan</div>
            <div><a href="/detail/lowongan/magang"><button type="button" class="btn btn-sm btn-outline-dark waves-effect mt-3" style="width: 200px; height:auto"> <i class="ti ti-eye" style="margin-right: 10px; margin-bottom:5px;"></i>Lihat Detail Pekerjaan</button>
                </a></div>
            <div class="border mt-3"></div>
            <div class="tex-start mt-3">
                <h4>Mengapa Saya Harus Diterima?</h4>
                <p>{{$pendaftar->reason_aplicant}}</p>
            </div>
            <div class="border mt-3"></div>
            <div class="row mt-3">
                <div class="col-3 text-start mx-5">
                    <h6 style="margin-left: -50px">Portofolio</h6>
                    @if(empty($pendaftar->portofolio))
                    <div class="map-pin mt-3 mb-3" style="margin-left: -50px">Tidak mengunggah portofolio</div>
                    @else
                    <a href="{{ url('kegiatan-saya/porto', $pendaftar->portofolio)}}" target="_blank">
                        <div class="map-pin mt-3 mb-3 text-success"><i class="ti ti-file-symlink" style="margin-left: -55px; margin-bottom:5px;"></i><u>{{$pendaftar->portofolio}}.pdf</u>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_script')
<script>
    
</script>
@endsection