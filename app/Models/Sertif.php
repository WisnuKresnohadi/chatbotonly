<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sertif extends Model
{
    use HasUuids;

    protected $table = 'sertifikat';
    protected $fillable = [
        'nim',
        'nama_sertif',
        'penerbit',
        'startdate',
        'enddate',
        'file_sertif',
        'link_sertif',
        'deskripsi'
    ];
    protected $guarded = [];
    public $timestamps = false;
    protected $primaryKey = 'id_sertif';
    protected $keyType = 'string';

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }
}
