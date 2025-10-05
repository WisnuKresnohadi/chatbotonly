<style>
    .circle {
        border-radius: 50%;
        color: black;
        display: inline-block;
        height: 35px;
        font-weight: bold;
        font-size: 1.2em;
        width: 35px;
        margin: 0 auto;
    }

    .circle span {
        display: table-cell;
        vertical-align: middle;
        height: 35px;
        width: 50px;
        text-align: center;
    }
</style>

<div class="w-100 mx-lg-5 mt-2 mb-5 pb-3">
    <div class="row data-row col-11">
        <div class="row mb-1 d-flex justify-content-between w-100 pl-3">
            <h4 class="mt-2" style="font-size: 22px;">Candidate Details</h4>
            @if(isset($job_id))
            <div class="d-flex justify-content-end">
                <a class="btn btn-primary text-right mx-1" target="_blank" href="{{ $application->resume_url }}">
                    <i style="font-size: 18px" class="align-middle material-symbols-outlined">system_update_alt</i>
                </a>
                <select name="filter_status" onchange="changeStatus(value);" class="filterStatus form-control" data-width="100%">
                    <option value selected disabled>Move to</option>
                    @foreach ($status as $value)
                        <option value="{{ $value->id }}"
                        {{-- @if($value->id == $application->status_id)
                        selected
                        @endif --}}
                        >{{ $value->status }}</option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>
        <div class="row mb-1 mt-3">
            <div class="card col-12" style="height: auto;">
                <div class="card-body">
                    <a class="image-container nav-link waves-effect waves-light px-0" style="display: flex; align-items: center;">
                        <div class="image" style="width: 60px; height: 60px;">
                            <img src="{{ $application->user->profile_image_url  }}" style="vertical-align:unset;" alt="User Image">
                        </div>
                        <div style="line-height: normal;">
                            <h4 class="mb-0" style="color:black;">{{ ucwords($application->user->name) }}<br></h4>
                            @if(isset($job_id))
                            <span class="text-muted" style="font-size: 14px;">{{ $application->job->title }}</span>
                            @else
                            <span class="text-muted" style="font-size: 14px;">{{ $application->headline }}</span>
                            @endif
                        </div>
                        <span class="ml-auto">
                            <!-- @if(isset($job_id))
                            <span title="Profile" onclick="buttonClicked('profile')" style="cursor: pointer;" class="circle bg-primary"><span><i class="fa fa-user"></i></span></span>
                            @endif -->
                            <span title="Phone" onclick="buttonClicked('phone')" style="cursor: pointer;" class="circle bg-primary"><span><i class="fa fa-phone"></i></span></span>
                            <span title="Email" onclick="buttonClicked('email')" style="cursor: pointer;" class="circle bg-primary"><span><i class="fa fa-envelope-o"></i></span></span>
                        </span>
                    </a>
                    @if(isset($job_id))
                    <div class="text-muted mt-2 d-flex align-items-center justify-content-center">Applied at {{$application->created_at->format('d M, Y')}}</div>
                    @endif
                </div>
            </div>
            @if(isset($job_id))
            <div class="card col-12" style="height: auto;">
                <div class="card-body">
                    <span style="font-size: 16px; font-weight: 600;">Why Hire Me?</span>
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="mt-2">
                                <div class="w-100">{{$application->cover_letter ?? 'Empty'}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="card col-12" style="height: auto;">
                <div class="card-body">
                    <span style="font-size: 16px; font-weight: 600;">Experience</span>
                    @if(count($application->experiences) > 0)
                    <div class="row mt-2">
                        @foreach($application->experiences as $key => $experience)
                        <div class="col-12">
                            <div class="my-2">
                                <div class="d-flex align-items-center" style="width: auto;">
                                    <span class="mx-0 circle bg-primary"><span><i class="fa fa-building-o"></i></span></span>
                                    <div class="ml-3" style="line-height: normal;">
                                        <div class="w-100" style="font-size: 15px; font-weight: 600;">{{$experience->company}}</div>
                                        <div class="w-100 text-muted">{{$experience->start_period}} - {{$experience->end_period}}</div>
                                    </div>
                                </div>
                                <div class="w-100 mt-3" style="font-weight: 600;">{{$experience->position}}</div>
                                <div class="w-100">{{$experience->description}}</div>
                            </div>
                        </div>
                        @if($key < count($application->experiences)-1)
                        <div class="col-12">
                            <hr style="margin-right: -28px; margin-left: -28px;">
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @else
                    <div class="d-flex align-items-center mt-3">
                        Empty
                    </div>
                    @endif
                </div>
            </div>
            <div class="card col-12" style="height: auto;">
                <div class="card-body">
                    <span style="font-size: 16px; font-weight: 600;">Educations</span>
                    @if(count($application->educations) > 0)
                    <div class="row mt-3">
                        @foreach($application->educations as $key => $education)
                        <div class="col-md-3 col-sm-6">
                            <div class="my-2">
                                <div class="w-100">University / School</div>
                                <div class="w-100" style="font-weight: 600;">{{$education->university}}</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="my-2">
                                <div class="w-100">Degree</div>
                                <div class="w-100" style="font-weight: 600;">{{$education->degree}}</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="my-2">
                                <div class="w-100">Field Of Study</div>
                                <div class="w-100" style="font-weight: 600;">{{$education->study}}</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="my-2">
                                <div class="w-100">Grd Year</div>
                                <div class="w-100" style="font-weight: 600;">{{$education->is_graduated ? $education->end_date : 'Now'}}</div>
                            </div>
                        </div>
                        {{-- <div class="col-md-4 col-sm-6">
                            <div class="my-2">
                                <div class="w-100">GPA / Score</div>
                                <div class="w-100" style="font-weight: 600;">{{$education->gpa}}</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="my-2">
                                <div class="w-100">Is Graduated?</div>
                                <div class="w-100" style="font-weight: 600;">{{$education->is_graduated ? 'graduated' : 'not yet'}}</div>
                            </div>
                        </div> --}}
                        @if($key < count($application->educations)-1)
                        <div class="col-12">
                            <hr style="margin-right: -28px; margin-left: -28px;">
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @else
                    <div class="d-flex align-items-center mt-3">
                        Empty
                    </div>
                    @endif
                </div>
            </div>
            <div class="card col-12" style="height: auto;">
                <div class="card-body">
                    <span style="font-size: 16px; font-weight: 600;">Skills</span>
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="mt-2">
                                @if(count($application->skills) > 0)
                                @foreach($application->skills as $key => $skill)
                                <label class="badge bg-primary" style="font-size: 14px;">{{$skill->skill->name}}</label>
                                @endforeach
                                @else
                                <div class="w-100">Empty</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="w-100">
                <div class="row">
                    <div class="col-md-7 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                            <span style="font-size: 16px; font-weight: 600;">Socials</span>
                                @if(count($application->portfolios) > 0)
                                <div class="row mt-2">
                                    @foreach($application->portfolios as $key => $portfolio)
                                    <div class="col-12">
                                        <div class="my-2">
                                            <div class="w-100">{{$portfolio->name}}</div>
                                            <div class="w-100" style="font-weight: 600;">{{$portfolio->url}}</div>
                                        </div>
                                    </div>
                                    @if($key < count($application->portfolios)-1)
                                    <div class="col-12">
                                        <hr style="margin-right: -28px; margin-left: -28px;">
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                @else
                                <div class="d-flex align-items-center mt-3">
                                    Empty
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <span style="font-size: 16px; font-weight: 600;">Documents</span>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="mt-2">
                                            <div class="w-100">CV or Resume</div>
                                            <p class="text-muted resume-button" id="">
                                                <a target="_blank" href="{{ $application->resume_url }}"
                                                class="btn btn-sm btn-primary">
                                                    @lang('app.view') @lang('modules.jobApplication.resume')
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="card col-12" style="height: auto;">
                <div class="card-body">
                    <span style="font-size: 16px; font-weight: 600;">Language</span>
                    <div class="row mt-2">
                        @foreach ($application->languages as $language) 
                            <div class="col-6">
                                <div class="my-2">
                                    <div class="w-100" style="font-weight: 600;"><div class="w-100">{{$language->name ?? 'Empty'}}</div></div>
                                    <div class="w-100">{{ $language->level ?? 'Empty' }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card col-12" style="height: auto;">
                <div class="card-body">
                    <span style="font-size: 16px; font-weight: 600;">Personal Details</span>
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="my-2">
                                <div class="w-100">DoB</div>
                                <div class="w-100" style="font-weight: 600;">{{is_string($application->dob) ? $application->dob : $application->dob->format('d-m-Y')}}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="my-2">
                                <div class="w-100">Nationality</div>
                                <div class="w-100" style="font-weight: 600;">{{$application->nationality}}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="my-2">
                                <div class="w-100">Gender</div>
                                <div class="w-100" style="font-weight: 600;">{{$application->gender}}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="my-2">
                                <div class="w-100">Marital</div>
                                <div class="w-100" style="font-weight: 600;">{{$application->marital_stat}}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="my-2">
                                <div class="w-100">City</div>
                                <div class="w-100" style="font-weight: 600;">{{$application->city}}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="my-2">
                                <div class="w-100">Postal Code</div>
                                <div class="w-100" style="font-weight: 600;">{{$application->postal_code}}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="my-2">
                                <div class="w-100">State</div>
                                <div class="w-100" style="font-weight: 600;">{{$application->state}}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="my-2">
                                <div class="w-100">Country</div>
                                <div class="w-100" style="font-weight: 600;">{{$application->country}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(!isset($job_id))
            <div class="card col-12" style="height: auto;">
                <div class="card-body">
                    <span style="font-size: 16px; font-weight: 600;">Apply History</span>
                        @if(count($application->user->job_applications) > 0)
                        <div class="row mt-2">
                            @foreach($application->user->job_applications as $key => $app)
                            <div class="col-12">
                                <div class="my-2">
                                    <a class="image-container nav-link waves-effect waves-light px-0" style="display: flex; align-items: center;">
                                        <div class="image" style="width: 40px; height: 40px;">
                                            <img src="{{ asset('user-uploads/company-logo/'.$app->job->company->logo) }}" style="vertical-align:unset;" alt="Company Image">
                                        </div>
                                        <div style="line-height: normal;">
                                            <h4 class="mb-0" style="font-size: 15px; color:black;">{{ $app->job->title }}<br></h4>
                                            <span class="text-muted" style="font-size: 14px;">{{ ucwords($app->job->company->company_name) }}</span>
                                        </div>
                                        <span class="ml-auto">
                                            <label class="badge" style="font-size: 14px; color: white; background: {{ $app->status->color }};">{{$app->status->status}}</label>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            @if($key < count($application->user->job_applications)-1)
                            <div class="col-12">
                                <hr style="margin-right: -28px; margin-left: -28px;">
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @else
                        <div class="d-flex align-items-center mt-3">
                            Empty
                        </div>
                        @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script src="{{ asset('front/assets/landing/js/jquery.js') }}"></script> 
<script type="text/javascript">
    $(document).ready(function (e) {
        $('#hidden-education').hide();
        $('#button-less-education').hide();
        $('#hidden-social').hide();
        $('#button-less-social').hide();
        $('#hidden-experience').hide();
        $('#button-less-experience').hide();
    });
</script>
<script>
    function changeStatus(value){
        var id = "{{ $application->id }}";

        $.ajax({
            url: '{{ route("admin.job-applications.updateStatus") }}',
            type: 'POST',
            container: '.container-row',
            data: {
                id: id,
                status_id: value,
                '_token': '{{ csrf_token() }}'
            },
            success: function (response) {
                loadData();
            }
        });

    }

    function buttonClicked(type){
        console.log(type);
        if(type == 'profile'){
            location.href = "{{route('admin.candidate.show', $application->id)}}"
        }
    }

    function viewAll(card){
        if(card == 'education'){
            $('#hidden-education').show();
            $('#button-less-education').show();
            $('#button-all-education').hide();
        }
        if(card == 'social'){
            $('#hidden-social').show();
            $('#button-less-social').show();
            $('#button-all-social').hide();
        }
        if(card == 'experience'){
            $('#hidden-experience').show();
            $('#button-less-experience').show();
            $('#button-all-experience').hide();
        }
    }

    function viewLess(card){
        if(card == 'education'){
            $('#hidden-education').hide();
            $('#button-less-education').hide();
            $('#button-all-education').show();
        }
        if(card == 'social'){
            $('#hidden-social').hide();
            $('#button-less-social').hide();
            $('#button-all-social').show();
        }
        if(card == 'experience'){
            $('#hidden-experience').hide();
            $('#button-less-experience').hide();
            $('#button-all-experience').show();
        }
    }
</script>