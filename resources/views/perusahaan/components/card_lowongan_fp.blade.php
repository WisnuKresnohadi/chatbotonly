@foreach($lowongan as $l)
    <div class="col-lg-12 col mb-2 card-desktop">
        <div class="card border cursor-pointer" data-id="{{$l['id_lowongan']}}" onclick="detail($(this))">
            <div class="card-body on-hover-dark">
                <div class="d-flex justify-content-between card-header mb-3" style="background-color: #FFFFFF; padding:0px;">
                    <div class="d-flex justify-content-start">
                        <div class="text-center" style="overflow: hidden; width: 100px; height: 100px;">
                        @if ($l['image'])
                            <img src="{{ url('storage/' . $l['image']) }}" alt="profile-image" class="d-block" width="100" alt="img">
                        @else
                            <img src="{{ asset('app-assets/img/avatars/building.png') }}" alt="user-avatar" class="d-block" width="100">
                        @endif
                        </div>
                        <div class="ms-2 my-auto">
                            <h5 class="mb-1">{{ Str::limit($l['intern_position'], 30, $end='...')}}</h5>
                            <p class="mb-0">{{ Str::limit($l['namaindustri'], 33, $end='...') }}</p>
                        </div>
                    </div>
                    <div class="ms-2">
                        @if($isMahasiswa)
                        <a onclick="myFunction(event, $(this));" data-id="{{$l['id_lowongan']}}" class="text-primary cursor-pointer bookmark" style="z-index: 8;">
                            @if (in_array($l['id_lowongan'], $lowongan_tersimpan))
                            <i class="fa-solid fa-bookmark" style="font-size: 25px;"></i>
                            @else
                            <i class="fa-regular fa-bookmark" style="font-size: 25px;"></i>
                            @endif
                        </a>
                        @endif
                    </div>
                </div>
                <div class="border"></div>
                <div class="map-pin mt-3 mb-3">
                    <i class="ti ti-map-pin" style="margin-right: 10px;margin-bottom:5px;"></i>
                    {{ implode(', ', json_decode($l['lokasi'])) }}
                </div>
                <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px">
                    <i class="ti ti-cash" style="margin-right: 10px;margin-bottom:5px;"></i>
                    {{ uangSakuRupiah($l['nominal_salary']) }}
                </div>
                <div class="briefcase mb-3" style="margin-left: 1px;">
                    <i class="ti ti-calendar-time" style="margin-right: 10px;margin-bottom:5px;"></i>
                    {{ implode(' dan ', json_decode($l['durasimagang'])) }}
                </div>
                <div class="briefcase mb-3" style="margin-left: 1px;">
                    <i class="ti ti-users" style="margin-right: 10px;margin-bottom:5px;"></i>
                    {{$l['kuota_terisi'] ?? ''}}/{{$l['kuota'] ?? ''}} Kuota Tersedia
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col mb-2 mt-4 card-mobile" style="position: relative; margin: auto; color: #5d596c;">
        <div class="card border cursor-pointer" data-id="{{$l['id_lowongan']}}" style="position: relative; color: #5d596c;">
            <a class="card-body on-active-dark" href="{{ route('dashboard.detail-lowongan', $l['id_lowongan']) }}">
                <div class="d-flex justify-content-between card-header mb-3" style="background-color: #FFFFFF; padding:0px; position: relative;">
                    <div class="d-flex justify-content-start">
                        <div class="text-center" style="overflow: hidden; width: 100px; height: 100px;">
                        @if ($l['image'])
                            <img src="{{ url('storage/' . $l['image']) }}" alt="profile-image" class="d-block" width="100" alt="img">
                        @else
                            <img src="{{ url('app-assets/img/avatars/building.png') }}" alt="user-avatar" class="d-block" width="100">
                        @endif
                        </div>
                        <div class="ms-2 my-auto">
                            <h5 class="mb-1 text-truncate">{{$l['intern_position'] ?? ''}}</h5>
                            <p class="mb-0">{{$l['namaindustri'] ?? ''}}</p>
                        </div>
                    </div>
                </div>
                <div class="border"></div>
                <div class="map-pin mt-3 mb-3">
                    <i class="ti ti-map-pin" style="margin-right: 10px;margin-bottom:5px;"></i>
                    {{ implode(', ', json_decode($l['lokasi'])) }}
                </div>
                <div class="currency-dollar mb-3" style="margin-left: -1px; margin-right: 10px">
                    <i class="ti ti-cash" style="margin-right: 10px;margin-bottom:5px;"></i>
                    {{ uangSakuRupiah($l['nominal_salary']) }}
                </div>
                <div class="briefcase mb-3" style="margin-left: 1px;">
                    <i class="ti ti-calendar-time" style="margin-right: 10px;margin-bottom:5px;"></i>
                    {{ implode(' dan ', json_decode($l['durasimagang'])) }}
                </div>
                <div class="briefcase mb-3" style="margin-left: 1px;">
                    <i class="ti ti-users" style="margin-right: 10px;margin-bottom:5px;"></i>
                    {{$l['kuota_terisi'] ?? ''}}/{{$l['kuota'] ?? ''}} Kuota Tersedia
                </div>
            </a>
            <div class="ms-2" style="position: absolute; right: 1.5%; top:1.5%;">
                @if($isMahasiswa)
                <a onclick="myFunction(event, $(this));" data-id="{{$l['id_lowongan']}}" class="text-primary cursor-pointer bookmark">
                    @if (in_array($l['id_lowongan'], $lowongan_tersimpan))
                    <i class="fa-solid fa-bookmark" style="font-size: 25px;"></i>
                    @else
                    <i class="fa-regular fa-bookmark" style="font-size: 25px;"></i>
                    @endif
                </a>
                @endif
            </div>
        </div>
    </div>
@endforeach
