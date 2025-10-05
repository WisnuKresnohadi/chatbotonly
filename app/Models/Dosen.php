<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    // use HasUuids;

    protected $table = 'dosen';
    protected $guarded = [];
    protected $primaryKey = 'nip';
    public $timestamps = false;
    protected $keyType = 'string';

    public function univ(){
        return $this->belongsTo(Universitas::class,'id_univ');
    }
    public function prodi(){
        return $this->belongsTo(ProgramStudi::class,'id_prodi');
    }
    public function fakultas(){
        return $this->belongsTo(Fakultas::class,'id_prodi');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    public function mahasiswaBimbingan() {
        return $this->hasMany(MhsMagang::class, 'nip', 'nip');
    }

    public function mahasiswaDiampu() {
        return $this->hasMany(Mahasiswa::class, 'kode_dosen', 'kode_dosen');
    }
}
