<?php

namespace App\Http\Requests\ApplicantProfile;

use App\Http\Requests\CoreRequest;
use App\Models\Job;
use App\Models\Question;
use Illuminate\Support\Arr;

class StoreSkills extends CoreRequest
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
            'start_period.*' => 'required_without:is_noExp',
            'end_period.*' => 'required_without:is_noExp',
            'company.*' => 'required_without:is_noExp',
            'description.*' => 'required_without:is_noExp',
            'position.*' => 'required_without:is_noExp',
            'industry_id.*' => 'required_without:is_noExp',
            'salary.*' => 'required_without:is_noExp',
            'skills.*' => 'required',
        ];
        
        return $rules;
    }

    public function messages()
    {
        return [
            'start_period.*required_without' => 'Start Year is required.',
            'end_period.*required_without' => 'End Year is required.',
            'company.*required_without' => 'Company is required.',
            'description.*required_without' => 'Description is required.',
            'position.*required_without' => 'Position is required.',
            'industry_id.*required_without' => 'Industry is required.',
        ];
    }
}
