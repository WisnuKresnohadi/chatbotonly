@extends('partials.horizontal_menu')

@section('page_style')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
    <style>
        .hidden {
            display: none;
        }

        .input-group> :not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
            /* width: 100% !important; */
            height: 48px !important;
            border: none;
            border-radius: 5px;
        }

        .input-group:not(.has-validation)> :not(:last-child):not(.dropdown-toggle):not(.dropdown-menu):not(.form-floating),
        .input-group:not(.has-validation)>.dropdown-toggle:nth-last-child(n+3),
        .input-group:not(.has-validation)>.form-floating:not(:last-child)>.form-control,
        .input-group:not(.has-validation)>.form-floating:not(:last-child)>.form-select {
            border: 0;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .dropdown.bootstrap-select {
            max-width: 170px;
            max-height: 45px;
        }

        .bootstrap-select .dropdown-toggle:after {
            right: 5px !important;
            top: 50% !important;
        }

        .light-style .bootstrap-select .dropdown-toggle {
            padding-left: 0%;
        }

        .light-style .select2-container--default .select2-selection--single {
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            background-color: #fff;
            border: none;
            border-radius: 0.375rem;
        }

        .select2-container {
            padding: 0.35rem 0rem;
            margin: 0;
            width: 100% !important;
            display: inline-block;
            position: relative;
            vertical-align: middle;
            box-sizing: border-box;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            position: absolute;
            height: 18px;
            width: 20px;
            top: 40%;
            right: 0%;
            background-repeat: no-repeat;
            background-size: 20px 18px;
        }

        .position-relative {
            position: relative !important;
            width: 90% !important;
        }

        .bootstrap-select.dropup .dropdown-toggle:after {
            transform: rotate(-45deg) translateY(-50%);
            height: 0.5em;
            width: 0.5em;
            right: 0px !important;
            top: 60% !important;
        }

        .input-group:focus-within {
            box-shadow: none;
        }

        /* For Desktop View */
        @media screen and (min-device-width: 1024px) {
            .header-daftar-perusahaan {
                background-color: #F8F8F8;
                background-repeat: no-repeat;
                background-size: cover;
                background-image: url({{ asset('assets/images/background.png') }});
            }

            .utilities-head {
                margin-top: 0.5rem;
                margin-bottom: 0.5rem;
                margin-left: 0.5rem;
                margin-right: 0.5rem;
                /* mt-5 mb-5 mx-5 */
            }

            .cards {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 1rem;
            }

            .title-daftar-mitra {
                display: static;
            }

            .search-perusahaan-mobile {
                display: none;
            }
        }

        /* For Tablet View */
        @media screen and (min-device-width: 768px) and (max-device-width: 1023px) {
            .header-daftar-perusahaan {
                background-color: #F8F8F8;
            }

            .lokasi-perusahaan {
                display: none;
            }

            .cari-perusahaan {
                display: none;
            }

            .nama_perusahaan {
                width: 100%;
            }

            .search-perusahaan-mobile {
                /* width: 28rem; */
            }

            .search-perusahaan {
                display: none;
            }

            .utilities-head {
                margin-left: 0.5rem;
                margin-right: 0.5rem;
                margin-top: auto;
                margin-bottom: auto;
            }

            .cards {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .title-daftar-mitra {
                display: none;
            }

            .daftar-mitra-content {
                margin-bottom: 4rem;
            }
        }

        /* For Mobile Portrait View */
        @media screen and (min-device-width: 300px) and (max-device-width: 768px) {
            .header-daftar-perusahaan {
                background-color: #F8F8F8;
                background-repeat: no-repeat;
                height: 15%;
                width: 100%;
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: center;
                background-size: cover;
                background-position: right;
                background-image: url({{ asset('assets/images/element-1-1.png') }});
            }

            .lokasi-perusahaan {
                display: none;
            }

            .cari-perusahaan {
                display: none;
            }

            .nama_perusahaan {
                width: 100%;
            }

            .search-perusahaan-mobile {
                display: flex;
                /* width: 28rem; */
            }

            .search-perusahaan {
                display: none;
            }

            .utilities-head {
                margin-left: 0.5rem;
                margin-right: 0.5rem;
                margin-top: auto;
                margin-bottom: auto;
            }

            .cards {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .title-daftar-mitra {
                display: none;
            }

            .daftar-mitra-content {
                margin-bottom: 4rem;
            }
        }

        /* For Mobile Landscape View */
        /* @media screen and (max-device-width: 640px) and (orientation: landscape) {
                    .header-daftar-perusahaan {
                        background-color: #F8F8F8;
                    }
                    } */

        /* For Medium Mobile View */
        /* @media screen and (min-device-width: 640px) and (max-device-width: 768px){
                    .header-daftar-perusahaan {
                        background-color: #F8F8F8;
                        background-repeat: no-repeat;
                        height: 15%;
                        width: 100%;
                        display:flex;
                        flex-direction:row;
                        align-items: center;
                        justify-content: center;
                        background-size: cover;
                        background-position: right;
                        background-image: url({{ asset('assets/images/element-1-1.png') }});
                    }
                    .lokasi-perusahaan{
                        display: none;
                    }

                    .cari-perusahaan{
                        display: none;
                    }

                    .nama_perusahaan{
                        width: 100%;
                    }

                    .search-perusahaan{
                        width: 28rem;
                    }

                    .utilities-head{
                        margin-left: 0.5rem;
                        margin-right: 0.5rem;
                        margin-top: auto;
                        margin-bottom: auto;
                    }

                    .cards{
                        display: flex;
                        flex-direction: column;
                        gap: 1rem;
                    }

                    .title-daftar-mitra{
                        display: none;
                    }

                    .daftar-mitra-content{
                        margin-bottom: 4rem;
                    }
                    } */
    </style>
@endsection

@section('content')
    <div class="auto-container container-p-y header-daftar-perusahaan" style="">
        <div class="d-flex justify-content-center utilities-head">
            <div class="col-lg-5 search-perusahaan-mobile">
                <div class="border input-group input-group-merge">
                    <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                    <input type="text" id="nama_perusahaan_mobile" class="form-control" placeholder="Nama Perusahaan"
                        oninput="setPerusahaan($(this))" onkeydown="if(event.key === 'Enter') filter();">
                    <button class="btn filter-perusahaan" style="background-color: white;" onclick="filter()">
                        <i class="ti ti-filter"></i>
                    </button>
                </div>

            </div>
            <div class="col-lg-5 search-perusahaan">
                <div class="border input-group input-group-merge">
                    <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                    <input type="text" id="nama_perusahaan" class="form-control" placeholder="Nama Perusahaan"
                        oninput="setPerusahaan($(this))" onkeydown="if(event.key === 'Enter') filter();">
                </div>
            </div>
            <div class="mx-2 col-5 lokasi-perusahaan">
                <div class="bg-white border input-group input-group-merge">
                    <span class="input-group-text"><i class="ti ti-calendar-time"></i></span>
                    {{-- <div class="position-relative">
                    <select name="location" id="location" class="form-select" data-placeholder="Lokasi Perusahaan" onkeydown="if(event.key === 'Enter') filter();">
                        <option value disabled selected> Lokasi Perusahaan </option>
                        @foreach ($regencies as $item)
                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div> --}}

                    <input type="text" id="location" class="form-control" placeholder="Lokasi Perusahaan"
                        onkeydown="if(event.key === 'Enter') filter();">
                </div>
            </div>
            <div class="col-auto cari-perusahaan">
                <button class="btn btn-primary" id="search" type="button" style="height: 50px;" onclick="filter()">Cari
                    sekarang</button>
            </div>
        </div>
    </div>
    <div class="container-xxl flex-grow-1 container-p-y daftar-mitra-content">
        @if (count($industries) != 0)
            <h4 class="mt-2 mb-4 ms-2 title-daftar-mitra">Daftar Mitra</h4>
            <div id="container-industri" class="cards">
                @include('perusahaan/components/card_perusahaan')
            </div>
            <nav aria-label="Page navigation">
                <ul class="mt-4 mb-5 pagination justify-content-end" id="container-pagination">
                    @include('perusahaan/components/pagination')
                </ul>
            </nav>
        @else
            <img src="\assets\images\nothing.svg" alt="no-data"
                style="display: flex; margin-left:
        auto; margin-right: auto; margin-top: 5%; margin-bottom: 5%;  width: 25%;">
            <div class="mt-5 mb-4 text-center sec-title">
                <h4>Belum ada mitra yang terdaftar</h4>
            </div>
        @endif
    </div>
@endsection

@section('page_script')
    <script>
        $(document).ready(function() {
            // $('#location').select2({
            //     allowClear: true,
            //     placeholder: $('#location').attr('data-placeholder'),
            //     dropdownAutoWidth: true,
            //     width: '100%',
            //     dropdownParent: $('#location').parent(),
            // });

            $(window).on('resize', function() {
                if(window.matchMedia("(min-device-width: 300px) and (max-device-width: 768px)").matches) {
                    $('#location').val('');
                }
            });
        });

        let dataFilter = {};

        function setPerusahaan(e) {
            if (e.attr('id') == 'nama_perusahaan_mobile') {
                $('#nama_perusahaan').val(e.val())
                return
            }

            $('#nama_perusahaan_mobile').val(e.val())
        }

        function pagination(e) {
            url = e.attr('data-url');
            if (url == '') return;
            dataFilter.page = url.split('page=')[1];

            $('.page-item').removeClass('active');
            e.addClass('active');

            loadData();
        }

        function filter() {
            let name = $('#nama_perusahaan').val();
            let location = $('#location').val();
            dataFilter.name = name;
            dataFilter.location = location;
            loadData();
        }

        function loadData() {
            let url = `{{ route('daftar_perusahaan') }}`;

            $.ajax({
                url: url,
                type: "GET",
                data: dataFilter,
                success: function(response) {
                    $('#container-industri').html(response.data.view);
                    $('#container-pagination').html(response.data.pagination);
                }
            });
        }
    </script>
@endsection
