<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SelectionSchedule extends Model
{
    use HasUuids;

    protected $table = 'selection_schedule';
    protected $fillable = [
        'schedule_date',
        'status',

    ];
    protected $primaryKey = 'id_schedule';
    protected $keyType = 'string';
}
