<?php

namespace App\Http\Controllers\Front;

use App\Models\Job;
use App\Models\User;
use App\Models\Skill;
use App\Models\Company;
use Carbon\Carbon;
use App\Models\JobCategory;
use App\Models\JobIndustry;
use App\Models\JobLocation;
use App\Models\MasterMajor;
use App\Models\ProfileUser;
use App\Helper\Files;
use App\Helper\Reply;
use App\Models\ThemeSetting;
use App\Models\FooterSetting;
use App\Models\JobApplication;
use App\Models\LinkedInSetting;
use App\Models\ProfileUserSkill;
use App\Models\ApplicationSetting;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\JobApplicationSkill;
use Illuminate\Http\Request;
use App\Models\JobApplicationAnswer;
use App\Models\JobApplicationLanguage;
use App\Models\JobApplicationEducation;
use App\Models\JobApplicationPortfolio;
use App\Models\JobApplicationExperience;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NewJobApplication;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\FrontJobApplication;
use Illuminate\Support\Facades\Notification;
// use Storage;
class FrontJobsController extends FrontBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('modules.front.jobOpenings');

        $linkedinSetting = LinkedInSetting::where('status', 'enable')->first();
        $this->linkedinGlobal = LinkedInSetting::first();

        if ($linkedinSetting)
        {
            Config::set('services.linkedin.client_id', $linkedinSetting->client_id);
            Config::set('services.linkedin.client_secret', $linkedinSetting->client_secret);
            Config::set('services.linkedin.redirect', $linkedinSetting->callback_url);
        }

        $this->skills = Skill::orderBy('name')->get();
        $this->industries = JobIndustry::orderBy('name')->get();
        $this->language_names = json_decode(file_get_contents(public_path('/json/languages.json')), true)['results'];
        $this->gender = [
            'male' => __('modules.front.male'),
            'female' => __('modules.front.female'),
            'others' => __('modules.front.others')
        ];
        
        $this->language_levels = [
            'Native / Bilingual Proficiency', 'Professional Working Proficiency', 'Limited Working Proficiency', 'Elementary Proficiency'
        ];
        
        $this->portfolios = [
            'LinkedIn', 'Portfolio', 'Website', 'Github', 'Gitlab', 'Behance', 'TikTok', 'Twitter', 'Instagram', 'Facebook', 'Other'
        ];
    }

    public function jobOpenings(Request $request)
    {
        // $this->locations = JobLocation::where('location', 'like', '%' . $request->loc . '%')->orderBy('location')->get();
        $jobs = Job::with('company')->where('status', 'active')
            ->where('start_date', '<=', Carbon::now()->format('Y-m-d'))
            ->where('end_date', '>=', Carbon::now()->format('Y-m-d'))
            ->orderBy('title');
            
        $this->jobs = $jobs->paginate(10);
        // $this->jobs = $jobs->take(6)->get();
        
        $this->categories = JobCategory::all();
        $this->companies = Company::get();
        // return $this->background->background_image_url;

        return view('front.job-openings', $this->data);
            
        
        
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function customPage($slug)
    {

        $this->customPage = FooterSetting::where('slug', $slug)->where('status', 'active')->first();

        if(is_null($this->customPage)){ abort(404); }

        $this->pageTitle = ucfirst($this->customPage->name);
        $this->companies = Company::get();

        return view('front.custom-page', $this->data);
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jobDetail($slug)
    {
        $this->job = Job::where('slug', $slug)
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())
            ->where('status', 'active')
            ->firstOrFail();
        Session::put('lastPageUrl', $slug);

        $this->pageTitle = $this->job->title . ' - ' . $this->companyName;
        $this->metaTitle = $this->job->meta_details['title'];
        $this->metaDescription = $this->job->meta_details['description'];
        $this->metaImage = $this->job->company->logo_url;
        $this->companyPhone = $this->job->company->company_phone;
        $this->companyAddress = $this->job->company->address;
        $this->companyEmail = $this->job->company->company_email;
        $this->pageUrl = request()->url();

        if(Auth::check()){
            $user = auth()->user();
            if ($user) {
                $application = JobApplication::where([['user_id', auth()->user()->id], ['job_id', $this->job->id]])->with(['educations', 'experiences', 'skills'])->first();
                $this->job_application_id = $application ? $application->id : null;
            }
        }

        return view('front.job-detail', $this->data);
    }

    /**
     * @param $provider
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function callback($provider, Request $request)
    {
        if ($request->error) {
            $this->errorCode = $request->error;
            $this->error = $request->error_description;
            return view('errors.linkedin', $this->data);
        }
        
        $this->user = Socialite::driver($provider)->user();
        $this->lastPageUrl = Session::get('lastPageUrl');
        Session::put('accessToken', $this->user->token);
        Session::put('expiresIn', $this->user->expiresIn);
        return redirect()->route('jobs.jobApply', $this->lastPageUrl);

    }

    /**
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function country()
    {
        // $country = Storage::disk('local')->get('country.json');
        // $country = json_decode($country, true);
        // $states = Storage::disk('local')->get('states.json');
        // $states = json_decode($states, true);
        // $countriesArray = json_decode(file_get_contents(public_path('country-state-city/countries.json')), true)['countries'];
        // $statesArray = json_decode(file_get_contents(public_path('country-state-city/states.json')), true)['states'];
        // $data = ['awdawd' => $countriesArray];
        // return $statesArray;
        
        
    }

    public function jobApply($slug)
    {
        //check if logged in
        if(! Auth::check()){
            Session::put('previousUrl', url('job/'.$slug.'/apply'));
            return redirect(url('/login'));
        }
        abort_if(Auth::user()->hasRole('admin'), 403);

        // $this->accessToken = Session::get('accessToken');
        // if ($this->accessToken)
        // {
        //     $this->user = Socialite::driver('linkedin')->userFromToken($this->accessToken);
        // }
        // else{
        //     $this->user =[];
        // }
        $this->job = Job::where('slug', $slug)->first();
        $this->jobQuestion = $this->job->questions;
        $this->applicationSetting = ApplicationSetting::first();
        $this->pageTitle = $this->job->title . ' - ' . $this->companyName;
        $this->locations = JobLocation::orderBy('location')->get();
        $this->majors = MasterMajor::orderBy('major')->get();
        // return awadwaw;
        $this ->countriesArray = json_decode(file_get_contents(public_path('country-state-city/countries.json')), true)['countries'];
        $this ->statesArray = json_decode(file_get_contents(public_path('country-state-city/states.json')), true)['states'];

        if(Auth::check()){
            $user = auth()->user();
            if ($user) {
                $this->user = User::find($user->id);
                $this->skill_data = Skill::all();
                $profile = ProfileUser::where('user_id', $this->user->id)->with(['educations', 'experiences', 'skills'])->first();
                $this->user->profile = $profile;
                if($profile){
                    $skills = ProfileUserSkill::where('profile_user_id', $profile->id)->get();
                    $this->user->profile->skills = $skills;
                }
                else{
                    return redirect(url('/profile/setup'));
                }

                $application = JobApplication::where([['user_id', auth()->user()->id], ['job_id', $this->job->id]])->with(['educations', 'experiences', 'skills'])->first();
                $this->job_application_id = $application ? $application->id : null;
            }
        }

        // $data = ['awdawd' => $countriesArray];

        $preferred_cities = json_decode($this->user->profile->information->preferred_city ?? '[]');

        return view('front.job-apply', $this->data, compact('preferred_cities'));
    }

    /**
     * @param FrontJobApplication $request
     * @return mixed
     */
    public function saveApplication(FrontJobApplication $request)
    {
        if($request->has('user_id')){
            $user = User::find($request->user_id);
        }
        else{
            $user = Auth::user();
        }

        //update user
        $user->calling_code = $request->calling_code;
        $user->mobile = $request->mobile;

        if ($request->hasFile('image')) {
            if($user->image){
                File::delete($user->profile_image_url);
            }
            $user->image = Files::upload($request->image, 'profile');
        }
        $user->save();

        //create profile user
        $jobApplication = new JobApplication();
        if($request->has('job_application_id')){
            $job_application_id = $request->job_application_id;
            if($job_application_id != null)
                $jobApplication = JobApplication::find($job_application_id);
        }
        $jobApplication->user_id = $user->id;
        $jobApplication->job_id = $request->job_id;
        $jobApplication->status_id = 1;
        $jobApplication->dob = $request->dob;
        $jobApplication->marital_stat = $request->marital_stat;
        $jobApplication->gender = $request->gender;
        $jobApplication->nationality = $request->nationality;
        $countriesArray = json_decode(file_get_contents(public_path('country-state-city/countries.json')), true)['countries'];
        $statesArray = json_decode(file_get_contents(public_path('country-state-city/states.json')), true)['states'];
        $jobApplication->country = $this->getName($countriesArray, $request->country);
        $jobApplication->state = $this->getName($statesArray, $request->state);
        $jobApplication->city = $request->city;
        $jobApplication->postal_code = $request->postal_code;
        $jobApplication->cover_letter = $request->cover_letter;

        if ($request->has('cover_letter')) {
            $jobApplication->cover_letter = $request->cover_letter;
        }

        $jobApplication->save();

        if ($request->has('university')) {
            $universities = $request->input('university');
            $degrees = $request->input('degree');
            $studies = $request->input('study');
            $start_dates = $request->input('start_date');
            $gpas = $request->input('gpa');
            $is_graduateds = $request->input('is_graduated');
            if($request->has('end_date')){
                $end_dates = $request->input('end_date');
            }
            
            for ($i=0;$i<count($universities);$i++){
                if (trim($universities[$i]) != '' && trim($degrees[$i]) != '' &&
                    trim($studies[$i]) != '' && trim($start_dates[$i]) != '' &&
                    trim($gpas[$i]) != '' && trim($is_graduateds[$i]) != ''
                ){
                    $education = new JobApplicationEducation();
                    $education->job_application_id = $jobApplication->id;
                    $education->university = $universities[$i];
                    $education->degree = $degrees[$i];
                    $education->study = $studies[$i];
                    $education->start_date = $start_dates[$i];
                    $education->gpa = $gpas[$i];
                    $education->is_graduated = $is_graduateds[$i];
                    if($request->has('end_date')){
                        if($end_dates[$i] != null)
                            $education->end_date = $end_dates[$i];
                    }
                    $education->save();
                }
            }
        }

        if ($request->has('skills')) {
            $skills = $request->input('skills');
            
            for ($i=0;$i<count($skills);$i++){
                if (trim($skills[$i]) != ''){
                    $skill = new Skill();
                    if(Skill::where('name', 'LIKE', $skills[$i])->first()){
                        $skill = Skill::where('name', 'LIKE', $skills[$i])->first();
                    }
                    $skill->name = ucwords($skills[$i]);
                    $skill->save();

                    $job_skill = new JobApplicationSkill();
                    $job_skill->job_application_id = $jobApplication->id;
                    $job_skill->skill_id = $skill->id;
                    $job_skill->save();
                }
            }
        }

        if ($request->has('start_period')) {
            $start_periods = $request->input('start_period');
            $end_periods = $request->input('end_period');
            $comps = $request->input('company');
            $positions = $request->input('position');
            $descriptions = $request->input('description');
            $industry_ids = $request->input('industry_id');
            $salaries = $request->input('salary');
            
            for ($i=0;$i<count($start_periods);$i++) {
                if (trim($start_periods[$i]) != '' && trim($comps[$i]) != '' && trim($positions[$i]) != '') {
                    $jobExp = new JobApplicationExperience();
                    $jobExp->job_application_id = $jobApplication->id;
                    $jobExp->start_period = $start_periods[$i];
                    $jobExp->end_period = $end_periods[$i];
                    $jobExp->company = $comps[$i];
                    $jobExp->position = $positions[$i];
                    $jobExp->description = $descriptions[$i];
                    $jobExp->industry_id = $industry_ids[$i];
                    $jobExp->salary = $salaries[$i];
                    $jobExp->save();
                }
            }
        }

        if ($request->has('language_name')) {
            $language_names = $request->input('language_name');
            $language_levels = $request->input('language_level');
            
            for ($i=0;$i<count($language_names);$i++) {
                if (trim($language_names[$i]) != '' && trim($language_levels[$i]) != '') {
                    $lang = new JobApplicationLanguage();
                    $lang->job_application_id = $jobApplication->id;
                    $lang->name = $language_names[$i];
                    $lang->level = $language_levels[$i];
                    $lang->save();
                }
            }
        }

        if ($request->has('portfolio')) {
            $portfolios = $request->input('portfolio');
            $urls = $request->input('url');
            
            for ($i=0;$i<count($portfolios);$i++) {
                if (trim($portfolios[$i]) != '' && trim($urls[$i]) != '') {
                    $port = new JobApplicationPortfolio();
                    $port->job_application_id = $jobApplication->id;
                    $port->name = $portfolios[$i];
                    $port->url = $urls[$i];
                    $port->save();
                }
            }
        }

        if ($request->hasFile('resume')) {
            // Files::deleteFile($profile->resumeDocument->hashname, 'documents/users'.$profile->id);
            $hashname = Files::upload($request->resume, 'documents/applications/'.$jobApplication->id, null, null, false);
            $jobApplication->documents()->updateOrCreate([
                'documentable_type' => JobApplication::class,
                'documentable_id' => $jobApplication->id,
                'name' => 'Resume'
            ],
            [
                'hashname' => $hashname
            ]);
        }

        $linkedin = false;

        if($request->linkedinPhoto)
        {
            $contents = file_get_contents($request->linkedinPhoto);
            $getfilename =  str_replace(' ', '_', $request->user->name);
            $filename = $jobApplication->id.$getfilename.'.png';
            Storage::put('candidate-photos/'.$filename, $contents);
            $jobApplication = JobApplication::find($jobApplication->id);
            $jobApplication->photo = $filename;
            $jobApplication->save();
        }
        
        $users = User::allAdmins();
        if (!empty($request->answer)) {
            foreach ($request->answer as $key => $value) {
                $answer = new JobApplicationAnswer();
                $answer->job_application_id = $jobApplication->id;
                $answer->job_id = $request->job_id;
                $answer->question_id = $key;
                $answer->answer = $value;
                $answer->save();
            }
        }
        if($request->has('apply_type')){
            $linkedin = true;
        }

        // Notification::send($users, new NewJobApplication($jobApplication, $linkedin));
        return Reply::redirect(header('Location: '.$_SERVER['PHP_SELF']), __('modules.front.applySuccessMsg'));
    }



    public function fetchCountryState(Request $request)
    {
        $responseArr = [];

        $response = [
            "status" => "success", 
            "tp" => 1,
            "msg" => "Countries fetched successfully."
        ];

        switch ($request->type) {
            case 'getCountries':
                $countriesArray = json_decode(file_get_contents(public_path('country-state-city/countries.json')), true)['countries'];

                foreach ($countriesArray as $country) {
                    $responseArr = Arr::add($responseArr, $country['id'], $country['name']);
                }
            break;
            case 'getStates':
                $statesArray = json_decode(file_get_contents(public_path('country-state-city/states.json')), true)['states'];
                $countryId = $request->countryId;

                $filteredStates = array_filter($statesArray, function ($value) use ($countryId) {
                    return $value['country_id'] == $countryId;
                });

                foreach ($filteredStates as $state) {
                    $responseArr = Arr::add($responseArr, $state['id'], $state['name']);
                }
            break;
        }
        $response = Arr::add($response, "result", $responseArr);                

        return response()->json($response);
    }

    public function getName($arr, $id)
    {
        $result = array_filter($arr, function ($value) use ($id) {
            return $value['id'] == $id;
        });
        return current($result)['name'];
    }

    public function fetchJobs(Request $request)
    {
        $data = Job::where('status', 'active')
            ->where('start_date', '<=', Carbon::now()->format('Y-m-d'))
            ->where('end_date', '>=', Carbon::now()->format('Y-m-d'))
            ->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->q . '%')
                      ->orWhere('job_description', 'like', '%' . $request->q . '%')
                      ->orWhere('job_requirement', 'like', '%' . $request->q . '%');
            })
            ->select('title as text')
            ->distinct()
            ->orderBy('title')
            ->limit(5)
            ->get();
        $res = array();
        foreach ($data as $d) {
            $res[] = $d->text;
        }
        return response()->json($res);
    }

    public function fetchLocations(Request $request)
    {
        $data = JobLocation::where('location', 'like', '%' . $request->q . '%')->select('id', 'location as text')->orderBy('location')->limit(5)->get();
        $res = array();
		foreach ($data as $d) {
			$res[] = $d->text;
		}
        return response()->json($res);
    }

    
    // public function coba()
    // {
    //     return view('coba');
    // }
}
