<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasUuids;

    protected $table = 'fakultas';
    protected $fillable = ['namafakultas','id_univ','status'];
    protected $primaryKey = 'id_fakultas';
    public $timestamps=false;
    
    protected $keyType = 'string';
    
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function univ(){
        return $this->belongsTo(Universitas::class,'id_univ');
    }
    public function lowongan(){
        return $this->belongsTo(Universitas::class,'id_lowongan');
    }

    public function program_studi()
    {
        return $this->hasMany(ProgramStudi::class, 'id_fakultas');
    }
}