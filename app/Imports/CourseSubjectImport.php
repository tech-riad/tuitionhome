<?php

namespace App\Imports;

use App\Models\CourseSubject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CourseSubjectImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CourseSubject([

            'course_id'=> $row['course_id'],
            'subject_id'=> $row['subject_id'],
        ]);
    }
}
