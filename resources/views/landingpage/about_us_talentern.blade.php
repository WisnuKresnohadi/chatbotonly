@extends('partials.horizontal_menu')

@section('page_style')
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
<div class="container-xxl flex-grow-1 container-p-y" style="margin: auto;">
    <div class="row ms-5 me-5">
        <div class="col-6">
            <h1 style="color: #FF9F43;">About Us</h1>
            <h3> <span style="color: #4EA971;"> TALENTERN </span> magang terbaik dengan perusahaan terpilih.</h3>
            <p>Mengejar impian untuk terus tumbuh dan berkembang sesuai dengan minat dan bakat kita bukan hanya sekadar
                keinginan, tapi petualangan seru yang mengasyikkan bagi setiap mahasiswa! Persiapkan dirimu untuk
                menghadapi realita dunia pekerjaan dengan mengikuti program magang melalui Talentern, di mana berbagai
                pilihan perusahaan menantimu. Let's turn the journey of professional growth into a fun-filled adventure!
                🌟</p>
            <a href="/lowongan/magang">
                <button class="btn btn-success"><i class="ti ti-search me-1"></i> Cari Magang</button>
            </a>
        </div>
        <div class="col-6">
            <div style="border-radius: 10px; background: linear-gradient(0deg, rgba(255, 255, 255, 0.30) 0%, rgba(255, 255, 255, 0.30) 100%), rgba(220, 238, 227, 0.60); width:50%; height:80%; margin-left:170px; margin-right:200px;">
                <figure class="image" style="margin-left:100px; margin-top:20px;">
                    <img style="height:200px; width: 300px; margin-top:-30px;" src="{{ asset('front/assets/img/Rectangle 14.png')}}" alt="admin.upload">
                </figure>
                <figure class="image" style="margin-left:-40px;">
                    <img style="height:200px; width: 300px;" src="{{ asset('front/assets/img/Rectangle 13.png')}}" alt="admin.upload">
                </figure>
            </div>
        </div>
    </div>
    <div class="row m-5">
        <div class="col-6 text-center" style="padding-left: 100px;">
            <div style="border-radius: 10px; background: linear-gradient(0deg, rgba(255, 255, 255, 0.30) 0%, rgba(255, 255, 255, 0.30) 100%), rgba(220, 238, 227, 0.60); width:63%; height:90%;">
                <figure class="image">
                    <img style="height:350px; width: 300px; margin-top: 20px;" src="{{ asset('front/assets/img/company.png')}}" alt="admin.upload">
                </figure>
            </div>
        </div>
        <div class="col-6">
            <h4 style="color: #4EA971;">Mitra Perusahaan</h4>
            <h3>Bersinergi dengan berbagai perusahaan keren yang tersebar di berbagai kota!🌍✨</h3>
            <p>Temukan perusahaan impianmu dengan berbagai pilihan seru di website Talentern. Ayo, kembangkan
                kemampuanmu dan berikan kontribusi terbaikmu untuk menciptakan kisah sukses yang menggembirakan bersama
                perusahaan yang kamu pilih! </p>
            <a href="/daftar_perusahaan">
                <button class="btn btn-success"><i class="ti ti-search me-1"></i> Cari Perusahaan</button>
            </a>
        </div>
    </div>
    <div class="row m-5">
        <div class="col-12 text-center">
            <h3>Meet The Team</h3>
        </div>
        <div class="mt-4 ms-1" style="display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 1rem;">
            <div class="col border" style="border-radius: 8px; background:#FFF; width: 100%; display: flex; flex-direction: column;">
                <img src="#" alt="Photo Profile" style="height: 10rem; margin-bottom: 1rem;">
                <span class="fw-bold mb-2 px-3" style="font-size: large;">IGN.Brindwan Tri Guna Yoga</span>
                <p class="px-3">Back-End Developer</p>
            </div>
            <div class="col border" style="border-radius: 8px; background:#FFF;  width: 100%; display: flex; flex-direction: column;">
                <img src="#" alt="Photo Profile" class="img-fluid" style="height: 10rem; margin-bottom: 1rem;">
                <span class="fw-bold mb-2 px-3" style="font-size: large;">IGN.Brindwan Tri Guna Yoga</span>
                <p class="px-3">Back-End Developer</p>
            </div>
            <div class="col border" style="border-radius: 8px; background:#FFF;  width: 100%; display: flex; flex-direction: column;">
                <img src="#" alt="Photo Profile" class="img-fluid" style="height: 10rem; margin-bottom: 1rem;">
                <span class="fw-bold mb-2 px-3" style="font-size: large;">IGN.Brindwan Tri Guna Yoga</span>
                <p class="px-3">Back-End Developer</p>
            </div>
            <div class="col border" style="border-radius: 8px; background:#FFF;  width: 100%; display: flex; flex-direction: column;">
                <img src="#" alt="Photo Profile" class="img-fluid" style="height: 10rem; margin-bottom: 1rem;">
                <span class="fw-bold mb-2 px-3" style="font-size: large;">IGN.Brindwan Tri Guna Yoga</span>
                <p class="px-3">Back-End Developer</p>
            </div>
            <div class="col border" style="border-radius: 8px; background:#FFF;  width: 100%; display: flex; flex-direction: column; ">
                <img src="#" alt="Photo Profile" class="img-fluid" style="height: 10rem; margin-bottom: 1rem;">
                <span class="fw-bold mb-2 px-3" style="font-size: large;">IGN.Brindwan Tri Guna Yoga</span>
                <p class="px-3">Back-End Developer</p>
            </div>
        </div>
    </div>
    <div class="row m-5">
        <div class="col-12 text-center">
            <h4 style="color: #4EA971;">Fitur dan Keunggulan</h4>
            <h3>Beberapa keunggulan dan fitur seru yang <br>disajikan oleh Talentern!🌟</h3>
        </div>
        <div class="row mt-4 ms-1">
            <div class="col-3 border" style="border-radius: 8px; background:#DCEEE3;">
                <h4 class="mt-2">01</h4>
                <h5>Kemudahan Melamar</h5>
                <p>"Hanya dengan mengikuti 5 langkah mudah, Anda dapat meraih posisi impian Anda dalam program magang. Mari mulai perjalanan menuju kesuksesan bersama-sama!"</p>
            </div>
            <div class="col-3 border ms-3 me-3" style="border-radius: 8px;">
                <h4 class="mt-2">02</h4>
                <h5>Berbagai Pilihan Lowongan</h5>
                 <p>Talentern menyediakan beragam pilihan lowongan magang yang sesuai dengan keinginan dan kemampuan Anda. Temukan peluang yang tepat untuk mewujudkan impian karier Anda dengan kami.</p>
            </div>
            <div class="col-3 border" style="border-radius: 8px; background:#DCEEE3;">
                <h4 class="mt-2">03</h4>
                <h5>Pekerjaan Sesuai Keinginan</h5>
                 <p>Kemampuan yang Anda miliki merupakan langkah awal untuk membangun masa depan yang Anda inginkan. Lakukan pekerjaan sesuai keinginanmu, dan bentuk masa depan yang diimpikan bersama kami.</p>
            </div>
        </div>
        <div class="row mt-4 ms-1">
            <div class="col-3 border" style="border-radius: 8px;">
                <h4 class="mt-2">04</h4>
                <h5>Membuat CV Otomatis</h5>
                 <p>Hanya dengan melengkapi informasi dan data yang diperlukan di website Talentern, Anda dapat dengan cepat dan efisien memiliki CV dalam format ATS. Mudahkan langkah pertama menuju kesuksesan karier Anda bersama kami!</p>
            </div>
            <div class="col-3 border ms-3 me-3" style="border-radius: 8px; background:#DCEEE3;">
                <h4 class="mt-2">05</h4>
                <h5>Berbagai Pilihan Perusahaan</h5>
                 <p>Berbagai pilihan perusahaan menantimu untuk berkembang dan memberikan kontribusi terbaikmu kepada perusahaan yang kamu impikan. Ayo jadikan setiap peluang sebagai langkah maju menuju karier impianmu!</p>
            </div>
            <div class="col-3 border" style="border-radius: 8px;">
                <h4 class="mt-2">06</h4>
                <h5>Keamanan Data Pribadi</h5>
                 <p>Tidak perlu khawatir, karena data yang Anda masukkan ke Talentern akan dijaga kerahasiaannya dengan ketat. Privasi Anda adalah prioritas utama bagi kami.</p>
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