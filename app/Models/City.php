<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class City
 * @package App\Models
 * @version February 22, 2023, 9:58 am UTC
 *
 * @property integer $country_id
 * @property string $name
 */
class City extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'cities';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'country_id',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'country_id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'country_id' => 'required',
        'name' => 'required'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }


}
