<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasUuids;

    protected $table = 'skills';
    protected $fillable = [
        'skills',
        'nim',
    ];
    public $timestamps = false;
    protected $primaryKey = 'id_skills';
    protected $keyType = 'string';

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }

    protected $guarded = ['id'];
}
