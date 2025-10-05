<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SosmedTambahan extends Model
{
    use HasFactory;
    
    protected $table = 'sosmed_tambahans';
    protected $fillable = [
        'nim',
        'namaSosmed',
        'urlSosmed'
    ];
    protected $keyType = 'string';
    public $timestamps = false;

    public function mhsw()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }
}