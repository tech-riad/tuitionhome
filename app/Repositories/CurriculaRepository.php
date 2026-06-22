<?php

namespace App\Repositories;

use App\Models\Curriculam;
use App\Repositories\BaseRepository;

/**
 * Class CurriculaRepository
 * @package App\Repositories
 * @version February 23, 2023, 4:35 am UTC
*/

class CurriculaRepository extends BaseRepository
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
        return Curriculam::class;
    }
}
