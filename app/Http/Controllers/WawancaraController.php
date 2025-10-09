<?php

namespace App\Http\Controllers;

use App\Models\Bank_Soal;
use App\Models\Hasil_Wawancara;
use App\Models\LowonganMagang;
use App\Models\PendaftaranMagang;
use Illuminate\Http\Request;

class WawancaraController extends Controller
{
    public function config($id_lowongan){
        return view ('chatbot.config', [
            'id_lowongan' => $id_lowongan,
        ]);
    }
    public function editconfig($id_lowongan, Request $request){
        $lowongan = LowonganMagang::find($id_lowongan);

        $softskills = $request->input('softskill', []);
        $persyaratanTambahan = collect($request->persyaratan_tambahan)
            ->pluck('persyaratan_tambah')
            ->filter()
            ->values()
            ->toArray();
        $updateData = [];

        if (!empty($softskills)) {
            $updateData['softskill'] = $softskills;
        }

        if (!empty($persyaratanTambahan)) {
            $updateData['requirements'] = $persyaratanTambahan;
        }

        // Update only if something changed
        if (!empty($updateData)) {
            $lowongan->update($updateData);
        }

        return redirect('lowongan-magang/informasi-lowongan');
    }
    public function start($id_pendaftaran, $statusTrial){
        $nim = auth()->user()->mahasiswa->nim;
        $pendaftar_exist = Hasil_Wawancara::where('id_pendaftaran',$id_pendaftaran)
        ->where('nim', $nim)
        ->first();

        if ($statusTrial) {
            $pendaftar_exist = Hasil_Wawancara::where('id_pendaftaran',$id_pendaftaran)
            ->where('nim', $nim)
            ->delete();
            $softskill_lowongan = PendaftaranMagang::join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
                ->where('pendaftaran_magang.id_pendaftaran', $id_pendaftaran)
                ->first();
                $arraySoftskills = array_merge(json_decode($softskill_lowongan->softskill), ["Keterangan Lain"]);
                $softskills = collect($arraySoftskills);
                Hasil_Wawancara::updateOrCreate([
                    'id_pendaftaran' => $id_pendaftaran,
                    'nim' => $nim,
                    'skoring_wawancara' => json_encode($softskills->map(function ($item) {
                        return [
                            'kriteria' => $item,
                            'kesimpulan' => '',
                            'score' => '0',
                            'chatHistory' => json_encode([]),
                        ];
                    })),
                    'kuota_wawancara' => 1,
                ]);
        }
        $pendaftar_exist = Hasil_Wawancara::where('id_pendaftaran',$id_pendaftaran)
            ->where('nim', $nim)
            ->first();

        if ($pendaftar_exist->kuota_wawancara <= 0) {
            return redirect()->route('lamaran_saya.detail', ['id' => $id_pendaftaran]);
        }
            return null;
    }

    public function decreaseQuota(Request $request){
        $id_pendaftaran = $request->input('id_pendaftaran');
        // $nim = auth()->user()->mahasiswa->nim;

        // Hasil_Wawancara::where('id_pendaftaran',$id_pendaftaran)
        // ->where('nim', $nim)
        // ->decrement('kuota_wawancara');
        return redirect()->route('lamaran_saya.detail', ['id' => $id_pendaftaran]);;
    }
    public function getSpecificQuestion($id_pendaftaran)
    {
        $lowongan_softskills = PendaftaranMagang::join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
        ->where('pendaftaran_magang.id_pendaftaran', $id_pendaftaran)
        ->first();
        $softskills = json_decode($lowongan_softskills->softskill);

        $bankSoal = Bank_Soal::whereIn('kriteria_softskill', $softskills)->get();

        $formattedData = $bankSoal->map(function ($item) {

            $listPertanyaan = json_decode($item->list_pertanyaan, true);

            return [
                'kriteria' => $item->kriteria_softskill,
                'pertanyaanList' => collect($listPertanyaan)->map(function ($pertanyaan) {
                        return [
                            'pertanyaan' => $pertanyaan['pertanyaan'],
                            'jmlKategori' => $pertanyaan['jml_kategori']
                        ];
                    })->all()
            ];
        });
        return $formattedData;
    }
    public function getTrialQuestion($id_pendaftaran){
        $pendaftaran_magang = PendaftaranMagang::select("lowongan_magang.requirements")
        ->join("lowongan_magang", "lowongan_magang.id_lowongan", "=", "pendaftaran_magang.id_lowongan")
        ->where("pendaftaran_magang.id_pendaftaran", $id_pendaftaran)
        ->first();
        $trialQuestion = $pendaftaran_magang->requirements;
        if ($trialQuestion == null) {
            return null;
        } else {
            $trialQuestion = json_decode($pendaftaran_magang->requirements);
            return $trialQuestion;
        }
    }
}
