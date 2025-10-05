<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogbookDay extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'logbook_day';
    protected $primaryKey = 'id_logbook_day';
    protected $guarded = [];

    public function logbookWeek()
    {
        return $this->hasOne(LogbookWeek::class, 'id_logbook_week', 'id_logbook_week');
    }
}
