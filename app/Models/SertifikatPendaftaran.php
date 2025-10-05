<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SertifikatPendaftaran extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'sertifikat_pendaftaran';
    protected $primaryKey = 'id_sertif';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_sertif',
        'id_pendaftaran',
        'nim',
        'nama_sertif',
        'penerbit',
        'startdate',
        'enddate',
        'file_sertif',
        'link_sertif',
        'deskripsi',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
