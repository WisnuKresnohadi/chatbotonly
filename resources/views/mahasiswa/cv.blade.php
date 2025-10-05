<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ATS CV</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@100;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <style>
        .container {
            /* width: 45em; */
            width: 50em;
            padding: 3rem 5rem;
            margin: auto;
            border: 1px solid #D3D6DB;
        }

        .print-button {
            background-color: #4EA971;
            color: white;
            padding: 10px 14px;
            width: 50em;
            font-weight: 500;
            font-size: medium;
            border-radius: 5px;
            border: white;
        }

        /* Print Styles */
        @media print {
            body {
                width: 210mm;
                A4 width margin: 0 auto;
            }

            .container {
                /* Reduced width to create margins */
                /* width: 180mm; */
                width: 100%;
                /* margin: 10mm auto;  Centers the content with margins */
                margin: 1rem 0;
                padding: 0rem;
                border: none;
                page-break-before: always;
                page-break-after: always;
                page-break-inside: avoid;
            }

            .section {
                page-break-inside: avoid;
            }

            .print-button {
                display: none;
            }

            /* Set specific page margins */
            @page {
                size: A4;
                /* Standard Word-like margins */
                /* margin: 10mm; */
            }
        }
    </style>
</head>

<body style="overflow-x: hidden;">
    {{-- <div style="position: fixed; bottom: 20px; justify-content: center;"> --}}
        {{-- <div style="position: fixed; bottom: 0; left: 0; right: 0; padding: 1rem; margin: auto; text-align: center; background: linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0)); backdrop-filter: blur(1px);">
        <button class="print-button" onclick="window.print();">Print CV</button>
        </div> --}}

        <div style="position: fixed; bottom: 0; left: 0; right: 0; padding: 1rem; margin: auto; text-align: center; background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
        <button class="print-button" onclick="window.print();">
            Print CV
        </button>
        </div>

    <div class="container" style="color: #333;">
        <!-- CV Header -->
        <div class="section" style="font-family:'Public Sans';">

            <!-- Photo, Name  -->
            <div style="display: flex; align-items: center; gap: 20px; margin: 0 auto;">
                <!-- <img src="{{ asset('storage/' . $dataInfoTambahan->profile_picture) }}" alt="Photo" style="width: 110px; height: 110px; border-radius: 50%; background-color: black;"> -->
                <img src="{{ asset('storage/' . $dataInfoTambahan->profile_picture) }}" alt="Photo" style="width: 110px; height: 110px; border-radius: 10px; background-color: black;">
                <div style="flex: 1;">
                    <h1 style="font-size: 2.5em; margin: 10px 0; color: #333;">{{ $dataInfoTambahan->namamhs ?? '-' }}
                    </h1>
                    <p style="font-size: 1.2em; margin: 10px 0; color: #555;">{{ $dataInfoTambahan->headliner ?? '-' }}
                    </p>
                </div>
            </div>

            <!-- Details, Email, Phone, birthday,-->
            <div style="display: flex; justify-content: space-between; gap: 25px; margin-top: 10px;">
                <div style="display: flex; flex-direction: column;">
                    <div>
                        <h3 style="margin: 10px 0; font-weight: 400; text-wrap: nowrap; display: flex; align-items: center; gap: 8px;"><span class="ti ti-mail" style="font-size: 1.4rem; color: #6f6b7d;"></span>{{ $dataInfoTambahan->emailmhs ?? '-' }} </h3>
                    </div>
                    <div>
                        <h3 style="margin: 10px 0; font-weight: 400; display: flex; align-items: center; gap: 8px;"><span  class="ti ti-map-pin" style="font-size: 1.4rem; color: #6f6b7d;"></span>{{ $dataInfoTambahan->alamatmhs ?? '-' }}</h3>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column;">
                    <div>
                        <h3 style="margin: 10px 0; font-weight: 400; text-wrap: nowrap; display: flex; align-items: center; gap: 8px;"><span class="ti ti-calendar" style="font-size: 1.4rem; color: #6f6b7d;"></span>{{ $dataInfoTambahan->tgl_lahir ?? '-' }}</h3>
                    </div>
                    <div>
                        <h3 style="margin: 10px 0; font-weight: 400; text-wrap: nowrap; display: flex; align-items: center; gap: 8px;"><span class="ti ti-phone" style="font-size: 1.4rem; color: #6f6b7d;"></span>{{ $dataInfoTambahan->nohpmhs ?? '-' }}</h3>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column;">
                    <div>
                        <h3 style="margin: 10px 0; font-weight: 400; text-wrap: nowrap; display: flex; align-items: center; gap: 8px;"><span class="ti ti-user" style="font-size: 1.4rem; color: #6f6b7d;"></span>{{ $dataInfoTambahan->gender ?? '-' }}</h3>
                    </div>
                </div>
            </div>

        </div>

        <!-- CV Body -->
        <div style="margin-top: 5px; display: flex; flex-direction: row-reverse; justify-content: start; gap: 20px; font-family:'Public Sans';">
            <!-- Right Side -->
            <div style="flex: 1; display: flex; flex-direction: column; gap: 1.5rem;">
                <!-- Keahlian -->
                <div class="section">
                    <h3 style="font-weight: 400; margin: 0; color: #73808D;  letter-spacing: 2px; text-transform: uppercase">Keahlian</h3>
                    <hr style="color: #D3D6DB; margin: 5px 0;">
                    @foreach (json_decode($dataInfoTambahan->skills ?? '[]') as $skill)
                    <h3 style="font-weight: 400; margin: 5px 0;">{{ $skill ?? '-' }}</h3>
                    @endforeach
                </div>
                <!-- Pendidikan -->
                <div class="section">
                    <h3 style="font-weight: 400; margin: 0; color: #73808D;  letter-spacing: 2px; text-transform: uppercase">Pendidikan</h3>
                    <hr style="color: #D3D6DB; margin: 5px 0;">
                    @foreach($pendidikan as $pen)
                    <div style="padding-top: 8px;">
                        <h3 style="font-weight: 700; margin: 6px 0;">{{$pen->name_intitutions ?? '-'}}</h3>
                        <!-- <h3 style="font-weight: 400; margin: 5px 0;">{{$pen->tingkat ?? '-'}}</h3> -->
                        <h3 style="font-weight: 400; color: #4B465C; margin: 5px 0;">Nilai Akhir {{$pen->nilai ?? '-'}}</h3>
                        <h4 style="font-weight: 400; color: #4B465C; margin: 5px 0;">{{\Carbon\Carbon::parse($pen->startdate)->format('F Y') ?? '-'}} - {{\Carbon\Carbon::parse($pen->enddate)->format('F Y') ?? '-'}}</h4>
                    </div>
                    @endforeach
                </div>

                <!-- Informasi Tambahan -->
                <div style="display: flex; flex-direction: column;">
                    <div class="section">
                        <h3 style="font-weight: 400; margin: 0; color: #73808D;  letter-spacing: 2px; text-transform: uppercase;">Informasi Tambahan</h3>
                        <hr style="color: #D3D6DB; margin: 5px 0;">
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 1.2rem;">
                        <div>
                            <h3 style="font-weight: 600; margin: 6px 0;">Media Sosial</h3>
                            @foreach(json_decode($dataInfoTambahan->sosmedmhs ?? '[]') as $sosmed)
                            <h3 style="font-weight: 400; color: #4B465C; margin: 5px 0;">● &nbsp;{{ $sosmed->namaSosmed ?? '-' }}: {{ $sosmed->urlSosmed ?? '-' }}</h3>
                            @endforeach
                        </div>
                        <div>
                            <h3 style="font-weight: 600; margin: 6px 0;">Bahasa</h3>
                            @foreach(json_decode($dataInfoTambahan->bahasa ?? '[]') as $bahasa)
                            <h3 style="font-weight: 400; color: #4B465C; margin: 5px 0;">● &nbsp;Bahasa {{ $bahasa ?? '-' }}</h3>
                            @endforeach
                        </div>
                        <div>
                            <h3 style="font-weight: 600; margin: 6px 0;">Lokasi kerja yang diharapkan:</h3>
                            <h3 style="font-weight: 400; color: #4B465C; margin: 5px 0;">● &nbsp;{{$dataInfoTambahan->lokasi_yg_diharapkan ?? '-'}}</h3>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Left Side -->
            <div style="flex: 2; display: flex; flex-direction: column; gap: 1rem;">
                <!-- Deskripsi Diri -->
                <div class="section">
                    <h3 style="font-weight: 400; margin: 0; color: #73808D;  letter-spacing: 2px; text-transform: uppercase;">Deskripsi Diri</h3>
                    <hr style="color: #D3D6DB; margin: 5px 0;">
                    <h3 style="font-weight: 400; margin: 0; text-indent: 1.5rem; text-align: justify; line-height: 1.4; word-break: break-word; hyphens: auto;">{{$dataInfoTambahan->deskripsi_diri ?? '-'}}</h3>
                </div>

                <!-- Pengalaman -->
                <div style="display: flex; flex-direction: column;">
                    <div class="section">
                        <h3 style="font-weight: 400; margin: 0; color: #73808D;  letter-spacing: 2px; text-transform: uppercase;">Pengalaman</h3>
                        <hr style="color: #D3D6DB; margin: 5px 0;">
                    </div>
                    @foreach($experience as $exp)
                    <div class="section" style="margin-bottom: 1rem;">
                        <h3 style="font-weight: 700; margin: 6px 0;">{{$exp->name_intitutions ?? '-'}}</h3>
                        <h3 style="font-weight: 400; margin: 6px 0;">{{$exp->posisi ?? '-'}}</h3>
                        <h3 style="font-weight: 400; margin: 6px 0; color: #4B465C;">{{\Carbon\Carbon::parse($exp->startdate)->format('F Y') ?? '-'}} - {{\Carbon\Carbon::parse($exp->enddate)->format('F Y') ?? '-'}}</h3>
                        <h3 style="font-weight: 400; margin: 0; text-align: justify; line-height: 1.4; word-break: break-word; hyphens: auto;">{{$exp->deskripsi ?? '-'}}</h3>
                    </div>
                    @endforeach
                </div>

                <!-- Dokumen Pendukung -->
                <div style="display: flex; flex-direction: column;">
                    <div class="section">
                        <h3 style="font-weight: 400; margin: 0; color: #73808D;  letter-spacing: 2px; text-transform: uppercase;">Dokumen Pendukung</h3>
                        <hr style="color: #D3D6DB; margin: 5px 0;">
                    </div>
                    @foreach($dokumenPendukung as $doc)
                    <div class="section" style="margin-bottom: 1rem;">
                        <h3 style="font-weight: 700; margin: 6px 0;">{{ $doc->nama_sertif ?? '-' }}</h3>
                        <h3 style="font-weight: 400; margin: 6px 0;">{{ $doc->penerbit ?? '-' }}</h3>
                        <h3 style="font-weight: 400; margin: 6px 0; color: #4B465C;">{{\Carbon\Carbon::parse($doc->startdate)->format('F Y') ?? '-'}} - {{\Carbon\Carbon::parse($doc->enddate)->format('F Y') ?? '-'}}</h3>
                        <h3 style="font-weight: 400; margin: 0; text-align: justify; line-height: 1.4; word-break: break-word; hyphens: auto;">{{ $doc->deskripsi ?? '-' }}</h3>
                        <a href="{{ url('storage/' . $doc->file_sertif) ?? '#' }}" target="_blank" rel="noopener noreferrer">
                            {{ $doc->nama_sertif ?? '-' }}.pdf
                        </a>
                    </div>

                    @endforeach
                </div>
            </div>

        </div>


    </div>

</body>

</html>
