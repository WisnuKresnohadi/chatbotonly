@extends('partials.horizontal_menu')

@section('page_style')
<style>
        /* For Desktop View */
    @media screen and (min-device-width: 1024px) {
        .card-mobile{
            display: none !important;
        }
        .header-mobile{
            display: none !important;
        }
    }

    /* For Tablet View */
    @media screen and (min-device-width: 768px) and (max-device-width: 1024px) {
       .back-navigasi{
         display: none !important;
       }
       .title-desktop{
         display: none !important;
       }
       .card-desktop{
            display: none !important;
       }
    }

    /* For Mobile Portrait View */
    @media screen and (min-device-width: 300px) and (max-device-width: 768px){
        .back-navigasi{
            display: none !important;
        }
        .title-desktop{
            display: none !important;
       }
       .card{
            margin: 0% !important;
       }
       .card-desktop{
            display: none !important;
       }

       .container-p-y:not([class^=pb-]):not([class*=" pb-"]) {
        padding: 0% !important;
       }
    }
</style>
@endsection

@section('content')

<div class="header-mobile bg-white" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center; height: 2.5rem; padding-top: 2.5rem; padding-bottom: 3rem;">
    <a href="{{ url()->previous() }}" style="color: #4B465C;" class="btn">
        <i class="ti ti-arrow-left fs-3"></i>
    </a>
    <span class="fw-bold fs-5">
        Detail Lowongan Pekerjaan
    </span>
    <div style="width: 3rem;">
    </div>
</div>

