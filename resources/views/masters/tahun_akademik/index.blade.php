@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Tahun Akademik</h4>
    </div>
    <div class="col-md-6 col-12 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-thn-akademik">Tambah Tahun Akademik</button>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table" id="table-master-tahun-akademik">
                    <thead>
                        <tr>
                            <th>NOMOR</th>
                            <th>TAHUN AJARAN</th>
                            <th>SEMESTER</th>
                            <th>TANGGAL PENDAFTARAN MAGANG</th>
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
@include('masters.tahun_akademik.modal')
@endsection

@section('page_script')
<script>
    $('#table-master-tahun-akademik').DataTable({
        ajax: '{{ route("thn-akademik.show") }}',
        serverSide: false,
        processing: true,
        deferRender: true,
        type: 'GET',
        destroy: true,
        columns: [{
                data: "DT_RowIndex"
            },
            {
                data: 'tahun',
                name: 'tahun'
            },
            {
                data: 'semester',
                name: 'semester'
            },
            {
                data: 'pendaftaran_magang',
                name: 'pendaftaran_magang',
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
        let action = "{{ route('thn-akademik.update', ['id' => ':id']) }}".replace(':id', id);
        var url = "{{ route('thn-akademik.edit', ['id' => ':id']) }}".replace(':id', id);
        let modal = $('#modal-thn-akademik');

        modal.find(".modal-title").html("Edit Tahun Akademik");
        modal.find('form').attr('action', action);
        modal.modal('show');

        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                $.each(response.data, function(key, value) {
                    let element = modal.find('form').find(`[name="${key}"]`);
                    element.val(value).trigger('change');
                    if (element.is('.flatpickr-date')) {
                        element.flatpickr({
                            altInput: true,
                            altFormat: 'j F Y',
                            dateFormat: 'Y-m-d',
                            defaultDate: value
                        });
                    }
                });
            }
        });
    }

    function afterAction(response) {
        $("#modal-thn-akademik").modal("hide");
        afterUpdateStatus(response);
    }

    function afterUpdateStatus(response) {
        $('#table-master-tahun-akademik').DataTable().ajax.reload();
    }

    $("#modal-thn-akademik").on("hide.bs.modal", function() {
        let modal = $('#modal-thn-akademik');
        modal.find(".modal-title").html("Tambah Tahun Akademik");
        modal.find("input[name='tahun']").val("{{ now()->format('Y') }}/{{ now()->addYear()->format('Y') }}");
        modal.find('form').attr('action', "{{ route('thn-akademik.store') }}");
    });
</script>
@endsection