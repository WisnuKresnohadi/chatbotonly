<!DOCTYPE html>

<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-app-assets-path="{{ url("app-assets")}}"
  data-template="vertical-menu-template"
>
  <head>
    <meta charset="utf-8" /><!DOCTYPE html>

    <html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ url("app-assets")}}" data-template="horizontal-menu-template">
    
    <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    
      <title>Talentern - message</title>
    
      <meta name="description" content="" />
    
      <!-- Favicon -->
      <link rel="icon" type="image/x-icon" href="{{url("")}}app-assets/img/favicon/favicon.ico" />
    
      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    
      <!-- Icons -->
      <link rel="stylesheet" href="{{url("app-assets/vendor/fonts/fontawesome.css")}}" />
      <link rel="stylesheet" href="{{url("app-assets/vendor/fonts/tabler-icons.css")}}" />
      <link rel="stylesheet" href="{{url("app-assets/vendor/fonts/flag-icons.css")}}" />
    
      <!-- Core CSS -->
      <link rel="stylesheet" href="{{url("app-assets/vendor/css/rtl/core.css")}}" class="template-customizer-core-css" />
      <link rel="stylesheet" href="{{url("app-assets/vendor/css/rtl/theme-default.css")}}" class="template-customizer-theme-css" />
      <link rel="stylesheet" href="{{url("app-assets/css/demo.css")}}" />
    
      <!-- Vendors CSS -->
      <link rel="stylesheet" href="{{url("app-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css")}}" />
      <link rel="stylesheet" href="{{url("app-assets/vendor/libs/node-waves/node-waves.css")}}" />
      <link rel="stylesheet" href="{{url("app-assets/vendor/libs/typeahead-js/typeahead.css")}}" />
      <link rel="stylesheet" href="{{url("app-assets/vendor/libs/apex-charts/apex-charts.css")}}" />
      <link rel="stylesheet" href="{{url("app-assets/vendor/libs/swiper/swiper.css")}}" />
      <link rel="stylesheet" href="{{url("app-assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css")}}" />
      <link rel="stylesheet" href="{{url("app-assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css")}}" />
      <link rel="stylesheet" href="{{url("app-assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css")}}" />
      <link rel="stylesheet" href="{{url("app-assets/vendor/libs/select2/select2.css")}}" />
      <link rel="stylesheet" href="{{url("app-assets/vendor/libs/bootstrap-select/bootstrap-select.css")}}" />
      <link rel="stylesheet" href="{{url("app-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css")}}" />
      <link rel="stylesheet" href="{{url("app-assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css")}}" />
    
      <!-- Page CSS -->
      <link rel="stylesheet" href="{{url("app-assets/vendor/css/pages/cards-advance.css")}}" />
      <!-- Helpers -->
      <script src="{{url("app-assets/vendor/js/helpers.js")}}"></script>
    
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
      <script src="{{url("app-assets/vendor/js/template-customizer.js")}}"></script>
      <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
      <script src="{{url("app-assets/js/config.js")}}"></script>
    </head>

    <title>Login Cover - Pages | Vuexy - Bootstrap Admin Template</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{url("")}}app-assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons -->
    <link rel="stylesheet" href="{{url("app-assets/vendor/fonts/fontawesome.css")}}" />
    <link rel="stylesheet" href="{{url("app-assets/vendor/fonts/tabler-icons.css")}}" />
    <link rel="stylesheet" href="{{url("app-assets/vendor/fonts/flag-icons.css")}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{url("app-assets/vendor/css/rtl/core.css")}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{url("app-assets/vendor/css/rtl/theme-default.css")}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{url("app-assets/css/demo.css")}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{url("app-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css")}}" />
    <link rel="stylesheet" href="{{url("app-assets/vendor/libs/node-waves/node-waves.css")}}" />
    <link rel="stylesheet" href="{{url("app-assets/vendor/libs/typeahead-js/typeahead.css")}}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{url("app-assets/vendor/libs/formvalidation/dist/css/formValidation.min.css")}}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{url("app-assets/vendor/css/pages/page-auth.css")}}" />
    <link rel="stylesheet" href="{{ url('app-assets/css/style.css') }}" />
    <!-- Helpers -->
    <script src="{{url("app-assets/vendor/js/helpers.js")}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{url("app-assets/vendor/js/template-customizer.js")}}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{url("app-assets/js/config.js")}}"></script>
  </head>
  <body>
    <div class="authentication-wrapper authentication-cover authentication-bg" style="background-image: url({{asset('assets/images/background/Bg-Green.svg')}}); background-repeat: no-repeat; background-size: cover;  padding-bottom: 1rem;">
      <div class="authentication-inner text-center">
        <div class="text-center">
          <h3 class="mb-1 fw-bold">403 | Page Restricted</h3>
          <p class="mb-4" style="font-size: 18px">Anda tidak memiliki akses ke halaman ini.</p>
          <a href="{{ url('/') }}" class="btn btn-primary"><i class="ti ti-arrow-left"></i> Kembali</a>
        </div>
        <img alt="auth-login-cover" class="img-fluid" style="width: 500px; height: 508.214px; flex-shrink: 0;" src="{{ asset('assets/images/nothing.svg') }}" alt="Login" />
      </div>
    </div>
</body>
</html>

