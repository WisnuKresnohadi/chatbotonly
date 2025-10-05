<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class MhsMandiri extends Model
{
    use HasUuids;

    protected $table = 'mhs_mandiri';
    protected $fillable = ['id_pengajuan', 'status', 'nip', 'id_pbb'];
    protected $primaryKey = 'id_mhsmandiri';
    protected $keyType = 'string';
    public $timestamps = false;

    public function PengajuanMandiri()
    {
        return $this->belongsTo(PengajuanMandiri::class, 'id_pengajuan');
    }
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nip');
    }
    public function pbb()
    {
        return $this->belongsTo(PembimbingMandiri::class, 'id_pbb');
    }
}