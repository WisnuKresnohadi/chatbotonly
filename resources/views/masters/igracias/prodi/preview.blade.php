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
            background-color: #DCEEE3;
            color: #4ea971;
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
            background-color: #D3D6DB;
            color: #485369;
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

        #table-master-prodi-data-duplikat-tab-preview {
            border-collapse: collapse;
        }

        #table-master-prodi-data-duplikat-tab-preview th,
        #table-master-prodi-data-duplikat-tab-preview td {
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

        /* #table-master-prodi-data-duplikat-tab-preview tbody tr:hover {
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
    <form name="data-import-failed" id="data-import-failed" method="POST" action="{{ route('igracias.prodi.download_failed_data') }}">
        @csrf
        <input type="hidden" name="failedData" id="failedData" value="{{ json_encode($data['failedData']) }}">
    </form>
    <form class="default-form" id="storeImport" name="storeImport" method="POST" action="{{ route('igracias.prodi.store_import') }}" function-callback="afterAction">
        @csrf
        <div class="row">
            <div class="col-md-10 col-12">
                <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> <span
                        class="text-muted fw-light">Matakuliah /</span> Preview</h4>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="d-flex flex-column">
                    <span style="font-size: 1rem; font-weight: 700;">{{ $data['univ']['namauniv'] }}</span>
                    <span> {{ $data['fakultas']['namafakultas'] }}</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button type="button" id="backBtn" class="btn btn-danger waves-effect waves-light">
                        Back
                    </button>
                    <button type="submit" class="btn btn-success waves-effect waves-light">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
        <div class="row mt-2">
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
                <div class="px-3 py-2 mb-3 rounded" style="background-color: #00d1e86f; display: flex; flex-direction: row; align-items: center; width: max-content; gap:1rem;">
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
                        <span style="color:#005b65;" class="text-content-info"></span>
                    </div>

                </div>
                <div class="tab-content" id="myTabContent">

                    {{-- Data Baru Tab --}}
                    <div class="tab-pane fade show active" id="new-data-tab-pane" role="tabpanel"
                        aria-labelledby="new-data-tab" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table-striped border" id="table-master-prodi-data-baru-tab-preview">
                                <thead>
                                    <tr style="text-align: start;">
                                        <th>NO</th>
                                        <th>JENJANG</th>
                                        <th>NAMA PROGRAM STUDI</th>                                                                           
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['newData'] as $index => $prodi)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                {{ $prodi['jenjang'] }}
                                            </td>
                                            <td>
                                                {{ $prodi['namaprodi'] }}
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
                            <table class="table border nowrap" id="table-master-prodi-data-duplikat-tab-preview">
                                <thead>
                                    <tr>
                                        <th colspan="4" class="border-bottom">DATA BARU</th>
                                        <th colspan="3" class="border-start border-bottom">DATA LAMA</th>
                                    </tr>
                                    <tr style="text-align: start; background-color: white;">
                                        <th style="background-color: white;">
                                            <input type="checkbox" name="" id="semuaData">
                                            <label for="semuaData" style="margin-left: 0.5rem; background-color: white;"> Semua Data</label>
                                        </th>
                                        <th style="width: 10rem;">NO</th>                                                                                
                                        <th>JENJANG</th>
                                        <th>NAMA PROGRAM STUDI</th>     
                                        <th class="border-start">JENJANG</th>
                                        <th style="width: 10rem;">NAMA PROGRAM STUDI</th>                                                                                                          
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['duplicatedData'] as $index => $prodi)
                                        @php
                                            $prodiExisting = $prodi['existing'];
                                            $prodiNew = $prodi['new'];
                                        @endphp
                                        <tr>
                                            <td class="border input-check" style="background-color: white"><input
                                                    type="checkbox" name="duplicatedData" id="data{{ $index + 1 }}"
                                                    class="input-check checkbox" value="{{ json_encode($prodiNew) }}">
                                            </td>
                                            <td style="border: 1px solid black">{{ $loop->index + 1 }}</td>
                                            <td class="onNewSame">
                                                {{ $prodiNew['jenjang'] }}
                                            </td>
                                            <td
                                                class="{{ isset($mk['differences']['namaprodi']) ? 'onNewDiff' : 'onNewSame' }}">
                                                {{ $prodiNew['namaprodi'] }}
                                            </td>                                
                                            <td class="onNewSame">
                                                {{ $prodiExisting['jenjang'] }}
                                            </td>
                                            <td
                                                class="{{ isset($mk['differences']['namaprodi']) ? 'onNewDiff' : 'onNewSame' }}">
                                                {{ $prodiExisting['namaprodi'] }}
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
                                <button type="button" onclick="submitDownloadFailedData()"
                                    class="btn btn-success waves-effect waves-light">Download Failed Data</button>
                            </div>
                            <table class="table table-striped border" id="table-master-prodi-data-gagal-tab-preview"
                                style="width: 100%;">
                                <thead>
                                    <tr style="text-align: start;">
                                        <th>NO</th>
                                        <th>JENJANG</th>
                                        <th>NAMA PROGRAM STUDI</th>     
                                        <th>KETERANGAN</th>     
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['failedData'] as $prodiError)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td class="{{ $prodiError['jenjang_error'] ? 'onerror' : 'onsuccess' }}">
                                                @if ($prodiError['jenjang_error'])
                                                    <h6>{{ $prodiError['jenjang_error'] }}</h6>
                                                @else
                                                    {{ $prodiError['jenjang'] }}
                                                @endif
                                            </td>
                                            <td class="{{ $prodiError['namaprodi_error'] ? 'onerror' : 'onsuccess' }}">
                                                @if ($prodiError['namaprodi_error'])
                                                    <h6>{{ $prodiError['namaprodi_error'] }}</h6>
                                                @else
                                                    {{ $prodiError['namaprodi'] }}
                                                @endif
                                            </td>                                                                    
                                            <td class="">
                                                @isset($prodiError['messages'])
                                                    {!! $prodiError['messages'] !!}
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
            
            $('#table-master-prodi-data-baru-tab-preview').DataTable({});

            $('#table-master-prodi-data-duplikat-tab-preview').DataTable({
                fixedColumns: {
                    left: 1
                },
                paging: false,
                // scrollX: true
                // scrollCollapse: true,
                columnDefs: [{
                    orderable: false,
                    targets: 0
                }],
            });
            $('#table-master-prodi-data-gagal-tab-preview').DataTable({});            
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

        // checkboxes.forEach(checkbox => {
        //     checkbox.addEventListener('change', function() {
        //         selectAllCheckbox.checked = Array.from(checkboxes).every(cb => cb.checked);
        //     });
        // });

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
