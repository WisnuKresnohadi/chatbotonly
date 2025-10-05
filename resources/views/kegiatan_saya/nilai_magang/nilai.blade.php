@extends('partials.horizontal_menu')

@section('page_style')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-12 col-12 mt-3">
        <h4 class="fw-bold"><span class="text-muted fw-light">Kegiatan Saya /</span> Nilai Magang</h4>
    </div>

    <div class="row ps-3">
        <ul class="nav nav-pills mb-3 " role="tablist">
            <li class="nav-item" style="font-size: small">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-lapangan" aria-controls="navs-pills-justified-lapangan" aria-selected="false">
                    Pembimbing Lapangan
                </button>
            </li>
            <li class="nav-item" style="font-size: small">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-akademik" aria-controls="navs-pills-justified-akademik" aria-selected="false">
                    Pembimbing akademik
                </button>
            </li>
            <li class="nav-item" style="font-size: small">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-nilai" aria-controls="navs-pills-justified-nilai" aria-selected="false">
                    Nilai Akhir Magang
                </button>
            </li>
        </ul>

        <div class="tab-content p-0">
            <!-- Pembimbing lapangan -->
            <div class="tab-pane fade show active" id="navs-pills-justified-lapangan" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="card-datatable table-responsive pb-0">
                            <table class="table border rounded mb-0" id="table-pembimbing-lapangan">
                                <thead>
                                    <tr>
                                        <th>NOMOR</th>
                                        <th>ASPEK PENILAIAN</th>
                                        <th style="min-width:600px;">DESKRIPSI ASPEK PENILAIAN</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nilai_pemb_lapangan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->aspek_penilaian }}</td>
                                        <td>{{ $item->deskripsi_penilaian }}</td>
                                        <td>{{ $item->nilai }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center" colspan="3">Total Nilai</th>
                                        <th>{{ $nilai_pemb_lapangan->sum('nilai') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nilai akhir magang -->
            <div class="tab-pane fade show" id="navs-pills-justified-akademik" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="card-datatable table-responsive pb-0">
                            <table class="table border rounded mb-0" id="table-pembimbing-akademik">
                                <thead>
                                    <tr>
                                        <th>NOMOR</th>
                                        <th style="min-width:400px;">ASPEK PENILAIAN</th>
                                        <th style="min-width:300px;">DESKRIPSI ASPEK PENILAIAN</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nilai_pemb_akademik as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->aspek_penilaian }}</td>
                                        <td>{{ $item->deskripsi_penilaian }}</td>
                                        <td>{{ $item->nilai }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center" colspan="3">Total Nilai</th>
                                        <th>{{ $nilai_pemb_akademik->sum('nilai') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade show" id="navs-pills-justified-nilai" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="card-datatable table-responsive pb-0">
                            <table class="table border rounded mb-0" id="table-nilai-akhir">
                                <thead>
                                    <tr>
                                        <th>NOMOR</th>
                                        <th>JENIS PEMBIMBING</th>
                                        <th>NAMA PEMBIMBING</th>
                                        <th style="text-align: center;">BOBOT</th>
                                        <th style="text-align: center;">Nilai</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>Pembimbing Lapangan</td>
                                        <td>{{ $dos_pemb_lapangan }}</td>
                                        <td style="text-align: center;">{{ isset($config_nilai_akhir) ? ($config_nilai_akhir->nilai_pemb_lap . '%') : 'Not Yet Set' }}</td>
                                        <td style="text-align: center;">{{ (isset($config_nilai_akhir)) ? ($nilai_pemb_lapangan->sum('nilai') * ($config_nilai_akhir->nilai_pemb_lap / 100)) : 'Not Yet Set' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td>Pembimbing Akademik</td>
                                        <td>{{ $dos_pemb_akademik }}</td>
                                        <td style="text-align: center;">{{ isset($config_nilai_akhir) ? ($config_nilai_akhir->nilai_pemb_akademik . '%') : 'Not Yet Set' }}</td>
                                        <td style="text-align: center;">{{ (isset($config_nilai_akhir)) ?  ($nilai_pemb_akademik->sum('nilai') * ($config_nilai_akhir->nilai_pemb_akademik / 100)) : 'Not Yet Set' }}</td>
                                    </tr>
                                    @if (isset($mhs_magang->nilai_adjust))
                                    <tr>
                                        <td class="text-center fw-bolder" colspan="4">PENGURANGAN NILAI OLEH ADMIN LKM</td>
                                        <td class="text-center fw-bolder">{{ $mhs_magang->nilai_adjust }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="text-center fw-bolder" colspan="4">Nilai Akhir</td>
                                        <td class="text-center fw-bolder">{{ $mhs_magang->nilai_akhir_magang - ($mhs_magang->nilai_adjust ?? 0) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center fw-bolder" colspan="4">Indeks Nilai Akhir</td>
                                        <td class="text-center fw-bolder">{{ $mhs_magang->indeks_nilai_adjust ?? $mhs_magang->indeks_nilai_akhir }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                @if (isset($mhs_magang->alasan_adjust))
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="text-danger">Komentar Pengurangan Nilai : </h5>
                        <p>{{ $mhs_magang->alasan_adjust }}</p>
                    </div>
                </div>    
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_script')
@endsection