<div class="container-xxl flex-grow-1 container-p-y">
    <a href="{{ url()->previous() }}" class="btn btn-outline-primary back-navigasi mt-5"><i class="ti ti-arrow-left me-2"></i>Kembali</a>
    <div class="d-flex justify-content-start mt-3 title-desktop">
        <h4 class="fw-bold">
            Detail Lowongan Pekerjaan
        </h4>
    </div>

    <div class="row card-desktop">
        <div class="col">
            <div class="card">
                <div class="card-body m-3">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1 me-5">
                            <div class="d-flex justify-content-start align-items-center">
                                @if ($lowongan->image)
                                    <img src="{{ asset('storage/' . $lowongan->image) }}" alt="user-avatar" style="max-width:170px; max-height: 140px" id="imgPreview">
                                @else
                                    <img src="{{ asset('app-assets/img/avatars/building.png') }}" alt="user-avatar" class="" height="125" width="125" id="imgPreview" data-default-src="{{ asset('app-assets/img/avatars/building.png') }}">
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
                        <div class="text-center">
                            <p class="mt-5" style="font-size: 18px;">Batas Melamar {{ $lowongan?->enddate ? \Carbon\Carbon::parse($lowongan->enddate)->translatedFormat('d F Y') : 'Undefined' }}</p>
                            @if (auth()->check() && auth()->user()->hasRole('Mahasiswa'))
                            <div class="mt-4">
                                <div class="row">
                                    <div class="col-md-6 mx-auto" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Simpan">
                                        <button type="button" class="btn btn-outline-primary" onclick="simpanLowongan($(this))" style="width: 95px;">
                                            @if ($tersimpan)
                                            <i class="fa-solid fa-bookmark" style="font-size: x-large;"></i>
                                            @else
                                            <i class="fa-regular fa-bookmark" style="font-size: x-large;"></i>
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($eligible)
                            <div class="mt-4 text-end">
                                @if ($lowongan->status == 1 && (\Carbon\Carbon::now()->lessThanOrEqualTo(\Carbon\Carbon::parse($lowongan->enddate)) || \Carbon\Carbon::now()->isSameDay(\Carbon\Carbon::parse($lowongan->enddate))))
                                    <a href="{{ route('apply_lowongan.detail.lamar', ['id' => $lowongan->id_lowongan]) }}" class="btn btn-primary waves-effect waves-light w-100">Lamar Lowongan</a>
                                @else
                                    <p class="btn btn-secondary w-100">Lamar Lowongan</p>
                                @endif
                            </div>
                            @endif
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
                                @foreach (json_decode($lowongan->requirements) as $item)
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

    <div class="card-mobile">
            <div class="bg-white "  style="padding-top: 2rem;">
                <div class="card-body px-4">
                    <div class="d-flex flex-column justify-content-between">
                            <div style="align-items: center; display: flex; flex-direction: row; justify-content: space-between; width: 100%;">
                                <div class="d-flex flex-column justify-content-start align-items-start">
                                    @if ($lowongan->image)
                                        <img src="{{ asset('storage/' . $lowongan->image) }}" alt="user-avatar" class="" style="max-width:170px; max-height: 140px" id="imgPreview">
                                    @else
                                        <img src="{{ asset('app-assets/img/avatars/building.png') }}" alt="user-avatar" class="" height="125" width="125" id="imgPreview" data-default-src="{{ asset('app-assets/img/avatars/building.png') }}">
                                    @endif
                                    <div class="">
                                        <h2 class="fw-bolder mb-0">{{$lowongan?->namaindustri ?? ''}}</h2>
                                        <h4 class="fw-lighter text-muted">{{$lowongan->intern_position}}</h4>
                                    </div>
                                </div>
                                <div>
                                    <p style="font-size: 15px;">Batas Melamar <br>{{ $lowongan?->enddate ? \Carbon\Carbon::parse($lowongan->enddate)->translatedFormat('d F Y') : 'Undefined' }}</p>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="col">
                                    <p><i class="ti ti-users me-2"></i>{{ $lowongan->kuota }} Orang</p>
                                    <p><i class="ti ti-briefcase me-2"></i>{{ $lowongan->pelaksanaan }}</p>
                                    <p><i class="ti ti-calendar-time me-2"></i>{{ implode(' dan ', json_decode($lowongan->durasimagang)) }}</p>
                                </div>
                                <div class="col">
                                    <p><i class="ti ti-map-pin me-2"></i>{{ implode(',', json_decode($lowongan->lokasi)) }}</p>
                                    <p><i class="ti ti-cash me-2"></i>{{ uangSakuRupiah($lowongan->nominal_salary) }}</p>
                                    <p><i class="ti ti-man me-2"></i>{{ $lowongan->gender }}</p>
                                </div>
                                <div class="col">
                                    <p class="mb-2"><i class="ti ti-school me-2"></i>Program Studi</p>
                                    <ul class="ps-2 ms-4 mb-0">
                                        @foreach ($lowongan->program_studi as $item)
                                            <li>{{ $item->namaprodi }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        {{-- <div class="text-center">
                            <div class="mt-4">
                                <div class="">
                                    <div class="col-md-6" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Bagikan ">
                                        <button type="button" class="btn btn-outline-dark waves-effect" onclick="changeColor(this)" data-bs-toggle="modal" data-bs-target="#modalbagikan" style="width: 95px;">
                                            <i class="ti ti-share" style="font-size: x-large;"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-6" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Simpan">
                                        <button type="button" class="btn btn-outline-dark waves-effect" onclick="changeColor(this)" data-bs-toggle="modal" data-bs-target="#modalalert" style="width: 95px;">
                                            <i class="ti ti-bookmark" style="font-size: x-large;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="mt-4">
                        <div class="col py-3">
                            <h4>Deskripsi Pekerjaan</h4>
                            <ul class="ps-2 ms-3 mb-0">
                                @foreach (explode(PHP_EOL, $lowongan->deskripsi) as $item)
                                <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="col py-3">
                            <h4>Requirement</h4>
                            <ul class="ps-2 ms-3 mb-0">
                                @foreach (explode(PHP_EOL, $lowongan->requirements) as $item)
                                <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="col py-3">
                            <h4>Benefit</h4>
                            <ul class="ps-2 ms-3 mb-0">
                                @foreach (explode(PHP_EOL, $lowongan->benefitmagang) as $item)
                                <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="col py-3">
                            <h4>Kemampuan</h4>
                            <div class="d-flex justify-content-start">
                                @foreach (json_decode($lowongan->keterampilan) as $item)
                                <span class="badge rounded-pill bg-primary mx-1">{{ $item }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
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
                    <div class="border-top">
                        <div class="col py-3">
                            <h4>Tentang Perusahaan</h4>
                            <p>{{ $lowongan->deskripsi_industri }}</p>
                        </div>
                    </div>
                </div>
                @if($eligible)
                <div class="mt-4 text-end px-5 bg-white pt-3" style="position: sticky; bottom: 0%;">
                    @if (\Carbon\Carbon::now()->lessThanOrEqualTo(\Carbon\Carbon::parse($lowongan->enddate)) || \Carbon\Carbon::now()->isSameDay(\Carbon\Carbon::parse($lowongan->enddate)))
                        <a href="{{ route('apply_lowongan.detail.lamar', ['id' => $lowongan->id_lowongan]) }}" class="btn btn-primary waves-effect waves-light w-100" style="height: 3rem; margin-bottom: 1rem;">Lamar Lowongan</a>
                    @else
                        <p class="btn btn-secondary w-100" style="height: 3rem;">Lamar Lowongan</p>
                    @endif
                </div>
                @endif
                {{-- <div class="mt-4 text-end px-5 bg-white pt-3" style="position: sticky; bottom: 0%;">
                    <a href="{{ route('apply_lowongan.detail.lamar', ['id' => $lowongan->id_lowongan]) }}" class="btn btn-primary waves-effect waves-light w-100" style="height: 3rem;">Lamar Lowongan</a>
                </div> --}}
            </div>
    </div>
</div>
@endsection

@section('page_script')
<script>
    function simpanLowongan(e) {
        let icon = e.find('i');

        if (icon.hasClass('fa-solid fa-bookmark')) {
            icon.removeClass().addClass('fa-regular fa-bookmark');
        } else {
            icon.removeClass().addClass('fa-solid fa-bookmark');
        }

        $.ajax({
            url: "{{ route('lowongan_tersimpan.save', ['id' => $lowongan->id_lowongan]) }}",
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: (response) => {

            },
            error: (xhr, status, error) => {
                let res = xhr.responseJSON;
                showSweetAlert({
                    title: 'Gagal!',
                    text: res.message,
                    icon: 'error'
                });
            },
        });
    }
</script>
@endsection
