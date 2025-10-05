@extends('partials.vertical_menu')

@section('page_style')
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
</style>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h4 class="fw-bold text-sm">Dashboard Periode <span id="container_tahun_picked"></span></h4>
    </div>
    <div class="d-none d-sm-flex">
        <select class="select2 form-select" data-placeholder="Filter Status" id="filter_tahun" onchange="getData();">
            {!! tahunAjaranMaker() !!}
        </select>
    </div>
</div>

<!-- Statistics -->
<div class="col-12 mb-4">
    <div class="card h-100">
        <div class="card-header">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title mb-0">Menunggu Approval</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row gy-3" id="container_pending_approval">
                @include('dashboard/admin/components/waiting_approval')
            </div>
        </div>
    </div>
</div>
<!--/ Statistics -->

<!-- Bar Chart -->
<div class="col-12 mb-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0">Lowongan Publish</h5>
        </div>
        <div class="card-body">
            <div id="container_lowongan">
                <div class="py-4"></div>
            </div>
        </div>
    </div>
</div>
<!-- /Bar Chart -->

<div class="row">
    <!-- Donut Chart -->
    <div class="col-md-6 col-12 mb-4" id="container_proses">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Proses Seleksi</h5>
                <div class="col-4">
                    <select class="select2 form-select" id="filter_industri_proses" onchange="loadChartProsesSeleksi();"></select>
                </div>
            </div>
            <div class="card-body">
                <div id="container_proses_chart"></div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <div class="d-sm-flex d-block">
                            <div class="d-flex align-items-center lh-1 me-3 mb-3 mb-sm-0">
                                <span class="badge badge-dot me-1 bg-info"></span> Seleksi
                            </div>
                            <div class="d-flex align-items-center lh-1 me-3 mb-3 mb-sm-0">
                                <span class="badge badge-dot me-1 bg-warning"></span> Penawaran
                            </div>
                            <div class="d-flex align-items-center lh-1 me-3 mb-3 mb-sm-0">
                                <span class="badge badge-dot me-1 bg-primary"></span> Diterima
                            </div>
                            <div class="d-flex align-items-center lh-1 me-3 mb-3 mb-sm-0">
                                <span class="badge badge-dot me-1 bg-danger"></span> Ditolak
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Donut Chart -->

    <!-- Pie Chart -->
    <div class="col-md-6 col-12 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Rekapitulasi Mahasiswa Magang</h5>
            </div>
            <div class="card-body">
                <div id="container_rekapitulasi">
                    <div class="py-4"></div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-center mb-3">
                        <div class="d-sm-flex d-block" id="container_list_jenis_magang"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Pie Chart -->
</div>
@include('dashboard/admin/components/modal')
@endsection
@section('page_script')
<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

