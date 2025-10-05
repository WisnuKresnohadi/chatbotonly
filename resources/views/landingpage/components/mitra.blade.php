<div class="row d-flex justify-content-center mx-5" style="height: 18rem;">
    @foreach ($mitra as $item)
        <div class="col-md-4 mt-5" style="height: 100%;">
            <div class="card" style="height: 100%;">
                <div class="card-body text-start" style="height: 100%;">
                        @if ($item->image)
                        <img class="img-thumbnail mb-3" src="{{ $item->image }}" style="max-height: 80px;" alt="admin.upload">   
                        @else
                        <img class="img-thumbnail mb-3" src="{{ asset('app-assets/img/avatars/building.png') }}" style="max-height: 80px;" alt="admin.upload">   
                        @endif
                        <h4 style="text-align: left !important; -webkit-line-clamp: 1;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word; margin: top 100px;">
                            {{ $item->namaindustri }}
                        </h4>
                        <div class="location" style="-webkit-line-clamp: 3;text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; word-break: break-word; margin: top 100px;">
                            {{ $item->alamatindustri }}
                        </div>
                        <div class="button-container">
                            <a href="{{ route('daftar_perusahaan.detail', ['id' => $item->id_industri]) }}?url_back={{ $urlBack }}" class="btn btn-outline-primary mt-3">Lihat Perusahaan</a>
                        </div>
                </div>
            </div>
        </div>
    @endforeach
</div>