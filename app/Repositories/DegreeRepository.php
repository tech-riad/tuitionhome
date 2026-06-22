<?php

namespace App\Repositories;

use App\Models\Degree;
use App\Repositories\BaseRepository;

/**
 * Class DegreeRepository
 * @package App\Repositories
 * @version February 23, 2023, 4:39 am UTC
*/

class DegreeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Degree::class;
    }
}
