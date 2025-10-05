@extends('partials.horizontal_menu')

@section('page_style')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-12 col-12 mt-3">
        <h4 class="fw-bold"><span class="text-muted fw-light">Kegiatan Saya /</span> Berkas Akhir Magang</h4>
    </div>
    <div id="container-berkas">
        @include('kegiatan_saya/berkas_akhir/components/card')
    </div>
</div>

<!-- Modal Laporan Harian Magang -->
<div class="modal fade" id="modallaporanharian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mx-auto"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="default-form" action="" function-callback="afterAction">
                @csrf
                <input type="hidden" name="data_id">
                <div class="modal-body py-1">
                    <div class="row">
                        <div class="col mb-0 form-group">
                            <label for="formFile" class="form-label">Upload File</label>
                            <input class="form-control" type="file" name="file" id="formFile">
                            <div class="invalid-feedback"></div>
                            <p class="pt-2" style="font-size: small;">Allowed PDF. Max size of 2 MB</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="me-0 mb-0 btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('page_script')
<script>
    $(document).on('click', '.btn-upload-berkas', function () {
        let dataBerkas = $(this).attr('data-berkas');
        let dataId = $(this).attr('data-id');
        let modal = $('#modallaporanharian');
        let form = modal.find('form');

        form.find('input[name="data_id"]').val(dataId);
        form.attr('action', "{{ route('berkas_akhir.store', ['id' => ':id']) }}".replace(':id', dataId));

        modal.find('.modal-title').text(dataBerkas);
        modal.modal('show');
    });

    function afterAction(response) {
        $('#modallaporanharian').modal('hide');
        $('#container-berkas').html(response.data.view_card);
    }
</script>
@endsection