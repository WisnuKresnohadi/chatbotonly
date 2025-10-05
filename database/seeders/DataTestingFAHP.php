<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\PendaftaranMagang;
use App\Models\DokumenPendaftaranMagang;
use App\Models\DocumentSyarat;
use App\Enums\PendaftaranMagangStatusEnum;
use App\Enums\LowonganMagangStatusEnum;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataTestingFAHP extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil 20 mahasiswa dengan nilai
        $mahasiswaList = Mahasiswa::where('id_prodi', '32')
            ->whereHas('nilaiAkhirMhs') // Mahasiswa yang memiliki nilai
            ->skip(20)
            ->take(20)
            ->get();


        // ID lowongan yang dituju (sesuaikan dengan database)
        $idLowongan = "9de08840-35bc-4b10-bcbe-1637e5a19fd6";

        // Ambil detail lowongan
        $lowonganDetail = DB::table('lowongan_magang')
            ->where('statusaprove', LowonganMagangStatusEnum::APPROVED)
            ->where('id_lowongan', $idLowongan)
            ->first();

        if (!$lowonganDetail) {
            $this->command->error('Lowongan not found or not approved.');
            return;
        }

        // Ambil dokumen persyaratan untuk lowongan
        $dokumenPersyaratan = DocumentSyarat::where('id_jenismagang', $lowonganDetail->id_jenismagang)->get();

        DB::transaction(function () use ($mahasiswaList, $lowonganDetail, $dokumenPersyaratan, $idLowongan) {
            foreach ($mahasiswaList as $mhs) {
                // Buat atau ambil akun mahasiswa
                $user = User::firstOrCreate(
                    ['email' => $mhs->emailmhs],
                    [
                        'name' => $mhs->namamhs,
                        'username' => $mhs->namamhs,
                        'password' => Hash::make('password'), // Default password
                    ]
                );

                // Assign role "Mahasiswa"
                $user->assignRole('Mahasiswa');

                // Simulasi validasi pendaftaran
                $existingRegistrations = PendaftaranMagang::where('nim', $mhs->nim)
                    ->whereNotIn('current_step', [
                        PendaftaranMagangStatusEnum::REJECTED_BY_DOSWAL,
                        PendaftaranMagangStatusEnum::REJECTED_BY_KAPRODI,
                        PendaftaranMagangStatusEnum::REJECTED_BY_LKM,
                        PendaftaranMagangStatusEnum::REJECTED_SCREENING,
                        PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_1,
                        PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_2,
                        PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_3,
                        PendaftaranMagangStatusEnum::REJECTED_PENAWARAN
                    ])->get();

                if ($existingRegistrations->where('id_lowongan', $idLowongan)->first()) {
                    continue; // Sudah mendaftar ke lowongan ini
                }

                // if ($existingRegistrations->count() >= 2) {
                //     continue; // Sudah mendaftar ke 2 lowongan
                // }

                // Simulasi pembuatan lamaran
                $pendaftaran = PendaftaranMagang::create([
                    'id_lowongan' => $idLowongan,
                    'nim' => $mhs->nim,
                    'tanggaldaftar' => now(),
                    'current_step' => PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1,
                    'reason_aplicant' => 'Simulasi alasan lamaran.',
                ]);

                // Simulasi upload dokumen persyaratan
                $dokumenPendaftaran = [];
                foreach ($dokumenPersyaratan as $doc) {
                    $dokumenPendaftaran[] = [
                        'id_doc_pendaftaran' => Str::orderedUuid(),
                        'id_pendaftaran' => $pendaftaran->id_pendaftaran,
                        'id_document' => $doc->id_document,
                        'file' => 'dummy/path/to/file.pdf', // Dummy file path
                        'date_time' => now(),
                        'status' => true,
                    ];
                }

                DokumenPendaftaranMagang::insert($dokumenPendaftaran);
            }
        });

        $this->command->info('Mahasiswa dan lamaran berhasil dibuat.');
    }
}
