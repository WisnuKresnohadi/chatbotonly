<!-- Magang Mandiri -->
<div class="tab-pane fade show" id="navs-pills-justified-magang-mandiri" role="tabpanel">
    @foreach ($mandiri as $item)
        @if ($item->nim == $nim->nim)
            @if ($item->statusapprove == 1 && $item->status_terima == null)
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            Lakukan konfirmasi penerimaan segera!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="text-end mt-3"><span class="badge bg-label-secondary">Penawaran</span>
                        </div>
                        <div class="row">
                            <div class="ps-4">
                                <h4>{{ $item->posisi_magang }}</h4>
                                <p>{{ $item->nama_industri }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <span class="border-end pe-2 me-2"><i class="tf-icons ti ti-map-pin"
                                        style="font-size: 18px;"></i>
                                    {{ $item->alamat_industri }}</span>
                            </div>
                            <div class="col-2">
                                <span class="border-end pe-2 me-2"><i class="tf-icons ti ti-phone-call pe-1"
                                        style="font-size: 18px;"></i>{{ $item->nohp }}</span>
                            </div>
                            <div class="col-2">
                                <span><i class="tf-icons ti ti-mail pe-1"
                                        style="font-size: 18px;"></i>{{ $item->email }}</span>
                            </div>
                        </div>
                        <div class="text-left mt-3">
                            <button type="button" class="btn btn-success waves-effect me-2" {{-- data-bs-toggle="modal" data-bs-target="#modalDiterima" --}}
                                data-id="{{ $item->id_pengajuan }}" onclick="terima($(this))">Diterima
                            </button>
                            <button type="button" class="btn btn-danger waves-effect me-2" {{-- data-bs-toggle="modal" data-bs-target="#modalDiterima" --}}
                                data-id="{{ $item->id_pengajuan }}" onclick="Ditolak($(this))">Ditolak
                            </button>
                        </div>
                    </div>
                </div>
            @elseif ($item->status_terima == 1)
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="text-end mt-3"><span class="badge bg-label-success">Diterima</span>
                        </div>
                        <div class="row">
                            <div class="ps-4">
                                <h4>{{ $item->posisi_magang }}</h4>
                                <p>{{ $item->nama_industri }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <span class="border-end pe-2 me-2"><i class="tf-icons ti ti-map-pin"
                                        style="font-size: 18px;"></i>
                                    {{ $item->alamat_industri }}</span>
                            </div>
                            <div class="col-2">
                                <span class="border-end pe-2 me-2"><i class="tf-icons ti ti-phone-call pe-1"
                                        style="font-size: 18px;"></i>{{ $item->nohp }}</span>
                            </div>
                            <div class="col-2">
                                <span><i class="tf-icons ti ti-mail pe-1"
                                        style="font-size: 18px;"></i>{{ $item->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($item->status_terima == 2)
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="text-end mt-3"><span class="badge bg-label-danger">Ditolak</span>
                        </div>
                        <div class="row">
                            <div class="ps-4">
                                <h4>{{ $item->posisi_magang }}</h4>
                                <p>{{ $item->nama_industri }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <span class="border-end pe-2 me-2"><i class="tf-icons ti ti-map-pin"
                                        style="font-size: 18px;"></i>
                                    {{ $item->alamat_industri }}</span>
                            </div>
                            <div class="col-2">
                                <span class="border-end pe-2 me-2"><i class="tf-icons ti ti-phone-call pe-1"
                                        style="font-size: 18px;"></i>{{ $item->nohp }}</span>
                            </div>
                            <div class="col-2">
                                <span><i class="tf-icons ti ti-mail pe-1"
                                        style="font-size: 18px;"></i>{{ $item->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    @endforeach
</div>
<!-- /Magang Mandiri -->
