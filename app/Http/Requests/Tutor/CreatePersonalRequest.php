<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ApiResponse;

class CreatePersonalRequest extends FormRequest
{
    use ApiResponse;
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
        return [

            'blood_group'             => 'nullable',
            'religion'                => 'nullable',
            'nationality'             => 'nullable',
            'present_address'         => 'nullable',
            'permanent_address'       => 'nullable',
            'nid'                     => 'nullable',
            'date_of_birth'           => 'nullable',
            'father_name'             => 'nullable',
            'mother_name'             => 'nullable',
            'father_phone'            => 'nullable',
            'mother_phone'            => 'nullable',
            'emargency_contact_name'  => 'nullable',
            'emargency_contact_phone' => 'nullable',

        ];
    }
}
