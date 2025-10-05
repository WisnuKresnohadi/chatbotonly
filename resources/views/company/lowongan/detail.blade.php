@extends('partials_admin.template')

@section('page_style')
    <link rel="stylesheet" href="../../app-assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <style>

    </style>
@endsection

@section('main')
    <div class="row ">
        <div class="">
            <h4 class="fw-bold text-sm"><span class="text-muted fw-light text-xs">Lowongan Magang / Kelola Magang / </span>
                Detail Lowongan UI/UX Designer
            </h4>
        </div>
    </div>
    <div class="d-flex">
        <div class="card" style="padding: 50px 30px; width: 80%; margin-right: 20px; !important">
            <div class="card-body d-flex flex-row justify-content-between"
                style=" border-bottom: 1px solid #D3D6DB;  !important">
                <div class="">
                    <div class="d-flex items-center justify-content-start">
                        <img src="/assets/images/wings.png" alt="" style="width: 150px; height: 90px; !important">
                        <div class="ms-5">
                            <p class="fw-bolder text-black" style="font-size: 32px; color: #23314B">Human resources</p>
                            <p class="mt-n3" style="font-size: 18px; color: #4B465C">IT consultant</p>
                        </div>
                    </div>
                    <div class="d-flex" style="margin-top: 40px; font-size: 13px; color: #23314B; !important">
                        <ul style="border-right: 1px solid #D3D6DB; padding: 0 20px 0 0; !important">
                            <li class="d-flex align-items-center fw-semibold" style="margin-top: 15px !important">
                                <i class="ti ti-calendar ti-xs me-2"></i>
                                2023/2024 - Ganjil
                            </li>
                            <li class="d-flex align-items-center fw-semibold" style="margin-top: 15px !important">
                                <i class="ti ti-users ti-xs me-2"></i>
                                100 Mahasiswa
                            </li>
                            <li class="d-flex align-items-center fw-semibold" style="margin-top: 15px !important">
                                <i class="ti ti-building-community  ti-xs me-2"></i>
                                Fakultas Ilmu Terapan
                            </li>
                        </ul>
                        <ul style="border-right: 1px solid #D3D6DB; padding: 0 20px 0 20px; !important">

                            <li class=" d-flex align-items-center fw-semibold" style="margin-top: 15px !important">
                                <i class="ti ti-map-pin  ti-xs me-2"></i>
                                Bandung & Jakarta
                            </li>
                            <li class=" d-flex align-items-center fw-semibold" style="margin-top: 15px !important">
                                <i class="ti ti-currency-dollar  ti-xs me-2"></i>
                                IDR 4.300.000 - 5.500.000
                            </li>
                            <li class=" d-flex align-items-center fw-semibold" style="margin-top: 15px !important">
                                <i class="ti ti-clock  ti-xs me-2"></i>
                                2 Semerter
                            </li>
                        </ul>
                        <ul style="padding: 0 0 0 20px; !important">
                            <li class="list-group-item d-flex align-items-start fw-semibold"
                                style="margin-top: 15px !important">
                                <i class="ti ti-school ti-xs me-2"></i>
                                <div>
                                    Program Studi
                                    <ul style="list-style-type: disc; padding-left: 20px; margin-top: 5px;">
                                        <li>D3 Rekayasa Perangkat Lunak</li>
                                        <li>D3 Rekayasa Perangkat Lunak</li>
                                        <li>D3 Rekayasa Perangkat Lunak</li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="w-auto">
                    <span class="badge bg-label-danger w-100">Ditolak</span>
                    <p class="mt-2" style="font-size: 22px; color: #4B465C !important">Detail pengajuan</p>
                    <p class="fw-normal" style="font-size: 13px; margin-top: -8px; !important">Pengajuan : <span
                            class="fw-semibold">25/08/2020</span></p>
                    <p class="fw-normal" style="font-size: 13px; margin-top: -12px; !important">Disetujui : <span
                            class="fw-semibold">25/08/2020</span></p>
                    <p class="fw-normal" style="font-size: 13px; margin-top: -12px; !important">Oleh : <span
                            class="fw-semibold">Admin
                            1</span></p>
                </div>
            </div>
            <div class="mt-4" style="border-bottom: 1px solid #D3D6DB;">
                <p style="font-size: 26px; color: #23314B; !important">Deskripsi pekerjaan</p>
                <ul
                    style="list-style-type: disc; padding-left: 20px; margin-top: 5px; padding-bottom: 30px; font-size: 15px; color: #23314B;">
                    <li>Manage Talent Acquisition activities for Desk Worker and Non-Desk Worker

                    </li>
                    <li>
                        Lead HR Internal Communication and Employer Branding
                    </li>
                    <li>
                        Manage On-Boarding program for new hire.
                    </li>
                    <li>
                        Manage People Development process from training need analysis into post-training effectiveness
                        evaluation including ROI.
                    </li>
                    <li>
                        Support employee Performance Evaluation process.

                    </li>
                    <li>
                        Support Talent Management and Succession Planning function.
                    </li>
                    <li>
                        Manage HR Digital function (Workday) in the country by ensuring data accuracy and updates.
                    </li>
                    <li>
                        Conduct HR People Analytic such as headcount, labor-cost, hours-work, etc.
                    </li>
                    <li>
                        Lead Employee Engagement activities and events.
                    </li>
                    <li>
                        Liaise with relevant parties to ensure HR function executed smoothly.
                    </li>
                    <li>Support other HR Indonesia operations activities.</li>
                </ul>
            </div>

            <div class="mt-4" style="border-bottom: 1px solid #D3D6DB;">
                <p style="font-size: 26px; color: #23314B; !important">Requirements</p>
                <ul
                    style="list-style-type: disc; padding-left: 20px; margin-top: 5px; padding-bottom: 30px; font-size: 15px; color: #23314B;">
                    <li>
                        At least Bachelor's degree in any field

                    </li>
                    <li>
                        At least 3 years of experience in HR / HRBP

                    </li>
                    <li>
                        Has strong numerical capability and excel expertise

                    </li>
                    <li>
                        Has experience using Workday will be an advantage

                    </li>
                    <li>
                        Good command of spoken and written English.


                    </li>
                    <li>
                        Experience within a rapidly changing organization in Multinational Company preferably within a
                        Manufacturing environment.
                    </li>
                    <li>
                        Strong attention to detail

                    </li>
                    <li>
                        Self-motivated and able to work without supervision

                    </li>
                    <li>
                        Willing to work in Cikampek area.

                    </li>
                </ul>
            </div>

            <div class="mt-4" style="border-bottom: 1px solid #D3D6DB;">
                <p style="font-size: 26px; color: #23314B; !important">Benefit</p>
                <ul
                    style="list-style-type: disc; padding-left: 20px; margin-top: 5px; padding-bottom: 30px; font-size: 15px; color: #23314B;">
                    <li>
                        Family Care
                    </li>
                    <li>
                        Parking Access
                    </li>
                    <li>
                        Reward Compensation
                    </li>

                </ul>
            </div>

            <div class="mt-4" style="border-bottom: 1px solid #D3D6DB;">
                <p style="font-size: 26px; color: #23314B; !important">Kemampuan</p>

                <div class="d-flex" style="column-gap: 10px; padding-bottom: 30px !important">
                    <span class="badge rounded-pill bg-success bg-glow">SPSS</span>
                    <span class="badge rounded-pill bg-success bg-glow">Microsoft Office</span>
                    <span class="badge rounded-pill bg-success bg-glow">Google Suite</span>
                    <span class="badge rounded-pill bg-success bg-glow">Counseling Tools</span>
                </div>
            </div>

            <div class="mt-4" style="border-bottom: 1px solid #D3D6DB;">
                <p style="font-size: 26px; color: #23314B; !important">Tentang Perusahaan</p>

                <p style="margin-top: 5px; padding-bottom: 30px; font-size: 15px; color: #23314B;">
                    ÅF and Pöyry joined forces in order to become an international engineering, design and advisory company,
                    driving digitalisation and sustainability for the energy, infrastructure and industrial sectors all over
                    the
                    world. AFRY as a new common brand of ÅF Pöyry is one of the largest international power sector
                    consulting
                    and engineering company with about 17,000 experts working across the world to create sustainable
                    solutions
                    for future generations
                </p>
            </div>
        </div>
        <div style="width: 20%">
            <div class="card" style=" height: 210px;">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <h5 class="card-title" style="font-size: 12px; color: #23314B; margin-top: 10px">Komentar</h5>
                        <p class="card-text" style="font-size: 12px; padding-bottom: 10px">Some quick example text to build
                            on
                            the card title and
                            make up the bulk of the
                            card's content.</p>
                    </li>
                    <li class="list-group-item">
                        <p style="font-size: 12px; font-weight: 600; color: #D3D6DB; margin-top: 10px">Timestamp : 15.00 -
                            12/09/2023 </p>
                        <p style="font-size: 12px; font-weight: 600; color: #D3D6DB; margin-top: -10px">Oleh : Admin 3 </p>
                    </li>

                </ul>
            </div>
            <button type="button" class="btn btn-label-warning w-100 mt-3"
                style="font-size: 15px; box-shadow: 0 2px 4px rgba(75, 70, 92, 0.1);">
                <i class="ti ti-edit ti-sm" style="margin-right: 15px"></i><a href="/edit">
                Ajukan perbaikan
            </button>

        </div>


    </div>
