<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Education extends Model
{
    use HasUuids;

    protected $table = 'education';
    protected $fillable = [
        'nim',
        'name_intitutions',
        'tingkat',
        'startdate',
        'enddate',
        'nilai',
    ];
    public $timestamps = false;
    protected $primaryKey = 'id_education';
    protected $keyType = 'string';

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }
}
