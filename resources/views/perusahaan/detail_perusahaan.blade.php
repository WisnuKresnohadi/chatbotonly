@extends('partials.horizontal_menu')

@section('page_style')
@include('perusahaan/style/hover')
<style>
    /* For Desktop View */
    @media screen and (min-device-width: 1024px) {
        .card-mobile{
            display: none !important;
        }
        .header-mobile{
            display: none !important;
        }

        .profile-mitra-mobile{
            display: none !important;
        }

        .about-mobile{
            display: none !important;
       }
       .lowongan-filter-mobile{
        display: none !important;
       }

       #container-lowongan-mobile{
        display: none !important;
       }

       .card-lowongan-lainnya-mobile{
            display: none !important;
        }
    }

    /* For Tablet View */
    @media screen and (min-device-width: 768px) and (max-device-width: 1024px) {
       .back-navigasi{
         display: none !important;
       }
       .title-desktop{
         display: none !important;
       }
       .profile-mitra-desktop{
        display: none !important;
       }
       .about-desktop{
            display: none !important;
       }
       .lowongan-filter-desktop{
        display: none !important;
       }

       #container-lowongan-desktop{
        display: none !important; 
       }

       .card-lowongan-lainnya-desktop{
            display: none !important;
        }
    }

    /* For Mobile Portrait View */
    @media screen and (min-device-width: 300px) and (max-device-width: 768px){
        .back-navigasi{
            display: none !important;
        }
        .title-desktop{
            display: none !important;
       }

       .profile-mitra-desktop{
            display: none !important;
       }

       .about-desktop{
            display: none !important;
       }

       .lowongan-filter-desktop{
        display: none !important;
       }

       #container-lowongan-desktop{
        display: none !important;
       }

       .card-lowongan-lainnya-desktop{
            display: none !important;
        }

    }
</style>
@endsection


@section('content')
<div class="header-mobile bg-white" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center; height: 2.5rem; padding-top: 2.5rem; padding-bottom: 3rem;">
    <a href="{{ url()->previous() }}" style="color: #4B465C;" class="btn">
        <i class="ti ti-arrow-left fs-3"></i>
    </a>
    <span class="fw-bold fs-5">
        Detail Mitra
    </span>
    <div style="width: 5rem;">
    </div>
