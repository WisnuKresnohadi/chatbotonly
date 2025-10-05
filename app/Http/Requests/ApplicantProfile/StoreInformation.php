<?php

namespace App\Http\Requests\ApplicantProfile;

use App\Http\Requests\CoreRequest;
use App\Models\Job;
use App\Models\Question;
use Illuminate\Support\Arr;

class StoreInformation extends CoreRequest
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
            // 'expected_salary_type' => 'required',
            // 'expected_salary_value' => 'required',
            // 'preferred_city' => 'required',
        ];
        
        return $rules;
    }
}
