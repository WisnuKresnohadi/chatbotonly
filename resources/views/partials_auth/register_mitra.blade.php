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
    
      <title>Register Mitra</title>
    
      <meta name="description" content="" />
    
      <!-- Favicon -->
      <link rel="icon" type="image/x-icon" href="../../app-assets/img/favicon/favicon.ico" />
    
      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    
      <!-- Icons -->
      <link rel="stylesheet" href="../../app-assets/vendor/fonts/fontawesome.css" />
      <link rel="stylesheet" href="../../app-assets/vendor/fonts/tabler-icons.css" />
      <link rel="stylesheet" href="../../app-assets/vendor/fonts/flag-icons.css" />
    
      <!-- Core CSS -->
      <link rel="stylesheet" href="../../app-assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
      <link rel="stylesheet" href="../../app-assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
      <link rel="stylesheet" href="../../app-assets/css/demo.css" />
    
      <!-- Vendors CSS -->
      <link rel="stylesheet" href="../../app-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
      <link rel="stylesheet" href="../../app-assets/vendor/libs/node-waves/node-waves.css" />
      <link rel="stylesheet" href="../../app-assets/vendor/libs/typeahead-js/typeahead.css" />
      <link rel="stylesheet" href="../../app-assets/vendor/libs/apex-charts/apex-charts.css" />
      <link rel="stylesheet" href="../../app-assets/vendor/libs/swiper/swiper.css" />
      <link rel="stylesheet" href="../../app-assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
      <link rel="stylesheet" href="../../app-assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
      <link rel="stylesheet" href="../../app-assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
      <link rel="stylesheet" href="../../app-assets/vendor/libs/select2/select2.css" />
      <link rel="stylesheet" href="../../app-assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
      <link rel="stylesheet" href="../../app-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
      <link rel="stylesheet" href="../../app-assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
    
      <!-- Page CSS -->
      <link rel="stylesheet" href="../../app-assets/vendor/css/pages/cards-advance.css" />
      <!-- Helpers -->
      <script src="../../app-assets/vendor/js/helpers.js"></script>
    
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
      <script src="../../app-assets/vendor/js/template-customizer.js"></script>
      <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
      <script src="../../app-assets/js/config.js"></script>
    </head>

    <title>Login Cover - Pages | Vuexy - Bootstrap Admin Template</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../app-assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons -->
    <link rel="stylesheet" href="../../app-assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../../app-assets/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="../../app-assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../app-assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../app-assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../app-assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../app-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../app-assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="../../app-assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="../../app-assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="../../app-assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="../../app-assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="../../app-assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../app-assets/js/config.js"></script>
  </head>
  <body>
    <!-- Content -->

    <div class="authentication-wrapper authentication-cover authentication-bg">
      <div class="authentication-inner row">
        <!-- Register -->
        <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
          <div class="w-px-400 mx-auto">
            <!-- Logo -->
            
            <div class="logo mr-3"><a href="{{ url('/') }}"><img src={{asset('assets/images/app-logo.png') }} alt="icon" style="margin-bottom: 10px;" width="auto" height="35px"></a></div>
            <h3 class="mb-1 fw-bold" >Selamat Datang Di Talentern!👋</h3>
            <p class="mb-4" style="font-size: 10pt">Silahkan melakukan pendaftaran dengan mengisi data diri berikut</p>
           
            <!-- /Logo -->
            @yield('conten')
            
            <p class="text-center">
              <span>Already have an account?</span>
              <a href="{{ url('/login') }}">
                <span>Sign in instead</span>
              </a>
            </p>
          </div>
        </div>
        <!-- /Register -->
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 p-0">
          <div class="auth-cover-bg d-flex justify-content-center align-items-center" style="margin-right: 30px">
            <img
              alt="auth-login-cover"
              class="img-fluid my-5 auth-illustration"
              style="background-image " src="{{ asset('assets/images/background/register.svg') }}" alt="Login" />
          </div>
        </div>
        <!-- /Left Text -->
      </div>
    </div>
    <div class="modal fade" id="registrasi-mitra" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-center">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  
                  </button>
              </div>
              <div class="modal-body text-center" style="display:block;">
                  Konfirmasi Persetujuan Data Mitra
              </div>
              <div class="modal-footer" style="display: flex; justify-content:center;">
                  <a class="btn btn-primary text-white" id="approve-confirm-button">Iya, Yakin</a>
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
              </div>
          </div>
      </div>
    </div>

    <script>
    function redirectToPage() {
      var selectedRole = document.getElementById("roleregister").value;

      if (selectedRole === "user") {
        window.location.href = "/mahasiswa/register";
        } else if (selectedRole === "mitra") {
          return Mitra;
      }
      
    }
    </script>

</body>
</html>

