<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigNilaiAkhir extends Model
{
    use HasUuids;

    protected $table = 'config_nilai_akhir';
    protected $guarded = [];
    protected $primaryKey = 'id_config_nilai_akhir';
}
