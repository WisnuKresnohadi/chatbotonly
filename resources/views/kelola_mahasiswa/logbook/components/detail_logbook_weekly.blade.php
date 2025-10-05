@if ($logbook_week->status == App\Enums\LogbookWeeklyStatus::REJECTED)
    @include('kelola_mahasiswa/logbook/components/rejected_reason')
@else
<div class="d-flex justify-content-between mb-3">
    <h5 class="my-auto">Logbook Minggu Ke-{{ $week }}</h5>
    @if ($logbook_week->status == App\Enums\LogbookWeeklyStatus::PENDING && (isset($isPembLapangan) && $isPembLapangan == true))
    <div class="d-flex justify-content-center">
        <button type="button" id="btn-approve" data-week="{{ $week }}" data-id="{{ $logbook_week->id_logbook_week }}" class="btn btn-primary me-1"><i class="ti ti-check ms-0 me-1"></i>Setujui</button>
        <button type="button" id="btn-reject" data-week="{{ $week }}" data-id="{{ $logbook_week->id_logbook_week }}" class="btn btn-danger"><i class="ti ti-x ms-0 me-1"></i>Tolak</button>
    </div>
    @endif
</div>
@foreach ($data as $item)
    <div style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 20px; margin-bottom: 30px;">
        <div class="d-flex justify-content-between">
            <div class="d-flex align-items-center">
                @if ($item->activity == 'Libur')
                <div class="rounded-pill d-flex flex-column align-items-center justify-content-center" style="background-color: #070A0F80; width: 70px; height: 70px;">
                    <img src="{{ asset('assets/images/smile.png') }}" alt="" style="filter: grayscale(80%) opacity(50%);">
                </div>
                @else
                <div class="rounded-pill d-flex flex-column align-items-center justify-content-center" style="background-color: #C4E2D0; width: 70px; height: 70px;">
                    <img src="{{ App\Enums\LogbookDailyEmot::getWithEmot($item->emoticon)['image'] }}" alt="">
                </div>
                @endif
                <div class="ms-3">
                    <h6 class="mb-0">{{ Carbon\Carbon::parse($item->date)->format('l') }}</h6>
                    <p class="fw-normal mb-0">{{ Carbon\Carbon::parse($item->date)->format('d F Y') }}</p>
                </div>
            </div>
        </div>
        <p style="color: #B6BAC3; margin-top: 15px;">Kamu melakukan Pekerjaan Apa Hari Ini ?</p>
        <p>
            @if (Str::wordCount($item->activity) > 25)
            <span class="sibling-fake">{{ Str::words($item->activity, 25, '...') }}</span>
            <span class="sibling-real d-none">{{ $item->activity }}</span>
            <a class="show_hide_new cursor-pointer" data-shortened="true" style="color:#4EA971">Show More</a>
            @else
            <span class="sibling-fake">{{ $item->activity }}</span>
            @endif
        </p>
    </div>
@endforeach
@endif