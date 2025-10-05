@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9 col-12">
            <h4>{{ $view['title'] }}</h4>
        </div>
        <div class="col-md-3 col-12 d-flex justify-content-end align-items-center">
            <select class="select2 form-select" data-placeholder="Pilih Tahun Ajaran" id="tahun_ajaran_filter">
                {!! tahunAjaranMaker() !!}
            </select>
            @if ($view['isLKM'] ?? false)
            <button class="btn btn-primary btn-icon ms-2" data-bs-toggle="offcanvas" data-bs-target="#modalSlide">
                <i class="tf-icons ti ti-filter"></i>
            </button>
            @endif
        </div>
    </div>
    <div class="nav-align-top mt-3">
        <ul class="nav nav-pills" role="tablist">
            @foreach ($view['listTab'] as $item)
                {!! $item !!}
            @endforeach
        </ul>
    </div>
    <div class="tab-content px-0">
        @foreach ($view['listTable'] as $key => $item)
        <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="navs-pills-{{ $item }}" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center my-4">
                <p class="text-secondary">Filter Berdasarkan : <i class='tf-icons ti ti-alert-circle text-primary pb-1'
                    data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-original-title="Jenis Magang: -, Jenjang: -, Program Studi: -, Nama Perusahaan: -, Posisi Magang: -"
                    id="tooltip-filter"></i></p>
                @if (($view['isKaprodi'] ?? false) && $item == 'diterima')
                <button type="button" id="assign-pembimbing" class="btn btn-primary text-white">Assign Dosen Pembimbing Akademik</button>
                @endif
                @if ($view['isLKM'] ?? false)
                @if ($item == 'belum_spm')
                <button type="button" id="upload-spm" class="btn btn-primary text-white">Upload SKM</button>
                @else
                <button id="export_data_{{ $item }}_magang" data-status="{{ $item }}" onclick="exportExcel($(this))" class="btn btn-outline-primary"><i class="ti ti-download"></i>Export Data di {{ $item == 'diterima'? 'Terima Magang' : 'Belum Magang' }}</button>
                @endif
                @endif
            </div>
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="table" id="{{ $item }}">
                        <thead>
                            <tr>
                                @foreach ($view[$item] as $item)
                                {!! $item !!}
                                @endforeach
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if ($view['isKaprodi'] ?? false)
    @include('data_mahasiswa_magang/components/modal')
    @endif
    @if ($view['isLKM'] ?? false)
    @include('data_mahasiswa_magang/components/filter_modal')
    @include('data_mahasiswa_magang/components/modal_lkm')
    @endif
@endsection

