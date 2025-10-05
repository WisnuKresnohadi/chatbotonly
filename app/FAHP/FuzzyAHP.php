<?php

namespace App\FAHP;

use App\Models\NilaiAkhirMhs;
use App\Models\PendaftaranMagang;
use App\Models\PredikatNilai;
use Illuminate\Database\Eloquent\Collection;

class FuzzyAHP
{
    private function generatePairwiseMatrix($weights)
    {
        $matrix = [];
        $criteria = array_keys($weights);
        foreach ($criteria as $ci) {
            $matrix[$ci] = [];
            foreach ($criteria as $cj) {
                $matrix[$ci][$cj] = [
                    $weights[$ci] / $weights[$cj],
                    $weights[$ci] / $weights[$cj],
                    $weights[$ci] / $weights[$cj]
                ];
            }
        }
        return $matrix;
    }

    private function generateTFNFromWeights($weights, $threshold = 0.25)
    {
        $tfn = [];
        foreach ($weights as $key => $weight) {
            $lower = $weight - ($weight * $threshold);
            $middle = $weight;
            $upper = $weight + ($weight * $threshold);
            $tfn[$key] = [$lower, $middle, $upper];
        }
        return $tfn;
    }

    private function normalizeTFN($tfn)
    {
        $total = [0, 0, 0];
        foreach ($tfn as $values) {
            for ($i = 0; $i < 3; $i++) {
                $total[$i] += $values[$i];
            }
        }
        $normalizedTFN = [];
        foreach ($tfn as $key => $values) {
            $normalizedTFN[$key] = [
                $values[0] / $total[2],
                $values[1] / $total[1],
                $values[2] / $total[0]
            ];
        }
        return $normalizedTFN;
    }

    private function calculateFuzzyWeightVector($normalizedTFN)
    {
        $fuzzyWeightVector = [];
        $n = count($normalizedTFN);
        foreach ($normalizedTFN as $key => $values) {
            $fuzzyWeightVector[$key] = [
                pow($values[0], 1 / $n),
                pow($values[1], 1 / $n),
                pow($values[2], 1 / $n)
            ];
        }
        return $fuzzyWeightVector;
    }

    private function defuzzify($fuzzyWeightVector)
    {
        $crispWeights = [];
        foreach ($fuzzyWeightVector as $key => $values) {
            $crispWeights[$key] = ($values[0] + $values[1] + $values[2]) / 3;
        }
        return $crispWeights;
    }

    private function normalizeCrispWeights($crispWeights)
    {
        $total = array_sum($crispWeights);
        $normalizedWeights = [];
        foreach ($crispWeights as $key => $weight) {
            $normalizedWeights[$key] = $weight / $total;
        }
        return $normalizedWeights;
    }

    private function calculateEigenvalue($matrix, $weights)
    {
        $n = count($weights);
        $sum = 0;
        foreach ($weights as $i => $wi) {
            $rowSum = 0;
            foreach ($weights as $j => $wj) {
                $rowSum += $matrix[$i][$j][1] * $wj;
            }
            $sum += $rowSum / $wi;
        }
        return $sum / $n;
    }

    private function calculateCI($lambda, $n)
    {
        return ($lambda - $n) / ($n - 1);
    }

    private function calculateCR($CI, $RI)
    {
        return $CI / $RI;
    }

