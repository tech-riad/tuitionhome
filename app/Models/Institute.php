<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Institute
 * @package App\Models
 * @version February 23, 2023, 4:46 am UTC
 *
 * @property string $title
 * @property string $type
 * @property tinyinteger $approved
 */
class Institute extends Model
{
    use SoftDeletes;

    use HasFactory;



    public $table = 'institutes';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'type',
        'approved'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'type' => 'required',
    ];


}
