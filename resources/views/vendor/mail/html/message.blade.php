<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header>
</x-mail::header>
</x-slot:header>
{{-- Body --}}
<div class="card" style="margin: 0px auto 0px auto;">
    <div class="card-header">
        <div style="padding-bottom:1rem;border-bottom: #33333321 1px solid;">
            <img src="{{ asset('app-assets/img/logo_talentern.png') }}" alt="logo_talentern">
        </div>
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
    <div class="card-footer">
        <div style="text-align:center;padding-top: 1rem;border-top: #33333321 1px solid;">
            <small>Copyright by PT Teknologi Nirmala Olah Daya Informasi (Techno Infinity)</small>
        </div>
    </div>
</div>
{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>

</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
