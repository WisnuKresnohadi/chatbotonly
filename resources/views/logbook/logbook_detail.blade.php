@extends('partials.horizontal_menu')

@section('page_style')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <a href="{{ route('logbook') }}" type="button" class="btn btn-outline-primary mt-4 mb-3 waves-effect">
        <span class="ti ti-arrow-left me-2"></span>Kembali
    </a>
    <div class="col-md-10 col-12">
        <h4 class="fw-bold"> <span class="text-muted fw-light text-xs">Kegiatan Saya / </span> Logbook Mahasiswa - Periode {{ Carbon\Carbon::parse($data->start_date)->format('d') }}&ensp;-&ensp;{{ Carbon\Carbon::parse($data->end_date)->format('d F Y') }}</h4>
    </div>
    <div class="col-12">
        <div class="card mb-4 ">
            <div class="user-profile-header-banner">
                <img src="{{ asset('assets/logbookbg.png') }}" alt="Banner image" class="rounded-top" width="100%" style="height: 129px !important;" />
            </div>
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4" style="justify-content: space-between !important;">
                <div class="flex-shrink-0 mt-n5 mx-sm-0 mx-auto ms-0 ms-sm-5">
                    <div class="text-center mb-4" style="overflow: hidden; width: 150px; height: 150px;">
                        @if ($mahasiswa->profile_picture)
                            <img src="{{ asset('storage/' . $mahasiswa->profile_picture) }}" alt="user-avatar" class="d-block" width="150" id="image_industri">
                        @else
                            <img src="{{ asset('app-assets/img/avatars/user.png') }}" alt="user-avatar" class="d-block" width="150" id="image_industri">
                        @endif
                    </div>
                    <div style="margin-top: 24px;">
                        <h4>{{ $mahasiswa->namamhs }}</h4>
                        <ul class="list-inline mb-0 align-items-center gap-2">
                            <li class="mb-2">{{ $mahasiswa->nim }}&ensp;-&ensp;{{ $mahasiswa->namaprodi }}</li>
                            <li>{{ $mahasiswa->namauniv }}</li>
                        </ul>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="card-body" style="width: 400px !important;" id="container-percentage">
                        @include('logbook.components.percentage')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4" style="padding-left: 10px; padding-right:10px;">
            <div id="container-left-card" class="text-center" style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 20px;  height: fit-content !important; background-color:white">
                @include('logbook.components.left_card_detail')
            </div>
            @if (isset($data->alasan_tolak))
            <div class="fw-bold mt-3" style="border: 1px solid #D3D6DB; border-radius: 6px; padding: 20px;height: fit-content !important; background-color:white;">
                <p>Alasan penolakan logbook :</p>
                <p class="fw-normal">{{ $data->alasan_tolak }}</p>
            </div>
            @endif
        </div>
        <div class="col-8">
            <div id="container-logbook-daily">
                @include('logbook.components.card_daily')
            </div>
        </div>
    </div>
</div>

@include('logbook.components.modal_daily')

@endsection

