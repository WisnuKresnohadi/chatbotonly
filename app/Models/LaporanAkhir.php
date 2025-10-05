<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAkhir extends Model
{
    use HasUuids;

    protected $table = 'laporan_akhir';
    protected $fillable = [
        'id_jenismagang',
        'id_year_akademik',
        'deadline_penilaian',
        'deadline_pengumpulan',
        'status',
        'durasi_magang',
        'berkas_magang'
    ];
    protected $primaryKey = 'id_lap_akhir';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $casts = [
        'deadline_penilaian' => 'datetime',
        'deadline_pengumpulan' => 'datetime',
        'berkas_magang' => 'array'
    ];

    public function jenis_magang()
    {
        return $this->belongsTo(JenisMagang::class, 'id_jenismagang');
    }
    public function tahun_akademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'id_year_akademik');
    }
}
