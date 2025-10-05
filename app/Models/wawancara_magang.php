<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wawancara_magang extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_wawancara',
        'id_lowongan',
        'list_kriteria_softskill',
    ];
    protected $table = 'wawancara_magang';
    protected $primaryKey = 'id_wawancara';
    public $timestamps = false;
}
