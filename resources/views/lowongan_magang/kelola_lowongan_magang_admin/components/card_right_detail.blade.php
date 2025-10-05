@switch($lowongan->statusaprove)
    @case('tertunda')
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <button class="btn btn-primary" type="button" id="btn-approve">
                            <i class="ti ti-check me-2"></i>
                            Setujui
                        </button>
                        <button class="btn btn-danger mt-2" type="button"  id="btn-reject">
                            <i class="ti ti-x me-2"></i>
                            Tolak
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @break
    @case('ditolak')
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h6>Alasan Penolakan:</h6>
                    <p>{{ $lowongan->alasantolak }}</p>
                </div>
            </div>
        </div>
        @break
    @default
        
@endswitch