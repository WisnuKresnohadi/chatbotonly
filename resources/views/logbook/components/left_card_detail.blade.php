<div class="d-flex">
    {!! $data->label_status !!}
</div>
<div class="d-flex align-items-center mt-1 mb-3">
    <h5 class="mb-0">{{ Carbon\Carbon::parse($data->start_date)->format('d') }}&ensp;-&ensp;{{ Carbon\Carbon::parse($data->end_date)->format('d F Y') }}</h5>
    <i class="ti ti-chevron-right"></i>
</div>
<div class="d-flex">
    <p>Minggu ke - {{ $data->week }}</p>
</div>
<div class="d-flex {{ count($data->emoticon) > 3 ? 'justify-content-between' : 'justify-content-start' }}">
    @foreach ($data->emoticon as $item)
        <div class="d-flex flex-column mx-1 align-items-center">
            <small>{{ Carbon\Carbon::parse($item->date)->format('D') }}</small>
            <img src="{{ App\Enums\LogbookDailyEmot::getWithEmot($item->emoticon)['image'] }}">
        </div>
    @endforeach
</div>