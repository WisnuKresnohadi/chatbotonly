<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BerkasMagang extends Model
{
    use HasUuids;

    protected $table = 'berkas_magang';
    protected $guarded = [];

    public $timestamps = false;
    protected $primaryKey = 'id_berkas_magang';

    public function jenis_magang()
    {
        return $this->belongsTo(JenisMagang::class, 'id_jenismagang');
    }

    public function berkasAkhirMagang()
    {
        return $this->hasOne(BerkasAkhirMagang::class, 'id_berkas_magang', 'id_berkas_magang');
    }
}
