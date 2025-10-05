<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogBookActivity extends Model
{
    use HasUuids;

    protected $table = 'log_book_activity';
    protected $fillable = [
        'date',
        'activity',
        'documentation',
        'approvelap',
        'date_approvelap',
        'approve_akademik',
        'date_approve_akademik',
    ];
    protected $primaryKey = 'id_log';
    protected $keyType = 'string';
}
