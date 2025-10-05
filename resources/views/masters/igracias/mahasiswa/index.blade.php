@extends('partials.vertical_menu')

@section('page_style')
  <style>
    .tooltip .tooltip-inner {
        max-width: 800px !important;
    }
  </style>
@endsection


@section('content')
<div class="row">
    <div class="col-md-10 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Mahasiswa</h4>
    </div>
    <div class="col-md-2 col-12 text-end">
        <button class="btn btn-success waves-effect waves-light" data-bs-toggle="offcanvas" data-bs-target="#modalSlide"> <i class="tf-icons ti ti-filter"></i></button>
    </div>
    <div class="col-md-12 d-flex justify-content-between mt-2">
        <p class="text-secondary">Filter Berdasarkan : <i class='tf-icons ti ti-alert-circle text-primary pb-1' data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Universitas : -, Fakultas : -, Prodi : -" id="tooltip-filter"></i></p>
        <div class="btn-group">
            <button type="button" class="btn btn-success dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                Tambah Mahasiswa
            </button>
            <ul class="dropdown-menu" style="">
                <li><a class="dropdown-item btn text-success ti ti-upload d-block pe-15" data-bs-toggle="modal" data-bs-target="#modal-import">Import</a></li>
                <li><a class="dropdown-item btn text-success" data-bs-toggle="modal" data-bs-target="#modal-mahasiswa">Tambah Mahasiswa</a></li>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table" id="table-master-mahasiswa">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA/NIM</th>
                            <th>UNIVERSITAS & FAKULTAS</th>
                            <th class="text-center">TUNGGAKAN BPP</th>
                            <th class="text-center">IPK</th>
                            <th class="text-center">EPRT</th>
                            <th class="text-center">TAK</th>
                            <th class="text-center">ANGKATAN</th>
                            <th>KONTAK</th>
                            <th>ALAMAT</th>
                            <th class="text-center">STATUS</th>
                            <th style="text-center;">AKSI</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

@include('masters.mahasiswa.modal')

@endsection

@section('page_script')
<script>
    function getDataSelect(e) {
        let idElement = e.attr('data-after');
        let modalId = e.closest('.modals').attr('id');

        $(`#${modalId} #${idElement}`).find('option:not([disabled])').remove();
        $(`#${modalId} #${idElement}`).val(null).trigger('change');

        if (e.val() == null) return;
        
        $.ajax({
            url: `{{ route('igracias.mahasiswa') }}?type=${idElement}&selected=` + e.val(),
            type: 'GET',
            success: function (response) {
                $.each(response.data, function () {
                    $(`#${modalId} #${idElement}`).append(new Option(this.text, this.id));
                });
            }
        });
    }

    function afterUpdateStatus(response) {
        $('#table-master-mahasiswa').DataTable().ajax.reload();
    }

    function afterAction(response) {
        $('#modal-mahasiswa, #modal-import').modal('hide');
        afterUpdateStatus(response);
    }

    $("#modal-mahasiswa").on("hide.bs.modal", function() {
        $("#modal-title").html("Tambah Mahasiswa");
        $("#modal-button").html("Save Data");
    });

    $("#modal-import").on("hide.bs.modal", function() {

        $("#buttonImport").html("Save Data");
    });

    function edit(e) {
        let id = e.attr('data-id');

        let action = `{{ route('igracias.mahasiswa.update', ['id' => ':id']) }}`.replace(':id', id);
        var url = `{{ route('igracias.mahasiswa.edit', ['id' => ':id']) }}`.replace(':id', id);
        let modal = $(`#modal-mahasiswa`);
        let form = modal.find('form');

        modal.find(".modal-title").html("Edit Mahasiswa");
        form.find('button[type="submit"]').html("Update Data")
        form.attr('action', action);
        modal.modal('show');

        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                $.each(response, function ( key, value ) {
                    let element = form.find(`[name="${key}"]`);
                    console.log(key)
                    if (element.is('select') && element.find('option').length <= 1) {
                        let interval = setInterval(() => {
                            if (element.children('option').length > 1) {
                                element.val(value).trigger('change');
                                clearInterval(interval);
                            }
                        }, 100);
                    } else if (element.is('[type="radio"]')) {
                        $(`[name="${key}"][value="${value}"]`).prop("checked", true);
                    } else {
                        element.val(value).trigger('change');
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        table_master_mahasiswa();
    });

    $(document).on('submit', '#filter', function(e) {
        const offcanvasFilter = $('#modalSlide');
        e.preventDefault();
        table_master_mahasiswa();
        $('#tooltip-filter').attr('data-bs-original-title', 'Universitas: ' + $(this).find('#id_univ :selected').text() +
            ', Fakultas: ' + $(this).find('#id_fakultas :selected').text() + ', Prodi: ' + $(this).find('#id_prodi :selected').text());
        offcanvasFilter.offcanvas('hide');
    });

    $('.data-reset').on('click', function() {
        const form = $(this).closest('form'); 
        form.find('#id_univ').val(null).trigger('change'); 
        form.find('#id_fakultas').val(null).trigger('change'); 
        form.find('#id_prodi').val(null).trigger('change'); 
    });


    function table_master_mahasiswa() {
        var table = $('#table-master-mahasiswa').DataTable({
            ajax: {
                url: "{{ url('master/igracias/mahasiswa/show') }}",
                type: 'POST',
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: function(d) {
                    var frm_data = $('#filter').serializeArray();
                    $.each(frm_data, function(key, val) {
                        d[val.name] = val.value;
                    });
                }
            },
            serverSide: false,
            processing: true,
            scrollX: true,
            // deferRender: true,
            destroy: true,
            columns: [
                { data: "DT_RowIndex" },
                { data: 'name', name: 'name' },
                { data: 'univ_fakultas', name: 'univ_fakultas' },
                { data: 'tunggakan_bpp', name: 'tunggakan_bpp' },
                { data: 'ipk', name: 'ipk' },
                { data: 'eprt', name: 'eprt' },
                { data: 'tak', name: 'tak' },
                { data: 'angkatan', name: 'angkatan' },
                { data: 'contact', name: 'contact' },
                { data: 'alamatmhs', name: 'alamatmhs' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action' },
            ]
        });
    }
</script>
@endsection