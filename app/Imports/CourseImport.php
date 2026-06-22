<?php

namespace App\Imports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CourseImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Course
     */
    public function model(array $row)
    {
        return new Course([
            'category_id'=> $row['category_id'],
            'name' => $row['title'],

        ]);
    }
}
