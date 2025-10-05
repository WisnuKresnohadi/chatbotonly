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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <link rel="stylesheet" href="{{ url('app-assets/vendor/css/rtl/core.css') }}"class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ url('app-assets/vendor/css/rtl/theme-default.css') }}"class="template-customizer-theme-css" />   
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $subject }}</h1>
        </div>
        <div class="card">
            <div class="card-body">
                {!! $content !!}
            </div>
        </div>
        <div class="footer">
            <p>© PT Teknologi Nirmala Olah Daya Informasi (Techno Infinity).</p>
        </div>
    </div>
    <script src="{{ url('app-assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ url('app-assets/vendor/js/bootstrap.js') }}"></script>
</body>
</html>
