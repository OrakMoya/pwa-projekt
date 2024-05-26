<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'uuid'=>['required','string','exists:posts'],
            'title'=>['required','min:3','max:50'],
            'category'=>['required','min:3','max:50'],
            'contents_json'=>['required'],
            'contents_html'=>['present'],
            'public'=>['required','boolean']
        ];
    }
}
