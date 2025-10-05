<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\WilayahProvinsi;

class WilayahKota extends Model
{
    protected $table = 'reg_regencies';
    public $timestamps = false;

    public function provinsi()
    {
        return $this->belongsTo(WilayahProvinsi::class, 'province_id');
    }

}