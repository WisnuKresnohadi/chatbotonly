<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use phpDocumentor\Reflection\Types\This;

class Seleksi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'seleksi_lowongan';
    public $timestamps = false;
    protected $fillable = [
        'id_email_template',
        'start_date',
        'end_date',
        'tahapan_seleksi',
        'id_lowongan',
        'id_pendaftaran'
    ];
    protected $primaryKey = 'id_seleksi_lowongan';
    protected $keyType = 'string';

    public function pendaftar()
    {
        return $this->belongsTo(PendaftaranMagang::class, 'id_pendaftaran');
    }
}
