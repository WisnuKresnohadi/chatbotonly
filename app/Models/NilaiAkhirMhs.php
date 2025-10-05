<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiAkhirMhs extends Model
{
    use HasFactory, HasUuids;    

    protected $table = 'nilai_akhir_mhs';
    protected $primaryKey = 'id_nilai_akhir_mhs';
    public $incrementing = false;
    protected $keyType = 'string';
    // public $timestamps = false;
    protected $guarded = [];

     // Relationship with Mahasiswa model
     public function mahasiswa()
     {
         return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
     }
 
     // Relationship with MataKuliah model
     public function mataKuliah()
     {
         return $this->belongsTo(MataKuliah::class, 'id_mk', 'id_mk');
     }

     public function prodi()
    {
        return $this->hasManyThrough(
            ProgramStudi::class, // Target Model (Prodi)
            MataKuliah::class,   // Intermediate Model (Mata Kuliah)
            'id_mk',           // Foreign key on Mata Kuliah (to connect with BidangPekerjaanMk)
            'id_prodi',          // Foreign key on ProgramStudi
            'id_mk',           // Local key on BidangPekerjaanMk
            'id_prodi'           // Local key on MataKuliah (connecting with ProgramStudi)
        );
    }
}