<script>
    let dataPayload = {};
    let listColor = ['#FF9F43', '#836AF9', '#4EA971', '#00CFE8', '#ffe800', '#28dac6', '#299AFF', '#4F5D70'];

    $(document).ready(function () {
        loadAll();
    });

    function getData() {
        loadAll();
    }

    function loadAll() {
        loadPendingApproval();
        loadLowonganPublished();
        loadRekapitulasiMhs();
        loadProsesSeleksi();
    }

    function loadPendingApproval() {
        dataPayload.section = 'get_waiting_approval';
        sectionBlock($('#container_pending_approval'));
        loadData(function (res) {
            sectionBlock($('#container_pending_approval'), false);
            $('#container_pending_approval').html(res.data);
        });
    }

    function loadLowonganPublished() {
        dataPayload.section = 'lowongan_published';
        sectionBlock($('#container_lowongan'));
        loadData(function (res) {
            res = res.data;

            sectionBlock($('#container_lowongan'), false);
            FusionCharts.ready(function() {
                var container_lowongan = new FusionCharts({
                    type: "scrollbar2d",
                    renderAt: "container_lowongan",
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
                            category: res.category
                        }],
                        dataSet: [{
                            data: res.dataSet
                        }]
                    }
                }).render();

                container_lowongan.addEventListener("dataplotClick", function(eventObj, dataObj) {
                    dataPayload.section = 'get_detail_mitra_lowongan';
                    dataPayload.data_id = dataObj.id;
                    let modal = $('#modal_show_lowongan_published');
                    modal.modal('show');
                    modal.find('#companyName').text(dataObj.categoryLabel);
                    modal.on('hidden.bs.modal', function (e) {
                        $(this).find('#container_list_lowongan_published').html(null);
                    });

                    loadData(function (res) {
                        res = res.data;
                        $('#container_list_lowongan_published').html(res);
                    });
                });
            });
        });
    }

    function loadProsesSeleksi() {
        dataPayload.section = 'get_dropdown_list_proses';
        sectionBlock($('#container_proses'));
        $('#filter_industri_proses').empty();

        loadData(function (res) {
            $.each(res.data, function ( index, value ) {
                $('#filter_industri_proses').append(`<option value="${value.id}" ${index == 0 ? 'selected' : ''}>${value.name}</option>`);
            });
            sectionBlock($('#container_proses'), false);
            if (res.data.length > 0) loadChartProsesSeleksi();
        });
    }

    function loadChartProsesSeleksi() {
        dataPayload.section = 'get_proses_seleksi';
        dataPayload.data_id = $('#filter_industri_proses').val();

        sectionBlock($('#container_proses_chart'));
        loadData(function (res) {
            sectionBlock($('#container_proses_chart'), false);

            FusionCharts.ready(function() {
                var kandidat = new FusionCharts({
                    type: "doughnut2d",
                    renderAt: "container_proses_chart",
                    width: "100%",
                    height: "400",
                    dataFormat: "json",
                    dataSource: {
                        chart: {
                            showvalues: "0",
                            showlabels: "0",
                            defaultcenterlabel: "Total Kandidat " + res.data.data_total,
                            decimals: "1",
                            plottooltext: "$label: $value Kandidat",
                            centerlabel: "Kandidat: $value",
                            theme: "fusion",
                            showlegend: "0",
                            "palettecolors": "#00CFE8,#FF9F43,#4EA971,#EA5455",
                            "enableMultiSlicing": "0"
                        },
                        data: res.data.data_chart

                    }
                }).render();
            });
        });
    }

    function loadRekapitulasiMhs() {
        dataPayload.section = 'get_rekapitulasi_mhs';
        sectionBlock($('#container_rekapitulasi'));

        $('#container_list_jenis_magang').empty();

        loadData(function (res) {
            $.each(res.data.list_jenis_magang, function ( index, value ) {
                $('#container_list_jenis_magang').append(`
                    <div class="d-flex align-items-center lh-1 me-3 mb-3 mb-sm-0">
                        <span class="badge badge-dot me-1" style="background-color: ${listColor[index]}"></span> ${value}
                    </div>
                `);
            });

            sectionBlock($('#container_rekapitulasi'), false);

            FusionCharts.ready(function() {
                var rekap = new FusionCharts({
                    type: "pie2d",
                    renderAt: "container_rekapitulasi",
                    width: "100%",
                    height: "400",
                    dataFormat: "json",
                    dataSource: {
                        chart: {
                            showvalues: "0",
                            showlabels: "0",
                            plottooltext: "$label : $value Mahasiswa",
                            legendposition: "bottom",
                            theme: "fusion",
                            showlegend: "0",
                            "palettecolors": listColor,
                            "enableMultiSlicing": "0"
                        },
                        data: res.data.data_chart
                    }
                }).render();
            });
        });
    }

    function loadData(callback = null) {
        $('#container_tahun_picked').text($('#filter_tahun option:selected').text());
        dataPayload.tahun = $('#filter_tahun').val();

        $.ajax({
            url: `{{ route('dashboard_admin.get_data') }}`,
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