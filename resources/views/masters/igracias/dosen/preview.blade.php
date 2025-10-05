@extends('partials.vertical_menu')
@section('page_style')
    <style>
        .bg-dark-green {
            background-color: #89C6A0;
        }

        .border .input-check input:checked {
            color: #89C6A0;
        }

        .onerror {
            background-color: #ec7474 !important;
        }

        .onerror h6 {
            color: white !important;
            margin: 0px auto
        }

        .onsuccess {
            background-color: white;
        }

        .onExistingDiff {
            background-color: #B6BAC3 !important;
        }

        .onExistingSame {
            background-color: #DBDADE !important;
        }

        .onNewDiff {
            background-color: #89C6A0 !important;
        }

        .onNewSame {
            background-color: #C4E2D0 !important;
        }

        #tab .nav-tabs {
            background-color: transparent;
            margin-bottom: 2rem;
            border: none;
        }

        #myTab .active {
            background-color: #4ea971;
            color: white;
            border: 1px solid #4ea971;
            box-shadow: 0;
        }

        #myTab .active .text-no {
            background-color: #FCEDDB;
            color: #B57A40;
            border-radius: 100%;
            box-shadow: 0;
            width: 1.5rem;
            height: 1.5rem;
            margin-left: 0.7rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #myTab .text-no {
            background-color: #C4E2D0;
            color: #28C76F;
            border-radius: 100%;
            box-shadow: 0;
            width: 1.5rem;
            height: 1.5rem;
            margin-left: 0.7rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #tab .nav-tabs .nav-link .active {
            box-shadow: 0 -2px 0 #4ea971 insert
        }

        #tab .nav-tabs .nav-link .active {
            box-shadow: 0 -2px 0 transparent inset;
        }

        #myTab .nav-item {
            border: none;
            outline: none;
            margin-bottom: 1rem;
        }

        #myTab .nav-link,
        #myTab .nav-item {
            border: none;
            outline: none;
        }

        #myTab .nav-link:hover {
            color: #4ea971;
            background-color: rgba(0, 0, 0, 0.079);
        }

        #tab .nav-tabs .nav-link .active:hover {
            color: white;
        }

        #myTab .active:hover {
            background-color: #4ea971;
            color: white;
            /* border: 1px solid #4ea971; */
            /* border-radius: 10%; */
            box-shadow: 0;
        }

        table {
            position: relative;
        }

        .no {
            position: sticky;
            left: 0;
        }

        .input-check {
            position: sticky;
            left: 0;
        }

        #table-master-dosen-data-duplikat-baru-tab-preview {
            border-collapse: collapse;
        }

        #table-master-dosen-data-duplikat-baru-tab-preview th,
        #table-master-dosen-data-duplikat-baru-tab-preview td {
            border: none;
            box-shadow: none;
        }

        table.dataTable thead > tr > th{
            background-color: white;
            z-index: 1;
        }

        table.dataTable thead > tr > th.sorting{
            background-color: white;
            position: static;
            padding: 0.5rem;
        }

        table.dataTable thead > tr > th.sorting::after{
            display: flex;
            justify-content: end;
            position: static;
            right: 0%;
            bottom: 0%;
            width: 100%;
            height: 100%;
        }

        table.dataTable thead > tr > th.sorting::before{
            display: flex;
            justify-content: end;
            position: static;
            right: 0%;
            bottom: 0%;
            width: 100%;
            height: 100%;
        }

        /* #table-master-dosen-data-duplikat-baru-tab-preview tbody tr:hover {
                                            background-color: #C0C3C7;
                                        } */
/*
        .nav ~ .tab-content{
            background-color: transparent;
        } */

        .tab-content{
            padding-right: 1.5rem;
            padding-left: 1.5rem;
            padding-top: 0.8rem;
            padding-bottom: 0.8rem;
        }
        .tooltip-inner {
            background-color: #485369;
            opacity: 1 !important;
        }
    </style>
