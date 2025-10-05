@extends('partials.horizontal_menu')

@section('page_style')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <a href="{{ $urlBack }}" class="btn btn-outline-primary"><i class="ti ti-arrow-left me-2"></i>Kembali</a>
    <div class="d-flex justify-content-start mt-3">
        <h4 class="fw-bold">
            Detail Lowongan Pekerjaan
        </h4>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body m-3">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1 me-5">
                            <div class="d-flex justify-content-start align-items-center">
                                @if ($lowongan->image)
                                    <img src="{{ asset('storage/' . $lowongan->image) }}" alt="user-avatar" style="max-width:170px; max-height: 140px" id="imgPreview">
                                @else
                                    <img src="{{ asset('app-assets/img/avatars/14.png') }}" alt="user-avatar" class="" height="125" width="125" id="imgPreview" data-default-src="{{ asset('app-assets/img/avatars/14.png') }}">
                                @endif
                                <div class="ms-4">
                                    <h2 class="fw-bolder mb-0">{{$lowongan?->namaindustri ?? ''}}</h2>
                                    <h4 class="fw-lighter text-muted">{{$lowongan->intern_position}}</h4>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-4">
                                    <p><i class="ti ti-users me-2"></i>{{ $lowongan->kuota }} Orang</p>
                                    <p><i class="ti ti-briefcase me-2"></i>{{ $lowongan->pelaksanaan }}</p>
                                    <p><i class="ti ti-calendar-time me-2"></i>{{ implode(' dan ', json_decode($lowongan->durasimagang)) }}</p>
                                </div>
                                <div class="col-4 border-start border-end">
                                    <p><i class="ti ti-map-pin me-2"></i>{{ implode(', ', json_decode($lowongan->lokasi)) }}</p>
                                    <p><i class="ti ti-cash me-2"></i>{{ uangSakuRupiah($lowongan->nominal_salary) }}</p>
                                    <p><i class="ti ti-man me-2"></i>{{ $lowongan->gender }}</p>
                                </div>
                                <div class="col-4">
                                    <p class="mb-2"><i class="ti ti-school me-2"></i>Program Studi</p>
                                    <ul class="ps-2 ms-4 mb-0">
                                        @foreach ($lowongan->program_studi as $item)
                                            <li>{{ $item->namaprodi }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <p class="mt-5" style="font-size: 18px;">Batas Melamar 13 Juli 2023</p>
                            <div class="text-end mt-4 me-2">
                                <div class="row">
                                    <div class="col-6" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Bagikan ">
                                        <button type="button" class="btn btn-outline-dark waves-effect" onclick="changeColor(this)" data-bs-toggle="modal" data-bs-target="#modalbagikan" style="width: 95px;">
                                            <i class="ti ti-share" style="font-size: x-large;"></i>
                                        </button>
                                    </div>
                                    <div class="col-6" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Simpan">
                                        <button type="button" class="btn btn-outline-dark waves-effect" onclick="changeColor(this)" data-bs-toggle="modal" data-bs-target="#modalalert" style="width: 95px;">
                                            <i class="ti ti-bookmark" style="font-size: x-large;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 border-top">
                        <div class="col py-3">
                            <h4>Deskripsi Pekerjaan</h4>
                            <ul class="ps-2 ms-3 mb-0">
                                @foreach (explode(PHP_EOL, $lowongan->deskripsi) as $item)
                                <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="row border-top">
                        <div class="col py-3">
                            <h4>Requirement</h4>
                            <ul class="ps-2 ms-3 mb-0">
                                @foreach (explode(PHP_EOL, $lowongan->requirements) as $item)
                                <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="row border-top">
                        <div class="col py-3">
                            <h4>Benefit</h4>
                            <ul class="ps-2 ms-3 mb-0">
                                @foreach (explode(PHP_EOL, $lowongan->benefitmagang) as $item)
                                <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="row border-top">
                        <div class="col py-3">
                            <h4>Kemampuan</h4>
                            <div class="d-flex justify-content-start">
                                @foreach (json_decode($lowongan->keterampilan) as $item)
                                <span class="badge rounded-pill bg-primary mx-1">{{ $item }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row border-top">
                        @for ($i = 0; $i <= $lowongan->tahapan_seleksi; $i++)
                        <div class="col-12 py-3">
                            <h5 class="mb-2">Seleksi Tahap {{ ($i + 1) }}</h5>
                            <p class="mb-1"><i class="ti ti-clipboard-list me-2"></i>{{ $lowongan->seleksi_tahap[$i]->deskripsi }}</p>
                            <p class="mb-1">
                                <i class="ti ti-calendar-event me-2"></i>Range Tanggal Pelaksanaan:&ensp;
                                <b>{{ Carbon\Carbon::parse($lowongan->seleksi_tahap[$i]->tgl_mulai)->format('d/m/Y') }}</b> &ensp;-&ensp; <b>{{ Carbon\Carbon::parse($lowongan->seleksi_tahap[$i]->tgl_akhir)->format('d/m/Y') }}</b>
                            </p>
                        </div>
                        @endfor 
                    </div>
                    <div class="row border-top">
                        <div class="col py-3">
                            <h4>Tentang Perusahaan</h4>
                            <p>{{ $lowongan->deskripsi_industri }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_script')
<script>
    
</script>
@endsection