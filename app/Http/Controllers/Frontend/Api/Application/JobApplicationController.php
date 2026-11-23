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
            $tutor = Tutor::with(['tutor_personal_info', 'tutor_education'])
                ->where('id', $request->tutor_id)
                ->first();

            if (!$tutor) {
                return $this->resposeError('Tutor not found.', '');
            }

            $job_offer = JobOffer::where('id', $request->job_id)->first();

            if (!$job_offer) {
                return $this->resposeError('Job offer not found.', '');
            }

            $dubliChecker = $tutor->job_applications()
                ->where('job_offer_id', $job_offer->id)
                ->first();

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

                if ($job_offer->teaching_method_id != 2
                    && (!$tutor->tutor_personal_info || $job_offer->city_id != $tutor->tutor_personal_info->city_id)) {
                    return $this->resposeError('Tutor City Mismatch!', '');
                }

                $honoursEducation = $tutor->tutor_education->firstWhere('degree_name', 'honours');
                $schoolEducation = $tutor->tutor_education->whereIn('degree_name', ['ssc', 'hsc']);

                if ($job_offer->tutor_university_type
                    && !$this->matchesCommaSeparatedRequirement(
                        $job_offer->tutor_university_type,
                        optional($honoursEducation)->university_type
                    )) {
                    return $this->resposeError(
                        'Your University Type does not match this job requirement.',
                        ''
                    );
                }

                $requiredStudyTypeIds = $job_offer->job_offer_tutor_study_types->pluck('id')->map(function ($id) {
                    return (string) $id;
                })->all();

                if ($requiredStudyTypeIds
                    && (!$honoursEducation
                        || !in_array((string) $honoursEducation->study_type_id, $requiredStudyTypeIds, true))) {
                    return $this->resposeError(
                        'Your Study Type does not match this job requirement.',
                        ''
                    );
                }

                if ($job_offer->tutor_curriculam_id
                    && !$tutor->tutor_education->contains(function ($education) use ($job_offer) {
                        return (string) $education->curriculum_id === (string) $job_offer->tutor_curriculam_id;
                    })) {
                    return $this->resposeError(
                        'Your Background Curriculum does not match this job requirement. ',
                        ''
                    );
                }

                if ($job_offer->tutor_religion
                    && strtolower(trim((string) optional($tutor->tutor_personal_info)->religion))
                        !== strtolower(trim($job_offer->tutor_religion))) {
                    return $this->resposeError(
                        'Your Religion does not match this job requirement.',
                        ''
                    );
                }

                if ($job_offer->tutor_group
                    && !$schoolEducation->contains(function ($education) use ($job_offer) {
                        return strtolower(trim((string) $education->group_or_major))
                            === strtolower(trim($job_offer->tutor_group));
                    })) {
                    return $this->resposeError(
                        'Your Group does not match this job requirement.',
                        ''
                    );
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

    private function matchesCommaSeparatedRequirement($requiredValues, $tutorValue)
    {
        if ($tutorValue === null || trim((string) $tutorValue) === '') {
            return false;
        }

        $requiredValues = array_map('trim', explode(',', $requiredValues));

        return in_array(
            strtolower(trim((string) $tutorValue)),
            array_map('strtolower', $requiredValues),
            true
        );
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
