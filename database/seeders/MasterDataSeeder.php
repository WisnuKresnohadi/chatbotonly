<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Fakultas;
use App\Models\Mahasiswa;
use App\Models\NilaiMutu;
use App\Models\JenisMagang;
use App\Models\Universitas;
use Illuminate\Support\Str;
use App\Models\BerkasMagang;
use App\Models\ProgramStudi;
use App\Models\KomponenNilai;
use App\Models\TahunAkademik;
use App\Models\DocumentSyarat;
use App\Models\PegawaiIndustri;
use Illuminate\Database\Seeder;

use App\Models\ConfigNilaiAkhir;
use App\Models\PembimbingLapanganMandiri;
use App\Http\Controllers\DokumenSyaratController;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Universitas = [
            'namauniv' => 'Telkom University',
            'jalan' => 'Jl. Telekomunikasi. 1, Terusan Buah Batu',
            'kota' => 'Bandung',
            'telp' => '022-7564108',
            'status' => 1,
        ];
        $id_univ = Universitas::updateOrCreate(['namauniv' => $Universitas['namauniv']], $Universitas)->id_univ;


        $Fakultas = [
            'namafakultas' => 'Fakultas Ilmu Terapan',
            'id_univ' => $id_univ,
            'status' => 1,
        ];
        $id_fakultas = Fakultas::updateOrCreate(['namafakultas' => $Fakultas['namafakultas']], $Fakultas)->id_fakultas;


        $NamaProgramStudi = [
            'Teknologi Telekomunikasi' => 'D3',
            'Rekayasa Perangkat Lunak Aplikasi' => 'D3',
            'Sistem Informasi' => 'D3',
            'Sistem Informasi Akuntansi' => 'D3',
            'Teknologi Komputer' => 'D3',
            'Manajemen Pemasaran' => 'D3',
            'Perhotelan' => 'D3',
            'Terapan Teknologi Rekayasa Multimedia' => 'D4'
        ];
        foreach($NamaProgramStudi as $key => $value){
            $prodi = ProgramStudi::updateOrCreate(['namaprodi' => $key] ,[
                'id_fakultas' => $id_fakultas,
                'status' => 1,
                'id_univ' => $id_univ,
                'jenjang' => $value
            ]);

            ConfigNilaiAkhir::updateOrCreate(['id_prodi' => $prodi->id_prodi] ,[
                'nilai_pemb_lap' => 40,
                'nilai_pemb_akademik' => 60,
                'status' => 1
            ]);
        }


        $TahunAkademik = ['2020/2021', '2021/2022', '2022/2023','2023/2024','2024/2025'];
        for($i = 1; $i <= count($TahunAkademik)*2; $i++){
            $i%2 == 0 ? $semester = 'Genap' : $semester = 'Ganjil';
            $bagi = ($i > count($TahunAkademik)) ? $i/2 : $i;
            TahunAkademik::updateOrCreate(
                [
                    'tahun' => $TahunAkademik[$bagi - 1],
                    'semester' => $semester
                ],[
                    'status' => ($TahunAkademik[$bagi - 1] == '2024/2025' && $semester == 'Ganjil') ? 1 : 0,
                ]
            );
        }


        $JenisMagang = [
            ['namajenis' => 'Magang Fakultas', 'durasimagang' => '1 Semester', 'desc' => '-', 'berkas' => [
                [
                    'nama_berkas' => 'Dokumen Implementasi Kegiatan',
                    'status_upload' => 1,
                    'template' => url('template/ia_individu.docx'),
                    'due_date' => '2024-07-30'
                ],
                [
                    'nama_berkas' => 'Laporan Magang',
                    'status_upload' => 1,
                    'template' => url('template/laporan_magang_1_smt.docx'),
                    'due_date' => '2024-07-30'
                ],
            ]], 
            ['namajenis' => 'Magang Fakultas', 'durasimagang' => '2 Semester', 'desc' => '-', 'berkas' => [
                [
                    'nama_berkas' => 'Dokumen Implementasi Kegiatan',
                    'status_upload' => 1,
                    'template' => url('template/ia_individu.docx'),
                    'due_date' => '2024-07-30'
                ],
                [
                    'nama_berkas' => 'Laporan Magang',
                    'status_upload' => 1,
                    'template' => url('template/laporan_magang_2_smt_kerja.docx'),
                    'due_date' => '2024-07-30'
                ],
            ]], 
            // ['namajenis' => 'Magang Mandiri', 'durasimagang' => '1 Semester', 'desc' => '-'], 
            // ['namajenis' => 'Magang MKBM - Kampus Merdeka', 'durasimagang' => '1 Semester', 'desc' => '-'], 
        ];
        foreach($JenisMagang as $value){
            $x = JenisMagang::updateOrCreate([
                'namajenis' => $value['namajenis'], 
                'durasimagang' => $value['durasimagang'],
                'id_year_akademik' => TahunAkademik::active()->first()->id_year_akademik,
                'desc' => $value['desc']
            ], [
                'status' => 1
            ]);

            if (isset($value['berkas'])) {
                foreach ($value['berkas'] as $k => $v) {
                    BerkasMagang::create([
                        'nama_berkas' => $v['nama_berkas'],
                        'status_upload' => 1,
                        'template' => $v['template'],
                        'id_jenismagang' => $x->id_jenismagang,
                        'due_date' => $v['due_date']
                    ]);
                }
            }
        }
        

        $NilaiMutu = [
            ['nilaimin' => '0.00', 'nilaimax' => '40.00', 'nilaimutu' => 'E'],
            ['nilaimin' => '40.01', 'nilaimax' => '50.00', 'nilaimutu' => 'D'],
            ['nilaimin' => '50.01', 'nilaimax' => '60.00', 'nilaimutu' => 'C'],
            ['nilaimin' => '60.01', 'nilaimax' => '65.00', 'nilaimutu' => 'BC'],
            ['nilaimin' => '65.01', 'nilaimax' => '70.00', 'nilaimutu' => 'B'],
            ['nilaimin' => '70.01', 'nilaimax' => '80.00', 'nilaimutu' => 'AB'],
            ['nilaimin' => '80.01', 'nilaimax' => '100', 'nilaimutu' => 'A'],
        ];
        foreach($NilaiMutu as $value){
            NilaiMutu::updateOrCreate([
                'nilaimutu' => $value['nilaimutu']
            ],[
                'nilaimin' => $value['nilaimin'],
                'nilaimax' => $value['nilaimax'],
                'status' => 1]
            );
        }


        $DokumenPersyaratan = [
            'Magang Fakultas' => ['Transkrip NIlai', 'Sertifikasi', 'Eprt', 'TAK', 'CV', 'Portofolio']
        ];

        foreach($DokumenPersyaratan as $magang => $documents){
            $jenismagang = JenisMagang::where('namajenis', $magang)->get()->pluck('id_jenismagang')->toArray();
            foreach($jenismagang as $id_jenismagang){
                foreach($documents as $val){
                    DocumentSyarat::updateOrCreate([
                        'namadocument' => $val,
                        'id_jenismagang' => $id_jenismagang
                    ],[
                        'status' => 1
                    ]);
                }
            }
        }

        $KomponenNilai = [
            'Magang Fakultas' => [[
                    'aspek_penilaian' => 'Komunikasi, Adaptasi, Kerjasama',
                    'deskripsi_penilaian' => 'Penilaian dalam magang mencakup kemampuan berkomunikasi dengan jelas, beradaptasi dengan perubahan, dan bekerja sama dalam tim untuk mencapai tujuan bersama.',
                    'scored_by' => '1',
                    'nilai_max' => '30'
                ],[
                    'aspek_penilaian' => 'Disiplin dan Tanggung Jawab dalam pengerjaan tugas',
                    'deskripsi_penilaian' => 'Kemampuan untuk mengikuti aturan dan tenggat waktu dengan konsisten serta menyelesaikan tugas sesuai standar yang ditetapkan.',
                    'scored_by' => '1',
                    'nilai_max' => '30'
                ],[
                    'aspek_penilaian' => 'Kemampuan/Skill Mahasiswa Sesuai (memenuhi) posisi magang',
                    'deskripsi_penilaian' => 'Mahasiswa memiliki kemampuan yang sesuai dengan posisi magang yang ditawarkan, memenuhi persyaratan yang diperlukan untuk berhasil dalam peran tersebut.',
                    'scored_by' => '1',
                    'nilai_max' => '40'
                ],[
                    'aspek_penilaian' => "Buku Laporan Akhir\n - Penulisan dan Tata Bahasa\n - Latar Belakang dan Tujuan\n - Uraian Mengenai Permasalahan dan Solusinya",
                    'deskripsi_penilaian' => 'Evaluasi kemampuan magang dalam menyampaikan ide, bertanya, dan menjelaskan secara jelas dan efektif.',
                    'scored_by' => '2',
                    'nilai_max' => '70'
                ],[
                    'aspek_penilaian' => "Presentasi dan Tanya Jawab\n - Mahasiswa Mempresentasikan Ruang Lingkup Pekerjaan selama Magang\n - Dosen memberi nilai terkait tingkat kesulitan dan ruang lingkup magang untuk dijadikan dasar penilaian",
                    'deskripsi_penilaian' => 'Evaluasi kemampuan magang dalam menyampaikan ide, bertanya, dan menjelaskan secara jelas dan efektif.',
                    'scored_by' => '2',
                    'nilai_max' => '30'
            ]]
        ];
        foreach($KomponenNilai as $magang => $komponen){
            $jenismagang = JenisMagang::where('namajenis', $magang)->get()->pluck('id_jenismagang')->toArray();
            foreach($jenismagang as $id_jenismagang){
                foreach($komponen as $value){
                    KomponenNilai::updateOrCreate([
                        'id_jenismagang' => $id_jenismagang,
                        'aspek_penilaian' => $value['aspek_penilaian'],
                        'scored_by' => $value['scored_by'],
                    ],[
                        'deskripsi_penilaian' => $value['deskripsi_penilaian'],
                        'nilai_max' => $value['nilai_max'],
                        'status' => 1
                    ]);
                }
            }
        }
    }
}