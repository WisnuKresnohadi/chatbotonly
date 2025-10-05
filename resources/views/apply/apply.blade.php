@extends('partials.horizontal_menu')

@section('page_style')

<style>
    .hidden {
        display: none;
    }

    /* For Desktop View */
    @media screen and (min-device-width: 1024px) {
        .container-lamar{
            padding-left: 5%;
            padding-right: 5%;
            padding-bottom: 2%;
            padding-top: 2%;
        }
        .header-mobile{
            display: none !important;
        }

        .lengkapi-profile-mobile{
            display: none !important;
        }
        .deskripsi-mobile{
            display: none !important;
        }
    }

    /* For Tablet View */
    @media screen and (min-device-width: 768px) and (max-device-width: 1024px) {
        .navigasi-desktop{
            display: none !important;
        }
        .title-desktop{
            display: none !important;
        }
        .container-lamar{
            padding-left: 0%;
            padding-right: 0%;
        }
        .lengkapi-profile-desktop{
            display: none !important;
        }
        .deskripsi-desktop{
            display: none !important;
        }
    }

    /* For Mobile Portrait View */
    @media screen and (min-device-width: 300px) and (max-device-width: 768px){
        .navigasi-desktop{
            display: none !important;
        }
        .title-desktop{
            display: none !important;
        }
        .container-lamar{
            padding-left: 0%;
            padding-right: 0%;
        }
        .lengkapi-profile-desktop{
            display: none !important;
        }

        .deskripsi-desktop{
            display: none !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 bg-white container-lamar">
    <div class="header-mobile bg-white" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center; height: 2.5rem; padding-top: 2.5rem; padding-bottom: 3rem;">
        <a href="{{ url()->previous() }}" style="color: #4B465C;" class="btn">
            <i class="ti ti-arrow-left fs-3"></i>
        </a>
        <span class="fw-bold fs-5">
            {{$lowongandetail->bidangPekerjaanIndustri->namabidangpekerjaan}}
        </span>
        <div style="width: 4rem;">
        </div>
    </div>
    <a href="{{ $urlBack }}" class="btn btn-outline-primary mt-4 mb-3 navigasi-desktop">
        <i class="ti ti-arrow-left me-2 text-primary"></i>
        Kembali
    </a>

    <div class="sec-title title-desktop">
        <h4>{{$lowongandetail->bidangPekerjaanIndustri->namabidangpekerjaan}}</h4>
    </div>

    @if($persentase < 80)
    <div class="alert alert-warning alert-dismissible" role="alert">
        <i class="ti ti-alert-triangle ti-xs"></i>
        <span style=" padding-left:10px; padding-top:5px; color:#322F3D;"> Silahkan melakukan pengisian data dengan minimal kelengkapan 80% untuk melanjutkan proses melamar pekerjaan</span>
    </div>
    @endif

    <div id="sudah-daftar-container"></div>

    <div id="daftar-lebih-container"></div>

    <div class="card lengkapi-profile-desktop">
        <div class="card-body">
            <h4>Informasi Data Diri</h4>
            <div class="d-flex justify-content-between mt-4 gap-3">
                <div class="text-center" style="overflow: hidden; width: 100px; height: 100px;">
                @if ($mahasiswa->profile_picture)
                    <img src="{{ asset('storage/' . $mahasiswa->profile_picture) }}" alt="profile-image" class="d-block" width="100" alt="img">
                @else
                    <img src="{{ asset('app-assets/img/avatars/user.png')}}" alt="user-avatar" class="d-block" width="100">
                @endif
                </div>
                <div class="d-flex flex-column">
                    <h6 class="mb-0">Nama Lengkap</h6>
                    <p style="text-wrap: wrap; width: 10rem;">
                        {{$mahasiswa->namamhs}}
                    </p>
                    <h6 class="mb-0">NIM</h6>
                    <p style="text-wrap: wrap; width: 10rem;">{{$mahasiswa->nim}}</p>
                </div>
                <div class="d-flex flex-column">
                    <h6 class="mb-0">Alamat Email</h6>
                    <p style="text-wrap: wrap; width: 10rem;">{{$mahasiswa->emailmhs}}</p>
                    <h6 class="mb-0">No.Telp</h6>
                    <p style="text-wrap: wrap; width: 10rem;">{{$mahasiswa->nohpmhs}}</p>
                </div>
                <div class="d-flex flex-column">
                    <h6 class="mb-0">Program Studi</h6>
                    <p style="text-wrap: wrap; width: 10rem;">{{$mahasiswa->prodi->namaprodi}}</p>
                    <h6 class="mb-0">Fakultas</h6>
                    <p style="text-wrap: wrap; width: 10rem;">{{$mahasiswa->fakultas->namafakultas}}</p>
                </div>
                <div class="d-flex flex-column">
                    <h6 class="mb-0">Universitas</h6>
                    <p style="text-wrap: wrap; width: 10rem;">{{$mahasiswa->univ->namauniv}}</p>
                </div>
                <div class="d-flex flex-column" style="flex: 0 0 auto;width: 20%;">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-1">Kelengkapan</h6>
                        <h6 class="mb-1">{{$persentase}}%</h6>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{$persentase}}%" role="progressbar" aria-valuenow="{{$persentase}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @if(isset($persentase) && $persentase != 100)
                    <a href="{{url('profile?lamaran='.$urlId)}}" class="btn btn-outline-success btn-label-success mt-2" type="button">Lengkapi Profile</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card lengkapi-profile-mobile m-3">
        <div class="card-body">
            <h4>Informasi Data Diri</h4>
            <div class="d-flex flex-column justify-content-between mt-4">
                <div style="width: 100%; margin-bottom: 2rem;">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-2">Kelengkapan</h6>
                        <h6 class="mb-2">{{$persentase}}%</h6>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{$persentase}}%" role="progressbar" aria-valuenow="{{$persentase}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @if(isset($persentase) && $persentase != 100)
                    <a href="{{url('profile?lamaran='.$urlId)}}" class="btn btn-outline-success btn-label-success mt-2 w-100" type="button">Lengkapi Profile</a>
                    @endif
                </div>
                <div class="text-center" style="overflow: hidden; width: 100px; height: 100px;">
                @if ($mahasiswa->profile_picture)
                    <img src="{{ asset('storage/' . $mahasiswa->profile_picture) }}" alt="profile-image" class="d-block" width="100" alt="img">
                @else
                    <img src="{{ asset('app-assets/img/avatars/user.png')}}" alt="user-avatar" class="d-block" width="100">
                @endif
                </div>
                <div class="d-flex flex-column mt-3">
                    <h6 class="mb-0">Nama Lengkap</h6>
                    <p>{{$mahasiswa->namamhs}}</p>
                    <h6 class="mb-0">NIM</h6>
                    <p>{{$mahasiswa->nim}}</p>
                </div>
                <div class="d-flex flex-column">
                    <h6 class="mb-0">Alamat Email</h6>
                    <p>{{$mahasiswa->emailmhs}}</p>
                    <h6 class="mb-0">No.Telp</h6>
                    <p>{{$mahasiswa->nohpmhs}}</p>
                </div>
                <div class="d-flex flex-column">
                    <h6 class="mb-0">Program Studi</h6>
                    <p>{{$mahasiswa->prodi->namaprodi}}</p>
                    <h6 class="mb-0">Fakultas</h6>
                    <p>{{$mahasiswa->fakultas->namafakultas}}</p>
                </div>
                <div class="d-flex flex-column">
                    <h6 class="mb-0">Universitas</h6>
                    <p>{{$mahasiswa->univ->namauniv}}</p>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="card bg-white mt-2 mx-3 px-3 py-3 d-flex flex-column" style="gap: 0.5rem;">
        <span class="fs-4 " style="font-weight: 700;">Portofolio</span>
        <div class="mb-3">
            <label for="formFile" class="form-label">Default file input example</label>
            <input class="form-control" type="file" id="formFile">
            <span class="text-secondary">Allowed PDF, JPG, PNG, JPEG. Max size of 10 GB</span>
        </div>
        <a href="#" class="btn btn-primary waves-effect waves-light" style="width: 100%; margin: auto;">Kirim Lamaran Sekarang</a>
    </div> --}}

    @if($sudahDaftar == false && $daftarDua == false && $sudahMagang == false)
    <div class="card mt-5" id="card-apply">
        <div class="card-body">
            <form class="default-form" action="{{ route('apply_lowongan.apply', ['id' => $lowongandetail->id_lowongan]) }}" function-callback="afterApplyLowongan">
                @csrf
                    <h4>Berkas Persyaratan</h4>
                    <div class="row">
                        @foreach ($dokumenPersyaratan as $key => $item)
                        <div class="mt-2 col-6 form-group">
                            <label for="{{ str_replace(' ', '_', strtolower($item->namadocument)) }}" class="form-label">{{ $item->namadocument }}</label>
                            @if(isset($persentase) && ($sudahDaftar || $persentase < 80))
                                <input class="form-control" type="file" id="{{ str_replace(' ', '_', strtolower($item->namadocument)) }}" name="{{ str_replace(' ', '_', strtolower($item->namadocument)) }}" disabled>
                            @else
                                <input class="form-control" type="file" id="{{ str_replace(' ', '_', strtolower($item->namadocument)) }}" name="{{ str_replace(' ', '_', strtolower($item->namadocument)) }}" accept=".pdf, .jpg, .jpeg, .png">
                            @endif
                            <span class="text-secondary" style="font-size: 9pt;">File harus berformat pdf, jpg, jpeg, png dan ukuran maksimal 2 MB</span>
                            <div class="invalid-feedback"></div>
                        </div>
                        @endforeach
                    </div>
                    <h4 class="mt-4">Mengapa Saya Harus Diterima</h4>
                    <div class="mt-3 form-group">
                        <label for="reasonTextarea" class="form-label">Jelaskan mengapa Anda layak diterima untuk posisi ini</label>
                        <textarea class="form-control" id="reasonTextarea" name="reason" rows="5"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    @if(isset($persentase) && ($sudahDaftar || $persentase < 80))
                        <button type="submit" class="btn btn-secondary waves-effect waves-light mt-3" disabled>Kirim lamaran sekarang</button>
                    @else
                        <button type="submit" class="btn btn-primary waves-effect waves-light mt-3">Kirim lamaran sekarang</button>
                    @endif
            </form>
        </div>
    </div>
    @endif

    <div class="card mt-5 deskripsi-desktop">
        <div class="card-body">
            <div class="border-bottom pb-4">
                <h4>Deskripsi pekerjaan</h4>
                <ul class="ps-2 ms-3 mb-0">
                    @foreach (explode(PHP_EOL, $lowongandetail->deskripsi) as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-4 border-bottom pb-4">
                <h4>Requirements</h4>
                <ul class="ps-2 ms-3 mb-0">
                    @foreach (json_decode($lowongandetail->requirements) as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-4 border-bottom pb-4">
                <h4>Benefit</h4>
                <ul class="ps-2 ms-3 mb-0">
                    @foreach (explode(PHP_EOL, $lowongandetail->benefitmagang) as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-4 border-bottom pb-4">
                <h4>Kemampuan</h4>
                <div class="d-flex justify-content-start">
                    @foreach (json_decode($lowongandetail->keterampilan) as $item)
                    <span class="badge rounded-pill bg-primary mx-1">{{ $item }}</span>
                    @endforeach
                </div>
            </div>
            <div class="mt-4 border-bottom pb-4">
                <h4>Kuota Penerimaan</h4>
                <p>{{ $lowongandetail->kuota_terisi }}/{{ $lowongandetail->kuota }} Kuota Tersedia</p>
            </div>
            <div class="mt-4">
                <h4>Tentang Perusahaan</h4>
                <div class="d-flex justify-content-start">
                    <div class="text-center" style="overflow: hidden; width: 70px; height: 70px;">
                        @if ($lowongandetail->industri->image)
                            <img src="{{ url('storage/' .$lowongandetail->industri->image) }}" alt="profile-image" class="d-block" width="70" alt="img">
                        @else
                            <img src="{{ url('app-assets/img/avatars/14.png')}}" alt="user-avatar" class="d-block" width="70">
                        @endif
                    </div>
                    <h5 class="ms-4 mt-4">{{$lowongandetail->industri->namaindustri}}</h5>
                </div>
                <p>{{ $lowongandetail->industri->description }}</p>
                <div class="mb-3">
                    <a href="#" class="btn btn-outline-primary mt-2">Lihat Perusahaan</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card m-3 deskripsi-mobile">
        <div class="card-body">
            <div class="border-bottom pb-4">
                <h4>Deskripsi pekerjaan</h4>
                <ul class="ps-2 ms-3 mb-0">
                    @foreach (explode(PHP_EOL, $lowongandetail->deskripsi) as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-4 border-bottom pb-4">
                <h4>Requirements</h4>
                <ul class="ps-2 ms-3 mb-0">
                    @foreach (explode(PHP_EOL, $lowongandetail->requirements) as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-4 border-bottom pb-4">
                <h4>Benefit</h4>
                <ul class="ps-2 ms-3 mb-0">
                    @foreach (explode(PHP_EOL, $lowongandetail->benefitmagang) as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-4 border-bottom pb-4">
                <h4>Kemampuan</h4>
                <div class="d-flex justify-content-start">
                    @foreach (json_decode($lowongandetail->keterampilan) as $item)
                    <span class="badge rounded-pill bg-primary mx-1">{{ $item }}</span>
                    @endforeach
                </div>
            </div>
            <div class="mt-4 border-bottom pb-4">
                <h4>Kuota Penerimaan</h4>
                <p>{{ $lowongandetail->kuota_terisi }}/{{ $lowongandetail->kuota }} Kuota Tersedia</p>
            </div>
            <div class="mt-4">
                <h4>Tentang Perusahaan</h4>
                <div class="d-flex justify-content-start">
                    <div class="text-center" style="overflow: hidden; width: 70px; height: 70px;">
                        @if ($lowongandetail->industri->image)
                            <img src="{{ url('storage/' .$lowongandetail->industri->image) }}" alt="profile-image" class="d-block" width="70" alt="img">
                        @else
                            <img src="{{ url('app-assets/img/avatars/14.png')}}" alt="user-avatar" class="d-block" width="70">
                        @endif
                    </div>
                    <h5 class="ms-4 mt-4">{{$lowongandetail->industri->namaindustri}}</h5>
                </div>
                <p>{{ $lowongandetail->industri->description }}</p>
                <div class="mb-3">
                    <a href="#" class="btn btn-outline-primary mt-2">Lihat Perusahaan</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page_script')
<script>
    function changeColor(button) {
        button.classList.toggle('highlight');
    }

    let sudahDaftar = `
        <div class="alert alert-warning alert-dismissible" role="alert">
            <i class="ti ti-alert-triangle ti-xs"></i>
            <span style=" padding-left:10px; padding-top:5px; color:#322F3D;"> Anda sudah mengajukan lamaran untuk pekerjaan ini</span>
        </div>
    `;

    let daftarDua = `
        <div class="alert alert-warning alert-dismissible" role="alert">
            <i class="ti ti-alert-triangle ti-xs"></i>
            <span style=" padding-left:10px; padding-top:5px; color:#322F3D;"> Anda sudah mendaftar pada 2 lowongan</span>
        </div>
    `;

    let sudahMagang = `
        <div class="alert alert-warning alert-dismissible" role="alert">
            <i class="ti ti-alert-triangle ti-xs"></i>
            <span style=" padding-left:10px; padding-top:5px; color:#322F3D;"> Anda sedang menjalani program magang saat ini.</span>
        </div>
    `;

    @if($sudahDaftar == true)
        document.getElementById("sudah-daftar-container").innerHTML = sudahDaftar;
    @endif

    @if($daftarDua == true)
        document.getElementById("daftar-lebih-container").innerHTML = daftarDua;
    @endif

    @if($sudahMagang == true)
        document.getElementById("daftar-lebih-container").innerHTML = sudahMagang;
    @endif

    //  Button Back
    document.getElementById("back").addEventListener("click", () => {
        history.back();
    });

    function afterApplyLowongan(){
        $('#card-apply').remove();
        $('#sudah-daftar-container').html(sudahDaftar);
    }
</script>
<script src="{{ asset('app-assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('app-assets/js/extended-ui-sweetalert2.js') }}"></script>
@endsection
