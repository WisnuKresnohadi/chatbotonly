@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
<div class="row mb-3">
    <div class="col-md-6 col-12">
        <h4 class="fw-bold text-sm">Roles</h4>
    </div>
    <div class="col-md-6 col-12 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-konfigurasi">Tambah Role</button>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="card-datatable table-responsive">
            <table class="table" id="table-konfig-role">
                <thead>
                    <tr>
                        <th>NOMOR</th>
                        <th>NAMA ROLE</th>
                        <th style="text-align: center;">AKSI</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@include('konfigurasi.modal')
@endsection

@section('page_script')
<script>
    var table = $('#table-konfig-role').DataTable({
        ajax: '{{ route("roles.show") }}',
        processing: true,
        serverSide: false,
        deferrender: true,
        type: 'GET',
        destroy: true,
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'action',
                name: 'action'
            }
        ]
    });

    $('.all_checked').on('click', function() {
        const allCheckedCheckbox = $(this);
        $('.checkbox').each(function() {
            $(this).prop('checked', allCheckedCheckbox.prop('checked'));
        });
    });

    function afterAction(response) {
        $('#modal-konfigurasi').modal('hide');
        $('#table-konfig-role').DataTable().ajax.reload();
    }

    function edit(e) {
        let dataId = e.attr('data-id');
        let modal = $('#modal-konfigurasi');
        modal.find('.modal-title').html('Edit Role');
        modal.find('form').attr('action', '{{ route("roles.update", ":id") }}'.replace(':id', dataId));
        modal.modal('show');

        $.ajax({
            url: '{{ route("roles.edit", ["id" => ":id"]) }}'.replace(':id', dataId),
            type: 'GET',
            success:function (response) {
                let { role, permissions } = response.data;
                $('#name').val(role);
                permissions.forEach(data => {
                    const checkbox_ = $('.checkbox').filter((index, e) => e.value == data);
                    if (checkbox_.length > 0) {
                        checkbox_.prop('checked', true);
                    }
                });

                checkCheckboxCheckAll();
            }
        });
    }

    $('.checkbox').on('click', function() {
        checkCheckboxCheckAll();
    });

    function checkCheckboxCheckAll() {
        if ($('.checkbox').filter(':checked').length == $('.checkbox').length) {
            $('.all_checked').prop('checked', true);
        } else {
            $('.all_checked').prop('checked', false);
        }
    }

    $('#modal-konfigurasi').on('hidden.bs.modal', function () {
        $(this).find('.modal-title').html('Tambah Role');
        $(this).find('form').attr('action', '{{ route("roles.store") }}'); 
    });
</script>
@endsection