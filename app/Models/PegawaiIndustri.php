<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PegawaiIndustri extends Model
{
    use HasUuids;

    protected $table = 'pegawai_industri';
    protected $guarded = [];
    protected $primaryKey = 'id_peg_industri';
    protected $keyType = 'string';
    public $timestamps = false;

    public function industri(){
        return $this->belongsTo(Industri::class, 'id_industri');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