</div>
<div class="container-xxl flex-grow-1 container-p-y">
    <a href="{{ $urlBack }}" class="btn btn-outline-primary mt-5 mb-3 text-primary back-navigasi">
        <span class="ti ti-arrow-left me-2"></span>Kembali
    </a>
    <div class="col-md-10 col-12 title-desktop">
        <h4 class="fw-bold"> <span class="text-muted fw-light text-xs">Daftar Mitra / </span> Detail Mitra </h4>
    </div>

    <div class="card mb-5 profile-mitra-desktop">
        <div class="card-body"> 
            <div class="d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <div class="text-center" style="overflow: hidden; width: 100px; height: 100px;">
                        @if ($detail->image)
                        <img src="{{ asset('storage/'. $detail->image) }}" alt="user-avatar" class="d-block" width="100">
                        @else
                        <img src="{{ asset('app-assets/img/avatars/building.png') }}" alt="user-avatar" class="d-block" width="100">
                        @endif
                    </div>
                    <div class="d-flex flex-column justify-content-center ms-3">
                        <h4 class="mb-1">{{ $detail->namaindustri }}</h4>
                        <span>{{ $detail->kategori_industri }}</span>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-4">
                    <h6 class="mb-0">Alamat Perusahaan</h6>
                    <p>{{$detail->alamatindustri ?? '-'}}</p>
                </div>
                <div class="col-4">
                    <h6 class="mb-0">Email</h6>
                    <p>{{$detail->email ?? '-'}}</p>
                </div>
                <div class="col-4">
                    <h6 class="mb-0">Phone</h6>
                    <p>+{{$detail->notelpon ?? '-'}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3 profile-mitra-mobile">
        <div class="card-body"> 
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-column justify-content-start mb-3">
                    <div class="text-center" style="overflow: hidden; width: 100px; height: 100px;">
                        @if ($detail->image)
                        <img src="{{ asset('storage/'. $detail->image) }}" alt="user-avatar" class="d-block" width="100">
                        @else
                        <img src="{{ asset('app-assets/img/avatars/building.png') }}" alt="user-avatar" class="d-block" width="100">
                        @endif
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <h4 class="mb-1">{{ $detail->namaindustri }}</h4>
                        <span>{{ $detail->kategori_industri }}</span>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column">
                <div class="col">
                    <h6 class="mb-0">Alamat Perusahaan</h6>
                    <p>{{$detail->alamatindustri ?? '-'}}</p>
                </div>
                <div class="col">
                    <h6 class="mb-0">Email</h6>
                    <p>{{$detail->email ?? '-'}}</p>
                </div>
                <div class="col">
                    <h6 class="mb-0">Phone</h6>
                    <p>+{{$detail->notelpon ?? '-'}}</p>
                </div>
                {{-- <div class="">
                    <button type="button" class="btn btn-outline-dark waves-effect w-100" onclick="changeColor(this)" data-bs-toggle="modal" data-bs-target="#modalbagikan" data-bs-placement="bottom" data-bs-original-title="Bagikan">
                        <i class="ti ti-share me-1"></i>Bagikan
                    </button>
                </div> --}}
            </div>
        </div>
    </div>

    <div class="card mb-5 about-desktop">
        <div class="card-body">
            <div class="border-bottom mt-1">
                <h4> Tentang Perusahaan</h4>
            </div>
            <p class="mt-3">{!! ($detail->description) ? nl2br($detail->description) : '-' !!}</p>
        </div>
    </div>

    <div class="card mb-3 about-mobile">
        <div class="card-body">
            <div class="">
                <h4> Tentang Perusahaan</h4>
            </div>
            <p class="mt-3">{!! ($detail->description) ? nl2br($detail->description) : '-' !!}</p>
        </div>
    </div>

    <div class="card lowongan-lainnya-desktop" style="background-color: #f8f7fa; overflow: hidden;">
        <div class="card-header p-3 lowongan-filter-desktop" style="background-color: #23314B;">
            <div class="row">
                <div class="col-6 my-auto">
                    <h4 class="ps-2 mb-0" style="color: #FFFFFF;">Lowongan Tersedia di Perusahaan</h4>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-9 my-auto">
                            <div class="input-group input-group-merge ">
                                <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                <input type="text" id="name_lowongan" class="form-control" placeholder="Lowongan Pekerjaan">
                            </div>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-primary waves-effect waves-light" onclick="filter();" style="height: 47px;">Cari Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body mt-3" id="container-lowongan-desktop"></div>
    </div>

    <div class="card lowongan-lainnya-mobile" style="background-color: #fff; overflow: hidden;">
        <div class="card-header p-3 lowongan-filter-mobile" style="background-color: #23314B;">
            <div class="d-flex flex-column">
                <div class="col my-auto">
                    <h4 class="mb-0 pb-2" style="color: #FFFFFF; font-size: 1rem;">Lowongan Tersedia di Perusahaan</h4>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col my-auto">
                            <div class="input-group input-group-merge ">
                                <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                <input type="text" id="name_lowongan" class="form-control" placeholder="Lowongan Pekerjaan">
                                <button class="btn bg-white">
                                    <i class="ti ti-filter"></i>
                                </button>
                            </div>
                        </div>
                        {{-- <div class="col-3">
                            <button type="button" class="btn btn-primary waves-effect waves-light" onclick="filter();" style="height: 47px;">Cari Sekarang</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body mt-3" id="container-lowongan-mobile"></div>
    </div>

    

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end mb-0 mt-3" id="container-pagination">
            @include('perusahaan/components/pagination')
        </ul>
    </nav>
    @include('perusahaan/components/modal_detail')
</div>

@endsection

@section('page_script')
<script>
    $(document).ready(function () {
        dataFilter.page = 1;
        loadData();
    });

    let dataFilter = {};
    function pagination(e) {
        url = e.attr('data-url');
        if (url == '') return;
        dataFilter.page = url.split('page=')[1];

        $('.page-item').removeClass('active');
        e.addClass('active');

        loadData();
    }

    function filter() {
        let name = $('#name_lowongan').val(); 
        dataFilter.name = name;
        loadData();
    }

    $('#name_lowongan').on('keyup', function () {
        let $this = $(this).val();
        if ($this == '') {
            dataFilter.page = 1;
            dataFilter.name = '';
            loadData();
        }
    });

    function loadData() {
        let url = `{{ route('daftar_perusahaan.detail' , ['id' => $detail->id_industri]) }}`;

        $.ajax({
            url: url,
            type: "GET",
            data: dataFilter,
            success: function(response) {
                $('#container-lowongan-desktop').html(response.data.view);
                $('#container-lowongan-mobile').html(response.data.view);
                $('#container-pagination').html(response.data.pagination);
            }
        });
    }
</script>
@endsection