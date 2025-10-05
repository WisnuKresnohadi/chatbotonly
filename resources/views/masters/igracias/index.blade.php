@extends('partials.vertical_menu')

@section('meta_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_style')
    <style>
        .capitalize-title {
            text-transform: capitalize;
        }

        .tooltip .tooltip-inner {
            max-width: 800px !important;
        }

        .batch-progress {
            padding-left: 0.75rem;
            /* px-3 */
            padding-right: 0.75rem;
            /* px-3 */
            padding-top: 0.5rem;
            /* pt-2 */
            padding-bottom: 0.75rem;
            /* pb-3 */
            margin-bottom: 0.75rem
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-12">
            <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Igracias</h4>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="nav-align-top">
            <div class="d-flex justify-content-between w-100">
                <ul class="mb-3 nav nav-pills " role="tablist">
                    @foreach (['dosen', 'mata_kuliah', 'mahasiswa', 'program_studi'] as $key => $item)
                        <li class="nav-item">
                            <button type="button" class="nav-link {{ $key == 0 ? 'active' : '' }}" role="tab"
                                data-bs-toggle="tab" disabled data-bs-target="#navs-pills-justified-{{ $item }}"
                                aria-controls="navs-pills-justified-{{ $item }}" aria-selected="true">
                                @php
                                    $displayText = str_replace('_', ' ', $item);
                                    $displayText = ucwords($displayText);
                                @endphp
                                {{ $displayText }}
                            </button>
                        </li>
                    @endforeach
                </ul>
                <div class="justify-content-end d-flex" style="gap: 2rem">
                    {{-- batch-progress --}}
                    <div class="border batch-progress rounded-3" style="display: none">
                        <p class="m-0 mb-2 text-info-progress">Progress Sinkronisasi</p>
                        <div class="border progress rounded-3" style="width: 400px">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0"
                                aria-valuemax="100">0%</div>
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-success waves-effect waves-light" data-bs-toggle="offcanvas"
                            data-bs-target="#modalSlide"> <i class="tf-icons ti ti-filter"></i></button>
                    </div>
                </div>
            </div>
            <div class="pt-3 tab-content pe-2">
                <div class="mt-2 col-md-12 d-flex justify-content-between align-content-center"
                    style="padding-right: 1rem;">
                    <p class="text-secondary">Filter Berdasarkan : <i class='tf-icons ti ti-alert-circle text-primary'
                            data-bs-toggle="tooltip" data-bs-placement="right"
                            data-bs-original-title="Universitas : -, Fakultas : -, Prodi : -" id="tooltip-filter"></i></p>
                    <div class="gap-3 btn-group">
                        <button type="button"
                            class="btn btn-success tambah-dropdown-toggle dropdown-toggle waves-effect waves-light"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Kelola Dosen
                        </button>
                        <ul class="dropdown-menu" style="">
                            <li>
                                <a class="dropdown-item btn text-success d-block pe-15" data-type="import"
                                    onclick="btnExcel($(this))">
                                    <i class="ti ti-upload me-2"></i>
                                    Import Excel
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item btn text-success d-block pe-15" data-type="export"
                                    onclick="btnExcel($(this))">
                                    <i class="ti ti-file-spreadsheet me-2"></i>
                                    Export Excel
                                </a>
                            </li>
                            <li>
                                <button class="btn-sync dropdown-item btn text-secondary d-block pe-15"
                                    data-type="syncronize" style="box-shadow: none" disabled onclick="btnExcel($(this))">
                                    <i class="ti ti-refresh me-2"></i>
                                    Sinkronisasi Data
                                </button>
                            </li>
                            <li class="btn-sync-nilai" style="display: none">
                                <button class="dropdown-item btn text-secondary d-block pe-15" data-type="syncronize-nilai"
                                    style="box-shadow: none" disabled onclick="btnExcel($(this))" data-bs-toggle="modal"
                                    data-bs-target="#modal-syncronize">
                                    <i class="ti ti-refresh me-2"></i>
                                    Sinkronisasi Data Nilai
                                </button>
                            </li>
                            {{-- <li>
                                <a class="dropdown-item btn text-success d-block pe-15" data-bs-toggle="modal"
                                    data-bs-target="#modal-dosen">
                                    <i class="ti ti-plus me-2"></i>
                                    Kelola Dosen
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                </div>
                @foreach (['dosen', 'mata_kuliah', 'mahasiswa', 'program_studi'] as $key => $item)
                    <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}"
                        id="navs-pills-justified-{{ $item }}" role="tabpanel">
                        <div class="card-datatable table-responsive">
                            <table class="table"
                                id="{{ str_contains($item, '_') ? str_replace('_', '-', $item) : $item }}">
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
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal -->

    @include('masters.igracias.dosen.modal')
    @include('masters.igracias.mata-kuliah.modal')
    @include('masters.igracias.mahasiswa.modal')
    @include('masters.igracias.modal')
    @include('masters.igracias.slide_filter')
@endsection

@section('page_script')
    <script>
        let buttonText = 'Dosen';
        let lowerCaseButtonText = 'dosen';
        let modalTarget = `"#modal-${lowerCaseButtonText}"`
        let tabs = ['dosen', 'mata-kuliah', 'mahasiswa', 'program-studi']
        tabs = Object.fromEntries(
            tabs.map((key, index) => [
                key,
                {
                    id_univ: '',
                    id_fakultas: '',
                    id_prodi: '',
                    isInitial: index === 0
                }
            ])
        );
        let syncName = '';

        $(document).ready(function() {
            checkBatchProgress();
            loadData(lowerCaseButtonText);
            updateProgressSmoothly(10);
            $('button.nav-link').removeAttr('disabled');
        });

        const progressBar = document.querySelector('.progress-bar');
        let batchInterval = setInterval(checkBatchProgress, 3000);
        let smoothInterval;
        let idleInterval;
        // const syncOptions = {
        //     batchInterval: setInterval(checkBatchProgress, 3000),
        //     smoothInterval: '',
        //     idleInterval: ''
        // }

        // Add this variable to track the highest progress value seen so far
        let highestProgressSeen = 0;

        function syncAll() {
            sweetAlertConfirm({
                title: 'Apakah anda yakin ingin melakukan sinkronisasi?',
                text: 'Sinkronisasi akan memakan waktu panjang tergantung jumlah data yang akan disinkronkan.',
                icon: 'warning',
                confirmButtonText: 'Ya, saya yakin!',
                cancelButtonText: 'Batal'
            }, function() {
                $.ajax({
                    url: "{{ route('igracias.sync_all') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (!response.error) {                            
                            showSweetAlert({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success'
                            });
                            checkBatchProgress();
                        } else {
                            showSweetAlert({
                                title: 'Gagal!',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        let res = xhr.responseJSON;
                        showSweetAlert({
                            title: 'Gagal!',
                            text: res.message,
                            icon: 'error'
                        });
                    }
                });
            });
        }

        function checkBatchProgress() {
            fetch('/master/igracias/sync-active-batch')
                .then(response => response.json())
                .then(data => {
                    const progress = data?.batch?.progress ?? null;
                    const pendingJobs = data?.batch?.pendingJobs ?? null;
                    const finishedAt = data?.batch?.finishedAt ?? null;
                    const cancelledAt = data?.batch?.cancelledAt ?? null;
                    const checkError = data?.batch?.error ?? false;
                    const currentSyncName = data?.batch?.syncName ?? '';

                    if (data?.batch?.isRead || data.batchId == null) {
                        enableSyncButtons();
                        $('.text-info-progress').text('Progress Sinkronisasi')
                        $('.batch-progress').hide(); // Hide the progress bar when no active batch
                        // Reset the highest progress when no active batch
                        highestProgressSeen = 0;
                        clearInterval(batchInterval);
                        return;
                    } else {
                        $('.text-info-progress').text('Progress Sinkronisasi ' + currentSyncName)
                    }

                    // Show progress bar for any active batch
                    $('.batch-progress').show();

                    // Handle batch completion
                    if ((pendingJobs == 0 && finishedAt) || cancelledAt) {
                        // Stop polling for updates
                        clearInterval(batchInterval);
                        batchInterval = null;

                        if (checkError) {
                            // Handle error case
                            $('.batch-progress').hide();
                            enableSyncButtons();
                            progressBar.style.width = '0%';
                            progressBar.setAttribute('aria-valuenow', 0);
                            progressBar.textContent = '0%';
                            highestProgressSeen = 0; // Reset highest progress

                            if (!data.batch.isRead) {
                                showSweetAlert({
                                    title: 'error',
                                    text: data.batch.message || 'Sinkronisasi gagal',
                                    icon: 'error',
                                    showConfirmButton: true
                                });
                            }
                        } else {
                            // Always go to 100% on completion
                            highestProgressSeen = 100; // Force highest to 100%
                            updateProgressSmoothly(100, () => {
                                setTimeout(() => {
                                    if (!data?.batch?.isRead) {
                                        showSweetAlert({
                                            title: 'success',
                                            text: `Sinkronisasi ${currentSyncName} berhasil.`,
                                            icon: 'success',
                                            showConfirmButton: true
                                        });
                                    }
                                    $('.batch-progress').hide();
                                    enableSyncButtons();

                                    // Reset progress bar after hiding
                                    progressBar.style.width = '0%';
                                    progressBar.setAttribute('aria-valuenow', 0);
                                    progressBar.textContent = '0%';
                                    highestProgressSeen = 0; // Reset highest progress

                                    // Refresh the table data
                                    const tableId = currentSyncName.toLowerCase().replace(/\s+/g, '-');
                                    $('#' + tableId).DataTable().ajax.reload(null, false);
                                }, 1000);
                            });
                        }
                        return;
                    }

                    // Handle progress update for ongoing batch
                    if (progress !== null) {
                        // Set minimum progress to 10%
                        const displayProgress = Math.max(10, progress);
                        // Use the higher value between current progress and highest seen so far
                        const targetProgress = Math.max(displayProgress, highestProgressSeen);
                        // Update the highest progress seen
                        highestProgressSeen = targetProgress;
                        updateProgressSmoothly(targetProgress);
                    } else if (pendingJobs > 0) {
                        // If we have pending jobs but no progress, ensure we're at least at 10%
                        const targetProgress = Math.max(10, highestProgressSeen);
                        highestProgressSeen = targetProgress;
                        updateProgressSmoothly(targetProgress);
                    }
                })
                .catch(error => {
                    console.error('Error fetching batch progress:', error)
                    // If fetch fails, don't leave the UI stuck
                    enableSyncButtons();
                });
        }

        function updateProgressSmoothly(targetProgress, onComplete = null) {
            // Clear any existing interval to prevent conflicts
            if (smoothInterval) {
                clearInterval(smoothInterval);
                smoothInterval = null;
            }

            let currentProgress = parseInt(progressBar.getAttribute('aria-valuenow')) || 0;

            // Never go backward in progress
            if (targetProgress < currentProgress && targetProgress < 100) {
                console.log(`Preventing backward progress: target ${targetProgress}% < current ${currentProgress}%`);
                if (onComplete) onComplete();
                return;
            }

            // If we're already at target, just call completion handler
            if (currentProgress >= targetProgress && targetProgress < 100) {
                progressBar.style.width = targetProgress + '%';
                progressBar.setAttribute('aria-valuenow', targetProgress);
                progressBar.textContent = targetProgress + '%';
                if (onComplete) onComplete();
                return;
            }

            // Calculate step size - faster for completion
            let step = targetProgress === 100 ? 5 : 2;

            smoothInterval = setInterval(() => {
                if (currentProgress >= targetProgress) {
                    clearInterval(smoothInterval);
                    smoothInterval = null;

                    // Ensure we're exactly at target value
                    progressBar.style.width = targetProgress + '%';
                    progressBar.setAttribute('aria-valuenow', targetProgress);
                    progressBar.textContent = targetProgress + '%';

                    if (onComplete) onComplete();
                } else {
                    currentProgress += step;
                    progressBar.style.width = currentProgress + '%';
                    progressBar.setAttribute('aria-valuenow', currentProgress);
                    progressBar.textContent = currentProgress + '%';
                }
            }, 50);
        }

        function toggleSyncButtons(isEnabled, ...selectors) {
            selectors.forEach(selector => {
                document.querySelectorAll(selector).forEach(element => {
                    // If the selector is a <li>, find the button inside
                    const button = element.tagName === "BUTTON" ? element : element.querySelector("button");
                    if (!button) return; // Skip if no button found

                    button.disabled = !isEnabled;
                    button.classList.toggle("text-success", isEnabled);
                    button.classList.toggle("text-secondary", !isEnabled);
                });
            });
        }

        function enableSyncButtons() {
            toggleSyncButtons(true, ".btn-sync", ".btn-sync-nilai");
            // toggleSyncButtons(true, ".btn-sync");
        }

        function disableSyncButtons() {
            toggleSyncButtons(false, ".btn-sync");
        }

        function clearAllIntervals() {
            if (idleInterval) {
                clearTimeout(idleInterval);
                idleInterval = null;
            }
            if (smoothInterval) {
                clearInterval(smoothInterval);
                smoothInterval = null;
            }
            if (batchInterval) {
                clearInterval(batchInterval);
                batchInterval = null;
            }
        }

        function afterActionSync() {
            // Clear any existing intervals first
            clearAllIntervals();

            disableSyncButtons();
            $('#modal-index').modal('hide');

            // Reset progress tracking
            highestProgressSeen = 10;

            // Reset progress UI
            progressBar.style.width = '10%';
            progressBar.setAttribute('aria-valuenow', 10);
            progressBar.textContent = '10%';

            // Show progress container
            $('.batch-progress').show();

            // Start checking for progress updates
            batchInterval = setInterval(checkBatchProgress, 3000);
        }

        function getDataSelect(e) {
            if (e.val() == null) return;

            let idElement = e.attr('data-after');
            idElement = idElement.split('|');
            let modalId = e.closest('.modals').attr('id');

            idElement.forEach(element => {
                $(`#${modalId} #${element}`).find('option:not([disabled])').remove();
                $(`#${modalId} #${element}`).val(null).trigger('change');

                $.ajax({
                    url: `{{ route('igracias') }}?type=${element}&selected=` + e.val(),
                    type: 'GET',
                    success: function(response) {
                        $.each(response.data, function() {
                            $(`#${modalId} #${element}`).append(new Option(this.text, this.id));
                        });
                    }
                });
            });
        }

        function getRoute(resource, action, id = null) {
            if (resource == 'program-studi') resource = 'prodi';
            let baseUrl = `${window.location.origin}/master/igracias/${resource}/${action}`;
            return id ? `${baseUrl}/${id}` : baseUrl;
        }

        function getTableColumn() {
            switch (lowerCaseButtonText) {
                case 'dosen':
                    return {!! $view['columnsDosen'] !!};
                    break;
                case 'mata-kuliah':
                    return {!! $view['columnsMataKuliah'] !!};
                    break;
                case 'mahasiswa':
                    return {!! $view['columnsMahasiswa'] !!};
                    break;
                case 'program-studi':
                    return {!! $view['columnsProdi'] !!};
                    break;
                default:
                    console.error('type not valid');
                    break;
            }
        }

        function loadData(tab = null) {
            let columns = [];
            let url = '';

            columns = getTableColumn();
            url = getRoute(tab, 'show');

            let table = $('#' + tab).DataTable({
                ajax: {
                    url: url,
                    type: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    data: function(d) {
                        const frm_data = $('#filter').serializeArray();
                        $.each(frm_data, function(key, val) {
                            d[val.name] = val.value;
                        });
                    }
                },
                drawCallback: function(settings) {
                    initTooltips();
                },
                serverSide: true,
                processing: true,
                deferRender: true,
                destroy: true,
                scrollX: true,
                columns: columns
            });
        }

        function AfterActionImport() {
            setTimeout(() => {
                const url = getRoute(lowerCaseButtonText, 'preview');
                location = url
            }, 1500);
        }

        function afterAction() {
            $('#modal-index').modal('hide');
        }

        function edit(e) {
            let id = e.attr('data-id');
            let action = getRoute(lowerCaseButtonText, 'update', id);
            let url = getRoute(lowerCaseButtonText, 'edit', id);

            let modal = $(`#modal-${lowerCaseButtonText}`);
            let form = modal.find('form');

            modal.find(".modal-title").html(`Edit ${lowerCaseButtonText.replace(/-/g, ' ')}`);
            form.find('button[type="submit"]').html("Update Data")
            form.attr('action', action);
            modal.modal('show');

            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    const responseKeys = response.data ? response.data : response
                    $.each(responseKeys, function(key, value) {
                        let element = form.find(`[name="${key}"]`);
                        if (element.is('select') && element.find('option').length <= 1) {
                            let interval = setInterval(() => {
                                if (element.children('option').length > 1) {
                                    element.val(value).trigger('change');
                                    clearInterval(interval);
                                }
                            }, 100);
                        } else if (element.is('[type="radio"]')) {
                            $(`[name="${key}"][value="${value}"]`).prop("checked", true);
                        } else {
                            element.val(value).trigger('change');
                        }
                    });
                }
            });
        }

        function toUpper(str) {
            return str
                .toLowerCase()
                .split(' ')
                .map(function(word) {
                    return word[0].toUpperCase() + word.substr(1);
                })
                .join(' ');
        }

        function afterUpdateStatus(response) {
            sinkronisasiData();
        }

        function sinkronisasiData() {
            $('#' + lowerCaseButtonText).DataTable().ajax.reload();
        }

        function afterAction(response) {
            $(`#modal-${lowerCaseButtonText}, #modal-index`).modal('hide');
            afterUpdateStatus(response);
        }

        Object.keys(tabs).forEach((item) => {
            if ($("#modal-" + item).length == 0) return;
            $("#modal-" + item).on("hide.bs.modal", function() {
                $(this).find("#modal-title").html(`Kelola ${lowerCaseButtonText.replace(/-/g, ' ')}`);
                $(this).find("#modal-button").html(`Simpan`);

                let action = getRoute(lowerCaseButtonText, 'store');
                $(this).find('form').attr('action', action);
                $(this).find('form').find(
                    '[name="id_fakultas"], [name="id_prodi"], [name="kode_dosen_wali"]').each(
                    function() {
                        $(this).val(null).trigger('change');
                        $(this).find('option:not([disabled])').remove();
                    });
            });
        })

        function handleTabClick(tabName) {
            if (!tabs[tabName].isInitial) {
                tabs[tabName].isInitial = true;
                loadData(tabName);
            }
        }

        function resetFilter() {
            $('#modalSlide select[name*="id_univ"]').val('').trigger('change');
            $('#modalSlide select[name*="id_fakultas"]').find('option:not([disabled])').remove()
            $('#modalSlide select[name*="id_prodi"]').find('option:not([disabled])').remove()
        }

        function asset(path) {
            return `${window.location.origin}/template-excel/${path}`;
        }

        function btnExcel(btn) {
            const type = btn.attr('data-type')
            const modal = $('#modal-index');
            $(`#modal-index #modal-title`).html(`${toUpper(type.replace(/[_-]+/g, ' '))} ${buttonText}`)

            const action = getRoute(lowerCaseButtonText, type);
            let assetTemplate = '';
            let afterAction = '';

            $(`#modal-index #kode_dosen_wali`).parent().parent().hide()
            switch (type) {
                case "export":
                    $(`#modal-index #container-template-excel`).hide();
                    $(`#modal-index #upload-file-excel`).hide();
                    afterAction = 'afterAction';
                    break;
                case "syncronize":
                case "syncronize-nilai":
                    $(`#modal-index #container-template-excel`).hide();
                    $(`#modal-index #upload-file-excel`).hide();
                    afterAction = 'afterActionSync';
                    break;
                case "import":
                    $(`#modal-index #container-template-excel`).show()
                    $(`#modal-index #upload-file-excel`).show()
                    afterAction = 'AfterActionImport';
                    switch (lowerCaseButtonText) {
                        case 'dosen':
                            assetTemplate = asset('Template_Import_Dosen.xlsx');
                            break;
                        case 'mahasiswa':
                            assetTemplate = asset('Template_Import_Mahasiswa.xlsx');
                            $('.btn-sync-nilai').show()
                            $(`#modal-index #kode_dosen_wali`).parent().parent().show()
                            break;
                        case 'mata-kuliah':
                            assetTemplate = asset('Template_Import_Matakuliah.xlsx');
                            break;
                        case 'program-studi':
                            assetTemplate = asset('Template_Import_Prodi.xlsx');
                            break;
                    }
                    break;
            }
            modal.find('form').attr('action', action);
            if (type === "export") {
                modal.find('form').removeClass('default-form')
                $('#buttonExcel').attr('type', `button`)
                $('#buttonExcel').attr('onclick', "exportData($(this))")
            } else {
                modal.find('form').addClass('default-form')
                $('#buttonExcel').attr('type', `submit`)
                $('#buttonExcel').attr('onclick', "")
            }
            modal.find('form').attr('function-callback', afterAction);
            $('#modal-index #download-template').attr('href', assetTemplate);
            modal.modal('show');
        }

        function exportData(e) {
            btnBlock(e);
            const formElement = $('#modal-index').find('form')[0];
            const action = $('#modal-index').find('form').attr('action')
            const formData = new FormData(formElement);
            $.ajax({
                url: action,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(data, status, xhr) {
                    btnBlock(e, false);
                    var filename = "";
                    var disposition = xhr.getResponseHeader('Content-Disposition');
                    if (disposition && disposition.indexOf('attachment') !== -1) {
                        var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                        var matches = filenameRegex.exec(disposition);
                        if (matches != null && matches[1]) {
                            filename = matches[1].replace(/['"]/g, '');
                        }

                        var blob = new Blob([data], {
                            type: xhr.getResponseHeader('Content-Type')
                        });
                        var url = window.URL.createObjectURL(blob);

                        var a = document.createElement('a');
                        a.href = url;
                        a.download = `${filename}.xlsx`;
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        a.remove();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    btnBlock(e, false);
                    if (jqXHR.status === 400) {
                        showSweetAlert({
                            title: 'Gagal!',
                            text: `Data ${lowerCaseButtonText} ${($('#modal-index #id_prodi option:selected').text()).toLowerCase()} tidak tersedia`,
                            icon: 'error'
                        });
                    } else if (jqXHR.status == 422) {
                        showSweetAlert({
                            title: 'Gagal!',
                            text: "Mohon isi inputan terlebih dahulu!",
                            icon: 'error'
                        });
                    } else {
                        let errorMessage = "Terjadi masalah dengan koneksi atau server.";
                        if (jqXHR.status) {
                            errorMessage = `Error ${jqXHR.status}: ${jqXHR.statusText}`;
                        }

                        showSweetAlert({
                            title: 'Gagal!',
                            text: errorMessage,
                            icon: 'error'
                        });
                    }
                }
            });
        }

        function updateTooltip() {
            const activeTab = lowerCaseButtonText;

            const univText = 'Universitas: ' + ((tabs[activeTab]?.id_univ?.value ? tabs[activeTab].id_univ
                .text : '-') || '-');
            const fakultasText = ', Fakultas: ' + ((tabs[activeTab]?.id_fakultas?.value ? tabs[activeTab]
                .id_fakultas.text : '-') || '-');
            const prodiText = lowerCaseButtonText === "program-studi" ?
                '' :
                ', Prodi: ' + ((tabs[activeTab]?.id_prodi?.value ? tabs[activeTab].id_prodi.text : '-') ||
                    '-');

            $('#tooltip-filter').attr('data-bs-original-title',
                univText +
                fakultasText +
                prodiText
            );
        }

        function onChangeTab(e) {
            buttonText = $(e).text().trim();
            lowerCaseButtonText = buttonText.toLowerCase().replace(/\s+/g, '-');
            $('.btn-sync-nilai').hide();
            if (lowerCaseButtonText == 'mahasiswa') $('.btn-sync-nilai').show();

            $('a[data-type="export"]').removeClass('d-none');
            $('a[data-type="import"]').removeClass('d-none');
            $(`#modal-index #id_prodi`).parent().parent().show();
            switch (lowerCaseButtonText) {
                case 'mata-kuliah':
                    $('a[data-type="export"]').addClass('d-none');
                    $('a[data-type="import"]').addClass('d-none');
                    assetTemplate = asset('Template_Import_Matakuliah.xlsx');
                    break;
                case 'program-studi':
                    assetTemplate = asset('Template_Import_Prodi.xlsx');
                    $('a[data-type="export"]').addClass('d-none');
                    $(`#modal-index #id_prodi`).parent().parent().hide()
                    break;
            }

            $(`a[data-bs-target=${modalTarget}]`).attr('data-bs-target', `#modal-${lowerCaseButtonText}`)
            modalTarget = `'#modal-${lowerCaseButtonText}'`
            $('.tambah-dropdown-toggle').text(`Kelola ${buttonText}`);
            const dropDownBtn = $(`a[data-bs-target=${modalTarget}]`);
            dropDownBtn.html(`<i class="ti ti-plus me-2"></i>Kelola ${buttonText}`);
        }

        $(document).on('click', '.data-reset', function(e) {
            e.preventDefault();
            resetFilter();
        });

        $(document).on('submit', '#filter', function(e) {
            const offcanvasFilter = $('#modalSlide');
            const activeTab = lowerCaseButtonText;
            e.preventDefault();

            sinkronisasiData();
            tabs[activeTab].id_univ = {
                value: $(this).find('select[name*="id_univ"]').val(),
                text: $(this).find('select[name*="id_univ"] :selected').text()
            };

            tabs[activeTab].id_fakultas = {
                value: $(this).find('select[name*="id_fakultas"]').val(),
                text: $(this).find('select[name*="id_fakultas"] :selected').text()
            };

            tabs[activeTab].id_prodi = {
                value: $(this).find('select[name*="id_prodi"]').val(),
                text: $(this).find('select[name*="id_prodi"] :selected').text()
            };
            updateTooltip();
            offcanvasFilter.offcanvas('hide');
        });

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            resetFilter();
            onChangeTab(this);
            handleTabClick(lowerCaseButtonText);
            updateTooltip();

            $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
        });
    </script>
@endsection
