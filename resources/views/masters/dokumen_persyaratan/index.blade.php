@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Dokumen Persyaratan</h4>
    </div>
    <div class="col-md-6 col-12 text-end">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-dokumen">Tambah Dokumen Persyaratan</button>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table" id="table-master-dokumen">
                    <thead>
                        <tr>
                            <th>NOMOR</th>
                            <th>NAMA DOKUMEN</th>
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
@include('masters.dokumen_persyaratan.modal')
@endsection

@section('page_script')
<script>
    var table = $('#table-master-dokumen').DataTable({
        ajax: '{{ route("doc-syarat.show")}}',
        serverSide: false,
        processing: true,
        deferRender: true,
        type: 'GET',
        destroy: true,
        rowGroup: {
            dataSrc: 'jenis_magang'
        },
        columns: [{
                data: "DT_RowIndex"
            },
            {
                data: 'namadocument',
                name: 'namadocument'
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

        let action = `{{ route('doc-syarat.update', ['id' => ':id']) }}`.replace(':id', id);
        var url = `{{ route('doc-syarat.edit', ['id' => ':id']) }}`.replace(':id', id);
        let modal = $('#modal-dokumen');

        modal.find(".modal-title").html("Edit Dokumen Persyaratan");
        modal.find('form').attr('action', action);

        modal.modal('show');

        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                $('#jenis').val(response.id_jenismagang).trigger('change');
                $('#namadokumen').val(response.namadocument);
            }
        });
    }

    function afterAction(response) {
        $("#modal-dokumen").modal('hide');
        afterUpdateStatus(response);
    }

    function afterUpdateStatus(response) {
        $('#table-master-dokumen').DataTable().ajax.reload();
    }

    $("#modal-dokumen").on("hide.bs.modal", function() {
        $("#modal-title").html("Tambah Dokumen Syarat");
        $('#modal-dokumen form').attr('action', "{{ route('doc-syarat.store') }}");
    });
</script>
@endsection