@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 col-12">
        <h4 class="fw-bold"><span class="text-muted fw-light">Master Data /</span> Nilai Akhir</h4>
    </div>
    <div class="col-md-6 col-12 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-nilai-akhir">Tambah Presentase Nilai</button>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table" id="table-master-nilai-akhir">
                    <thead>
                        <tr>
                            <th>NOMOR</th>
                            <th>Program Studi</th>
                            <th>Presentase Nilai Pembimbing Lapangan(%)</th>
                            <th>Presentase Nilai Pembimbing Akademik (%)</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@include('masters.nilai_akhir.modal')

@endsection

@section('page_script')
<script>
    var table = $('#table-master-nilai-akhir').DataTable({
        ajax: `{{ route('nilai_akhir.show') }}`,
        serverSide: false,
        processing: true,
        deferRender: true,
        type: 'GET',
        destroy: true,
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'namaprodi', name: 'namaprodi' },
            { data: 'nilai_pemb_lap', name: 'nilai_pemb_lap' },
            { data: 'nilai_pemb_akademik', name: 'nilai_pemb_akademik' },
            { data: 'aksi', name: 'aksi' }
        ]
    });

    function edit(e) {
        let modal = $('#modal-nilai-akhir');
        let form = modal.find('form');

        modal.find('.modal-title').html('Edit Presentase Nilai Akhir');
        modal.find('form').attr('action', `{{ route('nilai_akhir.update', ['id' => ':id']) }}`.replace(':id', e.attr('data-id')));

        $.ajax({
            url: `{{ route('nilai_akhir.edit', ['id' => ':id']) }}`.replace(':id', e.attr('data-id')),
            type: 'GET',
            success: function (res) {
                $.each(res.data, function (key, value) {
                    form.find('[name="' + key + '"]').val(value).change(); 
                });
            }
        });

        modal.modal('show');
    }

    function destroy(e) {
        let dataUrl = e.attr('data-url');

        sweetAlertConfirm({
            title: 'Apakah anda yakin ingin menghapus config?',
            text: 'Data yang dihapus tidak akan bisa dikembalikan lagi',
            icon: 'warning',
            confirmButtonText: 'Ya, saya yakin',
            cancelButtonText: 'Tidak'
        }, function () {
            $.ajax({
                url: dataUrl,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                success: function (res) {
                    afterChangeStatus(res)
                }
            });
        });
    }

    function afterAction(response) {
        $("#modal-nilai-akhir").modal('hide');
        afterChangeStatus(response)
    }

    function afterChangeStatus(response) {
        $('#table-master-nilai-akhir').DataTable().ajax.reload();
    }

    $('#modal-nilai-akhir').on('hidden.bs.modal', function () {
        $(this).find('.modal-title').html('Tambah Presentase Nilai Akhir');;
        $(this).find('form').attr('action', `{{ route('nilai_akhir.store') }}`);
    });
</script>
@endsection