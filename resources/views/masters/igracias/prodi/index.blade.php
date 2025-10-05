@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Prodi</h4>
    </div>
    <div class="col-md-2 col-12 text-end">
        <button class="btn btn-primary btn-icon" data-bs-toggle="offcanvas" data-bs-target="#modalSlide"><i class="tf-icons ti ti-filter"></i></button>
    </div>
    <div class="col-md-12 d-flex justify-content-between mt-2">
        <p class="text-secondary">Filter Berdasarkan : <i class='tf-icons ti ti-alert-circle text-primary pb-1' data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Universitas : -, Fakultas : -, Prodi : -" id="tooltip-filter"></i></p>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahProdi">Tambah Prodi</button>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table" id="table-master-prodi">
                    <thead>
                        <tr>
                            <th>NOMOR</th>
                            <th>UNIVERSITAS</th>
                            <th>NAMA FAKULTAS</th>
                            <th>NAMA PRODI</th>
                            <th class="text-center">STATUS</th>
                            <th style="min-width:100px;">AKSI</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
@include('masters.prodi.modal')
@endsection

@section('page_script')
<script>

    $("#modalTambahProdi").on("hide.bs.modal", function() {
        $("#modal-title").html("Tambah Prodi");
    });

    function getDataSelect(e) {
        let idElement = e.attr('data-after');
        $.ajax({
            url: `{{ route('prodi') }}?selected=` + e.val(),
            type: 'GET',
            success: function (response) {
                $(`#${idElement}`).find('option:not([disabled])').remove();
                $(`#${idElement}`).val(null).trigger('change');
                $.each(response.data, function () {
                    $(`#${idElement}`).append(new Option(this.namafakultas, this.id_fakultas));
                });
            }
        });
    }

    function edit(e) {
        let id = e.attr('data-id');

        let action = `{{ route('prodi.update', ['id' => ':id']) }}`.replace(':id', id);
        var url = `{{ route('prodi.edit', ['id' => ':id']) }}`.replace(':id', id);
        let modal = $('#modalTambahProdi');

        modal.find(".modal-title").html("Edit Prodi");
        modal.find('form').attr('action', action);
        modal.modal('show');

        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                $.each(response, function ( key, value ) {
                    let element = modal.find(`#${key}`);
                    if (element.is('select') && element.find('option').length <= 1) {
                        let interval = setInterval(() => {
                            if (element.children('option').length > 1) {
                                element.val(value).trigger('change');
                                clearInterval(interval);
                            }
                        }, 10);
                    } else {
                        element.val(value).trigger('change');
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        table_master_prodi();
    });

    $(document).on('submit', '#filter', function(e) {
        const offcanvasFilter = $('#modalSlide');
        e.preventDefault();
        table_master_prodi();
        $('#tooltip-filter').attr('data-bs-original-title', 'Universitas: ' + $('#univ :selected').text() + ', Fakultas: ' + $('#fakultas :selected').text() + ', Prodi: ' + $('#prodi :selected').text());
        offcanvasFilter.offcanvas('hide');
    });

    $('.data-reset').on('click', function() {
        $('#univ').val(null).trigger('change');
        $('#fakultas').val(null).trigger('change');
        $('#prodi').val(null).trigger('change');
    });

    function table_master_prodi() {
        var table = $('#table-master-prodi').DataTable({
            ajax: {
                url: "{{ url('master/prodi/show') }}",
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
            // deferRender: true,
            destroy: true,
            columns: [{
                    data: "DT_RowIndex"
                },
                {
                    data: "univ.namauniv"
                },
                {
                    data: "fakultas.namafakultas"
                },
                {
                    data: "namaprodi"
                },
                {
                    data: "status"
                },
                {
                    data: "action"
                }
            ]
        });
    }

    function afterAction(response) {
        $('#modalTambahProdi').modal('hide');
        afterUpdateStatus(response);
    }

    function afterUpdateStatus(response) {
        table_master_prodi();
    }
</script>
@endsection