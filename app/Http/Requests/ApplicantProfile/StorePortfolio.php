<?php

namespace App\Http\Requests\ApplicantProfile;

use App\Http\Requests\CoreRequest;
use App\Models\Job;
use App\Models\Question;
use Illuminate\Support\Arr;

class StorePortfolio extends CoreRequest
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
            'resume' => 'required_without:hidden_resume',
            'url.*' => 'required',
            'portfolio.*' => 'required',
        ];
        
        return $rules;
    }

    public function messages()
    {
        return [
            'resume.required_without' => 'Resume is required.',
        ];
    }
}
