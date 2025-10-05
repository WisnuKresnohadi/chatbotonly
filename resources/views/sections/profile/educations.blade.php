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
                                <input type="text" name="study[0]" class="form-control" placeholder="@lang('modules.front.study')" required>
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

    $(function() {
        select = $(select).select2({
            placeholder: "Pilih Skill"
            , tags: true
            , dropdownParent: $("#createForm")
        });

        $('.study-select2').select2({
            tags: true        
        })
    })
    </script>
    <script>
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
    </script>
    <script>
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script> </head>
    <script>
        $(".eduDate").datepicker( {
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years",
            autoclose : true,
            startYear : '2000:',
        });

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route("store-educations")}}',
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
                                        '<option value="{{ __($major->major) }}"'+
                                        '@if ($education->study)'+
                                            '{{ $education->study == __($major->major) ? 'selected' : '' }}'+
                                        '@endif>{{ __($major->major) }}</option>'+
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
    </script>
@endpush