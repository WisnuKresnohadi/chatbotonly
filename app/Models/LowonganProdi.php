<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowonganProdi extends Model
{
    use HasFactory;
    protected $table = 'lowongan_prodi';
    protected $fillable = [
        'id_lowongan',
        'id_prodi',
    ];
    

    public function lowongan(){
        return $this->belongsTo(LowonganMagang::class,"id_lowongan");
     }
    public function prodi(){
        return $this->belongsTo(ProgramStudi::class,"id_prodi");
     }
}
