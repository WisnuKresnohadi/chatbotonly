<?php

namespace App\Models;

use App\Http\Controllers\DokumenSyaratController;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisMagang extends Model
{
    use HasUuids;

    protected $table = 'jenis_magang';
    protected $fillable = ['namajenis', 'durasimagang', 'id_year_akademik', 'desc', 'status'];
    protected $primaryKey = 'id_jenismagang';
    protected $keyType = 'string';
    public $timestamps = false;

    public function berkas_magang()
    {
        return $this->hasMany(BerkasMagang::class, 'id_jenismagang');
    }

    public function dokumen_persyaratan()
    {
        return $this->hasMany(DocumentSyarat::class, 'id_jenismagang');
    }

    public function lowongan_magang()
    {
        return $this->hasMany(LowonganMagang::class, 'id_jenismagang');
    }
}