    public function calculateFuzzyAHP($candidates, $criteriaWeights = [])
    {
        // Generate pairwise matrix
        $pairwiseMatrix = $this->generatePairwiseMatrix($criteriaWeights);

        // Get criteria from candidates
        $criteriaWeights = count($criteriaWeights) > 1 ? $criteriaWeights : json_decode($candidates[0]->pembobotan, true) ?? [];

        // Generate TFN
        $tfn = $this->generateTFNFromWeights($criteriaWeights);

        // Normalize TFN
        $normalizedTFN = $this->normalizeTFN($tfn);

        // Calculate fuzzy weight vector
        $fuzzyWeightVector = $this->calculateFuzzyWeightVector($normalizedTFN);

        // Defuzzify weights
        $crispWeights = $this->defuzzify($fuzzyWeightVector);

        // Normalize crisp weights
        $finalWeights = $this->normalizeCrispWeights($crispWeights);

        // Calculate final scores for candidates
        // $scores = [];
        // foreach ($candidates as $candidateId => $candidateScores) {
        //     $score = 0;
        //     foreach ($candidateScores as $criteria => $value) {
        //         $score += $value * $finalWeights[$criteria];
        //     }
        //     $scores[$candidateId] = $score;
        // }

        // Generate Nilai Akademik
        $candidates = self::generateNilaiAkademik($candidates);

        // Get nilai pembobotan mhs
        $candidates = self::getDataNilaiKriteria($candidates);

        $scores = [];
        foreach ($candidates as $c) {
            $score = 0;
            foreach ($c->dataNilaiKriteria as $criteria => $candidateScores) {
                $score += $candidateScores * $finalWeights[$criteria];
                $c->score = $score;
            }
            $scores[] = $c;
        }

        // Sort scores in descending order
        // arsort($scores);
        usort($scores, function ($a, $b) {
            return $b->score <=> $a->score; // Mengurutkan descending berdasarkan properti 'score'
        });

        // return [
        //     'weights' => $finalWeights,
        //     'scores' => $scores
        // ];
        return $scores;
    }

    public static function getDataNilaiKriteria($pendaftar)
    {
        $pendaftar = $pendaftar->map(function ($item) {
            $kriteria['Nilai Akademik'] = $item->nilai_akademik;
            $kriteria = array_merge($kriteria, json_decode($item->scores, true) ?? []);


            $predikat = PredikatNilai::where('status', true)->get()->pluck('nilai', 'id_predikat_nilai');
            foreach ($kriteria as $key => $k) {
                if ($key == 'Nilai Akademik') {}
                $kriteria[$key] = $predikat[$k] ?? $k;
            }

            $item->dataNilaiKriteria = $kriteria;

            return $item;
        });

        return $pendaftar;
    }

    public static function generateNilaiAkademik(Collection|PendaftaranMagang $pendaftar)
    {
        if (!$pendaftar instanceof Collection) {
            $pendaftar = collect([$pendaftar]);
        }

        $dataPendaftar = $pendaftar[0]->load('bidangPekerjaanIndustri.bidangPekerjaanMk')->load('bidangPekerjaanIndustri.bidangPekerjaanMk.mkItems');
        $bobotMkTerkait = $dataPendaftar->bidangPekerjaanIndustri->first()->bidangPekerjaanMk;

        $dataMk = [];
        foreach ($bobotMkTerkait as $bmkt) {
            $dataMk[$bmkt->id_bidang_pekerjaan_mk]['bobot'] = $bmkt->bobot;
            $dataMk[$bmkt->id_bidang_pekerjaan_mk]['mk_terkait'] = $bmkt->mkItems;
        }

        $idMks = collect($dataMk)->map(function ($item) {
            return collect($item['mk_terkait'])->pluck('id_mk');
        })->flatten(1);

        $nilaiAkhirMhs = NilaiAkhirMhs::whereIn('id_mk', $idMks)
            ->whereIn('nim', $pendaftar->pluck('nim'))
            ->select('id_mk', 'nilai_mk', 'predikat', 'nim')
            ->orderBy('nilai_mk', 'desc')
            ->get()->groupBy('nim');

        $pendaftar->map(function ($kandidat) use ($dataMk, $nilaiAkhirMhs) {
            $nilaiAkademik = 0.0;
            $totalNilai = 0;

            collect($dataMk)->each(function ($dataBobotMk) use ($nilaiAkhirMhs, $kandidat, &$totalNilai) {
                $idMkTerkait = collect($dataBobotMk['mk_terkait'])->pluck('id_mk');
                $bobot = $dataBobotMk['bobot'];

                $nilaiAkhirMhsCurrent = $nilaiAkhirMhs[$kandidat->nim] ?? null;
                $nilai = $nilaiAkhirMhsCurrent
                    ?->first(function ($item) use ($idMkTerkait) {
                        return in_array($item->id_mk, $idMkTerkait->toArray());
                    })->nilai_mk ?? 0;

                $totalNilai += $nilai * $bobot;
            });

            $nilaiAkademik = $totalNilai / 100;
            $kandidat->nilai_akademik = $nilaiAkademik;
            return $kandidat;
        });

        if (!$pendaftar instanceof Collection) {
            $pendaftar = $pendaftar[0];
        }
        return $pendaftar;
    }
}