@section('page_script')
<script>
    function changeImage(e) {
        let dataOriginalSrc = e.attr('data-original-src');
        let dataSelectedSrc = e.attr('data-selected-src');

        let modal = $('#modalEditJadwal');
        
        $('.image-emot').each(function () {
            $(this).attr('src', $(this).attr('data-original-src'));
            $(this).attr('data-selected', 'false');
        });

        e.attr('src', dataSelectedSrc);
        e.attr('data-selected', 'true');
        modal.find('input[name="emoticon"]').val(e.attr('data-bobot'));
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

    function createLogbookDay(e) {
        let date = e.attr('data-date');
        let modal = $('#modalEditJadwal');
        let form = modal.find('form');

        form.attr('action', "{{ route('logbook.create_logbook_daily', $data->id_logbook_week) }}");
        form.find('input[name="date"]').val(date);
        modal.find('.date-formated').html(dateFormat(date));

        modal.modal('show');
    }

    function changeLogbookType(e){
        $.ajax({
            url: `{{ route('logbook.change_type', $data->id_logbook_week) }}`,
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                date: e.attr('data-date'),
                type: e.is(':checked') ? 'libur' : 'daily'
            },
            success: function (response) {
                $('#container-logbook-daily').html(response.data.view);
                $('#container-left-card').html(response.data.view_left_card);
                $('#container-percentage').html(response.data.view_percentage);
            }
        });
    }

    function changeLogbookLibur(e) {
        let modal = $('#modalEditJadwal');
        modal.find('button').attr('disabled', true);

        showSweetAlert({
            icon: 'warning',
            title: 'Yakin?',
            text: 'Ini akan menghapus laporan harian yang sudah dibuat.',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ route('logbook.change_type', $data->id_logbook_week) }}`,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        date: modal.find('input[name="date"]').val(),
                        type: 'libur'
                    },
                    success: function (response) {
                        $('#container-logbook-daily').html(response.data.view);
                        $('#container-left-card').html(response.data.view_left_card);
                        $('#container-percentage').html(response.data.view_percentage);
                        modal.modal('hide');
                        modal.find('button').attr('disabled', false);
                    },
                    error: function (response) {
                        modal.find('button').attr('disabled', false);
                        showSweetAlert({
                            icon: 'error',
                            title: 'Error',
                            text: response.responseJSON.message
                        });
                    }
                });
            } else {
                modal.find('button').attr('disabled', false);
            }
        });
    }

    function afterCreateLogbookday(response) {
        let modal = $('#modalEditJadwal');
        $('#container-logbook-daily').html(response.data.view);
        $('#container-left-card').html(response.data.view_left_card);
        $('#container-percentage').html(response.data.view_percentage);
        modal.modal('hide');
    }

    function editLogbookDay(e) {
        let dataId = e.attr('data-id');
        let modal = $('#modalEditJadwal');
        let form = modal.find('form');

        form.attr('action', "{{ route('logbook.update_logbook_daily', ['id' => ':id']) }}".replace(':id', dataId));

        $.ajax({
            url: `{{ route('logbook.detail', $data->id_logbook_week) }}`,
            data: {'section' : 'get_logbook_daily', 'data_id' : dataId},
            type: 'GET',
            success: function (response) {
                modal.find('.date-formated').html(dateFormat(response.data.date));
                form.find('input[name="emoticon"]').val(response.data.emoticon);
                form.find('textarea[name="activity"]').val(response.data.activity);
                form.find('input[name="date"]').val(response.data.date);

                $('.image-emot[data-bobot="'+response.data.emoticon+'"]').click();
            }
        });

        modal.modal('show');
    }

    function applyLogbook(e) {
        btnBlock(e);

        $.ajax({
            url: `{{ route('logbook.apply_logbook', ['id_logbook_week' => $data->id_logbook_week]) }}`,
            type: 'POST',
            data: { _token: "{{ csrf_token() }}" },
            success: function (response) {
                btnBlock(e, false);

                $('#container-left-card').html(response.data.view_left_card);
                $('#container-logbook-daily').html(response.data.view_detail);

                showSweetAlert({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message
                });
            },
            error: function (response) {
                btnBlock(e, false);
                showSweetAlert({
                    icon: 'error',
                    title: 'Error',
                    text: response.responseJSON.message
                });
            }

        });
    }

    $('#modalEditJadwal').on('hide.bs.modal', function () {
        $(this).find('.date-formated').html(null);
        $(this).find('input[name="date"]').val(null);
        $(this).find('input[name="emoticon"]').val(null);
        let form = $(this).find('form');

        $('.image-emot').each(function () {
            $(this).attr('src', $(this).attr('data-original-src'));
            $(this).attr('data-selected', 'false');
        });
    });

    function dateFormat(date) {
        date = new Date(date);
        return new Intl.DateTimeFormat('id-ID', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        }).format(date);
    }
</script>
@endsection