<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\WilayahNegara;

class WilayahProvinsi extends Model
{
    protected $table = 'reg_provinces';
    public $timestamps = false;

    public function negara()
    {
        return $this->belongsTo(WilayahNegara::class, 'country_id');
    }
    
    public function kota()
    {
        return $this->hasMany(WilayahKota::class, 'province_id');
    }
}