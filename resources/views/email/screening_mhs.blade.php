<x-mail::message>
<p style="font-size: 16pt;text-align: center;font-weight: bold;">{{ $subject }}</p>
<p style="font-size: 14pt;font-weight:500;margin-bottom: 10px;">Halo, {{ $dataMhs['industri'] }}!</p>
<p style="font-size: 12pt;margin-bottom: 10px;">Ada kandidat magang baru yang ingin bergabung menjadi <span style="font-weight:500;">{{ $dataMhs['lowongan'] }}</span>. Anda dapat melakukan screening pada kandidat dibawah ini.</p>
<div class="card" style="background-color: #edf2f7d1;">
    <div class="card-body" style="padding: 12px !important;">
        <p style="font-size:17px;font-weight:500;margin-bottom: 15px;">Informasi Pribadi.</p>
        <p style="margin-bottom: 0px;">Nama : {{ $dataMhs['name'] }}</p>
        <p style="margin-bottom: 0px;">NIM : {{ $dataMhs['nim'] }}</p>
        <p style="margin-bottom: 15px;">Prodi : {{ $dataMhs['prodi'] }}</p>
        <p style="font-size:17px;font-weight:500;margin-bottom: 15px;">Mengapa saya harus diterima?</p>
        <p style="margin-bottom: 0px;">{{ $dataMhs['reason'] }}</p>
    </div>
</div>
<div style="margin-top: 42px;">
    @component('mail::button', ['url' => $dataMhs['url_redirect']])
    <span style="font-size: 11pt;font-weight: 500;">
        Masuk ke Aplikasi
    </span>
    @endcomponent
</div>
<div style="margin-top: 5rem !important;">
    <p style="font-size: 12pt;margin-bottom:0;font-weight: 600;">Dengan hormat,</p>
    <p style="font-size: 12pt;margin-bottom:0;font-weight: 600;">LKM</p>
</div>
</x-mail::message>