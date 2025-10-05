<x-mail::message>
<p style="font-size: 16pt;text-align: center;font-weight: bold;">{{ $subject }}</p>
<p style="font-size: 14pt;font-weight:500;margin-bottom: 5px;">Halo, {{ $name }}!</p>
<p style="font-size: 12pt;margin-bottom: 30px;">Registrasi anda ditolak oleh LKM untuk alasan berikut:</p>
<div class="card" style="background-color: #edf2f7d1;">
    <div class="card-body" style="padding: 12px !important;">
        <p style="margin-bottom: 0px;font-weight: 500">{{ $reason }}</p>
    </div>
</div>
<div style="margin-top: 2rem !important;">
    <p style="font-size: 12pt;margin-bottom:0;font-weight: 600;">Dengan hormat,</p>
    <p style="font-size: 12pt;margin-bottom:0;font-weight: 600;">LKM</p>
</div>
</x-mail::message>