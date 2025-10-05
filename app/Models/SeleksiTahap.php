<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SeleksiTahap extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'seleksi';
    protected $guarded = [];
    protected $primaryKey = 'id_seleksi';
    protected $keyType = 'string';
    protected $casts = [
        'date_confirm_closing' => 'datetime'
    ];
    public $timestamps = false;

    
}