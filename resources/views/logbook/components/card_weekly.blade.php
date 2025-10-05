@foreach ($logbook_week as $item)
<a href="{{ route('logbook.detail', $item->id_logbook_week) }}" class="text-reset">
    <div class="mb-4" style="display: flex; justify-content: space-between; border: 1px solid #D3D6DB; padding: 10px 30px; background-color: white; border-radius: 6px; ">
        <div class="mt-3">
            {!! $item->status !!}
            <h5 class="mb-1">{{ Carbon\Carbon::parse($item->start_date)->format('d') }}&ensp;-&ensp;{{ Carbon\Carbon::parse($item->end_date)->format('d F Y') }}</h5>
            <p>Minggu ke - {{ $item->week }}</p>
        </div>
        <div class="mt-3 d-flex justify-content-between">
            @foreach ($item->logbookDay as $item2)
            <div class="mx-1 d-flex flex-column align-items-center">
                <small>{{ Carbon\Carbon::parse($item2->date)->format('D') }}</small>
                <img src="{{ App\Enums\LogbookDailyEmot::getWithEmot($item2->emoticon)['image'] }}">
            </div>
            @endforeach
        </div>
    </div>
</a>
@endforeach
