@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
<div class="d-flex justify-content-start">
    <a href="{{ $urlBack }}" class="btn btn-outline-primary mb-3 waves-effect">
        <span class="ti ti-arrow-left me-2"></span>Kembali
    </a>
</div>
<div class="d-flex justify-content-start">
    <h4 class="fw-bold"><span class="text-muted fw-light">Kelola Mahasiswa /</span> Detail Logbook {{ $mahasiswa->namamhs }}</h4>
</div>
<div class="card">
    <div class="card-body">
        <div style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 20px; height: fit-content !important; min-width: 320px !important;">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-left">
                        <div class="text-center my-4" style="overflow: hidden; width: 80px; height: 80px;">
                            @if ($mahasiswa->profile_picture)
                                <img src="{{ asset('storage/' . $mahasiswa->profile_picture) }}" alt="user-avatar" class="d-block" width="80" id="image_industri">
                            @else
                                <img src="{{ asset('app-assets/img/avatars/user.png') }}" alt="user-avatar" class="d-block" width="80" id="image_industri" data-default-src="{{ asset('app-assets/img/avatars/user.png') }}">
                            @endif
                        </div>
                        <div class="row pt-3 ms-3">
                            <h3 class="mb-4">{{ $mahasiswa->namamhs }}</h3>
                            {{-- <div class="col-xl-8"> --}}
                            <div class="col-8">
                                <h5 class="mb-3">Informasi Kegiatan</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h6 class="mb-1">Program Magang</h6>
                                        <span>{{ $mahasiswa->namajenis ?? '-' }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="mb-1">Durasi Magang</h6>
                                        <span>{{ $mahasiswa->durasimagang ?? '-' }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="mb-1">Periode Kegiatan</h6>
                                        <span>{{ $periode_magang ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <h5 class="mb-3">Informasi Tambahan</h5>
                                <div class="row">
                                    <div class="col-6">
                                        <h6 class="mb-1">Lokasi Magang</h6>
                                        <span>{{ $mahasiswa->namaindustri ?? '-' }}</span>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="mb-1">Posisi</h6>
                                        <span>{{ $mahasiswa->intern_position ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex mt-4">
            <div class="col-4">
                <div class="" style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 15px; margin-right: 10px; height: fit-content !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col">
                            <p class="fw-bold mb-0">Silahkan Pilih Bulan</p>
                        </div>
                        <div class="col-4">
                            <select class="select2 form-select" id="selected_month" onchange="getListWeek($(this))" data-placeholder="Filter Status">
                                @foreach ($list_month as $key => $item)
                                <option value="{{ $key }}" {{ ($key + 1) == Carbon\Carbon::now()->format('m') ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="border-bottom mt-3 mb-3"></div>
                    <div id="container_left_card">
                        @include('kelola_mahasiswa/logbook/components/left_card_week')
                    </div>
                </div>
            </div>
            <div class="col" id="container_detail_logbook_weekly"></div>
        </div>
        @if (isset($isPembLapangan) && $isPembLapangan == true)
        @include('kelola_mahasiswa/logbook/components/modal')
        @endif
    </div>
</div>
@endsection

@section('page_script')
<script>
    $(document).ready(function () {
        getLogbook();
    });

    function getLogbook(e = null) {
        if (e != null) {
            $('input[name="selected_logbook"]').prop('checked', false);
            e.find('input[name="selected_logbook"]').prop('checked', true);
        }

        let selected = $(`input[name="selected_logbook"]:checked`);
        // if (!selected.val()) return;
        
        sectionBlock($('#container_detail_logbook_weekly'));
        loadData({
            section: 'get_logbook_week',
            data_id: selected.val(),
            week: selected.attr('data-week')
        }).then(function (res) {
            if (res.code >= 200) {
                // success
            }
        });

        sectionBlock($('#container_detail_logbook_weekly', false));
    }

    function getListWeek(e) {
        loadData({
            section: 'get_list_week',
            selected_month: e.val()
        }).then(function (res) {
            if (res.code >= 200) getLogbook();
        });
    }

    function loadData(data) {
        return $.ajax({
            url: `{{ $url_get }}`,
            data: data,
            type: "GET",
            success: function (response) {
                $.each(response.data, function (key, value) {
                    if (key.includes('container_')) $('#' + key).html(value);
                });
            }
        });
    }

    $(document).on('click', '.show_hide_new', function() {
        let siblingsFake = $(this).siblings('.sibling-fake');
        let siblingsReal = $(this).siblings('.sibling-real');
        
        let dataShortened = $(this).attr('data-shortened');

        if (dataShortened == 'true') {
            siblingsFake.addClass('d-none');
            siblingsReal.removeClass('d-none');

            $(this).text('Show Less');
            $(this).attr('data-shortened', 'false');
        } else {
            siblingsFake.removeClass('d-none');
            siblingsReal.addClass('d-none');

            $(this).text('Show More');
            $(this).attr('data-shortened', 'true');
        }
    });

    @if (isset($isPembLapangan) && $isPembLapangan == true)
    $(document).on('click', '#btn-approve', function () {
        let dataId = $(this).attr('data-id');
        let week = $(this).attr('data-week');

        sweetAlertConfirm({
            title: 'Apakah logbook mahasiswa sudah sesuai dengan yang dikerjakan?',
            text: 'Status logbook akan otomatis berubah!',
            icon: 'warning',
            confirmButtonText: 'Ya, Sudah',
            cancelButtonText: 'Batal',
        }, function () {
            $.ajax({
                url: `{{ route('kelola_magang_pemb_lapangan.approval', ['id' => ':id']) }}`.replace(':id', dataId),
                type: "POST",
                data: { _token: "{{ csrf_token() }}", status: 'approved', week: week, selected_month: $('#selected_month').val()},
                success: function (response) {
                    $('#container_left_card').html(response.data.view_left_card);
                    $('#container_detail_logbook_weekly').html(response.data.view_logbook);

                    showSweetAlert({
                        title: 'Berhasil',
                        text: response.message,
                        icon: 'success',
                    });
                }
            });
        });
    });

    $(document).on('click', '#btn-reject', function () {
        let dataId = $(this).attr('data-id');
        let week = $(this).attr('data-week');
        let selected_month = $('#selected_month').val();
        let modal = $('#modalDitolak');
        let form = modal.find('form');

        console.log(selected_month);
        

        form.attr('action', `{{ route('kelola_magang_pemb_lapangan.approval', ['id' => ':id']) }}`.replace(':id', dataId))
        modal.find('.modal-title').text('Anda Menolak Logbook Minggu ke-' + week + ', Silahkan Memberikan Komentar!');
        form.find('input[name="status"]').val('rejected');
        form.find('input[name="week"]').val(week);
        form.find('input[name="selected_month"]').val(selected_month);
        modal.modal('show');
    });

    function afterApprovalLogbook(response) {
        $('#container_left_card').html(response.data.view_left_card);
        // $('#container_rejected_reason').html(response.data.view_rejected_reason);
        $('#container_detail_logbook_weekly').html(response.data.view_logbook);
        $('#modalDitolak').find('.modal-title').text('');
        $('#modalDitolak').modal('hide');
    }
    @endif
</script>
@endsection