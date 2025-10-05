@extends('partials.vertical_menu')

@section('page_style')
    <style>
        .top{
            display: flex !important;
            justify-content: space-between;
            align-items: center;
        }

        .table>tbody>tr:nth-child(even)>td,
        .table>tbody>tr:nth-child(even)>th {
            background-color: #FAFAFA !important; // Choose your own color here
        }

        .table>tbody>tr:nth-child(odd)>td,
        .table>tbody>tr:nth-child(odd)>th {
        background-color: #fff; // Choose your own color here
        }
    </style>
@endsection

@section('content')
    <form class="default-form" method="POST" action="{{ route('informasi_lowongan.update_nilai_kriteria', $kandidat->id_pendaftaran) }}">
        @csrf
        <div class="mb-3 d-flex justify-content-start">
            <a href="{{ route('informasi_lowongan.detail', $kandidat->id_lowongan) }}" class="btn btn-outline-primary">
                <i class="ti ti-arrow-left"></i>
                Kembali
            </a>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <span class="fw-bold" style="font-size: 150%;"><span class="text-muted fw-light">Informasi Lowongan / <span style="color: rgba(93, 88, 113, 1); font-weight: 600;">{{$kandidat['nim']}} - {{$kandidat['namamhs']}}</span></span></span>
            <a class="text-white cursor-pointer btn btn-primary" onclick="detailInfo($(this))" data-id="{{$kandidat['id_pendaftaran']}}">
                Lihat Resume CV
            </a>
        </div>
        <div class="p-3 mt-4 table-responsive card">
            <table class="table border" id="table-scores">
                <thead>
                    <tr>
                        <th class="text-center">
                            No
                        </th>
                        <th>
                            Nama Kriteria
                        </th>
                        <th>
                            Deskripsi Kriteria DIPERSYARATKAN
                        </th>
                        <th>
                            Deskripsi Kriteria Mahasiswa
                        </th>
                        <th style="width: 30%">
                            predikat nilai
                        </th>
                    </tr>
                </thead>
            </table>
            {{-- @dd($kandidat->enddate >= now(), $kandidat->kuota_wawancara >= 1) --}}
            <div class="d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal"
                    {{ ($kandidat->tgl_akhir <= now() || $kandidat->kuota_wawancara <= 0) ? 'enabled' : 'disabled' }}>
                    Simpan Data
                </button>
            </div>


        </div>
        @include('lowongan_magang/informasi_lowongan/components/modal')
    </form>
@endsection

@section('page_script')
    <script>

        $(document).ready(function() {
            loadData();
        });

        // ====================================

        // function changeColor(selectElement) {
        //     // Ambil nilai yang dipilih
        //     const selectedValue = parseInt(selectElement.value);

        //     // Hapus semua kelas warna sebelumnya
        //     selectElement.classList.remove('text-primary', 'text-info', 'text-disable', 'text-warning', 'text-danger');

        //     // Tentukan kelas yang sesuai berdasarkan nilai
        //     if (selectedValue > 80) {
        //         selectElement.classList.add('text-primary'); // Sangat Baik
        //     } else if (selectedValue > 60) {
        //         selectElement.classList.add('text-info'); // Baik
        //     } else if (selectedValue > 40) {
        //         selectElement.classList.add('text-secondary'); // Cukup
        //     } else if (selectedValue > 20) {
        //         selectElement.classList.add('text-warning'); // Buruk
        //     } else {
        //         selectElement.classList.add('text-danger'); // Sangat Buruk
        //     }
        // }
        // ====================================

    function loadData() {
        var table = $('#table-scores').DataTable({
            ajax: "{{ route('informasi_lowongan.detail_kriteria_kandidat',  $kandidat['id_pendaftaran']) }}",
            serverSide: false,
            processing: true,
            scrollX: true,
            destroy: true,
            paging : false,
            info: false,
            columns: [
                { data: "DT_RowIndex", className: 'dt-center' },
                { data: 'kriteria', name: 'kriteria' },
                { data: 'desk_persyaratan', name: 'desk_persyaratan' },
                { data: 'desk_kriteria_mhs', name: 'desk_kriteria_mhs' },
                { data: 'predikat_nilai', name: 'predikat_nilai' }
            ],
            drawCallback: function(settings) {
                    $('#table-scores tbody tr td').css('padding', '1.4rem');
                    initSelect2();
            }
        })};

        $('.table').DataTable({
            dom: '<"top"lf><"panduan">rt<"bottom"ip>',
            initComplete: function() {
                $('div.panduan').html('<div class="mt-2 rounded w-100" style="background:#CCF5FA; display:flex; flex-direction:row; height:3.5rem; margin-bottom:1rem; gap:0.5rem; padding-left:1rem; align-items:center;"><div class="d-flex align-items-start" style="gap:0.5rem; color:#009BAE;"><i class="ti ti-info-circle fs-4"></i><div style="display:flex; flex-direction:column;"><span style="font-weight:600;">Panduan</span><span>Beri predikat nilai kepada kandidat dengan membandingkan bagian kolom deskripsi kriteria dipersyaratkan dengan deskripsi kriteria milik mahasiswa</span></div></div></div>');
                //$('div.top').css({'display:flex;','flex-direction:row;','align-items: center;'})
            }
        });
        function detailInfo(e) {
            let offcanvas = $('#detail_pelamar_offcanvas');
            offcanvas.offcanvas('show');
            btnBlock(offcanvas);

            $.ajax({
                url: "{{ $urlDetailKandidat }}?data_id=" + e.attr('data-id'),
                type: "GET",
                success: function (response) {
                    btnBlock(offcanvas, false);
                    response = response.data;
                    $('#container_detail_pelamar').html(response.view);
                    $('#change_status').attr('data-id', response.id_pendaftaran);
                    $('#change_status').attr('data-default', response.current_step);
                    $('#change_status').val(response.current_step).change();
                }
            });
        }
        $('#detail_pelamar_offcanvas').on('hidden.bs.offcanvas', function () {
            $('#container_detail_pelamar').html(null);
            $('#change_status').removeAttr('data-id');
        });
    </script>
@endsection
