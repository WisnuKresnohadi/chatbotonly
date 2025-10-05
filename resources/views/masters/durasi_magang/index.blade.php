@extends('partials.vertical_menu')

@section('meta_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_style')
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Durasi Magang</h4>
    </div>
    <div class="col-md-6 col-12 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-durasi-magang">Tambah Durasi Magang</button>
    </div>
</div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="table" id="table-master-durasi-magang">
                        <thead>
                            <tr>
                                <th>NOMOR</th>
                                <th>NAMA</th>                                                            
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
    @include('masters.durasi_magang.modal')
@endsection

@section('page_script')
    <script>
        $(document).ready(function() {
            durasiMagangList();
        });        

        function durasiMagangList() {
            var table = $('#table-master-durasi-magang').DataTable({
                ajax: `{{ route('durasimagang.show') }}`,
                serverSide: false,
                processing: true,
                deferRender: true,
                type: 'GET',
                destroy: true,
                columns: [{
                        data: 'DT_RowIndex'
                    },

                    {
                        data: 'name',
                        name: 'name'
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

            let action = `{{ route('durasimagang.update', ['id' => ':id']) }}`.replace(':id', id);
            var url = `{{ route('durasimagang.edit', ['id' => ':id']) }}`.replace(':id', id);
            let modal = $('#modal-durasi-magang');
            modal.find(".modal-title").html("Edit Durasi Magang");
            modal.find('form').attr('action', action);
            modal.modal('show');

            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    $('#name').val(response.name);
                }
            });
        }

        function afterAction(response) {
            $("#modal-durasi-magang").modal("hide");
            afterUpdateStatus(response);
        }

        function afterUpdateStatus(response) {
            $('#table-master-durasi-magang').DataTable().ajax.reload();            
        }

        $("#modal-durasi-magang").on("hide.bs.modal", function() {
            $(this).find(".modal-title").html("Tambah Durasi Magang");
            $(this).find('form').attr('action', "{{ route('durasimagang.store') }}");
        });
    </script>
@endsection
