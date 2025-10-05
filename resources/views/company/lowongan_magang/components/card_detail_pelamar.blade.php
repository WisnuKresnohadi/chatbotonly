@if($pendaftar->current_step == ($onScreening ?? false))
{{-- for non enterprise --}}
{{-- <div class="bg-white" style="position: sticky; top: 0; z-index:3;">
    <div class="mb-0 alert alert-warning d-flex align-items-center" role="alert">
        <i class="ti ti-alert-triangle ti-xs me-2"></i>
        <span style="padding-left:10px; padding-top:5px; color:#322F3D;"> Scroll ke bawah untuk membaca secara seksama dan menindaklanjuti.</span>
    </div>
</div> --}}
@endif
<div class="text-center user-profile-header d-flex flex-column flex-sm-row text-sm-start">
    <div class="my-4 text-center" style="overflow: hidden; width: 100px; height: 100px;">
        @if ($pendaftar->profile_picture)
        <img src="{{ asset('storage/' . $pendaftar->profile_picture) }}" alt="user-avatar" class="d-block" width="100" id="image_industri">
        @else
        <img src="{{ asset('app-assets/img/avatars/user.png') }}" alt="user-avatar" class="d-block" width="100" id="image_industri">
        @endif
    </div>
    <div class="mt-0 flex-grow-1 mt-sm-5">
        <div class="gap-4 d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start ms-3 flex-md-row flex-column">
            <div class="me-2 ms-1">
                <h4 class="mb-0">{{ $pendaftar->namamhs }}</h4>
                <large class="text">{{ $headline_pendaftaran }}</large>
            </div>
            <div class="ms-auto">
                <a href="mailto:{{ $pendaftar->emailmhs }}" class="rounded-circle me-2 btn-label-success btn-icon">
                    <i class="ti ti-mail"></i>
                </a>
                <a href="tel:{{ $pendaftar->nohpmhs }}"class="rounded-circle btn-label-success btn-icon">
                    <i class="ti ti-phone-call"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<p>{!! nl2br($deskripsiDiri_pendaftar) !!}</p>
<h5 class="mt-2"> Mengapa Saya Harus Di Terima?</h5>
<p>{!! nl2br($pendaftar->reason_aplicant) !!}</p>
<hr>
<h5>Informasi Pribadi</h5>
<div class="row">
    <div class="col-3">
        <h6>Nama Lengkap</h6>
        <p>{{ $pendaftar->namamhs }}</p>
    </div>
    <div class="col-3">
        <h6>Tanggal Lahir</h6>
        <p>{{ Carbon\Carbon::parse($pendaftar->tgl_lahir)->format('d F Y') }}</p>
    </div>
    <div class="col-3">
        <h6>Jenis Kelamin</h6>
        <p>{{ $pendaftar->gender }}</p>
    </div>
    <div class="col-3">
        <h6>Warga Negara</h6>
        <p>@if($pendaftar->negara == null) - @else {{ $pendaftar->negara == '1' ? 'WNI' : 'WNA' }} @endif</p>
    </div>
    <div class="col-3">
        <h6>Negara</h6>
        <p>{{ $pendaftar->negara ?? '-' }}</p>
    </div>
    <div class="col-3">
        <h6>Provisi</h6>
        <p>{{ $pendaftar->provinsi ?? '-' }}</p>
    </div>
    <div class="col-3">
        <h6>Kota</h6>
        <p>{{ $pendaftar->kota ?? '-' }}</p>
    </div>
    <div class="col-3">
        <h6>Kode Pos</h6>
        <p>{{ $pendaftar->kodepos ?? '-' }}</p>
    </div>
    <div class="col-12">
        <h6>Alamat</h6>
        <p>{{ $pendaftar->alamatmhs }}</p>
    </div>
</div>
<hr>
<h5>Pendidikan</h5>
<div class="pb-0 card-body">
    <ul class="mb-0 timeline ms-1">
        @foreach ($education as $item)
        <li class="timeline-item timeline-item-transparent ps-3 pb-3 {{ $loop->last ? 'border-0' : '' }}">
            <span class="timeline-point timeline-point-primary"></span>
            <div class="d-flex justify-content-between position-relative" style="top:-0.3rem;">
                <div class="">
                    <h6>Sekolah/Universitas</h6>
                    <p class="mb-0">{{ $item->name_intitutions }}</p>
                    <small>{{ $item->tingkat }}</small>
                </div>
                <div class="">
                    <h6>Mulai - Akhir</h6>
                    <p>{{ Carbon\Carbon::parse($item->startdate)->format('d/m/Y') }} - {{ Carbon\Carbon::parse($item->enddate)->format('d/m/Y') }}</p>
                </div>
                <div class="">
                    <h6>IPK</h6>
                    <p>{{ $item->nilai }}</p>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>

