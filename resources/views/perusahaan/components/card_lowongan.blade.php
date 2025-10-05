@foreach ($lowongan as $key => $item)
<a class="card-lowongan-lainnya-mobile p-3 d-flex flex-column btn align-items-start  on-hover-dark justify-content-between {{ ($key+1) != count($lowongan) ? 'border-bottom' : '' }} hover-dark border rounded cursor-pointer" data-id="{{$item['id_lowongan']}}" href="{{ route('daftar_perusahaan.detail-lowongan',  $item['id_lowongan']) }}">
    <div class="d-flex justify-content-start align-items-center">
        <div class="text-center me-4" style="overflow: hidden; width: 100px; height: 100px;">
            @if ($detail->image)
            <img src="{{ asset('storage/'. $detail->image) }}" alt="user-avatar" class="d-block" width="100">
            @else
            <img src="{{ asset('app-assets/img/avatars/building.png') }}" alt="user-avatar" class="d-block" width="100">
            @endif
        </div>
        <div class="ms-3 d-flex flex-column align-items-start">
            <h2 class="mb-1" style="font-size: 1.5rem;">{{ $item['namabidangpekerjaan'] }}</h2>
            <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">{{ $detail->namaindustri }}</p>
            <p>{{ $detail->alamatindustri }}</p>
        </div>
    </div>
    <div class="mt-2">
        <i class="ti ti-clock mb-1"> </i>
        {{ Carbon\Carbon::parse($item['created_at'])->diffForHumans(Carbon\Carbon::now()) }}
    </div>
</a>

<div class="card-lowongan-lainnya-desktop py-4 my-4 px-4 align-items-start d-flex justify-content-between {{ ($key+1) != count($lowongan) ? 'border-bottom' : '' }} hover-dark card cursor-pointer" data-id="{{$item['id_lowongan']}}">
    <div class="d-flex justify-content-between align-items-start w-100">
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-center me-4" style="overflow: hidden; width: 100px; height: 100px;">
                @if ($detail->image)
                <img src="{{ asset('storage/'. $detail->image) }}" alt="user-avatar" class="d-block" width="100">
                @else
                <img src="{{ asset('app-assets/img/avatars/building.png') }}" alt="user-avatar" class="d-block" width="100">
                @endif
            </div>
            <div class="d-flex flex-column align-items-start gap-2">
                <p>
                    @if($item['status'] == 1 && $item['startdate'] <= now()->format('Y-m-d') && $item['enddate'] >= now()->format('Y-m-d'))
                    <span class='badge bg-label-primary'>Lowongan Aktif</span>
                    @elseif ($item['status'] == 1 && $item['startdate'] >= now()->format('Y-m-d'))
                    <span class='badge bg-label-warning'>Segera Hadir</span>
                    @else
                    <span class='badge bg-label-danger'>Lowongan Non-aktif</span>
                    @endif
                </p>
                {{-- Nama intern position --}}
                <h2 class="mb-1">{{ $item['namabidangpekerjaan'] }}</h2>
                <p style="text-align: left !important; font-size:15px; margin-bottom: 0px;">{{ $detail->namaindustri }}</p>
                <p>{{ $detail->alamatindustri }}</p>
                <a class="btn btn-primary text-white" href="{{ route('daftar_perusahaan.detail-lowongan',  $item['id_lowongan']) }}" >Detail Lowongan</a>
            </div>
        </div>
        <div class="mt-0">
            <i class="ti ti-clock mb-1"> </i>
            {{ Carbon\Carbon::parse($item['created_at'])->diffForHumans(Carbon\Carbon::now()) }}
        </div>
    </div>
</div>
@endforeach
