@if(Auth::user()->hasRole('admin'))
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title" style="font-weight: 600;">
                @lang('modules.dashboard.statistics')
            </h3>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box info-box-custom">
                        <div class="info-box-header">
                                <a href="{{ route('admin.company.index') }}"><span class="info-box-icon bg-primary"><i class="material-symbols-outlined" style="font-size: 22px;">domain</i></span></a>
                                <a href="{{ route('admin.company.index') }}" class="mt-2"><span class="text-primary">@lang('modules.dashboard.details')</span><i class="material-icons ml-1 text-primary" style="font-size: 14px;">arrow_forward</i></a>
                        </div>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('modules.dashboard.totalCompanies')</span>
                            <span class="info-box-number" style="font-size: 18px;">{{ $totalCompanies }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box info-box-custom">
                        <div class="info-box-header">
                                <a href="{{ route('admin.jobs.index') }}"><span class="info-box-icon bg-primary"><i class="material-symbols-outlined" style="font-size: 22px;">assignment_add</i></span></a>
                                <a href="{{ route('admin.jobs.index') }}" class="mt-2"><span class="text-primary">@lang('modules.dashboard.details')</span><i class="material-icons ml-1 text-primary" style="font-size: 14px;">arrow_forward</i></a>
                        </div>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('modules.dashboard.totalOpenings')</span>
                            <span class="info-box-number" style="font-size: 18px;">{{ $totalOpenings }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box info-box-custom">
                        <div class="info-box-header">
                                <a href="{{ route('admin.company.index') }}"><span class="info-box-icon bg-primary"><i class="material-symbols-outlined" style="font-size: 22px;">draft</i></span></a>
                                <a href="{{ route('admin.company.index') }}" class="mt-2"><span class="text-primary">@lang('modules.dashboard.details')</span><i class="material-icons ml-1 text-primary" style="font-size: 14px;">arrow_forward</i></a>
                        </div>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('modules.dashboard.totalApplications')</span>
                            <span class="info-box-number" style="font-size: 18px;">{{ $totalApplications }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box info-box-custom">
                        <div class="info-box-header">
                                <a href="{{ route('admin.company.index') }}"><span class="info-box-icon bg-primary"><i class="material-symbols-outlined" style="font-size: 22px;">person_add</i></span></a>
                                <a href="{{ route('admin.company.index') }}" class="mt-2"><span class="text-primary">@lang('modules.dashboard.details')</span><i class="material-icons ml-1 text-primary" style="font-size: 14px;">arrow_forward</i></a>
                        </div>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('modules.dashboard.totalHired')</span>
                            <span class="info-box-number" style="font-size: 18px;">{{ $totalHired }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box info-box-custom">
                        <div class="info-box-header">
                                <a href="{{ route('admin.company.index') }}"><span class="info-box-icon bg-primary"><i class="material-symbols-outlined" style="font-size: 22px;">person_remove</i></span></a>
                                <a href="{{ route('admin.company.index') }}" class="mt-2"><span class="text-primary">@lang('modules.dashboard.details')</span><i class="material-icons ml-1 text-primary" style="font-size: 14px;">arrow_forward</i></a>
                        </div>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('modules.dashboard.totalRejected')</span>
                            <span class="info-box-number" style="font-size: 18px;">{{ $totalRejected }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box info-box-custom">
                        <div class="info-box-header">
                                <a href="{{ route('admin.company.index') }}"><span class="info-box-icon bg-primary"><i class="material-symbols-outlined" style="font-size: 22px;">file_open</i></span></a>
                                <a href="{{ route('admin.company.index') }}" class="mt-2"><span class="text-primary">@lang('modules.dashboard.details')</span><i class="material-icons ml-1 text-primary" style="font-size: 14px;">arrow_forward</i></a>
                        </div>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('modules.dashboard.newApplications')</span>
                            <span class="info-box-number" style="font-size: 18px;">{{ $newApplications }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box info-box-custom">
                        <div class="info-box-header">
                                <a href="{{ route('admin.company.index') }}"><span class="info-box-icon bg-primary"><i class="material-symbols-outlined" style="font-size: 22px;">person_search</i></span></a>
                                <a href="{{ route('admin.company.index') }}" class="mt-2"><span class="text-primary">@lang('modules.dashboard.details')</span><i class="material-icons ml-1 text-primary" style="font-size: 14px;">arrow_forward</i></a>
                        </div>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('modules.dashboard.shortlistedCandidates')</span>
                            <span class="info-box-number" style="font-size: 18px;">{{ $shortlisted }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box info-box-custom">
                        <div class="info-box-header">
                                <a href="{{ route('admin.interview-schedule.index') }}"><span class="info-box-icon bg-primary"><i class="material-symbols-outlined" style="font-size: 22px;">content_paste_search</i></span></a>
                                <a href="{{ route('admin.interview-schedule.index') }}" class="mt-2"><span class="text-primary">@lang('modules.dashboard.details')</span><i class="material-icons ml-1 text-primary" style="font-size: 14px;">arrow_forward</i></a>
                        </div>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('modules.dashboard.todayInterview')</span>
                            <span class="info-box-number" style="font-size: 18px;">{{ $totalTodayInterview }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>
        </div>
    </div>
</div>
@endif