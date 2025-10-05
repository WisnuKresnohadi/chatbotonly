@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Nilai Mutu</h4>
    </div>
    <div class="col-md-6 col-12 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-nilai-mutu">Tambah Nilai Mutu</button>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table" id="table-master-nilai-mutu">
                    <thead>
                        <tr>
                            <th>NOMOR</th>
                            <th>NILAI MINIMAL</th>
                            <th>NILAI MAKSIMAL</th>
                            <th>NILAI MUTU</th>
                            <th>BOBOT</th>
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
@include('masters.nilai_mutu.modal')

@endsection

@section('page_script')
<script>
    $('#table-master-nilai-mutu').DataTable({
        ajax: '{{ route("nilai-mutu.show")}}',
        serverSide: false,
        processing: true,
        deferRender: true,
        type: 'GET',
        destroy: true,
        columns: [{
                data: 'DT_RowIndex'
            },
            {
                data: 'nilaimin',
                name: 'nilaimin'
            },
            {
                data: 'nilaimax',
                name: 'nilaimax'
            },

            {
                data: 'nilaimutu',
                name: 'nilaimutu'
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
        ]
    });

    function afterAction(response) {
        $("#modal-nilai-mutu").modal('hide');
        afterUpdateStatus(response);
    }

    function afterUpdateStatus(response) {
        $('#table-master-nilai-mutu').DataTable().ajax.reload();
    }

    function edit(e) {
        let id = e.attr('data-id');

        let action = `{{ route('nilai-mutu.update', ['id' => ':id']) }}`.replace(':id', id);
        var url = `{{ route('nilai-mutu.edit', ['id' => ':id']) }}`.replace(':id', id);

        $("#modal-title").html("Edit Nilai Mutu");
        $('#modal-nilai-mutu form').attr('action', action);
        $('#modal-nilai-mutu').modal('show');

        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                $('#minimal').val(response.nilaimin);
                $('#maksimal').val(response.nilaimax);
                $('#mutu').val(response.nilaimutu);
                $('#bobot').val(response.bobot);
            }
        });
    }

    $("#modal-nilai-mutu").on("hide.bs.modal", function() {
        $("#modal-title").html("Tambah Nilai Mutu");
        $('#modal-nilai-mutu form').attr('action', "{{ route('nilai-mutu.store') }}");
    });
</script>
@endsection