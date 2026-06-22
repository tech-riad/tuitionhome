<?php
namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ApiResponse{

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'=>false,
            'message'=>'validation error',
            'errors'=> $validator->errors()
        ]));
    }


    public function resposeSuccess($message="Successfull",$data)
    {
        return response()->json([
            'status'=>true,
            'message'=>$message,
            'data'=>$data,
            'errors'=> null
        ]);
    }

    public function resposeError($message = "Something went wrong",$error)
    {
        return response()->json([
            'status'=>false,
            'message'=>$message,
            'errors'=> $error
        ]);
    }
}
