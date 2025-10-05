@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
<div class="d-flex justify-content-between">
    <a href="{{ $urlBack }}" class="btn btn-outline-primary">
        <i class="ti ti-arrow-left"></i>
        Kembali
    </a>
    <select class="select2 form-select" data-placeholder="Pilih Tahun Ajaran" id="tahun_akademik_filter">
        {!! tahunAjaranMaker() !!}
    </select>
</div>
<div class="row mt-4">
    <div class="col-md-9 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Lowongan Magang / </span>Informasi Lowongan - Tahun Ajaran 
            <span id="tahun_ajar"></span>
        </h4>
    </div>
</div>

<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <div class="card shadow-none border border-secondary">
                            <div class="card-body py-2 px-2">
                                <div class="d-flex justify-content-center align-items-center">
                                    <span class="badge bg-label-primary p-2 me-2">
                                        <i class="ti ti-users" style="font-size: 12pt;"></i>
                                    </span>
                                    <div class="d-flex flex-column">
                                        <span class="mb-0 me-2">Total Pelamar :</span>
                                        <div class="d-flex align-items-center">
                                            <h5 class="mb-0 me-2 text-primary" id="set_total_pelamar">0</h5>
                                            <span class="mb-0 me-2">Kandidat Melamar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="card shadow-none border border-secondary">
                            <div class="card-body py-2 px-2">
                                <div class="d-flex justify-content-center align-items-center">
                                    <span class="badge bg-label-primary p-2 me-2">
                                        <i class="ti ti-briefcase" style="font-size: 12pt;"></i>
                                    </span>
                                    <div>
                                        <span class="mb-0 me-2">Total Lowongan :</span>
                                        <div class="d-flex align-items-center">
                                            <h5 class="mb-0 me-2 text-primary" id="set_total_lowongan">0</h5>
                                            <span class="mb-0 me-2">Lowongan</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
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
@endsection

@section('page_script')
<script>

    let dataFilter = {};
    $(document).ready(function () {
        dataFilter['tahun_akademik'] = $('#tahun_akademik_filter').val();
        loadData();
    });

    $('#tahun_akademik_filter').on('change', function(e) {
        e.preventDefault();
        dataFilter['tahun_akademik'] = $('#tahun_akademik_filter').val();
        loadData();
    });

    function loadData(){
        $('#tahun_ajar').text($(`#tahun_akademik_filter :selected`).text());
        $('#table').DataTable({
            ajax: {
                url: `{{ $urlGetData }}`,
                type: 'GET',
                data: dataFilter
            },
            serverSide: false,
            processing: true,
            deferRender: true,
            destroy: true,
            drawCallback: function ( settings, json ) {
                let total = this.api().data().count();
                let totalPelamar = 0;

                $('.total_pelamar').each(function () {
                    totalPelamar += parseInt($(this).text());
                });

                $('#set_total_lowongan').text(total);
                $('#set_total_pelamar').text(totalPelamar);
            },
            columns: [{data: "data"}],
            language: {
                emptyTable: `<img src="{{ asset('assets/images/lowongan-empty.svg') }}" alt="no-data" style="display: flex; margin-left: auto; margin-right: auto; margin-top: 5%; margin-bottom: 5%;  max-width: 80%;">`,
            },
            ordering: false
        });
    }
</script>
@endsection