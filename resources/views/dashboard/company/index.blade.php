@extends('partials.vertical_menu')

@section('page_style')
<link rel="stylesheet" href="{{ asset('app-assets/vendor/css/pages/app-calendar.css') }}" />
<link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/fullcalendar/fullcalendar.css') }}" />
<style>
    #outer {
        width: 100%;
        text-align: center;
        color: black;
    }

    #lowongan {
        text-align: center;
    }

    svg>g[class^='raphael-group-'] g {
        fill: none !important;
    }

    .fc-direction-ltr .fc-daygrid-event.fc-event-end,
    .fc-direction-rtl .fc-daygrid-event.fc-event-start {
        background: #DCEEE3;
        padding: 7px;
    }

    .fc-h-event {
        background-color: #DCEEE3 !important;
        border: 1px solid var(--fc-event-border-color);
        display: block;
    }

    .fc-event-title {
        color: #4EA971 !important;
    }

    .fc .fc-daygrid-day-frame {
        min-height: 110px !important;
    }

    .fc .fc-button-primary:not(.fc-prev-button):not(.fc-next-button) {
        background-color: #dbf1e4 !important;
        border: 0;
        color: #4EA971;
    }

    .fc .fc-button-primary:not(.fc-prev-button):not(.fc-next-button).fc-button-active, .fc .fc-button-primary:not(.fc-prev-button):not(.fc-next-button):hover {
        background-color: #cae0d2 !important;
        color: #4EA971;
    }

</style>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h4 class="fw-bold text-sm">Dashboard Mitra Perusahaan - Periode <span id="selected_tahun"></span></h4>
    </div>
    <div class="d-none d-sm-flex">
        <select class="select2 form-select" id="filter_tahun" onchange="getData();" data-placeholder="Filter Status">
            {!! tahunAjaranMaker() !!}
        </select>
    </div>
</div>
<!-- Statistics -->
<div class="col-12 mb-4">
    <div class="card h-100">
        <div class="card-header">
            <h5 class="card-title mb-0">Statistik Lowongan Pekerjaan</h5>
        </div>
        <div class="card-body">
            <div class="row gy-3" id="container_statistik_lowongan">
                @include('dashboard/company/components/statistik_lowongan')
            </div>
        </div>
    </div>
</div>
<!--/ Statistics -->

<!-- Bar Chart -->
<div class="col-12 mb-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center pb-0">
            <div>
                <h5 class="card-title fw-bold mb-0">Statistik Lowongan</h5>
                <p><span id="total_kandidat">0</span> Kandidat</p>
            </div>
        </div>
        <div class="card-body">
            <div id="container_statistik_proses" style="min-height: 300px;"></div>
        </div>
    </div>
</div>
<!-- /Bar Chart -->

<div class="col-xl-12">

    <div class="nav-align-top mb-4">
        <ul class="nav nav-pills mb-3" role="tablist">
            <li class="nav-item">
                <button type="button" id="view-calendar-tab" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">
                    <i class="tf-icons ti ti-calendar ti-xs me-1"></i> View Calendar
                </button>
            </li>
            <li class="nav-item">
                <button type="button" id="view-table-tab" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">
                    <i class="tf-icons ti ti-table ti-xs me-1"></i> View Table
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                <div class="app-calendar-wrapper">
                    <div class="row g-0">
                        <!-- Calendar & Modal -->
                        <div class="col app-calendar-content">
                            <div class="card shadow-none border">
                                <div class="card-body pb-0">
                                    <!-- FullCalendar -->
                                    <div id="calendar2"></div>
                                </div>
                            </div>
                            <div class="app-overlay"></div>
                        </div>
                        <!-- /Calendar & Modal -->
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="navs-pills-top-profile" role="tabpanel">
                <div class="card-datatable table-responsive">
                    <table class="table" id="table-status-mahasiswa">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NAMA</th>
                                <th>POSISI</th>
                                <th>TANGGAL</th>
                                <th style="text-align: center;">STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('dashboard/company/components/modal')

@endsection

@section('page_script')
<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
<script src="{{asset('app-assets/vendor/libs/fullcalendar/fullcalendar.js')}}"></script>
@include('dashboard/company/js/calendar')
<script>

    let dataPayload = {};
    $(document).ready(function () {
        loadAll();
    });

    function getData() {
        loadAll();
    }

    function loadAll() {
        loadStatistikLowongan();
        loadStatistikProses();
        loadJadwal();
    }

    function loadStatistikLowongan() {
        dataPayload.section = 'get_statistik_lowongan';
        sectionBlock($('#container_statistik_lowongan'));
        loadData(function (res) {
            $('#container_statistik_lowongan').html(res.data);
            sectionBlock($('#container_statistik_lowongan'), false);
        });
    }

    function loadStatistikProses() {
        dataPayload.section = 'get_statistik_proses_seleksi';
        sectionBlock($('#container_statistik_proses'));
        loadData(function (res) {
            $('#total_kandidat').text(res.data.total_kandidat);

            FusionCharts.ready(function() {
                let lowonganChart = new FusionCharts({
                    type: "scrollbar2d",
                    renderAt: "container_statistik_proses",
                    width: "100%",
                    height: "300",
                    dataFormat: "json",
                    dataSource: {
                        chart: {
                            theme: "fusion",
                            "scrollPosition": "right",
                            "palettecolors": "#4EA971"
                        },
                        categories: [{
                            category: res.data.list_category
                        }],
                        dataSet: [{
                            data: res.data.list_data
                        }]
                    }
                }).render();

                lowonganChart.addEventListener("dataplotClick", function(eventObj, dataObj) {
                    dataPayload.section = 'get_detail_statistik_proses';
                    dataPayload.data_id = dataObj.id;

                    loadData(function (res) {
                        let modal = $('#modal_detail_lowongan');
                        modal.find('#jobName').text(dataObj.categoryLabel);
                        modal.find('#container_detail_statistik_proses').html(res.data);
                        modal.modal('show');
                    });

                });
            });
            sectionBlock($('#container_statistik_proses'), false);
        });
    }

    function loadJadwal() {

        dataPayload.section = 'get_calendar';
        loadData(function (res) {
            $('#view-calendar-tab').tab('show');

            initCalendar(res.data.calendar);

            var table = $('#table-status-mahasiswa').DataTable({
                "data": res.data.table,
                destroy: true,
                columns: [{
                        data: "no"
                    },
                    {
                        data: "nama"
                    },
                    {
                        data: "posisi"
                    },
                    {
                        data: "tanggal"
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "aksi"
                    }
                ],
            });
        });

    }

    function loadData(callback = null) {
        $('#selected_tahun').text($('#filter_tahun option:selected').text());
        dataPayload.tahun = $('#filter_tahun').val();

        $.ajax({
            url: `{{ route('dashboard_company.get_data') }}`,
            type: 'GET',
            data: dataPayload,
            success: callback,
            error: function (xhr, status, error) {
                
                showSweetAlert({
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan',
                    icon: 'error'
                });
            }
        });

        dataPayload.section = null;
    }
</script>
@endsection