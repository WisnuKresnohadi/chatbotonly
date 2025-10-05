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

<form method="POST" id="createForm" class="ajax-form default-form">
    {{csrf_field()}}
    <input type="hidden" name="user_id" value="@if($user) {{ $user->id }} @endif">
    <input type="hidden" name="profile_user_id" value="@if($user && $user->profile) {{ $user->profile->id }} @endif">
    @if($user && $user->profile && $user->profile->information)
    <input type="hidden" name="information_id" value="{{ $user->profile->information->id }}">
    @endif
    <!--Checkout Details-->
    <div class="checkout-form">
        <div>
            <h4 class="title mb-4 text-primary">Additional Information</h4>
            <div class="row">
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label>Expected Salary</label>
                    <input type="hidden" name="expected_salary_type" value="IDR">
                    <div class="d-flex align-content-center col-12 px-0">
                        <span class="mt-3 mr-2">Rp. </span>
                        <input type="text" id="expected_salary_value" name="expected_salary_value" class="expected_salary_value form-control {{ $errors->has('expected_salary_value') ? ' is-invalid' : '' }}" placeholder="Salary Value" value="@if($user && $user->profile && $user->profile->information){{ $user->profile->information->expected_salary_value }}@else 0 @endif" required>
                        @if ($errors->has('expected_salary_value'))
                            <span class="invalid-feedback">{{ $errors->first('expected_salary_value') }}</span>
                        @endif
                    </div>
                </div>

                <!--Form Group-->
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <div class="d-flex justify-content-start">
                        <label>Preferred Work Location</label>
                    </div>
                    {{-- <input type="text" name="preferred_city" class="form-control {{ $errors->has('preferred_city') ? ' is-invalid' : '' }}" placeholder="@lang('modules.front.selectCity')" value="@if($user && $user->profile && $user->profile->information){{ $user->profile->information->preferred_city }}@endif" required> --}}
                    <div class="d-flex justify-content-start">
                        <select name="preferred_city[]" class="form-control preferred_city_select2 {{ $errors->has('preferred_city') ? ' is-invalid' : '' }}" required multiple="multiple">
                            @foreach($locations as $city)
                                <option value="{{ $city->location }}" 
                                    @if ($preferred_cities)
                                    @foreach ($preferred_cities as $preferred_city)
                                    @if($preferred_city == $city->location) 
                                    selected 
                                    @endif
                                    @endforeach
                                    @endif
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
    $('.preferred_city_select2').select2({
        tags: true,
        tokenSeparators: [',', ' ']
    });

    var change_expected_salary = $('#expected_salary_value').val();
    var x = formatRupiah(change_expected_salary);
    $('#expected_salary_value').val(x);

    var expected_salary_value = document.getElementById('expected_salary_value');
    expected_salary_value.addEventListener('keyup', function(e){
        expected_salary_value.value = formatRupiah(this.value);
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
    </script>
    <script>
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
    </script>
    <script>
        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route("store-information")}}',
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