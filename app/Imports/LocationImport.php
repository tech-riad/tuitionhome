<?php

namespace App\Imports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LocationImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Location
     */
    public function model(array $row)
    {
        return new Location([
            'city_id'=> $row['city_id'],
            'name'=> $row['name'],
        ]);
    }
}
