<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperiencePendaftaran extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'experience_pendaftaran';
    protected $primaryKey = 'id_experience';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_pendaftaran',
        'nim',
        'posisi',
        'jenis',
        'name_intitutions',
        'startdate',
        'enddate',
        'deskripsi',
        'nama',
        'prestasi',
        'kategori',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
