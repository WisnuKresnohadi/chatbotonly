@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
@isset ($urlBack)
<a href="{{ $urlBack }}" class="btn btn-outline-primary mb-3 mt-2">
    <i class="ti ti-arrow-left me-2"></i>
    <span>Kembali</span>
</a>
@endisset
<div class="row ">
    <div class="mb-2">
        <h4 class="fw-bold text-sm modal-title"><span class="text-muted fw-light text-xs">Master Data/ </span>
            {{ isset($jenismagang) ? 'Edit' : 'Tambah' }} Jenis Magang
        </h4>
    </div>
</div>

<div class="row" id="modal-jenismagang">
    <div class="col-12 mb-4">
        <div class="bs-stepper wizard-numbered mt-2">
            <div class="bs-stepper-header" style="justify-content: center">
                @include('masters.jenis_magang.step.number_step')
            </div>
            <div class="bs-stepper-content">
                <form class="default-form" action="{{ isset($jenismagang) ? route('jenismagang.update', ['id' => $jenismagang->id_jenismagang]) : route('jenismagang.store') }}" function-callback="afterAction">
                    @csrf
                    <div id="jenis_magang">
                        @include('masters.jenis_magang.step.jenis_magang')
                    </div>
                    <div id="detail_dokumen_persyaratan">
                        @include('masters.jenis_magang.step.detail_dokumen_persyaratan')
                    </div>
                    <div id="detail_berkas_magang">
                        @include('masters.jenis_magang.step.detail_berkas_magang')
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_script')
<script>
    $(document).ready(function () {
        loadFlatpickrX();

        @if (isset($jenismagang))
        loadDataEdit();
        @endif
    });

    function loadFlatpickrX() {
        $(".flatpickr-date-x").each(function () {
            let obj = {
                altInput: true,
                altFormat: 'j F Y, H:i',
                dateFormat: 'Y-m-d H:i',
                enableTime: true
            };

            @if (isset($jenismagang) && count($jenismagang->berkas_magang) > 0)
            obj.defaultDate = $(this).val();
            obj.defaultHour = $(this).attr('data-hour');
            obj.defaultMinute = $(this).attr('data-minute');
            @endif

            $(this).flatpickr(obj);
        });
    }

    @if(!isset($jenismagang))
    function getData() {
        let id = $('select[name="namajenis"]').find('option:selected').attr('data-id-selected');
        let url = `{{ route('jenismagang.create') }}`;
        $.ajax({
            url: url,
            type: 'GET',
            data: { section: 'get_data_before', id: id },
            success: function(response) {
                response = response.data;
                $.each(response, function(key, value) {
                    if (key == 'detail_berkas_magang') {
                        $('#detail_berkas_magang').html(value);
                        initFormRepeater();
                        loadFlatpickrX();
                    } else if (key == 'detail_dokumen_persyaratan') {
                        $('#detail_dokumen_persyaratan').html(value);
                        initFormRepeater();
                    } else {
                        $(`#${key}`).val(value).trigger('change');
                    }
                });
            }
        });
    }
    @endif

    function afterAction(response) {
        let data = response.data;
        if (data != null && data.data_step) {
            let currentStepNumber = $('.bs-stepper-header').find(`[data-step="${data.data_step}"]`);
            switchActive(currentStepNumber);
        } else {
            setTimeout(() => {
                window.location.href = "{{ route('jenismagang') }}";
            }, 1000);
        }
    }
 
    $(document).on('click', '.button-next', function () {
        let step = $(this).attr('data-step');

        if ($('.default-form').find('input[name="data_step"]').length > 0) {
            $('.default-form').find('input[name="data_step"]').remove();
        }

        $('.default-form').prepend(`<input type="hidden" name="data_step" value="${step}">`);
        $(this).attr('type', 'submit');
        $('.default-form').submit();
        $(this).attr('type', 'button');
    });

    function switchActive(currentStepNumber) {
        currentStepNumber.addClass('active');

        let prevStepNumber = currentStepNumber.attr('data-step') - 1;
        prevStepNumber = $(`[data-step="${prevStepNumber}"]`);
        prevStepNumber.addClass('crossed').removeClass('active');

        let prevStepContent = $(prevStepNumber.attr('data-target')).find('.content');
        let currentStepContent = $(currentStepNumber.attr('data-target')).find('.content');

        prevStepContent.removeClass('active');
        currentStepContent.addClass('active');
    }

    $(document).on('click', '.btn-prev', function() {
        let currentContent = $(this).parents('.content').parent();
        let currentStep = $(`[data-target="#${currentContent.attr('id')}"]`);
        currentStep.removeClass('active');

        let prevStep = $(`[data-step="${currentStep.attr('data-step') - 1}"]`);
        prevStep.addClass('active');
        prevStep.removeClass('crossed');

        currentContent.find('.content').removeClass('active');
        $(prevStep.attr('data-target')).find('.content').addClass('active');
    });

    function afterShown(e) {
        $(e).find('.container-label').find('a').remove();
        $(e).find('input.id_berkas').remove();

        let flatpickr = $(e).find(".flatpickr-date-x");
        if (flatpickr.length > 0) {
            let label = $(e).find(".form-label");
            let random = Math.random().toString(36).substring(2, 10);
    
            label.attr('for', flatpickr.attr('id') + random);
            flatpickr.attr('id', flatpickr.attr('id') + random);
    
            $(e).find(".flatpickr-date-x").flatpickr({
                altInput: true,
                altFormat: 'j F Y, H:i',
                dateFormat: 'Y-m-d H:i',
                enableTime: true
            });
        }
    }

    @if (isset($jenismagang))
    function loadDataEdit() {
        let data = @json($jenismagang);
        $.each(data, function ( key, value ) {
            $(`[name="${key}"]`).val(value).trigger('change');
        });
    }
    @endif
</script>
@endsection