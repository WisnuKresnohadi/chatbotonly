@extends('partials.vertical_menu')

@section('page_style')
<style>
    .tooltip-inner {
        max-width: 210px;
        /* If max-width does not work, try using width instead */
        width: 900px;
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between">
    <h4 class="my-auto fw-bold">Kelola Pengguna</h4>
    <div class="">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUser">Tambah Pengguna</button>
    </div>
</div>
<div class="mt-3 col-xl-12">
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="table" id="table-pengguna">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th style="min-width: 125px;">NAMA</th>
                        <th>EMAIL</th>
                        <th style="text-align: center;">Role</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center;">AKSI</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
{{-- Modal Edit> --}}
@include('admin.kelola-pengguna.modal')
@endsection

@section('page_script')
<script>
    var table = $('#table-pengguna').DataTable({
        ajax: `{{ route('kelola_pengguna.get_data') }}`,
        columns: [
            { data: "DT_RowIndex" },
            { data: "name" },
            { data: "email" },
            { data: "roles" },
            { data: "status" },
            { data: "action" }
        ]
    });

    function afterAction(response) {
        afterUpdateStatus(response)
        $('#modalTambahUser').modal('hide');
    }

    function afterUpdateStatus(response) {
        $('#table-pengguna').DataTable().ajax.reload();
    }

    function edit(e) {
        let id = e.attr('data-id');

        let url = `{{ route('kelola_pengguna.edit', ['id' => ':id']) }}`.replace(':id', id);
        let action = `{{ route('kelola_pengguna.update', ['id' => ':id']) }}`.replace(':id', id);
        let modal = $('#modalTambahUser');

        modal.find('.modal-title').html('Edit Pengguna');
        modal.find('form').attr('action', action);

        modal.find(`[name="role"]`).append(new Option('Dosen', 'Dosen', true, true));
        modal.find(`[name="role"]`).append(new Option('Kaprodi', 'Kaprodi', true, true));
        modal.find(`[name="role"]`).append(new Option('Koordinator Magang', 'Koordinator Magang', true, true));
        modal.find(`[name="role"]`).val(null).change();
        modal.modal('show');

        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                response = response.data;
                $('#name').val(response.name);
                $('#email').val(response.email);
                if (response.role == 'LKM') {
                    modal.find(`[name="role"]`).append(new Option('LKM', 'LKM', true, true));
                    modal.find(`[name="role"]`).attr('disabled', true);
                }
                $('#role').val(response.role).change();
            }
        });
    }

    function resetPassword(e) {
        $.ajax({
            url: "{{ route('kelola_pengguna.reset_password', ['id' => ':id']) }}".replace(':id', e.attr('data-id')),
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                if (!response.error) {
                    showSweetAlert({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success'
                    });
                } else {
                    showSweetAlert({
                        title: 'Gagal!',
                        text: response.message,
                        icon: 'error'
                    });
                }
            },
            error: function(xhr, status, error) {
                let res = xhr.responseJSON;
                showSweetAlert({
                    title: 'Gagal!',
                    text: res.message,
                    icon: 'error'
                });
            }
        });
    }

    $(`button[data-bs-target="#modalTambahUser"]`).on('click', function () {
        let modal = $("#modalTambahUser");
        modal.find(`[name="role"]`).append(new Option('LKM', 'LKM', true, true));
        modal.find(`[name="role"]`).val('LKM').change();
        modal.find(`[name="role"]`).attr('disabled', true);
    });

    $("#modalTambahUser").on("hide.bs.modal", function(e) {
        let modal = $("#modalTambahUser");
        modal.find(".modal-title").html('Tambah Pengguna');
        modal.find('form').attr('action', "{{ route('kelola_pengguna.store') }}");

        modal.find(`[name="role"]`).html(null);
        modal.find(`[name="role"]`).removeAttr('disabled');
        modal.find(`[name="role"]`).val(null).change();
    });
</script>
@endsection
