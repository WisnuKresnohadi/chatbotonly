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
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script> </head>
    <script>
        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route("store-languages")}}',
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
    </script>
@endpush