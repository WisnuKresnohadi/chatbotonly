<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PembimbingMandiri extends Model
{
    use HasUuids;

    protected $table = 'pbb_mandiri';
    protected $fillable = [
        'nama',
        'nip',
        'email',
        'jabatan',
        'no_hp',
        'status',
        'alasan_tolak'
    ];
    protected $primaryKey = 'id_pbb';
    protected $keyType = 'string';
    public $timestamps = false;
}
