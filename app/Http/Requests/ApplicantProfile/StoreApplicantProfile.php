<?php

namespace App\Http\Requests\ApplicantProfile;

use App\Http\Requests\CoreRequest;
use App\Models\Job;
use App\Models\Question;
use Illuminate\Support\Arr;

class StoreApplicantProfile extends CoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'headline' => 'required',
            'calling_code' => 'required',
            'mobile' => 'required',
            'dob' => 'required',
            'nationality' => 'required',
            'marital_stat' => 'required',
            'gender' => 'required',
            'country' => 'required|integer|min:1',
            'state' => 'required|integer|min:1',
            'city' => 'required',
            'postal_code' => 'required',
            // 'expected_salary_type' => 'required',
            // 'expected_salary_value' => 'required',
            // 'preferred_city' => 'required',
            'start_period.*' => 'required_without:is_noExp',
            'end_period.*' => 'required_without:is_noExp',
            'company.*' => 'required_without:is_noExp',
            'description.*' => 'required_without:is_noExp',
            'position.*' => 'required_without:is_noExp',
            'industry_id.*' => 'required_without:is_noExp',
            'salary.*' => 'required_without:is_noExp',
            'university.*' => 'required',
            'degree.*' => 'required',
            'study.*' => 'required',
            'start_date.*' => 'required',
            'end_date.*' => 'required',
            'gpa.*' => 'required',
            'skills.*' => 'required',
            'resume' => 'required_without:hidden_resume',
            'language_name.*' => 'required',
            'language_level.*' => 'required',
            'url.*' => 'required',
            'portfolio.*' => 'required',
        ];
        
        return $rules;
    }

    public function messages()
    {
        return [
            'dob.required' => 'Date of Birth field is required.',
            'country.min' => 'Please select country.',
            'state.min' => 'Please select state.',
            'city.required' => 'Please enter city.',
            'resume.required_without' => 'Resume is required.',
            'start_period.*required_without' => 'Start Year is required.',
            'end_period.*required_without' => 'End Year is required.',
            'company.*required_without' => 'Company is required.',
            'description.*required_without' => 'Description is required.',
            'position.*required_without' => 'Position is required.',
            'industry_id.*required_without' => 'Industry is required.',
        ];
    }
}