@section('page_script')
<script>
    let dataFilter = {};
    //fix datatable when click tab
    $('.nav-link').on('click', function() {
        $('.table').each(function () {
            $(this).DataTable().columns.adjust().draw();
        });7
    });

    function exportExcel(e) {
        // $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Exporting...');

        $.ajax({
            url: '{{ route("data_mahasiswa.terima_magang_export_excel") }}',
            method: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            data:{
                type:e.attr("data-status")
            },
            success: function(data, status, xhr) {
                var filename = "";
                var disposition = xhr.getResponseHeader('Content-Disposition');
                if (disposition && disposition.indexOf('attachment') !== -1) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches != null && matches[1]) {
                        filename = matches[1].replace(/['"]/g, '');
                    }
                }

                if (!filename) {
                    filename = 'pendaftaran_magang_diterima.xlsx';
                }

                var blob = new Blob([data], {type: xhr.getResponseHeader('Content-Type')});
                var url = window.URL.createObjectURL(blob);

                var a = document.createElement('a');
                a.href = url;
                a.download = `${filename}.xlsx`; // Nama file yang diinginkan
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                a.remove();

                // $('#exportButton').prop('disabled', false).html('Export to Excel');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX error:', textStatus, errorThrown);
                alert('Export failed. Please try again.');
                // $('#exportButton').prop('disabled', false).html('Export to Excel');
            }
        });
    }

    $(document).ready(function() {
        // Inisialisasi tabel di awal tanpa filter
        $('.table').each(function () {
            dataFilter['type'] = $(this).attr('id');
            initializeDataTable(); // Inisialisasi tanpa filter
        });

        // Submit form untuk memfilter data
        $('#filter').on('submit', function(e) {
            e.preventDefault(); // Mencegah submit form secara default

            // Ambil nilai filter dari form
            dataFilter = {
                jenis_magang: $('#jenis_magang').val(),
                jenjang: $('#jenjang').val(),
                program_studi: $('#program_studi').val(),
                nama_perusahaan: $('#nama_perusahaan').val(),
                posisi_magang: $('#posisi_magang').val()
            };

            // Refresh semua tabel dengan filter baru
            $('.table').each(function () {
                dataFilter['type'] = $(this).attr('id');
                initializeDataTable(); // Inisialisasi ulang dengan filter
            });
        });
    });

    $('#tahun_ajaran_filter').on('change', function () {
        $('.table').each(function () {
            dataFilter['type'] = $(this).attr('id');
            initializeDataTable(); // Inisialisasi ulang dengan filter
        });
    });

    // Fungsi untuk inisialisasi DataTable
    function initializeDataTable() {
        dataFilter['tahun_ajaran'] = $('#tahun_ajaran_filter').val();
        // Tentukan kolom berdasarkan type
        let columns = {!! $view['columnsDiterima'] !!};

        if (dataFilter['type'] == 'belum_magang') {
            columns = {!! $view['columnsBelumMagang'] !!};
        }
        @if ($view['isLKM'] ?? false)
        else if (dataFilter['type'] == 'belum_spm') {
            columns = {!! $view['columnsBelumSPM'] !!};
        }
        @endif

        // Buat URL dasar dan tambahkan filter jika ada
        let url = `{{ $view['urlGetData'] }}`;

        let attrDatatable = {
            ajax: { 
                url: url, 
                type: 'GET',
                data: dataFilter
            },
            serverSide: false,
            processing: true,
            destroy: true,
            columns: columns,
            ordering: false,
            scrollX: true,
        };
    
        if (dataFilter['type'] != 'belum_magang') {
            attrDatatable["rowGroup"] = {
                dataSrc: 'namaindustri'
            };
        }

        // Konfigurasi tambahan untuk tabel 'diterima' dan 'belum_spm'
        @if ($view['isKaprodi'] ?? false)
        if (dataFilter['type'] == 'diterima') {
            attrDatatable.select = {style: 'multi', selector: 'td:first-child input:checkbox'};
            attrDatatable.columnDefs = [{!! $view['columnDefs'] ?? null !!}];
        }
        @endif

        @if ($view['isLKM'] ?? false)
        if (dataFilter['type'] == 'belum_spm') {
            attrDatatable.select = {style: 'multi', selector: 'td:first-child input:checkbox'};
            attrDatatable.columnDefs = [{!! $view['columnDefs'] ?? null !!}];
        }
        @endif

        // Hapus DataTable lama dan inisialisasi ulang dengan yang baru
        $('#' + dataFilter['type']).DataTable(attrDatatable);
    }

</script>

