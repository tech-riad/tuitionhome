<?php

namespace App\Imports;

use App\Models\Parents;
use Maatwebsite\Excel\Concerns\ToModel;

class ParentImport implements ToModel
{
    private $rowCount = 0;
    private $validRowCount = 0;

    public function model(array $row)
    {
        if ($this->validRowCount >= 1000) {
            return null;
        }

        $phone = preg_replace('/^88/', '', $row[0]);

        $existingParent = Parents::where('phone', $phone)->first();

        if ($existingParent) {
            return null;
        }

        $parent = Parents::create([
            'name'    => 'Anonymous Parent',
            'phone'   => $phone,
            'password' => bcrypt(123456),
            'phone_verified_at' => now(),
        ]);

        $parent->get_parent_unique_id();

        $parent->save();

        $this->validRowCount++;

        return $parent;
    }

    public function getImportStatus()
    {
        return $this->validRowCount;
    }
}
