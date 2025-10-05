@extends('partials.horizontal_menu')

@section('page_style')
    <link rel="stylesheet" href="../../app-assets/vendor/libs/leaflet/leaflet.css" />
    <style>
        .col-3 {
            flex: 0 0 auto;
            width: 32% !important;
        }

        .btn-success {
            color: #fff;
            background-color: #4EA971 !important;
            border-color: #4EA971 !important;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y m-5">
        <div class="row ms-5 me-5">
            <div class="col-6">
                <h1 style="color: #FF9F43;">About Us</h1>
                <h3> <span style="color: #4EA971;"> Techno Infinity </span> perusahaan IT sebagai solusi kebutuhan yang
                    kalian inginkan</h3>
                <p>Techno infinity adalah sebuah perusahaan pengembang perangkat lunak yang berlokasi di Bandung, Jawa
                    Barat. Berdiri sejak 2012, berkomitmen untuk menyediakan solusi teknologi paling efisien untuk bisnis
                    Anda. Resmi menjadi PT Teknologi Nirmala Olah Daya Informasi pada tahun 2020 dan bergabung menjadi
                    bagian dari Proxsis Co pada tahun 2021.</p>
                <a href="https://technoinfinity.co.id/techno-story/">
                    <button class="btn btn-success">Lihat Selengkapnya <i class="ti ti-chevron-right me-1"></i></button>
                </a>
            </div>
            <div class="col-6">
                <div
                    style="border-radius: 10px; background: linear-gradient(0deg, rgba(255, 255, 255, 0.30) 0%, rgba(255, 255, 255, 0.30) 100%), rgba(220, 238, 227, 0.60); width:50%; height:80%; margin-left:170px; margin-right:200px;">
                    <figure class="image" style="margin-left:100px; margin-top:20px;">
                        <img style="height:200px; width: 300px; margin-top:-30px;"
                            src="{{ asset('front/assets/img/tim_techno_2.png') }}" alt="admin.upload">
                    </figure>
                    <figure class="image" style="margin-left:-40px;">
                        <img style="height:200px; width: 300px;" src="{{ asset('front/assets/img/tim_techno_1.png') }}"
                            alt="admin.upload">
                    </figure>
                </div>
            </div>
        </div>

        <div class="row m-5">
            <div class="col-6 text-center" style="padding-left: 100px;">
                <div
                    style="border-radius: 10px; background: linear-gradient(0deg, rgba(255, 255, 255, 0.30) 0%, rgba(255, 255, 255, 0.30) 100%), rgba(220, 238, 227, 0.60); width:63%; height:90%;">
                    <figure class="image">
                        <img style="height:350px; width: 300px; margin-top: 20px;"
                            src="{{ asset('front/assets/img/tim_techno_3.png') }}" alt="admin.upload">
                    </figure>
                </div>
            </div>
            <div class="col-6 ps-5">
                <h4 style="color: #4EA971;">Kolaborasi Mitra Perusahaan</h4>
                <h3>Berkolaborasi dengan berbagai macam perusahaan ternama di seluruh indonesia! 🌍✨</h3>
                <div class="row">
                    <div class="col-4">
                        <figure class="image">
                            <img src="{{ asset('front/assets/img/pln.png') }}" alt="">
                        </figure>
                    </div>
                    <div class="col-4 text-center">
                        <figure class="image">
                            <img src="{{ asset('front/assets/img/tni.png') }}" alt="">
                        </figure>
                    </div>
                    <div class="col-4">
                        <figure class="image">
                            <img src="{{ asset('front/assets/img/jasindo.png') }}" alt="">
                        </figure>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <figure class="image">
                            <img src="{{ asset('front/assets/img/ypt.png') }}" alt="">
                        </figure>
                    </div>
                    <div class="col-4 text-center">
                        <figure class="image">
                            <img src="{{ asset('front/assets/img/kominfo.png') }}" alt="">
                        </figure>
                    </div>
                    <div class="col-4">
                        <figure class="image">
                            <img src="{{ asset('front/assets/img/pertamina.png') }}" alt="">
                        </figure>
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-5">
            <div class="col-12 text-center">
                <h4 style="color: #4EA971;">Pondasi Techno Infinity</h4>
                <h2>Beberapa pondasi yang diterapkan pada <br> PT. Teknologi Nirmala Olah Daya Informasi!</h2>
            </div>
            <div class="row mt-4 ms-1">
                <div class="col-3 border" style="border-radius: 8px; background:#DCEEE3;">
                    <h4 class="mt-2" style="color: #4EA971;">01</h4>
                    <h5>Passion</h5>
                    <p>"Berkomiten dalam hati dan fikiran karena karier bukan hanya tugas rutin, melainkan petualangan
                        membangun impian dan mewujudkan passionmu setiap hari.</p>
                </div>
                <div class="col-3 border ms-3 me-3" style="border-radius: 8px;">
                    <h4 class="mt-2" style="color: #4EA971;">02</h4>
                    <h5>Integrity</h5>
                    <p>Menghormati dan berdedikasi pada klien Di sini, kami menghargai nilai-nilai kejujuran, etika, dan
                        konsistensi.</p>
                </div>
                <div class="col-3 border" style="border-radius: 8px; background:#DCEEE3;">
                    <h4 class="mt-2" style="color: #4EA971;">03</h4>
                    <h5>Rendah Hati</h5>
                    <p>Membangun tim yang baik berawal dari hal yang kecil. Kami percaya bahwa melalui sikap rendah hati,
                        kita dapat saling belajar, berkembang, dan menciptakan lingkungan kerja yang harmonis.</p>
                </div>
            </div>
            <div class="row justify-content-center mt-4 ms-1">
                <div class="col-3 border" style="border-radius: 8px;">
                    <h4 class="mt-2" style="color: #4EA971;">04</h4>
                    <h5>Berinovasi</h5>
                    <p>Terus bergerak maju, meningkatkan dan melampaui batas Kami mempercayai bahwa setiap ide, sekecil
                        apapun, dapat menjadi katalisator perubahan yang luar biasa.</p>
                </div>
                <div class="col-3 border ms-3 me-3" style="border-radius: 8px; background:#DCEEE3;">
                    <h4 class="mt-2" style="color: #4EA971;">05</h4>
                    <h5>Profesional</h5>
                    <p>Memberikan yang terbaik dalam setiap hal yang di lakukan karena pilar utama di setiap langkah karier
                        kita.</p>
                </div>
            </div>
        </div>

        <div class="row m-5">
            <div class="col-12 text-center">
                <h4 style="color: #4EA971;">Kunjungi Kami</h4>
            </div>
            <div class="row mt-4 ms-1">
                <div class="col-6 pt-5" style="padding-left: 100px;">
                    <h6>PT. Teknologi Nirmala Olah Daya Informasi (Techno Infinity)</h6>
                    <h6>Jl. Mars Sel. X No.19B, Manjahlega, Kec. Rancasari, Kota,<br>Bandung, Jawa Barat 40286</h6>

                    <div class="mb-3">
                        <i class="ti ti-mail me-1"></i><a href="mailto:info@technoinfinity.co.id"
                            style="color: #6F6B7D;">info@technoinfinity.co.id</a>
                    </div>
                    <div class="mb-3">
                        <i class="ti ti-phone-call me-1"></i><a>(022) 8750 - 5501</a>
                    </div>
                    <div>
                        <i class="ti ti-brand-instagram me-1"></i><a
                            href="https://www.instagram.com/techno_infinity?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                            style="color: #6F6B7D;">techno_infinity</a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="leaflet-map" id="dragMaps"></div>
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
    <script src="../../app-assets/vendor/libs/leaflet/leaflet.js"></script>
    <script src="../../app-assets/js/maps-leaflet.js"></script>
@endsection
