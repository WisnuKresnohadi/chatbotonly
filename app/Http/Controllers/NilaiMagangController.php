<?php

namespace App\Http\Controllers;

use App\Models\ConfigNilaiAkhir;
use App\Models\KomponenNilai;
use App\Models\MhsMagang;
use App\Models\NilaiPembAkademik;
use App\Models\NilaiPemblap;

class NilaiMagangController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;

        $data['mhs_magang'] = MhsMagang::select(
            'mhs_magang.id_mhsmagang', 'mahasiswa.id_prodi', 'mhs_magang.nilai_adjust', 'mhs_magang.nilai_akhir_magang', 'mhs_magang.indeks_nilai_akhir', 'mhs_magang.alasan_adjust',
            'mhs_magang.jenis_magang', 'dosen.namadosen', 'pegawai_industri.namapeg', 'pendaftaran_magang.dokumen_skm'
        )
        ->join('pendaftaran_magang', 'mhs_magang.id_pendaftaran', '=', 'pendaftaran_magang.id_pendaftaran')
        ->join('mahasiswa', 'pendaftaran_magang.nim', '=', 'mahasiswa.nim')
        ->leftJoin('dosen', 'dosen.nip', '=', 'mhs_magang.nip')
        ->leftJoin('pegawai_industri', 'pegawai_industri.id_peg_industri', '=', 'mhs_magang.id_peg_industri')
        ->where('pendaftaran_magang.nim', $mahasiswa->nim)
        ->where('mhs_magang.status_magang', 1)->first();

        if (!$data['mhs_magang']) return view('errors.error_custom', [
            'title' => '<span class="text-muted fw-light">Kegiatan Saya /</span> Nilai Magang',
            'message_1' => 'Anda Tidak Dalam Masa Magang',
            'message_2' => 'Anda tidak dalam masa magang. Kami sarankan untuk menghubungi LKM untuk informasi lebih lanjut.',
        ]);

        if ($data['mhs_magang']->dokumen_skm == null) return view('errors.error_custom', [
            'title' => '<span class="text-muted fw-light">Kegiatan Saya /</span> Nilai Magang',
            'message_1' => 'Anda Belum Dapat Melihat Nilai Magang',
            'message_2' => 'Anda belum dapat melihat nilai magang karena LKM belum mengirimkan surat pengantar magang. Kami sarankan untuk menghubungi LKM guna tindak lanjut proses tersebut.',
        ]);

        $komponenNilai = KomponenNilai::where('id_jenismagang', $data['mhs_magang']->jenis_magang)->get();

        $data['nilai_pemb_lapangan'] = NilaiPemblap::where('id_mhsmagang', $data['mhs_magang']->id_mhsmagang)->get();
        $data['dos_pemb_lapangan'] = $data['nilai_pemb_lapangan']->first()?->oleh;
        if (count($data['nilai_pemb_lapangan']) == 0) {
            $data['nilai_pemb_lapangan'] = $komponenNilai->where('scored_by', '2');
            $data['dos_pemb_lapangan'] = $data['mhs_magang']->namadosen ?? 'Not Yet Set';
        }

        $data['nilai_pemb_akademik'] = NilaiPembAkademik::where('id_mhsmagang', $data['mhs_magang']->id_mhsmagang)->get();
        $data['dos_pemb_akademik'] = $data['nilai_pemb_akademik']->first()?->oleh;
        if (count($data['nilai_pemb_akademik']) == 0) {
            $data['nilai_pemb_akademik'] = $komponenNilai->where('scored_by', '1');
            $data['dos_pemb_akademik'] = $data['mhs_magang']->namadosen ?? 'Not Yet Set';
        }

        $data['config_nilai_akhir'] = ConfigNilaiAkhir::where('id_prodi', $data['mhs_magang']->id_prodi)->first();

        return view('kegiatan_saya.nilai_magang.nilai', $data);
    }
}