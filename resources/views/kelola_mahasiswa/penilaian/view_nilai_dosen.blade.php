@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
<div class="row mb-2">
    <div class="">
        <a href="{{ route('kelola_mhs_pemb_akademik') }}" type="button" class="btn btn-outline-primary mb-3 waves-effect">
            <span class="ti ti-arrow-left me-2"></span>Kembali
        </a>
    </div>
    <div class="col-md-9 col-12">
        <h4 class="fw-bold text-sm"><span class="text-muted fw-light text-xs">Kelola Mahasiswa/ </span>
            Nilai Mahasiswa Magang
        </h4>
    </div>
</div>
<div class="card bg-transparent border border-secondary shadow-none ">
    <div class="card-body">
        <div class="d-flex justify-content-start mb-4">
            <div class="text-center" style="overflow: hidden; width: 100px; height: 100px;">
                @if ($mahasiswa->profile_picture)
                <img src="{{ asset('storage/' . $mahasiswa->profile_picture) }}" alt="user-avatar" class="d-block" width="100" id="image_industri">
                @else
                <img src="{{ asset('app-assets/img/avatars/user.png') }}" alt="user-avatar" class="d-block" width="100" id="image_industri" data-default-src="{{ asset('app-assets/img/avatars/user.png') }}">   
                @endif
            </div>
            <div class="my-auto ms-3">
                <h4 class="my-0">{{ $mahasiswa->namamhs }}</h4>
                <span class="my-0">{{ $mahasiswa->nim }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-7">
                <h5>Informasi Kegiatan</h5>
                <div class="row">
                    <div class="col-4">
                        <h6 class="mb-1">Program Magang</h6>
                        <span>{{ $mahasiswa->namajenis }}</span>
                    </div>
                    <div class="col-4">
                        <h6 class="mb-1">Durasi Magang</h6>
                        <span>{{ is_array($mahasiswa->durasimagang) ? implode(' & ', $mahasiswa->durasimagang) : $mahasiswa->durasimagang }}</span>
                    </div>
                    <div class="col-4">
                        <h6 class="mb-1">Periode Kegiatan</h6>
                        <span>{{ ($mahasiswa->startdate_magang) ? Carbon\Carbon::parse($mahasiswa->startdate_magang)->format('d M Y') : '-' }} - {{ ($mahasiswa->enddate_magang) ? Carbon\Carbon::parse($mahasiswa->enddate_magang)->format('d M Y') : '-' }}</span>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <h5>Informasi Tambahan</h5>
                <div class="row">
                    <div class="col-6">
                        <h6 class="mb-1">Lokasi Magang</h6>
                        <span>{{ $mahasiswa->namaindustri }}</span>
                    </div>
                    <div class="col-6">
                        <h6 class="mb-1">Posisi</h6>
                        <span>{{ $mahasiswa->intern_position }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mt-4">
    <div class="card-body">
        <div class="d-flex justify-content-start">
            @if ($urlInputNilai != null)
            <a href="{{ $urlInputNilai }}" class="btn btn-primary">Input Nilai</a>
            @else
            <a href="javascript:void(0)" class="btn btn-primary disabled">Input Nilai</a>
            @endif
            <a href="#" class="btn ms-3 btn-outline-primary" onclick="getNilaiPembLapangan($(this));">Lihat Nilai Pembimbing Lapangan</a>
        </div>
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
                    @foreach ($penilaian as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->aspek_penilaian }}</td>
                        <td>{{ $item->deskripsi_penilaian }}</td>
                        <td>{{ $item->nilai_max }}</td>
                        <td>{{ $item->nilai ?? '-' }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th class="text-center fw-bolder" colspan="4">TOTAL NILAI  MAGANG</th>
                        <th class="fw-bolder">{{ $total_nilai_pa }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <h5 class="mt-5 mb-1">Nilai Pembimbing Lapangan</h5>
        <div id="container_result_nilai_lap" class="table-responsive border border-bottom-0 mt-4">
            {!! $container_result_nilai_lap !!}
        </div>
        <h5 class="mt-5 mb-1">Nilai Pembimbing Akademik</h5>
        <div id="container_result_nilai_akademik" class="table-responsive border border-bottom-0 mt-4">
            {!! $container_result_nilai_akademik !!}
        </div>
        <h5 class="mt-5 mb-1">Nilai Akhir</h5>
        <div id="container_result_nilai_akhir" class="table-responsive border border-bottom-0 mt-4">
            {!! $container_result_nilai_akhir !!}
        </div>
    </div>
</div>
<div id="container-modal-nilai-lapangan"></div>
@endsection

@section('page_script')
<script>
    function getNilaiPembLapangan(e) {
        btnBlock(e);
        $.ajax({
            url: `{{ $url_get_nilai_pemb_lapangan }}`,
            type: 'GET',
            success: function (res) {
                btnBlock(e, false);
                $('#container-modal-nilai-lapangan').html(res.data);
                $('#modal-nilai-lapangan').modal('show');
            }
        });
    }

    $('#modal-nilai-lapangan').on('hidden.bs.modal', function () {
        $('#container-modal-nilai-lapangan').html(''); 
    });
</script>
@endsection