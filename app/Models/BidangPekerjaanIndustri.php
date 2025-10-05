<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangPekerjaanIndustri extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id_bidang_pekerjaan_industri'];
    protected $table = 'bidang_pekerjaan_industri';
    protected $primaryKey = 'id_bidang_pekerjaan_industri';
    public $keyType = 'string';

    public function industri()
    {
        return $this->belongsTo(Industri::class, 'id_industri');
    }

    public function bidangPekerjaanMk() {
        return $this->hasMany(BidangPekerjaanMk::class, 'id_bidang_pekerjaan_industri', 'id_bidang_pekerjaan_industri');
    }
}
