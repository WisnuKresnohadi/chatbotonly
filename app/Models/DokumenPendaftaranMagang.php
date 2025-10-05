<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DokumenPendaftaranMagang extends Model
{
    use HasUuids;

    protected $table = 'dokumen_pendaftaran_magang';
    protected $guarded = [];
    protected $primaryKey = 'id_doc_pendaftaran';
}
