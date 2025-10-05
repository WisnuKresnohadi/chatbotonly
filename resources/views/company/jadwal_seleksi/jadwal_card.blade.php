@foreach ($lowongan as $item)
<div class="card mt-4">
    <a href="/jadwal-seleksi/lanjutan/{{ $item->id_lowongan }}" style="min-width: 20%" class="card-body waves-effect waves-light">
        <div class="card-body">
            <div class="row">
                <div class="col-2">
                    <figure class="image" style="border-radius: 0%;"><img style="border-radius: 0%; width: 60%;" src="{{ $img ?? '\assets\images\no-pictures.png' }}" alt="Logo">
                    </figure>
                </div>
                <div class="col-10 d-flex justify-content-between">
                    <div>
                        <h5>{{ $item->intern_position }}</h5>
                        <p>{{ $item->bidang }}</p>
                    </div>
                    <div>
                        <span class="badge bg-label-{{$item->color}} me-1 text-end">{{$item->status}}</span>
                    </div>
                </div>
            </div>
            <div class="row gy-3 mt-3">
                <div class="col-md-2 col-6">
                    <div class="d-flex align-items-center">
                        <div class="badge rounded-pill bg-label-success me-3 p-2">
                            <i class="ti ti-users ti-sm"></i>
                        </div>
                        <div class="card-info">
                            <small>Total Pelamar</small>
                            <h5 class="mb-0">{{ $item->kandidat ?? '0' }}</h5>
                        </div>
                    </div>
                </div>
                @if ($item->tahapan_seleksi == '1')
                <div class="col-md-2 col-6">
                    <div class="d-flex align-items-center">
                        <div class="badge rounded-pill bg-label-success me-3 p-2">
                            <i class="ti ti-file-report ti-sm"></i>
                        </div>
                        <div class="card-info">
                            <small>Seleksi Tahap 1</small>
                            <h5 class="mb-0">{{ $item->tahap1 ?? '0'  }}</h5>
                        </div>
                    </div>
                </div>
                @elseif($item->tahapan_seleksi == '2')
                <div class="col-md-2 col-6">
                    <div class="d-flex align-items-center">
                        <div class="badge rounded-pill bg-label-success me-3 p-2">
                            <i class="ti ti-file-report ti-sm"></i>
                        </div>
                        <div class="card-info">
                            <small>Seleksi Tahap 1</small>
                            <h5 class="mb-0">{{ $item->tahap1 ?? '0'  }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="d-flex align-items-center">
                        <div class="badge rounded-pill bg-label-success me-3 p-2">
                            <i class="ti ti-file-report ti-sm"></i>
                        </div>
                        <div class="card-info">
                            <small>Seleksi Tahap 2</small>
                            <h5 class="mb-0">{{ $item->tahap2 ?? '0' }}</h5>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-md-2 col-6">
                    <div class="d-flex align-items-center">
                        <div class="badge rounded-pill bg-label-success me-3 p-2">
                            <i class="ti ti-file-report ti-sm"></i>
                        </div>
                        <div class="card-info">
                            <small>Seleksi Tahap 1</small>
                            <h5 class="mb-0">{{ $item->tahap1 ?? '0' }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="d-flex align-items-center">
                        <div class="badge rounded-pill bg-label-success me-3 p-2">
                            <i class="ti ti-file-report ti-sm"></i>
                        </div>
                        <div class="card-info">
                            <small>Seleksi Tahap 2</small>
                            <h5 class="mb-0">{{ $item->tahap2 ?? '0' }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="d-flex align-items-center">
                        <div class="badge rounded-pill bg-label-success me-3 p-2">
                            <i class="ti ti-file-report ti-sm"></i>
                        </div>
                        <div class="card-info">
                            <small>Seleksi Tahap 3</small>
                            <h5 class="mb-0">{{ $item->tahap3 ?? '0' }}</h5>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <hr />
            <div class="row mt-2">
                <div class="col-12 d-flex justify-content-between">
                    <div class="col-6">
                        <div class="tf-icons ti ti-calendar" style="font-size: medium; margin-right:10px;"> Tanggal
                            Posting: {{ $item->startdate?->format('d M Y') ?? '-' }} -
                            {{ $item->enddate?->format('d M Y') ?? '-' }}
                        </div>
                        <div class="tf-icons ti ti-users" style="font-size: medium;"> Kuota Penerimaan :
                            {{ $item->kuota }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
@endforeach