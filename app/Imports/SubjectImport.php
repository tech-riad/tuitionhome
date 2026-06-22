<?php

namespace App\Imports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubjectImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Subject
     */
    public function model(array $row)
    {
        return new Subject([
            'title'=>$row['title'],
        ]);
    }
}
