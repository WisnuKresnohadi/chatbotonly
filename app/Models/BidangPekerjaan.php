<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangPekerjaan extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id_bidang_pekerjaan'];
    protected $table = 'bidang_pekerjaan';
    protected $primaryKey = 'id_bidang_pekerjaan';   
    protected $keyType = 'string';
    public $timestamps = false; 
}
