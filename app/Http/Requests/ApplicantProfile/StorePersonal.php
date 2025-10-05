<?php

namespace App\Http\Requests\ApplicantProfile;

use App\Http\Requests\CoreRequest;
use App\Models\Job;
use App\Models\Question;
use Illuminate\Support\Arr;

class StorePersonal extends CoreRequest
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
        ];
    }
}
