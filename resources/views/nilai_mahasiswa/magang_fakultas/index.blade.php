@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
    <div class="row pe-2 ps-2">
        <div class="col-md-9 col-12">
            <h4 class="text-sm fw-bold"><span class="text-xs text-muted fw-light">Nilai Mahasiswa / </span>
                Magang Fakultas Tahun Ajaran <span id="tahun_picked"></span>
            </h4>
        </div>
        <div class="mb-3 col-md-3 col-12 d-flex align-items-center justify-content-end">
            <select class="select2 form-select" data-placeholder="Pilih Tahun Ajaran" id="tahun_ajaran_filter">
                {!! tahunAjaranMaker() !!}
            </select>
            <button class="btn btn-icon btn-primary ms-2" data-bs-toggle="offcanvas" data-bs-target="#modalSlide"><i
                    class="tf-icons ti ti-filter"></i></button>
        </div>
        <div class="row">
            <div class="mt-2 mb-3 col-md-12 col-12 d-flex justify-content-between">
                <div class="text-secondary ">Filter Berdasarkan : <i class='pb-1 tf-icons ti ti-alert-circle text-primary'
                        data-bs-toggle="tooltip" data-bs-placement="right"
                        data-bs-original-title="Prodi: D3 Sistem Informasi" id="tooltip-filter"></i></div>
                <button type="button" data-status="fakultas" class="btn btn-success waves-effect waves-light" onclick="exportDataNilai($(this))">Download data
                    nilai</button>
            </div>
        </div>
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table table-fakultas" id="table-fakultas">
                    <thead>
                        <tr>
                            <th style="min-width: 50px;">NOMOR</th>
                            <th style="min-width: 125px;">NAMA/NIM</th>
                            <th style="min-width: 170px;">PROGRAM STUDI</th>
                            <th style="min-width: 150px;">PERUSAHAAN</th>
                            <th style="min-width: 150px;">POSISI MAGANG</th>
                            <th style="min-width: 100px;">NILAI PBB LAPANGAN</th>
                            <th style="min-width: 100px;">NILAI PBB AKADEMIK</th>
                            <th style="min-width: 100px;">NILAI AKHIR</th>
                            <th style="min-width: 100px;">INDEKS NILAI AKHIR</th>
                            <th style="min-width: 50px;">AKSI</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="modalSlide" aria-labelledby="offcanvasAddUserLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Filter Berdasarkan</h5>
        </div>
        <div class="flex-grow-0 pt-0 mx-0 offcanvas-body h-100">
            <form class="pt-0 add-new-user" id="filter_form" onsubmit="return false;">
                <div class="mb-2 col-12">
                    <div class="row">
                        <div class="mb-2">
                            <label for="prodi" class="form-label">Program Studi</label>
                            <select class="form-select select2" id="prodi" name="prodi"
                                data-placeholder="Pilih Program Studi">
                                <option value="" disabled selected>Pilih Program Studi</option>
                                @foreach ($prodi as $item)
                                    <option value="{{ $item->id_prodi }}">{{ $item->namaprodi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2">
                            <label for="perusahaan" class="form-label">Masukkan Nama Perusahaan</label>
                            <input type="text" id="namaperusahaan" class="form-control"
                                placeholder="Masukkan Nama Perusahaan" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2">
                            <label for="posisi" class="form-label">Masukkan Posisi Magang</label>
                            <input type="text" id="posisi" class="form-control"
                                placeholder="Masukkan Posisi Magang" />
                        </div>
                    </div>
                </div>
                <div class="mt-3 text-end">
                    <button type="reset" class="btn btn-label-danger data-reset">Reset</button>
                    <button type="submit" class="btn btn-primary">Terapkan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('page_script')
    <script>
        let dataFilter = {};
        $(document).ready(function() {
            loadData();
        });

        $('#filter_form').on('submit', function() {
            dataFilter['prodi'] = $('#prodi').val();
            dataFilter['namaperusahaan'] = $('#namaperusahaan').val();
            dataFilter['posisi'] = $('#posisi').val();
            loadData();
        });

        $('#tahun_ajaran_filter').on('change', function() {
            loadData();
        });

        $('#filter_form').on('reset', function() {
            $('#prodi').val(null).trigger('change');
            dataFilter = {};
            loadData();
        });

        function exportDataNilai(e) {
            btnBlock(e);
            $.ajax({
                url: "{{ route('nilai_mahasiswa.fakultas.export_nilai_mhs') }}",
                method: 'GET',
                data: dataFilter,
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
                            text: "Data nilai mahasiswa magang fakultas tidak tersedia",
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


        function loadData() {
            dataFilter['tahun_ajaran'] = $('#tahun_ajaran_filter').val();
            $('#tahun_picked').text($('#tahun_ajaran_filter :selected').text());

            $('#table-fakultas').DataTable({
                ajax: {
                    url: `{{ route('nilai_mahasiswa.fakultas.get_data') }}`,
                    type: 'GET',
                    data: dataFilter
                },
                destroy: true,
                scrollX: true,
                columns: [{
                        data: "DT_RowIndex"
                    },
                    {
                        data: "namamhs"
                    },
                    {
                        data: "namaprodi"
                    },
                    {
                        data: "namaindustri"
                    },
                    {
                        data: "intern_position"
                    },
                    {
                        data: "nilai_lap"
                    },
                    {
                        data: "nilai_akademik"
                    },
                    {
                        data: "nilai_akhir_magang"
                    },
                    {
                        data: "indeks_nilai_akhir"
                    },
                    {
                        data: "action"
                    }
                ],
                "columnDefs": [{
                        "width": "50px",
                        "targets": 0
                    },
                    {
                        "width": "125px",
                        "targets": 1
                    },
                    {
                        "width": "170px",
                        "targets": 2
                    },
                    {
                        "width": "150px",
                        "targets": 3
                    },
                    {
                        "width": "150px",
                        "targets": 4
                    },
                    {
                        "width": "100px",
                        "targets": 5
                    },
                    {
                        "width": "100px",
                        "targets": 6
                    },
                    {
                        "width": "100px",
                        "targets": 7
                    },
                    {
                        "width": "100px",
                        "targets": 8
                    },
                    {
                        "width": "50px",
                        "targets": 9
                    },
                ],
            });
        }
    </script>
@endsection
