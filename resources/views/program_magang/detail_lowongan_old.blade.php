@extends('partials.horizontal_menu')

@section('page_style')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <a href="#"  class="btn btn-outline-primary text-primary mt-4 mb-3">
        <span class="ti ti-arrow-left me-2"></span>Kembali
    </a>
    <div class="sec-title">
        <h4>Detail Lowongan Pekerjaan</h4>
    </div>
    <div class="mb-5">
        <div class="card" style="padding: 50px 30px; width: 100%;">
            <div class="card-body d-flex flex-row justify-content-between" style=" border-bottom: 1px solid #D3D6DB  !important">
                <div class="">
                    <div class="d-flex items-center justify-content-start">
                        <img src="{{ asset('front/assets/img/icon_lowongan.png')}}" alt="" style="width: 150px; height: 90px !important">
                        <div class="ms-5">
                            <p class="fw-bolder text-black" style="font-size: 32px; color: #23314B">{{ $lowongan->namaindustri }}</p>
                            <p class="mt-n3" style="font-size: 18px; color: #4B465C">{{ $lowongan->intern_position }}</p>
                        </div>
                    </div>
                    <div class="d-flex" style="margin-top: 40px; font-size: 16px; color: #23314B !important">
                        <ul style="border-right: 1px solid #D3D6DB; padding: 0 20px 0 0;">
                            <li class="d-flex align-items-center fw-semibold" style="margin-top: 15px !important">
                                <i class="ti ti-users ti-xs me-2"></i>
                                {{ $lowongan->kuota }} Kouta Penerimaan
                            </li>
                            <li class=" d-flex align-items-center fw-semibold" style="margin-top: 15px !important">
                                <i class="ti ti-briefcase ti-xs me-2"></i>
                                {{ $lowongan->pelaksanaan }}
                            </li>
                            <li class=" d-flex align-items-center fw-semibold" style="margin-top: 15px !important">
                                <i class="ti ti-calendar-time  ti-xs me-2"></i>
                                {{ implode(' dan ', json_decode($lowongan->durasimagang)) }}
                            </li>
                        </ul>
                        <ul style="border-right: 1px solid #D3D6DB; padding: 0 20px 0 20px;">
                            <li class=" d-flex align-items-center fw-semibold" style="margin-top: 15px !important">
                                <i class="ti ti-map-pin  ti-xs me-2"></i>
                                {{ implode(', ', json_decode($lowongan->lokasi)) }}
                            </li>
                            <li class=" d-flex align-items-center fw-semibold" style="margin-top: 15px !important">
                                <i class="ti ti-cash ti-xs me-2"></i>
                                {{ uangSakuRupiah($lowongan->nominal_salary) }}
                            </li>
                            <li class="d-flex align-items-center fw-semibold" style="margin-top: 15px !important">
                                <i class="ti ti-man  ti-xs me-2"></i>
                                {{ $lowongan->gender }}
                            </li>
                        </ul>
                        <ul style="padding: 0 0 0 20px;">
                            <li class="list-group-item d-flex align-items-start fw-semibold" style="margin-top: 15px !important">
                                <i class="ti ti-school ti-xs me-2"></i>
                                <div>
                                    Program Studi
                                    <ul style="list-style-type: disc; padding-left: 20px; margin-top: 5px;">
                                        @foreach ($lowongan->program_studi as $item)
                                        <li>{{ $item->namaprodi }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="w-auto text-end">
                    <p class="mt-5" style="font-size: 18px;">Batas Melamar 13 Juli 2023</p>
                    <div class="text-end mt-4 me-2">
                        <div class="row">
                            <!-- <div class="col-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Laporkan"><button type="button" class="btn btn-outline-dark waves-effect me-3" onclick="changeColor(this)" data-bs-toggle="modal" data-bs-target="#modalCenter">
                                    <i class="ti ti-flag"></i>
                                </button>
                            </div> -->
                            <div class="col-6" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Bagikan ">
                                <button type="button" class="btn btn-outline-dark waves-effect" onclick="changeColor(this)" data-bs-toggle="modal" data-bs-target="#modalbagikan" style="width: 95px;">
                                    <i class="ti ti-share" style="font-size: x-large;"></i>
                                </button>
                            </div>
                            <div class="col-6" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Simpan">
                                <button type="button" class="btn btn-outline-dark waves-effect" onclick="changeColor(this)" data-bs-toggle="modal" data-bs-target="#modalalert" style="width: 95px;">
                                    <i class="ti ti-bookmark" style="font-size: x-large;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4"></div>
                    <a href="/apply" type="submit" class="btn btn-primary waves-effect waves-light" style="height: 50px; width: 230px;">
                        Lamar Lowongan
                    </a>
                </div>
            </div>
            <div class="mt-4" style="border-bottom: 1px solid #D3D6DB;">
                <h3 style="padding-left: 20px;">Deskripsi pekerjaan</h3>
                <ul style="list-style-type: disc; padding-left: 50px; margin-top: 5px; padding-bottom: 30px; font-size: 18px; color: #23314B;">
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
                <h3 style="padding-left: 20px;">Requirements</h3>
                <ul style="list-style-type: disc; padding-left: 50px; margin-top: 5px; padding-bottom: 30px; font-size: 18px; color: #23314B;">
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
                <h3 style="padding-left: 20px;">Benefit</h3>
                <ul style="list-style-type: disc; padding-left: 50px; margin-top: 5px; padding-bottom: 30px; font-size: 18px; color: #23314B;">
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
                <h3 style="padding-left: 20px;">Kemampuan</h3>

                <div class="d-flex" style="column-gap: 10px; padding-left: 20px; padding-bottom: 30px !important">
                    <span class="badge rounded-pill bg-primary bg-glow" style="font-size: 15px;">SPSS</span>
                    <span class="badge rounded-pill bg-primary bg-glow" style="font-size: 15px;">Microsoft Office</span>
                    <span class="badge rounded-pill bg-primary bg-glow" style="font-size: 15px;">Google Suite</span>
                    <span class="badge rounded-pill bg-primary bg-glow" style="font-size: 15px;">Counseling Tools</span>
                </div>
            </div>

            <div class="mt-4">
                <h3 style="padding-left: 20px;">Seleksi Tahap 1</h3>
                <div class="mb-3" style="padding-left: 20px; font-size: 18px;"><i class="ti ti-clipboard-list" style="font-size: xx-large;"></i>Seleksi Administrasi</div>
                <div style="padding-left: 20px; font-size: 18px;"><i class="ti ti-clipboard-list" style="font-size: xx-large;"></i>Range Tanggal Pelaksanaan: 18/10/2023 - 20/10/2023</div>
            </div>

            <div class="mt-4">
                <h3 style="padding-left: 20px;">Seleksi Tahap 2</h3>
                <div class="mb-3" style="padding-left: 20px; font-size: 18px;"><i class="ti ti-clipboard-list" style="font-size: xx-large;"></i>Wawancara HR</div>
                <div style="padding-left: 20px; font-size: 18px;"><i class="ti ti-clipboard-list" style="font-size: xx-large;"></i>Range Tanggal Pelaksanaan: 18/10/2023 - 20/10/2023</div>
            </div>

            <div class="mt-4" style="border-bottom: 1px solid #D3D6DB;">
                <h3 style="padding-left: 20px;">Seleksi Tahap 3</h3>
                <div class="mb-3" style="padding-left: 20px; font-size: 18px;"><i class="ti ti-clipboard-list" style="font-size: xx-large;"></i>Wawancara User</div>
                <div class="mb-4" style="padding-left: 20px; font-size: 18px;"><i class="ti ti-clipboard-list" style="font-size: xx-large;"></i>Range Tanggal Pelaksanaan: 18/10/2023 - 20/10/2023</div>
            </div>

            <div class="mt-4" style="border-bottom: 1px solid #D3D6DB;">
                <h3 style="padding-left: 20px;">Tentang Perusahaan</h3>

                <p style="margin-top: 5px; padding-left: 20px; font-size: 18px; color: #23314B;">
                    ÅF and Pöyry joined forces in order to become an international engineering, design and advisory company,
                    driving digitalisation and sustainability for the energy, infrastructure and industrial sectors all over
                    the
                    world. AFRY as a new common brand of ÅF Pöyry is one of the largest international power sector
                    consulting
                    and engineering company with about 17,000 experts working across the world to create sustainable
                    solutions
                    for future generations
                </p>
                <div style="margin-top: 5px; padding-left: 20px; padding-bottom: 30px;">
                    <a href="/detail_perusahaan" class="btn btn-outline-primary btn-label-primary mt-2" type="button">LIhat Perusahaan</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal -->
@include('program_magang/components/modal_simpan_lowongan')
@endsection

@section('page_script')
<script>
    function changeColor(button) {
        button.classList.toggle('highlight');
    }
</script>
@endsection