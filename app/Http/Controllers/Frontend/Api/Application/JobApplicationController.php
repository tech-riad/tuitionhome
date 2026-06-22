<?php

namespace App\Http\Controllers\Frontend\Api\Application;

use App\Http\Controllers\Controller;
use App\Models\Counting;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\Tutor;
use App\Models\TutorPreferedLocation;
use Illuminate\Http\Request;
use Exception;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    use ApiResponse;
    public function apply(Request $request)
    {
        try {
            $tutor = Tutor::where('id', $request->tutor_id)->first();
            $dubliChecker = $tutor->job_applications()->where('job_offer_id', '=', $request->job_id)->first();
            $job_offer = JobOffer::where('id', $request->job_id)->first();

            if ($dubliChecker != null) {
                return $this->resposeError('Already applied to the job offer', '');
            }

            if ($tutor->isActive() == true) {
                if ($tutor->getProfileComplete() < 75) {
                    return $this->resposeError('Complete your tutor profile at least 75% & then apply', $tutor->getProfileComplete());
                }

                if ($job_offer->tutor_gender !== 'any' && $job_offer->tutor_gender !== $tutor->gender) {
                    return $this->resposeError('Tutor Gender Mismatch!', '');
                }

                if ($job_offer->teaching_method_id != 2 && $job_offer->city_id != $tutor->tutor_personal_info->city_id) {
                    return $this->resposeError('Tutor City Mismatch!', '');
                }

            } else {
                return $this->resposeError('Please activate your profile!', '');
            }

            $job_application = new JobApplication();
            $job_application->tutor_id = $request->tutor_id;
            $job_application->job_offer_id = $request->job_id;
            $job_application->save();

            $job_offer->increment('total_application');
            $job_offer->save();


            $counting = Counting::where('tutor_id', $request->tutor_id)->first();
            $counting->applied_job = $counting->applied_job + 1;
            $counting->save();


            return $this->resposeSuccess('Your Job Applied Successfully Done...', '');
        } catch (Exception $e) {
            return $this->resposeError('', $e->getMessage());
        }


    }

    public function counting()
    {

        $id = Auth::user()->id;

        $all_job_applied = JobApplication::where('tutor_id', $id)->count();

        $appointed = JobApplication::where('tutor_id', $id)
            ->whereNotNull('trial_date_1st')
            ->count();

        $calcel = JobApplication::where('tutor_id', $id)
            ->whereNotNull('cancel_stage')
            ->count();

        $confirm = JobApplication::where('tutor_id', $id)
            ->whereNotNull('confirm_date')
            ->count();

        $shortlisted = JobApplication::where('tutor_id', $id)
            ->whereNotNull('taken_at')
            ->count();

            $prefered_locations = TutorPreferedLocation::where('tutor_id', $id)->pluck('location_id');

        $jobOffers = JobOffer::whereIn('location_id', $prefered_locations)
                                ->where('is_active', 1)
                                ->count();

        $response = [
            'applied' => $all_job_applied,
            'appointed' => $appointed,
            'calcel' => $calcel,
            'confirm' => $confirm,
            'shortlisted' => $shortlisted,
            'shortlisted' => $shortlisted,
            'preferedLocationJob' => $jobOffers,
        ];

        return response()->json(['data' => $response], 200);
    }


}