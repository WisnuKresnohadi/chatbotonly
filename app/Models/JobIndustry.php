<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobIndustry extends Model
{
    protected $guarded = ['id'];

    public function jobs(){
        return $this->hasMany(Jobs::class);
    }
}
