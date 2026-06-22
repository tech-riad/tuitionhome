<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Location;
use Illuminate\Http\Request;
use Exception;
use App\Traits\ApiResponse;
class CountryCityLocationController extends Controller
{
    use ApiResponse;
    public function getCountry()
    {
        try{

            $country = Country::get();
            if (count($country) >0)
            {
                return response()->json(['status'=>true,'message'=>'Get all country successfully!','data'=>$country]);
            }else
            {
                return response()->json(['status'=>false,'message'=>'Country Not Found!']);
            }

        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }


    }
    public function getcity($id)
    {
        try{

            if ($id)
            {
                $get_city = City::where('country_id',$id)->orderBy('name','asc')->get();
                if(count($get_city) > 0)
                {
                    return response()->json(['status'=>true,'message'=>'Get all city successfully!','data'=>$get_city]);


                }else
                {
                    return response()->json(['status'=>false,'message'=>'City Not Found!']);
                }
            }else
            {
                return response()->json(['status'=>false,'message'=>'Country id Not Found']);
            }

        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }




    }

    public function getlocation($id)
    {
        try{

            if ($id)
        {
            $get_location = Location::where('city_id',$id)->where('name','!=','Error')->orderBy('name','asc')->get();
            if(count($get_location) > 0)
            {
                return response()->json(['status'=>true,'message'=>'Get all location successfully!','data'=>$get_location]);

            }else
            {
                return response()->json(['status'=>false,'message'=>'Location Not Found!']);
            }
        }else
        {
            return response()->json(['status'=>false,'message'=>'City Id Not Found!']);
        }


        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }


    }

}