<hr>
<h5>Pengalaman Kerja</h5>
<div class="pb-0 card-body">
    <ul class="mb-0 timeline ms-1">
        @foreach ($experience as $item)
        <li class="timeline-item timeline-item-transparent ps-3 pb-3  {{ $loop->last ? 'border-0' : '' }}">
            <span class="timeline-point timeline-point-primary"></span>
            <div class="position-relative" style="top:-0.3rem;">
                <div class="px-0 d-flex justify-content-between">
                    <div class="">
                        <h6>Nama Perusahaan</h6>
                        <p>{{ $item->name_intitutions }}</p>
                    </div>
                    <div class="">
                        <h6>Posisi</h6>
                        <p>{{ $item->posisi }}</p>
                    </div>
                    <div class="">
                        <h6>Mulai - Akhir</h6>
                        <p>{{ Carbon\Carbon::parse($item->startdate)->format('d/m/Y') }} - {{ Carbon\Carbon::parse($item->enddate)->format('d/m/Y') }}</p>
                    </div>
                </div>
                <h6>Deskripsi</h6>
                <p>{{ $item->deskripsi }}.</p>
            </div>
        </li>
        @endforeach
    </ul>
</div>
<hr>
<h5>Keahlian</h5>
<div style="display: flex; flex-wrap: wrap; gap: 1px;">
    @foreach ($skills as $item)
    <span class='mx-1 badge rounded-pill bg-label-primary' style="margin-bottom: 10px;">{{ $item }}</span>
    @endforeach
</div>
<hr>
<h5>Bahasa</h5>
@foreach ($language as $item)
<span class='mx-1 badge rounded-pill bg-label-primary'>{{ $item->bahasa }}</span>
@endforeach
<hr>
<h5>Dokumen Pendukung</h5>
<div class="card-body">
    <div class="d-flex flex-column" id="container-dokumen-pendukung">
        @foreach ($dokumen_pendukung as $key => $item)
            <div class="{{ count($dokumen_pendukung) != ($key+1) ? 'border-bottom mb-3 pb-3' : '' }}">
                <div class="mb-1 d-flex justify-content-start">
                    <h6 class="mb-0">{{ $item->nama_sertif }}</h6>
                </div>
                <p class="mb-1" style="font-size: small">{{ $item->penerbit }}</p>
                <p class="mb-1">{{ Carbon\Carbon::parse($item->startdate)->format('F Y') }}&ensp;-&ensp;{{ Carbon\Carbon::parse($item->enddate)->format('F Y') }}</p>
                <a class="text-primary" href="{{ url('storage/'.$item->file_sertif) }}" target="_blank">Dokumen.pdf</a>
                <p class="mb-1">{{ $item->deskripsi }}</p>
            </div>
        @endforeach
    </div>
</div>
<hr>
<h5>Dokumen Persyaratan</h5>
<div class="card-body">
    <div class="row" id="container-dokumen-pendukung">
        @foreach ($dokumen_syarat as $item)
        <div class="mb-2 col-4">
            <h6 class="mb-1">{{ strtoupper($item->namadocument) }}</h6>
            <a class="text-primary" href="{{ url('storage/'.$item->file) }}" target="_blank">{{ ucwords(strtolower($item->namadocument)) }}.{{ explode('.', $item->file)[1] }}</a>
        </div>
        @endforeach
    </div>
</div>

{{-- for non enterprise --}}
{{-- @if($pendaftar->current_step == ($onScreening ?? false))
<hr>
<div class="d-flex justify-content-center">
    <button type="button" class="btn btn-success me-2 w-100" onclick="swalConfirmStatus($(this))" data-id="{{ $pendaftar->id_pendaftaran }}" data-status="approved">Lolos</button>
    <button type="button" class="btn btn-danger w-100" onclick="swalConfirmStatus($(this))" data-id="{{ $pendaftar->id_pendaftaran }}" data-status="rejected">Gagal</button>
</div>
@endif --}}
