<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendedEmailIndustri extends Model
{
    use HasUuids;

    protected $table = 'sended_email_industri';
    protected $primaryKey = 'id_sended_email';
    protected $guarded = [];
}
