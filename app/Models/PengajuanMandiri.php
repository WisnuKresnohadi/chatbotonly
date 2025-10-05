<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class PengajuanMandiri extends Model
{
    use HasUuids;

    protected $table = 'pengajuan_mandiri';
    protected $fillable = ['nim', 'tglpeng', 'nama_industri', 'email', 'posisi_magang', 'jabatan', 'alamat_industri', 'nohp', 'startdate', 'enddate', 'statusapprove', 'alasan_tolak', 'bukti_doc', 'dokumen_spm', 'status_terima'];
    protected $primaryKey = 'id_pengajuan';
    protected $keyType = 'string';
    public $timestamps = false;

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }
    public function mahasiswa_mandiri()
    {
        return $this->hasMany(MhsMandiri::class, 'id_pengajuan');
    }
}