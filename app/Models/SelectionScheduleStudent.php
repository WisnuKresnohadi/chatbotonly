<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SelectionScheduleStudent extends Model
{
    use HasUuids;

    protected $table = 'selection_schedule_student';
    protected $fillable = ['nim'];
    protected $primaryKey = 'id_schedule_student';
    protected $keyType = 'string';
}
