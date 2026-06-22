<?php

namespace App\Repositories;

use App\Models\Institute;
use App\Repositories\BaseRepository;

/**
 * Class InstituteRepository
 * @package App\Repositories
 * @version February 23, 2023, 4:46 am UTC
*/

class InstituteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'type',
        'approved'
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
        return Institute::class;
    }
}
