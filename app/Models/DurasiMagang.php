<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DurasiMagang extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id_durasi_magang'];
    protected $table = 'durasi_magang';
    protected $primaryKey = 'id_durasi_magang';
    public $keyType = 'string';
}
