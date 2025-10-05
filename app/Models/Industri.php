<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\LowonganMagang;

class Industri extends Model
{
    use HasUuids;

    protected $table = 'industri';
    protected $fillable = ['namaindustri', 'notelpon', 'email', 'alamatindustri', 'kategori_industri', 'statuskerjasama', 'description', 'statusapprove', 'penanggung_jawab', 'image'];
    protected $primaryKey = 'id_industri';
    protected $keyType = 'string';
    public $timestamps = false;

    public function relasi()
    {
        return $this->hasManyThrough(
            LowonganMagang::class,
            PendaftaranMagang::class,
            'id_pendaftaran',
            'id_lowongan',
            'id_pendaftaran',
            'id_lowongan'
        );
    }
    public function lowongan_magang()
    {
        return $this->hasMany(LowonganMagang::class, 'id_industri');
    }

    public function bidang_pekerjaan_industri()
    {
        return $this->hasMany(BidangPekerjaanIndustri::class, 'id_industri');
    }

    public function penanggungJawab()
    {
        return $this->hasOne(PegawaiIndustri::class, 'id_peg_industri', 'penanggung_jawab');
    }
}