@endsection
@section('content')
    <form name="data-import-failed" id="data-import-failed" method="POST" action="{{ route('igracias.dosen.download_failed_data') }}">
        @csrf
        <input type="hidden" name="failedData" id="failedData" value="{{ json_encode($data['failedData']) }}">
    </form>
    <form class="default-form" id="storeImport" name="storeImport" method="POST" action="{{ route('igracias.dosen.store_import') }}" function-callback="afterAction">
        @csrf
        <div class="row">
            <div class="col-md-10 col-12">
                <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> <span
                        class="text-muted fw-light">Dosen /</span> Preview</h4>
            </div>
            <div class="mt-4 d-flex justify-content-between">
                {{-- <h6>{{ $data['univ']['namauniv'] }}, {{ $data['fakultas']['namafakultas'] }},
                    {{ $data['prodi']['namaprodi'] }},</h6> --}}
                <div class="d-flex flex-column">
                    <span style="font-size: 1rem; font-weight: 700;">{{ $data['univ']['namauniv'] }}</span>
                    <span> {{ $data['fakultas']['namafakultas'] }} - {{ $data['prodi']['namaprodi'] }}</span>
                </div>
                <div class="gap-3 d-flex align-items-center">
                    <button type="button" id="backBtn" class="btn btn-danger waves-effect waves-light">
                        Back
                    </button>
                    <button type="submit" class="btn btn-success waves-effect waves-light">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
        <div class="mt-2 row">
            <div class="col-12" id="tab">
                <ul class="nav nav-pills" id="myTab" role="tablist" style="display: flex; gap: 0.5rem;">
                    <li class="nav-item" role="presentation"
                        style="width: 15rem; display: flex; align-items: center; gap: 0.5rem;">
                        <button class="nav-link active" id="new-data-tab" data-bs-toggle="pill"
                            data-bs-target="#new-data-tab-pane" type="button" role="tab"
                            aria-controls="new-data-tab-pane" aria-selected="true">
                            <span  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Data Baru" style="display: flex; flex-direction: row; align-items: center;">
                                Data Baru
                                <span class="bg-no text-no">{{ count($data['newData']) }}</span>
                            </span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation"
                        style="width: 15rem; display: flex; align-items: center;  gap: 0.5rem;">
                        <button class="nav-link" id="duplicate-data-tab" data-bs-toggle="pill"
                            data-bs-target="#duplicate-data-tab-pane" type="button" role="tab"
                            aria-controls="duplicate-data-tab-pane" aria-selected="false">
                            <span  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Data Duplikat"  style="display: flex; flex-direction: row; align-items: center;">
                                Periksa Data Duplikat
                                <span class="text-no">{{ count($data['duplicatedData']) }}</span>
                            </span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation"
                        style="width: 15rem; display: flex; align-items: center; gap: 0.5rem;">
                        <button class="nav-link" id="failed-data-tab" data-bs-toggle="pill"
                            data-bs-target="#failed-data-tab-pane" type="button" role="tab"
                            aria-controls="failed-data-tab-pane" aria-selected="false">
                            <span  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Data Gagal"  style="display: flex; flex-direction: row; align-items: center;">
                            Data Gagal
                            <span class="text-no">{{ count($data['failedData']) }}</span>
                            </span>
                        </button>
                    </li>
                </ul>
                <div class="px-3 py-2 mb-3 rounded" style="background-color: #00d1e86f; display: flex; flex-direction: row; align-items: center; gap:1rem;">
                    <div>
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12.5" cy="12" r="9" stroke="#005b65" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12.4989 8H12.5089" stroke="#005b65" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M11.5 12H12.5V16H13.5" stroke="#005b65" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    </div>
                    <div class="d-flex flex-column">
                        <span style="color:#005b65; font-weight: 600;">Panduan</span>
                        <span style="color:#005b65;text-wrap:wrap" class="text-content-info"></span>
                    </div>
                </div>
                <div class="tab-content" id="myTabContent">

                    {{-- Data Baru Tab --}}
                    <div class="tab-pane fade show active" id="new-data-tab-pane" role="tabpanel"
                        aria-labelledby="new-data-tab" tabindex="0">
                        <div class="table-responsive">
                            <table class="table border table-striped" id="table-master-dosen-data-baru-tab-preview">
                                <thead>
                                    <tr style="text-align: start;">
                                        <th>NO</th>
                                        <th>NIP</th>
                                        <th>KODEDOSEN</th>
                                        <th>NAMA DOSEN</th>
                                        <th>KONTAK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['newData'] as $index => $dosen)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                {{ $dosen['nip'] }}
                                            </td>
                                            <td>
                                                {{ $dosen['kode_dosen'] }}
                                            </td>
                                            <td>
                                                {{ $dosen['namadosen'] }}
                                            </td>
                                            <td>
                                                <span class='mb-2 fw-bolder'>{{ $dosen['nohpdosen'] }}</span><br>
                                                <small class=''>{{ $dosen['emaildosen'] }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Data Duplikat Tab --}}
                    <div class="tab-pane fade" id="duplicate-data-tab-pane" role="tabpanel"
                        aria-labelledby="duplicate-data-tab" tabindex="0">
                        <div class="rounded table-responsive d-flex flex-column">
                            <input type="hidden" name="newData" id="newData"
                                value="{{ json_encode($data['newData']) }}">
                            <input type="hidden" name="univ" id="univ" value="{{ $data['univ']['id_univ'] }}">
                            <input type="hidden" name="fakultas" id="fakultas"
                                value="{{ $data['fakultas']['id_fakultas'] }}">
                            <input type="hidden" name="prodi" id="prodi"
                                value="{{ $data['prodi']['id_prodi'] }}">
                            <table class="table border nowrap" id="table-master-dosen-data-duplikat-baru-tab-preview">
                                <thead>
                                    <tr>
                                        <th colspan="6" class="border-bottom">DATA BARU</th>
                                        <th colspan="6" class="border-start border-bottom">DATA LAMA</th>
                                    </tr>
                                    <tr style="text-align: start; background-color: white;">
                                        <th style="background-color: white;">
                                            <input type="checkbox" name="" id="semuaData" class="ml-3">
                                            <label for="semuaData" style="margin-left: 0.5rem; background-color: white;">
                                                <svg style="margin-bottom: 0.5rem;"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Semua Data" width="25" height="24" viewBox="0 0 25 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="12.5" cy="12" r="9" stroke="#4EA971" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M12.4989 8H12.5089" stroke="#4EA971" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M11.5 12H12.5V16H13.5" stroke="#4EA971" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </label>
                                        </th>
                                        <th style="width: 10rem;">NO</th>
                                        <th>NIP</th>
                                        <th>KODE DOSEN</th>
                                        <th>NAMA DOSEN</th>
                                        <th>KONTAK</th>
                                        <th class="border-start">NIP</th>
                                        <th style="width: 20rem;">KODE DOSEN</th>
                                        <th>NAMA DOSEN</th>
                                        <th>KONTAK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['duplicatedData'] as $index => $dosen)
                                        @php
                                            $dosenExisting = $dosen['existing'];
                                            $dosenNew = $dosen['new'];
                                        @endphp
                                        <tr>
                                            <td class="border input-check" style="background-color: white">
                                                <input
                                                    type="checkbox" name="duplicatedData[]" id="data{{ $index + 1 }}"
                                                    class="input-check checkbox" value="{{ json_encode($dosenNew) }}">
                                            </td>
                                            <td style="border: 1px solid black">{{ $loop->index + 1 }}</td>
                                            <td class="onNewSame">
                                                {{ $dosenNew['nip'] }}
                                            </td>
                                            <td
                                                class="{{ isset($dosen['differences']['kode_dosen']) ? 'onNewDiff' : 'onNewSame' }}">
                                                {{ $dosenNew['kode_dosen'] }}
                                            </td>
                                            <td
                                                class="{{ isset($dosen['differences']['namadosen']) ? 'onNewDiff' : 'onNewSame' }}">
                                                {{ $dosenNew['namadosen'] }}
                                            </td>
                                            <td
                                                class="{{ isset($dosen['differences']['nohpdosen']) || isset($dosen['differences']['emaildosen']) ? 'onNewDiff' : 'onNewSame' }}">
                                                <span class='mb-2 fw-bolder'>{{ $dosenNew['nohpdosen'] }}</span><br>
                                                <small class=''>{{ $dosenNew['emaildosen'] }}</small>
                                            </td>
                                            <td class="onNewSame">
                                                {{ $dosenExisting['nip'] }}
                                            </td>
                                            <td
                                                class="{{ isset($dosen['differences']['kode_dosen']) ? 'onNewDiff' : 'onNewSame' }}">
                                                {{ $dosenExisting['kode_dosen'] }}
                                            </td>
                                            <td
                                                class="{{ isset($dosen['differences']['namadosen']) ? 'onNewDiff' : 'onNewSame' }}">
                                                {{ $dosenExisting['namadosen'] }}
                                            </td>
                                            <td
                                                class="{{ isset($dosen['differences']['nohpdosen']) || isset($dosen['differences']['emaildosen']) ? 'onNewDiff' : 'onNewSame' }}">
                                                <span class='mb-2 fw-bolder'>{{ $dosenExisting['nohpdosen'] }}</span><br>
                                                <small class=''>{{ $dosenExisting['emaildosen'] }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Data Failed Tab --}}
                    <div class="tab-pane fade" id="failed-data-tab-pane" role="tabpanel"
                        aria-labelledby="failed-data-tab" tabindex="0" style="width: 100%;">
                        <div class="card-datatable table-responsive" style="width: 100%;">
                            <div style="display: flex; justify-content: flex-end;">
                                <button type="button" onclick="submitDownloadFailedData()" {{ count($data['failedData']) < 1 ? "disabled" : ""}}
                                    class="btn btn-success waves-effect waves-light">Download Failed Data</button>
                            </div>
                            <table class="table border table-striped" id="table-master-dosen-data-gagal-tab-preview"
                                style="width: 100%;">
                                <thead>
                                    <tr style="text-align: start;">
                                        <th>NO</th>
                                        <th>NIP</th>
                                        <th>KODE DOSEN</th>
                                        <th>NAMA DOSEN</th>
                                        <th>KONTAK</th>
                                        <th>KETERANGAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['failedData'] as $dosenError)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td class="{{ $dosenError['nip_error'] ? 'onerror' : 'onsuccess' }}">
                                                @if ($dosenError['nip_error'])
                                                    <h6>{{ $dosenError['nip_error'] }}</h6>
                                                @else
                                                    {{ $dosenError['nip'] }}
                                                @endif
                                            </td>
                                            <td class="{{ $dosenError['kode_dosen_error'] ? 'onerror' : 'onsuccess' }}">
                                                @if ($dosenError['kode_dosen_error'])
                                                    <h6>{{ $dosenError['kode_dosen_error'] }}</h6>
                                                @else
                                                    {{ $dosenError['kode_dosen'] }}
                                                @endif
                                            </td>
                                            <td class="{{ $dosenError['namadosen_error'] ? 'onerror' : 'onsuccess' }}">
                                                @if ($dosenError['namadosen_error'])
                                                    <h6>{{ $dosenError['namadosen_error'] }}</h6>
                                                @else
                                                    {{ $dosenError['namadosen'] }}
                                                @endif
                                            </td>
                                            <td
                                            class="{{ $dosenError['nohpdosen_error'] || $dosenError['emaildosen_error'] ? 'onerror' : 'onsuccess' }}">
                                            @if ($dosenError['nohpdosen_error'] || $dosenError['emaildosen_error'])
                                                <h6 class="py-2">{{ $dosenError['nohpdosen_error'] ? $dosenError['nohpdosen_error'] : $dosenError['nohpdosen'] }}</h6>
                                                <h6 class="pb-2">{{ $dosenError['emaildosen_error'] && !($dosenError['emaildosen_error'] == $dosenError['nohpdosen_error']) ? $dosenError['emaildosen_error'] : $dosenError['emaildosen'] }}</h6>
                                                @else
                                                    <span class='mb-2 fw-bolder'>{{ $dosenError['nohpdosen'] }}</span><br>
                                                    <small class=''>{{ $dosenError['emaildosen'] }}</small>
                                                    <br>
                                                @endif
                                            </td>
                                            <td class="">
                                                @isset($dosenError['messages'])
                                                    {!! $dosenError['messages'] !!}
                                                @endisset
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@section('page_script')
    <script>
        $(document).ready(function() {
            $('#table-master-dosen-data-baru-tab-preview').DataTable({
            });
            $('#table-master-dosen-data-duplikat-baru-tab-preview').DataTable({
            });
            $('#table-master-dosen-data-gagal-tab-preview').DataTable({
            });
            $('#backBtn').click(function(e) {
                e.preventDefault();
                showSweetAlert({
                    title: "Warning",
                    text: "Apakah Anda yakin ingin kembali?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Back",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('igracias') }}";
                    }
                });
            });
        });

        function submitDownloadFailedData() {
            const form = document.getElementById('data-import-failed');
            if (form) {
                form.submit();
            } else {
                console.error('Form not found');
            }
        }
        const selectAllCheckbox = document.getElementById('semuaData');
        const checkboxes = document.querySelectorAll('.checkbox');

        selectAllCheckbox.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                selectAllCheckbox.checked = Array.from(checkboxes).every(cb => cb.checked);
            });
        });

        const $infoTextElement = $('.text-content-info');

        function updateInfoText(tabId) {
            switch(tabId) {
                case 'new-data-tab':
                    $infoTextElement.text("Data baru adalah data bersih yang nantinya akan disimpan ke dalam sistem");
                    break;
                case 'duplicate-data-tab':
                    $infoTextElement.text("Dengan mencentang checkbox, nantinya akan mengganti data lama (data yang telah disimpan di sistem) dengan yang baru (data yang saat ini sedang diimport)");
                    break;
                case 'failed-data-tab':
                    $infoTextElement.text("Data gagal adalah data yang nantinya tidak akan disimpan ke dalam sistem, dan perlu untuk diperbaiki dahulu");
                    break;
                default:
                    $infoTextElement.text("");
            }
        }

        // Set initial text based on active tab
        updateInfoText($('.nav-link.active').attr('id'));

        // Update text when tab changes
        $('button[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {
            updateInfoText($(e.target).attr('id'));
        });

        function afterAction() {
            setTimeout(() => {
                location = '{{ route('igracias') }}'
            }, 1500);
        }
    </script>
@endsection
@endsection
