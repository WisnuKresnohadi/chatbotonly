@extends('partials.vertical_menu')

@section('page_style')
    <style>
        .select2-selection__clear {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <h4 class="fw-bold">Kelola Lowongan - Tahun Ajaran <span id="tahun_ajar"></span></h4>
            <div class="d-flex justify-content-end align-items-center">
                <div class="position-relative" style="width: 13rem;">
                    <select class="select2 form-select" data-placeholder="Pilih Tahun Ajaran" id="tahun_akademik_filter">
                        {!! tahunAjaranMaker() !!}
                    </select>
                </div>
                <button class="btn btn-icon btn-primary ms-2" data-bs-toggle="offcanvas" data-bs-target="#modalSlide">
                    <i class="tf-icons ti ti-filter"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="mt-4 row">
        <div class="nav-align-top">
            <ul class="mb-3 nav nav-pills " role="tablist">
                <li class="nav-item" style="font-size: small;">
                    <button type="button" class="nav-link active" target="1" role="tab"
                        data-bs-toggle="tab" data-bs-target="#navs-pills-justified-total"
                        aria-controls="navs-pills-justified-total" aria-selected="true" style="padding: 8px 9px;">
                        <i class="tf-icons ti ti-briefcase ti-xs me-1"></i> Total Lowongan
                    </button>
                </li>
                <li class="nav-item" style="font-size: small;">
                    <button type="button" class="nav-link" target="2" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-justified-tertunda" aria-controls="navs-pills-justified-tertunda"
                        aria-selected="false" style="padding: 8px 9px;">
                        <i class="tf-icons ti ti-clock ti-xs me-1"></i> Menunggu Persetujuan
                        </button>
                </li>
                <li class="nav-item" style="font-size: small;">
                    <button type="button" class="nav-link" target="3" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-justified-diterima" aria-controls="navs-pills-justified-diterima"
                        aria-selected="false" style="padding: 8px 9px;">
                        <i class="tf-icons ti ti-clipboard-check ti-xs me-1"></i> Lowongan Diterima
                        </button>
                </li>
                <li class="nav-item" style="font-size: small;">
                    <button type="button" class="nav-link" target="4" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-justified-ditolak" aria-controls="navs-pills-justified-ditolak"
                        aria-selected="false" style="padding: 8px 9px;">
                        <i class="tf-icons ti ti-clipboard-x ti-xs me-1"></i> Lowongan Ditolak
                        </button>
                </li>
            </ul>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <div class="my-auto col">
            <div class="text-secondary">
                Filter Berdasarkan :
                <i class='pb-1 tf-icons ti ti-alert-circle text-primary' data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Durasi Magang : -, Posisi Lowongan Magang : -, Status Lowongan Magang : -" id="tooltip-filter"></i>
            </div>
        </div>
        <div class="col text-end">
            <a href="{{ route('kelola_lowongan.create') }}" class="btn btn-primary">Tambah Lowongan Magang</a>
        </div>
    </div>

    <div class="p-0 tab-content">
        @foreach (['total', 'tertunda', 'diterima', 'ditolak'] as $key => $item)
        <div class="tab-pane fade show {{ $key == 0 ? 'active' : '' }}" id="navs-pills-justified-{{ $item }}" role="tabpanel">
            <div class="mt-4 card">
                <div class="m-2 mt-3 row">
                    <div class="col-auto">
                        <div class="border shadow-none card border-secondary">
                            <div class="p-2 card-body">
                                @switch($item)
                                    @case('total')
                                        <div class="d-flex justify-content-center align-items-center">
                                            <span class="p-2 badge bg-label-success me-2">
                                                <i class="ti ti-briefcase" style="font-size: 12pt;"></i>
                                            </span>
                                            <span class="mb-0 me-2">Total Lowongan:</span>
                                            <h5 class="mb-0 me-2 text-primary" id="sum_total">0</h5>
                                            <span class="mb-0 me-2">Lowongan </span>
                                        </div>
                                        @break
                                    @case('tertunda')
                                        <div class="d-flex justify-content-center align-items-center">
                                            <span class="p-2 badge bg-label-success me-2">
                                                <i class="ti ti-briefcase" style="font-size: 12pt;"></i>
                                            </span>
                                            <span class="mb-0 me-2">Total Menunggu Persetujuan:</span>
                                            <h5 class="mb-0 me-2 text-primary" id="sum_tertunda">0</h5>
                                            <span class="mb-0 me-2">Menunggu Persetujuan </span>
                                        </div>
                                        @break
                                    @case('diterima')
                                        <div class="d-flex justify-content-center align-items-center">
                                            <span class="p-2 badge bg-label-success me-2">
                                                <i class="ti ti-briefcase" style="font-size: 12pt;"></i>
                                            </span>
                                            <span class="mb-0 me-2">Total Diterima:</span>
                                            <h5 class="mb-0 me-2 text-primary" id="sum_diterima">0</h5>
                                            <span class="mb-0 me-2">Diterima </span>
                                        </div>
                                        @break
                                    @case('ditolak')
                                        <div class="d-flex justify-content-center align-items-center">
                                            <span class="p-2 badge bg-label-success me-2">
                                                <i class="ti ti-briefcase" style="font-size: 12pt;"></i>
                                            </span>
                                            <span class="mb-0 me-2">Total Ditolak:</span>
                                            <h5 class="mb-0 me-2 text-primary" id="sum_ditolak">0</h5>
                                            <span class="mb-0 me-2">Ditolak </span>
                                        </div>
                                        @break
                                    @default

                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="table" id="{{ $item }}" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="max-width:70px;">NOMOR</th>
                                <th style="min-width:100px;">POSISI</th>
                                <th style="min-width:100px;">TANGGAL</th>
                                <th style="min-width:100px;">DURASI MAGANG</th>
                                <th style="text-align:center;min-width:50px;">STATUS</th>
                                <th style="text-align:center;min-width:100px;">AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>

@include('company/lowongan_magang/components/modal_kelola_lowongan')
@endsection
@section('page_script')
    <script>
        let dataFilter = {};
        let pageState = {};
        let table = {};
        
        $(document).ready(function () {
            loadState();
            loadData();
        });

        $('#tahun_akademik_filter').on('change', function () {
            loadData();
        });

        function loadState() {
            let currentUrl = new URL(window.location.href);

            let type = currentUrl.searchParams.get("type");
            let page = currentUrl.searchParams.get("page");
            
            if (type != null && page != null) {
                pageState[type] = parseInt(page);

                let targetTab = $(`button[data-bs-target="#navs-pills-justified-${type}"]`);
                if (targetTab.length) {
                    new bootstrap.Tab(targetTab[0]).show();
                }

                currentUrl.searchParams.delete("type");
                currentUrl.searchParams.delete("page");
        
                window.history.replaceState({}, document.title, currentUrl.pathname);
            }
        }

        function loadData() {
            dataFilter['tahun_akademik'] = $('#tahun_akademik_filter').val();
            $('#tahun_ajar').text($('#tahun_akademik_filter :selected').text());
            let statusTableId = ['total', 'tertunda', 'diterima', 'ditolak'];

            statusTableId.forEach(function(idElement) {
                dataFilter['type'] = idElement;
                dataFilter['page'] = pageState[idElement] ?? 1;

                table[idElement] = $('#' + idElement).DataTable({
                    ajax: function (data, callback, settings) {
                        dataFilter['page_length'] = data.length;

                        $.ajax({
                            url: "{{ route('kelola_lowongan.show') }}",
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
                        let total = this.api().data().count();
                        $('#sum_' + idElement).text(settings.json.recordsTotal);
                        $('[data-bs-toggle="tooltip"]').tooltip();

                        let currentPage = settings._iDisplayStart / settings._iDisplayLength + 1;

                        $(this).find('.btn-detail').each(function () {
                            let baseUrl = new URL($(this).attr('href'), window.location.origin);

                            baseUrl.searchParams.set('page', currentPage);
                            baseUrl.searchParams.set('type', idElement);
                            $(this).attr('href', baseUrl.toString());
                        });
                    },
                    columns: [
                        {
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.settings._iDisplayStart + meta.row + 1;
                            }
                        },
                        {
                            data: "intern_position",
                            name: "intern_position"
                        },
                        {
                            data: "tanggal",
                            name: "tanggal"
                        },
                        {
                            data: "durasimagang",
                            name: "durasimagang"
                        },

                        {
                            data: "status",
                            name: "status"
                        },
                        {
                            data: "action",
                            name: "action"
                        }
                    ],
                });

                table[idElement].on('preXhr.dt', function(e, settings, data) {
                    var info = $(`#${idElement}`).DataTable().page.info();
                    
                    var currentPage = info.page + 1;
                    
                    dataFilter['type'] = $(e.target).attr('id');
                    dataFilter['page_length'] = settings._iDisplayLength;
                    dataFilter['page'] = currentPage;
                    dataFilter['search'] = data.search.value;
                });
            });
        }

        function afterUpdateStatus(response) {
            $('.table').each(function () {
                if ($(this).attr('id') == undefined) return;
                $(this).DataTable().ajax.reload(null, false);
            });
        }

        function updateTakedown(e) {
            let modal = $('#modal_edit_takedown');
            let id = e.attr('data-id');
            let urlGet = `{{ route('kelola_lowongan.get_takedown', ['id' => ':id']) }}`.replace(':id', e.attr('data-id'));
            let urlUpdate = `{{ route('kelola_lowongan.update_takedown', ['id' => ':id']) }}`.replace(':id', e.attr('data-id'));

            modal.find('form').attr('action', urlUpdate);

            $.ajax({
                url: urlGet,
                type: 'GET',
                success: function (response) {
                    modal.find('input[name="enddate"]').flatpickr({
                        altInput: true,
                        altFormat: 'j F Y',
                        dateFormat: 'Y-m-d',
                        defaultDate: response.data
                    });

                    modal.find('input[name="enddate"]').val(response.data);
                    modal.modal('show');
                }
            });
        }

        function afterUpdateTakedown(response) {
            $('#modal_edit_takedown').modal('hide');
            $('.table').each(function () {
                if ($(this).attr('id') == undefined) return;
                $(this).DataTable().ajax.reload(null, false);
            });
        }

        $('#tahun_akademik_filter').on('change', function(e) {
            e.preventDefault();
            $('#tahun_ajar').text($(`#tahun_akademik_filter :selected`).text())
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
        });

        $(document).on('submit', '#filter', function(e) {
            const offcanvasFilter = $('#modalSlide');
            e.preventDefault();
            $('#tooltip-filter').attr('data-bs-original-title', 'durasimagang: ' + $('#durasimagang :selected')
                .text() + ', posisilowongan: ' + $('#posisi :selected').text() + ', statuslowongan: ' + $(
                    '#status :selected').text());
            offcanvasFilter.offcanvas('hide');
            // $('#status').DataTable().ajax.reload();
        });

        $('.data-reset').on('click', function() {
            $('#durasimagang').val(null).trigger('change');
            $('#posisi').val(null).trigger('change');
            $('#status').val(null).trigger('change');
        });
    </script>
@endsection
