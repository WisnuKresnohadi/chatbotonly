<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogbookWeek extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'logbook_week';
    protected $primaryKey = 'id_logbook_week';

    protected $guarded = [];

    
    public function logbook() {
        return $this->hasOne(Logbook::class, 'id_logbook', 'id_logbook');
    }
    public function logbookDay() {
        return $this->hasMany(LogbookDay::class, 'id_logbook_week', 'id_logbook_week');
    }
}
