<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ApiResponse;
class CreateEducationRequest extends FormRequest
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
            'school_id' => 'nullable',
            'school_curriculum_id' => 'nullable',
            'school_gpa' => 'nullable',
            'school_group' => 'nullable',
            'school_board' => 'nullable',
            'school_year' => 'nullable',
            'college_id' => 'nullable',
            'college_curriculum_id' => 'nullable',
            'college_gpa' => 'nullable',
            'college_group' => 'nullable',
            'college_board' => 'nullable',
            'college_year' => 'nullable',
            'graduation_university_id' => 'nullable',
            'graduation_university_type' => 'nullable',
            'graduation_university_cgpa' => 'nullable',
            'graduation_university_department_id' => 'nullable',
            'graduation_university_study_type_id' => 'nullable',
            'graduation_university_passing_year' => 'nullable',

        ];
    }


}
