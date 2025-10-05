<x-mail::message>
<p style="font-size: 16pt;text-align: center;font-weight: bold;">{{ $subject }}</p>
<p style="font-size: 14pt;font-weight:500;margin-bottom: 10px;">Halo, {{ $name }}!</p>
<p style="font-size: 12pt;margin-bottom: 10px;">Anda menerima notifikasi dari perusahaan <span style="font-weight:500;">{{ $company }}</span>! Silahkan periksan di Talentern anda.</p>
<div class="card" style="background-color: #edf2f7d1;">
    <div class="card-body" style="padding: 12px !important;">
        {!! $content !!}
    </div>
</div>
</x-mail::message>