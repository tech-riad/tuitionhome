<?php

namespace App\Http\Controllers\Backend\Tutor;

use App\Console\Commands\AdvanceSearchSms;
use App\Http\Controllers\Controller;
use App\Jobs\SendBulkSms;
use App\Mail\ActiveDeactiveMail;
use App\Models\AdvanceSearchSms as ModelsAdvanceSearchSms;
use App\Models\Tutor;
use App\Models\Counting;
use App\Models\InactiveTutor;
use App\Models\Category;
use App\Models\City;
use App\Models\TutorAlertNote;
use App\Models\User;
use App\Models\Country;
use App\Models\Course;
use App\Models\SmsRecharge;
use App\Models\SendSms;
use App\Models\Department;
use App\Models\Institute;
use App\Models\TutorTeachingMethod;
use App\Models\Location;
use App\Models\TeachingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;
use App\Models\Study;
use App\Models\JobSms;
use App\Models\Subject;
use App\Models\SmsBalance;
use App\Models\Curriculam;
use App\Models\CourseSubject;
use App\Models\Day;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\TutorCategory;
use App\Models\TutorEducation;
use App\Models\TutorPersonalInfo;
use App\Models\PremiumMembership;
use App\Models\Sms;
use Doctrine\DBAL\Query\QueryException;
use App\Models\TutorCertificate;
use App\Models\TutorDeleteNote;
use App\Models\TutorLog;
use App\Models\TutorNote;
use App\Models\ApplicationPayment;
use App\Models\DuePayments;
use App\Models\Reffer;
use App\Models\TutorAccount;
use App\Models\TutorReview;
use App\Models\TutorStatusNote;
use App\Models\VerificationRequest;
use Carbon\Carbon;
use Exception;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Image;
use PDF;
use Illuminate\Support\Facades\Queue;

use Illuminate\Support\Facades\Cache;


class BackendTutorController extends Controller
{
    public function refferAdd(Request $request, $id)
    {
        $request->validate([
            'tutor_id' => 'required',
            'job_id' => 'nullable',
        ]);

        $reffer = new Reffer();
        $reffer->tutor_id = $id;
        $reffer->added_by = Auth::user()->id;
        $reffer->reffer_for = $request->tutor_id;
        $reffer->job_id = $request->job_id;
        $reffer->save();

        return response()->json(['success' => true]);
    }

    public function invoiceView(Request $request, $invoice_no)
    {
        $paymentInvoice = ApplicationPayment::with('tutor')
                            ->where('id', $invoice_no)
                            ->where('service_category', 'service charge')
                            ->where('in_out', 'received')
                            ->first();

        if (!$paymentInvoice) {
            return back()->with('error', 'Invoice not found.');
        }

        $invoiceData = [
            'id'              => $paymentInvoice->id,
            'invoiceNo'       => 'TM0' . $paymentInvoice->id,
            'tutorId'       => 'TM0' . $paymentInvoice->tutor_id,
            'tutorName'       => $paymentInvoice->tutor->name ?? 'N/A',
            'tutorEmail'      => $paymentInvoice->tutor->email ?? 'N/A',
            'serviceCategory' => $paymentInvoice->service_category,
            'jobId'           => $paymentInvoice->job_offer_id ?? 'N/A',
            'tutorId'         => $paymentInvoice->tutor->unique_id ?? 'N/A',
            'createdDate'     => optional($paymentInvoice->created_at)->toDateString() ?? 'N/A',
            'amount'          => $paymentInvoice->received_amount,
        ];

        return view('backend.tutor.invoice_view', compact('invoice_no', 'invoiceData'));
    }

    public function paymentInvoice(Request $request,$id)
    {
            $paymentInvoices = ApplicationPayment::where('tutor_id', $id)
                            ->where('service_category', 'service charge')
                            ->where('in_out', 'received')
                            ->get();

            $invoiceData = [];

            foreach ($paymentInvoices as $invoice) {
                $invoiceData[] = [
                    'id'              => $invoice->id,
                    'invoiceNo'       => 'TM0' . $invoice->id,
                    'tutorName'       => $invoice->tutor->name,
                    'tutorEmail'       => $invoice->tutor->email,
                    'serviceCategory' => $invoice->service_category,
                    'jobId'           => $invoice->job_offer_id,
                    'tutorId'         => $invoice->tutor->unique_id,
                    'createdDate'     => optional($invoice->created_at)->toDateString() ?? 'N/A',
                    'amount'          => $invoice->received_amount,
                ];
            }

            return view('backend.tutor.payment_invoice',compact('id','invoiceData'));



    }
    public function refundInvoice(Request $request,$id)
    {
        $refunds = DuePayments::where('tutor_id', $id)
        ->where('service_category', 'Refund')
        ->where('in_out', 'out')
        ->get();

        $refundData = [];

        foreach ($refunds as $refund) {
        $refundData[] = [
        'invoiceNo'       => 'TM0' . $refund->id,
        'serviceCategory' => 'Service Charge',
        'jobId'           => $refund->job_id ?? 'N/A',
        'tutorId'         => optional($refund->tutor)->unique_id ?? 'N/A',
        'createdDate'     => optional($refund->created_at)->toDateString() ?? 'N/A',
        'amount'          => $refund->amount ?? 0,
        'refundStatus'    => $refund->payment_status ?? 'N/A',
        'pendingDate'     => optional($refund->job)->refund_date ?? 'N/A',
        'paidDate'        => $refund->paid_date,
        'paymentAmount'   => $refund->payment_amount,
        'refundCoin'      => $refund->refund_coin,
        ];
        }


        return view('backend.tutor.refund_invoice',compact('id','refundData'));



    }
    public function accountAdd(Request $request,$id)
    {


            $existingRecord = TutorAccount::where('tutor_id', $id)->first();

            if ($request->provider == 'mobile_banking') {
                if ($existingRecord) {
                    $existingRecord->update([
                        'number' => $request->number,
                        'account_type' => $request->account_type,
                        'account_name' => $request->account_name,
                    ]);
                } else {
                    TutorAccount::create([
                        'tutor_id' => $id,
                        'number' => $request->number,
                        'account_type' => $request->account_type,
                        'account_name' => $request->account_name,
                    ]);
                }
                return response()->json(['message' => 'Successfull.']);

            } elseif ($request->provider == 'bank') {
                if ($existingRecord) {
                    $existingRecord->update([
                        'b_account_number' => $request->b_account_number,
                        'b_account_type' => $request->b_account_type,
                        'b_branch_name' => $request->b_branch_name,
                        'b_account_name' => $request->b_account_name,
                    ]);
                } else {
                    TutorAccount::create([
                        'tutor_id' => $id,
                        'b_account_number' => $request->b_account_number,
                        'b_account_type' => $request->b_account_type,
                        'b_branch_name' => $request->b_branch_name,
                        'b_account_name' => $request->b_account_name,
                    ]);
                }
                return response()->json(['message' => 'Successfull.']);

            }


    }
    public function paymentMethod($id)
    {
        $tutorAccount = TutorAccount::where('tutor_id', $id)->first();



        return view('backend.tutor.payment_method',compact('id','tutorAccount'));
    }
    public function refundTrxHistory($id)
    {
        $transctions = DuePayments::where('tutor_id', $id)
                            ->where('service_category', 'Refund')
                            ->where('in_out', 'out')
                            ->where(DB::raw('payment_amount + refund_coin'), DB::raw('amount'))
                            ->orderBy('id','desc')
                            ->paginate(20);


        return view('backend.tutor.refund_trx_history',compact('id','transctions'));
    }
    public function membershiptTrxHistory($id)
    {
        $transctions = ApplicationPayment::where('tutor_id', $id)
                            ->where('service_category', '!=', 'service charge')
                            ->orderBy('id','desc')
                            ->paginate(20);

        return view('backend.tutor.member_trx_history',compact('id','transctions'));
    }
    public function trxPayHistory($id)
    {
        $transctions = ApplicationPayment::where('tutor_id', $id)
                            ->where('service_category', 'service charge')
                            ->where('in_out', 'received')
                            ->orderBy('id', 'desc')
                            ->paginate(20);

        return view('backend.tutor.trx_history',compact('id','transctions'));
    }

    public function counting()
    {
        $all_tutor_count       = DB::table('tutors')->count();
        $male_tutor_count      = Tutor::where('gender', 'male')->where('is_active',1)->count();
        $female_tutor_count    = Tutor::where('gender', 'female')->where('is_active',1)->count();
        $premium_tutor_count   = Tutor::where('is_premium', '=', 1)->where('is_active',1)->count();
        $featured_tutor_count  = Tutor::where('is_featured', '=', 1)->where('is_active',1)->count();

        $uniqueTutorsTakenToday = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_taken_today'))
        ->whereDate('taken_at', now())
        ->first();
        $uniqueTutorsShortlistedToday = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_shortlisted_today'))
        ->whereDate('shortlisted_date', now())
        ->first();
        $unique_tutors_confirmed = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_confirmed'))
        ->whereNotNull('confirm_date')
        ->first();
        $unique_tutors_applied = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_applied'))
        ->first();
        $all_tutor_confirm = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_confirm'))
        ->where('current_stage','confirm')
        ->count();
        return view('backend.tutor.counting',compact('all_tutor_count', 'male_tutor_count',
            'female_tutor_count', 'premium_tutor_count', 'featured_tutor_count', 'uniqueTutorsShortlistedToday','uniqueTutorsTakenToday'
            ,'unique_tutors_confirmed','unique_tutors_applied','all_tutor_confirm'));

    }

