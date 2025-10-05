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
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <title>Print Logbook</title>
    {{-- <style>
        @page { 
            size: A5 
            margin: 10mm;
            counter-reset: page;
        }
        @media print {

            /* tfoot { 
                counter-increment: page;
            } */
            /* @page {
                counter-increment: page;
                content: counter(page);
            } */

            tfoot::after {
                /* Increment "my-sec-counter" by 1 */

                /* content: counter(page); */
            }
            thead {
                display: table-header-group;
            }
            tfoot {
                display: table-footer-group;
            }

            div {
                break-inside: avoid;
            }

            #print_button{
                display: none;
            }

        }
        .sheet {
            overflow: visible;
            width: auto !important;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            box-shadow: 0 .5mm 2mm rgba(0,0,0,.3) !important;
            margin: 5mm auto !important;
            color: #1D345D;
            line-height: 5mm;
            -webkit-print-color-adjust: exact !important;
                /* counter-reset: my-sec-counter; */
        }
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 100%;
            margin-bottom: 0.25rem;
            background-color: transparent;
        }
    </style> --}}
    <style>
        *{
            color: black;
        }
        @page {
            size: A4 portrait;
            margin: 10mm;
            counter-reset: page;
        }

        @media print {

            /* tfoot { 
                counter-increment: page;
            } */
            /* @page {
                counter-increment: page;
                content: counter(page);
            } */
            .sheet {
                overflow: visible;
                height: auto !important;
                background-color: white;
            }

            body {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 10pt;
                color: #1D345D;
                line-height: 5mm;
                -webkit-print-color-adjust: exact !important;
                /* counter-reset: my-sec-counter; */
            }

            tfoot::after {
                /* Increment "my-sec-counter" by 1 */

                /* content: counter(page); */
            }

            div {
                break-inside: avoid;
            }
            
            /* Hide the second TR on any subsequent pages when it is repeated */
            thead {
                break-after: avoid; /* Prevents splitting thead across pages */
            }   

            thead.{
            display: table-header-group;
            }
            tfoot {
                display: table-footer-group;
            }
            
            .table-header-cell:not(:first-of-type) {
                display: none;
            }
            
        }

        .sheet {
            overflow: visible;
            height: auto !important;
            background-color: white;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #1D345D;
            line-height: 5mm;
            -webkit-print-color-adjust: exact !important;
            /* counter-reset: my-sec-counter; */
        }

        h1 {
            font-family: Roboto;
            font-size: 20pt;
        }

        h2 {
            font-family: Roboto;
            font-size: 14pt;
        }

        h3 {
            font-family: Nunito;
            font-size: 12pt;
            line-height: 5mm;

        }

        table {
            width: 50rem;
            max-width: 100%;
            margin-bottom: 0.25rem;
            background-color: transparent;
        }

        .table th {
            padding: 10px 10px;
            font-weight: bold;
        }

        .table td {
            padding: 8px 8px;
            border: 1px solid #000000;
        }

        td {
            padding: 5px 5px;
            border: 1px solid #000000;
        }

        thead th {
            padding: 2px 2px;
        }


        thead.table-header{
            display: table-header-group;
        }
        tfoot {
            display: table-footer-group;
        }
        /*
        1. Use a more-intuitive box-sizing model.
        */
        *, *::before, *::after {
        box-sizing: border-box;
        }

        /*
        2. Remove default margin
        */
        * {
        margin: 0;
        }

        /*
        Typographic tweaks!
        3. Add accessible line-height
        4. Improve text rendering
        */
        body {
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
        }

        /*
        5. Improve media defaults
        */
        img, picture, video, canvas, svg {
        display: block;
        max-width: 100%;
        }

        /*
        6. Remove built-in form typography styles
        */
        input, button, textarea, select {
        font: inherit;
        }

        /*
        7. Avoid text overflows
        */
        p, h1, h2, h3, h4, h5, h6 {
        overflow-wrap: break-word;
        }

        /*
        8. Create a root stacking context
        */
        #root, #__next {
        isolation: isolate;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }
    </style>   
