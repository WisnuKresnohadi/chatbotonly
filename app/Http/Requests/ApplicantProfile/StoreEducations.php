<?php

namespace App\Http\Requests\ApplicantProfile;

use App\Http\Requests\CoreRequest;
use App\Models\Job;
use App\Models\Question;
use Illuminate\Support\Arr;

class StoreEducations extends CoreRequest
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
            'university.*' => 'required',
            'degree.*' => 'required',
            'study.*' => 'required',
            'start_date.*' => 'required',
            'end_date.*' => 'required',
            'gpa.*' => 'required',
        ];
        
        return $rules;
    }
}
