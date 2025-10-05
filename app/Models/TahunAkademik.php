<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TahunAkademik extends Model
{
    use HasUuids;

    protected $table = 'tahun_akademik';
    protected $fillable = ['semester', 'tahun','startdate_daftar','enddate_daftar','startdate_pengumpulan_berkas','enddate_pengumpulan_berkas'];
    protected $primaryKey = 'id_year_akademik';
    protected $keyType = 'string';
    public $timestamps = false;

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}