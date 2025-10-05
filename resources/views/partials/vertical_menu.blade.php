<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('app-assets') }}" data-template="vertical-menu-template">

<head>
    {{-- Maze script --}}
    <script>
        (function (m, a, z, e) {
          var s, t;
          try {
            t = m.sessionStorage.getItem('maze-us');
          } catch (err) {}
        
          if (!t) {
            t = new Date().getTime();
            try {
              m.sessionStorage.setItem('maze-us', t);
            } catch (err) {}
          }
        
          s = a.createElement('script');
          s.src = z + '?apiKey=' + e;
          s.async = true;
          a.getElementsByTagName('head')[0].appendChild(s);
          m.mazeUniversalSnippetApiKey = e;
        })(window, document, 'https://snippet.maze.co/maze-universal-loader.js', '3c949e36-badd-4d6e-929c-fe162cd13576');
        </script>
    <meta charset="utf-8" />
    @yield('meta_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Talentern</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ url('app-assets/img/favicon/icon.svg') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/fonts/flag-icons.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">


    <!-- Core CSS -->
    <!-- <link rel="stylesheet" href="{{ asset('app-assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" /> -->
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('app-assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/datatables-select-bs5/select.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
    <link rel="stylesheet" href="{{url('app-assets/vendor/libs/flatpickr/flatpickr.css')}}" />
    <link rel="stylesheet" href="{{ asset('app-assets/css/yearpicker.css') }}" />
    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('/app-assets/vendor/css/pages/cards-advance.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('app-assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('app-assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('app-assets/js/config.js') }}"></script>

    <link rel="stylesheet" href="{{ url('app-assets/css/style.css') }}" />
    @yield('page_style')    
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('partials.sidemenu')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('partials.header')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    
                    <!-- Modal Delete-->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-body text-center" style="display:block;">
                                    Apakah Anda Ingin Keluar Dari Akun Ini?
                                </div>
                                <div class="modal-footer" style="display: flex; justify-content:center;">
                                    <a href="{{ route('logout') }}"><button type="button" class="btn btn-success" data-dismiss="modal">Iya</button></a>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl ps-4">
                            <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                                <div>
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    Crafted with PASSION by <a href="https://technoinfinity.co.id/" target="_blank" class="fw-semibold"
                                        style="color:#4EA971;">Techno Infinity</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('app-assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('app-assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/node-waves/node-waves.js') }}"></script>

<script src="{{ asset('app-assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

<script src="{{ asset('app-assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('app-assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/swiper/swiper.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/block-ui/block-ui.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
<script src="{{ url('app-assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
<script src="{{ url('app-assets/js/yearpicker.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('app-assets/js/main.js') }}"></script>
<script src="{{ url('js/content.js') }}"></script>

<script>
    $(".flatpickr-date").flatpickr({
        altInput: true,
        altFormat: 'j F Y',
        dateFormat: 'Y-m-d'
    });

    $(".yearpicker").yearpicker();

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
        return rupiah;
    }
</script>

@yield('page_script')
</body>

</html>
