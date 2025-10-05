<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use App\Enums\TemplateEmailListProsesEnum;
use Illuminate\Foundation\Http\FormRequest;


class MasterEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'proses' => 'required|in:' . implode(',', TemplateEmailListProsesEnum::getConstants()),
            'subject_email' => ['required'],
            'content_email' => ['required']
        ];
    }          
    
    
    public function messages(): array
    {
        return [
            'proses.required' => 'Proses harus diisi',
            'proses.in' => 'Proses tidak valid',
            'subject_email.required' => 'Subject harus diisi',
            'content_email.required' => 'Content harus diisi',
        ];
    }
}