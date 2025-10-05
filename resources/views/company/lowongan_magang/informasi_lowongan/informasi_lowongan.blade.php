@extends('partials.vertical_menu')

@section('page_style')
<style>
    .select2-selection__clear{
        display: none;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-9 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Lowongan Magang / </span>Informasi Lowongan - Tahun Ajaran <span id="tahun_akademik_picked"></span></h4>
    </div>
    <div class="col-md-3 col-12 mb-3 float-end d-flex justify-content-end">
        <select class="select2 form-select" data-placeholder="Pilih Tahun Ajaran" id="tahun_akademik_filter">
            {!! tahunAjaranMaker() !!}
        </select>
    </div>
</div>

<div class="mt-2 row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-auto">
                        <div class="border shadow-none card border-secondary">
                            <div class="px-2 py-2 card-body">
                                <div class="gap-2 d-flex justify-content-center align-items-center">
                                    <span class="p-2 badge bg-label-primary me-2">
                                        <i class="ti ti-users" style="font-size: 12pt;"></i>
                                    </span>
                                    <div>
                                        <span class="mb-0 me-2 fw-semibold fs-5">Total Lowongan</span>
                                        <div class="d-flex">
                                            <h5 class="mb-0 me-2 text-primary fs-4" id="set_total_lowongan">0</h5>
                                            <span class="mt-1 mb-0 me-2">Lowongan</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-auto">
                        <div class="border shadow-none card border-secondary">
                            <div class="px-2 py-2 card-body">
                                <div class="gap-2 d-flex justify-content-center align-items-center">
                                    <span class="p-2 badge bg-label-primary me-2">
                                        <i class="ti ti-users" style="font-size: 12pt;"></i>
                                    </span>
                                    <div>
                                        <span class="mb-0 me-2 fw-semibold fs-5">Total Pelamar</span>
                                        <div class="d-flex">
                                            <h5 class="mb-0 me-2 text-primary fs-4" id="set_total_pelamar">0</h5>
                                            <span class="mt-1 mb-0 me-2">Kandidat Melamar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mt-4 row">
                    <div class="table-responsive">
                        <table class="" id="table">
                            <thead><td></td></thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('company/lowongan_magang/informasi_lowongan/modal')
@endsection

@section('page_script')
<script>
    let dataFilter = {};
    let pageState = 1;

    $(document).ready(function () {
        loadState();
        loadData();
    });

    $('#tahun_akademik_filter').on('change', function () {
        loadData();
    });

    function loadState() {
        let currentUrl = new URL(window.location.href);
        let page = currentUrl.searchParams.get("page");
        
        if (page != null) {
            pageState = parseInt(page);
            currentUrl.searchParams.delete("page");
            window.history.replaceState({}, document.title, currentUrl.pathname);
        }
    }

    function loadData(){
        dataFilter['tahun_akademik'] = $('#tahun_akademik_filter').val();
        $('#tahun_akademik_picked').text($(`#tahun_akademik_filter :selected`).text());
        dataFilter['page'] = pageState;

        let table = $('#table').DataTable({
            ajax: function (data, callback, settings) {
                dataFilter['page_length'] = data.length;
                dataFilter['section'] = 'data';

                $.ajax({
                    url: "{{ route('informasi_lowongan.show') }}",
                    type: 'GET',
                    data: dataFilter,
                    success: function (response) {
                        callback({
                            draw: data.draw,
                            recordsTotal: response.pagination.total,
                            recordsFiltered: response.pagination.total,
                            data: response.datatable.original.data
                        });
                    }
                });
            },
            serverSide: true,
            processing: true,
            destroy: true,
            displayStart: (dataFilter['page'] - 1) * 10,
            drawCallback: function ( settings, json ) {
                $('#set_total_lowongan').text(settings.json.recordsTotal);

                let currentPage = settings._iDisplayStart / settings._iDisplayLength + 1;
                $(this).find('.btn-detail').each(function () {
                    let baseUrl = new URL($(this).attr('href'), window.location.origin);
                    baseUrl.searchParams.set('page', currentPage);
                    $(this).attr('href', baseUrl.toString());
                });

                dataFilter['section'] = 'total_pelamar';

                $.ajax({
                    url: "{{ route('informasi_lowongan.show') }}",
                    type: 'GET',
                    data: dataFilter,
                    success: function (res) {
                        $('#set_total_pelamar').text(res);
                    }
                });
            },
            columns: [{data: "data"}],
            language: {
                emptyTable: `<img src="{{ asset('assets/images/lowongan-empty.svg') }}" alt="no-data" style="display: flex; margin-left: auto; margin-right: auto; margin-top: 5%; margin-bottom: 5%;  max-width: 80%;">`,
            },
            ordering: false
        });

        table.on('preXhr.dt', function(e, settings, data) {
            var info = table.page.info();
            
            var currentPage = info.page + 1;
            
            dataFilter['page_length'] = settings._iDisplayLength;
            dataFilter['page'] = currentPage;
            dataFilter['search'] = data.search.value;
        });
    }

    function afterSetConfirmClosing(response) {
        $('#modal-set-batas-confirm').modal('hide');
    }

    function setDateConfirm(e) {
        let modal = $('#modal-set-batas-confirm');
        let url = `{{ route('informasi_lowongan.set_confirm_closing', ['id' => ':id']) }}`.replace(':id', e.attr('data-id'));

        modal.find('form').attr('action', url);
        modal.modal('show');

        $.ajax({
            url: `{{ route('informasi_lowongan') }}`,
            type: `GET`,
            data: {
                section: 'get_data_date',
                data_id: e.attr('data-id')
            },
            success: function (res) {
                modal.find('input[name="date"]').val(res.data);
            }
        });
    }

    $('#modal-set-batas-confirm').on("hide.bs.modal", function() {
        $(this).find('form').attr('action', '#');
    });
</script>
@endsection
