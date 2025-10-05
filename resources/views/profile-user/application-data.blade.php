<div class="row">
    @foreach($jobApplications as $app)
    <div class="col-lg-4 col-md-6 col-sm-12">
        <a href="{{ route('jobs.jobDetail', [$app->job->slug]) }}" style="color: black;">
            <div class="card my-2" style="height: auto;">
                <div class="card-body">
                    <div class="row mx-2">
                        <div class="content">
                            <span class="company-logo"><img src="{{ asset("user-uploads/company-logo/".$app->job->company->logo) }}" alt=""></span>
                            <h4 class="text-truncate mb-0" style="width: 200px;">{{ ucwords($app->job->company->company_name) }}</h4>
                            <ul class="job-info">
                                <li class="text-truncate" style="width: 200px;">{{ ucwords($app->job->location->location)}}, {{ ucwords($app->job->location->country->country_name)}}</li>
                            </ul>
                        </div>
                        <div class="ml-auto">
                            <label class="badge" style="font-size: 15px; color: white; background: {{ $app->status->color }};">{{$app->status->status}}</label>
                        </div>
                        <div style="display: flex; flex-direction: column;">
                            <h5 style="font-weight: 600;">{{ ucwords($app->job->title) }}</h5>
                            <span>{{ ucwords($app->job->category->name) }}</span>
                            <div class="mt-4 w-100 d-flex align-content-center">
                                <i class="text-muted material-symbols-outlined mt-1" style="font-size: 20px;">date_range</i>
                                <span class="text-muted mx-2">Submitted on {{$app->created_at->format('d M Y')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endforeach
    @if(count($jobApplications) == 0)
        <div class="w-100" style="display: flex; align-items: center; justify-content: center;">
            <h5>No application found! Try change the filter or</h5>
            <div class="mx-2" style="display: flex; align-items: center; justify-content: center;">
                <a href="{{ url('search') }}" style="display: flex; align-items: center; justify-content: center;">
                    <button type="button" class="btn" style="background-color: #EFEFEF;">
                    Explore Jobs
                    </button>
                </a>
            </div>
        </div>
    @endif
</div>