<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank_Soal extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_kriteria',
        'kriteria_softskill',
        'list_pertanyaan',
    ];

    protected $casts = [
        'list_pertanyaan' => 'array',
    ];

    protected $table = 'bank_soal';
    protected $primaryKey = 'id_kriteria';
    public $timestamps = false;
}
