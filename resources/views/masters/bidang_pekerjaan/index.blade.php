@extends('partials.vertical_menu')

@section('meta_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_style')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-12">
            <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Bidang Pekerjaan</h4>
        </div>
        <div class="col-md-6 col-12 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-bidang-pekerjaan">Tambah Bidang
                Pekerjaan</button>
        </div>
    </div>
    <div class="mt-2 row">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="table" id="table-master-bidang-pekerjaan">
                        <thead>
                            <tr>
                                <th>NOMOR</th>
                                <th>BIDANG PEKERJAAN</th>
                                <th>PROGRAM STUDI</th>
                                <th>MATA KULIAH</th>
                                <th>BOBOT NILAI</th>
                                <th class="text-center">STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('masters.bidang_pekerjaan.modal')
@endsection

@section('page_script')
    <script
        src="https://cdn.jsdelivr.net/gh/ashl1/datatables-rowsgroup@fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js">
    </script>
    <script>
        $(document).ready(function() {
            initTooltips();
            bidangPekerjaanList();
            customFormRepeater();
        });

        function bidangPekerjaanList() {
            var table = $('#table-master-bidang-pekerjaan').DataTable({
                ajax: `{{ route('bidangpekerjaan.show') }}`,
                serverSide: false,
                processing: true,
                deferRender: true,
                type: 'GET',
                destroy: true,
                columns: [{
                        data: 'no'
                    },

                    {
                        data: 'bidang',
                        name: 'bidang'
                    },
                    {
                        data: 'prodi',
                        name: 'prodi'
                    },
                    {
                        data: 'matkul',
                        name: 'matkul'
                    },
                    {
                        data: 'bobot',
                        name: 'bobot'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                rowsGroup: [0, 5, 1, 2],
            });
        }

        function edit(e) {
            let id = e.attr('data-id');

            let action = `{{ route('bidangpekerjaan.update', ['id' => ':id']) }}`.replace(':id', id);
            var url = `{{ route('bidangpekerjaan.edit', ['id' => ':id']) }}`.replace(':id', id);
            let modal = $('#modal-bidang-pekerjaan');
            modal.find(".modal-title").html("Edit Bidang Pekerjaan");
            modal.find('form').attr('action', action);
            modal.modal('show');

            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    $('#namabidangpekerjaan').val(response.data.namabidangpekerjaan);
                    $('#deskripsi').val(response.data.deskripsi);
                }
            });
        }

        let formRepeater = $('.prodi-repeater');

        let data = {};

        function getDataSelect(e, $element = null, isOnChange = true) {
            let prodiId = isOnChange ? e.val() : e;

            if (prodiId == null) return;

            $.ajax({
                url: `{{ route('igracias') }}?type=id_mk&selected=` + prodiId,
                type: 'GET',
                success: function(response) {
                    data[prodiId] = response.data;

                    if (isOnChange) {
                        selectedValues = [];
                        let mataKuliahSelect = e.closest('.prodi-item-repeater').find('.mata-kuliah');
                        let bobotSelect = e.closest('.prodi-item-repeater').find('.bobot-nilai');

                        e.closest('.prodi-item-repeater').find(
                            '[data-repeater-list="matakuliah"] [data-repeater-item]').slice(1).remove()

                        mataKuliahSelect.find('option:not(:first)').remove();
                        mataKuliahSelect.empty();
                        mataKuliahSelect.val('');
                        bobotSelect.val('');
                        initializeMappingSelect(mataKuliahSelect, data[prodiId]);
                    } else {
                        initializeMappingSelect($element);
                    }
                }
            });
        }

        function initializeMappingSelect($element) {

            let idProdi = $element.closest('.prodi-item-repeater').find('.prodi').val()
            let dataProdi = data[idProdi];

            initSelect2($element, dataProdi)
            initSelect2()

            $element.each(function(index, el) {
                let $currentElement = $(el);
                const bpmk_id = $currentElement.closest('.form-group').find('input[name*="id_bidang_pekerjaan_mk"]')
                    .val()
                $currentElement.val(selectedValues[idProdi][bpmk_id]).trigger(
                    'change');
            });
        }

        function customFormRepeater() {
            var row = 2;
            var col = 1;

            if (formRepeater.length == 0) return;
            formRepeater.repeater({
                show: function() {
                    getDataSelect($(this).find('.prodi').val(), $(this).find('.mata-kuliah'), false)

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

                    // fix select2
                    // --------------------------------------------
                    $(this).slideDown();

                    initSelect2();
                },
                hide: function(e) {
                    if ($(this).find('button').hasClass('delete_parent')) {
                        const element = $(this)
                        sweetAlertConfirm({
                            title: 'Apakah Anda yakin ingin menghapus Prodi ini?',
                            text: "",
                            icon: 'warning',
                            confirmButtonText: 'Ya, saya yakin!',
                            cancelButtonText: 'Batal'
                        }, function() {
                            element.slideUp(e);
                        })
                    }
                },
                // isFirstItemUndeletable: true,
                repeaters: [{
                    selector: '.matakuliah-repeater',
                    show: function() {
                        const idProdi = $(this).closest('.prodi-item-repeater').find('.prodi').val();
                        const dataProdi = data[idProdi]

                        var fromControl = $(this).find(
                            '.form-control, .form-select, .form-check-input');
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

                        //fix select2
                        initSelect2();

                        const element = $(this).find('.mata-kuliah');
                        initSelect2(element, dataProdi)

                        $(this).slideDown();

                        initSelect2();
                        initTooltips();
                    },
                    hide: function(e) {
                        const element = $(this)
                        sweetAlertConfirm({
                            title: 'Apakah Anda yakin ingin menghapus Mata Kuliah ini?',
                            text: "",
                            icon: 'warning',
                            confirmButtonText: 'Ya, saya yakin!',
                            cancelButtonText: 'Batal'
                        }, function() {
                            element.slideUp(e);
                        })
                    },
                    isFirstItemUndeletable: true
                }],
            });
        }

        let selectedValues = {};

        function editMappingMk(e) {
            let id = e.attr('data-id');
            let action = `{{ route('bidangpekerjaan.update_mapping_mk', ['id' => ':id']) }}`.replace(':id', id);
            let url = `{{ route('bidangpekerjaan.edit_mapping_mk', ['id' => ':id']) }}`.replace(':id', id);
            let modal = $('#modal-mapping-mk-bidang-pekerjaan');

            modal.find(".modal-title").html("Konfigurasi Matakuliah - Bidang Pekerjaan");
            modal.find('form').attr('action', action);
            modal.modal('show');

            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    selectedValues = {}
                    // Populate form fields
                    $('#id_bidang_pekerjaan_industri').val(response.bidangPekerjaanIndustri
                        .id_bidang_pekerjaan_industri);
                    $('#nama_bidang_pekerjaan').val(response.bidangPekerjaanIndustri
                        .namabidangpekerjaan);

                    let prodiList = [];
                    let prodiData = response.bidangPekerjaanIndustri.prodi;

                    if (prodiData.length > 0) {
                        for (let i = 0; i < prodiData.length; i++) {
                            let prodiItem = {
                                'id_prodi': prodiData[i].id_prodi,
                                'matakuliah': []
                            };

                            let mataKuliahData = prodiData[i].mk_terkait;
                            if (mataKuliahData.length > 0) {
                                for (let j = 0; j < mataKuliahData.length; j++) {
                                    prodiItem.matakuliah.push({
                                        'id_bidang_pekerjaan_mk': mataKuliahData[j]
                                            .id_bidang_pekerjaan_mk,
                                        'id_mk': mataKuliahData[j].id_mk,
                                        'bobot': mataKuliahData[j].bobot
                                    });

                                    selectedValues[prodiData[i].id_prodi] = selectedValues[prodiData[i]
                                        .id_prodi] || [];
                                    selectedValues[prodiData[i].id_prodi][mataKuliahData[j]
                                        .id_bidang_pekerjaan_mk
                                    ] = mataKuliahData[j].id_mk;
                                }
                            }

                            prodiList.push(prodiItem);
                        }

                        prodiList.forEach(element => {
                            if (element.matakuliah.length == 0) {
                                element.matakuliah = [{}];
                            }
                        });

                        formRepeater.setList(prodiList);
                    }
                },
            });
        }

        function afterAction(response) {
            $("#modal-bidang-pekerjaan").modal("hide");
            $('#modal-mapping-mk-bidang-pekerjaan').modal('hide');
            afterUpdateStatus(response);
        }

        function afterUpdateStatus(response) {
            $('#table-master-bidang-pekerjaan').DataTable().ajax.reload(null, false);
        }

        $("#modal-bidang-pekerjaan").on("hide.bs.modal", function() {
            $(this).find(".modal-title").html("Tambah Bidang Pekerjaan");
            $(this).find('form').attr('action', "{{ route('bidangpekerjaan.store') }}");
        });

        $("#modal-mapping-mk-bidang-pekerjaan").on("hide.bs.modal", function() {
            $('#default-form').trigger('reset');
            $('.mata-kuliah').find('option:not([disabled])').remove();
            $('.mata-kuliah').val(null).trigger('change');
            $('[data-repeater-list="prodi"] [data-repeater-item]:not(:first)').slice(1).remove();

            if ($('[data-repeater-list="prodi"] [data-repeater-item]').length === 0) {
                let prodiList = [{
                    id_prodi: "",
                    matakuliah: {
                        'id_mk': [],
                    }
                }];
                formRepeater.setList(prodiList);
                initTooltips();
            }
        });
    </script>
@endsection
