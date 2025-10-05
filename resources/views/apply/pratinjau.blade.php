@extends('partials_mahasiswa.template')

@section('page_style')
<style>
    .hidden {
        display: none;
    }

    .page-item.active .page-link,
    .pagination li.active>a:not(.page-link) {
        border-color: #FFFFFF !important;
        background-color: #4EA971 !important;
    }

    .btn-success {
        color: #fff;
        background-color: #4EA971 !important;
        border-color: #4EA971 !important;
    }

    .highlight {
        background-color: #4EA971 !important;
        color: white !important;
    }

    .progress-bar {
        background-color: #4EA971 !important;
        color: #fff;
    }
</style>
@endsection

@section('main')
<div class="auto-container m-5">
    <h4>Pratinjau Data Diri  </h4>
    <div class="card mt-5">
        <div class="card-body mt-3 flex-grow-0 pt-0 h-100">
            <div class="row">
                <div class="col-12 d-flex justify-content-end">
                    <button class="btn btn-success waves-effect waves-light" data-bs-target="" style="min-width: 200px;"><i class="tf-icons ti ti-download me-2"></i><span class="mt-1">Unduh CV</span>
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img src="../../app-assets/img/avatars/2.png" alt="user image" class="d-block ms-0 mt-4  rounded user-profile-img" />
                    </div>
                    <div class="flex-grow-1 mt-0 mt-4">
                        <div class="d-flex align-items-end align-items-sm-start ms-3 flex-md-row flex-column gap-4">
                            <div class="me-2 ms-1 mt-3">
                                <h4 class="mb-2">Cecilia Payne</h4>
                                <p class="text">UI/UX Designer</p>
                            </div>
                            <div class="ms-auto">
                                <button class="rounded-circle btn-label-success btn-icon btn-sm waves-effect" style="min-width: 40px; height:40px;">
                                    <i class="ti ti-message" style="font-size: 25px;"></i>
                                </button>
                                <button class="rounded-circle btn-label-success btn-icon btn-sm waves-effect me-2" style="min-width: 40px; height:40px;">
                                    <i class="ti ti-phone-call" style="font-size: 25px;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4> Mengapa Saya Harus Di Terima?</h4>
            <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                    <p class="content-new mb-0">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    <u class="show_hide_new cursor-pointer" style="color:#4EA971">
                        Show more
                    </u>
            <hr>

            <h4>Informasi Pribadi</h4>
            <div class="row">
                <h5 class="mt-3"> Deskripsi Diri</h5>
                <div>
                    <p class="mb-0">Lorem ÅF and Pöyry joined forces in order to become an international engineering, design and advisory company, unknown printer took a galley of type and scrambled
                        it to make a type specimen book. It has survived not only five centuries, but also the leap into
                        electronic typesetting, remaining essentially unchanged.</p>
                    <p class="content-new mb-0">driving digitalisation and sustainability for the energy, infrastructure and industrial sectors all over the world.</p>
                    <u class="show_hide_new cursor-pointer" style="color:#4EA971">
                        Show more
                    </u>
                </div>
                <div class="col-4 mt-3">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <span class="fw-semibold me-1">NIM:</span>
                            <span>6705513025</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Universitas:</span>
                            <span>Universitas Telkom</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Fakultas:</span>
                            <span>Fakultas Ilmu Terapan</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Program Studi:</span>
                            <span>D3 Sistem Informasi</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Angkatan:</span>
                            <span>2021</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">IPK:</span>
                            <span>2021</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Eprt:</span>
                            <span>2021</span>
                        </li>
                    </ul>
                </div>
                <div class="col-4 mt-3">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <span class="fw-semibold me-1">TAK:</span>
                            <span>1000</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Email:</span>
                            <span>jennyrubyjane@gmail.com</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">No Telp:</span>
                            <span>08967654325</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Tanggal Lahir:</span>
                            <span>01 Januari 2002</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Jenis Kelamin:</span>
                            <span>Perempuan</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Alamat:</span>
                            <span>Jl. Rancabolang No. 145</span>
                        </li>
                    </ul>
                </div>
                <div class="col-4"></div>
            </div>
            <hr>

            <h4>Pendidikan</h4>
            <div class="card-body pb-0">
                <ul class="timeline ms-1 mb-0 mt-3">
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                            <h5 class="mb-2">University Of Melbourne</h5>
                            <p class="mb-2">Magister Management</p>
                            <p class="mb-2">IPK 3.89/4.00</p>
                            <small>Juli 2022 - Juli 2024</small>
                            <div class="border-bottom mt-4"></div>
                        </div>
                    </li>
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                            <h5 class="mb-2">University Of Melbourne</h5>
                            <p class="mb-2">Magister Management</p>
                            <p class="mb-2">IPK 3.89/4.00</p>
                            <p style="font-size: small;" class="mb-2">Juli 2022 - Juli 2024</p>
                            <div class="border-bottom mt-4"></div>
                        </div>
                    </li>
                    <li class="timeline-item timeline-item-transparent" style="border-left: 0px solid">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                            <h5 class="mb-2">University Of Melbourne</h5>
                            <p class="mb-2">Magister Management</p>
                            <p class="mb-2">IPK 3.89/4.00</p>
                            <small>Juli 2022 - Juli 2024</small>
                        </div>
                    </li>
                </ul>
            </div>
            <hr>

            <h4>Pengalaman Kerja</h4>
            <div class="card-body pb-0">
                <ul class="timeline ms-1 mb-0 mt-3">
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                            <h5 class="mb-2">UI/UX Designer</h5>
                            <p class="mb-2">Techno Infinty - Intership</p>
                            <p style="font-size: small;">Juli 2022 - Juli 2024</p>
                            <p class="mb-0">Lorem ÅF and Pöyry joined forces in order to become an international engineering, design and advisory company, unknown printer took a galley of type and scrambled
                                it to </p>
                            <p class="content-new mb-0">driving digitalisation and sustainability for the energy, infrastructure and industrial sectors all over the world.</p>
                            <u class="show_hide_new cursor-pointer" style="color:#4EA971">
                                Show more
                            </u>
                            <div class="border-bottom mt-4"></div>
                        </div>
                    </li>
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                            <h5 class="mb-2">UI/UX Designer</h5>
                            <p class="mb-2">Techno Infinty - Intership</p>
                            <p style="font-size: small;">Juli 2022 - Juli 2024</p>
                            <p class="mb-0">Lorem ÅF and Pöyry joined forces in order to become an international engineering, design and advisory company, unknown printer took a galley of type and scrambled
                                it to </p>
                            <p class="content-new mb-0">driving digitalisation and sustainability for the energy, infrastructure and industrial sectors all over the world.</p>
                            <u class="show_hide_new cursor-pointer" style="color:#4EA971">
                                Show more
                            </u>
                            <div class="border-bottom mt-4"></div>
                        </div>
                    </li>
                    <li class="timeline-item timeline-item-transparent" style="border-left: 0px solid">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                            <h5 class="mb-2">UI/UX Designer</h5>
                            <p class="mb-2">Techno Infinty - Intership</p>
                            <p style="font-size: small;">Juli 2022 - Juli 2024</p>
                            <p class="mb-0">Lorem ÅF and Pöyry joined forces in order to become an international engineering, design and advisory company, unknown printer took a galley of type and scrambled
                                it to </p>
                            <p class="content-new mb-0">driving digitalisation and sustainability for the energy, infrastructure and industrial sectors all over the world.</p>
                            <u class="show_hide_new cursor-pointer" style="color:#4EA971">
                                Show more
                            </u>
                        </div>
                    </li>
                </ul>
            </div>
            <hr>

            <h4>Keahlian</h4>
            <div class="mt-3">
                <span class="badge rounded-pill bg-success bg-glow" style="font-size: medium;">Figma </span>
                <span class="badge rounded-pill bg-success bg-glow" style="font-size: medium;">Adobe XD</span>
                <span class="badge rounded-pill bg-success bg-glow" style="font-size: medium;">Figma</span>
                <span class="badge rounded-pill bg-success bg-glow" style="font-size: medium;">Adobe XD</span>
            </div>
            <hr>

            <h4>Dokumen Pendukung</h4>
            <h5 class="mb-2">Desain UI/UX Design</h5>
            <p class="mb-2">Coursera</p>
            <p class="mb-2">Juli 2023-Juli 2030</p>
            <p class="mb-0">Lorem ÅF and Pöyry joined forces in order to become an international engineering, design and advisory company, unknown printer took a galley of type and scrambled
                it to </p>
            <p class="content-new mb-0">driving digitalisation and sustainability for the energy, infrastructure and industrial sectors all over the world.</p>
            <u class="show_hide_new cursor-pointer" style="color:#4EA971">
                Show more
            </u>
            <br>
            <a href="#"><u style="color: #0099FF">UI/UX Design.pdf</u></a>
            <div class="border-bottom mt-4"></div>
            <h5 class="mb-2 mt-4">Desain UI/UX Design</h5>
            <p class="mb-2">Coursera</p>
            <p class="mb-2">Juli 2023-Juli 2030</p>
            <p class="mb-0">Lorem ÅF and Pöyry joined forces in order to become an international engineering, design and advisory company, unknown printer took a galley of type and scrambled
                it to </p>
            <p class="content-new mb-0">driving digitalisation and sustainability for the energy, infrastructure and industrial sectors all over the world.</p>
            <u class="show_hide_new cursor-pointer" style="color:#4EA971">
                Show more
            </u>
            <br>
            <a href="#"><u style="color: #0099FF">UI/UX Design.pdf</u></a>
            <div class="border-bottom mt-4"></div>

            <h4 class="mt-3">Informasi Tambahan</h4>
            <div class="row">
                <div class="col-4">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <span class="fw-semibold me-1" style="font-size: 18px">Instagram:</span>
                            <span><a href="" style="color: #0099FF; font-size: 17px;">jenyrubyjane</a></span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1" style="font-size: 18px">Linkedin:</span>
                            <span><a href="" style="color: #0099FF; font-size: 17px;">jenyrubyjane</a></span>
                        </li>
                    </ul>
                </div>
                <div class="col-8">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <span class="fw-semibold me-1" style="font-size: 18px">Lokasi kerja yang di harapkan:</span>
                            <span style="font-size: 17px;">Bandung</span>
                        </li>
                </div>
            </div>
            <span class="fw-semibold me-1" style="font-size: 18px">Bahasa</span>
            <div class="mt-3">
                <span class="badge rounded-pill bg-success bg-glow" style="font-size: medium;">Mandarin </span>
                <span class="badge rounded-pill bg-success bg-glow" style="font-size: medium;">English</span>
                <span class="badge rounded-pill bg-success bg-glow" style="font-size: medium;">Japanese</span>
                <span class="badge rounded-pill bg-success bg-glow" style="font-size: medium;">Arabic</span>
            </div>
        </div>
    </div>
</div>


@endsection

@section('page_script')
<script>
    $(document).ready(function() {
        $(".content-new").hide();
        $(".show_hide_new").on("click", function() {
            var content = $(this).prev('.content-new');
            content.slideToggle(100);
            if ($(this).text().trim() == "Show more") {
                $(this).text("Show Less");
            } else {
                $(this).text("Show more");
            }
        });
    });
</script>
@endsection