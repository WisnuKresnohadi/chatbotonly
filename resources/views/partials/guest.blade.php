<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="{{ url('app-assets') }}" data-template="vertical-menu-template">

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
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

      <title>Talentern</title>

      <meta name="description" content="" />

      <!-- Favicon -->
      {{-- <link rel="icon" type="image/x-icon" href="{{ url('app-assets/img/favicon/favicon.ico') }}" /> --}}
      <link rel="icon" type="image/x-icon" href="{{ url('app-assets/img/favicon/icon.svg') }}" />

      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

      <!-- Icons -->
      <link rel="stylesheet" href="{{ url('app-assets/vendor/fonts/fontawesome.css') }}" />
      <link rel="stylesheet" href="{{ url('app-assets/vendor/fonts/tabler-icons.css') }}" />
      <link rel="stylesheet" href="{{ url('app-assets/vendor/fonts/flag-icons.css') }}" />

      <!-- Core CSS -->
      <link rel="stylesheet" href="{{ url('app-assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
      <link rel="stylesheet" href="{{ url('app-assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
      <link rel="stylesheet" href="{{ url('app-assets/css/demo.css') }}" />

      <!-- Vendors CSS -->
      <link rel="stylesheet" href="{{ url('app-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
      <link rel="stylesheet" href="{{ url('app-assets/vendor/libs/node-waves/node-waves.css') }}" />
      <link rel="stylesheet" href="{{ url('app-assets/vendor/libs/typeahead-js/typeahead.css') }}" />
      <!-- Vendor -->
      {{-- <link rel="stylesheet" href="{{ url('app-assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" /> --}}
      <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/select2/select2.css') }}" />
      {{-- <link rel="stylesheet" href="{{ asset('app-assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" /> --}}

      <!-- Page CSS -->
      {{-- <link rel="stylesheet" href="{{ url('app-assets/vendor/css/pages/cards-advance.css') }}" /> --}}

      <!-- Page CSS -->
      <link rel="stylesheet" href="{{ url('app-assets/vendor/css/pages/page-auth.css') }}" />

      <!-- Helpers -->
      <script src="{{ url('app-assets/vendor/js/helpers.js') }}"></script>

      <script src="{{ url('app-assets/vendor/js/template-customizer.js') }}"></script>
      <script src="{{ url('app-assets/js/config.js') }}"></script>

      <link rel="stylesheet" href="{{ url('app-assets/css/style.css') }}" />

      @yield('page_style')      
  </head>

<body>
    <!-- Content -->

    @yield('content')

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js app-assets/vendor/js/core.js -->
    <script src="{{ url('app-assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ url('app-assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ url('app-assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ url('app-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ url('app-assets/vendor/libs/node-waves/node-waves.js') }}"></script>

    <script src="{{ url('app-assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ url('app-assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ url('app-assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

    <script src="{{ url('app-assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ url('app-assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ url('app-assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ url('app-assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('app-assets/vendor/libs/block-ui/block-ui.js') }}"></script>
    <script src="{{ asset('app-assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ url('app-assets/js/main.js') }}"></script>

    <!-- Page JS -->
    {{-- <script src="{{ url('app-assets/js/pages-auth.js') }}"></script> --}}
    @yield('page_script')
</body>

</html>