    public function smsBalanceAdd()
    {
        $tutorIds = [];
        $tutors = Tutor::where('is_active', 1)->get();

        foreach ($tutors as $tutor) {
            $tutorIds[] = $tutor->id;
        }

        foreach ($tutorIds as $tutorId) {
            $smsBalance = SmsBalance::where('tutor_id', $tutorId)->first();

            if (!$smsBalance) {
                $newSmsBalance = new SmsBalance();
                $newSmsBalance->tutor_id = $tutorId;
                $newSmsBalance->save();
            }
        }

        $updatedTutorIds = SmsBalance::whereIn('tutor_id', $tutorIds)->pluck('tutor_id')->toArray();

        return response()->json([
            'tutorIds' => $updatedTutorIds
        ]);
    }

//     public function updateStatus(Request $request, $id)
// {
//     $request->validate([
//         'status' => 'required|in:0,1',
//         'changed_note' => 'nullable|string',
//     ]);

//     $isInactive = InactiveTutor::where('id', $id)->exists();

//     if ($isInactive) {
//         $tutor = InactiveTutor::findOrFail($id);
//     } else {
//         $tutor = Tutor::findOrFail($id);
//     }

//     $tutor->is_active = $request->status;
//     $tutor->is_sms = $request->status;

//     if ($request->status == 0) {
//         $tutor->deactivate_by_admin = Auth::id();
//     } else {
//         $tutor->deactivate_by_admin = null;
//     }

//     $tutor->save();

//     if ($isInactive) {
//         Tutor::updateOrCreate(['id' => $tutor->id], $tutor->toArray());
//         $tutor->delete();
//     }
//     TutorStatusNote::create([
//         'tutor_id' => $tutor->id,
//         'changed_by' => auth()->user()->name,
//         'status' => $request->status,
//         'changed_note' => $request->changed_note,
//     ]);

//     return response()->json(['message' => 'Tutor status updated successfully']);
// }

public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1',
            'changed_note' => 'nullable|string',
        ]);

        $tutor = Tutor::findOrFail($id);
        $tutor->is_active     = $request->status;
        $tutor->is_sms        = $request->status;
        if($request->status == 0)
        {
            $tutor->deactivate_by_admin = Auth::user()->id;
            $tutor->inactive_date = now();
        }
        if($request->status == 1)
        {
            $tutor->deactivate_by_admin = null;
            $tutor->is_sms = 1;
        }
        $tutor->save();

        TutorStatusNote::create([
            'tutor_id'      => $id,
            'changed_by'    => auth()->user()->name,
            'status'        => $request->status,
            'changed_note'  => $request->changed_note,
        ]);

        return response()->json(['message' => 'Tutor status updated successfully']);
    }

    public function tutorNote(Request $request)
    {
        $request->validate([
            'tutor_id' => 'required|integer',
            'note'     => 'required|string',
        ]);

        $note = new TutorNote();

        $note->tutor_id   = $request->tutor_id;
        $note->body       = $request->note;
        $note->created_by = Auth::user()->name;

        $note->save();

        return response()->json([
            'status'  => true,
            'message' => 'Note added successfully!',
            'data'    => $note
        ]);
    }

    public function getNote(Request $request)
    {
        return response()->json([
            'request_id' => $request->id,
            'notes' => TutorNote::where('tutor_id', $request->id)
                ->orderBy('id', 'desc')
                ->get(),
        ]);
    }



    public function filter(Request $request)
    {

        // dd($request->all());

        $input = $request->input('pagination_limit') ?? 200;



        $countryId              = $request->country_id;
        $cityId                 = $request->city_id;
        $locationId             = $request->location_id;
        $dateFrom               = $request->datef;
        $dateTo                 = $request->datet;
        $year                   = $request->year;
        $gender                 = $request->gender;
        $catId                  = $request->category_id;
        $courseId               = $request->course_id;
        $subId                  = $request->method_id;
        $studyType              = $request->study_type_id;
        $SscCurriculmnId        = $request->ssc_curriculum_id;
        $HscCurriculmnId        = $request->hsc_curriculum_id;
        $universityType         = $request->tutor_university_type;
        $honoursUniversity      = $request->honours_institute_id;
        $honoursDeptId          = $request->department_id;
        $preLocationId          = $request->pre_location_id;
        $religion               = $request->religion;
        $tutoringExp            = $request->tutoring_experience;
        $bloodGroup             = $request->blood_group;
        $salary                 = $request->expected_salary;
        $sscInstitute           = $request->ssc_institute_id;
        $hscInstitute           = $request->hsc_institute_id;
        $sscGroup               = $request->ssc_group_or_major;
        $hscGroup               = $request->hsc_group_or_major;
        $sscBoard               = $request->education_board_ssc;
        $hscBoard               = $request->hsc_education_board;
        $teachingMethod         = $request->method_id;

        $tutorsQuery = Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
        ])
        ->where ('is_active' , 1)
        ->where ('is_sms' , 1);

        if ($request->input('is_premium') == 1) {
            $tutorsQuery->where('is_premium', 1);
        }
        if ($request->input('is_verified') == 1) {
            $tutorsQuery->where('is_verified', 1);
        }
        if ($countryId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($countryId) {
                $subQuery->where('country_id', $countryId);
            });
        }
        if ($cityId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($cityId) {
                $subQuery->where('city_id', $cityId);
            });
        }
        if ($locationId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($locationId) {
                $subQuery->where('location_id', $locationId);
            });
        }
        if ($teachingMethod !== 'select Teaching Method') {
            $tutorsQuery->whereHas('teaching_method', function ($subQuery) use ($teachingMethod) {
                $subQuery->where('method_id', $teachingMethod);
            });
        }
        if ($religion !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($religion) {
                $subQuery->where('religion', $religion);
            });
        }
        if ($bloodGroup !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($bloodGroup) {
                $subQuery->where('blood_group', $bloodGroup);
            });
        }
        if ($tutoringExp !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($tutoringExp) {
                $subQuery->where('tutoring_experience', $tutoringExp);
            });
        }
        if ($salary !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($salary) {
                $subQuery->where('expected_salary', $salary);
            });
        }

        if ($dateFrom !== null) {
            if ($dateTo === null) {
                $dateTo = now()->toDateString();
            }

            $tutorsQuery->whereBetween('created_at', [$dateFrom, $dateTo]);
        }

        if ($year !== 'Select Year') {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($year) {
                $subQuery->where('degree_name', 'honours')
                         ->where('year_or_semester', $year);
            });
        }
        if ($SscCurriculmnId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($SscCurriculmnId) {
                $subQuery->where('degree_name', 'ssc')
                         ->where('curriculum_id', $SscCurriculmnId);
            });
        }
        if ($HscCurriculmnId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($HscCurriculmnId) {
                $subQuery->where('degree_name', 'hsc')
                         ->where('curriculum_id', $HscCurriculmnId);
            });
        }
        if ($gender !== null) {
            $tutorsQuery->where('gender', $gender);
        }
        if ($catId !== null && is_array($catId) && count($catId) > 0) {
            $tutorsQuery->whereHas('tutor_categories', function ($subQuery) use ($catId) {
                $subQuery->whereIn('category_id', $catId);
            });
        }
        if ($courseId !== null && is_array($courseId) && count($courseId) > 0) {
            $tutorsQuery->whereHas('tutor_course', function ($subQuery) use ($courseId) {
                $subQuery->whereIn('course_id', $courseId);
            });
        }
        if ($subId !== null && is_array($subId) && count($subId) > 0) {
            $tutorsQuery->whereHas('tutor_subject', function ($subQuery) use ($subId) {
                $subQuery->whereIn('subject_id', $subId);
            });
        }
        if ($studyType !== null && is_array($studyType) && count($studyType) > 0) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($studyType) {
                $subQuery->whereIn('study_type_id', $studyType);
            });
        }
        if ($universityType !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($universityType) {
                $subQuery->where('degree_name', 'honours')
                         ->where('university_type', $universityType);
            });
        }
        if ($honoursUniversity !== null && is_array($honoursUniversity) && count($honoursUniversity) > 0) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($honoursUniversity) {
                $subQuery->where('degree_name', 'honours')
                         ->whereIn('institute_id', $honoursUniversity);
            });
        }
        if ($honoursDeptId !== null && is_array($honoursDeptId) && count($honoursDeptId) > 0) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($honoursDeptId) {
                $subQuery->where('degree_name', 'honours')
                         ->whereIn('department_id', $honoursDeptId);
            });
        }

        if ($preLocationId !== null && is_array($preLocationId) && count($preLocationId) > 0) {
            $tutorsQuery->whereHas('tutor_prefered_locations', function ($subQuery) use ($preLocationId) {
                $subQuery->whereIn('location_id', $preLocationId);
            });
        }

        if ($sscInstitute !== null ) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscInstitute) {
                $subQuery->where('degree_name', 'ssc')
                         ->where('institute_id', $sscInstitute);
            });
        }
        if ($hscInstitute !== null ) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($hscInstitute) {
                $subQuery->where('degree_name', 'hsc')
                         ->where('institute_id', $hscInstitute);
            });
        }
        if ($sscGroup !== null ) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscGroup) {
                $subQuery->where('degree_name', 'ssc')
                         ->where('group_or_major', $sscGroup);
            });
        }
        if ($hscGroup !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($hscGroup) {
                $subQuery->where('degree_name', 'hsc')
                         ->where('group_or_major', $hscGroup);
            });
        }
        if ($sscBoard !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscBoard) {
                $subQuery->where('degree_name', 'ssc')
                         ->where('education_board', $sscBoard);
            });
        }
        if ($hscBoard !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($hscBoard) {
                $subQuery->where('degree_name', 'hsc')
                         ->where('education_board', $hscBoard);
            });
        }

        $tutors = $tutorsQuery->orderBy('id', 'desc')
        ->paginate($input);
          return view('backend.tutor.advanceSearch', compact('input','tutors'));


    }
    public function filterTrashTutor(Request $request)
    {


        $input = $request->input('pagination_limit') ?? 200;



        $countryId              = $request->country_id;
        $cityId                 = $request->city_id;
        $locationId             = $request->location_id;
        $dateFrom               = $request->datef;
        $dateTo                 = $request->datet;
        $year                   = $request->year;
        $gender                 = $request->gender;
        $catId                  = $request->category_id;
        $courseId               = $request->course_id;
        $subId                  = $request->method_id;
        $studyType              = $request->study_type_id;
        $SscCurriculmnId        = $request->ssc_curriculum_id;
        $HscCurriculmnId        = $request->hsc_curriculum_id;
        $universityType         = $request->tutor_university_type;
        $honoursUniversity      = $request->honours_institute_id;
        $honoursDeptId          = $request->department_id;
        $preLocationId          = $request->pre_location_id;
        $religion               = $request->religion;
        $tutoringExp            = $request->tutoring_experience;
        $bloodGroup             = $request->blood_group;
        $salary                 = $request->expected_salary;
        $sscInstitute           = $request->ssc_institute_id;
        $hscInstitute           = $request->hsc_institute_id;
        $sscGroup               = $request->ssc_group_or_major;
        $hscGroup               = $request->hsc_group_or_major;
        $sscBoard               = $request->education_board_ssc;
        $hscBoard               = $request->hsc_education_board;
        $teachingMethod         = $request->method_id;

          $tutorsQuery = Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
        ])
        ->where ('is_active' , 0);

        if ($countryId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($countryId) {
                $subQuery->where('country_id', $countryId);
            });
        }
        if ($cityId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($cityId) {
                $subQuery->where('city_id', $cityId);
            });
        }
        if ($locationId !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($locationId) {
                $subQuery->where('location_id', $locationId);
            });
        }
        if ($teachingMethod !== 'select Teaching Method') {
            $tutorsQuery->whereHas('teaching_method', function ($subQuery) use ($teachingMethod) {
                $subQuery->where('method_id', $teachingMethod);
            });
        }
        if ($religion !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($religion) {
                $subQuery->where('religion', $religion);
            });
        }
        if ($bloodGroup !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($bloodGroup) {
                $subQuery->where('blood_group', $bloodGroup);
            });
        }
        if ($tutoringExp !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($tutoringExp) {
                $subQuery->where('tutoring_experience', $tutoringExp);
            });
        }
        if ($salary !== null) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($salary) {
                $subQuery->where('expected_salary', $salary);
            });
        }

        if ($dateFrom !== null) {
            if ($dateTo === null) {
                $dateTo = now()->toDateString();
            }

            $tutorsQuery->whereBetween('created_at', [$dateFrom, $dateTo]);
        }

        if ($year !== 'Select Year') {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($year) {
                $subQuery->where('degree_name', 'honours')
                         ->where('year_or_semester', $year);
            });
        }
        if ($SscCurriculmnId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($SscCurriculmnId) {
                $subQuery->where('degree_name', 'ssc')
                         ->where('curriculum_id', $SscCurriculmnId);
            });
        }
        if ($HscCurriculmnId !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($HscCurriculmnId) {
                $subQuery->where('degree_name', 'hsc')
                         ->where('curriculum_id', $HscCurriculmnId);
            });
        }
        if ($gender !== null) {
            $tutorsQuery->where('gender', $gender);
        }
        if ($catId !== null && is_array($catId) && count($catId) > 0) {
            $tutorsQuery->whereHas('tutor_categories', function ($subQuery) use ($catId) {
                $subQuery->whereIn('category_id', $catId);
            });
        }
        if ($courseId !== null && is_array($courseId) && count($courseId) > 0) {
            $tutorsQuery->whereHas('tutor_subject', function ($subQuery) use ($courseId) {
                $subQuery->whereIn('course_id', $courseId);
            });
        }
        if ($subId !== null && is_array($subId) && count($subId) > 0) {
            $tutorsQuery->whereHas('tutor_course', function ($subQuery) use ($subId) {
                $subQuery->whereIn('subject_id', $subId);
            });
        }
        if ($studyType !== null && is_array($studyType) && count($studyType) > 0) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($studyType) {
                $subQuery->whereIn('study_type_id', $studyType);
            });
        }
        if ($universityType !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($universityType) {
                $subQuery->where('degree_name', 'honours')
                         ->where('university_type', $universityType);
            });
        }
        if ($honoursUniversity !== null && is_array($honoursUniversity) && count($honoursUniversity) > 0) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($honoursUniversity) {
                $subQuery->where('degree_name', 'honours')
                         ->whereIn('institute_id', $honoursUniversity);
            });
        }
        if ($honoursDeptId !== null && is_array($honoursDeptId) && count($honoursDeptId) > 0) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($honoursDeptId) {
                $subQuery->where('degree_name', 'honours')
                         ->whereIn('department_id', $honoursDeptId);
            });
        }

        if ($preLocationId !== null && is_array($preLocationId) && count($preLocationId) > 0) {
            $tutorsQuery->whereHas('tutor_prefered_locations', function ($subQuery) use ($preLocationId) {
                $subQuery->whereIn('location_id', $preLocationId);
            });
        }

        if ($sscInstitute !== null ) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscInstitute) {
                $subQuery->where('degree_name', 'ssc')
                         ->where('institute_id', $sscInstitute);
            });
        }
        if ($hscInstitute !== null ) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($hscInstitute) {
                $subQuery->where('degree_name', 'hsc')
                         ->where('institute_id', $hscInstitute);
            });
        }
        if ($sscGroup !== null ) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscGroup) {
                $subQuery->where('degree_name', 'ssc')
                         ->where('group_or_major', $sscGroup);
            });
        }
        if ($hscGroup !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($hscGroup) {
                $subQuery->where('degree_name', 'hsc')
                         ->where('group_or_major', $hscGroup);
            });
        }
        if ($sscBoard !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($sscBoard) {
                $subQuery->where('degree_name', 'ssc')
                         ->where('education_board', $sscBoard);
            });
        }
        if ($hscBoard !== null) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($hscBoard) {
                $subQuery->where('degree_name', 'hsc')
                         ->where('education_board', $hscBoard);
            });
        }

        $tutors = $tutorsQuery->orderBy('id', 'desc')
        ->paginate($input);
          return view('backend.tutor.advanceSearch', compact('input','tutors'));


    }
    // public function cvPdf($tutor)
    // {

    //     $tutor = Tutor::with([
    //         'tutor_personal_info',
    //         'tutor_education',
    //         'tutor_prefered_locations',
    //         'tutor_course',
    //         'tutor_subject',
    //         'tutor_categories',
    //     ])->where('id',$tutor)->first();
    //     // dd($tutor->toArray());
    //     $pdf = PDF::loadView('backend.tutor.cv',compact('tutor'));

    //     return $pdf->stream('cv.pdf');

    // }
    public function cvPdf($tutorId)
    {
        $tutor = Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
        ])->find($tutorId);

        if (!$tutor) {
            return response()->json(['error' => 'Tutor not found'], 404);
        }


        // For MSC
            $tutorUniversityMsc = null;
            $tutorEducationMasters = $tutor->tutor_education->where('degree_name', "masters")->first();

        if ($tutorEducationMasters) {
            $instituteMasters = Institute::where('id', $tutorEducationMasters->institute_id)->first();
            if ($instituteMasters) {
                $tutorUniversityMsc = $instituteMasters->title;
            }
        }
        if ($tutorEducationMasters) {
            $departmentMsc = Department::where('id', $tutorEducationMasters->department_id)->first();
            if ($departmentMsc) {
                $tutorUnidepartmentMsc = $departmentMsc->title;
            }
        }
        // For BSC
            $tutorUniversity = null;
            $tutorEducationHonours = $tutor->tutor_education->where('degree_name', "honours")->first();

        if ($tutorEducationHonours) {
            $institute = Institute::where('id', $tutorEducationHonours->institute_id)->first();
            if ($institute) {
                $tutorUniversity = $institute->title;
            }
        }
        if ($tutorEducationHonours) {
            $department = Department::where('id', $tutorEducationHonours->department_id)->first();
            if ($institute) {
                $tutorUnidepartment = $department->title;
            }
        }

        // For HSC

        $tutorHscIns = null;
        $tutorEducationHSC     = $tutor->tutor_education->where('degree_name', "hsc")->first();


        if ($tutorEducationHSC) {
            $institute = Institute::where('id', $tutorEducationHSC->institute_id)->first();
            if ($institute) {
                $tutorHscIns = $institute->title;
            }
        }

        // For SSC

        $tutorSscIns = null;
        $tutorEducationSSC     = $tutor->tutor_education->where('degree_name', "ssc")->first();


        if ($tutorEducationSSC) {
            $institute = Institute::where('id', $tutorEducationSSC->institute_id)->first();
            if ($institute) {
                $tutorSscIns = $institute->title;
            }
        }




        $tutorData = [
            'tutorName'     => $tutor->name,
            'tutorId'       => $tutor->unique_id,
            'tutorImage'    => $tutor->image,
            'tutorUniversity'    => $tutorUniversity ?? 'N/A',
            'tutorDepartment'    => $tutorUnidepartment ?? 'N/A',
            'tutorPresentAddress'    => $tutor->tutor_personal_info->full_address ?? 'N/A',
            'tutorPermanentAddress'    => $tutor->tutor_personal_info->permanent_full_address ?? 'N/A',
            'tutorAbout'           => $tutor->tutor_personal_info->about_yourself ?? 'N/A',
            'tutorExperience'      => $tutor->tutor_personal_info->tutoring_experience_details ?? 'N/A',
            'tutorHiringReason'    => $tutor->tutor_personal_info->reason_hired ?? 'N/A',
            'tutorBscResult'       => $tutorEducationHonours->gpa ?? 'N/A',

            'tutorHscIns'       => $tutorHscIns ?? 'N/A',
            'tutorHscResult'    => $tutorEducationHSC->gpa ?? 'N/A',
            'tutorHscGroup'     => $tutorEducationHSC->group_or_major ?? 'N/A',

            'tutorSscIns'       => $tutorSscIns ?? 'N/A',
            'tutorSscResult'    => $tutorEducationHSC->gpa ?? 'N/A',
            'tutorSscGroup'     => $tutorEducationHSC->group_or_major ?? 'N/A',


            'tutorUniversityMsc'      => $tutorUniversityMsc ?? 'N/A',
            'tutorUnidepartmentMsc'   => $tutorUnidepartmentMsc ?? 'N/A',
            'tutorResultMsc'          => $tutorEducationMasters->gpa ?? 'N/A',
        ];

        $pdf = PDF::loadView('backend.tutor.cv', array_merge(compact('tutorData')));

        return $pdf->stream('cv.pdf');
    }
    public function updateCertificateFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "tutor_id"          => "required",
            "ssc_c"             => "mimes:jpg,jpeg,png,bmp|max:200",
            "ssc_m"             => "mimes:jpg,jpeg,png,bmp|max:200",
            "hsc_c"             => "mimes:jpg,jpeg,png,bmp|max:200",
            "hsc_m"             => "mimes:jpg,jpeg,png,bmp|max:200",
            "nid"               => "mimes:jpg,jpeg,png,bmp|max:200",
            "university_c"      => "mimes:jpg,jpeg,png,bmp|max:200",
            "cv"                => "mimes:jpg,jpeg,png,bmp,pdf|max:200",
            "others"            => "mimes:jpg,jpeg,png,bmp|max:200",
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        try {
            $tutor_id = $request->input('tutor_id');
            $t_certificate = TutorCertificate::where('tutor_id', $tutor_id)->first();

            if (!$t_certificate) {
                $t_certificate = new TutorCertificate();
            }

            // Upload SSC Certificate
            if ($request->hasFile('ssc_c')) {
                $ssc_c_name = $this->uploadImage($request->file('ssc_c'), $tutor_id);
                $t_certificate->ssc_c = $ssc_c_name;
            }

            // Upload SSC Marksheet
            if ($request->hasFile('ssc_m')) {
                $ssc_m_name = $this->uploadImage($request->file('ssc_m'), $tutor_id);
                $t_certificate->ssc_m = $ssc_m_name;
            }

            // Upload HSC Certificate
            if ($request->hasFile('hsc_c')) {
                $hsc_c_name = $this->uploadImage($request->file('hsc_c'), $tutor_id);
                $t_certificate->hsc_c = $hsc_c_name;
            }

            // Upload HSC Marksheet
            if ($request->hasFile('hsc_m')) {
                $hsc_m_name = $this->uploadImage($request->file('hsc_m'), $tutor_id);
                $t_certificate->hsc_m = $hsc_m_name;
            }

            // Upload NID/Passport/Birth Certificate
            if ($request->hasFile('nid')) {
                $nid_name = $this->uploadImage($request->file('nid'), $tutor_id);
                $t_certificate->nid = $nid_name;
            }

            // Upload Admission Slip/University ID Certificate
            if ($request->hasFile('university_c')) {
                $university_c_name = $this->uploadImage($request->file('university_c'), $tutor_id);
                $t_certificate->university_c = $university_c_name;
            }

            // Upload CV
            if ($request->hasFile('cv')) {
                $cv_name = $this->uploadImage($request->file('cv'), $tutor_id);
                $t_certificate->cv = $cv_name;
            }

            // Upload Others
            if ($request->hasFile('others')) {
                $others_name = $this->uploadImage($request->file('others'), $tutor_id);
                $t_certificate->others = $others_name;
            }

            $t_certificate->tutor_id = $tutor_id;
            $t_certificate->save();

            return response()->json(['status' => true, 'message' => 'Updated Successfully!']);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    // Helper method to upload image and return its name
    private function uploadImage($file, $tutor_id)
    {
        $image_name = $tutor_id . rand(1234, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/tutor-certificate', $image_name);
        return $image_name;
    }



    public function updateEducationalInfo(Request $request)
    {

        // $validator = Validator()->make($request->all(),[
        //     'ssc_institute_id' => 'required',



        // ]);
        // if ($validator->fails())
        // {
        //     return response()->json(['status'=>false,'error'=>$validator->errors()]);
        // }
        if($request['ssc_tutor_id']){

            try{

                    $tutor_id= $request['ssc_tutor_id'];
                    $tutor_ssc_info = TutorEducation::where('tutor_id', $tutor_id)->where('degree_name', 'ssc')->first();

                    if ($tutor_ssc_info) {

                        $tutor_ssc_info->institute_id=  $request->ssc_institute_id;
                        $tutor_ssc_info->education_board=  $request->ssc_board;
                        $tutor_ssc_info->passing_year=  $request->ssc_passing_year;
                        $tutor_ssc_info->curriculum_id=  $request->ssc_curriculum_id;
                        $tutor_ssc_info->group_or_major=  $request->ssc_group;
                        $tutor_ssc_info->gpa =  $request->ssc_result;
                        $tutor_ssc_info->update();

                        return response()->json(['status'=>true,'message'=>'updated Successfully!','data' =>$tutor_ssc_info]);

                        // return redirect()->back()->withMessage('Success! SSC information updated successfully');

                        }
                        else{
                            $addTutor_ssc_info = new TutorEducation();
                            $addTutor_ssc_info->tutor_id = $request->ssc_tutor_id;
                            $addTutor_ssc_info->degree_name = 'ssc';
                            $addTutor_ssc_info->institute_id=  $request->ssc_institute_id;
                            $addTutor_ssc_info->education_board=  $request->ssc_board;
                            $addTutor_ssc_info->passing_year=  $request->ssc_passing_year;
                            $addTutor_ssc_info->curriculum_id=  $request->ssc_curriculum_id;
                            $addTutor_ssc_info->group_or_major=  $request->ssc_group;
                            $addTutor_ssc_info->gpa =  $request->ssc_result;
                            $addTutor_ssc_info->save();

                            return response()->json(['status'=>true,'message'=>'added Successfully!','data' =>$addTutor_ssc_info]);

                            // return redirect()->back()->withMessage('Success! SSC information Added successfully');

                        }

            }
                catch (QueryException $e) {
                    return redirect()->back()->withInput()->withErrors($e->getMessage());
                }

        }
        if($request['hsc_tutor_id']){

            try{
                    $tutor_id= $request['hsc_tutor_id'];
                    $tutor_hsc_info = TutorEducation::where('tutor_id', $tutor_id)->where('degree_name', 'hsc')->first();


                    if ($tutor_hsc_info) {

                        $tutor_hsc_info->institute_id=  $request->hsc_institute_id;
                        $tutor_hsc_info->education_board=  $request->hsc_board;
                        $tutor_hsc_info->passing_year=  $request->hsc_passing_year;
                        $tutor_hsc_info->curriculum_id=  $request->hsc_curriculum_id;
                        $tutor_hsc_info->group_or_major=  $request->hsc_group;
                        $tutor_hsc_info->gpa =  $request->hsc_result;
                        $tutor_hsc_info->update();

                        return response()->json(['status'=>true,'message'=>'updated Successfully!','data' =>$tutor_hsc_info]);
                        // return redirect()->back()->withMessage('Success! HSC information updated successfully');

                        }
                        else{
                            $addTutor_hsc_info = new TutorEducation();
                            $addTutor_hsc_info->tutor_id = $request->hsc_tutor_id;
                            $addTutor_hsc_info->degree_name = 'hsc';
                            $addTutor_hsc_info->institute_id=  $request->hsc_institute_id;
                            $addTutor_hsc_info->education_board=  $request->hsc_board;
                            $addTutor_hsc_info->passing_year=  $request->hsc_passing_year;
                            $addTutor_hsc_info->curriculum_id=  $request->hsc_curriculum_id;
                            $addTutor_hsc_info->group_or_major=  $request->hsc_group;
                            $addTutor_hsc_info->gpa =  $request->hsc_result;
                            $addTutor_hsc_info->save();

                            return response()->json(['status'=>true,'message'=>'added Successfully!','data' =>$addTutor_hsc_info]);

                            // return redirect()->back()->withMessage('Success! HSC information Added successfully');

                        }


                } catch (QueryException $e) {
                    return redirect()->back()->withInput()->withErrors($e->getMessage());
                }

            }

                if($request['gra_tutor_id']){


                    try{
                        $tutor_id= $request['gra_tutor_id'];
                        $tutor_gra_info = TutorEducation::where('tutor_id', $tutor_id)->where('degree_name', 'honours')->first();


                        if ($tutor_gra_info) {

                            $tutor_gra_info->institute_id     =  $request->gra_institute_id;
                            $tutor_gra_info->study_type_id    =  $request->gra_study_id;
                            $tutor_gra_info->year_or_semester     =  $request->gra_passing_year;
                            $tutor_gra_info->passing_year     =  $request->gra_passing_year;
                            $tutor_gra_info->university_type  =  $request->gra_university_type;
                            $tutor_gra_info->department_id    =  $request->gra_dept_id;
                            $tutor_gra_info->gpa              =  $request->gra_result;
                            $tutor_gra_info->update();

                            return response()->json(['status'=>true,'message'=>'updated Successfully!','data' =>$tutor_gra_info]);


                            return redirect()->back()->withMessage('Success! Graduation information updated successfully');

                            }
                            else{
                                $addTutor_gra_info = new TutorEducation();
                                $addTutor_gra_info->tutor_id = $request->gra_tutor_id;
                                $addTutor_gra_info->degree_name = 'honours';
                                $addTutor_gra_info->institute_id=  $request->gra_institute_id;
                                $addTutor_gra_info->study_type_id=  $request->gra_study_id;
                                $addTutor_gra_info->year_or_semester=  $request->gra_passing_year;
                                $addTutor_gra_info->passing_year=  $request->gra_passing_year;
                                $addTutor_gra_info->university_type=  $request->gra_university_type;
                                $addTutor_gra_info->department_id=  $request->gra_dept_id;
                                $addTutor_gra_info->gpa =  $request->gra_result;
                                $addTutor_gra_info->save();

                                return response()->json(['status'=>true,'message'=>'added Successfully!','data' =>$addTutor_gra_info]);

                                // return redirect()->back()->withMessage('Success! Graduation information Added successfully');

                            }


                    } catch (QueryException $e) {
                        return redirect()->back()->withInput()->withErrors($e->getMessage());
                    }


                }

                if($request['post_gra_tutor_id'])
                {

                    try{
                        $tutor_id= $request['post_gra_tutor_id'];
                        $tutor_post_gra_info = TutorEducation::where('tutor_id', $tutor_id)->where('degree_name', 'masters')->first();


                        if ($tutor_post_gra_info) {

                            $tutor_post_gra_info->institute_id     =  $request->post_gra_institute_id;
                            $tutor_post_gra_info->study_type_id    =  $request->post_gra_study_id;
                            $tutor_post_gra_info->year_or_semester =  $request->post_gra_passing_year;
                            $tutor_post_gra_info->university_type  =  $request->post_gra_university_type;
                            $tutor_post_gra_info->department_id    =  $request->post_gra_dept_id;
                            $tutor_post_gra_info->gpa              =  $request->post_gra_result;
                            $tutor_post_gra_info->update();

                            return response()->json(['status'=>true,'message'=>'updated Successfully!','data' =>$tutor_post_gra_info]);

                            // return redirect()->back()->withMessage('Success! Post graduation information updated successfully');

                            }
                            else{
                                $addTutor_post_gra_info                    = new TutorEducation();
                                $addTutor_post_gra_info->tutor_id          = $request->post_gra_tutor_id;
                                $addTutor_post_gra_info->degree_name       = 'masters';
                                $addTutor_post_gra_info->institute_id      =  $request->post_gra_institute_id;
                                $addTutor_post_gra_info->study_type_id     =  $request->post_gra_study_id;
                                $addTutor_post_gra_info->year_or_semester  =  $request->post_gra_passing_year;
                                $addTutor_post_gra_info->university_type   =  $request->post_gra_university_type;
                                $addTutor_post_gra_info->department_id     =  $request->post_gra_dept_id;
                                $addTutor_post_gra_info->gpa               =  $request->post_gra_result;
                                $addTutor_post_gra_info->save();

                                return response()->json(['status'=>true,'message'=>'added Successfully!','data' =>$addTutor_post_gra_info]);

                                // return redirect()->back()->withMessage('Success! Post graduation information Added successfully');

                            }


                    } catch (QueryException $e) {
                        return redirect()->back()->withInput()->withErrors($e->getMessage());
                    }



                }


    }


    public function updatePersonalInfo(Request $request)
    {


        //  dd($request->toArray());

        try {
            $tutor_id= $request['tutor_id'];
            $tutor = Tutor::where('id', $tutor_id)->firstOrFail();

            $tutor->gender = $request->gender;
            $tutor->update();

            $tutor_p_info = TutorPersonalInfo::where('tutor_id', $tutor_id)->first();

            if ($tutor_p_info) {

                $tutor_p_info->blood_group    =           $request->blood_group;
                $tutor_p_info->full_address    =    $request->full_address;
                $tutor_p_info->nationality              = $request->nationality;
                $tutor_p_info->nid_number               = $request->nid_number;
                $tutor_p_info->fathers_name             = $request->fathers_name;
                $tutor_p_info->fathers_phone            = $request->fathers_phone;
                $tutor_p_info->emergency_name           = $request->emergency_name;
                $tutor_p_info->about_yourself           = $request->about_yourself;
                $tutor_p_info->personal_opinion         = $request->personal_opinion;
                $tutor_p_info->permanent_full_address   = $request->permanent_full_address;
                $tutor_p_info->date_of_birth            = $request->date_of_birth;
                $tutor_p_info->facebook_link            = $request->facebook_link;
                $tutor_p_info->mothers_name             = $request->mothers_name;
                $tutor_p_info->mothers_phone            = $request->mothers_phone;
                $tutor_p_info->emergency_phone          = $request->emergency_phone;
                $tutor_p_info->reason_hired             = $request->reason_hired;
                $tutor_p_info->religion                 = $request->religion;

                $tutor_p_info->update();
                return redirect()->back()->withMessage('Success! personal information updated successfully');


            } else {
                $addTutor_p_info = new TutorPersonalInfo();

                $addTutor_p_info->country_id                 = 1;
                $addTutor_p_info->tutor_id                   = $request->tutor_id;
                $addTutor_p_info->blood_group                = $request->blood_group;
                $addTutor_p_info->full_address               = $request->full_address;
                $addTutor_p_info->nationality                = $request->nationality;
                $addTutor_p_info->nid_number                 = $request->nid_number;
                $addTutor_p_info->fathers_name               = $request->fathers_name;
                $addTutor_p_info->fathers_phone              = $request->fathers_phone;
                $addTutor_p_info->emergency_name             = $request->emergency_name;
                $addTutor_p_info->about_yourself             = $request->about_yourself;
                $addTutor_p_info->personal_opinion           = $request->personal_opinion;
                $addTutor_p_info->permanent_full_address     = $request->permanent_full_address;
                $addTutor_p_info->date_of_birth              = $request->date_of_birth;
                $addTutor_p_info->facebook_link              = $request->facebook_link;
                $addTutor_p_info->mothers_name               = $request->mothers_name;
                $addTutor_p_info->mothers_phone              = $request->mothers_phone;
                $addTutor_p_info->emergency_phone            = $request->emergency_phone;
                $addTutor_p_info->reason_hired               = $request->reason_hired;
                $addTutor_p_info->religion                   = $request->religion;

                $addTutor_p_info->save();



                return redirect()->back()->withMessage('Success! personal information save successfully');
            }

        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

        //  return view('backend.tutor.edit_info.edit_info', compact('tutor'));
    }
    public function updateTutoringInfo(Request $request)
    {

        // dd($request->toArray());


        try {
        $tutor_id = $request['tutor_id'];
        $tutor    = Tutor::where('id', $tutor_id)->firstOrFail();

        // dd($request->available_from);
        // $tutor->available_form  = $request->available_form;
        // $tutor->available_to    = $request->available_to;
        // $tutor->update();

        $tutor->tutor_categories()->sync($request->category_id);
        $tutor->tutor_course()->sync($request->course_id);
        $tutor->course_subjects()->sync($request->subject_id);
        $tutor->tutor_prefered_locations()->sync($request->p_location_id);
        $tutor->tutor_days()->sync($request->days_id);
        $tutor->teaching_method()->sync($request->tecahing_method_id);

        $tutor_p_info = TutorPersonalInfo::where('tutor_id', $tutor_id)->first();


        if ($tutor_p_info) {

            $tutor_p_info->country_id                   = 1;
            $tutor_p_info->available_from               = $request->available_from;
            $tutor_p_info->available_to                 = $request->available_to;
            $tutor_p_info->city_id                      = $request->city_id;
            $tutor_p_info->location_id                  = $request->location_id;
            $tutor_p_info->tutoring_experience          = $request->experience;
            $tutor_p_info->tutoring_experience_details  = $request->tutoring_experience_details;
            $tutor_p_info->expected_salary              = $request->expected_salary;
            $tutor_p_info->update();
            return redirect()->back()->withMessage('Success! tutoring information updated successfully');


        } else {
            $addTutor_p_info = new TutorPersonalInfo();

            $addTutor_p_info->country_id                   = 1;
            $addTutor_p_info->available_from               = $request->available_from;
            $addTutor_p_info->available_to                 = $request->available_to;
            $addTutor_p_info->tutor_id                     = $request->tutor_id;
            $addTutor_p_info->city_id                      = $request->city_id;
            $addTutor_p_info->location_id                  = $request->location_id;
            $addTutor_p_info->tutoring_experience          = $request->experience;
            $addTutor_p_info->tutoring_experience_details  = $request->tutoring_experience_details;
            $addTutor_p_info->expected_salary              = $request->expected_salary;
            $addTutor_p_info->save();


            return redirect()->back()->withMessage('Success! tutoring information updated successfully');
        }


        //  return $tutor->tutor_categories;



    } catch (QueryException $e) {
        return redirect()->back()->withInput()->withErrors($e->getMessage());
    }

    }

    public function editInfo($tutor)
    {


        // dd($tutor);
        $countries  = Country::orderBy('id', 'desc')->get();
        $cities     = City::orderBy('id', 'desc')->get();
        $locations  = Location::orderBy('id', 'desc')->get();
        $days       = Day::orderBy('id', 'desc')->get();



        // $tutors= Tutor::orderBy('id', 'desc')->get();
        $departments      = Department::orderBy('id', 'desc')->get();
        $categories       = Category::orderBy('id', 'ASC')->get();
        $departments      = Department::orderBy('id', 'desc')->get();
        $courses          = Course::orderBy('id', 'desc')->get();
        $institutes       =Institute::orderBy('id', 'desc')->get();
        $teaching_methods = TeachingMethod::orderBy('id', 'desc')->get();
        $subjects         = Subject::orderBy('id', 'desc')->get();
        $studies          = Study::orderBy('id', 'desc')->get();
        $curriculams      = Curriculam::orderBy('id', 'desc')->get();
        $courseSubjects   = CourseSubject::orderBy('id', 'desc')->get();


        $tutor= Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
            'course_subjects',
        ])->where('id', $tutor)->firstOrFail();


        return view('backend.tutor.edit_info.edit_info', compact('countries','cities','locations','departments','categories',
        'departments','days','courses','institutes','teaching_methods','subjects','studies','curriculams','tutor','courseSubjects'));


    }



    public function index(Request $request)
    {
        $input = $request->input('pagination_limit') ?? 50;

        // Cache the average ratings for 12 hours (720 minutes)
        $ratings = Cache::remember('tutor_average_ratings', 60 * 12, function () {
            return DB::table('tutor_reviews')
                ->select('tutor_id', DB::raw('AVG(rating) as avg_rating'))
                ->groupBy('tutor_id')
                ->pluck('avg_rating', 'tutor_id')
                ->toArray();
        });

        // Get tutors (without AVG)
        $tutors = Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
        ])
        ->select(
            'tutors.id',
            'tutors.name',
            'tutors.gender',
            'tutors.unique_id',
            'tutors.phone',
            'tutors.is_active',
            'tutors.deleted_at',
            'tutors.created_at',
            'tutors.is_sms'
        )
        ->where('is_active', 1)
        ->orderBy('id','desc')
        ->paginate($input);

        // Inject cached ratings
        $tutors->getCollection()->transform(function ($tutor) use ($ratings) {
            $tutor->average_rating = $ratings[$tutor->id] ?? 0;
            return $tutor;
        });

        return view('backend.tutor.index', compact('input', 'tutors'));
    }







    public function paginateInput(Request $request)
    {


        $input = $request->pagination_limit;
        // dd($input);

        $all_tutor_count       = DB::table('tutors')->count();
        $male_tutor_count      = Tutor::where('gender', 'male')->where('is_active',1)->count();
        $female_tutor_count    = Tutor::where('gender', 'female')->where('is_active',1)->count();
        $premium_tutor_count   = Tutor::where('is_premium', '=', 1)->where('is_active',1)->count();
        $featured_tutor_count  = Tutor::where('is_featured', '=', 1)->where('is_active',1)->count();
        $unique_tutors_confirmed = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_confirmed'))
        ->whereNotNull('confirm_date')
        ->first();




        $tutors = Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
        ])->orderBy('id', 'desc')->paginate($input);


        return view('backend.tutor.paginate', compact('tutors','all_tutor_count','male_tutor_count',
        'female_tutor_count','premium_tutor_count','featured_tutor_count','input','unique_tutors_confirmed'));
    }


    public function create()
    {

        return view('backend.tutor.create');

    }
    public function edit($tutor)
    {
        $tutor= Tutor::where('id', $tutor)->firstOrFail();

        return response()->json([
            'status'=>200,
            'tutor'=>$tutor,
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name'      => 'required',
            'phone'     => 'required|regex:/(01)[0-9]{9}/|unique:tutors,phone',
            'email'     => 'required|email|unique:tutors,email',
            'gender'    => 'required',
            'password'  => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }
        $tutor = new Tutor();
        $tutor->otp       = rand(1234,9999);
        $tutor->name      = $request->name;
        $tutor->phone     = $request->phone;
        $tutor->email     = $request->email;
        $tutor->gender    = $request->gender;
        $tutor->role_id   = '3';
        $tutor->password  = Hash::make($request->password);
        $tutor->save();
        $tutor->get_tutor_unique_id();

        $counting = new Counting();
        $counting->tutor_id = $tutor->id;
        $counting->save();


        return response()->json(['status'=>true,'message'=>'Tutor Registration Successfully!','data' =>$tutor]);

    }

    public function update(Request $request)
    {

        $tutordata=$request->all();
        $id = $tutordata['tutor_id'];
        $tutor= Tutor::where('id', $id)->firstOrFail();
        $tutor->update($tutordata);
        return redirect()->route('tutor.index')->withMessage('Tutor Data Updated Successfully');

    }

    public function VerifyPhone(Request $request)
    {
        $validator = Validator()->make($request->all(), [
            'phone_otp' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }
        $id = $request->tutor_id;
        if (Tutor::find($id)) {
            $check_Otp = Tutor::find($id);
            if ($check_Otp->otp == $request->phone_otp) {
                $check_Otp->phone_varified_at = now();
                $check_Otp->save();
                return response()->json(['status' => true, 'message' => 'Phone verified successfully!']);
            } else {
                return response()->json(['status' => false, 'error' => 'your otp is invalid!']);
            }
        } else {
            return response()->json(['status' => false, 'error' => 'User Not Found']);
        }
    }

    public function smsEditor(Request $request)
    {
        $ids     = $request['all_id'];
        $myArray = explode(',', $ids);
        $tutors = Tutor::whereIn('id', $myArray)
                ->where('is_sms', 1)
                ->get();


        $errorTutorId = null;

        $phonenumbers = [];

        foreach ($tutors as $utor) {
            if ($utor->is_sms == 1) {
                $phonenumbers[] = $utor->phone;
            } else {
                $errorTutorId = $utor->id;
            }
        }

        if ($errorTutorId !== null) {
            return response()->json(['send-sms-status' => false, 'error' => 'Please Activate Sms Status for Tutor ID: ' . $errorTutorId]);
        }

        $numbers = implode(',', $phonenumbers);

        return view('backend.tutor.smsEditor', compact('numbers', 'tutors'));
    }


    public function singleSms($tutor)
    {


        $tutor   = explode(',', $tutor);
        $tutors  = Tutor::where('id',$tutor)->get();


        foreach($tutors as $utor){
           if( $utor->is_sms == 1){
               $phonenumbers[] = $utor->phone;
           }
           else{
            return response()->json(['send-sms-status' => false, 'error' => 'Please Active Sms Status ']);
           }
        }

           $numbers = implode(',', $phonenumbers);
        //    dd($numbers);

        return view('backend.tutor.smsEditor', compact('tutors' , 'numbers'));

    }

    public function sendSms(Request $request)
    {


        try {
            $tutorNumbers = explode(',', $request->phone_numbers);

            foreach ($tutorNumbers as $phoneNumber) {
                $sms = new ModelsAdvanceSearchSms();
                $sms->send_by = Auth::user()->id;
                $sms->body = $request->body;
                $sms->phone = $phoneNumber;
                $sms->is_send = 0;
                $sms->save();
                $tutorId = Tutor::where('phone', $phoneNumber)->pluck('id')->first();
                if ($tutorId) {
                    $updateSmsBalance = SmsBalance::where('tutor_id', $tutorId)->first();
                    if ($updateSmsBalance) {
                        $updateSmsBalance->increment('unpaid_sms');
                    } else {
                        $newSmsBalance = new SmsBalance();
                        $newSmsBalance->tutor_id = $tutorId;
                        $newSmsBalance->unpaid_sms = 1;
                        $newSmsBalance->save();
                    }
                }
            }


            return redirect()->route('tutor.index')->withMessage('Success! SMS sent successfully');
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }

    }

   public function showTutor($id)
    {
        $reffers = Reffer::where('tutor_id', $id)->latest('created_at')->take(3)->orderBy('id','desc')->get();

            $tutor = Tutor::with([
                'tutor_personal_info',
                'tutor_education',
                'tutor_prefered_locations',
                'tutor_course',
                'tutor_subject',
                'tutor_categories',
                'tutor_days',
                'teaching_method',
                'course_subjects',
                'TutorCertificate',
                'smsBalances',

            ])->where('id',$id)->first();

            // dd($tutor);
            // dd();
            $refferedBy = Reffer::where('reffer_for', $tutor->phone)->latest('created_at')->orderBy('id','desc')->get();


            $tutor_logs = TutorLog::where('tutor_id',$id)->get();

            $tutor_important_update = TutorLog::where('tutor_id', $id)
            ->where(function ($query) {
                $query->whereNotNull('name')
                    ->orWhereNotNull('email')
                    ->orWhereNotNull('phone');
            })
            ->orderBy('id','DESC')->get();

            $tutor_confirm_tuition = JobApplication::where('tutor_id',$id)->whereNotNull('confirm_date')->get();


            $paidSms = JobSms::where('tutor_id',$id)->orderBy('id','DESC')->get();
            $unPaidSms = Sms::where('phone', $tutor->phone)->orderBy('id','DESC')->get();

            $smsTrxHistory = SmsRecharge::where('tutor_id',$id)->orderBy('created_at','DESC')->get();

            $smsBalance = SmsBalance::where('tutor_id',$id)->first();

            return view('backend.tutor.tutor_info',compact('refferedBy','reffers','smsBalance','smsTrxHistory','unPaidSms','paidSms','tutor','tutor_logs','tutor_important_update','tutor_confirm_tuition'));


    }
    public function search(Request $request)
    {
        $input = 50;
        $inputt = $request['search'];

        $all_tutor_count       = DB::table('tutors')->count();
        $male_tutor_count      = Tutor::where('gender', 'male')->where('is_active',1)->count();
        $female_tutor_count    = Tutor::where('gender', 'female')->where('is_active',1)->count();
        $premium_tutor_count   = Tutor::where('is_premium', '=', 1)->where('is_active',1)->count();
        $featured_tutor_count  = Tutor::where('is_featured', '=', 1)->where('is_active',1)->count();
        $unique_tutors_confirmed = DB::table('job_applications')
            ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_confirmed'))
            ->whereNotNull('confirm_date')
            ->first();

            $tutors = Tutor::with([
                'tutor_personal_info',
                'tutor_education',
                'tutor_prefered_locations',
                'tutor_course',
                'tutor_subject',
                'tutor_categories',
                'tutor_days',
                'teaching_method',
            ])
            ->leftJoin('tutor_reviews', 'tutors.id', '=', 'tutor_reviews.tutor_id')
            ->select(
                'tutors.id',
                'tutors.name',
                'tutors.phone',
                'tutors.unique_id',
                'tutors.gender',
                'tutors.is_active',
                'tutors.is_premium',
                'tutors.is_featured',
                'tutors.is_sms',
                DB::raw('COALESCE(AVG(tutor_reviews.rating), 0) as average_rating')
            )
            ->where('tutors.id', $inputt)
            ->orWhere('tutors.unique_id', $inputt)
            ->orWhere('tutors.phone', $inputt)
            ->groupBy('tutors.is_sms','tutors.id', 'tutors.name', 'tutors.phone', 'tutors.unique_id', 'tutors.gender', 'tutors.is_active', 'tutors.is_premium', 'tutors.is_featured') // Include all selected columns in GROUP BY
            ->paginate($input);


        return view('backend.tutor.index', compact(
            'tutors',
            'all_tutor_count',
            'male_tutor_count',
            'female_tutor_count',
            'premium_tutor_count',
            'featured_tutor_count',
            'input',
            'unique_tutors_confirmed'
        ));
    }

    public function premiumTutor(Request $request)
    {
        // dd($request->all());
        $input = $request->input('pagination_limit') ?? 50;

        $tutors = Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
        ])->where('is_active',1)
        ->where('is_premium', '=', 1)
        ->orWhere('is_premium_pro', 1)
        ->orWhere('is_premium_advance', 1)
        ->orderBy('id', 'desc')->paginate(50);

        return view('backend.tutor.premium_tutor', compact('tutors','input'));

    }
    public function verifiedTutor(Request $request)
    {
        // dd($request->all());
        $input = $request->input('pagination_limit') ?? 50;

        $tutors = Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
        ])->where('is_active',1)
        ->where('is_verified', '=', 1)
        ->orderBy('id', 'desc')->paginate(50);




        return view('backend.tutor.verified_tutor', compact('tutors','input'));

    }
    public function boostTutor(Request $request)
    {
        // dd($request->all());
        $input = $request->input('pagination_limit') ?? 50;

        $tutors = Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
        ])->where('is_active',1)
        ->where('is_boost', '=', 1)
        ->orderBy('id', 'desc')->paginate($input);




        return view('backend.tutor.boost_tutor', compact('tutors','input'));

    }

    public function featuredTutor()
    {
        $all_tutor_count       = DB::table('tutors')->count();
        $male_verified_tutor_count      = Tutor::where('gender', 'male')->where('is_verified',1)->count();
        $female_verified_tutor_count      = Tutor::where('gender', 'female')->where('is_verified',1)->count();
        $male_featured_tutor_count      = Tutor::where('gender', 'male')->where('is_featured',1)->count();
        $female_featured__tutor_count    = Tutor::where('gender', 'female')->where('is_featured',1)->count();
        $verified_tutor_count   = Tutor::where('is_verified', '=', 1)->where('is_active',1)->count();
        // $featured_tutor_count  = Tutor::where('is_verified', '=', 1)->where('is_active',1)->count();
        $unique_tutors_confirmed = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_confirmed'))
        ->whereNotNull('confirm_date')
        ->first();

        $tutors = Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
        ])->orderBy('id', 'desc')->where('is_featured', '=', 1)->paginate(20);

        return view('backend.tutor.featured_tutor', compact('tutors','all_tutor_count','male_featured_tutor_count',
        'female_featured__tutor_count','verified_tutor_count','unique_tutors_confirmed','female_verified_tutor_count','male_verified_tutor_count'));

    }
    public function memberCount()
    {
        $activePremium = Tutor::where('is_active',1)
                        ->where('is_premium', '=', 1)
                        ->orWhere('is_premium_pro', 1)
                        ->orWhere('is_premium_advance', 1)->count();
        $totalPremium = Tutor::where('is_premium', '=', 1)
                        ->orWhere('is_premium_pro', 1)
                        ->orWhere('is_premium_advance', 1)->count();

        $regularPremium = Tutor::where('is_active',1)
                        ->where('is_premium', '=', 1)->count();
        $proPremium = Tutor::where('is_active',1)
                        ->where('is_premium_pro', 1)->count();
        $advancePremium = Tutor::where('is_active',1)
                        ->where('is_premium_advance', 1)->count();
        $todayPremium = Tutor::whereDate('premium_date', today())->count();

        $activePremiumId = Tutor::where(function($query) {
                            $query->where('is_premium', '=', 1)
                                ->orWhere('is_premium_pro', 1)
                                ->orWhere('is_premium_advance', 1);
                        })
                        ->pluck('id');

        $confirmedTutorsCount = JobApplication::whereIn('tutor_id', $activePremiumId)
                                                ->where('current_stage', 'confirm')
                                                ->distinct('tutor_id')
                                                ->count('tutor_id');

        $totalVerify        = Tutor::where('is_verified', 1)->count();
        $activeVerify       = Tutor::where('is_active',1)->where('is_verified', 1)->count();
        $inActiveVerify     = Tutor::where('is_active',0)->where('is_verified', 1)->count();
        $todayVerify        = Tutor::whereDate('verify_date',today())->count();
        $activeVerifyId     = Tutor::where('is_verified', 1)
                                     ->pluck('id');

        $confirmedTutorsCountv = JobApplication::whereIn('tutor_id', $activeVerifyId)
                                ->where('current_stage', 'confirm')
                                ->distinct('tutor_id')
                                ->count('tutor_id');


        $totalBoost = Tutor::where('is_boost',1)->count();
        $activeBoost = Tutor::where('is_active',1)
                            ->where('is_boost',1)
                            ->count();
        $oneMonthBoost      = Tutor::where('is_boost',1)
                                ->where('boost_package',1)
                                ->count();
        $threeMonthBoost    = Tutor::where('is_boost',1)
                                ->where('boost_package',3)
                                ->count();
        $sixMonthBoost      = Tutor::where('is_boost',1)
                                ->where('boost_package',6)
                                ->count();
        $twelveMonthBoost   = Tutor::where('is_boost',1)
                                ->where('boost_package',12)
                                ->count();

        $activeboostId     = Tutor::where('is_boost', 1)
                                ->pluck('id');

        $confirmedTutorsCountb = JobApplication::whereIn('tutor_id', $activeboostId)
                           ->where('current_stage', 'confirm')
                           ->distinct('tutor_id')
                           ->count('tutor_id');





        return view('backend.tutor.membership_counting',
        compact('totalPremium','activePremium','regularPremium','totalVerify','activeVerify','inActiveVerify','todayVerify',
        'proPremium','advancePremium','todayPremium','confirmedTutorsCount','confirmedTutorsCountv','confirmedTutorsCountb',
        'totalBoost','activeBoost','oneMonthBoost','threeMonthBoost','sixMonthBoost','twelveMonthBoost'));
    }

    public function verifiedJobTutor(Request $request)
    {
        $input = $request->input('pagination_limit') ?? 50;

        $tutorIds = Tutor::where('is_active', 1)
                 ->where('is_verified', 1)
                 ->pluck('id');


        if($request->verified == 'yes')
        {
            $jobConfirm = JobApplication::whereIn('tutor_id', $tutorIds)
                                    ->where('current_stage', 'confirm')
                                    ->distinct('tutor_id')
                                    ->pluck('tutor_id');

        }elseif($request->verified == 'no'){
            $confirmedTutorIds = JobApplication::where('current_stage', 'confirm')
                                   ->pluck('tutor_id');

            $jobConfirm = JobApplication::whereIn('tutor_id', $tutorIds)
                                        ->whereNotIn('tutor_id', $confirmedTutorIds)
                                        ->pluck('tutor_id')
                                        ->unique();
        }




        $tutors = Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
        ])
        ->whereIn('id',$jobConfirm)
        ->where('is_active',1)
        ->where('is_verified', '=', 1)
        ->orderBy('id', 'desc')->paginate($input);
        return view('backend.tutor.verified_tutor', compact('tutors','input'));



    }
    public function premiumJobTutor(Request $request)
    {
        $input = $request->input('pagination_limit') ?? 50;

        $tutorIds = Tutor::where('is_active', 1)
                ->where('is_premium', '=', 1)
                ->orWhere('is_premium_pro', 1)
                ->orWhere('is_premium_advance', 1)
                 ->pluck('id');


        if($request->verified == 'yes')
        {
            $jobConfirm = JobApplication::whereIn('tutor_id', $tutorIds)
                                    ->where('current_stage', 'confirm')
                                    ->distinct('tutor_id')
                                    ->pluck('tutor_id');

        }elseif($request->verified == 'no'){
            $confirmedTutorIds = JobApplication::where('current_stage', 'confirm')
                                   ->pluck('tutor_id');

            $jobConfirm = JobApplication::whereIn('tutor_id', $tutorIds)
                                        ->whereNotIn('tutor_id', $confirmedTutorIds)
                                        ->pluck('tutor_id')
                                        ->unique();
        }




        $tutors = Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
        ])
        ->whereIn('id',$jobConfirm)
        ->where('is_active',1)
        ->orderBy('id', 'desc')->paginate($input);
        return view('backend.tutor.premium_tutor', compact('tutors','input'));



    }
    public function boostJobTutor(Request $request)
    {
        $input = $request->input('pagination_limit') ?? 50;

        $tutorIds = Tutor::where('is_active', 1)
                ->where('is_boost', '=', 1)

                 ->pluck('id');


        if($request->verified == 'yes')
        {
            $jobConfirm = JobApplication::whereIn('tutor_id', $tutorIds)
                                    ->where('current_stage', 'confirm')
                                    ->distinct('tutor_id')
                                    ->pluck('tutor_id');

        }elseif($request->verified == 'no'){
            $confirmedTutorIds = JobApplication::where('current_stage', 'confirm')
                                   ->pluck('tutor_id');

            $jobConfirm = JobApplication::whereIn('tutor_id', $tutorIds)
                                        ->whereNotIn('tutor_id', $confirmedTutorIds)
                                        ->pluck('tutor_id')
                                        ->unique();
        }




        $tutors = Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
        ])
        ->whereIn('id',$jobConfirm)
        ->where('is_active',1)
        ->orderBy('id', 'desc')->paginate($input);
        return view('backend.tutor.boost_tutor', compact('tutors','input'));



    }

    public function makePremium(Request $request)
    {

        $tutor= Tutor::where('id',$request->grant_id)->first();

        if($request->package_name == 'regular'){

            $tutor->is_premium = 1;
            $tutor->premium_by = Auth::user()->id;
            $tutor->premium_date = now();
            $tutor->premium_expire = now()->addYear();
            $tutor->is_premium_advance = 0;
            $tutor->is_premium_pro = 0;
            $tutor->update();

            $transction = new ApplicationPayment();
            $transction->tutor_id            = $request->grant_id ;
            $transction->received_amount     = $request->taka;
            $transction->trx_id              = $request->transction_id;
            $transction->payment_method      = $request->payment_method ?? "Bkash";
            $transction->render_by           = Auth::user()->id;
            $transction->service_category    = "membership payment";
            $transction->save();
            return redirect()->back()->withMessage('Success! tutor marked as premium tutor successfully');


        }elseif($request->package_name == 'pro'){




            $tutor->is_premium_pro = 1;
            $tutor->premium_by = Auth::user()->id;
            $tutor->premium_date = now();
            $tutor->premium_expire = now()->addYear(2);
            $tutor->is_premium_advance = 0;
            $tutor->is_premium = 0;
            $tutor->update();

            $transction = new ApplicationPayment();
            $transction->tutor_id            = $request->grant_id ;
            $transction->received_amount     = $request->taka;
            $transction->render_by           = Auth::user()->id;
            $transction->trx_id              = $request->transction_id;
            $transction->payment_method      = $request->payment_method ?? "Bkash";
            $transction->service_category    = "membership payment";
            $transction->save();
            return redirect()->back()->withMessage('Success! tutor marked as premium tutor successfully');


        }elseif($request->package_name == 'advance'){




            $tutor->is_premium_advance = 1;
            $tutor->premium_by = Auth::user()->id;
            $tutor->premium_date = now();
            $tutor->premium_expire = now()->addYear(5);
            $tutor->is_premium_pro = 0;
            $tutor->is_premium = 0;
            $tutor->update();


            $transction = new ApplicationPayment();
            $transction->tutor_id            = $request->grant_id ;
            $transction->received_amount     = $request->taka;
            $transction->trx_id              = $request->transction_id;
            $transction->render_by           = Auth::user()->id;
            $transction->payment_method      = $request->payment_method ?? "Bkash";
            $transction->service_category    = "membership payment";
            $transction->save();
            return redirect()->back()->withMessage('Success! tutor marked as premium tutor successfully');


        }


    }
    public function makeAlert(Request $request, $tutor)
    {
        $tutor= Tutor::where('id',$tutor)->firstOrFail();
        $tutor->is_alerted = 1;
        $tutor->alerted_date = now();
        $tutor->alerted_by = auth()->user()->id;

        $tutor->save();

        $tutorNote = new TutorAlertNote();

        $tutorNote->tutor_id = $tutor->id;
        $tutorNote->changed_note = $request->changed_note;
        $tutorNote->changed_by = Auth::user()->id;
        $tutorNote->status = 1;

        $tutorNote->save();

        return redirect()->route('tutor.index')->withMessage('Success! tutor marked as alerted tutor successfully');

    }
    public function undoAlert(Request $request, $tutor)
    {
        $tutor= Tutor::where('id',$tutor)->firstOrFail();
        $tutor->is_alerted = null;
        $tutor->alerted_date =null;
        $tutor->alerted_by = null;

        $tutor->save();

        $tutorNote = new TutorAlertNote();

        $tutorNote->tutor_id = $tutor->id;
        $tutorNote->changed_note = $request->changed_note;
        $tutorNote->undo_by = Auth::user()->id;
        $tutorNote->status =0;

        $tutorNote->save();
        return redirect()->route('tutor.index')->withMessage('Success! tutor marked as regular tutor successfully');

    }
    public function undoPremium($tutor)
    {
        $tutor= Tutor::where('id',$tutor)->firstOrFail();
        $tutor->is_premium = 0;
        $tutor->premium_date = null;
        $tutor->premium_by = null;
        $tutor->save();
        return redirect()->back()->withMessage('Success! tutor marked as general tutor');

    }

    public function makeFeatured($tutor)
    {
        $tutor= Tutor::where('id',$tutor)->firstOrFail();
        $tutor->is_featured = 1;
        $tutor->featured_by = auth()->user()->id;
        $tutor->featured_date = now();
        $tutor->save();
        return redirect()->route('tutor.index')->withMessage('Success! tutor marked as featured tutor');
    }

    public function undoFeatured($tutor)
    {
        $tutor= Tutor::where('id',$tutor)->firstOrFail();
        $tutor->is_featured = 0;
        $tutor->save();
        return redirect()->back()->withMessage('Success! tutor marked as general tutor');
    }

    public function verifyTutor($tutor,Request $request)
    {
        $tutor= Tutor::where('id',$tutor)->firstOrFail();

        if($request->transction_id){

            $updatedRows = VerificationRequest::where('tutor_id', $tutor->id)->whereNull('payment_status')->update([
                'request_status' => 'accepted',
                'action_by' => Auth::user()->id,
                'channel_name' => 'Admin',
                'payment_status' => 'paid',
                'action_at' => now(),
            ]);
            $tutor->is_verified = 1;
            $tutor->verified_by = auth()->user()->id;
            $tutor->verify_date = now();
            $tutor->update();


            $transction = new ApplicationPayment();
            $transction->tutor_id            = $tutor->id ;
            $transction->received_amount     = $request->taka;
            $transction->trx_id              = $request->transction_id;
            $transction->render_by           = Auth::user()->id;
            $transction->payment_method      = $request->payment_method ?? "Bkash";
            $transction->service_category    = "verification payment";
            $transction->save();
            return redirect()->back()->withMessage('Success! tutor marked as verified tutor successfully');


        }else{

            $tutor->is_internal_verify = 1;
            $tutor->verified_by = auth()->user()->id;
            $tutor->verify_date = now();
            $tutor->update();
            return redirect()->back()->withMessage('Success! tutor verified successfully');


        }

    }

    public function destroy(Request $request, $tutor)
    {


        $tutor = Tutor::findOrFail($tutor);
        $tutor->deleted_by = auth()->user()->name;
        $tutor->is_alerted = 0;
        $note = $request->input('tutor_delete_note');
        $tutor->save();

        $deleteNote = new TutorDeleteNote();
        $deleteNote->tutor_id = $tutor->id;
        $deleteNote->delete_note = $note;
        $deleteNote->delete_by = Auth::user()->id;
        $deleteNote->save();

        $tutor->delete();
        return redirect()->route('admin.tutors.trash')->withMessage('Successfully sent to trash!');
    }
    public function tutorDeleteNoteList($id)
    {
        $notes = TutorDeleteNote::where('tutor_id', $id)->get();
        return response()->json(['notes' => $notes]);
    }



    public function trash(Request $request)
    {
        $all_tutor_count       = DB::table('tutors')->count();
        $male_tutor_count      = Tutor::where('gender', 'male')->where('is_active',1)->count();
        $female_tutor_count    = Tutor::where('gender', 'female')->where('is_active',1)->count();
        $premium_tutor_count   = Tutor::where('is_premium', '=', 1)->where('is_active',1)->count();
        $featured_tutor_count  = Tutor::where('is_featured', '=', 1)->where('is_active',1)->count();

        $uniqueTutorsTakenToday = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_taken_today'))
        ->whereDate('taken_at', now())
        ->first();
        $uniqueTutorsShortlistedToday = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_shortlisted_today'))
        ->whereDate('shortlisted_date', now())
        ->first();
        $unique_tutors_confirmed = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_confirmed'))
        ->whereNotNull('confirm_date')
        ->first();
        $unique_tutors_applied = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_applied'))
        ->first();
        $all_tutor_confirm = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_confirm'))
        ->where('current_stage','confirm')
        ->count();


        $input = $request->input('pagination_limit') ?? 50;

        $tutors = Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
        ])->where('is_active',0)
        ->orderBy('id', 'desc')->paginate(50);

        return view('backend.tutor.trash', compact('tutors', 'all_tutor_count', 'male_tutor_count',
            'female_tutor_count', 'premium_tutor_count', 'featured_tutor_count', 'input','uniqueTutorsShortlistedToday','uniqueTutorsTakenToday'
            ,'unique_tutors_confirmed','unique_tutors_applied','all_tutor_confirm'));
    }
    public function restore(Request $request, $tutor)
    {

         Tutor::withTrashed()
        ->where('id', $tutor)
        ->restore();


        Tutor::where('id', $tutor)->update([
            'is_active' => 1,
            'is_sms' => 1
        ]);
        $restoreNote = new TutorDeleteNote();
        $restoreNote->tutor_id = $request->tutor_id;
        $restoreNote->restore_note = $request->input('restore_note');
        $restoreNote->restore_by = Auth::user()->id;
        $restoreNote->save();


        return redirect()->route('admin.tutors.trash')->withMessage('Successfully Restored!');
    }
    public function delete($tutor)
    {


        $tutor = Tutor::where('id', $tutor);
        // dd($tutor);
        $tutor->forceDelete();
        // Tutor::withTrashed()
        //     ->where('id', $tutor)
        //     ->forceDelete();
            return redirect()->back();
    }
    public function note($tutor)
    {
        $tutor = Tutor::where('id', $tutor)->firstOrFail();

        return response()->json([
            'status' =>200,
            'tutor'  =>$tutor,
        ]);


    }

    public function createNote(Request $request)
    {

        $tutor_id = $request->t_id;
        $tutor    = Tutor::where('id', $tutor_id)->firstOrFail();
        $tutor->condition_note = $request->t_note;
        $tutor->save();

        return response()->json([
            'status'=>true,
            'tutor'=>$tutor,
        ]);

    }



    public function changeStatus(Request $request)
    {
        $tutor            = Tutor::find($request->id);
        $tutor->is_sms    = $tutor->is_sms === 1 ? 0 : 1;
        $tutor->save();
        return response()->json(['status'=>'success','message'=> 'Send Sms Status Change']);
    }

    public function tutorUpdate(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required',
            'phone'      => 'required|regex:/(01)[0-9]{9}/|unique:tutors,phone,' . $id,
            'email'      => 'required|email|unique:tutors,email,' . $id,
            'password'   => 'required|min:6',
            'cpassword'  => 'required|same:password',
        ]);

        $tutor_update = Tutor::find($id);

        if (!$tutor_update) {
            return response()->json(['status' => 'error', 'message' => 'Tutor not found'], 404);
        }

        $tutor_update->name         = $request->input('name');
        $tutor_update->email        = $request->input('email');
        $tutor_update->phone        = $request->input('phone');
        $tutor_update->phone_varified_at        = now();
        $tutor_update->otp_expiry        = now();
        $tutor_update->password     = Hash::make($request->input('password'));

        $tutor_update->save();

        $tutor_logs = new TutorLog();
        $tutor_logs->tutor_id     = $tutor_update->id;
        $tutor_logs->name         = $tutor_update->name;
        $tutor_logs->email        = $tutor_update->email;
        $tutor_logs->phone        = $tutor_update->phone;
        $tutor_logs->edited_by    = Auth::user()->name;

        $tutor_logs->save();


        return response()->json(['status' => 'success', 'message' => 'Tutor update successful']);
    }


    // Premium Membership
    public function premiumMemberAdd(Request $request)
    {

        $request->validate([
            'phone'      => 'required|regex:/(01)[0-9]{9}/',
            'package_name'      => 'required'

        ]);

        $tutor = Tutor::where('phone',$request->phone)->first();


        if (!$tutor) {
            return response()->json(['status' => 'error', 'message' => 'Tutor not found'], 404);
        }

        $membership = new PremiumMembership();
        $membership->tutor_id = $tutor->id;
        $membership->package_name = $request->package_name;
        $membership->name = $tutor->name;
        $membership->action_by = Auth::user()->id;
        $membership->action_at = now();
        $membership->channel_name = 'Admin';
        $membership->request_status = 'pending';
        $membership->save();

        return redirect()->back()->withMessage('Request Added Succesfully!');


    }
    public function premiumMembership(Request $request)
    {
        $paginationLimit = $request->input('pagination_limit', 50);

        $employees = User::where('role_id',4)->get();

        $memberships = PremiumMembership::orderBy('id', 'desc')->paginate($paginationLimit);

        return view('backend.premiummember.index', compact('memberships','paginationLimit','employees'));
    }
    public function premiumMembershipSearch(Request $request)
    {
        $search = $request->input('search');
        $paginationLimit = $request->input('pagination_limit', 50);

        $tutor = Tutor::where('phone',$search)->first();

        $memberships = PremiumMembership::where('tutor_id',$tutor->id ?? '')->paginate($paginationLimit);
        $employees = User::where('role_id',4)->get();

        return view('backend.premiummember.search', compact('memberships','paginationLimit','employees'));
    }
    public function premiumMembershipNote(Request $request)
    {
        $memberships = PremiumMembership::where('id', $request->application_id)->first();

        if (!$memberships) {
            session()->flash('error', 'Membership not found!');
            return redirect()->back();
        }

        $memberships->action_by = auth()->user()->id;
        $memberships->note = $request->note;
        $memberships->action_at = now();
        $memberships->update();

        session()->flash('success', 'Note Updated!');
        return redirect()->back();
    }


    public function grantApplication(Request $request)
    {

        $memberships = PremiumMembership::where('id',$request->grant_id)->first();
        $tutor = Tutor::where('id',$memberships->tutor_id)->first();

        if($memberships->payment_status == 'paid')
        {
            $memberships->channel_name = 'Website';
        }else{
            $memberships->channel_name = 'Admin';


            $transction = new ApplicationPayment();
            $transction->tutor_id            = $memberships->tutor_id ;
            $transction->received_amount     = $request->taka;
            $transction->trx_id              = $request->transction_id;
            $transction->payment_method      = $request->payment_method ?? "Bkash";
            $transction->render_by           = Auth::user()->id;
            $transction->service_category    = "membership payment";
            $transction->save();
        }
        if($memberships->package_name == 'regular'){
            $tutor->is_premium = 1;
            $tutor->premium_by = Auth::user()->id;
            $tutor->premium_date = now();
            $tutor->premium_expire = now()->addYear();
            $tutor->is_premium_advance = 0;
            $tutor->is_premium_pro = 0;
            $tutor->update();

            $memberships->action_by        = auth::user()->id;
            $memberships->payment_status   = 'paid';
            $memberships->request_status   = 'accepted';
            $memberships->action_at        = now();
            $memberships->update();

            return redirect()->back()->withMessage('Successfully Granted Application!');

        }elseif($memberships->package_name == 'pro'){
            $tutor->is_premium_pro = 1;
            $tutor->premium_by = Auth::user()->id;
            $tutor->premium_date = now();
            $tutor->premium_expire = now()->addYears(2);
            $tutor->is_premium = 0;
            $tutor->is_premium_advance = 0;
            $tutor->update();

            $memberships->action_by        = auth::user()->id;
            $memberships->payment_status   = 'paid';
            $memberships->request_status   = 'accepted';
            $memberships->action_at        = now();
            $memberships->update();

            return redirect()->back()->withMessage('Successfully Granted Application!');


        }elseif($memberships->package_name == 'advance'){
            $tutor->is_premium_advance = 1;
            $tutor->premium_by = Auth::user()->id;
            $tutor->premium_date = now();
            $tutor->premium_expire = now()->addYears(5);
            $tutor->is_premium_pro = 0;
            $tutor->is_premium = 0;
            $tutor->update();

            $memberships->action_by        = auth::user()->id;
            $memberships->payment_status   = 'paid';
            $memberships->request_status   = 'accepted';
            $memberships->action_at        = now();
            $memberships->update();

            return redirect()->back()->withMessage('Successfully Granted Application!');


        }


    }

    public function declineApplication(Request $request)
    {
        $memberships = PremiumMembership::where('id',$request->decline_id)->first();

        $memberships->action_by        = auth::user()->id;
        $memberships->decline_note     = $request->decline_note;
        $memberships->request_status   = 'rejected';
        $memberships->action_at        = now();
        $memberships->update();
        return redirect()->back()->withMessage('Declined Application!');

    }

    public function filterMemberApplication(Request $request)
    {

        $query = PremiumMembership::query();

        if ($request->filled('datef')) {
            $query->whereDate('created_at', '>=', $request->input('datef'));
        }

        if ($request->filled('datet')) {
            $query->whereDate('created_at', '<=', $request->input('datet'));
        }

        if ($request->filled('user_id')) {
            $query->where('action_by', $request->input('user_id'));
        }
        if ($request->filled('status')) {
            $query->where('request_status', $request->input('status'));
        }
        if ($request->filled('channel_name')) {
            $query->where('channel_name', $request->input('channel_name'));
        }

        $paginationLimit = $request->input('pagination_limit', 50);
        $memberships = $query->paginate($paginationLimit);
        $employees = User::where('role_id',4)->get();

        return view('backend.premiummember.filter', compact('memberships', 'paginationLimit', 'employees'));
    }


    public function waitingMemberApplication(Request $request)
    {
        $memberships = PremiumMembership::where('id',$request->waiting_id)->first();

        $memberships->action_by        = auth::user()->id;
        $memberships->action_at        = now();
        $memberships->waiting_note     = $request->waiting_note;
        $memberships->expected_waiting_date     = $request->expected_waiting_date;
        $memberships->request_status   = 'waiting';
        $memberships->payment_status   = 'unpaid';
        $memberships->waiting_note_update_date  = now();
        $memberships->update();
        return redirect()->back()->withMessage('waiting Application!');

    }

    public function sendTutorReviews(Request $request)
    {
        $request->validate([
            'tutor_id' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'required|string|min:20',
        ]);
        $existingReview = TutorReview::where('emp_id', Auth::user()->id)
            ->where('tutor_id', $request->tutor_id)
            ->exists();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'You have already submitted a review for this tutor.'
            ], 400);
        }

        // Create a new review
        TutorReview::create([
            'tutor_id' => $request->tutor_id,
            'emp_id' => Auth::user()->id,
            'rating' => $request->rating,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully!'
        ], 201);
    }


    public function makeTutorBoost(Request $request,$tutor)
    {

        $tutor= Tutor::where('id',$tutor)->firstOrFail();

        $tutor->is_boost = 1;
        $tutor->boost_date = now();
        $tutor->boost_package = $request->boost_package;
        $tutor->boost_expire = now()->addMonths($request->boost_package);
        $tutor->save();


        $transction = new ApplicationPayment();
        $transction->tutor_id            = $tutor->id ;
        $transction->received_amount     = $request->taka;
        $transction->trx_id              = $request->transction_id;
        $transction->render_by           = Auth::user()->id;
        $transction->payment_method      = $request->payment_method ?? "Bkash";
        $transction->service_category    = "profile boost";
        $transction->save();
        return redirect()->back()->withMessage('Success! tutor marked as boost tutor successfully');

    }


    public function getAllTutor(Request $request)
    {
        $input = 1000; // pagination limit

        // Get tutors (without AVG) with ID between 1 and 100
        $tutors = Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
        ])
        ->where('is_active', 1)
        // ->where('id',106078)
        ->whereBetween('id', [244001, 245000])
        ->inRandomOrder()// IDs from 1 to 100
        ->orderBy('id', 'desc')
        ->paginate($input);

        return $tutors;
    }



}
