@extends('partials.horizontal_menu')

@section('page_style')
 <style>
    /* .nav-status-lamaran {
        --scrollbar-color-thumb: hotpink;
        --scrollbar-color-track: blue;
        --scrollbar-width: thin;
        --scrollbar-width-legacy: 0.5rem;
    }
    @supports (scrollbar-width: auto) {
        .nav-status-lamaran {
            scrollbar-color: var(--scrollbar-color-thumb) var(--scrollbar-color-track);
            scrollbar-width: var(--scrollbar-width);
        }
    } */
    /* For Desktop View */
    @media screen and (min-width: 1024px) {
        .nav-status-lamaran{
            overflow: none !important;
        }
        .nav{
            flex-wrap: wrap !important;
        }

        .select-filter-status-desktop{
            display: block !important;
        }

        .bg-card{
            background-color: transparent !important;
        }

        .select-filter-status-mobile{
            display: none !important;
        }

        .content-status-lamaran{
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }

        .info-status-lamaran{
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }

        .detail-status-lamaran{
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
        }
    }

    /* For Tablet View */
    @media screen and (min-device-width: 768px) and (max-device-width: 1024px) {

    }

    /* For Mobile Portrait View */
    @media screen and (min-device-width: 380px) and (max-device-width: 768px) {
        .nav-status-lamaran{
            overflow: auto !important;
        }

        .title-status-lamaran{
            display: none !important;
        }

        .nav{
            flex-wrap: nowrap !important;
        }

        .select-filter-status-desktop{
            display: none !important;
        }

        .bg-card{
            background-color: white !important;
            padding: 1rem !important;
            /* margin-left: 0.5rem !important;
            margin-right: 0.5rem !important; */
        }

        .select-filter-status-mobile{
            display: block !important;
        }

        .content-status-lamaran{
            padding-left: 0rem !important;
            padding-right: 0rem !important;
        }

        .detail-status-lamaran{
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
        }

        .info-status-lamaran{
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
        }
    }


 </style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-12 col-12 mt-3 title-status-lamaran">
        <h4 class="fw-bold"><span class="text-muted fw-light">Kegiatan Saya /</span> Status Lamaran Magang</h4>
    </div>

    <div class="row mt-3 content-status-lamaran">
        <div class="d-flex justify-content-between">
            <ul class="nav nav-pills mb-3 nav-status-lamaran pb-3" role="tablist">
                <li class="nav-item">
                    <button type="button" id="fakultas" target="1" class="nav-link active text-nowrap" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-magang-fakultas" aria-controls="navs-pills-justified-magang-fakultas" aria-selected="false">
                        Magang Fakultas
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" target="2" class="nav-link text-nowrap" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-magang-mandiri" aria-controls="navs-pills-justified-magang-mandiri" aria-selected="false">
                        Magang Mandiri
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" target="2" class="nav-link text-nowrap" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-magang-mbkm" aria-controls="navs-pills-justified-magang-mbkm" aria-selected="false">
                        Magang MBKM
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" target="2" class="nav-link text-nowrap" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-magang-kerja" aria-controls="navs-pills-justified-magang-kerja" aria-selected="false">
                        Magang Kerja
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" target="2" class="nav-link text-nowrap" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-magang-startup" aria-controls="navs-pills-justified-magang-startup" aria-selected="false">
                        Magang StartUp
                    </button>
                </li>
            </ul>
            <div class="col-2 select-filter-status-desktop">
                <select class="select2 form-select" name="filter_lowongan" id="filter_lowongan" data-allow-clear="true" data-placeholder="Filter Status Lowongan">
                    <option value="" disabled selected>Filter Status Lowongan</option>
                    <option value="proses_seleksi">Proses Seleksi</option>
                    <option value="penawaran">Penawaran</option>
                    <option value="diterima">Diterima</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
        </div>
        <div class="tab-content bg-card p-0">
            <div class="col-6 select-filter-status-mobile mb-3">
                <select class="form-select" name="filter_lowongan" id="filter_lowongan" data-allow-clear="true" data-placeholder="Filter Status Lowongan">
                    <option value="" disabled selected>Filter Status Lowongan</option>
                    <option value="proses_seleksi">Proses Seleksi</option>
                    <option value="penawaran">Penawaran</option>
                    <option value="diterima">Diterima</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
            <div class="tab-pane fade show active" id="navs-pills-justified-magang-fakultas" role="tabpanel">
                @include('kegiatan_saya.lamaran_saya.components.magang_fakultas')
            </div>
            <div class="tab-pane fade" id="navs-pills-justified-magang-mandiri" role="tabpanel"></div>
            <div class="tab-pane fade" id="navs-pills-justified-magang-mbkm" role="tabpanel"></div>
            <div class="tab-pane fade" id="navs-pills-justified-magang-kerja" role="tabpanel"></div>
            <div class="tab-pane fade" id="navs-pills-justified-magang-startup" role="tabpanel"></div>
        </div>
    </div>
</div>
@include('kegiatan_saya.lamaran_saya.modal')
@endsection

@section('page_script')
<script>
    let dataFilter = {};

    $('#filter_lowongan').on('change', function () {
        loadData();
    });

    function approvalTawaran(event, e) {
        event.stopPropagation();

        let text = 'Ingin menerima lowongan ini?';
        let url = "{{ route('lamaran_saya.approval_penawaran', ['id' => ':id']) }}".replace(':id', e.attr('data-id'))

        if (e.attr('data-status') == 'approved') {
            let modal = $('#modalDiterima');

            modal.find('form').attr('action', url);
            modal.find('form').prepend(`<input type="hidden" name="status" value="approved">`);

            $('#onehundredagree').on('click', function () {
                if ($(this).is(':checked') == true) {
                    modal.find('button[type="submit"]').removeClass('disabled');
                } else {
                    modal.find('button[type="submit"]').addClass('disabled');
                }
            });

            modal.modal('show');
            return;
        } else {
            text = 'Ingin menolak lowongan ini?'
        }

        sweetAlertConfirm({
            title: 'Apakah anda yakin?',
            text: text,
            icon: 'warning',
            confirmButtonText: 'Ya, saya yakin!',
            cancelButtonText: 'Batal'
        }, function () {
            $.ajax({
                url: url,
                type: "POST",
                data: { status: e.attr('data-status') },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (!response.error) {
                        loadData();
                        showSweetAlert({
                            title: 'Berhasil!',
                            text: 'Penawaran berhasil ' + (e.attr('data-status') == 'rejected' ? 'ditolak' : 'diterima') + '!',
                            icon: 'success'
                        });
                    } else {
                        showSweetAlert({
                            title: 'Gagal!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    let res = xhr.responseJSON;
                    showSweetAlert({
                        title: 'Gagal!',
                        text: res.message,
                        icon: 'error'
                    });
                }
            });
        });
    }

    function afterAction(response) {
        let modal = $('#modalDiterima');
        loadData();
        modal.modal('hide');
    }

    function loadData() {
        dataFilter.component = $('#filter_lowongan').val();

        $.ajax({
            url: `{{ route('lamaran_saya') }}`,
            type: 'GET',
            data: dataFilter,
            success: function (response) {
                response = response.data;
                $('#navs-pills-justified-magang-fakultas').html(response.view);
            }
        });
    }

    $('#modalDiterima').on('hide.bs.modal', function () {
        $(this).find('form').find('input[name="status"]').remove();
        $(this).find('form').attr('action', '');
    });
</script>
@endsection