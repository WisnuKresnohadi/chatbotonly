@extends('partials.vertical_menu')

@section('page_style')
    <style>
        table.dataTable thead>tr>th.sorting {
            background-color: white;
            position: static;
            padding: 0.5rem;
        }

        table.dataTable thead>tr>th.sorting::after {
            display: flex;
            justify-content: end;
            position: static;
            right: 0%;
            bottom: 0%;
            width: 100%;
            height: 100%;
        }

        table.dataTable thead>tr>th.sorting::before {
            display: flex;
            justify-content: end;
            position: static;
            right: 0%;
            bottom: 0%;
            width: 100%;
            height: 100%;
        }
    </style>
@endsection


@section('content')
    <div>
        <a href="{{ route('igracias') }}" class="btn btn-outline-primary mb-3">
            <i class="ti ti-arrow-left me-2 text-primary"></i>
            Kembali
        </a>
    </div>
    <div class="row">
        <div class="col-md-10 col-12">
            <h4 class="fw-bold"><span class="text-muted fw-light">Data Nilai Mahasiswa /</span> Detail Nilai Mahasiswa</h4>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable table-responsive">

                    <div class="p-2 px-3 col mx-4 my-4 border rounded">
                        <h4>Profil Mahasiswa</h4>
                        <div class="d-flex gap-5 align-items-center">
                            <div class="ms-2">
                                <img src="{{ isset($user->foto) ?  url('storage/foto/'.$user->foto) : asset('app-assets/img/avatars/user.png') }}" alt="Profile Image"class="profile-pic rounded-circle" id="initialImage">                                    
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem;">
                                <span class="fs-5">Nama Mahasiswa</span> <span style="grid-column: span 2 / span 2; "> <span>:</span> <span class="ms-2 fw-bold fs-5">{{ $mahasiswa->namamhs }}</span></span>
                                <span class="fs-5">NIM</span> <span style="grid-column: span 2 / span 2;"><span>:</span> <span class="ms-2 fw-bold fs-5">{{ $mahasiswa->nim }}</span></span>                                
                                <span class="fs-5">Kelas</span> <span style="grid-column: span 2 / span 2;"><span>:</span> <span class="ms-2 fw-bold fs-5">{{ $mahasiswa->kelas }}</span></span>                                
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem;">
                                <span class="fs-5">Angkatan</span> <span style="grid-column: span 2 / span 2; "><span>:</span> <span class="ms-2 fw-bold fs-5">{{ $mahasiswa->angkatan }}</span></span>
                                <span class="fs-5">Program Studi</span> <span style="grid-column: span 2 / span 2;"><span>:</span> <span class="ms-2 fw-bold fs-5">{{ $mahasiswa->namaprodi }} {{ $mahasiswa->jenjang }}</span></span>
                                <span class="fs-5">IP Kumulatif (IPK) </span> <span style="grid-column: span 2 / span 2;"><span>:</span> <span class="ms-2 fw-bold fs-5">{{ $mahasiswa->ipk }}</span></span>
                            </div>
                        </div>
                    </div>

                    <div class="mx-4" style="margin-top: 2.5rem">                        
                        <table class="table table-striped border" id="table-nilai-mk-mahasiswa">
                            <thead>
                                <tr>
                                    <th>NOMOR</th>
                                    <th>SEMESTER</th>
                                    <th class="text-center">KODE MK</th>
                                    <th class="text-center">NAMA MATAKULIAH</th>
                                    <th>SKS</th>
                                    <th>NILAI</th>
                                    <th>PREDIKAT</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_script')
    <script>
        $(document).ready(function() {
            table_nilai_mk_mahasiswa();
        });

        function table_nilai_mk_mahasiswa() {
            var table = $('#table-nilai-mk-mahasiswa').DataTable({
                ajax: "{{ route('igracias.mahasiswa.detail', $id) }}",
                serverSide: false,
                processing: true,
                scrollX: true,
                destroy: true,
                ordering: false,
                paging: false,                
                info: false,
                dom: "<'row'<'col-md-6 d-flex align-items-center'<'custom-title mr-3'>><'col-md-6 text-right'<'d-inline'f>>>"
      + "<'row'<'col-sm-12'tr>>",
initComplete: function() {
    // Place the title beside the search box, vertically centered
    $('.custom-title').html("<h4 style='margin: 0;'>Nilai Lulus Mahasiswa</h4>");
},
                columns: [{
                        data: "DT_RowIndex"
                    },
                    {
                        data: 'semester',
                        name: 'semseter'
                    },
                    {
                        data: 'kode_mk',
                        name: 'kode_mk'
                    },
                    {
                        data: 'namamk',
                        name: 'namamk'
                    },
                    {
                        data: 'sks',
                        name: 'sks'
                    },
                    {
                        data: 'nilai_mk',
                        name: 'nilai_mk'
                    },
                    {
                        data: 'predikat',
                        name: 'predikat'
                    },
                ],
                // rowGroup: {
                //     dataSrc: 'semester'
                // },
                drawCallback: function(settings) {
                    $('#table-nilai-mk-mahasiswa tbody tr td').css('padding', '1.4rem');
                }
            });
        }
    </script>
@endsection
