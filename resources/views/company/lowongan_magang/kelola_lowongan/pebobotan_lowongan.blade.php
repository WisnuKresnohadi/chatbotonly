@extends('partials.vertical_menu')

@section('page_style')
    <style>
        .hr-style {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 2px dashed rgba(0, 0, 0, 0.1);
        }
        ul{
            list-style-type: circle !important;
        }

        .noUi-horizontal .noUi-handle {
            width: 1.2rem !important;
            height: 1.2rem !important;
        }

        .noUi-horizontal{
            height: 0.7rem !important;
            border-radius: 100%;
        }

        .light-style .noUi-tooltip{
            padding-left: 0.5rem;
            padding-right: 0.5rem;
            color: rgba(255, 255, 255, 1) !important;
        }

        .apexcharts-legend{
            margin-top: 15px;
        }

        #bar-Chart #pie-Chart {
            /* max-width: 650px;
            min-width: 800px;
            margin: 35px auto; */
        }
    </style>
    <link rel="stylesheet" href="{{ url('app-assets/vendor/libs/nouislider/nouislider.css') }}" />
@endsection
@section('content')

{{-- tombol kembali --}}
<a href="{{ url('lowongan-magang/informasi-lowongan', ) }}" class="mt-4 mb-3 btn btn-outline-primary">
    <i class="ti ti-arrow-left me-2 text-primary"></i>
    Kembali
</a>
{{-- multipurpose input :) --}}
<input type="hidden" id="change_status">

<div class="d-flex justify-content-between">
    <h4 class="fw-bold"><span class="text-muted fw-light">Informasi Lowongan / </span> Pengaturan Kriteria Seleksi / {{$getInternPosition->namabidangpekerjaan ?? ''}}</h4>
</div>



