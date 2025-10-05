<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission['Super Admin'] = ['roles.view', 'kelola_semua_pengguna.view'];
        $permission['LKM'] = [
            // admin lkm
            'dashboard.dashboard_admin',
            // kelola mitra
            'kelola_mitra.view',
            'kelola_mitra.create',
            'kelola_mitra.approval',
            // -----------------------
            // informasi lowongan LKM
            'informasi_lowongan_lkm.view',
            // -----------------------
            // Kelola Lowongan LKM
            'kelola_lowongan_lkm.view',
            'kelola_lowongan_lkm.approval',
            // -----------------------
            // pengajuan magang
            'pengajuan_magang.view',
            'pengajuan_magang.approval',
            'pengajuan_magang.upload_sr',
            // -----------------------
            // data magang
            'data_magang.view',
            'data_magang.upload_spm',
            // -----------------------
            // jadwal seleksi LKM
            'jadwal_seleksi_lkm.view',
            // -----------------------
            // berkas magang fakultas
            'berkas_magang_fakultas.view',
            'berkas_magang_fakultas.approval_file',
            'berkas_magang_fakultas.adjustment_nilai',
            // -----------------------
            // berkas magang mandiri
            'berkas_magang_mandiri.view',
            // -----------------------
            'nilai_mahasiswa_magang_fakultas.view',
            'nilai_mahasiswa_magang_mandiri.view',
            //------------------------
            'logbook_magang_fakultas.view',
            'logbook_magang_mandiri.view',
            // -----------------------
            'kelola_pengguna.view',
            'kelola_pengguna.create',
            'kelola_pengguna.update',
            'kelola_pengguna.reset_password',
            // master data
            'universitas.view',
            'fakultas.view',
            'program_studi.view',
            'tahun_akademik.view',
            'jenis_magang.view',
            // 'igracias.dosen.view',
            // 'igracias.mahasiswa.view',
            'wilayah.view',
            // 'pegawai_industri.view',
            'nilai_mutu.view',
            'nilai_akhir.view',
            'komponen_penilaian.view',
            'dokumen_syarat.view',
            'pembimbing_lapangan_mandiri.view',
            'durasi_magang.view',
            'igracias.view',
            'bidang_pekerjaan.view',
            'perusahaan.view',
            'predikat_nilai_fahp.view',
            'igracias.view', //
            'bidang_pekerjaan.view'
        ];

        $permission['Mitra'] = [
            // mitra
            'dashboard.dashboard_mitra',
            // informasi lowongan mitra
            'informasi_lowongan_mitra.view',
            'informasi_lowongan_mitra.set_confirm_closing',
            // --------------------------
            // kelola lowongan mitra
            'kelola_lowongan_mitra.view', //
            'informasi_lowongan_mitra.approval',
            'informasi_lowongan_mitra.set_jadwal',
            // --------------------------
            // kelola lowongan mitra
            'kelola_lowongan_mitra.view',
            'kelola_lowongan_mitra.create',
            'kelola_lowongan_mitra.update',
            // --------------------------
            // anggota tim mitra
            'anggota_tim.view',
            'anggota_tim.create',
            'anggota_tim.update',
            'anggota_tim.reset_password',
            // --------------------------
            // assign pembimbing lapangan
            'assign_pembimbing.view',
            'assign_pembimbing.assign',
            // --------------------------
            // template email mitra
            'template_email.view',
            'template_email.create',
            // --------------------------
            // profile perusahaan
            'profile_perusahaan.view',
            'profile_perusahaan.update',
            //-------------------
            'assign_pembimbing.view',
            'template_email.view',
            'bidang_pekerjaan_industri.view',
        ];

        $permission['Pembimbing Lapangan'] = [
            // kelola mahasiswa pemb lapangan
            'kelola_magang_pemb_lapangan.view',
            'kelola_magang_pemb_lapangan.approval',
            'kelola_magang_pemb_lapangan.set_nilai',
            'kelola_magang_pemb_lapangan.delete_mhs',
            // --------------------------
            'profile_perusahaan.view'
        ];
        $permission['Mahasiswa'] = [];
        $permission['Dosen'] = [
            // approval mahasiswa
            'approval_mhs_doswal.view',
            'data_mahasiswa_magang_dosen.view',
            'kelola_mhs_pemb_akademik.view',
            'approval_mhs_doswal.approval',
            // --------------------------
            'data_mahasiswa_magang_dosen.view',
            'kelola_mhs_pemb_akademik.view',
        ];
        $permission['Kaprodi'] = [
            // approval mahasiswa
            'approval_mhs_kaprodi.view',
            'approval_mhs_kaprodi.approval',
            // --------------------------
            // data mahasiswa magang kaprodi
            'data_mahasiswa_magang_kaprodi.view',
            'data_mahasiswa_magang_kaprodi.assign_pembimbing',
            // --------------------------
            // approval mahasiswa
            'approval_mhs_doswal.view',
            'approval_mhs_doswal.approval',
            // --------------------------
            'data_mahasiswa_magang_dosen.view',
            'kelola_mhs_pemb_akademik.view'
        ];
        $permission['Koordinator Magang'] = $permission['Kaprodi'];

        foreach ($permission as $key => $value) {
            foreach ($value as $p) {
                Permission::findOrCreate($p, 'web');
            }
            $role = Role::findOrCreate($key, 'web');
            $role->syncPermissions($value);
        }

        $role = Role::findOrCreate('Super Admin', 'web');

        $permission['Super Admin'] = array_merge($permission['Super Admin'], $permission['LKM']);
        $role->syncPermissions($permission['Super Admin']);

        Artisan::call('cache:clear');
    }
}