@if ($view['isLKM'] ?? false)
<script>
    $(document).on('submit', '#filter', function(e) {
        const offcanvasFilter = $('#modalSlide');
        e.preventDefault();
        // $('#tooltip-filter').attr('data-bs-original-title', 'durasimagang: ' + $('#durasimagang :selected').text() + ', posisilowongan: ' + $('#posisi :selected').text() + ', statuslowongan: ' + $('#status :selected').text());
        $('#tooltip-filter').attr('data-bs-original-title', 'Jenis Magang: ' + $('#jenis_magang :selected').text() + ', Jenjang: ' + $('#jenjang :selected').text() + ', Program Studi: ' + $('#program_studi :selected').text() + ', Nama Perusahaan: ' + $('#nama_perusahaan :selected').text() + ', Posisi Magang: ' + $('#posisi_magang :selected').text());
    });

    $('.data-reset').on('click', function() {
        $('#jenis_magang').val(null).trigger('change');
        $('#jenjang').val(null).trigger('change');
        $('#program_studi').val(null).trigger('change');
        $('#nama_perusahaan').val(null).trigger('change');
        $('#posisi_magang').val(null).trigger('change');

        $('#tooltip-filter').attr('data-bs-original-title', 'Jenis Magang: -, Jenjang: -, Program Studi: -, Nama Perusahaan: -, Posisi Magang: -');

        dataFilter = {};

        $('.table').each(function () {
            dataFilter['type'] = $(this).attr('id');
            initializeDataTable(); // Inisialisasi ulang dengan filter
        });
    });

    function getDataSelect(e) {
            // Get the ID of the target element from the 'data-after' attribute of the triggering element
            let idElement = e.attr('data-after');
            // Get the ID of the closest modal to the triggering element
            let modalId = e.closest('.modals').attr('id');

            // Store previously selected dropdown values (if any) into the prevData variable for AJAX request if needed
            let prevData = {};
            $('.select2').each(function() {
                let id = $(this).attr('id');
                if ($(this).val()) prevData[id] = $(this).val();  // Store only if a value is selected
            });

            // Reset the target dropdown: remove existing options except disabled ones and reset the value
            let $targetDropdown = $(`#${modalId} #${idElement}`).val(null).trigger('change');
            $targetDropdown.find('option:not([disabled])').remove();

            // Stop if the initial dropdown has no selected value
            if (e.val() == null) return;

            // Proceed with AJAX request if a value is selected
            $.ajax({
                url: `{{ $urlGetSelect }}`,
                type: 'GET',
                data: {
                    selected: e.val(),          // Selected value from the initial dropdown
                    section: idElement,         // The ID of the target dropdown
                    previous: prevData          // Send previously selected dropdown values
                },
                success: function(response) {
                    // Add new options to the target dropdown
                    $targetDropdown.append(new Option('Semua', 'all'));

                    $.each(response.data, function() {
                        $targetDropdown.append(new Option(this.name, this.id));
                    });

                    // If one or more options are available, automatically select the first option and trigger the 'change' event
                    if ($targetDropdown.find('option:not([disabled])').length >= 1) {
                        $targetDropdown.val($targetDropdown.find('option:not([disabled])').first().val()).trigger('change');
                    }
                }
            }
        );
    }

    $('#upload-spm').on('click', function() {
        let modal = $('#modal-spm');
        let selectedValue = $('input.dt-checkboxes:checked');

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
            modal.find('form').prepend('<input type="hidden" name="id_pendaftaran[]" value="' + $(this).val() + '">');
            modal.find('form').find('#container-list-mhs').append(`
                <p class="mb-1">
                    <span>${counter}.&ensp;${$(this).attr('data-nim')}&ensp;-&ensp;${$(this).attr('data-namamhs')}&ensp;-&ensp;${$(this).attr('data-position')} (${$(this).attr('data-industri')})</span>
                </p>`
            );
            counter++;
        });

        modal.modal('show');
    });

    $('#modal-spm').on('hide.bs.modal', function() {
        $(this).find('form').find('input[name="id_pendaftaran[]"]').remove();
        $(this).find('form').find('#container-list-mhs').empty();
    });

    function afterUpload(response) {
        $("#modal-spm").modal("hide");

        $('input.dt-checkboxes').prop('checked', false);

        $('#data_mahasiswa_count').html(response.data);

        $('.table').each(function () {
            $(this).DataTable().ajax.reload();
        });
    }
</script>
@endif

@if ($view['isKaprodi'] ?? false)
<script>
    $('#assign-pembimbing').on('click', function() {
        let modal = $('#modal-assign');
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
            modal.find('form').prepend('<input type="hidden" name="id_pendaftaran[]" value="' + $(this).val() + '">');
        });

        modal.modal('show');
    });

    $('#modal-assign').on('hide.bs.modal', function() {
        $(this).find('form').find('input[name="id_pendaftaran[]"]').remove();
    });

    function afterAssigning(response) {
        $("#modal-assign").modal("hide");

        $('input.dt-checkboxes').prop('checked', false);

        $('.table').each(function () {
            $(this).DataTable().ajax.reload();
        });
    }
</script>
@endif
@endsection
