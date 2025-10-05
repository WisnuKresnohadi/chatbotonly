<x-mail::layout>
<div class="container-luar">
    <div class="container">
        <div class="card" style="max-width: 500px;margin: 20px auto;">
            <div class="card-header">
                <div style="padding-bottom:1rem;border-bottom: #33333372 1px solid;">
                    <img src="{{ public_path('app-assets/img/logo_talentern.svg') }}" width="200" alt="logo_talentern">
                </div>
            </div>
            <div class="card-body">
                {{ $slot }}
                <div style="margin-top: 5rem !important;">
                    <p class="fw-semibold fs-6 mb-0">Dengan hormat,</p>
                    <p class="fw-semibold fs-6">Talentern</p>
                </div>
            </div>
            <div class="card-footer text-center">
                <div class="border-top pt-3">
                    <small>Copyright by PT Teknologi Nirmala Olah Daya Informasi (Techno Infinity)</small>
                </div>
            </div>
        </div>
    </div>
</div>
</x-mail::layout>