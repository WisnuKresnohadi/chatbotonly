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
            <h3> <span style="color: #4EA971;"> Fakultas Ilmu Terapan </span> salah satu fakultas vokasi terbaik di Indonesia</h3>
            <p>Fakultas Ilmu Terapan merupakan satu dari tujuh fakultas di Universitas Telkom yang fokus pada Pendidikan vokasi. Untuk menunjang kompetensi lulusan yang terampil serta match dengan kebutuhan industri, maka kurikulum pendidikan vokasi didesain menjadi 60% praktek dan 40% teori. Fakultas Ilmu Terapan merupakan fakultas berbasis vokasi yang dimiliki oleh Telkom University dimana kegiatan magang menjadi program penting dalam bentuk implementasi keilmuan yang didapat dari perkuliahan ke Dunia Usaha dan Dunia Industri (DUDI).</p>
            <a href="https://sas.telkomuniversity.ac.id/">
                <button class="btn btn-success">Lihat Selengkapnya <i class="ti ti-chevron-right me-1"></i></button>
            </a>
        </div>
        <div class="col-6">
            <div style="border-radius: 10px; background: linear-gradient(0deg, rgba(255, 255, 255, 0.30) 0%, rgba(255, 255, 255, 0.30) 100%), rgba(220, 238, 227, 0.60); width:50%; height:80%; margin-left:170px; margin-right:200px;">
                <figure class="image" style="margin-left:100px; margin-top:20px;">
                    <img style="height:200px; width: 300px; margin-top:-30px;" src="{{ asset('front/assets/img/gedung.png')}}" alt="admin.upload">
                </figure>
                <figure class="image" style="margin-left:-40px;">
                    <img style="height:200px; width: 300px;" src="{{ asset('front/assets/img/lkm.png')}}" alt="admin.upload">
                </figure>
            </div>
        </div>
    </div>

    <div class="row m-5">
        <div class="col-6 text-center" style="padding-left: 100px;">
            <div style="border-radius: 10px; background: linear-gradient(0deg, rgba(255, 255, 255, 0.30) 0%, rgba(255, 255, 255, 0.30) 100%), rgba(220, 238, 227, 0.60); width:63%; height:90%;">
                <figure class="image">
                    <img style="height:350px; width: 300px; margin-top: 20px;" src="{{ asset('front/assets/img/fit.png')}}" alt="admin.upload">
                </figure>
            </div>
        </div>
        <div class="col-6 ps-5">
            <h4 style="color: #4EA971;">Program Studi</h4>
            <h3>Fakultas Ilmu Terapan Menawarkan 9 Program Studi Unggulan ! 🌍✨</h3>
            <ul class="list-unstyled">
                <li> 1. S1 Terapan Teknologi Rekayasa Multimedia</li>
                <li> 2. D3 Rekayasa Perangkat Lunak Aplikasi (D3 Teknik Informatika)</li>
                <li> 3. D3 Sistem Informasi</li>
                <li> 4. D3 Teknologi Komputer</li>
                <li> 5. D3 Teknologi Telekomunikasi</li>
                <li> 6. D3 Sistem Informasi Akuntansi</li>
                <li> 7. D3 Perhotelan</li>
                <li> 8. D3 Manajemen Pemasaran</li>
            </ul>
        </div>
    </div>

    <div class="row text-center ps-5">
        <h4 style="color: #4EA971;">Kerjasama Mitra Industri</h4>
        <h3>Berkolaborasi dengan berbagai macam perusahaan dari berbagai <br> sektor industri! 🌍✨</h3>
        <div class="row mt-2">
            <div class="col-1"></div>
            <div class="col-2">
                <figure class="image">
                    <img style="width:200px;" src="{{ asset('front/assets/img/horison.png')}}" alt="">
                </figure>
            </div>
            <div class="col-2">
                <figure class="image">
                    <img style="width:130px;" src="{{ asset('front/assets/img/grnadorchard.png')}}" alt="">
                </figure>
            </div>
            <div class="col-2">
                <figure class="image mt-3">
                    <img style="width:200px;" src="{{ asset('front/assets/img/archipelago.png')}}" alt="">
                </figure>
            </div>
            <div class="col-2">
                <figure class="image">
                    <img src="{{ asset('front/assets/img/marriott.png')}}" alt="">
                </figure>
            </div>
            <div class="col-2">
                <figure class="image">
                    <img style="width:200px;" src="{{ asset('front/assets/img/grandtjokro.png')}}" alt="">
                </figure>
            </div>
            <div class="col-1"></div>
        </div>
        <div class="row mt-3">
            <div class="col-1"></div>
            <div class="col-2">
                <figure class="image">
                    <img style="width:150px;" src="{{ asset('front/assets/img/technoo.png')}}" alt="">
                </figure>
            </div>
            <div class="col-2">
                <figure class="image mt-3">
                    <img style="width:150px;" src="{{ asset('front/assets/img/bni.png')}}" alt="">
                </figure>
            </div>
            <div class="col-2">
                <figure class="image">
                    <img style="width:200px;" src="{{ asset('front/assets/img/tokopedia.png')}}" alt="">
                </figure>
            </div>
            <div class="col-2">
                <figure class="image">
                    <img style="width:150px;" src="{{ asset('front/assets/img/mnc.png')}}" alt="">
                </figure>
            </div>
            <div class="col-2">
                <figure class="image">
                    <img style="width:170px;" src="{{ asset('front/assets/img/asyst.png')}}" alt="">
                </figure>
            </div>
            <div class="col-1"></div>
        </div>
        <div class="row mb-3">
            <div class="col-1"></div>
            <div class="col-2">
                <figure class="image mt-3">
                    <img style="width:150px;" src="{{ asset('front/assets/img/datacomm.png')}}" alt="">
                </figure>
            </div>
            <div class="col-2">
                <figure class="image mt-3">
                    <img style="width:150px;" src="{{ asset('front/assets/img/TransRetail.png')}}" alt="">
                </figure>
            </div>
            <div class="col-1">
                <figure class="image">
                    <img style="width:70px;" src="{{ asset('front/assets/img/kominfo.png')}}" alt="">
                </figure>
            </div>
            <div class="col-1">
                <figure class="image">
                    <img style="width:50px;" src="{{ asset('front/assets/img/ntt.png')}}" alt="">
                </figure>
            </div>
            <div class="col-2">
                <figure class="image mt-3">
                    <img style="width:150px;" src="{{ asset('front/assets/img/transtrack.png')}}" alt="">
                </figure>
            </div>
            <div class="col-2">
                <figure class="image">
                    <img style="width:200px;" src="{{ asset('front/assets/img/telkom.png')}}" alt="">
                </figure>
            </div>
            <!-- <div class="col-1">
                <figure class="image">
                    <img style="width:50px;" src="{{ asset('front/assets/img/seven.png')}}" alt="">
                </figure>
            </div> -->
            <div class="col-1"></div>
        </div>
        <a href="https://magang-sas.telkomuniversity.ac.id/daftar-mitra/#1655554704954-bee5c091-bce5">
            <button class="btn btn-success">Lihat Selengkapnya <i class="ti ti-chevron-right me-1"></i></button>
        </a>
    </div>

    <div class="row m-5">
        <div class="col-12 text-center">
            <h4 style="color: #4EA971;">Keunggulan Fakultas Ilmu Terapan</h4>
            <h2>Program Unggulan yang Ditawarkan <br> Oleh Fakultas Ilmu Terapan! 💼 🚀</h2>
        </div>
        <div class="row justify-content-center mt-4 ms-1">
            <div class="col-3 border" style="border-radius: 8px; background:#DCEEE3;">
                <h4 class="mt-2" style="color: #4EA971;">01</h4>
                <h5>Perkuliahan Berbasis Industri</h5>
                <p>Fakultas Ilmu Terapan merupakan satu dari tujuh fakultas di Universitas Telkom yang fokus pada Pendidikan vokasi. Untuk menunjang kompetensi lulusan yang terampil serta match dengan kebutuhan industri, maka kurikulum pendidikan vokasi didesain menjadi 60% praktek dan 40% teori.</p>
            </div>
            <div class="col-3 border ms-3 me-3" style="border-radius: 8px;">
                <h4 class="mt-2" style="color: #4EA971;">02</h4>
                <h5>Mobility Program</h5>
                <p>Fakultas Ilmu Terapan aktif menyelenggarakan kegiatan Inbound Mobility & Outbound Mobility dengan Universitas Luar Negeri seperti Jerman, Korea, Taiwan dan Malaysia dan di tahun 2022 FIT telah menyelenggarakan 6 Program Mobility dengan jumlah mahasiswa sebanyak 380 mahasiswa.</p>
            </div>
        </div>
        <div class="row justify-content-center mt-4 ms-1">
            <div class="col-3 border" style="border-radius: 8px;">
                <h4 class="mt-2" style="color: #4EA971;">03</h4>
                <h5>Sertifikasi Kompetensi</h5>
                <p>Chevalier adalah sebuah laboratorium yang berada di Fakultas Ilmu Terapan (FIT) sebagai wadah bagi para mahasiswa yang memiliki ketertarikan dalam belajar ilmu teknologi, serta pengembangannya yang bergerak dalam lingkup perangkat lunak atau Software.</p>
            </div>
            <div class="col-3 border ms-3 me-3" style="border-radius: 8px; background:#DCEEE3;">
                <h4 class="mt-2" style="color: #4EA971;">04</h4>
                <h5>Ekosistem Research & Entreupreneurial</h5>
                <p>Untuk menunjang kreativitas dan kemampuan berwirausaha mahasiswa, maka fakultas membentuk wadah inkubasi melalui program ESSTaV-FIT (Ekosistem Sinkronisasi Startup di Vokasi – Fakultas Ilmu Terapan), Magang, Lomba, Pengabdian Masyarakat maupun Proyek Penelitian yang terekognisi ke dalam SKS matakuliah.</p>
            </div>
        </div>
    </div>

    <div class="row m-5">
        <div class="col-12 text-center">
            <h4 style="color: #4EA971;">Kunjungi Kami</h4>
        </div>
        <div class="row mt-4 ms-1">
            <div class="col-6 pt-5" style="padding-left: 100px;">
                <h6>Ruang Layanan Kerjasama dan Magang</h6>
                <h6>Gedung Selaru, lantai 1 Fakultas Ilmu Terapan</h6>
                <h6>Jl, Telekomunikasi No. 1, Terusan Buah Batu 40257 Bandung,<br> Jawa Barat, Indonesia</h6>

                <div class="mb-3">
                    <i class="ti ti-mail me-1"></i><a href="mailto:magangfit@telkomuniversity.ac.id" style="color: #6F6B7D;">magangfit@telkomuniversity.ac.id</a>
                </div>
                <div class="mb-3">
                    <i class="ti ti-brand-whatsapp me-1"></i><a href="https://wa.me/6285161415115" style="color: #6F6B7D;">+62 851-6141-5115</a>
                </div>
                <div class="mb-3">
                    <i class="ti ti-phone-call me-1"></i><a>(022) 5201159</a>
                </div>
                <div>
                    <i class="ti ti-brand-instagram me-1"></i><a href="https://www.instagram.com/magang.fit/?hl=id" style="color: #6F6B7D;">magang.fit</a>
                </div>
            </div>
            <div class="col-6">
                <div class="leaflet-map" id="dragMap"></div>
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