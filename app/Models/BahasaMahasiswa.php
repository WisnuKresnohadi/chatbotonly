<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahasaMahasiswa extends Model
{
    use HasFactory;
    protected $table = 'bahasa_mahasiswas';
    protected $fillable = [
        'nim',
        'bahasa'];
    protected $keyType = 'string';
    public $timestamps = false;

    public function mhs()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }
}
