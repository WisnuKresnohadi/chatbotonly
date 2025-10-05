@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <h4 class="fw-bold"> Assign Pembimbing Lapangan - Periode Tahun Ajaran <span id="tahun_ajaran_picked"></span></h4>
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

    <div class="row mt-4">
        <div class="nav-align-top">
            <ul class="nav nav-pills mb-3 " role="tablist">
                <li class="nav-item" style="font-size: small;">
                    <button type="button" class="nav-link active" target="1" role="tab" id="tab-unassigned"
                        data-bs-toggle="tab" data-bs-target="#navs-pills-justified-unassigned"
                        aria-controls="navs-pills-justified-unassigned" aria-selected="true" style="padding: 8px 9px;">
                        <i class="tf-icons ti ti-user-x ti-xs me-1"></i> Tentukan Pembimbing
                    </button>
                </li>
                <li class="nav-item" style="font-size: small;">
                    <button type="button" class="nav-link" target="2" role="tab" id="tab-assigned"
                        data-bs-toggle="tab" data-bs-target="#navs-pills-justified-assigned" 
                        aria-controls="navs-pills-justified-assigned" aria-selected="false" style="padding: 8px 9px;">
                        <i class="tf-icons ti ti-user-check ti-xs me-1"></i> Pembimbing Telah Ditentukan
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <div class="col my-auto">
            <div class="text-secondary">
                Filter Berdasarkan : 
                <i class='tf-icons ti ti-alert-circle text-primary pb-1' data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Posisi Magang: Pilih Posisi Lowongan Magang, Program Studi: Pilih Program Studi" id="tooltip-filter"></i>
            </div>
        </div>
        <div class="col-md-6 col-12 text-end">
            <button class="btn btn-primary" id="assign-pembimbing">Assign Pembimbing Lapangan</button>
        </div>
    </div>

    <div class="tab-content p-0">
        @foreach (['unassigned','assigned'] as $key => $item)
        <div class="tab-pane fade show {{ $key == 0 ? 'active' : '' }}" id="navs-pills-justified-{{ $item }}" role="tabpanel">
            <div class="card mt-4">
                <div class="card-datatable table-responsive">
                    <table class="table" id="{{ $item }}" style="width: 100%;">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="max-width:70px;">NOMOR</th>
                                <th style="min-width:100px;">NAMA/NIM</th>
                                <th style="min-width:100px;">PROGRAM STUDI</th>
                                <th style="min-width:100px;">POSISI MAGANG</th>
                                <th style="min-width:100px;">TANGGAL MAGANG</th>
                                <th style="min-width:100px;">DOKUMEN</th>
                                @if($item == 'assigned')
                                    <th style="min-width:100px;">PEMBIMBING LAPANGAN</th>
                                @endif
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Modal -->
    @include('company.assign_pembimbing.components.modal')
    {{-- Filter --}}
    @include('company.assign_pembimbing.components.filter')


@endsection
@section('page_script')
    <script>
        $(document).ready(function () {
            dataFilter['tahun_akademik'] = $('#tahun_akademik_filter').val();
            loadData();
        });

        let dataFilter = {};
        let tables = {};
        let baseColumnSettings = [
            {
                data: null
            },
            {
                data: "DT_RowIndex"
            },
            {
                data: "namamhs",
                name: "namamhs"
            },
            {
                data: "namaprodi",
                name: "namaprodi"
            },
            {
                data: "intern_position",
                name: "intern_position"
            },
            {
                data: "tanggal_magang",
                name: "tanggal_magang"
            },
            {
                data: "bukti_penerimaan",
                name: "bukti_penerimaan"
            },
        ];

        function loadData() {
            $('#tahun_ajaran_picked').text($('#tahun_akademik_filter :selected').text());

            let statusTableId = ['unassigned', 'assigned'];

            statusTableId.forEach(function (idElement) {
                let columnSettings = [...baseColumnSettings];

                if (idElement === 'assigned') {
                    columnSettings.push({
                        data: "pembimbing_lapangan",
                        name: "pembimbing_lapangan"
                    });
                }

                dataFilter['type'] = idElement;
                tables[statusTableId] = $('#' + idElement).DataTable({
                    ajax: {
                        url: "{{ route('assign_pembimbing.show') }}",
                        data: dataFilter
                    },
                    processing: true,
                    destroy: true,
                    columns: columnSettings,
                    columnDefs: [
                        {
                            targets: 0,
                            searchable: false,
                            orderable: false,
                            render: function (data, type, row, meta) {
                                return `<input type='checkbox' class='dt-checkboxes form-check-input' value='${row.id_mhsmagang}'>`;
                            },
                            checkboxes: {
                                selectRow: false,
                                selectAllRender: `<input type='checkbox' class='form-check-input'>`
                            }
                        }
                    ],
                    select: { 
                        style: 'multi', 
                        selector: 'td:first-child input:checkbox' 
                    }
                });
                
            });
        }

        $(document).on('submit', '#filter', function(e) {
            const offcanvasFilter = $('#modalSlide');
            e.preventDefault();
            $('#tooltip-filter').attr('data-bs-original-title', 
                'Posisi Magang: ' + $('#id_lowongan :selected') .text() + 
                ', Program Studi: ' + $('#program_studi :selected').text()
            );
            let filter = $(this).serializeArray();
            filter.forEach(function( item ) {
                dataFilter[item.name] = item.value;
            });
            loadData();
        });

        $('#tahun_akademik_filter').on('change', function () {
            dataFilter['tahun_akademik'] = $(this).val();
            loadData();
        });

        $('#data-reset').on('click', function() {
            $('#posisi').val(null).trigger('change');
            $('#id_prodi').val(null).trigger('change');
            dataFilter = {};
            loadData();
        });

        $('#assign-pembimbing').on('click', function() {
            let modal = $('#modalAssignPembimbing');
            let selectedValue = $('input.dt-checkboxes:checked');

            if (selectedValue.length == 0) {
                showSweetAlert({
                    title: 'Invalid',
                    text: 'Pilih mahasiswa terlebih dahulu',
                    icon: 'warning'
                });
                return;
            }

            selectedValue.each(function() {
                modal.find('form').prepend('<input type="hidden" name="id_mhsmagang[]" value="' + $(this).val() + '">');
            });

            modal.modal('show');
        });

        $('#modalAssignPembimbing').on('hide.bs.modal', function() {
            $(this).find('form').find('input[name="id_mhsmagang[]"]').remove();
        });

        function afterAssigning(response) {
            $("#modalAssignPembimbing").modal("hide");
            $('input.dt-checkboxes').prop('checked', false);

            loadData()
        }

        $('#tab-assigned').on('click', function() {
            $('#assign-pembimbing').html('Edit Pembimbing Lapangan');
            $('#modal-assign-title').html('Edit Pembimbing Lapangan');
            $('input.form-check-input').prop('checked', false);
        });

        $('#tab-unassigned').on('click', function() {
            $('#assign-pembimbing').html('Assign Pembimbing Lapangan');
            $('#modal-assign-title').html('Assign Pembimbing Lapangan');
            $('input.form-check-input').prop('checked', false);
        });
    </script>
@endsection
