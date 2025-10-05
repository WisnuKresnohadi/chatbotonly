<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PekerjaanTersimpan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pekerjaan_tersimpans';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