<div class="gap-4 p-4 card">

    <div class="flex-row gap-3 px-3 mx-1 rounded d-flex align-items-center mb-n2"  style="background-color: rgba(255, 159, 67, 0.08); color: rgba(255, 159, 67, 1); height: 4rem;">
        <i class="ti ti-info-circle fs-3"></i>
        <span class="fs-5">
            Proses seleksi dilakukan oleh sistem secara semi-otomatis dengan melibatkan beberapa kriteria, berikan preferensi bobot dari setiap kriteria menurut perusahaan Anda.
        </span>
    </div>

    {{-- Container Description --}}
    <div class="mx-1 mt-2 border rounded accordion" id="accordionFAHP">
        <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button fs-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Penjelasan Pembobotan
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionFAHP">
            {{-- Accordion Body --}}
            <div class="accordion-body fs-5">
                <span>Talentern dilengkapi dengan fitur rekomendasi kandidat otomatis berbasis sistem. Untuk dapat menggunakan fitur rekomendasi otomatis tersebut diperlukan untuk melakukan beberapa rangkaian aktivitas mulai dari memberikan prioritas pembobotan terhadap kriteria, hingga memberikan penilaian terhadap kandidat dan membandingkannya dengan kriteria yang sudah ditetapkan oleh perusahaan. </span>
                <div class="gap-1 my-3 d-flex flex-column">
                    <span class="flex-row gap-2 d-flex align-items-start">
                        <span>1.</span>Range pembobotan setiap kriteria tersedia dari range 1-9
                    </span>
                    <span class="flex-row gap-1 d-flex align-items-start">
                        <span>2.</span>Semakin kecil angka pembobotan, semakin rendah prioritas kriteria dibandingkan kriteria lainnya.
                    </span>
                    <span class="flex-row gap-1 d-flex align-items-start">
                        <span>3.</span>Semakin besar angka pembobotan, semakin tinggi prioritas kriteria, menjadikannya yang utama dibandingkan kriteria lainnya.
                    </span>
                    <span class="flex-row gap-1 d-flex align-items-start">
                        <span>4.</span>Dalam pembobotan kriteria terdapat Consistency Ratio (CR), yang mengukur seberapa konsisten pembobotan antar kriteria, semakin kecil nilainya, semakin baik.
                    </span>
                    <span class="flex-row gap-1 d-flex align-items-start">
                        <span>5.</span>Nilai pembobotan antar kriteria tidak dapat terlalu timpang, karena dapat mengurangi akurasi penilaian kandidat.
                    </span>
                </div>
                <hr class="hr-style">
                <div>
                    <h5>Kriteria yang digunakan dalam proses seleksi</h5>
                    <ul class="flex-row gap-5 d-flex align-items-start">
                        <div>
                            <li>
                                <span class="flex-row gap-1 d-flex align-items-center">
                                    <span>Akademik</span> <i class="ti ti-info-circle fs-5" data-bs-toggle="tooltip" data-bs-placement="right" title="Hasil Akademik didapat dari nilai transkip mahasiswa untuk lowongan yang sesuai"></i>
                                </span>
                            </li>
                            <li>
                                Keterampilan/Sertifikasi
                            </li>
                            <li>
                                Prestasi/Kejuaraan
                            </li>
                        </div>
                        <div>
                            <li>
                                Pengalaman Praktis/Project
                            </li>
                            <li>
                                Kriteria Tambahan
                            </li>
                        </div>
                    </ul>
                </div>
                <hr class="hr-style">
                <h5>Contoh Pembobotan</h5>
                <div class="mb-4">
                    <div class="pb-5 card-body d-flex">
                        <h5 style="white-space: nowrap; margin-right: 1rem; margin-top: 0.5rem;">Nilai Akademik</h5>
                        <div class="my-3 w-100 noUi-target noUi-ltr noUi-horizontal noUi-txt-dir-ltr" id="slider-test"></div>
                    </div>
                </div>
            </div>
            {{-- Accordion Body : END --}}
        </div>
        </div>
    </div>
    {{-- Container Description : END --}}

    {{-- Chart & Slider Criteria --}}
    <div class="mx-1 mb-2 border rounded d-flex justify-content-between">

        {{-- Chart --}}
        <div class="mt-4 ms-4 w-100">
            <h4 class="fs-4 ms-2">Pembobotan Prioritas Kriteria</h4>
            <div class="gap-3 p-4 rounded shadow-sm d-flex flex-column mt-n2 w-100" style="max-height: 95%;">

                {{-- Cr Description --}}
                <div class="p-4 border rounded">

                    {{-- Hidden ketika cr tidak lebih dari 0,1 --}}
                    <div id="cr-info" class="gap-2 px-2 mb-3 rounded d-flex align-items-center" style="background-color: rgba(255, 159, 67, 0.08); color: rgba(255, 159, 67, 1); height: 3rem;">
                        <i class="ti ti-info-circle fs-3"></i><span class="mt-1 fs-5 fw-semibold">Consistent Ratio perlu disesuaikan</span>
                    </div>

                    <div class="gap-3 d-flex">
                        <div class="w-100">
                            <h5 class="fs-5 fw-semibold mb-n1">Consistent Ratio yang dapat diterima sistem</h5>
                            <span class="fs-5">< 0.1</span>
                        </div>
                        <div class="w-100">
                            <h5 class="fs-5 fw-semibold mb-n1">Consistent Ratio saat ini</h5>
                            <input class="border-0 fs-5" id="preview-cr" type="text" disabled></span>
                        </div>
                        {{-- <input class="border-0 fs-2 " id="value-cr" type="text" disabled> --}}
                    </div>
                </div>
                {{-- Cr Description : END --}}

                {{-- Chart Tab --}}
                <div class="p-3 border rounded">
                    <div class="nav nav-pills d-flex justify-content-center" id="pills-tab" role="tablist">
                        <div>
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                                <i class="ti ti-chart-pie fs-3 me-2"></i>
                                Pie Chart
                            </button>
                        </div>
                        <div>
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
                                <i class="ti ti-chart-bar fs-3 me-2"></i>
                                Bar Chart
                            </button>
                        </div>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="rounded tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                            <div id="pie-Chart"></div>

                        </div>
                        <div class="rounded tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                            <div id="bar-Chart"></div>

                        </div>
                    </div>
                </div>
                {{-- Chart Tab : END --}}
            </div>
        </div>
        {{-- Chart --}}

        {{-- Slider Criteria --}}
        <div id="genCriteriaSlider" class="mx-5" style="width: 100%">
            <form class="default-form" action="{{ route('kelola_lowongan.pengaturan_kriteria.store', $id) }}" method="POST">
                @csrf
                <input name="value_cr" id="value-cr" type="text" readonly hidden></span>
                <table>
                    @foreach ($kriteria as $namaKriteria => $bobot)
                    <tr class="border border-start-0 border-end-0">
                        <td>
                            <h5 class="my-5 me-5 fs-5 fw-semibold">{{ $namaKriteria }}</h5>
                        </td>
                        <td class="w-100">
                            <div class="my-3 slider-wrapper w-100">
                                <input class="slider-pembobotan" type="hidden" id="{{ $namaKriteria }}" value="{{ $bobot }}" name="{{ $namaKriteria }}" readonly>
                                <div class="my-3 noUi-target noUi-ltr noUi-horizontal noUi-txt-dir-ltr" id="slider-{{ $loop->index }}"></div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
        </div>
        {{-- Slider Criteria : END --}}

    </div>
                <div id="buttons" class="flex-row-reverse d-flex w-100">
                    <button class="px-5 btn btn-primary mt-n2 fs-5">
                        Simpan
                    </button>
                </div>
            </form>
    {{-- Chart & Slider Criteria : END--}}
