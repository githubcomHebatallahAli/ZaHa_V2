<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ProjectRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'cost' => 'nullable|numeric|min:0|max:99999.99',
            'projectType' => 'required|in:web,flutter,webAndFlutter,other',
            'startDate' => 'nullable|date_format:Y-m-d',
            'endDate' => 'nullable|date_format:Y-m-d|after_or_equal:startDate',
            'hostName' => 'nullable|string|max:255',
            'hostCost' => 'nullable|numeric|min:0|max:99999.99',
            'buyHostDate' => 'nullable|date_format:Y-m-d',
            'renewalHostDate' => 'nullable|date_format:Y-m-d|after_or_equal:buyHostDate',
            'domainName' => 'nullable|string|max:255',
            'domainCost' => 'nullable|numeric|min:0|max:99999.99',
            'buyDomainDate' => 'nullable|date_format:Y-m-d',
            'renewalDomainDate' => 'nullable|date_format:Y-m-d|after_or_equal:buyDomainDate',
            'reason' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0|max:99999.99',
            'status'=>'nullable|in:pending,completed,canceled,inProgress,rejected',
            'creationDate' => 'nullable|date_format:Y-m-d H:i:s',
            'developers' => 'nullable|array',
            'developers.*.id' => 'nullable_with:developers|exists:developers,id',
            'developers.*.profit' => 'nullable_with:developers|numeric|min:0|max:99999.99',
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
