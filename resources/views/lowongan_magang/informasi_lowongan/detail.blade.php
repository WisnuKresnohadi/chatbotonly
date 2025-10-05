@extends('partials.vertical_menu')

@section('page_style')
<style>
    .tooltip-inner {
        min-width: 100%;
        max-width: 100%;
    }

    .position-relative {
        padding-right: 15px;
        padding-left: 15px;
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
<div class="d-flex justify-content-start">
    <a href="{{ $urlBack }}" class="btn btn-outline-primary">
        <i class="ti ti-arrow-left"></i>
        Kembali
    </a>
</div>
<div class="mt-3 d-flex justify-content-between">
    <h4 class="fw-bold"><span class="text-muted fw-light">Informasi Lowongan / </span>{{ $lowongan->intern_position }}</h4>
</div>

<div class="col-xl-12">
    <div class="nav-align-top">
        <ul class="mb-3 nav nav-pills " role="tablist">
            @foreach ($tab as $key => $item)
            <li class="nav-item" style="font-size: small;">
                <button type="button" class="{{ $loop->first ? 'active' : '' }} nav-link" target="2" role="tab" data-bs-toggle="tab" data-bs-target="#{{ $key }}" aria-controls="{{ $key }}" aria-selected="false" style="padding: 8px 9px;">
                    <i class="tf-icons {{ $item['icon'] }} ti-xs me-1"></i>
                    {{ $item['label'] }}
                    <span class="badge rounded-pill bg-label-primary badge-center h-px-20 w-px-20 ms-1" id="total_{{ $item['table'] }}">
                        0
                    </span>
                </button>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="row cnt">
        <div class="mb-3 col-8 text-secondary">Filter Berdasarkan : <i class='pb-1 tf-icons ti ti-alert-circle text-primary' data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Program Studi : D3 Rekayasa Perangkat Lunak Aplikasi, Fakultas : Ilmu Terapan, Universitas : Tel-U Jakarta, Status :  Diterima" id="tooltip-filter"></i></div>
        <div id="div2" class="col-1 targetDiv" style="display: none;">
            <div class="mb-3 col-md-4 col-12 d-flex align-items-center justify-content-between">
                <select class="select2 form-select" data-placeholder="Ubah Status Kandidat">
                </select>
                <button class="btn btn-success" data-bs-toggle="offcanvas" data-bs-target="#modalSlide" style="min-width: 142px;"><i class="tf-icons ti ti-checks">
                        Terapkan</i>
                </button>
            </div>
        </div>
    </div>

    <div class="p-0 tab-content">
        @foreach ($tab as $key => $item)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $key }}" role="tabpanel">
            <div class="card">
                {{-- <div class="p-3 d-flex align-items-center justify-content-between">
                    <div class="border shadow-none card border-secondary">
                        <div class="p-2 card-body">
                            <div class="d-flex justify-content-center align-items-center">
                                <span class="p-2 badge bg-label-success me-2">
                                    <i class="ti ti-briefcase" style="font-size: 12pt;"></i>
                                </span>
                                <span class="mb-0 me-2">Total Pelamar:</span>
                                <h5 class="mb-0 me-2 text-primary" id="total-{{ $item['table'] }}">0</h5>
                                <span class="mb-0 me-2">Lowongan </span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <span class="fw-semibold">Batas Konfirmasi Penerimaan&nbsp;:&nbsp;<span class="text-primary">20 Juli 2023</span></span>
                    </div>
                </div> --}}
                <div class="card-datatable table-responsive">
                    <table class="table" id="{{ $item['table'] }}" style="width: 100%;">
                        <div class="mx-3 mt-4 rounded" style="background:#009BAE; display:flex; flex-direction:row; height:4.5rem; margin-bottom:1rem; gap:0.5rem; padding-left:1rem; align-items:center;"><div class="d-flex align-items-start" style="gap:0.5rem; color:white;"><i class="ti ti-info-circle fs-4"></i><div style="display:flex; flex-direction:column;"><span style="font-weight:600;">Panduan</span><span>Beri predikat nilai kepada kandidat dengan membandingkan bagian kolom deskripsi kriteria dipersyaratkan dengan deskripsi kriteria milik mahasiswa</span></div></div></div>'
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-center">STATUS</th>
                                @if ($key == 'FAHP')
                                    <th>SKOR</th>
                                @endif
                                <th>NAMA</th>
                                <th>KONTAK</th>
                                <th>UNIVERSITAS</th>
                                {{-- <th>EMAIL</th> --}}
                                <th class="text-center">Tanggal Daftar</th>
                                {{-- <th>PROGRAM STUDI</th>
                                <th>FAKULTAS</th> --}}
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @include('lowongan_magang/informasi_lowongan/components/modal')
</div>
@endsection

