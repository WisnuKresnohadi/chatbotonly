<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Universitas extends Model
{
    use HasUuids;

    protected $table = 'universitas';
    protected $fillable = ['namauniv', 'jalan', 'kota', 'telp', 'status'];
    protected $primaryKey = 'id_univ';
    
    public $timestamps = false;

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function fakultas()
    {
        return $this->hasMany(Fakultas::class, 'id_univ');
    }
}


