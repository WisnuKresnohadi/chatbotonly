<?php

namespace App\Http\Controllers;

use App\Models\Hasil_Wawancara;
use App\Models\LowonganMagang;
use App\Models\PendaftaranMagang;

class HasilWawancaraController extends Controller
{
    //
    public function viewHasilWawancara($id_pendaftaran)
    {
        $hasilKesimpulan = PendaftaranMagang::leftJoin('hasil_wawancara', 'pendaftaran_magang.id_pendaftaran', '=', 'hasil_wawancara.id_pendaftaran')
        ->join('lowongan_magang', 'lowongan_magang.id_lowongan', 'pendaftaran_magang.id_lowongan')
        ->where('pendaftaran_magang.id_pendaftaran', '9f8a4106-3def-4cd1-8bf6-9d8fc8f82c1c')
        ->select('hasil_wawancara.*', 'lowongan_magang.id_lowongan')
        ->first();

        $id_industri = LowonganMagang::find($hasilKesimpulan->id_lowongan);

        // if ($id_industri->id_industri != auth()->user()->pegawai_industri->id_industri) abort(403);
        return view('chatbot.hasilwawancara', compact('hasilKesimpulan'));
    }
    public function simpanWawancara($id_pendaftaran, $kriteria, $conclusion, $kriteriaScore, $chatHistory)
    {
        $nimMahasiswa = auth()->user()->mahasiswa->nim;
        $pendaftaran_magang = PendaftaranMagang::where('nim', $nimMahasiswa)
        ->where('id_pendaftaran', $id_pendaftaran)
        ->first();

        $defaultScores = ['Sertifikasi' => '', 'Prestasi Kompetisi' => '', 'Pengalaman Proyek' => '', 'Softskills' => ''];
        $nilaiKriteria = json_decode($pendaftaran_magang->scores, true) ?? $defaultScores;

        $nilaiKriteria['Softskills'] = round($kriteriaScore * 100);
        $pendaftaran_magang->update(['scores' => $nilaiKriteria]);

        $getSkoring = Hasil_Wawancara::where('nim', $nimMahasiswa)
        ->where('id_pendaftaran', $id_pendaftaran)
        ->first();

        $skoring = json_decode($getSkoring->skoring_wawancara, true);
        $skoring = array_map(function ($item) use ($kriteria, $conclusion, $kriteriaScore, $chatHistory) {
            if ($item['kriteria'] === $kriteria ) {
                $item['kesimpulan'] = $conclusion;
                $item['score'] = round($kriteriaScore * 100);
                $item['chatHistory'] = json_encode($chatHistory);
            }
            return $item;
        }, $skoring);

        $skoring_wawancara = json_encode($skoring);

        Hasil_Wawancara::updateOrInsert(
        ['nim' => $nimMahasiswa, 'id_pendaftaran' => $id_pendaftaran],
        ['skoring_wawancara' => $skoring_wawancara]
        );

        return $id_pendaftaran;
    }
}
