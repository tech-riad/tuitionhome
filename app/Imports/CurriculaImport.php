<?php

namespace App\Imports;

use App\Models\Curriculam;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CurriculaImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Curriculam
     */
    public function model(array $row)
    {
        return new Curriculam([
            'title'=> $row['title'],

        ]);
    }
}
