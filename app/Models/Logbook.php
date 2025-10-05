<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'logbook';
    protected $primaryKey = 'id_logbook';
    protected $guarded = [];

    public function logbookWeek()
    {
        return $this->hasMany(LogbookWeek::class, 'id_logbook', 'id_logbook');
    }

    public function pendaftaran()
    {
        return $this->hasOne(PendaftaranMagang::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}
