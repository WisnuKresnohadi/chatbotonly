<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasil_Wawancara extends Model
{
    use HasFactory;
    protected $fillable = [
        'nim',
        'id_pendaftaran',
        'skoring_wawancara',
        'kuota_wawancara',
    ];

    protected $table = 'hasil_wawancara';
    public $timestamps = false;
}