</head>
<body class="A5 landscape" style="display: flex; flex-direction: column; align-items: center;">
    <section id="logbook_print" class="sheet" onload="printLogbook()" style="display: flex; flex-direction: column; background-color: white; padding: 2rem;">
            <table style="">
                <thead class="table-header">
                    <tr>
                            <th colspan="4" class="table-header-cell">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 2rem; width: 100%; margin-left:1rem; text-align: center;">
                                    <img src="{{url('app-assets/img/telu-logo.png')}}" alt="" style="width: 5rem; height: 5rem;"/>
                                    <div style="display: flex; flex-direction: column; justify-content: center; text-align: center; line-height: 2;">
                                        <h1 style="margin: 0;">Universitas Telkom</h1>
                                        <p style="margin: 0;">Jl. Telekomunikasi No. 1 Ters. Buah Batu Bandung</p>
                                        <h3 style="margin: 0;">PROSEDUR PELAKSANAAN MAGANG</h3>
                                    </div>
                                </div>
                            </th>
                    </tr>
                    <tr>
                        <th colspan="4" class="table-header-cell" style="text-align: center;">
                            <h3 style="text-decoration: underline; margin-top: 2rem; margin-bottom: 1rem; text-align: center;">LEMBAR KEGIATAN HARIAN MAGANG</h3>
                            <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 1rem;">
                                <div style="display: flex; flex-direction: column; align-items: flex-start; line-height: 2;">
                                    <h4 style="width: 100%; display: flex; flex-direction: row; justify-content: start;">
                                        <span style="width: 14rem; margin-left: 0%; text-align: start;">NAMA/NIM</span>  {{": ".$data->namamhs ?? "-"}} / {{$data->nim ?? "-"}}
                                    </h4>
                                    <h4 style="width: 100%; display: flex; flex-direction: row; justify-content: start;">
                                        <span style="width: 14rem; margin-left: 0%; text-align: start;">NAMA PERUSAHAAN</span>  {{": ".$data->namaindustri ?? "-"}}
                                    </h4>
                                    <h4 style="width: 100%; display: flex; flex-direction: row; justify-content: start;">
                                        <span style="width: 14rem; margin-left: 0%; text-align: start;">NAMA PEMBIMBING LAPANGAN</span>  {{": ".$data->namapeg ?? "-"}}
                                    </h4>
                                    <h4 style="width: 100%; display: flex; flex-direction: row; justify-content: start;">
                                        <span style="width: 14rem; margin-left: 0%; text-align: start;">NAMA PEMBIMBING AKADEMIK</span>  {{": ".$data->namadosen ?? "-"}}
                                    </h4>
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th style="border: 2px solid black; background-color: #d9d9d9; color: black;">Tanggal</th>
                        <th style="border: 2px solid black; background-color: #d9d9d9; color: black;">Activity</th>
                    </tr>
                </thead>
                {{-- @dd($data) --}}
                <tbody>
                    {{-- @dd($weeklyActivities) --}}
                    @foreach($weeklyActivities as $value)
                    {{-- @dd($weeklyActivities) --}}
                        <tr>
                            <td style="text-align: center; width: 15rem;">
                                Minggu ke {{ $value->week }}
                                <h5 class="mb-1">{{ Carbon\Carbon::parse($value->start_date)->format('d') }}&ensp;-&ensp;{{ Carbon\Carbon::parse($value->end_date)->format('d F Y') }}</h5>
                            </td>
                            <td >
                                <ul>
                                    @foreach ($value->logbookDay as $day)
                                        <li>
                                            {{ Carbon\Carbon::parse($day->date)->format('d F Y') }}
                                            :
                                            <span style='{{ $day->activity == 'Libur' ? 'font-weight: bold;' : '' }}'>
                                                {{$day->activity}}
                                            </span>
                                        </li>
                                     @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table>
            <div style="display: flex; flex-direction: column; width: 15rem; align-items: center; margin-left: auto; margin-top: 10rem;">
                <span>Bandung
                    ,{{$currentDate}}</span>
                    <span>Diketahui</span>
                    <span>
                        {{$data->namapeg ?? "-"}}
                    </span>

                <img src="#" alt="TTD PEMBIMBING LAPANGAN" width="100" height="100" style="margin: 1rem;">
                <span>NIK/NIP............................................</span>
            </div>
    </section>
    <button onclick="printLogbook()" id="print_button" style="background:#4EA971; border:none; border-radius: 10px; width: 10rem; height: 3rem; margin-bottom: 3rem; color:white; font-weight: 700;">Export PDF</button>
    <script>
        function printLogbook() {
            var print = document.getElementById('logbook_print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = print;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
</body>
</html>