@section('page_script')
<script>
    $('.table').each(function () {
        let tableId = $(this).attr('id');
        console.log(tableId);
        let columns = [
            { data: "DT_RowIndex" },
            { data: "current_step" },
            { data: "namamhs" },
            { data: "nohpmhs" },
            { data: "namauniv" },
            // { data: "emailmhs" },
            { data: "tanggaldaftar" },
            // { data: "namaprodi" },
            // { data: "namafakultas" },
            { data: "action" },
        ];

        if (tableId == 'fahp') {
            columns.splice(2, 0, { data: "score" });
        }        

        $(this).DataTable({
            ajax: {
                url: "{{ $urlGetData }}",
                type: 'GET',
                data: function(d) {
                    d['type'] = tableId
                    if (tableId == 'fahp') {
                        d['filter_seleksi'] = $('#filter-seleksi').val();
                    }
                }
            },
            scrollX: true,
            serverSide: false,
            processing: true,
            deferRender: true,
            destroy: true,
            drawCallback: function( settings, json ) {
                let total = this.api().data().count();
                $('#total_' + tableId).text(total);
                $('#total-' + tableId).text(total);

            },
            initComplete: function() {

            },
            columns: columns,
            createdRow: function(row,data,dataIndex) {
                $(row).attr('data-href', '{{ route("lowongan.informasi.detail_kandidat", ":id") }}'.replace(':id', data.id_pendaftaran));
                $(row).css('cursor', 'pointer');
            }
        });

        //Drop down filter
        if (tableId == 'penawaran') {
            var divElement = document.getElementById('approved_seleksi_tahap_1_filter');

            if (divElement) {
                divElement.style.display = 'flex';
                divElement.style.gap = '1.5rem';
                divElement.style.justifyContent = 'flex-start';
                divElement.style.flexDirection = 'row-reverse';
                divElement.style.alignItems = 'center';


                var selectElement = document.createElement('select');
                selectElement.classList.add('select2', 'form-select');
                selectElement.setAttribute('data-placeholder', 'Filter Data');
                selectElement.setAttribute('id', 'filter-seleksi');

                $(selectElement).on('change', () => {
                    $(this).DataTable().ajax.reload(null, false);
                });

                var options = [
                    { value: 'all', text: 'Semua Data' },
                    { value: 'approved_penawaran', text: 'Diambil' },
                    { value: 'rejected_penawaran', text: 'Diabaikan' },
                ];

                options.forEach(function(optionData) {
                    var option = document.createElement('option');
                    option.value = optionData.value;
                    option.textContent = optionData.text;
                    selectElement.appendChild(option);
                });

                divElement.appendChild(selectElement);
            }
        }

        $(this).on('click', 'tr > td:not(:last-child)', function() {
            window.location = $(this).closest('tr').data('href');
        });
    });


    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
    });

    function detailInfo(e) {
        let offcanvas = $('#detail_pelamar_offcanvas');
        offcanvas.offcanvas('show');
        btnBlock(offcanvas);

        $.ajax({
            url: "{{ $urlDetailPelamar }}?data_id=" + e.attr('data-id'),
            type: "GET",
            success: function (response) {
                btnBlock(offcanvas, false);
                response = response.data;
                $('#container_detail_pelamar').html(response.view);
                $('#change_status').attr('data-id', response.id_lowongan);
                $('#change_status').attr('data-default', response.current_step);
                $('#change_status').val(response.current_step).change();
            }
        });
    }

    $('#detail_pelamar_offcanvas').on('hidden.bs.offcanvas', function () {
        $('#container_detail_pelamar').html(null);
        $('#change_status').removeAttr('data-id');
    });
</script>
@endsection
