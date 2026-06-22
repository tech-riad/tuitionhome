<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Category
     */
    public function model(array $row)
    {
        return new Category([
            'name'=> $row['title'],
        ]);
    }
}
