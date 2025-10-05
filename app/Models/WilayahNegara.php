<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class WilayahNegara extends Model
{
    protected $table = 'reg_countries';
    public $timestamps = false;

    public function provinsi()
    {
        return $this->hasMany(WilayahProvinsi::class, 'country_id');
    }

    public function kota()
    {
        return $this->hasManyThrough(
            WilayahKota::class,
            WilayahProvinsi::class,
            'country_id',
            'province_id',
            'id',
            'id'
        );
    }
}