<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class NilaiMutu extends Model
{
    use HasUuids;

    protected $table = 'nilai_mutu';
    protected $fillable = ['nilaimin', 'nilaimax', 'nilaimutu', 'bobot'];
    protected $primaryKey = 'id_nilai';
    public $timestamps = false;
}
