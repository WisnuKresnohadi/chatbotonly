<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangPekerjaanMk extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'bidang_pekerjaan_mk';
    protected $primaryKey = 'id_bidang_pekerjaan_mk';
    protected $guarded = [];
    protected $keyType = 'string';
    // public $timestamps = false;

     /**
     * Relationship ke tabel bidang_pekerjaan_industri
     */
    public function bidangPekerjaanIndustri()
    {
        return $this->belongsTo(BidangPekerjaanIndustri::class, 'id_bidang_pekerjaan_industri');
    }

    /**
     * Relationship ke tabel bidang_pekerjaan_mk_item
     */
    public function mkItems()
    {
        return $this->hasMany(BidangPekerjaanMkItem::class, 'id_bidang_pekerjaan_mk', 'id_bidang_pekerjaan_mk');
    }
}
