<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangPekerjaanMkItem extends Model
{
    use HasFactory;

    protected $table = 'bidang_pekerjaan_mk_item';
    // public $timestamps = false; 
    protected $primaryKey = null; 
    public $incrementing = false; 
    protected $keyType = 'string';
    protected $guarded = [];

    /**
     * Relationship ke tabel bidang_pekerjaan_mk
     */
    public function bidangPekerjaanMk()
    {
        return $this->belongsTo(BidangPekerjaanMk::class, 'id_bidang_pekerjaan_mk', 'id_bidang_pekerjaan_mk');
    }

    /**
     * Relationship ke tabel mata_kuliah
     */
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'id_mk', 'id_mk');
    }
}
