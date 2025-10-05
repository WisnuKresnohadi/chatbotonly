{{-- <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">

@push('header-css')
<link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/datepicker3.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/node_modules/multiselect/css/multi-select.css') }}">
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
    <input type="hidden" name="user_id" value="@if($user) {{ $user->id }} @endif">
    <input type="hidden" name="profile_user_id" value="@if($user && $user->profile) {{ $user->profile->id }} @endif">
    <!--Checkout Details-->
    <div class="checkout-form">
        <div>
            <h4 class="title mb-4 text-primary">Experience & Skills</h4>
            <div class="row">
                <!--Form Group-->
                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                    <label>@lang('modules.front.experience')</label>
                    @if(!$user || !$user->profile || !$user->profile->experiences || count($user->profile->experiences) == 0)
                    <div class="form-group my-1">
                        <input @if(count($user->profile->experiences) == 0) checked @endif onclick="isNoExp()" name="is_noExp" style="vertical-align: middle; float: left; margin-top:4px;" id="is_noExp" class="mr-2" type="checkbox" data-size="small" data-color="#00c292">
                        <label for="term_agreement" class="align-top" >No experience yet?</label>
                    </div>
                    @endif
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
                                                <input class="ml-3 form-control form-control-lg salary_experience[{{ $key }}]" id="salary_experience[{{ $key }}]" onkeyup="convertNominal(this);" value="{{$experience->salary ?? 0}}" type="text" name="salary[{{ $key }}]"
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
                                                <input class="form-control form-control-lg" id="salary_experience[0]" id="salary_experience[0]" onkeyup="convertNominal(this);" type="text" value="0" name="salary[0]"
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
        <div class="mt-5" style="width: 25%;">
            <button class="btn btn-lg btn-primary btn-block theme-background" id="save-form" type="button">Save</button>
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
        
    </script>
    <script>
    var select = $('.select2');

    $(function() {
        select = $(select).select2({
            placeholder: "  Choose"
            , tags: true
            , dropdownParent: $("#createForm")
        });
    })
    </script>
    <script>
        $(document).ready(function () {
            var countExp = <?php echo ($user && $user->profile && $user->profile->experiences) ? count($user->profile->experiences) : -1; ?>;
            if (countExp == 0) {
                $('#is_noExp').attr('checked', 'checked');
                $('.row-button-exp').hide();
            }

            for (let index = 0; index < countExp; index++) {
                var salary = document.getElementById('salary_experience['+index+']');

                salary.value = formatRupiah(salary.value);
            }

        });

        function convertNominal(nominal){
            console.log(nominal.id);
            var result = formatRupiah(nominal.value);
            var id = document.getElementById(nominal.id);
            id.value = result;
        }

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
                url: '{{route("store-skills")}}',
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
                            '<select name="industry_id[' + exp + ']" class="select2 custom-select select2-expindustry-'+exp+'">'+
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
                                '<input class="form-control form-control-lg" id="salary_experience['+exp+']" type="text" value="0" name="salary[' + exp + ']"'+
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

            // inisialisasi ulang 

            $(".eduDate").datepicker( {
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years",
                autoclose : true,
                startYear : '2000:',
            });

            var salary_experience = document.getElementById('salary_experience['+exp+']');
            
            salary_experience.addEventListener('keyup', function(e){
                salary_experience.value = formatRupiah(this.value);
            });

            $('.select2-expindustry-' + exp).select2({
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
    </script>
@endpush