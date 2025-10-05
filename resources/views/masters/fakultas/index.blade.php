@extends('partials.vertical_menu')

@section('meta_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_style')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-12">
            <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Fakultas</h4>
        </div>
        <div class="col-md-3 col-12 mb-2">
            <select class="form-select select2" onchange="filter();" id="id_univ" data-placeholder="Pilih Universitas">
                <option selected value="all">Semua Universitas</option>
                @foreach ($universitas as $u)
                    <option value="{{ $u->id_univ }}">{{ $u->namauniv }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-9 col-12 text-end">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-fakultas">Tambah Fakultas</button>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="table" id="table-master-fakultas">
                        <thead>
                            <tr>
                                <th>NOMOR</th>
                                <th>UNIVERSITAS</th>
                                <th>NAMA FAKULTAS</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('masters.fakultas.modal')
@endsection

@section('page_script')
    <script>
        $(document).ready(function() {
            fakultasList();
        });

        function filter() {
            fakultasList($('#id_univ').val());
        };

        function fakultasList(id_univ = 'all') {
            var table = $('#table-master-fakultas').DataTable({
                ajax: `{{ route('fakultas.show', ['id_univ' => ':id']) }}`.replace(':id', id_univ),
                serverSide: false,
                processing: true,
                deferRender: true,
                type: 'GET',
                destroy: true,
                columns: [{
                        data: 'DT_RowIndex'
                    },

                    {
                        data: 'univ.namauniv',
                        name: 'namauniv'
                    },
                    {
                        data: 'namafakultas',
                        name: 'namafakultas'
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
        }



        function edit(e) {
            let id = e.attr('data-id');

            let action = `{{ route('fakultas.update', ['id' => ':id']) }}`.replace(':id', id);
            var url = `{{ route('fakultas.edit', ['id' => ':id']) }}`.replace(':id', id);
            let modal = $('#modal-fakultas');
            modal.find(".modal-title").html("Edit Fakultas");
            modal.find('form').attr('action', action);
            modal.modal('show');

            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    $('#namauniv').val(response.id_univ).change();
                    $('#namafakultas').val(response.namafakultas);
                }
            });
        }

        function afterAction(response) {
            $("#modal-fakultas").modal("hide");
            afterUpdateStatus(response);
        }

        function afterUpdateStatus(response) {
            $('#table-master-fakultas').DataTable().ajax.reload();
            filter();
        }

        $("#modal-fakultas").on("hide.bs.modal", function() {
            $(this).find(".modal-title").html("Tambah Fakultas");
            $(this).find('form').attr('action', "{{ route('fakultas.store') }}");
        });
    </script>
@endsection
