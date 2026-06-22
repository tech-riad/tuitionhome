<?php

namespace App\Imports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DepartmentImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Department
     */
    public function model(array $row)
    {
        return new Department([
            'title'=>$row['title']
        ]);
    }
}
