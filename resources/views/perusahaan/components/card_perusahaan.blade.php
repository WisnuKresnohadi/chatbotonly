@foreach($industries as $key => $i)
    <div class="col-lg-4 col card border w-100">
        <div class="card-body">
            <a href="{{ route('daftar_perusahaan.detail', ['id' => $i['id_industri']]) }}" class="text-decoration-none" style="color: var(--bs-body-color);">
                <div class="d-flex justify-content-start">
                    @if ($i['image'])
                    <img class="img-thumbnail" src="{{ url('storage/' . $i['image']) }}" style="max-width: 80px;max-height: 80px;" alt="admin.upload">
                    @else
                    <img class="img-thumbnail" src="{{ asset('app-assets/img/avatars/building.png') }}" style="max-width: 80px;max-height: 80px;" alt="admin.upload">
                    @endif
                    <h4 class="my-auto ms-3">{{ Str::limit($i['namaindustri'], 35, $end='...') }}</h4>
                </div>
                <div class="mt-3 mb-2">
                    <i class="ti ti-map-pin" style="padding-right :5px; padding-bottom:5px;"></i>
                    <span>{{$i['alamatindustri']}}</span>
                </div>
                <div class="mb-3">
                    <i class="ti ti-briefcase" style="padding-right :5px; padding-bottom:5px;"></i>
                    <span>{{ $i['lowongan_magang_count'] }} lowongan</span>
                </div>
            </a>
        </div>
    </div>
@endforeach