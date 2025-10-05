{{-- <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">

@push('header-css')
<link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/datepicker3.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">

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
    <input type="hidden" name="user_id" value="@if($user) {{ $user->id }} @endif">
    <input type="hidden" name="profile_user_id" value="@if($user && $user->profile) {{ $user->profile->id }} @endif">
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

                <div class="form-group col-lg-12 col-md-12 col-sm-12 mb-5">
                    <label>Headline <sup>*</sup></label>
                    <input type="text" name="headline" class="form-control {{ $errors->has('headline') ? ' is-invalid' : '' }}" placeholder="Example: Software Developer, Photographer, Etc" value="@if($user && $user->profile){{ $user->profile->headline }}@endif" required>
                    @if ($errors->has('headline'))
                        <span class="invalid-feedback">{{ $errors->first('headline') }}</span>
                    @endif
                </div>
                
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
        <div class="mt-5" style="width: 25%;">
            <button class="btn btn-lg btn-primary btn-block theme-background" id="save-form" type="button">Save</button>
        </div>
    </div>
<!--End Checkout Details-->
</form>


@push('footer-script')
    <script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script> </head>
    <script>
        $(".dob").datepicker( {
        format: "yyyy-mm-dd",
        endDate: '-18y',
        autoclose : true,  
        });

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route("store-personal")}}',
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
    </script>
@endpush