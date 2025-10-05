{{-- <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">

@push('header-css')
<link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/datepicker3.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('assets/node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
<style>
    input[type="file"] {
        height:45px !important;
    }
    @media (max-width: 767.5px) {
        .hidden-small {
            display: none;
        }
    }

</style>

<form method="POST" id="createForm" class="ajax-form default-form">
    {{csrf_field()}}
    <input type="hidden" name="job_id" value="@if(isset($job)) {{ $job->id }} @endif">
    <input type="hidden" name="user_id" value="@if($user) {{ $user->id }} @endif">
    <input type="hidden" name="job_application_id" value="@if(isset($job_application_id)) {{ $job_application_id }} @endif">
    <input type="hidden" name="profile_user_id" value="@if($user && $user->profile) {{ $user->profile->id }} @endif">
    @if($user && $user->profile && $user->profile->information)
    <input type="hidden" name="information_id" value="{{ $user->profile->information->id }}">
    @endif
    <!--Checkout Details-->
    <div class="checkout-form">
        <div>
            <h4 class="title mb-4 text-primary">Personal Information</h4>
            <div class="row">
                <!--Form Group-->
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label>@lang('modules.front.fullName') <sup>*</sup></label>
                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="@lang('modules.front.fullName')" value="@if($user){{ $user->name }}@endif" required @if(request()->segment(1) == 'job') disabled @endif>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                
                <!--Form Group-->
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label>@lang('modules.front.email') <sup>*</sup></label>
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="@lang('modules.front.email')" value="@if($user){{ $user->email }}@endif" required @if(request()->segment(1) == 'job') disabled @endif>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                    <label>@lang('app.image')</label>
                    <div class="card" style="height: auto;">
                        <div class="card-body">
                            <input type="hidden" name="hidden_image" value="@if($user) {{ $user->image }} @endif">
                            <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" class="dropify" style="min-height: 100%;"
                                data-default-file="{{ $user->profile_image_url }}"
                            />
                        </div>
                    </div>
                </div>

                @if(!isset($job))
                <div class="form-group col-lg-12 col-md-12 col-sm-12 mb-5">
                    <label>Headline <sup>*</sup></label>
                    <input type="text" name="headline" class="form-control {{ $errors->has('headline') ? ' is-invalid' : '' }}" placeholder="Example: Software Developer, Photographer, Etc" value="@if($user && $user->profile){{ $user->profile->headline }}@endif" required>
                    @if ($errors->has('headline'))
                        <span class="invalid-feedback">{{ $errors->first('headline') }}</span>
                    @endif
                </div>
                @endif
                
                <!--Form Group-->
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label>@lang('modules.front.phone') <sup>*</sup></label>
                    <div class="form-row">
                        <div class="col-sm-3">
                            <select name="calling_code" id="calling_code" class="form-control selectpicker" data-live-search="true" data-width="100%">
                                @foreach ($calling_codes as $code => $value)
                                    <option value="{{ $value['dial_code'] }}"
                                    @if ($user->calling_code)
                                    {{ $user->calling_code == $value['dial_code'] ? 'selected' : '' }}
                                    @elseif ($value['dial_code'] == '+62')
                                    selected
                                    @endif
                                    >{{ $value['dial_code'] . ' - ' . $value['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" min="0" name="mobile" value="@if($user){{ $user->mobile }}@endif" class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" placeholder="@lang('modules.front.phone')">
                            @if ($errors->has('mobile'))
                                <span class="invalid-feedback">{{ $errors->first('mobile') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!--Form Group-->
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label>@lang('modules.front.dob') <sup>*</sup><span style="font-size: 14px;"> (18 or older)</span></label>
                    <input type="text" name="dob" class="dob form-control {{ $errors->has('dob') ? ' is-invalid' : '' }}" placeholder="@lang('modules.front.dob')" value="@if($user && $user->profile){{$user->profile->dob->format('Y-m-d')}}@endif" required>
                    @if ($errors->has('dob'))
                        <span class="invalid-feedback">{{ $errors->first('dob') }}</span>
                    @endif
                </div>

                <!--Form Group-->
                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                    <label>@lang('modules.front.nationality') <sup>*</sup></label>
                    <select name="nationality" id="nationality" class="form-control selectpicker {{ $errors->has('nationality') ? ' is-invalid' : '' }}" data-live-search="true" data-width="100%">
                        <option value="WNI" @if($user && $user->profile && $user->profile->nationality == 'WNI') selected @endif>WNI</option>
                        <option value="WNA" @if($user && $user->profile && $user->profile->nationality == 'WNA') selected @endif>WNA</option>
                    </select>
                    @if ($errors->has('nationality'))
                        <span class="invalid-feedback">{{ $errors->first('nationality') }}</span>
                    @endif
                </div>

                <!--Form Group-->
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label>@lang('modules.front.country') <sup>*</sup></label>
                    <select class="form-control form-control-lg countries" name="country" id="countryId">
                        <option value="0">@lang('modules.front.selectCountry')</option>
                    </select>
                    @if ($errors->has('country'))
                        <span class="invalid-feedback">{{ $errors->first('country') }}</span>
                    @endif
                </div>

                <!--Form Group-->
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label>@lang('modules.front.state') <sup>*</sup></label>
                    <select class="form-control form-control-lg states" name="state" id="stateId">
                        <option value="0">@lang('modules.front.selectState')</option>
                    </select>
                    @if ($errors->has('state'))
                        <span class="invalid-feedback">{{ $errors->first('state') }}</span>
                    @endif
                </div>

                <!--Form Group-->
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label>@lang('modules.front.city') <sup>*</sup></label>
                    <input type="text" name="city" class="form-control {{ $errors->has('city') ? ' is-invalid' : '' }}" placeholder="@lang('modules.front.selectCity')" value="@if($user && $user->profile){{ $user->profile->city }}@endif" required>
                    @if ($errors->has('city'))
                        <span class="invalid-feedback">{{ $errors->first('city') }}</span>
                    @endif
                </div>

                <!--Form Group-->
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label>@lang('modules.front.postalCode') <sup>*</sup></label>
                    <input type="number" name="postal_code" min="0" class="form-control {{ $errors->has('postal_code') ? ' is-invalid' : '' }}" placeholder="@lang('modules.front.postalCode')" value="@if($user && $user->profile){{ $user->profile->postal_code }}@endif" required>
                    @if ($errors->has('postal_code'))
                        <span class="invalid-feedback">{{ $errors->first('postal_code') }}</span>
                    @endif
                </div>

                <!--Form Group-->
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label>@lang('modules.front.maritalStat') <sup>*</sup></label>
                    <div class="form-inline mb-2" class="form-control {{ $errors->has('marital_stat') ? ' is-invalid' : '' }}">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="Single" name="marital_stat" value="Single" @if($user && $user->profile) @if($user->profile->marital_stat == 'Single') checked @endif @endif />
                            <label class="form-check-label" for="Single">Single</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="Married" name="marital_stat" value="Married" @if($user && $user->profile) @if($user->profile->marital_stat == 'Married') checked @endif @endif />
                            <label class="form-check-label" for="Married">Married</label>
                        </div>
                    </div>
                    @if ($errors->has('marital_stat'))
                        <span class="invalid-feedback">{{ $errors->first('marital_stat') }}</span>
                    @endif
                </div>

                <!--Form Group-->
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label>@lang('modules.front.gender') <sup>*</sup></label>
                    <div class="form-inline mb-2" class="form-control {{ $errors->has('gender') ? ' is-invalid' : '' }}">
                    @foreach ($gender as $key => $value)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="{{ $key }}" value="{{ $key }}" @if($user && $user->profile) @if($user->profile->gender == $key) checked @endif @endif>
                            <label class="form-check-label" for="{{ $key }}">{{ ucFirst($value) }}</label>
                        </div>
                    @endforeach
                    </div>
                    @if ($errors->has('gender'))
                        <span class="invalid-feedback">{{ $errors->first('gender') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-5">
            <h4 class="title mb-4 text-primary">Additional Information</h4>
            <div class="row">
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label>Expected Salary</label>
                    <input type="hidden" name="expected_salary_type" value="IDR">
                    <div class="d-flex align-content-center col-12 px-0">
                        <span class="mt-3 mr-2">Rp. </span>
                        <input type="text" id="expected_salary_value" name="expected_salary_value" class="form-control {{ $errors->has('expected_salary_value') ? ' is-invalid' : '' }}" placeholder="Salary Value" value="@if($user && $user->profile && $user->profile->information){{ $user->profile->information->expected_salary_value }}@else 0 @endif">
                        @if ($errors->has('expected_salary_value'))
                            <span class="invalid-feedback">{{ $errors->first('expected_salary_value') }}</span>
                        @endif
                    </div>
                </div>

                <!--Form Group-->
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    {{-- <label>Preferred Work Location <sup>*</sup></label> --}}
                    {{-- <input type="text" name="preferred_city" class="form-control {{ $errors->has('preferred_city') ? ' is-invalid' : '' }}" placeholder="@lang('modules.front.selectCity')" value="@if($user && $user->profile && $user->profile->information){{ $user->profile->information->preferred_city }}@endif" required> --}}
                        <div class="d-flex justify-content-start">
                            <label>Preferred Work Location</label>
                        </div>
                        <div class="d-flex justify-content-start">
                            <select name="preferred_city[]" class="form-control preferred_city_select2 {{ $errors->has('preferred_city') ? ' is-invalid' : '' }}" multiple="multiple">
                                @foreach($locations as $city)
                                    <option value="{{ $city->location }}" 
                                        @foreach ($preferred_cities as $preferred_city)
                                        @if($preferred_city == $city->location) 
                                        selected 
                                        @endif
                                        @endforeach
                                        >
                                        {{ $city->location }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @if ($errors->has('preferred_city'))
                        <span class="invalid-feedback">{{ $errors->first('preferred_city') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-5">
            <h4 class="title mb-4 text-primary">Educations</h4>
            <div id="educationForm">
                @if($user && $user->profile && $user->profile->educations)
                @foreach($user->profile->educations as $key => $education)
                <div class="card form-education mb-1" style="height: auto;">
                <input type="hidden" name="education_id[{{ $key }}]" value="{{ $education->id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>@lang('modules.front.university') <sup>*</sup></label>
                                <input type="text" name="university[{{ $key }}]" class="form-control" placeholder="@lang('modules.front.university')" value="{{ $education->university }}" required>
                            </div>

                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>@lang('modules.front.degree') <sup>*</sup></label>
                                <select name="degree[{{ $key }}]" id="degree" class="form-control selectpicker" data-live-search="true" data-width="100%" >
                                    @foreach ($degrees as $key1 => $degree)
                                        <option value="{{ __($degree) }}"
                                        @if ($education->degree)
                                            {{ $education->degree == __($degree) ? 'selected' : '' }}
                                        @endif>{{ __($degree) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>@lang('modules.front.study') <sup>*</sup></label>
                                {{-- <input type="text" name="study[{{ $key }}]" class="form-control" placeholder="@lang('modules.front.study')" value="{{ $education->study }}" required> --}}
                                <select name="study[{{ $key }}]" class="study-select2">
                                    <option value selected>Select Field Of Study</option>
                                    @foreach ($majors as $major)
                                        <option value="{{ __($major->major) }}"
                                        @if ($education->study)
                                            {{ $education->study == __($major->major) ? 'selected' : '' }}
                                        @endif>{{ __($major->major) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>@lang('modules.front.eduStartDate') <sup>*</sup></label>
                                <input type="number" id="start-date-{{ $key }}" name="start_date[{{ $key }}]" min="1900" class="eduDate form-control" placeholder="@lang('modules.front.eduStartDate')" value="{{ $education->start_date }}" required>
                            </div>

                            <div id="div-end-date-{{ $key }}" class="form-group col-lg-6 col-md-12 col-sm-12" @if(!$education->is_graduated) hidden @endif>
                                <label>@lang('modules.front.eduEndDate') <sup>*</sup></label>
                                <input type="number" id="end-date-{{ $key }}" name="end_date[{{ $key }}]" min="1900" class="eduDate form-control" placeholder="@lang('modules.front.eduEndDate')" value="{{ $education->end_date }}" required @if(!$education->is_graduated) disabled @endif>
                            </div>

                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>@lang('modules.front.gpa') <sup>*</sup></label>
                                <input type="number" name="gpa[{{ $key }}]" min="0" class="form-control" placeholder="@lang('modules.front.gpa')" value="{{ $education->gpa }}" required>
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <input type="hidden" id="is_graduated" name="is_graduated[{{ $key }}]" value="1">
                            <input onclick="isGraduated('{{ $key }}')" style="vertical-align: middle; float: left; margin-top:5px;" id="check-a" class="mr-2" type="checkbox" value="0" name="is_graduated[{{ $key }}]" data-size="small" data-color="#00c292" @if(!$education->is_graduated) checked @endif>
                            <label for="term_agreement" class="align-top" >@lang('modules.front.haveNotGraduated')</label>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="card form-education mb-1" style="height: auto;">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>@lang('modules.front.university') <sup>*</sup></label>
                                <input type="text" name="university[0]" class="form-control" placeholder="@lang('modules.front.university')" required>
                            </div>

                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>@lang('modules.front.degree') <sup>*</sup></label>
                                <select name="degree[0]" id="degree" class="form-control selectpicker" data-live-search="true" data-width="100%" >
                                    @foreach ($degrees as $key1 => $degree)
                                        <option value="{{ __($degree) }}">{{ __($degree) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>@lang('modules.front.study') <sup>*</sup></label>
                                {{-- <input type="text" name="study[0]" class="form-control" placeholder="@lang('modules.front.study')" required> --}}
                                <select name="study[0]" class="study-select2">
                                    <option value selected>Select Field Of Study</option>
                                    @foreach ($majors as $major)
                                        <option value="{{ __($major->major) }}">{{ __($major->major) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>@lang('modules.front.eduStartDate') <sup>*</sup></label>
                                <input type="number" id="start-date-0" name="start_date[0]" min="1900" class="eduDate form-control" placeholder="@lang('modules.front.eduStartDate')" required>
                            </div>

                            <div id="div-end-date-0" class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>@lang('modules.front.eduEndDate') <sup>*</sup></label>
                                <input type="number" id="end-date-0" name="end_date[0]" min="1900" class="eduDate form-control" placeholder="@lang('modules.front.eduEndDate')" required>
                            </div>

                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label>@lang('modules.front.gpa') <sup>*</sup></label>
                                <input type="number" name="gpa[0]" min="0" class="form-control" placeholder="@lang('modules.front.gpa')" required>
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <input type="hidden" id="is_graduated" name="is_graduated[0]" value="1">
                            <input onclick="isGraduated(0)" style="vertical-align: middle; float: left; margin-top:5px;" id="check-a" class="mr-2" type="checkbox" value="0" name="is_graduated[0]" data-size="small" data-color="#00c292">
                            <label for="term_agreement" class="align-top" >@lang('modules.front.haveNotGraduated')</label>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="row-button-education form-check-inline col-md-1 py-2">
                <i class="fa fa-2x fa-minus-circle minus-education" style="cursor:pointer" onclick="deleteEducation()"></i>
                <i class="fa fa-2x fa-plus-circle plus-education" style="cursor:pointer" onclick="addEducation()"></i>
            </div>
        </div>
        <div class="mt-5">
            <h4 class="title mb-4 text-primary">Experience & Skills</h4>
            <div class="row">
                <!--Form Group-->
                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                    <label>@lang('modules.front.experience')</label>
                    <div class="form-group my-1">
                        <input onclick="isNoExp()" name="is_noExp" style="vertical-align: middle; float: left; margin-top:4px;" id="is_noExp" class="mr-2" type="checkbox" data-size="small" data-color="#00c292">
                        <label for="term_agreement" class="align-top" >No experience yet?</label>
                    </div>
                    <div class="col-md-12 bt-1 px-0" id="expForm">
                        @if($user && $user->profile && $user->profile->experiences)
                        @foreach($user->profile->experiences as $key => $experience)
                        <div class="card mb-1" style="height: auto;">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <input type="hidden" name="experience_id[{{ $key }}]" value="{{ $experience->id }}">
                                    <div class="col-md-6 my-sm-1 my-xs-1">
                                        <div class="form-group">
                                            <label>Start Year <sup>*</sup></label>
                                            <input class="eduDate form-control form-control-lg" type="text" name="start_period[{{ $key }}]" value="{{ $experience->start_period }}"
                                            placeholder="ex: 2020"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-sm-1 my-xs-1">
                                        <div class="form-group">
                                            <label>End Year <sup>*</sup></label>
                                            <input class="eduDate form-control form-control-lg" type="text" name="end_period[{{ $key }}]" value="{{ $experience->end_period }}"
                                            placeholder="ex: 2022"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-sm-1 my-xs-1">
                                        <div class="form-group">
                                            <label>@lang('modules.front.expPlace') <sup>*</sup></label>
                                            <input class="form-control form-control-lg" type="text" name="company[{{ $key }}]" value="{{ $experience->company }}"
                                            placeholder="@lang('modules.front.expPlace')"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-sm-1 my-xs-1">
                                        <div class="form-group">
                                            <label>@lang('modules.front.expPosition') <sup>*</sup></label>
                                            <input class="form-control form-control-lg" type="text" name="position[{{ $key }}]" value="{{ $experience->position }}"
                                            placeholder="@lang('modules.front.expPosition')"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-sm-1 my-xs-1">
                                        <div class="form-group">
                                            <label>Industry <sup>*</sup></label>
                                            <select name="industry_id[{{ $key }}]" class="select2 custom-select select2-expindustry-{{ $key }}">
                                                <option value=""> -- Choose -- </option>
                                                @foreach($industries as $industry)
                                                    <option value="{{ $industry->id }}"
                                                    @if($experience->industry_id == $industry->id)
                                                    selected
                                                    @endif
                                                    >{{ ucfirst($industry->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-sm-1 my-xs-1">
                                        <div class="form-group">
                                            <label>Salary <sup>(optional)</sup></label>
                                            <div class="d-flex align-content-center col-12 px-0">
                                                <span class="mt-3 mr-2">Rp. </span>
                                                <input class="form-control form-control-lg" type="text" id="salary_experience[0]" value="{{$experience->salary}}" name="salary[{{ $key }}]"
                                                placeholder="IDR"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-sm-1 my-xs-1">
                                        <div class="form-group">
                                            <label>@lang('modules.front.expDescription') <sup>*</sup></label>
                                            <textarea rows="2" class="form-control form-control-lg" type="text" name="description[{{ $key }}]"
                                            placeholder="@lang('modules.front.expDescription')"
                                            >{{ $experience->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="card mb-1" style="height: auto;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 my-sm-1 my-xs-1">
                                        <div class="form-group">
                                            <label>Start Year <sup>*</sup></label>
                                            <input class="eduDate form-control form-control-lg" type="text" name="start_period[0]"
                                            placeholder="ex: 2020"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-sm-1 my-xs-1">
                                        <div class="form-group">
                                            <label>End Year <sup>*</sup></label>
                                            <input class="eduDate form-control form-control-lg" type="text" name="end_period[0]"
                                            placeholder="ex: 2022"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-sm-1 my-xs-1">
                                        <div class="form-group">
                                            <label>@lang('modules.front.expPlace') <sup>*</sup></label>
                                            <input class="form-control form-control-lg" type="text" name="company[0]"
                                            placeholder="@lang('modules.front.expPlace')"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-sm-1 my-xs-1">
                                        <div class="form-group">
                                            <label>@lang('modules.front.expPosition') <sup>*</sup></label>
                                            <input class="form-control form-control-lg" type="text" name="position[0]"
                                            placeholder="@lang('modules.front.expPosition')"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-sm-1 my-xs-1">
                                        <div class="form-group">
                                            <label>Industry <sup>*</sup></label>
                                            <select name="industry_id[0]" class="select2 custom-select select2-expindustry-0">
                                                <option value=""> -- Choose -- </option>
                                                @foreach($industries as $industry)
                                                    <option value="{{ $industry->id }}">{{ ucfirst($industry->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-sm-1 my-xs-1">
                                        <div class="form-group">
                                            <label>Salary <sup>(optional)</sup></label>
                                            <div class="d-flex align-content-center col-12 px-0">
                                                <span class="mt-3 mr-2">Rp. </span>
                                                <input class="form-control form-control-lg" type="text" value="0" id="salary_experience[0]" name="salary[0]"
                                                placeholder="IDR"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-sm-1 my-xs-1">
                                        <div class="form-group">
                                            <label>@lang('modules.front.expDescription') <sup>*</sup></label>
                                            <textarea rows="2" class="form-control form-control-lg" type="text" name="description[0]"
                                            placeholder="@lang('modules.front.expDescription')"
                                            ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row-button-exp form-check-inline col-md-1 py-2">
                            <i class="fa fa-2x fa-minus-circle minus-exp" style="cursor:pointer" onclick="deleteExp()"></i>
                            <i class="fa fa-2x fa-plus-circle plus-exp" style="cursor:pointer" onclick="addExp()"></i>
                        </div>
                    </div>
                </div>
                <!--Form Group-->
                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                    <label>@lang('modules.front.skills') <sup>*</sup></label>
                    <div class="col-md-12 bt-1 px-0">
                        <div class="row" id="skillForm">
                            <div class="col-md-12 form-skill">
                                <div class="form-group">
                                    <select name="skills[]" id="skills"
                                        class="form-control select2 custom-select" multiple="multiple">
                                        @foreach($skills as $value)
                                        <option value="{{ $value->name }}"
                                        @if($user && $user->profile && $user->profile->skills && count($user->profile->skills) > 0)
                                        @foreach($user->profile->skills as $key => $skill)
                                        @if($skill->skill_id == $value->id)
                                        selected
                                        @endif
                                        @endforeach
                                        @endif
                                        >{{ ucfirst($value->name) }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-muted" class="font-size: 14px;">Type and press enter to insert new skill</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <h4 class="title mb-4 text-primary">Languages</h4>
            <div class="row">
                <!--Form Group-->
                <div class="col-12 form-group">
                    <div id="languageForm">
                        @if($user && $user->profile && $user->profile->languages)
                        @foreach($user->profile->languages as $key => $language)
                        <div class="card form-language mb-1" style="height: auto;">
                        <input type="hidden" name="language_id[{{ $key }}]" value="{{ $language->id }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select name="language_name[{{ $key }}]" class="select2 custom-select select2-language-{{ $key }}">
                                            <option value=""> -- Choose -- </option>
                                            @foreach($language_names as $language_val)
                                                <option value="{{ $language_val['name'] }}"
                                                    @if($language->name == $language_val['name'])
                                                    selected
                                                    @elseif($language->name == 'Indonesian')
                                                    selected
                                                    @endif
                                                >{{ ucfirst($language_val['name']) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select name="language_level[{{ $key }}]" id="language_level" class="selectpicker" data-live-search="true" data-width="100%">
                                            @foreach ($language_levels as $key1 => $value)
                                                <option value="{{ $value }}"
                                                @if($language->level == $value) selected @endif
                                                >{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="card form-language mb-1" style="height: auto;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select name="language_name[0]" class="select2 custom-select select2-language-0">
                                            <option value=""> -- Choose -- </option>
                                            @foreach($language_names as $language_val)
                                                <option value="{{ $language_val['name'] }}"
                                                    @if($language_val['name'] == 'Indonesian')
                                                    selected
                                                    @endif
                                                >{{ ucfirst($language_val['name']) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select name="language_level[0]" id="language_level" class="selectpicker" data-live-search="true" data-width="100%">
                                            @foreach ($language_levels as $key1 => $value)
                                                <option value="{{ $value }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row-button-language form-check-inline col-md-1 py-2">
                        <i class="fa fa-2x fa-minus-circle minus-language" style="cursor:pointer" onclick="deleteLanguage()"></i>
                        <i class="fa fa-2x fa-plus-circle plus-language" style="cursor:pointer" onclick="addLanguage()"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <h4 class="title mb-4 text-primary">CV, Portfolio & Social Media</h4>
            <div class="row">
                <!--Form Group-->
                @if(request()->segment(1) == 'profile' && $user && $user->profile && $user->profile->resume_url)
                <input type="hidden" name="hidden_resume" id="hidden_resume" value="{{ $user->profile->resume_url }}" />
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                @else
                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                @endif
                    <label>@lang('modules.front.resume') <sup>*</sup></label>
                    <input name="resume" class="form-control" type="file" accept=".pdf,.doc,.docx" required />
                    <span style="font-size: 14px;">@lang('modules.front.resumeFileType')</span>
                </div>

                @if(request()->segment(1) == 'profile' && $user && $user->profile && $user->profile->resume_url)
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label>@lang('modules.front.resumeCurrent')</label>
                    <p class="text-muted resume-button" id="">
                        <a target="_blank" href="{{ $user->profile->resume_url }}"
                        class="btn btn-sm btn-primary">
                            @lang('app.view') @lang('modules.jobApplication.resume')
                        </a>
                    </p>
                </div>
                @endif

                <!--Form Group-->
                <div class="col-12 form-group">
                    <label>@lang('modules.front.portfolio') <sup>*</sup></label>
                    <div id="portfolioForm">
                        @if($user && $user->profile && $user->profile->portfolios)
                        @foreach($user->profile->portfolios as $key => $portfolio)
                        <div class="card form-portfolio mb-1" style="height: auto;">
                        <input type="hidden" name="portfolio_id[{{ $key }}]" value="{{ $portfolio->id }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <select name="portfolio[{{ $key }}]" id="portfolio" class="selectpicker" data-live-search="true" data-width="100%">
                                            @foreach ($portfolios as $key1 => $value)
                                                <option value="{{ $value }}"
                                                @if($portfolio->name == $value) selected @endif
                                                >{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <input type="text" name="url[{{ $key }}]" placeholder="@lang('modules.front.portfolioUrl')" value="{{ $portfolio->url }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="card form-portfolio mb-1" style="height: auto;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <select name="portfolio[0]" id="portfolio" class="selectpicker" data-live-search="true" data-width="100%">
                                            @foreach ($portfolios as $key => $value)
                                                <option value="{{ $value }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-8 col-md-12 col-sm-12">
                                        <input type="text" name="url[0]" placeholder="@lang('modules.front.portfolioUrl')" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row-button-portfolio form-check-inline col-md-1 py-2">
                        <i class="fa fa-2x fa-minus-circle minus-portfolio" style="cursor:pointer" onclick="deletePortfolio()"></i>
                        <i class="fa fa-2x fa-plus-circle plus-portfolio" style="cursor:pointer" onclick="addPortfolio()"></i>
                    </div>
                </div>
            </div>
        </div>
        @if(isset($job))
        <div class="mt-5">
            <h4 class="title mb-4 text-primary">Why are you applying for this job?</h4>
            <div class="row">
                <!--Form Group-->
                <div class="col-12 form-group">
                <textarea rows="2" class="form-control form-control-lg {{ $errors->has('cover_letter') ? ' is-invalid' : '' }}" type="text" name="cover_letter"
                placeholder="Tell us the reason why you are applying for this job"
                ></textarea>
                @if ($errors->has('cover_letter'))
                    <span class="invalid-feedback">{{ $errors->first('cover_letter') }}</span>
                @endif
                </div>
            </div>
        </div>
        @endif
        @if (isset($job) && $job->section_visibility['terms_and_conditions'] == 'yes')
        <div class="mt-5">
            <h4 class="title mb-4 text-primary">@lang('modules.front.legalTerm')</h4>
            <div class="switchery-demo form-group d-inline-block" >
                <div class="mb-3 text-muted" style="text-align: justify; text-justify: inter-word;"><small>{!! $applicationSetting->legal_term !!}</small></div>
                <input style="vertical-align: middle; float: left; margin-top:5px;" id="check-a" class="mr-2" type="checkbox" value="yes" name="term_agreement" data-size="small" data-color="#00c292">
                <label for="term_agreement" class="align-top" ><b>@lang('modules.front.agreeWithTerm')</b></label>
            </div>
        </div>
        @endif
        <div class="mt-5" style="width: 25%;">
            <button class="btn btn-lg btn-primary btn-block theme-background" id="save-form" type="button">@lang('modules.front.submit')</button>
        </div>
    </div>
<!--End Checkout Details-->
</form>


@push('footer-script')
    <script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/switchery/dist/switchery.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/plugins/yearpicker/yearpicker.js') }}" async></script> --}}
    <script src="{{ asset('assets/node_modules/dropify/dist/js/dropify.min.js') }}" type="text/javascript"></script>
    <script>
        $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang("app.largeFile")'
            }
        });
    </script>
    <script>
    var select = $('.select2');
    
    $('.preferred_city_select2').select2({
        tags: true,
    });

    $(function() {
        select = $(select).select2({
            placeholder: "  Choose"
            , tags: true
            , dropdownParent: $("#createForm")
        });
        $('.study-select2').select2({
            tags: true
        })
    })
    </script>
    <script>
        $(document).ready(function () {
            var countExp = '<?php echo ($user && $user->profile && $user->profile->experiences) ? count($user->profile->experiences) : -1; ?>';
            if (countExp == 0) {
                $('#is_noExp').attr('checked', 'checked');
                $('.row-button-exp').hide();
            }
            $('.study-select2').select2({
                tags: true        
            });
        });

        function isGraduated(index){
            if(event.target.checked){
                $('#end-date-' + index).removeAttr('required');
                $('#end-date-' + index).val('');
                $('#div-end-date-' + index).attr('hidden', 'hidden');
                $('#end-date-' + index).attr('disabled', 'disabled');
            }
            else{
                $('#end-date-' + index).attr('required');
                $('#end-date-' + index).val('');
                $('#div-end-date-' + index).removeAttr('hidden');
                $('#end-date-' + index).removeAttr('disabled');
            }
        }

        function isNoExp(){
            if(event.target.checked){
                deleteAllExp();
                $('.row-button-exp').hide();
            }
            else{
                addExp();
                $('.row-button-exp').show();
            }
        }
    </script>
    <script>
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
    </script>
    <script>
        const fetchCountryState = "{{ route('jobs.fetchCountryState') }}";
        const csrfToken = "{{ csrf_token() }}";
        const selectCountry = "@lang('modules.front.selectCountry')";
        const selectState = "@lang('modules.front.selectState')";
        const selectCity = "@lang('modules.front.selectCity')";
        const pleaseWait = "@lang('modules.front.pleaseWait')";

        let country = '<?php echo ($user && $user->profile && $user->profile->country) ? $user->profile->country : ''; ?>';
        let state = '<?php echo ($user && $user->profile && $user->profile->state) ? $user->profile->state : ''; ?>';
    </script>
    <script src="{{ asset('front/assets/js/location.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <script>
        var salary_experience = document.getElementById('salary_experience[0]');
        var expected_salary_value = document.getElementById('expected_salary_value');

        expected_salary_value.addEventListener('keyup', function(e){
			expected_salary_value.value = formatRupiah(this.value);
		});
        
        salary_experience.addEventListener('keyup', function(e){
			salary_experience.value = formatRupiah(this.value);
		});

		/* Fungsi formatRupiah */
		function formatRupiah(angka){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return rupiah ? rupiah : null;
		}

        $(".dob").datepicker( {
            format: "yyyy-mm-dd",
            endDate: '-18y',
            autoclose : true,  
        });

        $(".eduDate").datepicker( {
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years",
            autoclose : true,
            startYear : '2000:',
        });
        
        // $(".grad_year").datepicker( {
        // format: "yyyy",
        // viewMode: "years", 
        // minViewMode: "years",
        // autoclose : true,
        // startYear : '2000:',
        // endDate: (new Date()).toDateString(),
        // });

        $('#save-form').click(function () {
            if('<?php echo (request()->segment(1) == 'profile') ? 'true' : 'false'; ?>' == 'true'){
                $.easyAjax({
                    url: '{{route("store-profile")}}',
                    container: '#createForm',
                    type: "POST",
                    file:true,
                    redirect: true,
                    // data: $('#createForm').serialize(),
                    success: function (response) {
                        if(response.status == 'success'){
                            window. scroll({top: 0, left: 0});
                            window.location.reload();
                        }
                    },
                    error: function (response) {
                    // console.log(response.responseText);
                        alert('please fill all required fields!');
                        handleFails(response);
                    }
                })
            }
            else if('<?php echo (request()->segment(1) == 'job') ? 'true' : 'false'; ?>' == 'true')
                $.easyAjax({
                    url: '{{route("jobs.saveApplication")}}',
                    container: '#createForm',
                    type: "POST",
                    file:true,
                    redirect: true,
                    // data: $('#createForm').serialize(),
                    success: function (response) {
                        if(response.status == 'success'){
                            window. scroll({top: 0, left: 0});
                            window.location.reload();
                        }
                    },
                    error: function (response) {
                    // console.log(response.responseText);
                        alert('please fill all required fields!');
                        handleFails(response);
                    }
                })
        });

        function handleFails(response) {
            if (typeof response.responseJSON.errors != "undefined") {
                var keys = Object.keys(response.responseJSON.errors);
                $('#createForm').find(".has-error").find(".help-block").remove();
                $('#createForm').find(".has-error").removeClass("has-error");

                for (var i = 0; i < keys.length; i++) {
                    // Escape dot that comes with error in array fields
                    var key = keys[i].replace(".", '\\.');
                    var formarray = keys[i];

                    // If the response has form array
                    if(formarray.indexOf('.') >0){
                        var array = formarray.split('.');
                        response.responseJSON.errors[keys[i]] = response.responseJSON.errors[keys[i]];
                        key = array[0]+'['+array[1]+']';
                    }

                    var ele = $('#createForm').find("[name='" + key + "']");

                    var grp = ele.closest(".form-group");
                    $(grp).find(".help-block").remove();

                    //check if wysihtml5 editor exist
                    var wys = $(grp).find(".wysihtml5-toolbar").length;

                    if(wys > 0){
                        var helpBlockContainer = $(grp);
                    }
                    else{
                        var helpBlockContainer = $(grp).find("div:first");
                    }
                    if($(ele).is(':radio')){
                        helpBlockContainer = $(grp);
                    }

                    if (helpBlockContainer.length == 0) {
                        helpBlockContainer = $(grp);
                    }

                    helpBlockContainer.append('<div class="help-block">' + response.responseJSON.errors[keys[i]] + '</div>');
                    $(grp).addClass("has-error");
                }

                if (keys.length > 0) {
                    var element = $("[name='" + keys[0] + "']");
                    if (element.length > 0) {
                        $("html, body").animate({scrollTop: element.offset().top - 150}, 200);
                    }
                }
            }
        }

		var exp = <?php echo ($user && $user->profile && $user->profile->experiences) ? count($user->profile->experiences) : 1; ?>;
		function addExp() {
			var el = '<div class="card mb-1" style="height: auto;">'+
                '<div class="card-body">'+
                '<div class="row">'+
					'<div class="col-md-6 my-sm-1 my-xs-1">'+
						'<div class="form-group">'+
                            '<label>Start Year <sup>*</sup></label>'+
							'<input class="eduDate form-control form-control-lg" type="text" name="start_period[' + exp + ']"'+
									'placeholder="ex: 2020">'+
						'</div>'+
					'</div>'+
                    '<div class="col-md-6 my-sm-1 my-xs-1">'+
						'<div class="form-group">'+
                            '<label>End Year <sup>*</sup></label>'+
							'<input class="eduDate form-control form-control-lg" type="text" name="end_period[' + exp + ']"'+
									'placeholder="ex: 2022">'+
						'</div>'+
					'</div>'+
					'<div class="col-md-6 my-sm-1 my-xs-1">'+
						'<div class="form-group">'+
                            '<label>@lang('modules.front.expPlace') <sup>*</sup></label>'+
							'<input class="form-control form-control-lg" type="text" name="company[' + exp + ']"'+
									'placeholder="@lang('modules.front.expPlace')">'+
						'</div>'+
					'</div>'+
                    '<div class="col-md-6 my-sm-1 my-xs-1">'+
						'<div class="form-group">'+
                            '<label>@lang('modules.front.expPosition') <sup>*</sup></label>'+
							'<input class="form-control form-control-lg" type="text" name="position[' + exp + ']"'+
									'placeholder="@lang('modules.front.expPosition')">'+
						'</div>'+
					'</div>'+
                    '<div class="col-md-6 my-sm-1 my-xs-1">'+
                        '<div class="form-group">'+
                            '<label>Industry <sup>*</sup></label>'+
                            '<select name="industry_id[' + exp + ']" class="select2 custom-select select2-expindustry-' + exp + '">'+
                                '<option value=""> -- Choose -- </option>'+
                                '@foreach($industries as $industry)'+
                                    '<option value="{{ $industry->id }}">{{ ucfirst($industry->name) }}</option>'+
                                '@endforeach'+
                            '</select>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-6 my-sm-1 my-xs-1">'+
                        '<div class="form-group">'+
                            '<label>Salary <sup>(optional)</sup></label>'+
                            '<div class="d-flex align-content-center col-12 px-0">'+
                                '<span class="mt-3 mr-2">Rp. </span>'+
                                '<input class="form-control form-control-lg" id="salary_experience[' + exp + ']" type="text" value="0" name="salary[' + exp + ']"'+
                                'placeholder="IDR"'+
                                '>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-6 my-sm-1 my-xs-1">'+
                        '<div class="form-group">'+
                            '<label>@lang('modules.front.expDescription') <sup>*</sup></label>'+
                            '<textarea rows="2" class="form-control form-control-lg" type="text" name="description[' + exp + ']"'+
                            'placeholder="@lang('modules.front.expDescription')"'+
                            '></textarea>'+
                        '</div>'+
                    '</div>'+
				'</div>'+
                '</div>'+
                '</div>'+
                '<div class="row-button-exp form-check-inline col-md-1 py-2">'+
                    '<i class="fa fa-2x fa-minus-circle minus-exp" style="cursor:pointer" onclick="deleteExp()"></i>'+
                    '<i class="fa fa-2x fa-plus-circle plus-exp" style="cursor:pointer" onclick="addExp()"></i>'+
                '</div>';
            $('.row-button-exp').remove();
			$('#expForm').append(el);

            var salary_experience = document.getElementById('salary_experience['+exp+']');
            salary_experience.addEventListener('keyup', function(e){
                salary_experience.value = formatRupiah(this.value);
            });


            $('.select2-expindustry-' + lang).select2({
                placeholder: "  Choose"
                , tags: true
                , dropdownParent: $("#createForm")
            });

			exp++;

            $(".eduDate").datepicker( {
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years",
                autoclose : true,
                startYear : '2000:',
            });
            
            $('#is_noExp').removeAttr('checked');
		}

        function deleteExp() {
            if (exp > 0){
                $('#expForm .card').last().remove();
                if (exp == 1){
                    $('.minus-exp').remove();
                    $('#is_noExp').attr('checked', 'checked');
                }
                exp--;
            }
            else{
                $('.minus-exp').remove();
            }
		}

        function deleteAllExp() {
            for (let i = 0; i < exp; i++) {
                $('#expForm .card').last().remove();
            }
		}

        var skill = <?php echo ($user && $user->profile && $user->profile->skills) ? count($user->profile->skills) : 1; ?>;
		function addSkill() {
			var el = '<div class="col-md-6 my-sm-1 my-xs-1 form-skill">'+
                        '<select name="skills[' + skill + ']" class="form-control">'+
                            '<option value=""> -- Choose -- </option>'+
                           ' @foreach($skills as $skill)'+
                                '<option value="{{ $skill->name }}">{{ ucfirst($skill->name) }}</option>'+
                            '@endforeach'+
                        '</select>'+
					'</div>';
			$('#skillForm').append(el);
            if(skill == 1){
                var button = '<i class="fa fa-2x fa-minus-circle minus-skill" style="cursor:pointer" onclick="deleteSkill()"></i>'+
                            '<i class="fa fa-2x fa-plus-circle plus-skill" style="cursor:pointer" onclick="addSkill()"></i>';
                $('.plus-skill').remove();
                $('.minus-skill').remove();
                $('.row-button-skill').append(button);
            }
			skill++;
		}

        function deleteSkill() {
            if (skill > 1){
                $('.form-skill').last().remove();
                if (skill == 2){
                    $('.minus-skill').remove();
                }
                skill--;
            }
            else{
                $('.minus-skill').remove();
            }
		}

        var education = <?php echo ($user && $user->profile && $user->profile->educations) ? count($user->profile->educations) : 1; ?>;
		function addEducation() {
			var el = '<div class="card form-education mb-1" style="height: auto;">'+
						'<div class="card-body">'+
							'<div class="row">'+
                                '<div class="form-group col-lg-12 col-md-12 col-sm-12">'+
                                    '<label>@lang('modules.front.university') <sup>*</sup></label>'+
                                    '<input type="text" name="university[' + education + ']" class="form-control" placeholder="@lang('modules.front.university')" required>'+
                                '</div>'+
                                '<div class="form-group col-lg-6 col-md-12 col-sm-12">'+
                                    '<label>@lang('modules.front.degree') <sup>*</sup></label>'+
                                    '<select name="degree['+ education +']" id="degree" class="form-control selectpicker" data-live-search="true" data-width="100%" >'+
                                    '@foreach ($degrees as $key1 => $degree)'+
                                        '<option value="{{ __($degree) }}">{{ __($degree) }}</option>'+
                                    '@endforeach'+
                                    '</select>'+
                                '</div>'+
                                '<div class="form-group col-lg-6 col-md-12 col-sm-12">'+
                                    '<label>@lang('modules.front.study') <sup>*</sup></label>'+
                                    // '<input type="text" name="study['+ education +']" class="form-control" placeholder="@lang('modules.front.study')" required>'+
                                    '<select name="study['+ education +']" class="study-select2">'+
                                    '<option value selected>Select Field Of Study</option>'+
                                    '@foreach ($majors as $major)'+
                                        '<option value="{{ __($major->major) }}">{{ __($major->major) }}</option>'+
                                    '@endforeach'+
                                    '</select>'+
                                '</div>'+
                                '<div class="form-group col-lg-6 col-md-12 col-sm-12">'+
                                    '<label>@lang('modules.front.eduStartDate') <sup>*</sup></label>'+
                                    '<input type="number" id="start-date-'+ education +'" name="start_date['+ education +']" min="1900" class="eduDate form-control" placeholder="@lang('modules.front.eduStartDate')" required>'+
                                '</div>'+
                                '<div id="div-end-date-'+ education +'" class="form-group col-lg-6 col-md-12 col-sm-12">'+
                                    '<label>@lang('modules.front.eduEndDate') <sup>*</sup></label>'+
                                    '<input type="number" id="end-date-'+ education +'" name="end_date['+ education +']" min="1900" class="eduDate form-control" placeholder="@lang('modules.front.eduEndDate')" required>'+
                                '</div>'+
                                '<div class="form-group col-lg-6 col-md-12 col-sm-12">'+
                                    '<label>@lang('modules.front.gpa') <sup>*</sup></label>'+
                                    '<input type="number" name="gpa['+ education +']" min="0" class="form-control" placeholder="@lang('modules.front.gpa')" required>'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group mt-4">'+
                                '<input type="hidden" id="is_graduated" name="is_graduated['+ education +']" value="1">'+
                                '<input onclick="isGraduated('+ education +')" style="vertical-align: middle; float: left; margin-top:5px;" id="check-a" class="mr-2" type="checkbox" value="0" name="is_graduated['+ education +']" data-size="small" data-color="#00c292">'+
                                '<label for="term_agreement" class="align-top" >@lang('modules.front.haveNotGraduated')</label>'+
                            '</div>'+
						'</div>'+
					'</div>';
			$('#educationForm').append(el);
            $('.study-select2').select2({
                tags: true        
            });
            if(education == 1){
                var button = '<i class="fa fa-2x fa-minus-circle minus-education" style="cursor:pointer" onclick="deleteEducation()"></i>'+
                            '<i class="fa fa-2x fa-plus-circle plus-education" style="cursor:pointer" onclick="addEducation()"></i>';
                $('.plus-education').remove();
                $('.minus-education').remove();
                $('.row-button-education').append(button);
            }
			education++;

            $(".eduDate").datepicker( {
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years",
                autoclose : true,
                startYear : '2000:',
            });
		}

        function deleteEducation() {
            if (education > 1){
                $('.form-education').last().remove();
                if (education == 2){
                    $('.minus-education').remove();
                }
                education--;
            }
            else{
                $('.minus-education').remove();
            }
		}

        var lang = <?php echo ($user && $user->profile && $user->profile->languages) ? count($user->profile->languages) : 1; ?>;
		function addLanguage() {
			var el = `<div class="card form-language mb-1" style="height: auto;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select name="language_name[` + lang + `]" class="select2 custom-select select2-language-` + lang + `">
                                            <option value=""> -- Choose -- </option>
                                            @foreach($language_names as $language_val)
                                                <option value="{{ $language_val['name'] }}"
                                                    @if($language_val['name'] == 'Indonesian')
                                                    selected
                                                    @endif
                                                >{{ ucfirst($language_val['name']) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select name="language_level[` + lang + `]" id="language_level" class="selectpicker" data-live-search="true" data-width="100%">
                                            @foreach ($language_levels as $key1 => $value)
                                                <option value="{{ $value }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>`;
			$('#languageForm').append(el);
            if(lang == 1){
                var button = '<i class="fa fa-2x fa-minus-circle minus-language" style="cursor:pointer" onclick="deleteLanguage()"></i>'+
                            '<i class="fa fa-2x fa-plus-circle plus-language" style="cursor:pointer" onclick="addLanguage()"></i>';
                $('.plus-language').remove();
                $('.minus-language').remove();
                $('.row-button-language').append(button);
            }
            
            $('.select2-language-' + lang).select2({
                placeholder: "  Choose"
                , tags: true
                , dropdownParent: $("#createForm")
            });

			lang++;
		}

        function deleteLanguage() {
            if (lang > 1){
                $('.form-language').last().remove();
                if (lang == 2){
                    $('.minus-language').remove();
                }
                lang--;
            }
            else{
                $('.minus-language').remove();
            }
		}

        var portfolio = <?php echo ($user && $user->profile && $user->profile->portfolios) ? count($user->profile->portfolios) : 1; ?>;
		function addPortfolio() {
			var el = '<div class="card form-portfolio mb-1" style="height: auto;">' +
                '<div class="card-body">' +
                    '<div class="row">' +
                        '<div class="col-lg-4 col-md-12 col-sm-12">' +
                            '<select name="portfolio['+ portfolio +']" id="portfolio" class="selectpicker" data-live-search="true" data-width="100%">' +
                                '@foreach ($portfolios as $key => $value)' +
                                    '<option value="{{ $value }}">{{ $value }}</option>' +
                                '@endforeach' +
                            '</select>' +
                        '</div>' +
                        '<div class="form-group col-lg-8 col-md-12 col-sm-12">' +
                            '<input type="text" name="url['+ portfolio +']" placeholder="@lang('modules.front.portfolioUrl')" required>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';
			$('#portfolioForm').append(el);
            if(portfolio == 1){
                var button = '<i class="fa fa-2x fa-minus-circle minus-portfolio" style="cursor:pointer" onclick="deletePortfolio()"></i>'+
                            '<i class="fa fa-2x fa-plus-circle plus-portfolio" style="cursor:pointer" onclick="addPortfolio()"></i>';
                $('.plus-portfolio').remove();
                $('.minus-portfolio').remove();
                $('.row-button-portfolio').append(button);
            }
			portfolio++;
		}

        function deletePortfolio() {
            if (portfolio > 1){
                $('.form-portfolio').last().remove();
                if (portfolio == 2){
                    $('.minus-portfolio').remove();
                }
                portfolio--;
            }
            else{
                $('.minus-portfolio').remove();
            }
		}
    </script>
@endpush