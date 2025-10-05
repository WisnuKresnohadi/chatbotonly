<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class NilaiAkhir extends Model
{
    use HasUuids;

    protected $table = 'nilai_akhir';
    protected $fillable = ['nilaimin', 'nilaimax', 'nilaimutu'];
    protected $primaryKey = 'id_nilai';
    protected $keyType = 'string';
    public $timestamps = false;
}