@endsection

@section('page_script')
    <script src="../../app-assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
    <script src="../../app-assets/js/forms-extras.js"></script>
    <script>
        var jsonData = [{
                "posisi": "UI/UX Designer",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-danger'>Non-aktif</span>",
                "aksi": "<a href='/edit'class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a href='/detail-lowongan' class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            },
            {
                "posisi": "UI/UX Designer",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-success'>Aktif</span>",
                "aksi": "<a href='/edit'class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a href='/detail-lowongan' class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            },
            {
                "posisi": "UI/UX Designer   ",
                "fakultas": "Ilmu terapan",
                "jurusan": "D3 Informatika <br> D3 Informatika",
                "tanggal": "<div class='flex'><small class='text-light fw-semibold'>Publish</small><h6>20 september 2023</h6><small class='text-light fw-semibold '>Takedown</small><h6>11 Desember 2024</h6></div>",
                "durasi_magang": "2 Semester",
                "status": "<span class='badge bg-label-danger'>Non-aktif</span>",
                "aksi": "<a href='/edit'class='btn-icon text-warning waves-effect waves-light'><i class='ti ti-edit'></i></a><a href='/detail-lowongan' class='btn-icon text-success waves-effect waves-light'><i class='ti ti-file-invoice'></i></a> <a class='btn-icon text-danger waves-effect waves-light'><i class='ti ti-trash'></i></a>",
            }
        ];

        var table = $('#table-kelola-mitra1').DataTable({
            "data": jsonData,
            columns: [{
                    data: "posisi"
                },
                {
                    data: "fakultas"
                },
                {
                    data: "jurusan"
                },

                {
                    data: "tanggal"
                },
                {
                    data: "durasi_magang"
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


    <script src="../../app-assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="../../app-assets/js/extended-ui-sweetalert2.js"></script>
@endsection
