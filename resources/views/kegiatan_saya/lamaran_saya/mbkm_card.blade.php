<!-- Magang MBKM -->
<div class="tab-pane fade show" id="navs-pills-justified-magang-mbkm" role="tabpanel">
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="table table-mbkm" id="table-mbkm">
                <thead>
                    <tr>
                        <th>NOMOR</th>
                        <th style="min-width:160px">JENIS MAGANG</th>
                        <th style="min-width:170px">PERUSAHAAN</th>
                        <th>POSISI</th>
                        <th>STATUS PENGAJUAN</th>
                        <th>AKSI</th>
                </thead>
            </table>
        </div>
    </div>
</div>


<!-- /Magang MBKM -->

@section('page_script')
<script>
    var jsonData = [{
            "nomor": "1",
            "jenis": "MSIB - Studi Independen",
            "perusahaan": "PT. Teknologi Nirmala Olah Daya Informasi",
            "posisi": "System Analyst",
            "status": "<span class='badge bg-label-warning'>Belum Diterima</span>",
            "aksi": "<a data-bs-toggle='modal' data-bs-target='#modalDitolak' class='btn-icon text-danger waves-effect waves-light'><i class='tf-icons ti ti-file-x'></i></a><a data-bs-toggle='modal' data-bs-target='#modalDiterima' class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-file-check'></i></a>",

        },
        {
            "nomor": "2",
            "jenis": "MSIB - Magang Bersertifikat",
            "perusahaan": "PT. Teknologi Nirmala Olah Daya Informasi",
            "posisi": "Quality Assurance",
            "status": "<span class='badge bg-label-warning'>Belum Diterima</span>",
            "aksi": "<a data-bs-toggle='modal' data-bs-target='#modalDitolak' class='btn-icon text-danger waves-effect waves-light'><i class='tf-icons ti ti-file-x'></i></a><a data-bs-toggle='modal' data-bs-target='#modalDiterima' class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-file-check'></i></a>",
        },
        {
            "nomor": "3",
            "jenis": "FHCI (Forum Human Capital Indonesia)",
            "perusahaan": "PT. Teknologi Nirmala Olah Daya Informasi",
            "posisi": "Business Development",
            "status": "<span class='badge bg-label-warning'>Belum Diterima</span>",
            "aksi": "<a data-bs-toggle='modal' data-bs-target='#modalDitolak' class='btn-icon text-danger waves-effect waves-light'><i class='tf-icons ti ti-file-x'></i></a><a data-bs-toggle='modal' data-bs-target='#modalDiterima' class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-file-check'></i></a>",
        },
        {
            "nomor": "4",
            "jenis": "MBKM - Internal Tel-U",
            "perusahaan": "PT. Teknologi Nirmala Olah Daya Informasi",
            "posisi": "Marketing Communication",
            "status": "<span class='badge bg-label-warning'>Belum Diterima</span>",
            "aksi": "<a data-bs-toggle='modal' data-bs-target='#modalDitolak' class='btn-icon text-danger waves-effect waves-light'><i class='tf-icons ti ti-file-x'></i></a><a data-bs-toggle='modal' data-bs-target='#modalDiterima' class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-file-check'></i></a>",
        },
        {
            "nomor": "5",
            "jenis": "Magang Ekstensi D4 TRM",
            "perusahaan": "PT. Teknologi Nirmala Olah Daya Informasi",
            "posisi": "Frontend Developer",
            "status": "<span class='badge bg-label-warning'>Belum Diterima</span>",
            "aksi": "<a data-bs-toggle='modal' data-bs-target='#modalDitolak' class='btn-icon text-danger waves-effect waves-light'><i class='tf-icons ti ti-file-x'></i></a><a data-bs-toggle='modal' data-bs-target='#modalDiterima' class='btn-icon text-success waves-effect waves-light'><i class='tf-icons ti ti-file-check'></i></a>",
        },
    ];

    var table = $('#table-mbkm').DataTable({
        "data": jsonData,
        columns: [{
                data: "nomor"
            },
            {
                data: "jenis"
            },
            {
                data: "perusahaan"
            },
            {
                data: "posisi"
            },
            {
                data: "status"
            },
            {
                data: "aksi"
            }
        ]
    });
</script>

@endsection