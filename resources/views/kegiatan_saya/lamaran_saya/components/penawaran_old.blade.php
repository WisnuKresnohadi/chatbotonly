@if ($penawaran->count() == 0)
    <img src="\assets\images\nothing.svg" alt="no-data"
        style="display: flex; margin-left: auto; margin-right: auto; margin-top: 5%; margin-bottom: 5%;  width: 28%;">
    <div class="sec-title mt-5 mb-4 text-center">
        <h4>Anda belum memiliki Lowongan Magang pada tahap Penawaran</h4>
    </div>
@else
    @foreach ($penawaran as $item)
        <div class="card mt-2">
            <div class="card-body">
                <div class="alert alert-danger alert-dismissible" role="alert">
                    Lakukan konfirmasi penerimaan sebelum tanggal
                    {{ $item->lowongan_magang->date_confirm_closing?->format('d F Y') }}!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <a href="{{ url('kegiatan-saya/detail', $item->id_lowongan) }}" style="color:#4B4B4B">
                    <div class="row mb-2">
                        <div class="col-2">
                            <figure class="image mx-1" style="border-radius: 0%;"><img
                                    style="border-radius: 0%; width: 120px;"
                                    src="{{ $item->img ?? '\assets\images\no-pictures.png' }}" alt="Logo">
                            </figure>
                        </div>
                        <div class="col-10 d-flex justify-content-between">
                            <div>
                                <h5>{{ $item->lowongan_magang->intern_position }}</h5>
                                <p>{{ $item->lowongan_magang->industri->namaindustri }}</p>
                            </div>
                            <div>
                                <span
                                    class="badge bg-label-{{ $item->color }} me-1 text-end">{{ $item->step }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-left mb-2">
                        <p>{{ $item->lowongan_magang->deskripsi }}</p>
                    </div>
                </a>
                <div class="text-left">
                    <button type="button" data-id="{{ $item->nim }}"
                        data-lowongan="{{ $item->lowongan_magang->id_lowongan }}" onclick="ambil($(this))"
                        class="btn btn-success waves-effect me-2" data-bs-toggle="modal">Ambil Tawaran
                    </button>
                    <button type="button" data-id="{{ $item->nim }}"
                        data-lowongan="{{ $item->lowongan_magang->id_lowongan }}" onclick="tolak($(this))"
                        class="btn btn-danger waves-effect" data-bs-toggle="modal">Tolak Tawaran
                    </button>
                </div>
                <hr />
                <div class="row mt-2">
                    <div class="col-12 d-flex justify-content-between">
                        <div class="col-6">
                            <span> <i class="ti ti-map-pin" style="font-size: medium;"></i>
                                {{ $item->lowongan_magang->lokasi }}</span>
                            @if (empty($item->lowongan_magang->nominal_salary))
                                <span> <i class="ti ti-cash ms-3" style="font-size: medium;"></i> Tidak
                                    Diberi Uang Saku</span>
                            @else
                                <span> <i class="ti ti-cash ms-3" style="font-size: medium;"></i>
                                    Diberi Uang Saku</span>
                            @endif
                            <span> <i class="ti ti-calendar-time ms-3" style="font-size: medium;"></i>
                                {{ $item->lowongan_magang->durasimagang }}</span>
                            <span> <i class="ti ti-users ms-3" style="font-size: medium;"></i>
                                {{ $item->lowongan_magang->kuota }}
                                Kuota Penerimaan</span>
                        </div>
                        <div class="col-6">
                            <div class="text-end" style="font-size: medium; color : #4EA971">
                                Lamaran terkirim pada
                                {{ $item->tanggaldaftar?->format('d F Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
