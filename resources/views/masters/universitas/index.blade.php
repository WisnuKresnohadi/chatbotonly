@extends('partials.vertical_menu')

@section('meta_header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_style')
<style>
    /* .swal2-icon {
        border-color: transparent !important;
    }

    .swal2-title {
        font-size: 20px !important;
        text-align: center !important;
        margin-top: 0px !important;
        margin-bottom: 0px !important;
    }

    .swal2-modal.swal2-popup .swal2-title {
        max-width: 100% !important;
    }

    .swal2-html-container {
        font-size: 16px !important;
    } */
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-12">
            <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Universitas</h4>
        </div>
        <div class="col-md-6 col-12 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-universitas">Tambah Universitas</button>
        </div>
    </div>
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table" id="table-master-univ">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Universitas</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th>Telp</th>
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
@include('masters.universitas.modal')

@endsection

@section('page_script')
<script>
    var table = $('#table-master-univ').DataTable({
        ajax: '{{ route("universitas.show")}}',
        serverSide: false,
        processing: true,
        deferRender: true,
        type: 'GET',
        destroy: true,
        columns: [{
                data: 'DT_RowIndex'
            },

            {
                data: 'namauniv',
                name: 'namauniv'
            },
            {
                data: 'jalan',
                name: 'jalan'
            },
            {
                data: 'kota',
                name: 'kota'
            },
            {
                data: 'telp',
                name: 'telp'
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

    function edit(e) {
        let id = e.attr('data-id');

        let action = `{{ route('universitas.update', ['id' => ':id']) }}`.replace(':id', id);
        var url = `{{ route('universitas.edit', ['id' => ':id']) }}`.replace(':id', id);
        let modal = $('#modal-universitas');

        modal.find(".modal-title").html("Edit Universitas");
        modal.find('form').attr('action', action);
        modal.modal('show');

        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {

                $('#namauniv').val(response.namauniv);
                $('#jalan').val(response.jalan);
                $('#kota').val(response.kota);
                $('#telp').val(response.telp);
            }
        });
    }

    function afterAction(response) {
        $("#modal-universitas").modal('hide');
        afterUpdateStatus(response)
    }

    function afterUpdateStatus(response) {
        $('#table-master-univ').DataTable().ajax.reload();
    }

    $("#modal-universitas").on("hidden.bs.modal", function() {
        $(this).find(".modal-title").html("Tambah Universitas");
        $(this).find('form').attr('action', "{{ route('universitas.store') }}");
    });
</script>
@endsection