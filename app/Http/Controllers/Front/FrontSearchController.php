<?php

namespace App\Http\Controllers\Front;

use App\Models\ApplicationSetting;
use App\Models\Company;
use App\Models\FooterSetting;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\FrontJobApplication;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobApplicationAnswer;
use App\Models\JobApplicationExperience;
use App\Models\JobCategory;
use App\Models\JobLocation;
use App\Notifications\NewJobApplication;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\LinkedInSetting;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;


class FrontSearchController extends FrontBaseController
{
    
    public function searchOpenings(Request $request)
    {
        // $this->locations = JobLocation::where('location', 'like', '%' . $request->loc . '%')->orderBy('location')->get();
        // $this->companies = Company::where('company_name', 'like', '%' . $request->company . '%')->orderBy('company_name')->get();
       
        // $jobs = Job::with('company')->where('status', 'active')
        //     ->where('start_date', '<=', Carbon::now()->format('Y-m-d'))
        //     ->where('end_date', '>=', Carbon::now()->format('Y-m-d'))
        //     ->where(function ($query) use ($request) {
        //         $query->where('title', 'like', '%' . $request->job . '%')
        //               ->orWhere('job_description', 'like', '%' . $request->job . '%')
        //               ->orWhere('job_requirement', 'like', '%' . $request->job . '%');
        //     })
        //     ->orderBy('title');
            
        // if ($request->loc != '') {
        //     $res = array();
        //     foreach ($this->locations as $d) {
        //         $res[] = $d->id;
        //     }
        //     $jobs = $jobs->whereIn('location_id', $res);
        // }

        // if ($request->company != '') {
        //     $res = array();
        //     foreach ($this->companies as $d) {
        //         $res[] = $d->id;
        //     }
        //     $jobs = $jobs->whereIn('company_id', $res);
        // }

        // $row = ($request->row != '') ? $request->row : 3;
        
        // // return $jobs->paginate(1);
        // $this->jobs = $jobs->paginate($row);

        $this->rows_sort = array(3=>"show 3", 5=>"show 5");

            return view('layouts.front_find_jobs' , $this->data);

    }
}


?>