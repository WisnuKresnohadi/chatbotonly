<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-app-assets-path="{{ url("app-assets")}}" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <!DOCTYPE html>

    <html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ url("app-assets")}}" data-template="horizontal-menu-template">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <title>Talentern</title>

        <meta name="description" content="" />

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ url("app-assets/img/favicon/favicon.ico")}}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

        <!-- Icons -->
        <link rel="stylesheet" href="{{ url("app-assets/vendor/fonts/fontawesome.css")}}" />
        <link rel="stylesheet" href="{{ url("app-assets/vendor/fonts/tabler-icons.css")}}" />
        <link rel="stylesheet" href="{{ url("app-assets/vendor/fonts/flag-icons.css")}}" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ url("app-assets/vendor/css/rtl/core.css")}}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ url("app-assets/vendor/css/rtl/theme-default.css")}}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ url("app-assets/css/demo.css")}}" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ url("app-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css")}}" />
        <link rel="stylesheet" href="{{ url("app-assets/vendor/libs/node-waves/node-waves.css")}}" />
        <link rel="stylesheet" href="{{ url("app-assets/vendor/libs/typeahead-js/typeahead.css")}}" />
        <link rel="stylesheet" href="{{ url("app-assets/vendor/libs/apex-charts/apex-charts.css")}}" />
        <link rel="stylesheet" href="{{ url("app-assets/vendor/libs/swiper/swiper.css")}}" />
        <link rel="stylesheet" href="{{ url("app-assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css")}}" />
        <link rel="stylesheet" href="{{ url("app-assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css")}}" />
        <link rel="stylesheet" href="{{ url("app-assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css")}}" />
        <link rel="stylesheet" href="{{ url("app-assets/vendor/libs/select2/select2.css")}}" />
        <link rel="stylesheet" href="{{ url("app-assets/vendor/libs/bootstrap-select/bootstrap-select.css")}}" />
        <link rel="stylesheet" href="{{ url("app-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css")}}" />
        <link rel="stylesheet" href="{{ url("app-assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css")}}" />

        <!-- Page CSS -->
        <link rel="stylesheet" href="{{ url("app-assets/vendor/css/pages/cards-advance.css")}}" />
        <!-- Helpers -->
        <script src="{{ url("app-assets/vendor/js/helpers.js")}}"></script>

        @yield('page_style')
        <style>
            .dropdown-item:focus,
            .dropdown-item:hover {
                color: #4EA971 !important
            }

            .dropdown-item.active,
            .dropdown-item:active {
                color: #FFF;
                background-color: #4EA971 !important
            }
        </style>
        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
        <script src="{{ url("app-assets/vendor/js/template-customizer.js")}}"></script>
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="{{ url("app-assets/js/config.js")}}"></script>
    </head>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ url("app-assets/img/favicon/favicon.ico")}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- Icons -->
    <link rel="stylesheet" href="{{ url("app-assets/vendor/fonts/fontawesome.css")}}" />
    <link rel="stylesheet" href="{{ url("app-assets/vendor/fonts/tabler-icons.css")}}" />
    <link rel="stylesheet" href="{{ url("app-assets/vendor/fonts/flag-icons.css")}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url("app-assets/vendor/css/rtl/core.css")}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ url("app-assets/vendor/css/rtl/theme-default.css")}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ url("app-assets/css/demo.css")}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ url("app-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css")}}" />
    <link rel="stylesheet" href="{{ url("app-assets/vendor/libs/node-waves/node-waves.css")}}" />
    <link rel="stylesheet" href="{{ url("app-assets/vendor/libs/typeahead-js/typeahead.css")}}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ url("app-assets/vendor/libs/formvalidation/dist/css/formValidation.min.css")}}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ url("app-assets/vendor/css/pages/page-auth.css")}}" />
    <!-- Helpers -->
    <script src="{{ url("app-assets/vendor/js/helpers.js")}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ url("app-assets/vendor/js/template-customizer.js")}}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ url("app-assets/js/config.js")}}"></script>
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ url("assets/vendor/libs/jquery/jquery.js")}}"></script>
    <script src="{{ url("assets/vendor/libs/popper/popper.js")}}"></script>
    <script src="{{ url("assets/vendor/js/bootstrap.js")}}"></script>
    <script src="{{ url("assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js")}}"></script>
    <script src="{{ url("assets/vendor/libs/node-waves/node-waves.js")}}"></script>

    <script src="{{ url("assets/vendor/libs/hammer/hammer.js")}}"></script>
    <script src="{{ url("assets/vendor/libs/i18n/i18n.js")}}"></script>
    <script src="{{ url("assets/vendor/libs/typeahead-js/typeahead.js")}}"></script>

    <script src="{{ url("assets/vendor/js/menu.js")}}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ url("assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js")}}"></script>
    <script src="{{ url("assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js")}}"></script>
    <script src="{{ url("assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js")}}"></script>

    <!-- Main JS -->
    <script src="{{ url("assets/js/main.js")}}"></script>

    <!-- Page JS -->
    <script src="{{ url("assets/js/pages-auth.js")}}"></script>
</head>
<body>
    <div class="authentication-wrapper authentication-cover authentication-bg" style="background-image: url({{ asset('app-assets/img/branding/bg_password.png') }});background-size: cover; background-repeat: no-repeat; min-width:100%;">
        <div class="authentication-inner row">
            <div class="d-flex col-12 align-items-center p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    @yield('conten')
                    <div class="card text-center" style="width: 450px;">
                        <div class="card-header">
                            <div class="text-center">
                                <img src="{{ asset('app-assets/img/branding/Talentern.png') }}" style="width:250px">
                            </div>
                        </div>
                        <form class="default-form" id="updatePasswordForm" action="{{ url('company/set-password') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{$token}}">
                            <div class="text-start ps-5 pe-5">
                                <h5>Silakan buat kata sandi anda</h5>
                                <div class="mb-3 ">
                                    <label class="form-label">Kata sandi <span style="color: red;">*</span> </label>
                                    <input type="password" name="password" class="form-control"  placeholder="Kata sandi"  >
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3 ">
                                    <label class="form-label">Konfirmasi Kata sandi <span style="color: red;">*</span> </label>
                                    <input type="password" name="password_confirmation" class="form-control"   placeholder="Konfirmasi Kata sandi" >
                                    <div class="invalid-feedback"></div>
                                </div>

                                <h6>Password Requirements:</h6>
                                <li>Panjang minimal 8 karakter</li>
                                <li>Setidaknya satu karakter huruf kecil</li>
                                <li>Setidaknya satu angka, simbol atau karakter</li>
                            </div>
                            <button type="submit" class="btn btn-success m-5">Atur kata sandi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $('#updatePasswordForm').submit(function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: "{{ url('/company/set-password') }}",
        data: $(this).serialize(),
        success: function(response) {
            alert(response.message);
        },
        error: function(xhr) {
            var errors = xhr.responseJSON;
            if ($.isEmptyObject(errors) === false) {
                $.each(errors.errors, function(key, value) {
                    alert(value);
                });
            }
        }
    });
});
</script>
</html>