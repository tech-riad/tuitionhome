<?php

namespace App\Imports;

use App\Models\Institute;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InstituteImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Institute
     */
    public function model(array $row)
    {
        return new Institute([
            'title' => $row['title'],
            'type' =>$row['type'],
        ]);
    }
}
