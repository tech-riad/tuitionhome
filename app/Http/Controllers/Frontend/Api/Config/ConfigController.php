<?php

namespace App\Http\Controllers\Frontend\Api\Config;

use App\Http\Controllers\Controller;
use App\Models\Counting;
use App\Models\Curriculam;
use App\Models\Day;
use App\Models\Degree;
use App\Models\Department;
use App\Models\PopupImage;
use App\Models\PwaDownload;
use App\Models\Study;
use App\Models\TeachingMethod;
use App\Models\WebLead;
use App\Models\WebsiteReview;
use Exception;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConfigController extends Controller
{
    use ApiResponse;
    public function allDepartment()
    {
       try
       {
        $departments = Department::all();
        return $this->resposeSuccess('data get successfully',$departments);
       }catch(Exception $e)
       {
        return $this->resposeError('',$e->getMessage());
       }

    }



    public function allConfigData()
    {
        try
        {
            $studies = Study::all();
            $days = Day::all();
            $degree = Degree::all();
            $curriculam = Curriculam::all();
            $teaching_method = TeachingMethod::all();

          $config_data =[
            'studies' =>$studies,
            'days' => $days,
            'degrees' => $degree,
            'curriculams' => $curriculam,
            'teaching_methods' => $teaching_method,
          ];
        return $this->resposeSuccess('data get successfully',$config_data);
        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }
    }

    public function hireTutor(Request $request)
    {

        $validator = Validator()->make($request->all(), [
            'phone' => 'required|regex:/^(01)[0-9]{9}$/'

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        $webLead = new WebLead();
        $webLead->name = $request->name;
        $webLead->location = $request->location;
        $webLead->class = $request->class;
        $webLead->tutor_gender = $request->tutor_gender;
        $webLead->phone = $request->phone;
        $webLead->save();

        return response()->json(['message' => 'Your requirement sent successfully.']);





    }
    public function pwaCount(Request $request)
    {
        $count = PwaDownload::firstOrCreate([], ['count' => 0]);
        $count->increment('count');

    }

    public function pwaCountGet()
    {
        $count = PwaDownload::value('count');
        return response()->json(['success' => true, 'count' => $count]);

    }

    public function webReviewGet()
    {
        $reviews = WebsiteReview::where('status', 1)->get();

        if ($reviews->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No reviews found'
            ]);
        }

        $reviews->transform(function ($review) {

            $review->image = $review->image
                ? Storage::disk('r2')->url( $review->image)
                : null;

            return $review;
        });

        return response()->json([
            'success' => true,
            'reviews' => $reviews
        ]);
    }

    public function popupImageGet()
    {
        $popup = PopupImage::where('status', 1)->get();

        if ($popup->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No active popup found'
            ]);
        }

        $popup->transform(function ($item) {

            $item->image = $item->image
                ? Storage::disk('r2')->url( $item->image)
                : null;

            return $item;
        });

        return response()->json([
            'success' => true,
            'popup' => $popup
        ]);
    }

    public function jobCounting(Request $request)
    {
        $tutorId = $request->tutor_id;
        $countings = Counting::where('tutor_id',$tutorId)->first();

        return $this->resposeSuccess('Data get successfully', [
            'tutor_id'        => optional($countings)->tutor_id,
            'applied_job'     => optional($countings)->applied_job ?? 0,
            'shortlisted_job' => optional($countings)->shortlisted_job ?? 0,
            'appointed_job'   => optional($countings)->appointed_job ?? 0,
            'confirmed_job'   => optional($countings)->confirmed_job ?? 0,
            'cancel_job'      => optional($countings)->cancel_job ?? 0,
            'payment_job'     => optional($countings)->payment_job ?? 0,
            'refund_job'      => optional($countings)->refund_job ?? 0,
        ]);

    }
}