</div>

@endsection
@section('page_script')
    <script src="{{ asset('app-assets/vendor/libs/nouislider/nouislider.js') }}"></script>

    {{-- Dummy Slider --}}
    <script>
        // call create slider function
        createSlider('slider-test', 'input-test', '#FF9F43', 6);

        function createSlider(sliderId, inputId, color, currentValue) {
            var sliderPips = document.getElementById(sliderId);
            noUiSlider.create(
                sliderPips, {
                    start: [currentValue],
                    connect: 'lower',
                    behaviour: 'tap-drag',
                    step: 1,
                    tooltips: true,
                    range: {min: 1, max: 9},
                    pips: {
                        mode: 'steps',
                        stepped: true,
                        density: 5
                    },
                }
            );

            // Set custom colors
            sliderPips.querySelector('.noUi-handle').style.background = color;
            sliderPips.querySelector('.noUi-tooltip').style.background = color;
            sliderPips.querySelector('.noUi-connect').style.background = color;
        }
    </script>
    {{-- Dummy Slider --}}

    <script>
        // Colors for the sliders
        const colors = ['#4F5D70', '#EA5455', '#4EA971', '#46BFBD', '#826BF8', '#FF9F40', '#CCCCCC', '#F7464A', '#66D9CA'];
        let chartPie; // Global variable for the pie chart
        let chartBar; // Global variable for the bar chart

        // Create sliders for each criteria
        document.addEventListener("DOMContentLoaded", function () {
            @foreach ($kriteria as $namaKriteria => $bobot)
                createSlider('slider-{{ $loop->index }}', '{{ $namaKriteria }}', colors[{{ $loop->index }} % colors.length], {{ $bobot }});
            @endforeach

            // Initialize pie chart with default values
            updateChart();
        });

        // Create slider function
        function createSlider(sliderId, label, color, currentValue) {
            var sliderPips = document.getElementById(sliderId);
            var hiddenInput = document.getElementById(label); // Get the corresponding hidden input

            noUiSlider.create(
                sliderPips, {
                    start: [currentValue],
                    connect: 'lower',
                    step: 1,
                    tooltips: true,
                    range: { min: 1, max: 9 },
                    pips: {
                        mode: 'steps',
                        stepped: true,
                        density: 5
                    },
                }
            );

            // Set custom colors for slider
            sliderPips.querySelector('.noUi-handle').style.background = color;
            sliderPips.querySelector('.noUi-tooltip').style.background = color;
            sliderPips.querySelector('.noUi-connect').style.background = color;

            // Update hidden input and chart when slider value changes
            sliderPips.noUiSlider.on('update', function (values, handle) {
                hiddenInput.value = values[handle]; // Update hidden input value
                calculateCRDisplay(); // Recalculate CR when slider value changes
            });

            // Call updateChart only on 'set' event (after user releases the slider)
            sliderPips.noUiSlider.on('set', function () {
                updateChart(); // Update chart with the new values
            });
        }

        // Update the chart dynamically based on hidden input values
        function updateChart() {
            let chartLabels = [];
            let chartSeries = [];
            let chartColors = [];

            // Loop through all sliders to get the updated values
            document.querySelectorAll('input[class="slider-pembobotan"]').forEach(function (input, index) {
                chartLabels.push(input.id); // The label is the input's ID (criteria name)
                chartSeries.push(parseFloat(input.value)); // The series is the input's value
                chartColors.push(colors[index % colors.length]); // Assign color from the predefined list
            });

            // Destroy the existing pie chart if it exists
            if (chartPie) {
                chartPie.destroy();
            }

            // Create a new pie chart with updated data
            chartPie = new ApexCharts(document.querySelector("#pie-Chart"), {
                series: chartSeries,
                chart: {
                    type: 'pie',
                },
                labels: chartLabels,
                colors: chartColors,
                dataLabels: {
                    style: {
                        fontSize: '16px',
                    },
                    dropShadow: {
                        enabled: true,
                        top: 1,
                        left: 0,
                        blur: 2,
                        opacity: 40,
                        color: '#3B3B3B' // Shadow color
                    },
                    formatter: function (val) {
                        return val.toFixed(0) + "%";
                    }
                },
                // title: {
                //     text: 'Visualisasi Prioritas Pembobotan Kriteria',
                //     align: 'center',
                //     style: {
                //         fontSize: '18px',
                //         fontWeight: 'bold'
                //     }
                // },
                // subtitle: {
                //     text: 'Total Presentase Kriteria 100%',
                //     align: 'center',
                // },
                legend: {
                    position: 'right',
                    markers: { offsetY: 1 },
                    itemMargin: {
                        // horizontal: 3,
                        vertical: 3,
                        offsetY: -10,
                    },
                    fontSize: '14px',
                    fontWeight: 'bold',
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 340,
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            });

            // Render the pie chart
            chartPie.render();

            // ==========================================================================================
            // Bar Chart
            const totalValue = chartSeries.reduce((sum, val) => sum + val, 0);
            const percentageData = chartSeries.map(val => (val / totalValue) * 100);  // Normalize to percentage

            // Destroy the existing bar chart if it exists
            if (chartBar) {
                chartBar.destroy();
            }

            // Create the new bar chart
            chartBar = new ApexCharts(document.querySelector("#bar-Chart"), {
                series: [{
                    data: percentageData // Data already normalized to percentage
                }],
                chart: {
                    height: 350,
                    type: 'bar',
                    events: {
                        click: function (chart, w, e) {
                            // Optional click event
                        }
                    }
                },
                colors: chartColors, // Use same colors as pie chart
                plotOptions: {
                    bar: {
                        columnWidth: '75%',
                        distributed: true,
                    }
                },
                dataLabels: {
                    enabled: true,
                    offsetY: -5,
                    formatter: function (val) {
                        return val.toFixed(0) + "%";
                    },
                    style: {
                        fontSize: '16px',
                        colors: ['#E8E7E7'], // Color for data labels
                    },
                    dropShadow: {
                        enabled: true,
                        top: 1,
                        left: 0,
                        blur: 2,
                        opacity: 1,
                        color: '#474747' // Shadow color
                    }
                },
                legend: {
                    show: false,
                    markers: { offsetY: -2 },
                    itemMargin: {
                        horizontal: 5,
                        vertical: 10
                    }
                },
                xaxis: {
                    categories: chartLabels,
                    labels: {
                        style: {
                            colors: chartColors, // Colors for x-axis labels
                            fontWeight: 'bold',
                            fontSize: '16px'
                        }
                    }
                },
                yaxis: {
                    max: 70, // Set maximum Y-axis to 70%
                    min: 0,  // Set minimum Y-axis to 0
                    tickAmount: 7, // Four ticks: 10, 30, 50, 70
                    labels: {
                        // new formatter, without , behind
                        // formatter: function (val) {
                        //     return val.toFixed(0) + "%"; // Format Y-axis labels to show percentage with 2 decimals
                        // }
                        formatter: function (val) {
                            if (val === 10 || val === 30 || val === 50 || val === 70) {
                                return val + "%"; // Only display specific labels
                            }
                            return ""; // Do not display other labels
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val.toFixed(1) + "%"; // Format tooltip to show percentage with 1 decimals
                        }
                    }
                }
            });

            // Render the bar chart
            chartBar.render();
        }

        // ==============================================z==============================================
        // Calculate CR
        function calculateCRDisplay() {
            // Get weights from the hidden inputs
            const weights = {};
            document.querySelectorAll('input[class="slider-pembobotan"]').forEach(input => {
                weights[input.id] = parseFloat(input.value);
            });
            // const weights = {'Kriteria Tambahan': 5, 'Nilai Akademik': 5, 'Passion': 5, 'Pengalaman Proyek': 3, 'Prestasi Kompetisi': 8, 'Sertifikasi': 8};
            // console.log(weights);

            // Step 1: Generate pairwise comparison matrix
            function generatePairwiseMatrix(weights) {
                const matrix = {};
                const criteria = Object.keys(weights);
                criteria.forEach(ci => {
                    matrix[ci] = {};
                    criteria.forEach(cj => {
                        matrix[ci][cj] = [weights[ci] / weights[cj], weights[ci] / weights[cj], weights[ci] / weights[cj]];
                    });
                });
                return matrix;
            }

            const pairwiseMatrix = generatePairwiseMatrix(weights);
            console.log(pairwiseMatrix);

            // Step 2: Generate TFN (Triangular Fuzzy Numbers) for each criterion
            function generateTFNFromWeights(weights, threshold = 0.15) {
                const tfn = {};
                Object.entries(weights).forEach(([key, weight]) => {
                    const lower = weight - (weight * threshold);
                    const middle = weight;
                    const upper = weight + (weight * threshold);
                    tfn[key] = [lower, middle, upper];
                });
                return tfn;
            }

            const tfn = generateTFNFromWeights(weights);

            // Step 3: Normalize the TFNs
            function normalizeTFN(tfn) {
                const total = [0, 0, 0];
                Object.values(tfn).forEach(values => {
                    for (let i = 0; i < 3; i++) {
                        total[i] += values[i];
                    }
                });

                const normalizedTFN = {};
                Object.entries(tfn).forEach(([key, values]) => {
                    normalizedTFN[key] = [
                        values[0] / total[2],
                        values[1] / total[1],
                        values[2] / total[0]
                    ];
                });
                return normalizedTFN;
            }

            const normalizedTFN = normalizeTFN(tfn);

            // Step 4: Calculate the fuzzy weight vector
            function calculateFuzzyWeightVector(normalizedTFN) {
                const fuzzyWeightVector = {};
                const n = Object.keys(normalizedTFN).length;
                Object.entries(normalizedTFN).forEach(([key, values]) => {
                    fuzzyWeightVector[key] = [
                        Math.pow(values[0], 1/n),
                        Math.pow(values[1], 1/n),
                        Math.pow(values[2], 1/n)
                    ];
                });
                return fuzzyWeightVector;
            }

            const fuzzyWeightVector = calculateFuzzyWeightVector(normalizedTFN);

            // Step 5: Defuzzification using Center of Area (CoA) method
            function defuzzify(fuzzyWeightVector) {
                const crispWeights = {};
                Object.entries(fuzzyWeightVector).forEach(([key, values]) => {
                    crispWeights[key] = (values[0] + values[1] + values[2]) / 3;
                });
                return crispWeights;
            }

            const crispWeights = defuzzify(fuzzyWeightVector);

            // Step 6: Normalize crisp weights
            function normalizeCrispWeights(crispWeights) {
                const total = Object.values(crispWeights).reduce((sum, weight) => sum + weight, 0);
                const normalizedWeights = {};
                Object.entries(crispWeights).forEach(([key, weight]) => {
                    normalizedWeights[key] = weight / total;
                });
                return normalizedWeights;
            }

            const normalizedCrispWeights = normalizeCrispWeights(crispWeights);

            // Step 7: Calculate Consistency Ratio (CR)
            function calculateEigenvalue(matrix, weights) {
                const n = Object.keys(weights).length;
                let sum = 0;
                Object.entries(weights).forEach(([i, wi]) => {
                    let rowSum = 0;
                    Object.entries(weights).forEach(([j, wj]) => {
                        rowSum += matrix[i][j][1] * wj;  // Using the middle value of TFN
                    });
                    sum += rowSum / wi;
                });
                return sum / n;
            }

            function calculateCI(lambda, n) {
                return (lambda - n) / (n - 1);
            }

            function calculateCR(CI, RI) {
                return CI / RI;
            }

            const lambda_max = calculateEigenvalue(pairwiseMatrix, normalizedCrispWeights);
            const n = Object.keys(weights).length;
            const CI = calculateCI(lambda_max, n);

            const RI_values = [0, 0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49];
            const RI = RI_values[n - 1];
            const CR = calculateCR(CI, RI);

            // Display CR in the input field
            document.getElementById("preview-cr").value = CR.toFixed(4); // Adjust to your desired decimal places
            document.getElementById("value-cr").value = CR.toFixed(4); // Adjust to your desired decimal places


            // Output results
            console.log("Normalized Crisp Weights:");
            console.log(normalizedCrispWeights);

            console.log(`\nMaximum Eigenvalue: ${lambda_max}`);
            console.log(`Consistency Index (CI): ${CI}`);
            console.log(`Consistency Ratio (CR): ${CR}`);

            const notif = document.querySelector('#cr-info');
            const cr = document.querySelector('#preview-cr');
            if (CR < 0.1) {
                console.log("The matrix is consistent.");
                notif.classList.add('visually-hidden');
                cr.style.color = 'green';
            } else {
                console.log("The matrix is inconsistent! Please review the comparisons.");
                notif.classList.remove('visually-hidden');
                cr.style.color = 'red';
            }

        }
    </script>


@endsection
