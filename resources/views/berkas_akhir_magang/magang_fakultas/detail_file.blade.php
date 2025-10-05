@extends('partials.vertical_menu')

@section('page_style')
<link rel="stylesheet" href="{{ asset('app-assets/css/pdfviewer.jquery.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-start mb-3">
    <a href="{{ route('berkas_akhir_magang.fakultas') }}" class="btn btn-outline-primary">
        <i class="ti ti-arrow-left"></i>
        Kembali
    </a>
</div>
<div class="row">
    <div class="col-12 mb-2 card">
        <div class="row card-body">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6"><h6 class="mb-1">NIM:</h6></div>
                            <div class="col-md-6">{{$mahasiswa->nim ?? '-'}}</div>
                            <div class="col-md-6"><h6 class="mb-1">Nama:</h6></div>
                            <div class="col-md-6">{{$mahasiswa->namamhs ?? '-'}}</div>
                            <div class="col-md-6"><h6 class="mb-1">Program Studi:</h6></div>
                            <div class="col-md-6">{{$mahasiswa->namaprodi ?? '-'}}</div>
                            <div class="col-md-6"><h6 class="mb-1">Pembimbing Lapangan:</h6></div>
                            <div class="col-md-6">{{$mahasiswa->namapeg ?? '-'}}</div>
                            <div class="col-md-6"><h6 class="mb-1">Pembimbing Akademik:</h6></div>
                            <div class="col-md-6">{{$mahasiswa->namadosen ?? '-'}}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6"><h6 class="mb-1">Nama Perusahaan:</h6></div>
                            <div class="col-md-6">{{$mahasiswa->namaindustri ?? '-'}}</div>
                            <div class="col-md-6"><h6 class="mb-1">Posisi Magang:</h6></div>
                            <div class="col-md-6">{{$mahasiswa->intern_position ?? '-'}}</div>
                            <div class="col-md-6"><h6 class="mb-1">Tanggal mulai magang:</h6></div>
                            <div class="col-md-6">{{$mahasiswa->startdate_magang ?? '-'}}</div>
                            <div class="col-md-6"><h6 class="mb-1">Tanggal Akhir magang:</h6></div>
                            <div class="col-md-6">{{$mahasiswa->enddate_magang ?? '-'}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3" id="container-right-card">
                @include('berkas_akhir_magang/magang_fakultas/components/right_card_detail')
            </div>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-center">
        <div id="pdfviewer" class="mb-5"></div>
    </div>
</div>
@include('berkas_akhir_magang/magang_fakultas/components/modal_detail_file')
@endsection

@section('page_script')
@include('berkas_akhir_magang/magang_fakultas/script_js_detail_file')
<script>
    function reject() {
        let modal = $('#modal-detail-file');
        modal.find('form').find('input[name="status"]').val('reject');
        modal.modal('show');
    }

    function afterReject(res) {
        $('#container-right-card').html(res.data.view);
        $('#modal-detail-file').modal('hide');
        settingBadgeCount(res.data.count);
    }

    function approve() {
        sweetAlertConfirm({
            title: 'Apakah anda yakin ingin menyetujui berkas?',
            text: 'Harap pastikan data sudah benar!',
            icon: 'warning',
            confirmButtonText: 'Ya, Yakin',
            cancelButtonText: 'Batal',
        }, function () {
            $.ajax({
                url: `{{ $url }}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: 'approve'
                },
                success: function (res) {
                    let modal = $('#modal-detail-file');
                    showSweetAlert({
                        title: 'Berhasil!',
                        text: res.message,
                        icon: 'success'
                    });
                    $('#container-right-card').html(res.data.view);
                    modal.modal('hide');

                    settingBadgeCount(res.data.count);

                },
                error: function (res) {
                    showSweetAlert({
                        title: 'Gagal!',
                        text: res.responseJSON.message,
                        icon: 'error'
                    });
                }
            });
        });
    }

    function settingBadgeCount(total) {
        
        if (total != false) {
            if (total > 0) {
                $('#berkas_akhir_magang_fakultas_count').html(total);
                $('.berkas_akhir_magang_fakultas_count').html(total);
            } else {
                $('#berkas_akhir_magang_fakultas_count').addClass('d-none');
                $('.berkas_akhir_magang_fakultas_count').addClass('d-none');
            }
        }
    }   
</script>
@endsection