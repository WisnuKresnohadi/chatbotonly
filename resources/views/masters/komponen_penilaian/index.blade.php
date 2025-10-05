@extends('partials.vertical_menu')

@section('page_style')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-12">
            <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Komponen Penilaian</h4>
        </div>
        <div class="col-md-6 col-12 mb-3 d-flex align-items-center justify-content-end">
            <select class="select2 form-select" data-placeholder="Pilih Tahun Ajaran" id="filter_tahun">
                {!! tahunAjaranMaker() !!}
            </select>
            <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#modal-komponen-nilai">Tambah Komponen</button>
        </div>

        <div class="nav-align-top">
            <div class="row">
                <div class="col-6">
                    <ul class="nav nav-pills mb-3 " role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" target="1" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-akademik" aria-controls="navs-pills-justified-akademik" aria-selected="false"> 
                                Pembimbing Akademik
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" target="0" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-lapangan" aria-controls="navs-pills-justified-lapangan" aria-selected="false" > 
                                Pembimbing Lapangan
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tab-content p-0">
            <div class="tab-pane fade show active" id="navs-pills-justified-akademik" role="tabpanel">
                <div class="card">
                    <div class="card-datatable table-responsive">
                        <table class="table" id="table-akademik">
                            <thead>
                                <tr>
                                    <th>NOMOR</th>
                                    <th>ASPEK PENILAIAN</th>
                                    <th>DESKRIPSI ASPEK PENILAIAN</th>
                                    <th>NILAI MAX</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center">AKSI</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade show" id="navs-pills-justified-lapangan" role="tabpanel">
                <div class="card">
                    <div class="card-datatable table-responsive">
                        <table class="table" id="table-lapangan">
                            <thead>
                                <tr>
                                    <th>NOMOR</th>
                                    <th>ASPEK PENILAIAN</th>
                                    <th>DESKRIPSI ASPEK PENILAIAN</th>
                                    <th>NILAI MAX</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center">AKSI</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('masters.komponen_penilaian.modal')
@endsection

@section('page_script')
    <script
        src="https://cdn.jsdelivr.net/gh/ashl1/datatables-rowsgroup@fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js">
    </script>

    <script>
        let formRepeater = $('.form-repeater');
        let dataFilter = {};
        $(document).ready(function () {
            loadData();
        });

        $('#filter_tahun').on('change', function () {
            loadData();
        });

        function loadData() {
            dataFilter.tahun_ajaran = $('#filter_tahun').val();

            $('.table').each(function () {
                let dataId = $(this).attr('id');

                $(this).DataTable({
                    ajax: {
                        url: "{{ route('komponen-penilaian.show') }}?id=" + dataId,
                        type: 'GET',
                        data: dataFilter
                    },
                    serverSide: false,
                    processing: true,
                    deferRender: true,
                    type: 'GET',
                    destroy: true,
                    rowGroup: {
                        dataSrc: 'namajenis'
                    },
                    columns: [
                        {
                            data: "DT_RowIndex"
                        },
                        {
                            data: 'aspek_penilaian',
                            name: 'aspek_penilaian',
                            render: function(data, type, row){
                                return data.split("\n ").join("<br/>");
                            }
                        },
                        {
                            data: 'deskripsi_penilaian',
                            name: 'deskripsi_penilaian'
                        },
                        {
                            data: 'nilai_max',
                            name: 'nilai_max'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        }
                    ]
                });
            });
        }

        function afterAction(response) {
            loadData();

            $('#modal-komponen-nilai').modal('hide');
        }

        function edit(e) {
            let id = e.attr('data-id');

            let action = `{{ route('komponen-penilaian.update', ['id'=>':id']) }}`.replace(':id', id);
            var url = `{{ route('komponen-penilaian.edit', ['id'=>':id']) }}`.replace(':id', id);
            let modal = $('#modal-komponen-nilai');

            modal.find(".modal-title").html("Edit Komponen Nilai");
            modal.find('form').attr('action', action);
            modal.find('#container-add-row').hide();

            modal.modal('show');

            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    $.each(response.data, function ( key, value ) {
                        $(`#${key}`).val(value).trigger('change');
                    })
                }
            });
        }

        function afterUpdateStatus(response) {
            loadData();
        }

        $("#modal-komponen-nilai").on("hide.bs.modal", function() {
            let modal = $('#modal-komponen-nilai');
            modal.find('#container-add-row').show();
            modal.find(".modal-title").html("Tambah Komponen Nilai");
            modal.find('form').attr('action', "{{ route('komponen-penilaian.store') }}");
            formRepeater.find('[data-repeater-item]').slice(1).empty();                 
        });
    </script>
@endsection
