<?php

namespace App\Imports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CityImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return City
     */
    public function model(array $row)
    {
        return new City([
            'country_id'=> $row['country_id'],
            'name'=> $row['name'],
        ]);
    }
}
