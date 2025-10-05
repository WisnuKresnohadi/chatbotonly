<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pertanyaan_wawancara extends Model
{
    use HasFactory;
    protected $fillable = [
        'pertanyaan',
        'jml_kategori',
    ];
}
