<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
        return [
            'user_name'     =>'required|string|max:20',
            'user_email'    =>'required|email|unique:users,email',
            'user_phone'    =>'required|numeric|min:11|unique:users,phone',
            'user_password' =>'required|min:6|numeric',
            'user_role'     =>'required',
        ];
    }
}
