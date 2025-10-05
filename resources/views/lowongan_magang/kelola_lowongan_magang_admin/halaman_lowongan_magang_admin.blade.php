@extends('partials.vertical_menu')

@section('page_style')
<style>
    .tooltip-inner {
        min-width: 100%;
        max-width: 100%;
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

@section('content')
    <div class="row">
        <div class="col-md-9 col-12">
            <h4 class="fw-bold">Kelola Lowongan - Tahun Ajaran <span id="tahun_ajar"></span></h4>
        </div>
        <div class="mb-3 col-md-3 col-12 d-flex align-items-center justify-content-end">
            <select class="select2 form-select" data-placeholder="Pilih Tahun Ajaran" id="tahun_akademik_filter">
                {!! tahunAjaranMaker() !!}
            </select>
            <button class="btn btn-primary btn-icon ms-2" data-bs-toggle="offcanvas" data-bs-target="#modalSlide"><i class="tf-icons ti ti-filter"></i></button>
        </div>
    </div>

    <div class="col-12">
        <div class="nav-align-top">
            <ul class="mb-1 nav nav-pills" role="tablist">
                <li class="nav-item" style="font-size: small;">
                    <button type="button" class="nav-link active" target="2" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-tertunda" aria-controls="navs-pills-justified-tertunda" aria-selected="false" style="padding: 8px 9px;">
                        <i class="tf-icons ti ti-clock me-1"></i> Menunggu Persetujuan
                    </button>
                </li>
                <li class="nav-item" style="font-size: small;">
                    <button type="button" class="nav-link" target="3" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-diterima" aria-controls="navs-pills-justified-diterima" aria-selected="false" style="padding: 8px 9px;">
                        <i class="tf-icons ti ti-clipboard-check me-1"></i> Disetujui
                    </button>
                </li>
                <li class="nav-item" style="font-size: small;">
                    <button type="button" class="nav-link" target="4" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-ditolak" aria-controls="navs-pills-justified-ditolak" aria-selected="false" style="padding: 8px 9px;">
                        <i class="tf-icons ti ti-clipboard-x me-1"></i> Ditolak
                    </button>
                </li>
            </ul>
        </div>

        <div class="my-4 row">
            <div class="col-md-8 col-12">
                <div class="text-secondary">Filter Berdasarkan : <i class='pb-1 tf-icons ti ti-alert-circle text-primary' data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Durasi Magang : -, Posisi Lowongan Magang : -, Status Lowongan Magang : -" id="tooltip-filter"></i></div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="p-0 tab-content">
            @foreach (['tertunda', 'diterima', 'ditolak'] as $key => $tableId)
            <div class="tab-pane fade show {{ $loop->iteration == 1 ? 'active' : '' }}" id="navs-pills-justified-{{ $tableId }}" role="tabpanel">
                <div class="card">
                    <div class="mt-3 row ms-3">
                        <div class="col-6 d-flex align-items-center" style="border: 1px solid #D3D6DB; max-width:280px; height:40px;border-radius:8px;">
                            <span class="badge badge-center bg-label-primary me-2"><i class="ti ti-briefcase"></i></span>Total Lowongan:</span>&nbsp;<span id="total_{{ $tableId }}" style="color:#7367F0;">0</span>&nbsp;<span style="color:#4EA971;"> Lowongan </span>
                        </div>
                    </div>
                    <div class="card-datatable table-responsive">
                        <table class="table tab1c" id="{{ $tableId }}" data-key="{{ $key }}" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th>PERUSAHAAN</th>
                                    <th style="">POSISI</th>
                                    <th style="">Program Studi</th>
                                    <th style="">TANGGAL</th>
                                    <th style="">JENIS MAGANG</th>
                                    <th style="text-align:center;">AKSI</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @include('lowongan_magang/kelola_lowongan_magang_admin/modal')
@endsection


@section('page_script')
<script>
    let dataFilter = {};
    let pageState = {};
    let table = {};

    $(document).ready(function() {
        loadState();
        loadData();
    });

    $('#tahun_akademik_filter').on('change', function() {
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
        $('#tahun_ajar').text($(`#tahun_akademik_filter :selected`).text());
        dataFilter['tahun_akademik'] = $('#tahun_akademik_filter').val();

        $('.table').each(function(index) {
            let $this = $(this);
            let idElement = $this.attr('id');
            if (idElement == undefined) return;

            dataFilter['type'] = idElement;
            dataFilter['page'] = pageState[idElement] ?? 1;

            table[idElement] = $this.DataTable({
                serverSide: true,
                processing: true,
                destroy: true,
                scrollX: true,
                displayStart: (dataFilter['page'] - 1) * 10,
                ajax: function (data, callback) {
                    dataFilter['page_length'] = data.length;

                    $.ajax({
                        url: `{{ route('lowongan.kelola.show') }}`,
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
                drawCallback: function (settings) {
                    $('#total_' + idElement).text(settings.json.recordsTotal);

                    let currentPage = settings._iDisplayStart / settings._iDisplayLength + 1;

                    $(this).find('.btn-detail').each(function () {
                        let baseUrl = new URL($(this).attr('href'), window.location.origin);

                        baseUrl.searchParams.set('page', currentPage);
                        baseUrl.searchParams.set('type', idElement);
                        $(this).attr('href', baseUrl.toString());
                    });

                    initTooltips();
                },
                columns: [
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.settings._iDisplayStart + meta.row + 1;
                        }
                    },
                    {
                        data: 'namaindustri',
                        name: 'namaindustri',

                    },
                    {
                        data: "intern_position",
                        name: "intern_position"
                    },
                    {
                        data: 'prodi',
                        name: "program_studi"
                    },
                    {
                        data: "tanggal",
                        name: "tanggal"
                    },
                    {
                        data: "id_jenismagang",
                        name: "id_jenismagang"
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

    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
    });

    function afterUpdateStatus(response) {
        $('#diterima').DataTable().ajax.reload(null, false)
    }

    $('#filter_data').on('submit', function(e) {
        e.preventDefault();
        $('#tooltip-filter').attr('data-bs-original-title', 'durasimagang: ' + $('#durasimagang :selected')
            .text() + ', posisilowongan: ' + $('#posisi :selected').text() + ', statuslowongan: ' + $(
                '#status :selected').text());


        dataFilter['durasimagang'] = $('#durasimagang').val();
        dataFilter['posisi'] = $('#posisi').val();
        loadData();

    });

    $('#filter_data').on('reset', function(e) {
        e.preventDefault();
        $('#tooltip-filter').attr('data-bs-original-title', "Durasi Magang : -, Posisi Lowongan Magang : -, Status Lowongan Magang : -");
        dataFilter = {};
        $('#filter_data').find('.form-select').val('').change();
        $('#filter_data').find('.form-control').val('');
        loadData();
    });
</script>
@endsection
