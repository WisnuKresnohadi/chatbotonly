<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NilaiIntern extends Model
{
    use HasUuids;

    protected $table = 'nilai_intern';
    protected $fillable = [
        'nilai',
        'deskripsi',
        'created_by',
        'nilaiadjust',
        'tgladjust',
        'alasanadjust',
    ];
    protected $primaryKey = 'id_nilai_intern';
    protected $keyType = 'string';
}
