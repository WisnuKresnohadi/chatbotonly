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

        /* #myTab .active .text-no {
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
        } */
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

        #table-master-mahasiswa-data-duplikat-baru-tab-preview {
            border-collapse: collapse;
        }

        #table-master-mahasiswa-data-duplikat-baru-tab-preview th,
        #table-master-mahasiswa-data-duplikat-baru-tab-preview td {
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

        /* #table-master-mahasiswa-data-duplikat-baru-tab-preview tbody tr:hover {
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
        /* table.dataTable thead > tr > th.sorting, table.dataTable thead > tr > th.sorting_asc, table.dataTable thead > tr > th.sorting_desc, table.dataTable thead > tr > th.sorting_asc_disabled, table.dataTable thead > tr > th.sorting_desc_disabled, table.dataTable thead > tr > td.sorting, table.dataTable thead > tr > td.sorting_asc, table.dataTable thead > tr > td.sorting_desc, table.dataTable thead > tr > td.sorting_asc_disabled, table.dataTable thead > tr > td.sorting_desc_disabled{
            position: static;
        } */
        /* #table-master-mahasiswa-data-duplikat-baru-tab-preview tbody tr:hover {
                                            background-color: #C0C3C7;
                                        } */
    </style>
@endsection
@section('content')
    <form name="data-import-failed" id="data-import-failed" method="POST"
        action="{{ route('igracias.mahasiswa.download_failed_data') }}">
        @csrf
        <input type="hidden" name="failedData" id="failedData" value="{{ json_encode($data['failedData']) }}">
    </form>
    <form class="default-form" id="storeImport" name="storeImport" method="POST"
        action="{{ route('igracias.mahasiswa.store_import') }}" function-callback="afterAction">
        @csrf
        <div class="row">
            <div class="col-md-10 col-12">
                <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> <span
                        class="text-muted fw-light">Mahasiswa /</span> Preview</h4>
            </div>
            <div class="mt-4 d-flex justify-content-between">
                <div class="d-flex flex-column">
                    <span style="font-size: 1rem; font-weight: 700;">{{ $data['fakultas']['namafakultas'] }} - {{ $data['prodi']['namaprodi'] }}</span>
                    <span>Dosen : {{ $data['dosen_wali']['namadosen'] }}</span>
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
                            <span  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Data Duplikat" style="display: flex; flex-direction: row; align-items: center;">
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
                            <span  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Data Gagal" style="display: flex; flex-direction: row; align-items: center;">
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
                        <div class="card-datatable table-responsive">
                            <table class="table border table-striped" id="table-master-mahasiswa-data-baru-tab-preview">
                                <thead>
                                    <tr style="text-align: start;">
                                        <th>NO</th>
                                        <th>NAMA/NIM</th>
                                        <th>TUNGGAKAN BPP</th>
                                        <th>IPK</th>
                                        <th>EPRT</th>
                                        <th>TAK</th>
                                        <th>ANGKATAN</th>
                                        <th>KONTAK</th>
                                        <th>ALAMAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['newData'] as $index => $mhs)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <span style="font-weight: 800;">
                                                    {{ $mhs['namamhs'] }}
                                                </span>
                                                <br>
                                                {{ $mhs['nim'] }}
                                            </td>
                                            <td>
                                                {{ $mhs['tunggakan_bpp'] }}
                                            </td>
                                            <td>
                                                {{ $mhs['ipk'] }}
                                            </td>
                                            <td>
                                                {{ $mhs['tesbahasa'] }}
                                            </td>
                                            <td>
                                                {{ $mhs['tak'] }}
                                            </td>
                                            <td>
                                                {{ $mhs['angkatan'] }}
                                            </td>
                                            <td>
                                                <span style="font-weight: 800;">
                                                    {{ $mhs['nohpmhs'] }}
                                                </span>
                                                <br>
                                                {{ $mhs['emailmhs'] }}
                                            </td>
                                            <td>
                                                {{ $mhs['alamatmhs'] }}
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
                        <div class="card-datatable table-responsive d-flex flex-column">
                            <input type="hidden" name="newData" id="newData"
                                value="{{ json_encode($data['newData']) }}">
                            <input type="hidden" name="univ" id="univ" value="{{ $data['univ']['id_univ'] }}">
                            <input type="hidden" name="fakultas" id="fakultas"
                                value="{{ $data['fakultas']['id_fakultas'] }}">
                            <input type="hidden" name="prodi" id="prodi" value="{{ $data['prodi']['id_prodi'] }}">
                            <input type="hidden" name="dosen_wali" id="dosen_wali"
                                value="{{ $data['dosen_wali']['kode_dosen'] }}">
                            <div>
                                {{-- <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12.5" cy="12" r="9" stroke="#4EA971" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12.4989 8H12.5089" stroke="#4EA971" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M11.5 12H12.5V16H13.5" stroke="#4EA971" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg> --}}

                            </div>
                            <table class="table border nowrap" id="table-master-mahasiswa-data-duplikat-baru-tab-preview">
                                <thead>
                                    <tr>
                                        <th colspan="9" class="border-bottom">DATA BARU</th>
                                        <th colspan="7" class="border-start border-bottom">DATA LAMA</th>
                                    </tr>
                                    <tr style="text-align: start;">
                                        <th style="background-color: white; width: 100%;">
                                            <input type="checkbox" name="" id="semuaData" class="mr-3">
                                            <label style="margin-bottom: 0.5rem;" for="semuaData" style="background-color: white;">
                                                <svg data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Semua Data" width="25" height="24" viewBox="0 0 25 24" fill="none"
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
                                        <th style="width: 100rem;">NO</th>
                                        <th>NAMA/NIM</th>
                                        <th>IPK</th>
                                        <th>EPRT</th>
                                        <th>TAK</th>
                                        <th>ANGKATAN</th>
                                        <th>KONTAK</th>
                                        <th>ALAMAT</th>
                                        <th class="border-start">NAMA/NIM</th>
                                        <th>IPK</th>
                                        <th>EPRT</th>
                                        <th>TAK</th>
                                        <th>ANGKATAN</th>
                                        <th>KONTAK</th>
                                        <th>ALAMAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['duplicatedData'] as $index => $mhs)
                                        @php
                                            $mhsExisting = $mhs['existing'];
                                            $mhsNew = $mhs['new'];
                                        @endphp
                                        <tr>
                                            <td class="border input-check" style="background-color: white"><input
                                                    type="checkbox" name="duplicatedData[]" id="data{{ $index + 1 }}"
                                                    class="input-check checkbox" value="{{ json_encode($mhsNew) }}"></td>
                                            <td style="border: 1px solid black">{{ $loop->index + 1 }}</td>
                                            <td
                                                class="{{ isset($mhs['differences']['namamhs']) ? 'onNewDiff' : 'onNewSame' }}">
                                                <span class='mb-2 fw-bolder' style="font-weight: 800;">{{ $mhsNew['namamhs'] }}</span><br>
                                                <small class=''>{{ $mhsNew['nim'] }}</small>
                                            </td>
                                            <td
                                                class="{{ isset($mhs['differences']['ipk']) ? 'onNewDiff' : 'onNewSame' }}">
                                                {{ $mhsNew['ipk'] }}
                                            </td>
                                            <td
                                                class="{{ isset($mhs['differences']['tesbahasa']) ? 'onNewDiff' : 'onNewSame' }}">
                                                {{ $mhsNew['tesbahasa'] }}
                                            </td>
                                            <td
                                                class="{{ isset($mhs['differences']['tak']) ? 'onNewDiff' : 'onNewSame' }}">
                                                {{ $mhsNew['tak'] }}
                                            </td>
                                            <td
                                                class="{{ isset($mhs['differences']['angkatan']) ? 'onNewDiff' : 'onNewSame' }}">
                                                {{ $mhsNew['angkatan'] }}
                                            </td>
                                            <td
                                                class="{{ isset($mhs['differences']['nohpmhs']) || isset($mhs['differences']['emailmhs']) ? 'onNewDiff' : 'onNewSame' }}">
                                                <span class='mb-2 fw-bolder'>{{ $mhsNew['nohpmhs'] }}</span><br>
                                                <small class=''>{{ $mhsNew['emailmhs'] }}</small>
                                            </td>
                                            <td
                                                class="{{ isset($mhs['differences']['alamatmhs']) ? 'onNewDiff' : 'onNewSame' }}">
                                                {{ $mhsNew['alamatmhs'] }}
                                            </td>
                                            <td
                                                class="{{ isset($mhs['differences']['namamhs']) ? 'onExistingDiff' : 'onExistingSame' }}">
                                                <span class='mb-2 fw-bolder'>{{ $mhsExisting['namamhs'] }}</span><br>
                                                <small class=''>{{ $mhsExisting['nim'] }}</small>
                                            </td>
                                            <td
                                                class="{{ isset($mhs['differences']['ipk']) ? 'onExistingDiff' : 'onExistingSame' }}">
                                                {{ $mhsExisting['ipk'] }}
                                            </td>
                                            <td
                                                class="{{ isset($mhs['differences']['tesbahasa']) ? 'onExistingDiff' : 'onExistingSame' }}">
                                                {{ $mhsExisting['tesbahasa'] }}
                                            </td>
                                            <td
                                                class="{{ isset($mhs['differences']['tak']) ? 'onExistingDiff' : 'onExistingSame' }}">
                                                {{ $mhsExisting['tak'] }}
                                            </td>
                                            <td
                                                class="{{ isset($mhs['differences']['angkatan']) ? 'onExistingDiff' : 'onExistingSame' }}">
                                                {{ $mhsExisting['angkatan'] }}
                                            </td>
                                            <td
                                                class="{{ isset($mhs['differences']['nohpmhs']) || isset($mhs['differences']['emailmhs']) ? 'onExistingDiff' : 'onExistingSame' }}">
                                                <span class='mb-2 fw-bolder'>{{ $mhsExisting['nohpmhs'] }}</span><br>
                                                <small class=''>{{ $mhsExisting['emailmhs'] }}</small>
                                            </td>
                                            <td
                                                class="{{ isset($mhs['differences']['alamatmhs']) ? 'onExistingDiff' : 'onExistingSame' }}">
                                                {{ $mhsExisting['alamatmhs'] ?? null }}
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
                            <table class="table border table-striped" id="table-master-mahasiswa-data-gagal-tab-preview"
                                style="width: 100%;">
                                <thead>
                                    <tr style="text-align: start;">
                                        <th>NO</th>
                                        <th>NAMA/NIM</th>
                                        <th>TUNGGAKAN BPP</th>
                                        <th>IPK</th>
                                        <th>EPRT</th>
                                        <th>TAK</th>
                                        <th>ANGKATAN</th>
                                        <th>KONTAK</th>
                                        <th>ALAMAT</th>
                                        <th>KETERANGAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['failedData'] as $mhsError)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td class="{{ $mhsError['namamhs_error'] || $mhsError['nim_error'] ? 'onerror' : 'onsuccess' }}">
                                                @if ($mhsError['namamhs_error'] || $mhsError['nim_error'])
                                                    <h6>{{ $mhsError['namamhs_error'] ? $mhsError['namamhs_error'] : $mhsError['namamhs'] }}</h6>
                                                    <h6>{{ $mhsError['nim_error'] && !($mhsError['namamhs_error'] == $mhsError['nim_error']) ? $mhsError['nim_error'] : $mhsError['nim'] }}</h6>
                                                @else
                                                    <span class='mb-2 fw-bolder'>{{ $mhsError['namamhs'] }}</span><br>
                                                    <small class=''>{{ $mhsError['nim'] }}</small>
                                                    <br>
                                                @endif
                                            </td>
                                            <td class="{{ $mhsError['tunggakan_bpp_error'] ? 'onerror' : 'onsuccess' }}">
                                                @if ($mhsError['tunggakan_bpp_error'])
                                                    <h6>{{ $mhsError['tunggakan_bpp_error'] }}</h6>
                                                @else
                                                    {{ $mhsError['tunggakan_bpp'] }}
                                                @endif
                                            </td>
                                            <td class="{{ $mhsError['ipk_error'] ? 'onerror' : 'onsuccess' }}">
                                                @if ($mhsError['ipk_error'])
                                                    <h6>{{ $mhsError['ipk_error'] }}</h6>
                                                @else
                                                    {{ $mhsError['ipk'] }}
                                                @endif
                                            </td>
                                            <td class="{{ $mhsError['tesbahasa_error'] ? 'onerror' : 'onsuccess' }}">
                                                @if ($mhsError['tesbahasa_error'])
                                                    <h6>{{ $mhsError['tesbahasa_error'] }}</h6>
                                                @else
                                                    {{ $mhsError['tesbahasa'] }}
                                                @endif
                                            </td>
                                            <td class="{{ $mhsError['tak_error'] ? 'onerror' : 'onsuccess' }}">
                                                @if ($mhsError['tak_error'])
                                                    <h6>{{ $mhsError['tak_error'] }}</h6>
                                                @else
                                                    {{ $mhsError['tak'] }}
                                                @endif
                                            </td>
                                            <td class="{{ $mhsError['angkatan_error'] ? 'onerror' : 'onsuccess' }}">
                                                @if ($mhsError['angkatan_error'])
                                                    <h6>{{ $mhsError['angkatan_error'] }}</h6>
                                                @else
                                                    {{ $mhsError['angkatan'] }}
                                                @endif
                                            </td>
                                            <td
                                                class="{{ $mhsError['nohpmhs_error'] || $mhsError['emailmhs_error'] ? 'onerror' : 'onsuccess' }}">
                                                @if ($mhsError['nohpmhs_error'] || $mhsError['emailmhs_error'])
                                                    <h6>{{ $mhsError['nohpmhs_error'] ? $mhsError['nohpmhs_error'] : $mhsError['nohpmhs'] }}</h6>
                                                    <h6>{{ $mhsError['emailmhs_error'] && !($mhsError['emailmhs_error'] == $mhsError['nohpmhs_error']) ? $mhsError['emailmhs_error'] : $mhsError['emailmhs'] }}</h6>
                                                @else
                                                    <span class='mb-2 fw-bolder'>{{ $mhsError['nohpmhs'] }}</span><br>
                                                    <small class=''>{{ $mhsError['emailmhs'] }}</small>
                                                    <br>
                                                @endif
                                            </td>
                                            <td class="{{ $mhsError['alamatmhs_error'] ? 'onerror' : 'onsuccess' }}">
                                                @if ($mhsError['alamatmhs_error'])
                                                    <h6>{{ $mhsError['alamatmhs_error'] }}</h6>
                                                @else
                                                    {{ $mhsError['alamatmhs'] }}
                                                @endif
                                            </td>
                                            <td>
                                                @isset($mhsError['messages'])
                                                    {!! $mhsError['messages'] !!}
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
            $('#table-master-mahasiswa-data-baru-tab-preview').DataTable({});
            $('#table-master-mahasiswa-data-duplikat-baru-tab-preview').DataTable({
                fixedColumns: {
                    left: 1
                },
                paging: false,
                // scrollX: true
                scrollCollapse: true,
                columnDefs: [{
                    orderable: false,
                    targets: 0
                }],
            });
            $('#table-master-mahasiswa-data-gagal-tab-preview').DataTable({});

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

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                selectAllCheckbox.checked = Array.from(checkboxes).every(cb => cb.checked);
            });
        });
    </script>
@endsection
@endsection
