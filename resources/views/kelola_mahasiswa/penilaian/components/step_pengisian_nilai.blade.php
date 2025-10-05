<div class="content active">
    @if (count($nilaiLapangan) > 0)
    <div class="accordion mt-3 accordion-bordered" id="accordionStyle1">
        <div class="accordion-item card">
            <h2 class="accordion-header">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionStyle1-1" aria-expanded="false">
                    Nilai Pembimbing Lapangan
                </button>
            </h2>
    
            <div id="accordionStyle1-1" class="accordion-collapse collapse" data-bs-parent="#accordionStyle1" style="">
                <div class="accordion-body">
                    @include('kelola_mahasiswa/penilaian/components/nilai_pemb_lapangan')
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info alert-dismissible" role="alert">
        <i class="ti ti-info"></i>
        Pembimbing Lapangan Belum Memberikan Nilai Magang
    </div>
    @endif
    <div class="table-responsive border border-bottom-0 mt-4">
        <table class="table" id="table-penilaian">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Aspek Penilaian</th>
                    <th>Deskripsi Penilaian</th>
                    <th>Nilai Max</th>
                    <th>Nilai Magang</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penilaian as $key => $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->aspek_penilaian }}</td>
                    <td>{{ $item->deskripsi_penilaian }}</td>
                    <td>{{ $item->nilai_max }}</td>
                    <td>
                        <input type="hidden" name="id_kompnilai[{{ $key }}]" value="{{ $item->id_kompnilai }}">
                        <div class="form-group">
                            <input type="text" name="nilai[{{ $key }}]" class="form-control nilai-input" onkeyup="getIndexNilai();" value="{{ $item->nilai ?? '' }}"/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <th class="text-center" colspan="4">TOTAL NILAI AKHIR MAGANG</th>
                    <th class=""><input type="text" id="nilai-akhir" class="form-control" placeholder="-" style="max-width: 150px;" disabled /></th>
                </tr>
                <tr>
                    <th class="text-center" colspan="4">PREDIKAT INDEX NILAI AKHIR MAGANG</th>
                    <th class=""><input type="text" id="index-nilai" class="form-control" placeholder="-" style="max-width: 150px;" disabled /></th>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-5">
        <button class="btn btn-primary button-next" type="button" data-step="{{ Crypt::encryptString("1") }}">
            <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
            <i class="ti ti-arrow-right"></i>
        </button>
    </div>
</div>