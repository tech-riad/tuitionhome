<?php

namespace App\Repositories;

use App\Models\Study;
use App\Repositories\BaseRepository;

/**
 * Class StudyRepository
 * @package App\Repositories
 * @version February 23, 2023, 4:40 am UTC
*/

class StudyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'type'
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
        return Study::class;
    }
}
