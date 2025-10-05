@if (isset($detailLowongan))
<div class="card border mt-3">
    <div class="card-body m-3">
        <div class="d-flex justify-content-between">
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-center">
                    @if ($detailLowongan->image)
                        <img src="{{ asset('storage/' . $detailLowongan->image) }}" alt="user-avatar" style="max-width:170px; max-height: 140px" id="imgPreview">
                    @else
                        <img src="{{ asset('app-assets/img/avatars/building.png') }}" alt="user-avatar" class="" height="125" width="125" id="imgPreview" data-default-src="{{ asset('app-assets/img/avatars/14.png') }}">
                    @endif
                    <div class="text-end">
                        <p>Batas Melamar {{ $detailLowongan?->enddate ? \Carbon\Carbon::parse($detailLowongan->enddate)->translatedFormat('d F Y') : 'Undefined' }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <h4 class="mb-0">{{$detailLowongan?->namaindustri ?? ''}}</h4>
                    <h3 class="fw-bolder">{{$detailLowongan->intern_position}}</h3>
                </div>
                <div class="row mt-5">
                    <div class="col-4 my-auto">
                        <p @if( $kuotaPenuh ) class="fw-bold text-danger" @endif><i class="ti ti-users me-2"></i>{{ $detailLowongan->kuota_terisi }}/{{ $detailLowongan->kuota }} @if( $kuotaPenuh ) (Sudah Penuh) @endif</p>
                        <p><i class="ti ti-briefcase me-2"></i>{{ $detailLowongan->pelaksanaan }}</p>
                        <p><i class="ti ti-calendar-time me-2"></i>{{ implode(' dan ', json_decode($detailLowongan->durasimagang)) }}</p>
                    </div>
                    <div class="col-4 my-auto border-start border-end">
                        <p><i class="ti ti-map-pin me-2"></i>{{ implode(', ', json_decode($detailLowongan->lokasi)) }}</p>
                        <p><i class="ti ti-cash me-2"></i>{{ uangSakuRupiah($detailLowongan->nominal_salary) }}</p>
                        <p><i class="ti ti-man me-2"></i>{{ $detailLowongan->gender }}</p>
                    </div>
                    <div class="col-4 my-auto">
                        <p class="mb-2"><i class="ti ti-school me-2"></i>Program Studi</p>
                        <ul class="ps-2 ms-4 mb-0">
                            @foreach ($detailLowongan->program_studi as $item)
                                <li>{{ $item->namaprodi }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col py-3">
                <h4>Deskripsi Pekerjaan</h4>
                <ul class="ps-2 ms-3 mb-0">
                    @foreach (explode(PHP_EOL, $detailLowongan->deskripsi) as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row border-top">
            <div class="col py-3">
                <h4>Requirement</h4>
                <ul class="ps-2 ms-3 mb-0">
                    @foreach (json_decode($detailLowongan->requirements) as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @if($isMahasiswa && !$kuotaPenuh)
        <div class="row mt-3">
            @if (\Carbon\Carbon::now()->lessThanOrEqualTo(\Carbon\Carbon::parse($detailLowongan->enddate)) || \Carbon\Carbon::now()->isSameDay(\Carbon\Carbon::parse($detailLowongan->enddate)))
                <a href="{{ route('apply_lowongan.detail.lamar', ['id' => $detailLowongan->id_lowongan]) }}" class="btn btn-primary w-100">Lamar</a>
            @else
                <p class="btn btn-secondary w-100">Lamar</p>
            @endif
        </div>

        @endif
        <div class="row border-top">
            <div class="col py-3">
                <h4>Benefit</h4>
                <ul class="ps-2 ms-3 mb-0">
                    @foreach (explode(PHP_EOL, $detailLowongan->benefitmagang) as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row border-top">
            <div class="col py-3">
                <h4>Kemampuan</h4>
                <div class="d-flex justify-content-start">
                    @foreach (json_decode($detailLowongan->keterampilan) as $item)
                    <span class="badge rounded-pill bg-primary mx-1">{{ $item }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row border-top">
            @for ($i = 0; $i <= $detailLowongan->tahapan_seleksi; $i++)
            <div class="col-12 py-3">
                <h5 class="mb-2">Seleksi Tahap {{ ($i + 1) }}</h5>
                <p class="mb-1"><i class="ti ti-clipboard-list me-2"></i>{{ $detailLowongan->seleksi_tahap[$i]->deskripsi }}</p>
                <p class="mb-1">
                    <i class="ti ti-calendar-event me-2"></i>Range Tanggal Pelaksanaan:&ensp;
                    <b>{{ Carbon\Carbon::parse($detailLowongan->seleksi_tahap[$i]->tgl_mulai)->format('d/m/Y') }}</b> &ensp;-&ensp; <b>{{ Carbon\Carbon::parse($detailLowongan->seleksi_tahap[$i]->tgl_akhir)->format('d/m/Y') }}</b>
                </p>
            </div>
            @endfor
        </div>
        <div class="row border-top">
            <div class="col py-3">
                <h4>Tentang Perusahaan</h4>
                <p>{{ $detailLowongan->deskripsi_industri }}</p>
            </div>
        </div>
    </div>
</div>
@else
<div class="card border text-center mt-3">
    <div class="card-body">
        <figure class="m-5">
            <img class="image" src="{{ asset('front/assets/img/amico.png')}}" alt="admin.upload">
        </figure>
        <h5>Belum ada lowongan terpilih</h5>
        <p>Silahkan pilih lowongan yang tersedia untuk mendapatkan detail informasi</p>
    </div>
</div>
@endif
