<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Location
 * @package App\Models
 * @version February 22, 2023, 10:08 am UTC
 *
 * @property integer $country_id
 * @property integer $city_id
 * @property string $name
 */
class Location extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'locations';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'country_id',
        'city_id',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'country_id' => 'integer',
        'city_id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'country_id' => 'required',
        'city_id' => 'required',
        'name' => 'required'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id','id');
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }


}
