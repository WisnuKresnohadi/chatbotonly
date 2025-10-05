@if($approved->count() == 0)
<img src="\assets\images\nothing.svg" alt="no-data" style="display: flex; margin-left: auto; margin-right: auto; margin-top: 5%; margin-bottom: 5%;  width: 28%;">
<div class="sec-title mt-5 mb-4 text-center">
    <h4>Anda tidak memiliki lamaran yang diterima!</h4>
</div>
@else
@foreach($approved as $item)
<div class="cursor-pointer card mt-4" onclick="window.location.href='{{ route('lamaran_saya.detail', $item->id_pendaftaran) }}'">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div class="d-flex justify-content-start">
                <div class="text-center" style="overflow: hidden; width: 125px; height: 125px;">
                    @if ($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="user-avatar" class="d-block" width="125" id="image_industri">
                    @else
                        <img src="{{ asset('app-assets/img/avatars/building.png') }}" alt="user-avatar" class="d-block" width="125" id="image_industri" data-default-src="{{ asset('assets/images/no-pictures.png') }}">
                    @endif
                </div>
                <div class="d-flex flex-column justify-content-center ms-2">
                    <h4 class="mb-1">{{$item->intern_position}}</h4>
                    <p class="mb-0">{{$item->namaindustri}}</p>
                </div>
            </div>
            <div>
                {!! $item->status_badge !!}
            </div>
        </div>
        <div class="my-3">
            <p>{!! nl2br($item->deskripsi) !!}</p>
        </div>
        <hr />
        <div class="d-flex justify-content-between mt-2">
            <div class="d-flex justify-content start">
                <div class="d-flex justify-content-start align-items-center">
                    <i class="me-2 ti ti-map-pin" style="font-size: medium;"></i>
                    {{ implode(', ', json_decode($item->lokasi)) }}
                </div>
                <div class="ms-3 d-flex justify-content-start align-items-center">
                    <i class="me-2 ti ti-cash" style="font-size: medium;"></i> 
                    {{ uangSakuRupiah($item->nominal_salary) }}
                </div>
                <div class="ms-3 d-flex justify-content-start align-items-center">
                    <i class="me-2 ti ti-calendar-time" style="font-size: medium;"></i>
                    {{ implode(', ', json_decode($item->durasimagang)) }}
                </div>
                <div class="ms-3 d-flex justify-content-start align-items-center">
                    <i class="me-2 ti ti-users" style="font-size: medium;"></i>
                    {{ $item->kuota }} Kuota Penerimaan
                </div>
            </div>
            <div class="d-flex justify-content-end text-primary">
                Lamaran terkirim pada&ensp;<b>{{($item->tanggaldaftar?->format('d F Y')) }}</b>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif