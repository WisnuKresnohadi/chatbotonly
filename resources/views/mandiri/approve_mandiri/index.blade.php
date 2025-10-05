@extends('partials.vertical_menu')

@section('page_style')
    <style>
        .tooltip-inner {
            width: 450px !important;
            max-width: 450px !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="mb-3 d-flex align-items-center justify-content-between">
            <div>
                <h4 class="text-sm fw-bold">Pengajuan Magang Tahun Ajaran <span id="tahun_ajar"></span></h4>
            </div>
            <div class="d-flex justify-content-end">
                <select class="select2 form-select" data-placeholder="Filter Status" id="tahun_akademik_filter">
                    {!! tahunAjaranMaker() !!}
                </select>
                <button class="btn btn-icon btn-primary ms-1" data-bs-toggle="offcanvas" data-bs-target="#modalSlide"><i
                        class="tf-icons ti ti-filter"></i></button>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="nav-align-top">
            <ul class="mb-3 nav nav-pills" role="tablist">
                <li class="nav-item">
                    <button type="button" id="btn-tertunda" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-justified-tertunda" aria-controls="navs-pills-justified-tertunda"
                        aria-selected="true">
                        <i class="tf-icons ti ti-clock ti-xs me-1"></i> Belum Approval
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" id="btn-sudah" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-justified-done" aria-controls="navs-pills-justified-disetujui"
                        aria-selected="false">
                        <i class="tf-icons ti ti-list-check ti-xs me-1"></i> Sudah Approval
                    </button>
                </li>
            </ul>
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="text-secondary">Filter Berdasarkan : <i class='pb-1 tf-icons ti ti-alert-circle text-primary'
                        data-bs-toggle="tooltip" data-bs-placement="right"
                        data-bs-original-title="Program Studi: D3 Sistem Informasi, Jenis Magang: MSIB"
                        id="tooltip-filter"></i></div>
                <div class="d-flex justify-content-end" style="gap: 1rem;">
                    <button type="button" id="approval-btn" onclick="approvalSelected($(this))"
                        class="btn btn-primary">Terima</button>
                    <button type="button" id="upload-sr" class="text-white btn btn-primary d-none">Kelola Surat</button>
                </div>
            </div>
            <div class="p-0 tab-content">
                @foreach (['tertunda', 'done'] as $key => $item)
                    <div class="tab-pane fade {{ $key == 0 ? 'active show' : '' }}"
                        id="navs-pills-justified-{{ $item }}" role="tabpanel">
                        <div class="card-datatable table-responsive">
                            <table class="table" id="{{ $item }}">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>NO</th>
                                        <th>DATA MAHASISWA</th>
                                        <th>PROGRAM STUDI</th>
                                        <th>JENIS MAGANG</th>
                                        <th>PERUSAHAAN + POSISI</th>
                                        <th>TANGGAL MAGANG</th>
                                        <th>KONTAK PERUSAHAAN</th>
                                        <th>ALAMAT PERUSAHAAN</th>
                                        <th>DOKUMEN PENGAJUAN</th>
                                        <th class="text-center">STATUS</th>
                                        @if ($item == 'tertunda')
                                            <th class="text-center">AKSI</th>
                                        @endif
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @include('mandiri.approve_mandiri.modal')
    </div>

    <!-- filter -->
@endsection

@section('page_script')
    <script>
        let dataFilter = {};
        $(document).ready(function() {
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();

                if ($(this).attr('id') == 'btn-tertunda') {
                    $('#approval-btn').removeClass('d-none');
                    $('#upload-sr').addClass('d-none');
                } else {
                    $('#upload-sr').removeClass('d-none');
                    $('#approval-btn').addClass('d-none');
                }
            });

            loadData();
        });

        $('#tahun_akademik_filter').on('change', function() {
            loadData();
        });

        $('#filter_form').on('reset', function() {
            dataFilter = {};
            $(this).find('select').val('').trigger('change');
            loadData();
        });

        $('#filter_form').on('submit', function(e) {
            e.preventDefault();

            dataFilter['prodi'] = $('#prodi_filter').val();
            dataFilter['jenis_magang'] = $('#jenis_magang_filter').val();
            dataFilter['label_penawaran'] = $('#label_penawaran_filter').val();

            loadData();
        });

        function loadData() {
            $('#tahun_ajar').text($('#tahun_akademik_filter :selected').text());
            dataFilter['tahun_akademik'] = $('#tahun_akademik_filter').val();

            $('.table').each(function() {
                if ($(this).attr('id') == undefined) return;
                let column = [{
                        data: null
                    },
                    {
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'namaprodi'
                    },
                    {
                        data: 'namajenis'
                    },
                    {
                        data: 'posisi_magang'
                    },
                    {
                        data: 'tgl_magang'
                    },
                    {
                        data: 'contact_perusahaan'
                    },
                    {
                        data: 'alamatindustri'
                    },
                    {
                        data: 'dokumen'
                    },
                    {
                        data: 'current_step'
                    }
                ];

                let columnDefs = [];
                let select = false;

                if ($(this).attr('id') == 'tertunda') {
                    column.push({
                        data: 'action'
                    });
                }

                select = {style: 'multi', selector: 'td:first-child input:checkbox'}

                columnDefs = [{
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    render: function (data, type, row, meta) {
                        return `<input type='checkbox' class='dt-checkboxes form-check-input'  data-namamhs='` + row.namamhs + `' data-nim='` + row.nim + `' data-position='` + row.intern_position + `' data-industri='` + row.namaindustri + `' value='` + row.id_pendaftaran + `'>`;
                    },
                    checkboxes: {
                        selectRow: false,
                        selectAllRender: `<input type='checkbox' class='form-check-input'>`
                    }
                }];

                dataFilter.status = $(this).attr('id');

                $(this).DataTable({
                    ajax: {
                        url: "{{ route('pengajuan_magang.show') }}",
                        data: dataFilter,
                        type: 'GET'
                    },
                    serverSide: false,
                    processing: true,
                    type: 'GET',
                    destroy: true,
                    scrollX: true,
                    rowGroup: {
                        dataSrc: 'namaindustri'
                    },
                    columns: column,
                    columnDefs: columnDefs,
                    select: select
                });
            });
        }

        function approvalSelected(e) {
            let id = e.attr('id');
            let selectedValue = $('#tertunda').find('input.dt-checkboxes:checked');
            let modal = $('#modalpersetujuanspm');

            if (selectedValue.length == 0) {
                showSweetAlert({
                    title: 'Invalid',
                    text: 'Pilih data terlebih dahulu',
                    icon: 'warning'
                });
                return;
            }

            selectedValue.each(function() {
                modal.find('form').prepend('<input type="hidden" name="data_id[]" value="' + $(this).val() + '">');
                modal.find('#container-list-mhs').prepend(
                    `<div class="list-group-item ps-1"><span>${$(this).attr('data-position')} (${$(this).attr('data-industri')})</span><br><small> ${$(this).attr('data-namamhs')} (${$(this).attr('data-nim')})</small></div>`
                    );
            });

            modal.find('form').attr('action', `{{ route('pengajuan_magang.approved') }}`);
            modal.modal('show');
        }

        function batalSR(e) {
            showSweetAlert({
                    title: "Warning",
                    text: "Apakah Anda yakin membatalkan Surat?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Iya, Batalkan Surat",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // btnBlock(e, true);
                        const modal = $('#modal-sr')
                        modal.find('#type').val('batal');
                        modal.find('button[id="batal-button"]').attr('type', 'submit');
                        modal.find('button[id="upload-button"]').attr('type', 'button');
                        modal.find('form').submit();
                        modal.find('#type').val('upload');
                        modal.find('button[id="batal-button"]').attr('type', 'button');
                        modal.find('button[id="upload-button"]').attr('type', 'submit');
                    }
                });
        }

        function approved(e) {
            $('#modalpersetujuanspm').find('#container-list-mhs').prepend(
                `<div class="list-group-item ps-1"><span>${e.attr('data-position')} (${e.attr('data-industri')})</span><br><small> ${e.attr('data-namamhs')} (${e.attr('data-nim')})</small></div>`
                );
            $('#modalpersetujuanspm').modal('show');


            $('#modalpersetujuanspm form').attr('action', `{{ route('pengajuan_magang.approved') }}`);
            $('#modalpersetujuanspm form').prepend('<input type="hidden" name="data_id[]" value="' + e.attr('data-id') +
                '">');
        }

        $('#modalpersetujuanspm').on('hide.bs.modal', function() {
            $(this).find('form').find('input[name="data_id[]"]').remove();
            $(this).find('#container-list-mhs').html(null);
        });

        function afterApprove(response) {
            let modal = $('#modalpersetujuanspm');
            modal.find('form').attr('action', '');
            modal.modal('hide');

            $('input.dt-checkboxes').prop('checked', false);

            settingBadgeCount(response.data);

            $('.table').each(function() {
                $(this).DataTable().ajax.reload(null, false);
            });
        }

        function rejected(e) {
            $('#modalreject').modal('show');
            let url = `{{ route('pengajuan_magang.rejected', ['id' => ':id']) }}`.replace(':id', e.attr('data-id'));
            $('#modalreject form').attr('action', url);
        }

        function afterReject(response) {
            let modal = $('#modalreject');
            modal.find('form').attr('action', '');
            modal.modal('hide');

            settingBadgeCount(response.data);

            $('.table').each(function() {
                $(this).DataTable().ajax.reload();
            });
        }

        function settingBadgeCount(total) {
            if (total > 0) {
                $('#pengajuan_magang_count').html(total);
            } else {
                $('#pengajuan_magang_count').attr('hidden', true);
            }
        }

        $('#upload-sr').on('click', function() {
            let modal = $('#modal-sr');
            let selectedValue = $('#done').find('input.dt-checkboxes:checked');

            if (selectedValue.length == 0) {
                showSweetAlert({
                    title: 'Invalid',
                    text: 'Pilih mahasiswa terlebih dahulu',
                    icon: 'warning'
                });
                return;
            }

            let counter = 1;
            selectedValue.each(function() {
                modal.find('form').prepend('<input type="hidden" name="id_pendaftaran[]" value="' + $(this)
                    .val() + '">');
                modal.find('form').find('#container-list-mhs').append(`
                <p class="mb-1">
                    <span>${counter}.&ensp;${$(this).attr('data-nim')}&ensp;-&ensp;${$(this).attr('data-namamhs')}&ensp;-&ensp;${$(this).attr('data-position')} (${$(this).attr('data-industri')})</span>
                </p>`);
                counter++;
            });

            modal.modal('show');
        });

        $('#modal-sr').on('hide.bs.modal', function() {
            $(this).find('form').find('input[name="id_pendaftaran[]"]').remove();
            $(this).find('form').find('#container-list-mhs').empty();
        });

        function afterActionSR(response) {
            const modal = $("#modal-sr");
            modal.find('#type').val('upload');
            modal.modal("hide");
            btnBlock($('#batal-button'), false)
            $('input.dt-checkboxes').prop('checked', false);
            $('.table').each(function() {
                $(this).DataTable().ajax.reload(null, false);
            });
        }
    </script>
@endsection
