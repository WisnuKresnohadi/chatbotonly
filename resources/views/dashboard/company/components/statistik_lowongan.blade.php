<div class="col-md-3 col-6">
    <div class="d-flex align-items-center">
        <div class="badge bg-label-primary me-3 p-2">
            <i class="ti ti-files ti-sm" style="font-size: 30px !important;"></i>
        </div>
        <div class="card-info">
            <h5 class="mb-0">{{ $total ?? 0 }}</h5>
            <p class="mb-0" style="font-size:18px;">Total</p>
        </div>
    </div>
</div>
<div class="col-md-3 col-6">
    <div class="d-flex align-items-center">
        <div class="badge bg-label-warning me-3 p-2">
            <i class="ti ti-clock ti-sm" style="font-size: 30px !important;"></i>
        </div>
        <div class="card-info">
            <h5 class="mb-0">{{ $pending ?? 0 }}</h5>
            <p class="mb-0" style="font-size:18px;">Pending</p>
        </div>
    </div>
</div>
<div class="col-md-3 col-6">
    <div class="d-flex align-items-center">
        <div class="badge bg-label-danger me-3 p-2">
            <i class="ti ti-clipboard-x ti-sm" style="font-size: 30px !important;"></i>
        </div>
        <div class="card-info">
            <h5 class="mb-0">{{ $rejected ?? 0 }}</h5>
            <p class="mb-0" style="font-size:18px;">Ditolak</p>
        </div>
    </div>
</div>
<div class="col-md-3 col-6">
    <div class="d-flex align-items-center">
        <div class="badge bg-label-info me-3 p-2">
            <i class="ti ti-clipboard-x ti-sm" style="font-size: 30px !important;"></i>
        </div>
        <div class="card-info">
            <h5 class="mb-0">{{ $publish ?? 0 }}</h5>
            <p class="mb-0" style="font-size:18px;">Publish</p>
        </div>
    </div>
</div>