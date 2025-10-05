@extends('partials.horizontal_menu')

@section('page_style')
<style>
    .flatpickr-day.flatpickr-disabled.inRange {
        color: #a5a3ae !important;
        background: none !important;
        border: 1px solid transparent !important;
    }

    .flatpickr-day.flatpickr-disabled.today.inRange {
        color: #a5a3ae !important;
        background: none !important;
        border: 1px solid transparent !important;
    }

    .flatpickr-day.flatpickr-disabled.week.selected {
        color: #a5a3ae !important;
        background: none !important;
        border: 1px solid transparent !important;
        box-shadow: none !important;
    }
</style>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-10 col-12 mb-4">
        <h4 class="fw-bold"> <span class="text-muted fw-light text-xs">Kegiatan Saya / </span> Logbook Mahasiswa</h4>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="user-profile-header-banner">
                <img src="{{ asset('assets/logbookbg.png') }}" alt="Banner image" class="rounded-top" width="100%" style="height: 129px !important;" />
            </div>
            <div class="user-profile-header text-sm-start text-center mb-4" style="justify-content: space-between !important;">
                <div class="flex-shrink-0 mt-n5 mx-sm-0 mx-auto ms-0 ms-sm-5">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="text-center mb-4" style="overflow: hidden; width: 150px; height: 150px;">
                                @if ($data->image)
                                <img src="{{ asset('storage/' . $data->image) }}" alt="user-avatar" class="d-block" width="150" id="image_industri">
                                @else
                                <img src="{{ asset('app-assets/img/avatars/user.png') }}" alt="user-avatar" class="d-block" width="150" id="image_industri">
                                @endif
                            </div>
                            <div style="margin-top: 24px;">
                                <h2 class="mb-1">{{ $data->intern_position }}</h2>
                                <span>{{ $data->namaindustri ?? '-' }}</span>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <h4 class="mb-1">Pembimbing Akademik</h4>
                                    <span>{{ $data->namadosen ?? '-' }}</span>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="mb-1">Pembimbing Lapangan</h4>
                                    <span>{{ $data->namapeg ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <h4 class="mb-1">Program Magang</h4>
                                    <span>{{ $data->namajenis ?? '-' }}</span>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="mb-1">Durasi Magang</h4>
                                    <span>{{ $data->durasimagang ?? '-' }}</span>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="mb-1">Periode Kegiatan</h4>
                                    <span>{{ $periode_magang ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-5 d-flex flex-column justify-content-center">
                            <div class="me-5 mt-3" id="percentage_container">
                                @include('logbook.components.percentage')
                            </div>
                            <div class="pe-4">
                                @isset($id_logbook)
                                <a class="btn btn-outline-primary mt-3" tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog" aria-expanded="false" href="{{ route('logbook.print_logbook', $id_logbook) }}"><span><i class="ti ti-download me-sm-1"></i> <span class="d-none d-sm-inline-block">Ekspor PDF</span></span></a>
                                @else
                                <a class="btn btn-secondary mt-3" tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog" aria-expanded="false" href="#"><span><i class="ti ti-download me-sm-1"></i> <span class="d-none d-sm-inline-block">Ekspor PDF</span></span></a>
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="my-4 d-flex justify-content-between">
        <h4>Logbook Mahasiswa - <span id="selected_month">{{ Carbon\Carbon::now()->format('F') }}</span></h4>
        <div class="col-2">
            <select class="select2 form-select" onchange="filter();" id="select_month" data-placeholder="Silahkan Pilih Bulan">
                @foreach ($list_month as $key => $item)
                    <option value="{{ $key }}" {{ ($key + 1) == Carbon\Carbon::now()->format('m') ? 'selected' : '' }}>{{ $item }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div id="container-logbook-week">
        @include('logbook/components/card_weekly')
    </div>

    <div class="d-flex justify-content-center">
        <button type="button" onclick="createLogbook()" class="btn btn-primary">Buat Logbook Minggu ini</button>
    </div>
    
</div>

@include('logbook.components.modal')
{{-- @include('logbook.logbook_print') --}}
@endsection

@section('page_script')
<script>
    var filterData;
    function filter() {
        filterData = $('#select_month').val();
        $('#selected_month').html($('#select_month').find(':selected').text());

        loadData();
    }

    function loadData() {
        $.ajax({
            url: `{{ route('logbook') }}`,
            type: 'GET',
            data: { section: 'get_logbook_week', current_month: filterData },
            success: function (response) {
                $('#container-logbook-week').html(response.data.view_card_weekly);
            },
        })
    }

    function createLogbook() {
        let modal = $('#modal_logbook');

        let startDate = new Date(`{{ $data->startdate_magang }}`);
        startDate.setHours(1);
        let endDate = new Date(`{{ $data->enddate_magang }}`);

        const formatDate = (date) => {
            let day = ("0" + date.getDate()).slice(-2);
            let month = ("0" + (date.getMonth() + 1)).slice(-2);
            let year = date.getFullYear();
            return `${day}-${month}-${year}`;
        };

        const funcDate = (selectedDates, dateStr, instance) => {
            if (selectedDates.length > 0) {
                let start_date = new Date(selectedDates[0]);
                let day = start_date.getDay();
                start_date.setDate(start_date.getDate() - day);
    
                let end_date = new Date(start_date);
                end_date.setDate(start_date.getDate() + 6);
    
                if (start_date < startDate) start_date = startDate;
                if (end_date > endDate) end_date = endDate;
                
                const formattedDateRange = `${formatDate(start_date)} to ${formatDate(end_date)}`;
                instance.input.value = formattedDateRange;
            }
        }

        console.log(startDate, endDate);
        

        $('#range_date').flatpickr({
            plugins: [new weekSelect({})],
            enableTime: false,
            minDate: startDate,
            maxDate: endDate,
            onChange: funcDate,
            onClose: funcDate
        });

        let current_month = $('#select_month').val();
        $('#selected_month').html($('#select_month').find(':selected').text());

        modal.find('input[name="current_month"]').val(current_month);
        modal.modal('show');
    };

    function afterCreateLogbook(response) {
        $('#modal_logbook').modal('hide');
        $('#container-logbook-week').html(response.data.view);
    }
</script>
@endsection