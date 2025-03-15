<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PortfolioRequest extends FormRequest
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
             'name'=>'required|string',
             'description'=>'required|string',
             'projectType'=>'nullable|string',
             'programLang' => 'required|array',
            'programLang.*' => 'string',
             'url'=>'required|string',
             'mainImage' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg',
             'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg',
             'videoUrl' => 'nullable|string',
             'startDate'=> 'nullable|date_format:Y-m-d',
             'endDate'=> 'nullable|date_format:Y-m-d',
             'status'=> 'nullable|in:active,notActive',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
