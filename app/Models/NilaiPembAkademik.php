<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiPembAkademik extends Model
{
    use HasUuids;

    protected $table = 'nilai_pemb_akademik';
    protected $primaryKey = 'id_nilai_pemb_akademik';
    protected $guarded = [];
}
