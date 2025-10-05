<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{

    use HasFactory;
    protected $table = 'mahasiswa';
    protected $fillable = [
        'nim',
        'angkatan',
        'id_prodi',
        'id_univ',
        'id_fakultas',
        'namamhs',
        'alamatmhs',
        'emailmhs',
        'nohpmhs',
        'status',
        // 'eprt',
        'ipk',
        'tak',
        'sosmed',
        'url_sosmed',
        'skills',
        'bahasa',
        'tunggakan_bpp',
        'kode_dosen',
        'kelas',
        'tesbahasa',
        'tipetesbahasa',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'kelas',
        'lok_magang',
    ];

    protected $casts = [
        'tesbahasa' => 'integer',
    ];

    protected $keyType = 'string';
    protected $primaryKey = 'nim';
    // public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_prodi');
    }
    public function univ()
    {
        return $this->belongsTo(Universitas::class, 'id_univ');
    }
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, "id_fakultas");
    }
    public function bahasamhs()
    {
        return $this->hasMany(BahasaMahasiswa::class, 'nim');
    }
    public function sosmedmhs()
    {
        return $this->hasMany(SosmedTambahan::class, 'nim');
    }

    public function education()
    {
        return $this->hasMany(Education::class, 'nim', 'nim');
    }

    public function experience()
    {
        return $this->hasMany(Experience::class, 'nim', 'nim');
    }

    public function profesional()
    {
        return $this->hasMany(Experience::class, 'nim', 'nim')
            ->where('kategori', 'profesional')
            ->orderBy('startdate', 'desc');
    }

    public function project()
    {
        return $this->hasMany(Experience::class, 'nim', 'nim')
            ->where('kategori', 'project')
            ->orderBy('startdate', 'desc');
    }

    public function competition()
    {
        return $this->hasMany(Experience::class, 'nim', 'nim')
            ->where('kategori', 'competition')
            ->orderBy('startdate', 'desc');
    }

    public function sertifikat()
    {
        return $this->hasMany(Sertif::class, 'nim', 'nim');
    }

    public function dosen_wali()
    {
        return $this->hasOne(Dosen::class, 'kode_dosen', 'kode_dosen');
    }

    public function lamaran_magang()
    {
        return $this->hasMany(PendaftaranMagang::class, 'nim', 'nim');
    }

    public function pekerjaan_tersimpan()
    {
        return $this->belongsToMany(LowonganMagang::class, 'pekerjaan_tersimpans', 'nim', 'id_lowongan');
    }

    public function kota()
    {
        return $this->belongsTo(WilayahKota::class, 'kota_id', 'id');
    }

    public function getTesBahasaAttribute($value)
    {
        return fmod($value, 1) === 0.0 ? intval($value) : $value;
    }

    // nilaiAkhirMhs
    public function nilaiAkhirMhs()
    {
        return $this->hasMany(NilaiAkhirMhs::class, 'nim', 'nim');
    }

}
