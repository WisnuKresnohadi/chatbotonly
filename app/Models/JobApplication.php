<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use Notifiable, SoftDeletes;

    protected $appends = ['resume_url'];

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function resumeDocument()
    {
        return $this->morphOne(Document::class, 'documentable')->where('name', 'Resume');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }

    public function status()
    {
        return $this->belongsTo(ApplicationStatus::class, 'status_id');
    }

    public function schedule()
    {
        return $this->hasOne(InterviewSchedule::class)->latest();
    }

    public function onboard()
    {
        return $this->hasOne(Onboard::class);
    }

    public function getResumeUrlAttribute()
    {
        if ($this->documents()->where([['name', 'Resume'], ['documentable_id', $this->id], ['documentable_type', 'App\JobApplication']])->first()) {
            return asset_url('documents/applications/' . $this->id . '/' . $this->documents()->where([['name', 'Resume'], ['documentable_id', $this->id], ['documentable_type', 'App\JobApplication']])->first()->hashname);
        }
        return false;
    }

    public function notes()
    {
        return $this->hasMany(ApplicantNote::class, 'job_application_id')->orderBy('id', 'desc');
    }

    public function experiences()
    {
        return $this->hasMany(JobApplicationExperience::class)->orderBy('start_period', 'desc');
    }

    public function educations()
    {
        return $this->hasMany(JobApplicationEducation::class)->orderBy('start_date', 'desc');
    }

    public function skills()
    {
        return $this->hasMany(JobApplicationSkill::class);
    }

    public function languages()
    {
        return $this->hasMany(JobApplicationLanguage::class);
    }

    public function portfolios()
    {
        return $this->hasMany(JobApplicationPortfolio::class);
    }
}
