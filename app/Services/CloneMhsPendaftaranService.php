<?php

namespace App\Services;

use App\Models\PendaftaranMagang;
use App\Models\ExperiencePendaftaran;
use App\Models\Mahasiswa;
use App\Models\SertifikatPendaftaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CloneMhsPendaftaranService
{
    public static function cloneData(string $id_pendaftaran, Mahasiswa $mahasiswa)
    {
        try {
                // Clone informasi pribadi mahasiswa ke pendaftaran_magang
            self::cloneInformasiPribadi($id_pendaftaran, $mahasiswa);

            // Clone pengalaman kerja/magang mahasiswa
            self::cloneExperience($id_pendaftaran, $mahasiswa->experience);

            // Clone sertifikat mahasiswa
            self::cloneSertifikat($id_pendaftaran, $mahasiswa->sertifikat);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private static function cloneInformasiPribadi($id_pendaftaran, $mahasiswa)
    {
        PendaftaranMagang::where('id_pendaftaran', $id_pendaftaran)->update([
            'skills' => $mahasiswa->skills,
            'headliner' => $mahasiswa->headliner,
            'deskripsi_diri' => $mahasiswa->deskripsi_diri,
        ]);
    }

    private static function cloneExperience($id_pendaftaran, $experience)
    {
        $experience_pendaftaran = $experience->each(function($item) use($id_pendaftaran) {
            $item['id_experience'] = Str::orderedUuid();
            $item['id_pendaftaran'] = $id_pendaftaran;
            return $item;
        });

        ExperiencePendaftaran::insert($experience_pendaftaran->toArray());
    }

    private static function cloneSertifikat($id_pendaftaran, $sertifikat)
    {
        $sertifikat_pendaftaran = [];

        foreach ($sertifikat as $sertif) {
            $nim = $sertif['nim'];
            $file = null;

            if ($sertif['file_sertif'] && Storage::exists($sertif['file_sertif'])) {
                $namaFile = str_replace(' ', '_', strtolower($sertif['nama_sertif'])) . '.' . pathinfo($sertif['file_sertif'], PATHINFO_EXTENSION);
                $filePath = "sertifikat/pendaftaran/{$nim}/{$namaFile}";
                if (Storage::exists($sertif['file_sertif'])) {
                    if (Storage::exists($filePath)) {
                        Storage::delete($filePath);
                    }
                    Storage::copy($sertif['file_sertif'], $filePath);
                }
            }

            $sertifikat_pendaftaran[] = [
                'id_sertif' => Str::orderedUuid(),
                'id_pendaftaran' => $id_pendaftaran,
                'nim' => $sertif['nim'],
                'nama_sertif' => $sertif['nama_sertif'],
                'penerbit' => $sertif['penerbit'],
                'startdate' => $sertif['startdate'],
                'enddate' => $sertif['enddate'],
                'file_sertif' => $file, // path random dari Storage
                'link_sertif' => $sertif['link_sertif'],
                'deskripsi' => $sertif['deskripsi'],
            ];
        }

        SertifikatPendaftaran::insert($sertifikat_pendaftaran);
    }
}
