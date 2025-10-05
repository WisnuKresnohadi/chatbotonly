<!DOCTYPE html>
<html lang="en">
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>500 - Internal Server Error</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset("bootstrap/dist/css/bootstrap.min.css") }}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{ asset("css/animate.css") }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset("css/style.css") }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset("css/colors/default-dark.css") }}" id="theme"  rel="stylesheet">
    <link href="{{ asset("css/custom.css") }}"  rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>
<body>
<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="error-page">
    <div class="error-box">
        <div class="error-body text-center">
            <h1>500</h1>
            <h3 class="text-uppercase">Internal Server Error.</h3>
            <p class="text-muted m-t-30 mb-4">Please try after some time</p>
            <a href="{{ url('/') }}" class="btn btn-primary btn-rounded waves-effect waves-light m-b-40">Back to home</a> </div>
        <footer class="footer text-center">2017</footer>
    </div>
</section>
<!-- jQuery -->
<script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ asset("bootstrap/dist/js/bootstrap.min.js") }}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ asset("js/custom.min.js") }}"></script>

</body>
</html>