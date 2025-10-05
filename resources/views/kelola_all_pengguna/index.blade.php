@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4 class="fw-bold text-sm"><span class="text-muted fw-light text-xs"></span>
        Kelola Semua Pengguna
    </h4>
    {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahMitra">Tambah Mitra</button> --}}
</div>
<div class="col-12">
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="table" id="table-kelola-pengguna">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NAMA</th>
                        <th>EMAIL</th>
                        <th>ROLE</th>
                        <th style="text-align: center;">AKSI</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@include('kelola_all_pengguna.modal')
@endsection

@section('page_script')
<script>
    function afterEdit(response) {
        $('#table-kelola-pengguna').DataTable().ajax.reload();
        $('#modalTambahMitra').modal('hide');
    }

    var table = $('#table-kelola-pengguna').DataTable({
        ajax: `{{ route('kelola_semua_pengguna.show') }}`,
        columns: [
            { data: "DT_RowIndex" },
            { data: "name" },
            { data: "email" },
            { data: "roles" },
            { data: "action" }
        ]
    });

    function edit(e) {
        let id = e.attr('data-id');

        let action = `{{ route('kelola_semua_pengguna.update', ['id' => ':id']) }}`.replace(':id', id);
        var url = `{{ route('kelola_semua_pengguna.edit', ['id' => ':id']) }}`.replace(':id', id);

        let modal = $('#modalTambahMitra');

        modal.find('.modal-title').html("Edit Pengguna");
        modal.find('form').attr('action', action);
        modal.modal('show');

        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                response = response.data;
                $('#name').val(response.name);
                $('#email').val(response.email);
                $('#role').val(response.role).trigger('change');
            }
        });
    }
</script>
@endsection