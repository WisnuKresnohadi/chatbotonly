<html>
<div style="text-align: center;">
    {{-- <img src= {{ $pathToFile }}> --}}
    <a href="https://imgbb.com/"><img src="https://i.ibb.co/vm3vPmc/banner-image.png" alt="banner-image" border="0"></a>
</div>

<h2 style="font-size:24px; color: #222;">Hi, {{ $user }}</h2>

<p style="color: #222;">Selamat anda berhak melanjutkan proses <span style="color: #222; font-weight: 600;">Seleksi Tahap
        1</span> pada <span style="color: #222; font-weight: 600;">PT. ABC</span> dengan posisi <span
        style="color: #222; font-weight: 600;">UI/UX Designer.</span> Pastikan untuk menyusun portofolio dan
    mempersiapkan diri anda untuk menghadapi tahap berikutnya.</p>

<p style="color: #4B465C;">Berikut File Jadwal <span style="color: #222; font-weight: 600;">Seleksi Tahap 1:</span></p>

<p style="color: #4B465C;">Jika memiliki kendala atau hambatan untuk <span
        style="color: #222; font-weight: 600;">Seleksi Tahap 1</span> silahkan hubungi penanggungjawab seleksi dibawah
    ini : </p>

<p style="color: #222; font-weight: 600;">Regards, <br>
    Harmonie</p>

<div>
    {{-- <x-mail::subcopy> --}}
    <hr>
    <div style="text-align: center;">
        <a href="https://www.instagram.com/techno_infinity/"><img
                src="{{ $message->embed(public_path() . '/app-assets/img/icons/brands/ig.png') }}"
                style="margin-right: 8px;"></a>
        <a href="https://www.linkedin.com/company/techno-infinity/"><img
                src="{{ $message->embed(public_path() . '/app-assets/img/icons/brands/linkedin.png') }}"></a>
    </div>
    <hr>
    <p style="text-align: center; color: #4EA971;">© 2024 talentern.id All Rights Reserved. Crafted with PASSION by
        Proxsis Solusi Humakan & Techno Infinity</p>
    {{-- </x-mail::subcopy> --}}
</div>

</html>
