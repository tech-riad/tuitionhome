<?php

namespace App\Imports;

use App\Models\Study;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudyImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Study
     */
    public function model(array $row)
    {
        return new Study([
            'title'=>$row['title'],
        ]);
    }
}
