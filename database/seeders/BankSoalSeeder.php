<?php

namespace Database\Seeders;

use App\Models\Bank_Soal;
use Illuminate\Database\Seeder;

class BankSoalSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_kriteria' => 1,
                'kriteria_softskill' => 'Adaptasi',
                'list_pertanyaan' => [
                    ['pertanyaan' => 'Apakah anda membutuhkan waktu untuk penyesuaian dengan rekan kerja?', 'jml_kategori' => 4],
                    ['pertanyaan' => 'Bagaimana anda menghadapi perubahan yang terjadi pada situasi kerja?', 'jml_kategori' => 3],
                    ['pertanyaan' => 'Bagaimana anda menyesuaikan diri dengan aturan yang berlaku di tempat magang?', 'jml_kategori' => 4],
                    ['pertanyaan' => 'Bagaimana jika perusahaan membutuhkan skill yang diluar kemampuanmu, apakah kamu siap untuk belajar?', 'jml_kategori' => 3]
                ]
            ],
            [
                'id_kriteria' => 2,
                'kriteria_softskill' => 'Komunikasi',
                'list_pertanyaan' => [
                    ['pertanyaan' => 'Bagaimana cara anda menyampaikan pendapat dalam tim?', 'jml_kategori' => 5],
                    ['pertanyaan' => 'Bagaimana cara anda menyampaikan pendapat kepada supervisor anda?', 'jml_kategori' => 5],
                    ['pertanyaan' => 'Bagaimana cara anda menyampaikan pendapat di depan umum?', 'jml_kategori' => 4]
                ]
            ],
            [
                'id_kriteria' => 3,
                'kriteria_softskill' => 'Kepemimpinan',
                'list_pertanyaan' => [
                    ['pertanyaan' => 'Apakah anda yakin bahwa anda memiliki jiwa kepemimpinan yang kuat? Ceritakan pengalaman anda secara singkat dalam memimpin tim!', 'jml_kategori' => 4],
                    ['pertanyaan' => 'Bagaimana Anda membangkitkan semangat tim ketika menghadapi hambatan?', 'jml_kategori' => 4],
                    ['pertanyaan' => 'Bagaimana sikap anda terkait saingan dan kompetitor anda?', 'jml_kategori' => 4],
                    ['pertanyaan' => 'Seberapa sering anda memimpin sebuah tim atau kelompok?', 'jml_kategori' => 4]
                ]
            ],
            [
                'id_kriteria' => 4,
                'kriteria_softskill' => 'Kepercayaan Diri',
                'list_pertanyaan' => [
                    ['pertanyaan' => 'Bagaimana sikap anda ketika melihat orang yang lebih ahli atau menguasai bidang yang anda lamar sekarang?', 'jml_kategori' => 4],
                    ['pertanyaan' => 'Bagaimana Anda menilai diri sendiri dibandingkan dengan teman-teman Anda dalam bidang yang Anda lamar saat ini?', 'jml_kategori' => 4],
                    ['pertanyaan' => 'Seberapa yakin anda menguasai materi terkait posisi yang anda lamar?', 'jml_kategori' => 4]
                ]
            ],
            [
                'id_kriteria' => 5,
                'kriteria_softskill' => 'Manajemen Waktu',
                'list_pertanyaan' => [
                    ['pertanyaan' => 'Jika anda memiliki tugas yang sudah tenggat waktu, Apa yang anda lakukan?', 'jml_kategori' => 3],
                    ['pertanyaan' => 'Bagaimana anda mengatur jadwal keseharian anda?', 'jml_kategori' => 4],
                    ['pertanyaan' => 'Apakah anda suka menunda pekerjaan?', 'jml_kategori' => 4],
                ]
            ],
            [
                'id_kriteria' => 6,
                'kriteria_softskill' => 'Pemecahan Masalah',
                'list_pertanyaan' => [
                    ['pertanyaan' => 'Apa langkah pertama jika anda dihadapkan dengan masalah baru?', 'jml_kategori' => 4],
                    ['pertanyaan' => 'Seberapa yakin anda dapat menyelesaikan setiap masalah yang menimpa anda?', 'jml_kategori' => 4],
                    ['pertanyaan' => 'Situasi tersulit apa yang pernah anda alami dan bagaimana anda mengatasinya?', 'jml_kategori' => 4]
                ]
            ]
        ];

        foreach ($data as $entry) {
            Bank_Soal::create([
                'id_kriteria' => $entry['id_kriteria'],
                'kriteria_softskill' => $entry['kriteria_softskill'],
                'list_pertanyaan' => json_encode($entry['list_pertanyaan']),
            ]);
        }
    }
}
