@extends('partials_admin.template')

@section('page_style')
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<style>
    .tooltip-inner {
        min-width: 100%;
        max-width: 100%;
    }

    .position-relative {
        padding-right: 15px;
        padding-left: 15px;
    }

    h6,
    .h6 {
        font-size: 0.9375rem;
        margin-bottom: 0px;
    }

    #more {
        display: none;
    }
</style>
@endsection

@section('main')
<div class="row">
    <div class="col-md-9 col-12">
        <button class="btn btn-outline-success my-2 waves-effect p-3 mb-4" type="button" id="back" style="width: 15%; height:12%;">
            <i class="bi bi-arrow-left text-success" style="font-size: medium;"> Kembali </i>
        </button>
        <h4 class="fw-bold"><span class="text-muted fw-light">Informasi Mitra / Informasi Lowongan / Informasi Kandidat / </span>Detail Mahasiswa </h4>
    </div>
    <div class="card">
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
                        <img src="{{$img ?? '\assets\images\no-pictures.png'}}" style="border-radius: 0%; width: 90px;" alt="user image" class="d-block ms-0 mt-4  rounded user-profile-img" />
                    </div>
                    <div class="flex-grow-1 mt-0 mt-4">
                        <div class="d-flex align-items-end align-items-sm-start ms-3 flex-md-row flex-column gap-4">
                            <div class="me-2 ms-1">
                                <h1 class="mb-2">{{$pendaftar->mahasiswa->namamhs}}</h1>
                                <p class="text" style="font-size: 20px">{{$pendaftar->lowongan_magang->intern_position }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4> Mengapa Saya Harus Di Terima?</h4>
            <p class="mb-0 text-justify">
                <span id="headline" class="headliner">{{ \Illuminate\Support\Str::limit($pendaftar->reason_aplicant ?? '-', 100) }}</span>

                <u class="show-btn link-success cursor-pointer" data-deskripsi="{{$pendaftar->reason_aplicant ?? '-'}}">Show More</u>
            </p>
            <hr>

            <!-- Informasi Pribadi -->
            <h4>Informasi Pribadi</h4>
            <div class="row">
                <h5 class="mt-3"> Deskripsi Diri</h5>
                <div>
                    <p class="mb-0 text-justify">
                        <span id="desk" class="deskriipsi_diri">{{ \Illuminate\Support\Str::limit($prib->deskripsi_diri ?? '-', 100) }}</span>

                        <u class="show-btn link-success cursor-pointer" data-deskripsi="{{$prib->deskripsi_diri ?? '-'}}">Show More</u>
                    </p>
                </div>
                <div class="col-4 mt-3">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <span class="fw-semibold me-1">NIM:</span>
                            <span>{{$pendaftar->mahasiswa->nim}}</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Universitas:</span>
                            <span>{{$pendaftar->mahasiswa->univ->namauniv}}</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Fakultas:</span>
                            <span>{{$pendaftar->mahasiswa->fakultas->namafakultas}}</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Program Studi:</span>
                            <span>{{$pendaftar->mahasiswa->prodi->namaprodi}}</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Angkatan:</span>
                            <span>{{$pendaftar->mahasiswa->angkatan}}</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">IPK:</span>
                            <span>{{$prib->ipk ?? '-'}}</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Tes Bahasa:</span>
                            <span>{{ $prib->tesbahasa ? ($prib->tipetesbahasa . ' - ' . $prib->tesbahasa) : '-' }}</span>                            
                        </li>
                    </ul>
                </div>
                <div class="col-4 mt-3">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <span class="fw-semibold me-1">TAK:</span>
                            <span>{{$prib->TAK ?? '-'}}</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Email:</span>
                            <a class="cursor-pointer link-primary link-offset-2" href="mailto:{{$pendaftar->mahasiswa->emailmhs}}" target="_blank">{{$pendaftar->mahasiswa->emailmhs}}</a>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">No Telp:</span>
                            <span>{{$pendaftar->mahasiswa->nohpmhs}}</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Tanggal Lahir:</span>
                            <span>
                                {{ is_string($prib->tgl_lahir ?? '')
                                ? \Carbon\Carbon::parse($prib->tgl_lahir ?? '')->format('d F Y')  
                                : $prib->tgl_lahir?->format('d F Y')  
                                }}
                            </span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Jenis Kelamin:</span>
                            <span>{{$prib->gender ?? '-'}}</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-1">Alamat:</span>
                            <span>{{$pendaftar->mahasiswa->alamatmhs}}</span>
                        </li>
                    </ul>
                </div>
                <div class="col-4"></div>
            </div>
            <hr>

            <!-- Pendidikan / Education -->
            <h4>Pendidikan</h4>
            <div class="card-body">
                <ul class="timeline ms-1 mb-0 mt-3">
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-success"></span>
                        <div>
                            <h5 class="mb-2">{{$education->name_intitutions ?? '-'}}</h5>
                            <p class="mb-2">{{$education->tingkat ?? '-'}}</p>
                            <p class="mb-2">Nilai : {{$education->nilai ?? '-'}}</p>
                            <small>{{ is_string($education->startdate ?? '')
                                ? \Carbon\Carbon::parse($education->startdate ?? '')->format('d F Y')  
                                : $education->startdate?->format('d F Y')  
                                }} - {{ is_string($education->enddate ?? '')
                                ? \Carbon\Carbon::parse($education->enddate ?? '')->format('d F Y')  
                                : $education->enddate?->format('d F Y')  
                                }}</small>
                            <div class="border-bottom mt-4"></div>
                        </div>
                    </li>
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-success"></span>
                    </li>
                </ul>
            </div>
            <hr>

            <!-- Pengalaman / Experience -->
            <h4>Pengalaman</h4>
            <div class="card-body ">
                <ul class="timeline ms-1 mb-0 mt-3">
                    @foreach($experience as $data)
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                            <h5 class="mb-2">{{$data->posisi}}</h5>
                            <p class="mb-2">{{$data->name_intitutions}} - {{$data->jenis}}</p>
                            <p style="font-size: small;">{{ is_string($data->startdate)
                                ? \Carbon\Carbon::parse($data->startdate)->format('d F Y')  
                                : $data->startdate?->format('d F Y')
                                }} - {{ is_string($data->enddate)
                                ? \Carbon\Carbon::parse($data->enddate)->format('d F Y')  
                                : $data->enddate?->format('d F Y')
                                }}</p>
                            <p class="mb-0 text-justify">
                                <span id="experience" class="pengalaman">{{ \Illuminate\Support\Str::limit($data->deskripsi, 100) }}</span>

                                <u class="show-btn link-success cursor-pointer" data-deskripsi="{{$data->deskripsi}}">Show More</u>
                            </p>
                            <div class="border-bottom mt-4"></div>
                        </div>
                    </li>
                    @endforeach
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-success"></span>
                    </li>
                </ul>
            </div>
            <hr>

            <!-- Skill / Keahlian -->
            <h4>Keahlian</h4>
            <div class="d-flex mt-3" style="column-gap: 10px; padding-bottom: 10px  !important">
                @foreach($skills as $item)
                @if($item->skills == null)
                <span></span>
                @else
                <span class="badge rounded-pill bg-success bg-glow">{{ $item->skills }}</span>
                @endif
                @endforeach
            </div>
            <hr>

            <!-- Dokumen Pendukung -->
            <h4>Dokumen Pendukung</h4>
            @foreach($sertif as $doc)
            <h5 class="mb-2 bold">{{$doc->nama_sertif}}</h5>
            <p class="mb-2">{{$doc->penerbit}}</p>
            <p class="mb-2">{{ is_string($doc->startdate)
                                ? \Carbon\Carbon::parse($doc->startdate)->format('d F Y')  
                                : $doc->startdate?->format('d F Y')
                                }} - {{ is_string($doc->enddate)
                                ? \Carbon\Carbon::parse($doc->enddate)->format('d F Y')  
                                : $doc->enddate?->format('d F Y')
                                }}</p>
            <p class="mb-0 text-justify">
                <span id="experience" class="pengalaman">{{ \Illuminate\Support\Str::limit($doc->deskripsi, 100) }}</span>

                <u class="show-btn link-success cursor-pointer" data-deskripsi="{{$doc->deskripsi}}">Show More</u>
            </p>
            <br>
            @if($doc->link_sertif == null)
            <a class="cursor-pointer link-primary link-offset-2"></a>
            @else
            <a class="cursor-pointer link-primary link-offset-2" href="{{$doc->link_sertif}}" target="_blank">Lihat Dokumen</a>
            @endif
            @endforeach

            <div class="border-bottom mt-4"></div>

            <!-- Informasi Tambahan -->
            <h4 class="mt-3">Informasi Tambahan</h4>
            <div class="row">
                <div class="col-6">
                    <ul class="list-unstyled">
                        @foreach($infoTambah as $item)
                        @if($item->sosmed == null && $item->url_sosmed == null)
                        <span class="fw-semibold me-1" style="font-size: 18px"></span>
                        @else
                        <li class="mb-3">
                            <span class="fw-semibold me-1" style="font-size: 18px">{{$item->sosmed}}:</span>
                            <a class="cursor-pointer link-primary link-offset-2" style="font-size: 18px;" href="{{$item->url_sosmed}}" target="_blank">
                                {{$item->url_sosmed}}
                            </a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
                <div class="col-4">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <span class="fw-semibold me-1" style="font-size: 18px">Lokasi kerja yang di harapkan:</span>
                            @foreach($infoTambah as $item)
                            @if($item->lok_kerja == null)
                            <span class="fw-semibold me-1" style="font-size: 18px"></span>
                            @else
                            <span style="font-size: 17px;">{{$item->lok_kerja}}</span>
                            @endif
                            @endforeach
                        </li>
                </div>
            </div>
            <span class="fw-semibold me-1" style="font-size: 18px">Bahasa</span>
            <div class="d-flex mt-3" style="column-gap: 10px; padding-bottom: 10px  !important">
                @foreach($infoTambah as $item)
                @if($item->bahasa == null)
                <span class="fw-semibold me-1" style="font-size: 18px"></span>
                @else
                <span class="badge rounded-pill bg-success bg-glow">{{ $item->bahasa->bahasa}} </span>
                @endif
                @endforeach
            </div>
        </div>

    </div>
    @endsection

    @section('page_script')
    <script src="{{asset('app-assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
    <script src="{{asset('app-assets/js/forms-extras.js')}}"></script>

    <script>
        jQuery(function() {
            jQuery('.showSingle').click(function() {
                jQuery('.targetDiv').hide('.cnt');
                jQuery('#div' + $(this).attr('target')).slideToggle();
            });
        });

        function myFunction() {
            var dots = document.getElementById("dots");
            var moreText = document.getElementById("more");
            var btnText = document.getElementById("myBtn");

            if (dots.style.display === "none") {
                dots.style.display = "inline";
                btnText.innerHTML = "Show more";
                moreText.style.display = "none";
            } else {
                dots.style.display = "none";
                btnText.innerHTML = "Show less";
                moreText.style.display = "inline";
            }
        }

        $(document).ready(function() {
            $(".content-new").hide();
            $(".show_hide_new").on("click", function() {
                var content = $(this).prev('.content-new');
                content.slideToggle(100);
                if ($(this).text().trim() == "Show more") {
                    $(this).text("Show less");
                } else {
                    $(this).text("Show more");
                }
            });
        });

        const buttons = document.querySelectorAll('.show-btn');

        buttons.forEach(button => {
            button.addEventListener('click', showMore);
        });

        function showMore() {
            var content = this.previousElementSibling;
            var isShowMore = this.innerText === "Show More";
            var deskripsi = $(this).attr("data-deskripsi");

            var lessContent = deskripsi.substring(0, 100) + "...";
            // console.log(deskripsi);

            if (isShowMore) {
                content.innerHTML = deskripsi;
                this.innerText = "Show Less";
            } else {
                content.innerHTML = lessContent;
                this.innerText = "Show More";
            }
        }

        document.getElementById("back").addEventListener("click", () => {
            history.back();
        });
    </script>
    <script src="{{ asset('app-assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
    <script src="{{ asset('app-assets/js/extended-ui-sweetalert2.js')}}"></script>
    @endsection