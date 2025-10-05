<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliah';
    protected $guarded = [];
    protected $primaryKey = 'id_mk';
    protected $keyType = 'string';
    // public $timestamps = false;

    public function univ(){
        return $this->belongsTo(Universitas::class,'id_univ');
    }
    public function prodi(){
        return $this->belongsTo(ProgramStudi::class,'id_prodi');
    }
    public function fakultas(){
        return $this->belongsTo(Fakultas::class,'id_prodi');
    }

    public function bidangPekerjaanMkItems()
    {
        return $this->hasMany(BidangPekerjaanMkItem::class, 'id_mk', 'id_mk');
    }

    public function nilaiAkhirMk()
    {
        return $this->hasMany(NilaiAkhirMhs::class, 'id_mk', 'id_mk');
    }

    public function getShortName()
    {
        // Memastikan bahwa $this->name adalah string
        if (isset($this->namamk)) {
            // Memisahkan string berdasarkan spasi menggunakan explode
            $words = explode(' ', $this->namamk);

            // Mengambil huruf pertama dari setiap kata, mengubahnya menjadi huruf besar
            $shortName = strtoupper(implode('', array_map(function ($word) {
                return $word[0]; // Huruf pertama setiap kata
            }, $words)));

            return $shortName;
        }
    }

}
