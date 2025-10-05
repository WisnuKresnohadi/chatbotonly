<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MhsMagang extends Model
{
    use HasUuids;

    protected $table = 'mhs_magang';
    protected $guarded = [];
    protected $primaryKey = 'id_mhsmagang';
    
    public $timestamps = false;
    protected $casts = [
        'startdate_magang' => 'datetime',
        'enddate_magang' => 'datetime'
    ];

    public function PengajuanMandiri()
    {
        return $this->belongsTo(PengajuanMandiri::class, 'id_pengajuan');
    }
    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranMagang::class, 'id_pendaftaran');
    }
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nip');
    }
    public function pbb()
    {
        return $this->belongsTo(PembimbingMandiri::class, 'id_pbb');
    }
    public function peg_industri()
    {
        return $this->belongsTo(PegawaiIndustri::class, 'id_peg_industri');
    }
}