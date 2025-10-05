<div class="d-flex justify-content-between">
    <h6 class="text-start">Kelengkapan Profil @if($percentageData->clue != null)<i class='tf-icons ti ti-alert-circle text-primary pb-1' data-bs-toggle="tooltip" data-bs-placement="right"
        data-bs-original-title="Data Kosong : {{$percentageData->clue}}" id="tooltip-filter"></i>@endif</h6>
    <h6 class="text-end" id="percentage_progress">{{$percentageData->percentage}}%</h6>
</div>
<div class="progress">
    <div class="progress-bar" id="progress_bar" role="progressbar" style="width: {{$percentageData->percentage}}%;" aria-valuenow="{{$percentageData->percentage}}" aria-valuemin="0" aria-valuemax="100"></div>
</div>