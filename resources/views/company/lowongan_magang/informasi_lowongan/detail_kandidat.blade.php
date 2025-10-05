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
    {{-- tombol kembali --}}
    <a href="{{ $urlBack }}" class="mt-2 mb-3 btn btn-outline-primary">
        <i class="ti ti-arrow-left me-2 text-primary"></i>
        Kembali
    </a>
    {{-- multipurpose input :) --}}

    <div class="d-flex justify-content-between">
        <h4 class="fw-bold"><span class="text-muted fw-light">Informasi Lowongan /
            </span>{{ $lowongan->bidangPekerjaanIndustri->namabidangpekerjaan }}</h4>
    </div>

    <div class="col-xl-12">
        <div class="nav-align-top">
            <div class="mb-3 d-flex justify-content-between">
                <div class="border shadow-none card border-secondary">
                    <div class="px-2 py-2 card-body">
                        <div class="d-flex justify-content-center align-items-center">
                            <span class="p-2 badge bg-label-primary me-2">
                                <i class="ti ti-users" style="font-size: 12pt;"></i>
                            </span>
                            <span class="mb-0 me-2">Total Pelamar :</span>
                            <h5 class="mb-0 me-2 text-primary" id="set_total_pelamar">{{ $total_pelamar }}</h5>
                            <span class="mb-0 me-2">Orang</span>
                        </div>
                    </div>
                </div>
                <div class="border shadow-none card border-secondary">
                    <div class="px-3 py-2 card-body d-flex align-items-center">
                        <span class="px-2 my-auto fw-semibold">Batas Konfirmasi&nbsp;:&nbsp;<span
                                id="date_confirm_closing">{!! $date_confirm_closing !!}</span> <a href="#"
                                class="my-auto ms-2" onclick="setDateConfirm();"><i
                                    class="ti ti-edit text-warning"></i></a></span>
                    </div>
                </div>
            </div>
            <ul class="mb-3 nav nav-pills " role="tablist">
                @foreach ($tab as $key => $item)
                    <li class="nav-item" style="font-size: small;">
                        <button type="button" class="{{ $loop->first ? 'active' : '' }} nav-link"
                            id="{{ $key }}-tab" target="2" role="tab" data-bs-toggle="tab"
                            data-bs-target="#{{ $key }}" aria-controls="{{ $key }}" aria-selected="false"
                            style="padding: 8px 9px;">
                            <i class="tf-icons {{ $item['icon'] }} ti-xs me-1"></i>
                            {{ $item['label'] }}
                            <span class="badge rounded-pill bg-label-primary badge-center h-px-20 w-px-20 ms-1"
                                id="total_{{ $item['table'] }}">
                                0
                            </span>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="p-0 tab-content">
            @foreach ($tab as $key => $item)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $key }}"
                    role="tabpanel">
                    @if ($key == 'tahap' || $key == 'seleksi')
                        <div class="d-flex justify-content-center alert-cant-approve">
                            @include('company/lowongan_magang/components/card_alert', [
                                'kuota' => $lowongan->kuota,
                                'kuota_penawaran_full' => $kuota_penawaran_full,
                            ])
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-datatable table-responsive">
                            @if ($key == 'tahap')
                                <div class="m-4 d-flex justify-content-between">
                                    <div class="col-2" id="container-filter-seleksi">
                                        <select class="form-select select2" id="filter_seleksi"
                                            onchange="changeSeleksiTable($(this).val())">
                                            <option value="all_seleksi">Semua Tahap</option>
                                            @foreach ($item['tahap_valid'] as $d)
                                                <option value="{{ $d['table'] }}">{{ $d['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button class="btn btn-primary text-start" data-bs-target="#modal-send-email"
                                        data-bs-toggle="modal">
                                        <i class="ti ti-mail me-2"></i>
                                        Kirim Email
                                    </button>
                                </div>
                            @endif
                            @if ($key == 'seleksi')
                                <div style="display: flex; flex-direction: column; gap: 2rem; margin: 1.3rem;">
                                    <div class="gap-3 px-3 rounded d-flex align-items-center mb-n2"
                                        style="height: 4rem; background-color: rgba(1, 155, 175, 1); color: #fff;">
                                        <i class="ti ti-info-circle fs-3"></i>
                                        <div>
                                            <span class="fs-5 fw-semibold">Panduan</span>
                                            <p class="mb-0 fs-6">Centang pada checkbox digunakan untuk mengirim email kepada
                                                calon kandidat.</p>
                                        </div>
                                    </div>
                                    <div style="display: flex; gap: 1rem;">
                                        <button class="btn btn-primary waves-effect waves-light"
                                            onclick="btnSeleksi($(this))" data-status="approved" data-last='1'>Kirim Penawaran</button>
                                        <button class="btn btn-danger waves-effect waves-light"
                                            onclick="btnSeleksi($(this))" data-status="rejected">Eleminasi Kandidat</button>
                                    </div>
                                </div>
                            @endif
                            <table
                                class="table table-seleksi table-striped @if ($key == 'tahap') tahap-table @endif"
                                id="{{ $item['table'] }}" style="width: 100%;">
                                <thead>
                                    <tr>
                                        @if ($key == 'seleksi')
                                            <th></th>
                                        @endif
                                        <th>NOMOR</th>
                                        @if ($key == 'penawaran')
                                            <th class="text-center">STATUS</th>
                                        @endif
                                        @if ($key == 'seleksi')
                                            <th>SKOR</th>
                                        @endif
                                        <th>NAMA</th>
                                        <th>KONTAK</th>
                                        <th>UNIVERSITAS</th>
                                        {{-- <th>PROGRAM STUDI</th> --}}
                                        <th class="text-center">Tanggal Daftar</th>
                                        {{-- <th class="text-center">Tanggal Seleksi</th> --}}
                                        <th>Surat Pengantar Magang</th>
                                        @if ($key == 'diterima' || $key == 'penawaran')
                                            <th class="text-center">Dokumen</th>
                                        @endif
                                        <th class="text-center">AKSI</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @include('company/lowongan_magang/components/modal_detail_pelamar')
        @include('company/lowongan_magang/informasi_lowongan/modal')

    </div>
@endsection

@section('page_script')
    <script>
        $(document).ready(function() {
            $('#container-filter-seleksi .select2-container--default .select2-selection').css({
                'border': '3px solid var(--bs-primary)',
                'border-radius': '0.375rem',
                'background-color': '#fff'
            });
            $(`#container-filter-seleksi .select2-container--default.select2-container--focus 
        .select2-selection, 
        .select2-container--default.select2-container--open 
        .select2-selection`).css({
                'border-color': 'var(--bs-primary)'
            });

            loadPage();
            loadData();
            changeSeleksiTable($('#filter_seleksi').val());
        });

        function loadPage() {
            let currentUrl = new URL(window.location.href);

            let tab = currentUrl.searchParams.get("tab");
            let select = currentUrl.searchParams.get("select");

            if (tab != null || select != null) {
                if (tab != null) $('#' + tab + '-tab').tab('show');
                if (select != null) {
                    $('#filter_seleksi option:selected').removeAttr('selected');
                    $('#filter_seleksi').find('option[value="' + select + '"]').attr('selected', 'selected');
                    $('#filter_seleksi').parents('#container-filter-seleksi').find('#select2-filter_seleksi-container')
                        .text($('#filter_seleksi option:selected').text());
                }

                currentUrl.searchParams.delete("tab");
                currentUrl.searchParams.delete("select");

                window.history.replaceState({}, document.title, currentUrl.pathname);
            }
        }

        $(".flatpickr-date-custom").flatpickr({
            enableTime: true,
            altInput: true,
            altFormat: 'j F Y, H:i',
            dateFormat: 'Y-m-d H:i'
        });

        let dtProp = {
            scrollX: true,
            serverSide: false,
            processing: true,
            deferRender: true,
            destroy: true,
        };

        function columns(tableClass) {
            let columns = [{
                    data: "DT_RowIndex"
                },
                {
                    data: "current_step"
                },
                {
                    data: "namamhs",
                    render: function(data, type, row, meta) {
                        let result = '<div class="d-flex flex-column align-items-start">';
                        result += '<span class="fw-semibold text-nowrap">' + row.namamhs + '</span>';
                        result += '<span class="text-nowrap">' + row.namaprodi + '</span>';
                        result += '</div>';
                        return result;
                    }
                },
                {
                    data: "nohpmhs"
                },
                {
                    data: "namauniv"
                },
                {
                    data: "tanggaldaftar"
                },
                {
                    data: "dokumen_spm"
                },
                {
                    data: "action"
                },
            ]
            if(tableClass == 'kandidat_pelamar') {
                columns.splice(1, 1);
            }
            if (tableClass == 'seleksi') {
                columns.splice(1, 1);

                columns.splice(1, 0, {
                    data: "score"
                });

                columns.unshift({
                    data: null
                })
            }
            if (tableClass == 'penawaran') {
                columns.splice(columns.length - 1, 0, {
                    data: "dokumen_skm"
                })
            }
            return columns
        }

        function getOptionsDataTable(tableId) {
            const options = {
                ajax: {
                    url: "{{ $urlGetData }}",
                    type: 'GET',
                    data: function(d) {
                        d['type'] = tableId;
                        if (tableId == 'penawaran') {
                            d['filter_seleksi'] = $('#filter-seleksi').val();
                        }
                    }
                },
                ...dtProp,
                drawCallback: function(settings, json) {
                    let total = this.api().data().count();
                    $('#total_' + tableId).text(total);
                    $(`#${tableId} tbody tr td`).css('padding', '1.4rem');
                },
                columns: columns(tableId),
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('data-href',
                        '{{ route('informasi_lowongan.detail_kandidat', ':id') }}'.replace(
                            ':id', data.id_pendaftaran));
                    const exceptColumn = [0, 1, 6, 7, 8];
                    $(row).children('td').each(function(index) {
                        if (!exceptColumn.includes(index)) {
                            $(this).css('cursor', 'pointer');
                            $(this).on('click', function() {
                                window.location = $(row).data('href');
                            });
                        }
                    });
                },
            };

            let columnDefs = [];
            if (tableId == "seleksi") {
                const select = {
                    style: 'multi',
                    selector: 'td:first-child input:checkbox'
                };

                columnDefs.push({
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    className: 'dt-checkboxes-cell',
                    render: function(data, type, row, meta) {
                        return `<input type='checkbox' class='dt-checkboxes form-check-input'  data-namamhs='` +
                            row
                            .namamhs + `' data-nim='` + row.nim + `' value='` + row.id_pendaftaran + `'>`;
                    },
                    checkboxes: {
                        selectRow: false,
                        selectAllRender: `<input type='checkbox' class='form-check-input'>`
                    }
                });

                options.select = select;
            }

            options.columnDefs = columnDefs;

            return options
        }

        function loadData() {
            $('.table-seleksi').each(function() {
                const tableId = $(this).attr('id');
                if ($(this).hasClass('tahap-table')) return;

                $(this).DataTable(getOptionsDataTable(tableId));

                var divElement = document.getElementById('penawaran_filter');

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

                    var options = [{
                            value: 'all',
                            text: 'Semua Data'
                        },
                        {
                            value: 'approved_seleksi_tahap_1',
                            text: 'Penawaran'
                        },
                        {
                            value: 'approved_penawaran',
                            text: 'Diambil'
                        },
                        {
                            value: 'rejected_penawaran',
                            text: 'Diabaikan'
                        },
                        {
                            value: 'rejected_seleksi_tahap_1',
                            text: 'Ditolak'
                        }
                    ];

                    options.forEach(function(optionData) {
                        var option = document.createElement('option');
                        option.value = optionData.value;
                        option.textContent = optionData.text;
                        selectElement.appendChild(option);
                    });

                    divElement.appendChild(selectElement);
                    initSelect2();
                }
            });
        }

        function changeSeleksiTable(table) {

            $('.tahap-table').prop('id', table);

            $('.tahap-table').DataTable().destroy();

            $('.tahap-table').DataTable({
                ajax: {
                    url: "{{ $urlGetData }}",
                    type: 'GET',
                    data: {
                        type: table
                    }
                },
                ...dtProp,
                drawCallback: function(settings, json) {
                    total = this.api().data().count();
                    $('#total_all_seleksi').text(total);
                },
                columns: columns(table)
            });
        }

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
        });

        function detailInfo(e) {
            let offcanvas = $('#detail_pelamar_offcanvas');
            offcanvas.offcanvas('show');
            btnBlock(offcanvas);

            $.ajax({
                url: "{{ $urlDetailPelamar }}",
                type: "GET",
                data: {
                    section: 'get_detail_mhs',
                    data_id: e.attr('data-id')
                },
                success: function(response) {
                    btnBlock(offcanvas, false);
                    response = response.data;
                    let url = `{{ route('informasi_lowongan.show_cv', ['nim' => ':nim']) }}`.replace(':nim',
                        response.nim);
                    $('#detail_pelamar_offcanvas').find('#btn_unduh_cv').attr('href', url);
                    $('#container_detail_pelamar').html(response.view);
                }
            });
        }

        $('#detail_pelamar_offcanvas').on('hidden.bs.offcanvas', function() {
            $('#container_detail_pelamar').html(null);
            $('#detail_pelamar_offcanvas').find('#btn_unduh_cv').attr('href', '');
            Swal.close();
        });

        function changeStatus(e = null) {
            if (e != null && ((e.attr('data-status') == "approved" && e.attr('data-last') == "1") || e.attr(
                    'data-status') == "rejected")) {
                let modal = $('#modal-upload-file');
                let form = modal.find('form');

                if (e.attr('data-status') == "approved" && e.attr('data-last') == "1") modal.find('.modal-title').text(
                    'Berkas Penerimaan');
                else if (e.attr('data-status') == "rejected") modal.find('.modal-title').text('Berkas Penolakan');

                // form.attr('action', "{{ route('informasi_lowongan.update_status') }}");
                form.prepend('<input type="hidden" name="id_pendaftaran[]" value="' + e.attr('data-id') + '">');
                form.prepend('<input type="hidden" name="status" value="' + e.attr('data-status') + '">');
                modal.modal('show');
            } else {
                btnBlock(e, true)
                $.ajax({
                    url: "{{ route('informasi_lowongan.update_status') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: 'approved',
                        id_pendaftaran: e.attr('data-id')
                    },
                    success: function(response) {
                        btnBlock(e, false)
                        $('#detail_pelamar_offcanvas .btn-close').click();
                        $('.table-seleksi').each(function() {
                            $(this).DataTable().ajax.reload();
                        });

                        if (response.data.counter != undefined && response.data.counter != 0) {
                            $('#informasi_lowongan_count').text(response.data.counter);
                            $('.informasi_lowongan_count').text(response.data.counter);
                        } else {
                            $('#informasi_lowongan_count').text(null);
                            $('.informasi_lowongan_count').text(null);
                        }
                        setTimeout(() => {
                            showSweetAlert({
                                title: response?.data?.title ?? 'Berhasil!',
                                text: response.message,
                                icon: response?.data?.icon ?? 'success',
                            });
                        }, 400);
                    },
                    error: function(xhr, status, error) {
                        btnBlock(e, false)
                        let response = xhr.responseJSON;
                        showSweetAlert({
                            title: 'Gagal!',
                            text: response.message,
                            icon: 'error'
                        });

                        if (response.data.view_alert != undefined) {
                            $('.alert-cant-approve').html(response.data.view_alert);
                        }
                    }
                });
            }
        }

        function afterUploadBerkas(response) {
            response = response.data;
            $('.alert-cant-approve').html(response.view_alert);

            $('.table-seleksi').each(function() {
                $(this).DataTable().ajax.reload();
            });

            $('#modal-upload-file').modal('hide');
            $('#detail_pelamar_offcanvas').offcanvas('hide');
        }

        $('#modal-upload-file').on("hide.bs.modal", function() {
            $('#container-list-mhs').html(null).parent().hide();
            $(this).find('form').trigger('reset');
            $(this).find('form').find('input[name="id_pendaftaran[]"]').remove();
            $(this).find('form').find('input[name="status"]').remove();
        });

        $('modal-send-email').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
            getKandidat(null);
        });

        function btnSeleksi(e) {
            let modal = $('#modal-upload-file');
            let selectedValue = $('input.dt-checkboxes:checked');

            if (selectedValue.length == 0) {
                showSweetAlert({
                    title: 'Invalid',
                    text: 'Pilih mahasiswa terlebih dahulu',
                    icon: 'warning'
                });
                return;
            }

            swalConfirmStatus(e, function() {
                if (e.attr('data-status') == "approved" && e.attr('data-last') == "1") modal.find('.modal-title').text('Berkas Penerimaan');
                else if (e.attr('data-status') == "rejected") modal.find('.modal-title').text('Berkas Penolakan');

                let counter = 1;
                const form = modal.find('form');
                selectedValue.each(function() {
                    form.prepend('<input type="hidden" name="id_pendaftaran[]" value="' + $(
                            this)
                        .val() + '">');
                    form.prepend('<input type="hidden" name="status" value="' + e.attr(
                        'data-status') + '">');
                    form.find('#container-list-mhs').append(`
                <p class="mb-1">
                    <span>${counter}.&ensp;${$(this).attr('data-nim')}&ensp;-&ensp;${$(this).attr('data-namamhs')}&ensp;-&ensp;</span>
                </p>`);
                    counter++;
                });

                $('#container-list-mhs').parent().show();
                modal.modal('show');
            })
        }

        function swalConfirmStatus(e, cb = null) {
            title = (e.attr('data-status') == 'approved') ? 'Yakin untuk meloloskan kandidat?' :
                'Yakin untuk menggagalkan kandidat ke tahap selanjutnya?';
            confirmButtonText = (e.attr('data-status') == 'approved') ? 'Lolos' : 'Gagal';
            customClassConfirm = (e.attr('data-status') == 'approved') ? 'btn btn-success me-2' : 'btn btn-danger me-2';
            customClassCancel = (e.attr('data-status') == 'approved') ? 'btn btn-danger' : 'btn btn-success';
            sweetAlertConfirm({
                title: title,
                text: 'Pastikan periksa kembali profile kandidat ',
                icon: 'warning',
                confirmButtonText: confirmButtonText,
                cancelButtonText: 'Batal',
                customClassConfirm: customClassConfirm,
                customClassCancel: customClassCancel,
            }, function() {
                if (cb) cb()
                else changeStatus(e);
            });
        }

        function emailSent(e) {

            $('#modal-sent-email').modal('show');
            $.ajax({
                url: `{{ $urlDetailPelamar }}`,
                type: 'GET',
                data: {
                    section: 'get_email_sent',
                    data_id: e.attr('data-id')
                },
                success: function(res) {
                    $.each(res.data, function(key, value) {
                        $('#container-list-sent-email').append(`<tr>
                        <td style="text-align: center;">${(key+1)}</td>
                        <td>${value.subject}</td>
                    </tr>`);
                    });
                }
            });
        }

        $('#modal-sent-email').on('hidden.bs.modal', function() {
            $(this).find('#container-list-sent-email').html(null);
        });

        function getKandidat(e = null) {
            if (e.val() == null) {
                $('#kandidat').html('<option disabled selected class="mt-1 text-danger">Pilih Kandidat</option>');
                $('#kandidat').prop('disabled', true);
                $('#mulai_date').val('');
                $('#selesai_date').val('');
                $('#pilih-semua').prop('checked', false);
                $('#pilih-semua').parent('.form-check').hide();
                $('#pilih-semua-label').html('');
                $('#mulai_date').flatpickr({
                    enableTime: true,
                    altInput: true,
                    altFormat: 'j F Y, H:i',
                    dateFormat: 'Y-m-d H:i',
                });
                $('#selesai_date').flatpickr({
                    enableTime: true,
                    altInput: true,
                    altFormat: 'j F Y, H:i',
                    dateFormat: 'Y-m-d H:i',
                });
                return;
            }
            let tahap = e.find(':selected').attr('data-status');
            $.ajax({
                url: "{{ route('informasi_lowongan.get_kandidat', ['tahap' => ':tahap']) }}".replace(':tahap',
                    tahap),
                type: "GET",
                data: {
                    id_lowongan: "{{ $lowongan->id_lowongan }}",
                    tahapan_seleksi: e.val()
                },
                success: function(response) {
                    response = response.data;
                    $('#kandidat').empty();
                    $('#kandidat').prop('disabled', false);
                    $('#kandidat').append('<option value="">Pilih Kandidat</option>');
                    $.each(response, function(index, value) {
                        $('#kandidat').append('<option value="' + index + '">' + value + '</option>');
                    });
                    total = $('#kandidat').find('option').length - 1;
                    $('#pilih-semua-label').html(e.find(':selected').text() + " <span class='text-primary'>(" +
                        total + " Kandidat)</span>");
                    $('#pilih-semua').parent('.form-check').show();

                }
            });
        }

        function afterSetConfirmClosing(response) {
            $('#date_confirm_closing').html(`<span class="text-primary">${response.data} Hari Setelah Penerimaan</span>`);
            $('#modal-set-batas-confirm').modal('hide');
        }

        function setDateConfirm() {
            let modal = $('#modal-set-batas-confirm');
            let url = `{{ route('informasi_lowongan.set_confirm_closing', ['id' => $lowongan->id_lowongan]) }}`;

            modal.find('form').attr('action', url);
            modal.modal('show');

            $.ajax({
                url: `{{ route('informasi_lowongan.detail', ['id' => $lowongan->id_lowongan]) }}`,
                type: `GET`,
                data: {
                    section: 'get_data_date'
                },
                success: function(res) {
                    modal.find('input[name="date"]').val(res.data);
                }
            });
        }

        $('#modal-set-batas-confirm').on("hide.bs.modal", function() {
            $(this).find('form').attr('action', '#');
        });

        $('#pilih-semua').on('click', function() {
            if ($(this).is(':checked')) {
                $('#kandidat').find('option').prop('selected', true).change();
                $('#kandidat').find('option').eq(0).prop('selected', false).change();
            } else {
                $('#kandidat').find('option').prop('selected', false).change();
            }

        });

        function afterSetJadwal(response) {
            $('#modal-send-email').modal('hide');
            $('.table-seleksi').each(function() {
                $(this).DataTable().ajax.reload();
            });
        }

        $('#mulai_date').on('change', function() {
            $('#selesai_date').flatpickr({
                enableTime: true,
                altInput: true,
                altFormat: 'j F Y, H:i',
                dateFormat: 'Y-m-d H:i',
                minDate: $('#mulai_date').val(),
            });
        });

        $('#selesai_date').on('change', function() {
            $('#mulai_date').flatpickr({
                enableTime: true,
                altInput: true,
                altFormat: 'j F Y, H:i',
                dateFormat: 'Y-m-d H:i',
                maxDate: $('#selesai_date').val(),
            });
        });
    </script>
@endsection
