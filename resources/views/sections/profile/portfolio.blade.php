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
@php
$portfolios = [
    'LinkedIn', 'Portfolio', 'Website', 'Github', 'Gitlab', 'Behance', 'TikTok', 'Twitter', 'Instagram', 'Facebook', 'Other'
];
@endphp
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
                    <span>@lang('modules.front.resumeFileType')</span>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script> </head>
    <script>
        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route("store-portfolio")}}',
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