<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileUser extends Model
{
    protected $table = 'profile_users';

    protected $dates = ['dob'];

    protected $appends = ['resume_url'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function resumeDocument()
    {
        return $this->morphOne(Document::class, 'documentable')->where('name', 'Resume');
    }

    public function getResumeUrlAttribute()
    {
        if ($this->documents()->where([['name', 'Resume'], ['documentable_id', $this->id], ['documentable_type', 'App\ProfileUser']])->first()) {
            return asset_url('documents/users/' . $this->id . '/' . $this->documents()->where([['name', 'Resume'], ['documentable_id', $this->id], ['documentable_type', 'App\ProfileUser']])->first()->hashname);
        }
        return false;
    }

    public function information()
    {
        return $this->hasOne(ProfileUserInformation::class);
    }

    public function experiences()
    {
        return $this->hasMany(ProfileUserExperience::class)->orderBy('start_period', 'desc');
    }

    public function educations()
    {
        return $this->hasMany(ProfileUserEducation::class)->orderBy('start_date', 'desc');
    }

    public function skills()
    {
        return $this->hasMany(ProfileUserSkill::class);
    }

    public function languages()
    {
        return $this->hasMany(ProfileUserLanguage::class);
    }

    public function portfolios()
    {
        return $this->hasMany(ProfileUserPortfolio::class);
    }
}
