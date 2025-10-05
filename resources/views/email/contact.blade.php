<html>
<div style="text-align: center;">
    <a href="https://imgbb.com/"><img src="https://i.ibb.co/vm3vPmc/banner-image.png" alt="banner-image" border="0"></a>
</div>

<h2 style="font-size:24px; color: #222;">Hi Admin LKM,</h2>

<p style="color: #222;">Perkenalkan saya <strong>{{ $user['name'] }}</strong> asal instansi
    <strong>{{ $user['institutions'] }}.</strong> Saya ingin menyampaikan keluhan yaitu {{ $user['note'] }}</span>.
</p>

<p style="color: #4B465C;">Dokumen Pendukung:</p>
<p><a href="{{ $user['file'] }}">Bukti Keluhan</a></p>
{{-- <p><img src="{{ $message->embed($user['file']) }}"></p> --}}

<p style="color: #222; font-weight: 600;"> Best Regards, <br>
    {{ $user['name'] }}</p>
<div>
    {{-- <x-mail::subcopy> --}}
    <hr>
    <div style="text-align: center;">
        <a href="https://www.instagram.com/techno_infinity/"><img src="{{ $message->embed(public_path() . '/app-assets/img/icons/brands/ig.png') }}" style="margin-right: 8px;"></a>
        <a href="https://www.linkedin.com/company/techno-infinity/"><img src="{{ $message->embed(public_path() . '/app-assets/img/icons/brands/linkedin.png') }}"></a>
    </div>
    <hr>
    <p style="text-align: center; color: #4EA971;">© 2024 talentern.id All Rights Reserved. Crafted with PASSION by
        Proxsis Solusi Humakan & Techno Infinity</p>
    {{-- </x-mail::subcopy> --}}
</div>

</html>
{{-- </x-mail::message> --}}
