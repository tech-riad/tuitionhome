<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'nationality',
        'flag',
    ];

    private static $country;
    private static $dir;
    private static $imageUrl;

    public static function CountryStore($request)
    {
         self::$country = new Country();
         self::$dir = "public/backend/images/country_flag/";
         self::$country->name = $request->country_name;
         self::$country->nationality = $request->nationality;
         self::$country->flag = imgUpload($request->file('flag_img'),self::$dir);
         self::$country->save();
    }

    public static function updateCountry($request,$id)
    {
        self::$country = Country::find($id);
        self::$dir = "public/backend/images/country_flag/";
        if ($request->file('flag_img'))
        {
            if (file_exists(self::$country->flag))
            {
                unlink(self::$country->flag);
            }
            self::$imageUrl = imgUpload($request->file('flag_img'),self::$dir);
        }else
        {
            self::$imageUrl = self::$country->flag;

        }
        self::$country->name = $request->country_name;
        self::$country->nationality = $request->nationality;
        self::$country->flag = self::$imageUrl;
        self::$country->update();


    }

    public static function deleteCountry($id)
    {
        self::$country = Country::find($id);
        if (file_exists(self::$country->flag))
        {
            unlink(self::$country->flag);
        }
        self::$country->delete();
    }

}
