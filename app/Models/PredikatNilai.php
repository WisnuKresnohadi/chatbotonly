<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PredikatNilai extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'predikat_nilai';
    protected $guarded = [];    
    protected $primaryKey = 'id_predikat_nilai';
    protected $keyType = 'string';
    public $timestamps = false;
}
