<div class="row">
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="info-box info-box-custom">
            <div class="info-box-header">
                    <a><span class="info-box-icon bg-primary"><i class="material-symbols-outlined" style="font-size: 22px;">draft</i></span></a>
            </div>
            <div class="info-box-content">
                <span class="info-box-text">Total Applications</span>
                <span class="info-box-number" style="font-size: 18px;">{{ $totalJobApplications }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    @foreach($status as $stat)
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="info-box info-box-custom">
            <div class="info-box-header">
                <a><span class="info-box-icon bg-primary"><i class="material-symbols-outlined" style="font-size: 22px;">search</i></span></a>
            </div>
            <div class="info-box-content" style="flex: 1;">
                <span class="info-box-text">{{ ucwords($stat->status) }}</span>
                <span class="info-box-number" style="font-size: 18px; color: {{ $stat->color }};">{{ count($stat->applications) }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    @endforeach
</div>