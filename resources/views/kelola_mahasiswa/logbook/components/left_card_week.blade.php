@if (count($list_week))
@foreach ($list_week as $key => $item)
<div class="mt-3 cursor-pointer" style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 10px;" onclick="getLogbook($(this));">
    <div class="row">
        <div class="col-auto my-auto pe-1">
            <div class="form-check form-check-primary">
                <input name="selected_logbook" class="form-check-input" type="radio" value="{{ $item->id_logbook_week }}" data-week="{{ $loop->iteration }}" id="logbook_{{ $key }}" {{ ((isset($checked) && $checked == $item->id_logbook_week) ?: $loop->first) ? 'checked' : '' }}>
            </div>
        </div>
        <div class="col ps-0 d-flex justify-content-between">
            <div class="d-flex flex-column align-items-start">
                <h6 class="mb-1">Minggu Ke {{ $loop->iteration }}</h6>
                <p class="mb-0" style="font-size: small;">{{ Carbon\Carbon::parse($item->start_date)->format('d') }}&ensp;-&ensp;{{ Carbon\Carbon::parse($item->end_date)->format('d M Y') }}</p>
            </div>
            @if (isset($showStatus) && $showStatus == true)
            <div class="d-flex justify-content-end align-items-center">
                @php
                    $status = App\Enums\LogbookWeeklyStatus::getWithLabel($item->status);
                    $item->status = "<span class='badge bg-label-" . $status['color'] . "'>" . $status['title'] . "</span>";
                @endphp
                {!! $item->status !!}
            </div>
            @endif
        </div>
    </div>
</div>
@endforeach
@else
    <h4 class="text-center">Kosong</h4>
@endif