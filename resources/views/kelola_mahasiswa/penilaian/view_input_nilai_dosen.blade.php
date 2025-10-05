@extends('partials.vertical_menu')

@section('page_style')
@endsection

@section('content')
<div class="row mb-2">
    <div class="">
        <a href="{{ $urlBack }}" type="button" class="btn btn-outline-primary mb-3 waves-effect">
            <span class="ti ti-arrow-left me-2"></span>Kembali
        </a>
    </div>
    <div class="col-md-9 col-12">
        <h4 class="fw-bold text-sm"><span class="text-muted fw-light text-xs">Kelola Mahasiswa/ </span>
            Input Nilai Mahasiswa Magang
        </h4>
    </div>
</div>
<div class="row" id="modal-jenismagang">
    <div class="col-12 mb-4">
        <div class="bs-stepper wizard-numbered mt-2">
            <div class="bs-stepper-header" style="justify-content: center">
                @include('kelola_mahasiswa/penilaian/components/number_step')
            </div>
            <div class="bs-stepper-content">
                <form class="default-form" action="{{ $urlStore }}" function-callback="afterAction">
                    @csrf
                    <div id="pengisian_nilai">
                        @include('kelola_mahasiswa/penilaian/components/step_pengisian_nilai')
                    </div>
                    <div id="perhitungan_nilai_akhir">
                        @include('kelola_mahasiswa/penilaian/components/step_perhitungan_nilai_akhir')
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
        getIndexNilai();
    });

    function afterAction(response) {
        let data = response.data;
        if (data != null && data.data_step) {
            let currentStepNumber = $('.bs-stepper-header').find(`[data-step="${data.data_step}"]`);
            switchActive(currentStepNumber);
            $('#container_result_nilai_lap').html(data.container_result_nilai_lap);
            $('#container_result_nilai_akademik').html(data.container_result_nilai_akademik);
            $('#container_result_nilai_akhir').html(data.container_result_nilai_akhir);
        } else {
            setTimeout(() => {
                window.location.href = "{{ $urlBack }}";
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

    function getIndexNilai() {
        let nilaiMutu = @json($nilai_mutu);
        let totalNilai = 0;

        $('.nilai-input').each(function () {
            if ($(this).val() != '' && $(this).val() != null) {
                totalNilai += parseFloat($(this).val());
            }
        });

        let index = nilaiMutu.find(item => totalNilai >= item.nilaimin && totalNilai <= item.nilaimax)?.nilaimutu;

        if (index != null && index != undefined) {
            $('#nilai-akhir').val(totalNilai);
            $('#index-nilai').val(index);
        } else {
            $('#nilai-akhir').val('-');
            $('#index-nilai').val('-');
        }
    }
</script>
@endsection