<x-mail::message>
<p style="font-size: 16pt;text-align: center;font-weight: bold;">{{ $subject }}</p>
<p style="font-size: 14pt;font-weight:500;margin-bottom: 10px;">Halo, {{ $name }}!</p>
<p style="font-size: 12pt;font-weight:500;margin-bottom: 10px;">{{ $message }}</p>
<div class="card" style="background-color: #edf2f7d1;">
    <div class="card-body" style="padding: 12px !important;">
        <p style="margin-bottom: 0px;">Untuk mengatur password, dapat dengan menekan tombol berikut.</p>
    </div>
</div>
<div style="margin-top: 42px;">
    @component('mail::button', ['url' => $url])
    <span style="font-size: 11pt;font-weight: 500;">
        Atur Password Sekarang
    </span>
    @endcomponent
</div>
<div style="margin-top: 5rem !important;">
    <p style="font-size: 12pt;margin-bottom:0;font-weight: 600;">Dengan hormat,</p>
    <p style="font-size: 12pt;margin-bottom:0;font-weight: 600;">LKM</p>
</div>
</x-mail::message>