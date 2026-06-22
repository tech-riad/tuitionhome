<?php

namespace App\Imports;

use App\Models\Degree;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DegreeImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Degree
     */
    public function model(array $row)
    {
        return new Degree([
            'title'=>$row['title'],
        ]);
    }
}
