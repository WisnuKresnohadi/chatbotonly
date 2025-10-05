<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailTemplate extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'email_template';
    protected $guarded = [];
    protected $primaryKey = 'id_email_template';
    public $timestamps = false;
}