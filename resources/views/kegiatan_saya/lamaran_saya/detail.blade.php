@extends('partials.horizontal_menu')

@section('page_style')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-start">
        <a href="{{ route('lamaran_saya') }}" class="btn btn-outline-primary">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>
    <div class="mt-2 d-flex justify-content-start">
        <h4><span class="text-muted">Kegiatan saya&ensp;/&ensp;Status Lamaran Saya&ensp;/&ensp;</span>Detail</h4>
    </div>
    <div class="my-5 position-relative">
        {!! $pelamar->step_status !!}
    </div>
    <div class="card">
        <div class="card-body">
            <div class="pb-4 mx-2 row border-bottom">
                <div class="px-0 col-6">
                    <div class="d-flex justify-content-start">
                        <div class="text-center" style="overflow: hidden; width: 100px; height: 100px;">
                            @if ($pelamar->image)
                            <img src="{{ asset('storage/' . $pelamar->image) }}" alt="user-avatar" class="d-block" width="100" id="image_industri">
                            @else
                            <img src="{{ asset('app-assets/img/avatars/user.png') }}" alt="user-avatar" class="d-block" width="100" id="image_industri">
                            @endif
                        </div>
                        <div class="d-flex flex-column justify-content-center ms-3">
                            <h4 class="mb-1">{{ $pelamar->intern_position }}</h4>
                            <span>{{ $pelamar->namaindustri }}</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="mt-2 d-flex justify-content-start">
                            <i class="ti ti-map-pin"></i>
                            <span class="ms-2">{{ implode(', ', json_decode($pelamar->lokasi)) }}</span>
                        </div>
                        <div class="mt-2 d-flex justify-content-start">
                            <i class="ti ti-cash"></i>
                            <span class="ms-2">{{ uangSakuRupiah($pelamar->nominal_salary) }}</span>
                        </div>
                        <div class="mt-2 d-flex justify-content-start">
                            <i class="ti ti-calendar-time"></i>
                            <span class="ms-2">{{ implode(', ', json_decode($pelamar->durasimagang)) }}</span>
                        </div>
                        <div class="mt-2 d-flex justify-content-start">
                            <i class="ti ti-users"></i>
                            <span class="ms-2">{{ $pelamar->kuota }} Kuota Penerimaan</span>
                        </div>
                        <div class="mt-4 d-flex justify-content-start">
                            <a href="{{ route('lamaran_saya.detail_lowongan', $pelamar->id_pendaftaran) }}" class="btn btn-sm btn-outline-primary">
                                <i class="ti ti-eye"></i>
                                <span class="ms-2">Lihat Detail Pekerjaan</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="px-0 col-6">
                    <div class="d-flex flex-column justify-content-end align-items-end">
                        <span>Lamaran terkirim pada <span class="fw-semibold">{{ Carbon\Carbon::parse($pelamar->tanggaldaftar)->format('d F Y') }}</span></span>
                        @if (!$pelamar->lowongan_tersedia)
                        <span class="mt-2 badge fs-6 bg-label-secondary">Lowongan sudah ditutup</span>
                        @endif
                        <div class="mt-2">
                            {!! $pelamar->status_badge !!}
                        </div>
                        @if (in_array($pelamar->current_step, ['approved_penawaran', 'rejected_screening', 'rejected_seleksi_tahap_1', 'rejected_seleksi_tahap_2', 'rejected_seleksi_tahap_3']))
                        <a href="{{ asset('storage/' . $pelamar->file_document_mitra) }}" target="_blank" class="mt-2 text-primary">
                            <small class="d-flex align-items-center">
                                <i class="ti ti-file-symlink me-2"></i>
                                Berkas {{ in_array($pelamar->current_step, ['rejected_screening', 'rejected_seleksi_tahap_1', 'rejected_seleksi_tahap_2', 'rejected_seleksi_tahap_3']) ? 'Penolakan' : 'Penerimaan' }}
                            </small>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-3 mb-3 row {{ $pelamar->dokumen_sr ? 'pb-4 border-bottom' : '' }}">
                @if($pelamar->reason_reject)
                <div class="px-0 mb-2 col-12">
                    <div class="alert alert-danger">
                        <small class="mb-1 fw-bolder">Alasan Ditolak:</small><br>
                        <small class="mb-1">{{ $pelamar->reason_reject }}</small>
                    </div>
                </div>
                @endif

                <div class="mb-2 col-12">
                    <h5 class="mb-1">Berkas Persyaratan</h5>
                </div>
                <div class="row">
                    @foreach ($dokumen_pendaftaran as $item)
                    <div class="px-2 my-1 col-4">
                        <a href="{{ asset('storage/' . $item->file) }}" target="_blank" class="text-primary">
                            <small class="d-flex align-items-center">
                                <i class="ti ti-file-symlink me-2"></i>
                                {{ $item->namadocument }}
                            </small>
                        </a>
                    </div>
                    @endforeach

                    <div class="mt-3">
                        <div class="mb-2 col-12">
                            <h5 class="mb-1">Surat</h5>
                        </div>
                        <div class="d-flex justify-content-start">
                            {!! $persuratan !!}
                        </div>
                    </div>
                    <form action="{{ route('wawancara-flow.panduan', $pelamar->id_pendaftaran) }}" method="POST">
                        @csrf
                        <div class="persyaratan-tambahan-repeater col-lg-12 col-sm-6 form-group" data-limit="3">
                            <div class="px-3 pt-2 pb-3">
                                {{-- Softskill select --}}
                                <div class="mb-3 col-12 form-group">
                                    <label for="softskill" class="form-label">
                                        Soft Skills yang akan digali lebih dalam (minimal 1 dan maksimal 3)<span style="color: red;">*</span>
                                    </label>
                                    <select class="form-select select2" name="softskill[]" id="softskill" data-placeholder="Pilih Soft Skills" data-tags="true" multiple>
                                        <option value="Adaptasi">Adaptasi</option>
                                        <option value="Komunikasi">Komunikasi</option>
                                        <option value="Kepemimpinan">Kepemimpinan</option>
                                        <option value="Kepercayaan Diri">Kepercayaan Diri</option>
                                        <option value="Manajemen Waktu">Manajemen Waktu</option>
                                        <option value="Pemecahan Masalah">Pemecahan Masalah</option>
                                    </select>
                                </div>

                                {{-- Repeater --}}
                                <div data-repeater-list="persyaratan_tambahan">
                                    <div data-repeater-item>
                                        <div class="gap-3 mb-3 justify-content-between d-flex">
                                            <div class="w-100">
                                                <h6>Pertanyaan Tambahan</h6>
                                                <label class="form-label">Pertanyaan tambahan tidak akan diproses sebagai penilaian...</label>
                                                <input type="text" name="persyaratan_tambah" class="form-control" placeholder="Tulis Pertanyaan">
                                            </div>
                                            <button type="button" class="mt-4 btn btn-outline-danger" data-repeater-delete>
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 border-top">
                                    <button class="mt-4 btn btn-outline-warning" type="button" data-repeater-create>
                                        <i class="ti ti-plus me-1"></i>
                                        <span class="align-middle">Pertanyaan</span>
                                    </button>
                                </div>

                                <button type="submit" class="btn btn-primary mt-2">Mulai Test</button>
                            </div>
                        </div>
                    </form>
                    <div>
                        <button class="btn btn-primary mt-2">
                            <a href="{{ route('wawancara-flow.result', $pelamar->id_pendaftaran) }}" style="color: white; text-decoration: none;">
                                Lihat Hasil Wawancara
                            </a>
                        </button>
                    </div>
                    <div class="mt-3" style="display:flex; gap:20px;">
                        <div style="font-weight:600; display:flex; flex-direction:column;  " >
                            {{-- @if($pelamar->current_step == "approved_by_lkm" && ($pelamar->kuota_wawancara ?? 1) > 0)
                                <a name="" id="" class="btn btn-primary" href="/wawancara/panduan/{{ $pelamar->id_pendaftaran }}" role="button" style="font-size:13px; padding-y:10px; margin-bottom:24px;">Mulai Wawancara</a>
                            @endif --}}
                            <h5 style=" color: #4B465C;" >Batas Akhir Seleksi Wawancara</h5>
                            <div style="text-align: center; width:123px; border-radius:4px; padding:8px 4px; font-size:13px; color:#cc7f36; background-color:#ffecd9">
                                13 Agustus 2025
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                {{-- <div class="row">
                    <div class="py-3 col">
                        <h6 class="mb-1">Data Matakuliah</h6>
                        <p class="d-flex justify-items-center" style="color: #4EA971"><i class="ti ti-notebook me-2"></i>Data Matakuliah Terkait</p>
                        <div class="d-flex justify-content-start">
                            <div class="row w-100">
                                <table class="table table-bordered table-striped" id="table-nilai-mk-mahasiswa">
                                    <thead>
                                        <tr class="fw-normal">
                                            <th style="width: 10%">NOMOR</th>
                                            <th style="width: 40%">MATAKULIAH</th>
                                            <th>BOBOT NILAI</th>
                                            <th>NILAI AKHIR</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="table-group-divider table-secondary fw-bold">
                                        <tr>
                                            <th colspan="3" class="text-center">Total Nilai</th>
                                            <th id="total-nilai-footer"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

@section('page_script')
<script>
    $(document).ready(function() {
        let id = "{{ $pelamar->id_bidang_pekerjaan_industri ?? 1 }}";
        let total_nilai = "{{ $pelamar->nilai_akademik ?? 0 }}";
        initFormPersyaratanTambahanRepeater();
        initSoftskillSelect();
        loadData(id, total_nilai);
    });

        let formRepeater = $('.persyaratan-tambahan-repeater');

        function initFormPersyaratanTambahanRepeater() {
            var row = 2;
            var col = 1;

            if (formRepeater.length == 0) return;

            formRepeater.repeater({
                show: function() {
                    let dataCallback = $(this).attr('data-callback');
                    if (typeof window[dataCallback] === "function") window[dataCallback](this);

                    var fromControl = $(this).find('.form-control, .form-select, .form-check-input');
                    var formLabel = $(this).find('.form-label, .form-check-label');

                    fromControl.each(function(i) {
                        if (!$(this).hasClass('flatpickr-date')) {
                            var id = 'form-repeater-' + row + '-' + col;
                            $(fromControl[i]).attr('id', id);
                            $(formLabel[i]).attr('for', id);
                            col++;
                        }
                    });

                    row++;

                    var limitcount = $(this).parents(".persyaratan-tambahan-repeater").data("limit");
                    var itemcount = $('[data-repeater-list="persyaratan_tambahan"] [data-repeater-item]').length

                    if (limitcount) {
                        if (itemcount <= limitcount) {
                            $(this).slideDown();
                        } else {
                            $(this).remove();
                        }
                    } else {
                        $(this).slideDown();
                    }

                    if (itemcount >= limitcount) {
                        $(".persyaratan-tambahan-repeater [data-repeater-create]").parent().addClass("d-none");
                    }
                },
                hide: function(e) {
                    var limitcount = $(this).parents(".persyaratan-tambahan-repeater").data("limit");
                    var itemcount = $('[data-repeater-list="persyaratan_tambahan"] [data-repeater-item]')
                        .length;

                    const element = $(this)
                    sweetAlertConfirm({
                        title: 'Apakah Anda yakin ingin menghapus pertanyaan ini?',
                        text: "",
                        icon: 'warning',
                        confirmButtonText: 'Ya, saya yakin!',
                        cancelButtonText: 'Batal'
                    }, function() {
                        let dataCallback = $(this).attr('data-callback');
                        if (typeof window[dataCallback] === "function") window[dataCallback](this);
                        element.slideUp(e);
                        if (itemcount <= limitcount) {
                            $(".persyaratan-tambahan-repeater [data-repeater-create]").parent()
                                .removeClass('d-none');
                        }
                    })
                },
                isFirstItemUndeletable: true
            });

        }
        function initSoftskillSelect() {
        let $select = $('#softskill');

        $select.select2({
            maximumSelectionLength: 3,
            placeholder: "Pilih Soft Skills"
        });

        // When selecting
        $select.on('select2:select', function () {
            let selected = $(this).val() || [];
            if (selected.length >= 3) {
                $select.find('option:not(:selected)').prop('disabled', true);
            } else {
                $select.find('option').prop('disabled', false);
            }
            $select.trigger('change.select2');
        });

        // When unselecting
        $select.on('select2:unselect', function () {
            $select.find('option').prop('disabled', false);
            $select.trigger('change.select2');
        });
    }
    function loadData(id, total_nilai){
        $('#table-nilai-mk-mahasiswa').DataTable({
            processing: true,
            serverSide: false,
            scrollX: true,
            destroy: true,
            paging : false,
            info: false,
            ordering: false,
            searching: false,
            lengthChange: false,
            ajax: "{{ route('lamaran_saya.get_detail_nilai', ':id') }}".replace(':id', id),
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                { data: 'mata_kuliah', name: 'mata_kuliah' },
                { data: 'bobot', name: 'bobot' },
                { data: 'nilai_akhir', name: 'nilai_akhir' },
                { data: 'index_key', visible: false }
            ],
            drawCallback: function(settings) {
                let api = this.api();
                let rows = api.rows({page:'current'}).nodes();
                let lastIndex = null;
                let lastBobot = null;

                api.rows({page:'current'}).every(function(rowIdx, tableLoop, rowLoop){
                    let data = this.data();
                    let bobot = data.bobot;
                    let indexKey = data.index_key;

                    if (lastIndex === indexKey && lastBobot === bobot) {
                        // merge with previous row
                        let firstCell = $(rows).eq(rowIdx-1).find('td:eq(2)');
                        let rowspan = firstCell.attr('rowspan') || 1;
                        rowspan = parseInt(rowspan) + 1;
                        firstCell.attr('rowspan', rowspan);
                        $(rows).eq(rowIdx).find('td:eq(2)').remove(); // remove duplicate
                    } else {
                        lastIndex = indexKey;
                        lastBobot = bobot;
                    }
                });

                $('#total-nilai-footer').text(total_nilai);
            }
        });
    }

</script>

@endsection
