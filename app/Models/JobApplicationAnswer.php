<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicationAnswer extends Model
{
    protected $guarded = ['id'];

    public function job(){
        return $this->belongsTo(Job::class);
    }

    public function jobApplication(){
        return $this->belongsTo(JobApplication::class)->withTrashed();
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
