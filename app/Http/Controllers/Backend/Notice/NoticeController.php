<?php

namespace App\Http\Controllers\Backend\Notice;

use App\Http\Controllers\Controller;
use App\Models\AllNotice;
use App\Models\Backend\Config\TutorRequirementTemplate;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Course;
use App\Models\Curriculam;
use App\Models\Department;
use App\Models\Institute;
use App\Models\Location;
use App\Models\MarketeingSms;
use App\Models\Marketting;
use App\Models\Parents;
use App\Models\PopupImage;
use App\Models\PopupImageData;
use App\Models\PopupNotification;
use App\Models\SmsMarketing;
use App\Models\Study;
use App\Models\Subject;
use App\Models\TeachingMethod;
use App\Models\Tutor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class NoticeController extends Controller
{
    public function allNotice()
    {

        $countries         = Country::orderBy('id', 'ASC')->get();
        // $tutors= Tutor::orderBy('id', 'ASC')->get();
        $departments       = Department::orderBy('id', 'ASC')->get();
        $categories        = Category::orderBy('id', 'ASC')->get();
        $departments       = Department::orderBy('id', 'ASC')->get();
        $courses           = Course::orderBy('id', 'ASC')->get();
        $institutes        = Institute::orderBy('id', 'ASC')->get();
        $teaching_methods  = TeachingMethod::all();
        $subjects          = Subject::orderBy('id', 'ASC')->get();
        $studies           = Study::orderBy('id', 'ASC')->get();
        $curriculams       = Curriculam::orderBy('id', 'ASC')->get();
        $templates         = TutorRequirementTemplate::orderBy('id', 'ASC')->get();
        $cities            = City::orderBy('id', 'ASC')->get();
        $locations         = Location::orderBy('id', 'ASC')->get();

        $notices = Marketting::orderBy('id', 'desc')->withTrashed()->paginate(10);

        return view('backend.notice.all_notice',compact('locations','cities','countries','departments','categories',
        'departments','courses','institutes','teaching_methods','subjects','studies','curriculams','templates','notices'));
    }

    public function noticeTutorFilter(Request $request)
    {
        $input = $request->input('pagination_limit') ?? 200;
        $countryId              = $request->country_id;
        $cityId                 = $request->city_id;
        $locationId             = $request->location_id;
        $dateFrom               = $request->date_from;
        $dateTo                 = $request->date_to;
        $year                   = $request->year;
        $gender                 = $request->gender;
        $catId                  = $request->category_id;
        $courseId               = $request->course_id;
        $subId                  = $request->subject_id;
        $studyType              = $request->study_type_id;
        $SscCurriculmnId        = $request->ssc_curriculum_id;
        $honoursUniversity      = $request->tutor_university_id;
        $universityType         = $request->tutor_university_type;
        $honoursDeptId          = $request->department_id;
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
        ->where('is_active', 1);

        if (!empty($countryId)) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($countryId) {
                $subQuery->where('country_id', $countryId);
            });
        }

        if (!empty($cityId)) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($cityId) {
                $subQuery->where('city_id', $cityId);
            });
        }

        if (!empty($locationId)) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($locationId) {
                $subQuery->where('location_id', $locationId);
            });
        }

        if (!empty($teachingMethod)) {
            $tutorsQuery->whereHas('teaching_method', function ($subQuery) use ($teachingMethod) {
                $subQuery->where('method_id', $teachingMethod);
            });
        }

        if (!empty($dateFrom)) {
            $dateTo = $dateTo ?? now()->toDateString();
            $tutorsQuery->whereBetween('created_at', [$dateFrom, $dateTo]);
        }

        if (!empty($year) && $year !== 'Select Year') {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($year) {
                $subQuery->where('degree_name', 'honours')
                         ->where('year_or_semester', $year);
            });
        }

        if (!empty($SscCurriculmnId)) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($SscCurriculmnId) {
                $subQuery->where('degree_name', 'ssc')
                         ->where('curriculum_id', $SscCurriculmnId);
            });
        }
        if (!empty($universityType)) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($universityType) {
                $subQuery->where('degree_name', 'honours')
                         ->where('university_type', $universityType);
            });
        }

        if (!empty($gender)) {
            $tutorsQuery->where('gender', $gender);
        }

        if (!empty($catId)) {
            $tutorsQuery->whereHas('tutor_categories', function ($subQuery) use ($catId) {
                $subQuery->whereIn('category_id', (array) $catId);
            });
        }

        if (!empty($courseId)) {
            $tutorsQuery->whereHas('tutor_course', function ($subQuery) use ($courseId) {
                $subQuery->whereIn('course_id', (array) $courseId);
            });
        }
        if (!empty($subId)) {
            $tutorsQuery->whereHas('tutor_subject', function ($subQuery) use ($subId) {
                $subQuery->whereIn('subject_id', (array) $subId);
            });
        }

        if (!empty($studyType)) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($studyType) {
                $subQuery->whereIn('study_type_id', (array) $studyType);
            });
        }

        if (!empty($honoursUniversity)) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($honoursUniversity) {
                $subQuery->where('degree_name', 'honours')
                         ->whereIn('institute_id', (array) $honoursUniversity);
            });
        }

        if (!empty($honoursDeptId)) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($honoursDeptId) {
                $subQuery->where('degree_name', 'honours')
                         ->whereIn('department_id', (array) $honoursDeptId);
            });
        }

        $query = $tutorsQuery->orderBy('id', 'desc');

        $rawSql = $query->toSql();
        $bindings = $query->getBindings();



        return response()->json([
            'status' => 'success',
            'raw_sql' => vsprintf(str_replace('?', '"%s"', $rawSql), $bindings),
            'userType' => request('userType')
        ]);

    }
    public function noticeParentFilter(Request $request)
    {
        $paginationLimit = $request->input('pagination_limit', 200);
        $dateFrom = $request->input('datefp');
        $dateTo = $request->input('datetp');
        $countryId              = $request->country_id;
        $cityId                 = $request->city_id;
        $locationId             = $request->location_id;
        $verified_status        = $request->is_verified;


        $parentsQuery = Parents::with([
            'parents_personalInfo',
        ])
        ->where('is_active', 1);

        if ($dateFrom && $dateTo) {
            $parentsQuery->whereBetween('created_at', [$dateFrom, $dateTo]);
        }


        if (!empty($verified_status)) {
            $parentsQuery->where('is_verified',$verified_status);
        }
        if (!empty($countryId)) {
            $parentsQuery->whereHas('parents_personalInfo', function ($subQuery) use ($countryId) {
                $subQuery->where('country_id', $countryId);
            });
        }

        if (!empty($cityId)) {
            $parentsQuery->whereHas('parents_personalInfo', function ($subQuery) use ($cityId) {
                $subQuery->where('city_id', $cityId);
            });
        }

        if (!empty($locationId)) {
            $parentsQuery->whereHas('parents_personalInfo', function ($subQuery) use ($locationId) {
                $subQuery->where('location_id', $locationId);
            });
        }

        $parentsQuery->orderBy('id', 'desc');

        $rawSql = vsprintf(
            str_replace('?', '"%s"', $parentsQuery->toSql()),
            $parentsQuery->getBindings()
        );

        $parents = $parentsQuery->get();
        $count = $parents->count();

        return response()->json([
            'status' => 'success',
            'raw_sql' => $rawSql,
            'userType' => $request->input('userType'),
        ]);
    }



    public function noticeSendFilter(Request $request)
    {
        $marketting = new Marketting();
        $marketting->title = $request->input('title');
        $marketting->description = $request->input('description');
        $marketting->query = $request->input('query');
        $marketting->audience = $request->input('count');
        $marketting->status = 0;
        $marketting->campain_status = 'pending';
        $marketting->user_type = $request->user_type;

        if ($request->input('send_now') == 1) {
            $marketting->send_now = now()->addMinutes(2);
            $marketting->send_latter = null;
        } else {
            $marketting->send_now = null;
            $marketting->send_latter = $request->input('send_later_time');
        }

        $marketting->save();

        return response()->json([
            'status' => 'success',
            'message' => 'SMS scheduled successfully!',
        ]);
    }

    public function NoticeTest(Request $request)
    {

    }
    public function statusChange(Request $request)
    {
        $item = Marketting::find($request->id);

        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item not found!'
            ], 404);
        }

        $item->status = $request->state;

        if ($request->state == 0) {
            $item->campain_status = 'deactive';

            AllNotice::where('marketting_id', $item->id)->update(['status' => 0]);
        } elseif ($request->state == 1) {
            $item->campain_status = 'accepted';

            AllNotice::where('marketting_id', $item->id)->update([
                'status' => 1,
                'created_at' => now()
            ]);

            if ($item->user_type == 'tutor' && isset($item->query)) {
                $tutors = DB::select($item->query);
                $tutorIds = collect($tutors)->pluck('id')->filter();
                $tutorCount = $tutorIds->count();

                $item->update([
                    'updated_audience' => $tutorCount,
                    'status'           => 1,
                    'campain_status'   => 'accepted'
                ]);

                $existingTutorIds = [];
                foreach ($tutorIds->chunk(1000) as $chunk) {
                    $ids = AllNotice::whereIn('tutor_id', $chunk->toArray())
                        ->where('marketting_id', $item->id)
                        ->pluck('tutor_id')
                        ->toArray();
                    $existingTutorIds = array_merge($existingTutorIds, $ids);
                }

                $missingTutorIds = array_diff($tutorIds->toArray(), $existingTutorIds);

                $newNotices = [];
                foreach ($missingTutorIds as $tutor) {
                    $newNotices[] = [
                        'user_type'     => $item->user_type,
                        'tutor_id'      => $tutor,
                        'status'        => 1,
                        'marketting_id' => $item->id,
                        'title'         => $item->title,
                        'description'   => $item->description,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ];
                }

                foreach (array_chunk($newNotices, 100) as $chunk) {
                    AllNotice::insert($chunk);
                }
            } elseif ($item->user_type == 'parent' && isset($item->query)) {
                $parents = DB::select($item->query);
                $parentIds = collect($parents)->pluck('id')->filter();
                $parentCount = $parentIds->count();

                $item->update([
                    'updated_audience' => $parentCount,
                    'status'           => 1,
                    'campain_status'   => 'accepted'
                ]);

                $existingParentIds = [];
                foreach ($parentIds->chunk(1000) as $chunk) {
                    $ids = AllNotice::whereIn('parent_id', $chunk->toArray())
                        ->where('marketting_id', $item->id)
                        ->pluck('parent_id')
                        ->toArray();
                    $existingParentIds = array_merge($existingParentIds, $ids);
                }

                $missingParentIds = array_diff($parentIds->toArray(), $existingParentIds);

                $newNotices = [];
                foreach ($missingParentIds as $parent) {
                    $newNotices[] = [
                        'user_type'     => $item->user_type,
                        'parent_id'     => $parent,
                        'status'        => 1,
                        'marketting_id' => $item->id,
                        'title'         => $item->title,
                        'description'   => $item->description,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ];
                }

                foreach (array_chunk($newNotices, 100) as $chunk) {
                    AllNotice::insert($chunk);
                }
            }
        }

        $item->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status updated successfully!'
        ]);
    }



    public function noticeSend(Request $request)
    {
        $notice = Marketting::where(function ($query) {
                $query->where('send_now', '<=', now())
                    ->orWhere('send_latter', '<=', now());
            })
            ->where('status',0)
            ->where(function ($query) {
                $query->where('campain_status', 'pending')
                    ->orWhere('campain_status', 'accepted');
            })
            ->first();


        if ($notice && isset($notice->query)) {
            $tutors = DB::select($notice->query);

            $tutorIds = collect($tutors)->pluck('id')->filter();
            $tutorCount = $tutorIds->count();

            $notice->updated_audience = $tutorCount;
            $notice->status = 1;
            $notice->campain_status = 'accepted';
            $notice->update();

            foreach ($tutorIds as  $tutor) {

                $tutorNotice = new AllNotice();
                $tutorNotice->user_type = $notice->user_type;
                $tutorNotice->tutor_id = $tutor;
                $tutorNotice->status = 1;
                $tutorNotice->marketting_id = $notice->id;
                $tutorNotice->title = $notice->title;
                $tutorNotice->description = $notice->description;
                $tutorNotice->save();

            }
        } else {
            return response()->json(['message' => 'No valid notice found'], 404);
        }
    }


    public function noticeDelete($id)
    {
        $marketting = Marketting::find($id);

        if ($marketting) {
            $marketting->forceDelete();
            $marketting->update([
                'status'=>0,
                'campain_status'=>'deactive',
            ]);
            $notices = AllNotice::where('marketting_id', $id)->forceDelete();
            return response()->json([
                'status' => 'success',
                'message' => 'Notice deleted successfully!'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Notice not found!'
        ], 404);
    }

    public function noticeRestore($id)
    {
        $marketting = Marketting::withTrashed()->find($id);

        if ($marketting) {

            $marketting->restore();

            return response()->json([
                'status' => 'success',
                'message' => 'Notice restored successfully!'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Notice not found!'
        ]);
    }
    public function edit($id)
    {
        $item = Marketting::findOrFail($id);

        return response()->json($item);
    }

    public function markettinPlanUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $model = Marketting::findOrFail($request->id);

        $model->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'message' => 'Notice updated successfully']);
    }


    public function unitNoticeSend(Request $request)
    {
        $numbers = preg_split('/\r\n|\r|\n/', trim($request->numbers));
        $numbers = array_filter($numbers);

        $validator = Validator::make($request->all(), [
            'user_type' => 'required|in:tutor,parent',
            'title' => 'required|string|max:30',
            'description' => 'required|string|max:250',
            'send_now' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $userType = $request->user_type;
        $rawSql = null;

        if ($userType == 'tutor') {
            $query = Tutor::where('is_active', 1)->whereIn('phone', $numbers);
        } elseif ($userType == 'parent') {
            $query = Parents::where('is_active', 1)->whereIn('phone', $numbers);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Invalid user type'], 422);
        }

        $rawSql = vsprintf(str_replace('?', '"%s"', $query->toSql()), $query->getBindings());

        $marketing = new Marketting();
        $marketing->title = $request->title;
        $marketing->description = $request->description;
        $marketing->query = $rawSql;
        $marketing->user_type = $request->user_type;
        $marketing->status = 0;
        $marketing->campain_status = 'pending';
        $marketing->send_now = now()->addMinutes(10);
        $marketing->save();

        return redirect()->back()->with('success', 'Notice scheduled successfully');
    }


    // Popup Image Function Start

    public function allPopupImage()
    {
        $countries         = Country::orderBy('id', 'ASC')->get();
        // $tutors= Tutor::orderBy('id', 'ASC')->get();
        $departments       = Department::orderBy('id', 'ASC')->get();
        $categories        = Category::orderBy('id', 'ASC')->get();
        $departments       = Department::orderBy('id', 'ASC')->get();
        $courses           = Course::orderBy('id', 'ASC')->get();
        $institutes        = Institute::orderBy('id', 'ASC')->get();
        $teaching_methods  = TeachingMethod::all();
        $subjects          = Subject::orderBy('id', 'ASC')->get();
        $studies           = Study::orderBy('id', 'ASC')->get();
        $curriculams       = Curriculam::orderBy('id', 'ASC')->get();
        $templates         = TutorRequirementTemplate::orderBy('id', 'ASC')->get();
        $cities            = City::orderBy('id', 'ASC')->get();
        $locations         = Location::orderBy('id', 'ASC')->get();

        $popupImages = PopupNotification::orderBy('id', 'desc')->withTrashed()->paginate(10);

        return view('backend.popupimage.all_popup_image',compact('locations','cities','countries','departments','categories',
        'departments','courses','institutes','teaching_methods','subjects','studies','curriculams','templates','popupImages'));

    }


    public function popupTutorFilter(Request $request)
    {
        $input = $request->input('pagination_limit') ?? 200;
        $countryId              = $request->country_id;
        $cityId                 = $request->city_id;
        $locationId             = $request->location_id;
        $dateFrom               = $request->date_from;
        $dateTo                 = $request->date_to;
        $year                   = $request->year;
        $gender                 = $request->gender;
        $catId                  = $request->category_id;
        $courseId               = $request->course_id;
        $subId                  = $request->subject_id;
        $studyType              = $request->study_type_id;
        $SscCurriculmnId        = $request->ssc_curriculum_id;
        $honoursUniversity      = $request->tutor_university_id;
        $universityType         = $request->tutor_university_type;
        $honoursDeptId          = $request->department_id;
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
        ->where('is_active', 1);

        if (!empty($countryId)) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($countryId) {
                $subQuery->where('country_id', $countryId);
            });
        }

        if (!empty($cityId)) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($cityId) {
                $subQuery->where('city_id', $cityId);
            });
        }

        if (!empty($locationId)) {
            $tutorsQuery->whereHas('tutor_personal_info', function ($subQuery) use ($locationId) {
                $subQuery->where('location_id', $locationId);
            });
        }

        if (!empty($teachingMethod)) {
            $tutorsQuery->whereHas('teaching_method', function ($subQuery) use ($teachingMethod) {
                $subQuery->where('method_id', $teachingMethod);
            });
        }

        if (!empty($dateFrom)) {
            $dateTo = $dateTo ?? now()->toDateString();
            $tutorsQuery->whereBetween('created_at', [$dateFrom, $dateTo]);
        }

        if (!empty($year) && $year !== 'Select Year') {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($year) {
                $subQuery->where('degree_name', 'honours')
                         ->where('year_or_semester', $year);
            });
        }

        if (!empty($SscCurriculmnId)) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($SscCurriculmnId) {
                $subQuery->where('degree_name', 'ssc')
                         ->where('curriculum_id', $SscCurriculmnId);
            });
        }
        if (!empty($universityType)) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($universityType) {
                $subQuery->where('degree_name', 'honours')
                         ->where('university_type', $universityType);
            });
        }

        if (!empty($gender)) {
            $tutorsQuery->where('gender', $gender);
        }

        if (!empty($catId)) {
            $tutorsQuery->whereHas('tutor_categories', function ($subQuery) use ($catId) {
                $subQuery->whereIn('category_id', (array) $catId);
            });
        }

        if (!empty($courseId)) {
            $tutorsQuery->whereHas('tutor_course', function ($subQuery) use ($courseId) {
                $subQuery->whereIn('course_id', (array) $courseId);
            });
        }
        if (!empty($subId)) {
            $tutorsQuery->whereHas('tutor_subject', function ($subQuery) use ($subId) {
                $subQuery->whereIn('subject_id', (array) $subId);
            });
        }

        if (!empty($studyType)) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($studyType) {
                $subQuery->whereIn('study_type_id', (array) $studyType);
            });
        }

        if (!empty($honoursUniversity)) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($honoursUniversity) {
                $subQuery->where('degree_name', 'honours')
                         ->whereIn('institute_id', (array) $honoursUniversity);
            });
        }

        if (!empty($honoursDeptId)) {
            $tutorsQuery->whereHas('tutor_education', function ($subQuery) use ($honoursDeptId) {
                $subQuery->where('degree_name', 'honours')
                         ->whereIn('department_id', (array) $honoursDeptId);
            });
        }

        $query = $tutorsQuery->orderBy('id', 'desc');

        $rawSql = $query->toSql();
        $bindings = $query->getBindings();



        return response()->json([
            'status' => 'success',
            'raw_sql' => vsprintf(str_replace('?', '"%s"', $rawSql), $bindings),
            'userType' => request('userType')
        ]);

    }
    public function popupParentFilter(Request $request)
    {
        $paginationLimit = $request->input('pagination_limit', 200);
        $dateFrom = $request->input('datefp');
        $dateTo = $request->input('datetp');
        $countryId              = $request->country_id;
        $cityId                 = $request->city_id;
        $locationId             = $request->location_id;
        $verified_status        = $request->is_verified;


        $parentsQuery = Parents::with([
            'parents_personalInfo',
        ])
        ->where('is_active', 1);

        if ($dateFrom && $dateTo) {
            $parentsQuery->whereBetween('created_at', [$dateFrom, $dateTo]);
        }


        if (!empty($verified_status)) {
            $parentsQuery->where('is_verified',$verified_status);
        }
        if (!empty($countryId)) {
            $parentsQuery->whereHas('parents_personalInfo', function ($subQuery) use ($countryId) {
                $subQuery->where('country_id', $countryId);
            });
        }

        if (!empty($cityId)) {
            $parentsQuery->whereHas('parents_personalInfo', function ($subQuery) use ($cityId) {
                $subQuery->where('city_id', $cityId);
            });
        }

        if (!empty($locationId)) {
            $parentsQuery->whereHas('parents_personalInfo', function ($subQuery) use ($locationId) {
                $subQuery->where('location_id', $locationId);
            });
        }

        $parentsQuery->orderBy('id', 'desc');

        $rawSql = vsprintf(
            str_replace('?', '"%s"', $parentsQuery->toSql()),
            $parentsQuery->getBindings()
        );

        $parents = $parentsQuery->get();
        $count = $parents->count();

        return response()->json([
            'status' => 'success',
            'raw_sql' => $rawSql,
            'userType' => $request->input('userType'),
        ]);
    }


    public function popupSendFilter(Request $request)
    {
        // Validate form data
        $validator = Validator::make($request->all(), [
            'user_type' => 'required|string',
            'placement_url' => 'required',
            'navigate_link' => 'nullable',
            'query' => 'required',
            'image' => 'required|image|mimes:jpeg,png,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        }

        $popup = new PopupNotification();
        $popup->query = $request->input('query');
        $popup->click_type = $request->input('click_type');
        if ($request->input('send_now') == 1) {
            $popup->send_now = now()->addMinutes(2);
            $popup->send_latter = null;
        } else {
            $popup->send_now = null;
            $popup->send_latter = Carbon::parse($request->input('send_later_time'))->addMinutes(2);
        }
        $popup->status = 0;
        $popup->campain_status = 'pending';
        $popup->user_type = $request->user_type;
        $popup->placement_url = $request->placement_url;
        $popup->navigate_link = $request->navigate_link;
        $popup->image = isset($imagePath) ? $imagePath : null;
        $popup->save();

        return response()->json([
            'success' => true,
            'message' => 'Popup sent successfully!',
            'data' => $popup
        ]);
    }

    public function statusChangePopup(Request $request)
    {
        $item = PopupNotification::find($request->id);
        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item not found!'
            ], 404);
        }

        $item->status = $request->state;

        if ($request->state == 0) {
            $item->campain_status = 'deactive';
            PopupImageData::where('popupnotification_id', $item->id)->update(['status' => 0]);

        } elseif ($request->state == 1) {
            $item->campain_status = 'accepted';

            PopupImageData::where('popupnotification_id', $item->id)->update([
                'status' => 1,
                'created_at' => now()
            ]);

            if ($item->user_type == 'tutor' && isset($item->query)) {
                $tutors = DB::select($item->query);
                $tutorIds = collect($tutors)->pluck('id')->filter();
                $tutorCount = $tutorIds->count();

                $item->update([
                    'updated_audience' => $tutorCount,
                    'status'           => 1,
                    'campain_status'   => 'accepted'
                ]);

                $existingTutorIds = PopupImageData::whereIn('tutor_id', $tutorIds)
                                                ->where('popupnotification_id', $item->id)
                                                ->pluck('tutor_id')
                                                ->toArray();
                $missingTutorIds = array_diff($tutorIds->toArray(), $existingTutorIds);

                $newNotices = [];
                foreach ($missingTutorIds as $tutor) {
                    $newNotices[] = [
                        'user_type'            => $item->user_type,
                        'tutor_id'             => $tutor,
                        'status'               => 1,
                        'popupnotification_id' => $item->id,
                        'placement_url'        => $item->placement_url,
                        'navigate_link'        => $item->navigate_link,
                        'image'                => $item->image,
                        'created_at'           => now(),
                        'updated_at'           => now(),
                    ];
                }

                foreach (array_chunk($newNotices, 100) as $chunk) {
                    PopupImageData::insert($chunk);
                }

            } elseif ($item->user_type == 'parent' && isset($item->query)) {
                $parents = DB::select($item->query);
                $parentIds = collect($parents)->pluck('id')->filter();
                $parentCount = $parentIds->count();

                $item->update([
                    'updated_audience' => $parentCount,
                    'status'           => 1,
                    'campain_status'   => 'accepted'
                ]);

                $existingParentIds = PopupImageData::whereIn('parent_id', $parentIds)
                                                ->where('popupnotification_id', $item->id)
                                                ->pluck('parent_id')
                                                ->toArray();
                $missingParentIds = array_diff($parentIds->toArray(), $existingParentIds);

                $newNotices = [];
                foreach ($missingParentIds as $parent) {
                    $newNotices[] = [
                        'user_type'            => $item->user_type,
                        'parent_id'            => $parent,
                        'status'               => 1,
                        'popupnotification_id' => $item->id,
                        'placement_url'        => $item->placement_url,
                        'navigate_link'        => $item->navigate_link,
                        'image'                => $item->image,
                        'created_at'           => now(),
                        'updated_at'           => now(),
                    ];
                }

                foreach (array_chunk($newNotices, 100) as $chunk) {
                    PopupImageData::insert($chunk);
                }
            }
        }

        $item->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status updated successfully!'
        ]);
    }


    public function unitPopupSend(Request $request)
    {

        // dd($request->all());
        $numbers = preg_split('/\r\n|\r|\n/', trim($request->numbers));
        $numbers = array_filter($numbers);

        $validator = Validator::make($request->all(), [
            'user_type'=>'required',
            'click_type'=>'required',
            'placement_url'=>'nullable',
            'navigate_link'=>'nullable',
            'title'=>'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $userType = $request->user_type;
        $rawSql = null;

        if ($userType == 'tutor') {
            $query = Tutor::where('is_active', 1)->whereIn('phone', $numbers);
        } elseif ($userType == 'parent') {
            $query = Parents::where('is_active', 1)->whereIn('phone', $numbers);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Invalid user type'], 422);
        }

        $rawSql = vsprintf(str_replace('?', '"%s"', $query->toSql()), $query->getBindings());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        }
        $popup = new PopupNotification();
        $popup->title           = $request->title;
        $popup->click_type      = $request->click_type;
        $popup->placement_url   = $request->placement_url;
        $popup->navigate_link   = $request->navigate_link;
        $popup->query           = $rawSql;
        $popup->user_type       = $request->user_type;
        $popup->status          = 0;
        $popup->campain_status  = 'pending';
        $popup->send_now        = now()->addMinutes(10);
        $popup->image = isset($imagePath) ? $imagePath : null;


        $popup->save();

        return redirect()->back()->with('success', 'Notice scheduled successfully');
    }

    public function popupDelete($id)
    {
        $popup = PopupNotification::find($id);

        if ($popup) {
            $popup->forceDelete();

            $popupImage = PopupImageData::where('popupnotification_id', $id)->forceDelete();
            return response()->json([
                'status' => 'success',
                'message' => 'Popup deleted successfully!'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Notice not found!'
        ], 404);
    }

    // SMS Marketting function
    public function smsMarketting()
    {
        $countries         = Country::orderBy('id', 'ASC')->get();
        // $tutors= Tutor::orderBy('id', 'ASC')->get();
        $departments       = Department::orderBy('id', 'ASC')->get();
        $categories        = Category::orderBy('id', 'ASC')->get();
        $departments       = Department::orderBy('id', 'ASC')->get();
        $courses           = Course::orderBy('id', 'ASC')->get();
        $institutes        = Institute::orderBy('id', 'ASC')->get();
        $teaching_methods  = TeachingMethod::all();
        $subjects          = Subject::orderBy('id', 'ASC')->get();
        $studies           = Study::orderBy('id', 'ASC')->get();
        $curriculams       = Curriculam::orderBy('id', 'ASC')->get();
        $templates         = TutorRequirementTemplate::orderBy('id', 'ASC')->get();
        $cities            = City::orderBy('id', 'ASC')->get();
        $locations         = Location::orderBy('id', 'ASC')->get();

        $smsMarketing = SmsMarketing::orderBy('id', 'desc')->paginate(10);

        return view('backend.smsmarketting.sms_marketting',compact('smsMarketing','locations','cities','countries','departments','categories',
        'departments','courses','institutes','teaching_methods','subjects','studies','curriculams','templates'));

    }

    public function sendMarketingSms(Request $request)
    {
        $marketting = new SmsMarketing();
        $marketting->title = $request->input('title');
        $marketting->sms_body = $request->input('sms_body');
        $marketting->query = $request->input('query');
        $marketting->status = 0;
        $marketting->campain_status = 'pending';
        $marketting->user_type = $request->user_type;
        $marketting->recurring = $request->input('recurring');

        if ($request->input('send_now') == 1) {
            $marketting->send_now = now()->addMinutes(2);
            $marketting->send_latter = null;

        } else {
            $marketting->send_now = null;
            $marketting->send_latter = $request->input('send_later_time');

        }

        $marketting->save();

        return response()->json([
            'status' => 'success',
            'message' => 'SMS scheduled successfully!',
        ]);
    }

    public function statusChangeSms(Request $request)
    {
        $item = SmsMarketing::find($request->id);
        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item not found!'
            ], 404);
        }

        $item->status = $request->state;

        if ($request->state == 0) {
            $item->campain_status = 'deactive';
            MarketeingSms::where('marketing_id', $item->id)->forceDelete();

        } elseif ($request->state == 1) {
            $item->campain_status = 'accepted';
            MarketeingSms::where('marketing_id', $item->id)->update([
                'status' => 1,
                'created_at' => now()
            ]);

            if ($item->user_type == 'tutor') {
                if ($item && isset($item->query)) {
                    $tutors = DB::select($item->query);
                    $tutorsArray = collect($tutors)->map(function ($row) {
                        return (array) $row;
                    });

                    $tutorIds = $tutorsArray->pluck('id', 'phone')->filter();
                    $tutorCount = $tutorIds->count();

                    $item->update([
                        'updated_audience' => $tutorCount,
                        'status'           => 1,
                        'campain_status'   => 'accepted'
                    ]);

                    $existingTutorIds = MarketeingSms::whereIn('tutor_id', $tutorIds)
                        ->where('marketing_id', $item->id)
                        ->pluck('tutor_id')
                        ->toArray();

                    $newSms = [];

                    foreach ($tutorIds as $phone => $id) {
                        if (!in_array($id, $existingTutorIds)) {
                            MarketeingSms::create([
                                'user_type'    => $item->user_type,
                                'tutor_id'     => $id,
                                'marketing_id' => $item->id,
                                'phone'        => $phone,
                                'status'       => 0,
                                'sms_body'     => $item->sms_body,
                            ]);

                        }
                    }


                }

            } elseif ($item->user_type == 'parent') {
                if ($item && isset($item->query)) {
                    $parents = DB::select($item->query);
                    $parentsArray = collect($parents)->map(function ($row) {
                        return (array) $row;
                    });

                    $parentIds = $parentsArray->pluck('id', 'phone')->filter();
                    $parentCount = $parentIds->count();

                    $item->update([
                        'updated_audience' => $parentCount,
                        'status'           => 1,
                        'campain_status'   => 'accepted'
                    ]);

                    $existingParentIds = MarketeingSms::whereIn('parent_id', $parentIds)
                        ->where('marketing_id', $item->id)
                        ->pluck('parent_id')
                        ->toArray();

                    $newSms = [];

                    foreach ($parentIds as $phone => $id) {
                        if (!in_array($id, $existingParentIds)) {
                            MarketeingSms::create([
                                'user_type'    => $item->user_type,
                                'parent_id'    => $id,
                                'marketing_id' => $item->id,
                                'phone'        => $phone,
                                'status'       => 0,
                                'sms_body'     => $item->sms_body,
                            ]);
                        }
                    }

                }
            }

        }

        $item->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status updated successfully!'
        ]);
    }

    // Sms Marketting function Unit
    public function smsMarketingUnit()
    {
        $countries         = Country::orderBy('id', 'ASC')->get();
        // $tutors= Tutor::orderBy('id', 'ASC')->get();
        $departments       = Department::orderBy('id', 'ASC')->get();
        $categories        = Category::orderBy('id', 'ASC')->get();
        $departments       = Department::orderBy('id', 'ASC')->get();
        $courses           = Course::orderBy('id', 'ASC')->get();
        $institutes        = Institute::orderBy('id', 'ASC')->get();
        $teaching_methods  = TeachingMethod::all();
        $subjects          = Subject::orderBy('id', 'ASC')->get();
        $studies           = Study::orderBy('id', 'ASC')->get();
        $curriculams       = Curriculam::orderBy('id', 'ASC')->get();
        $templates         = TutorRequirementTemplate::orderBy('id', 'ASC')->get();
        $cities            = City::orderBy('id', 'ASC')->get();
        $locations         = Location::orderBy('id', 'ASC')->get();


        $smsMarketing = SmsMarketing::orderBy('id', 'desc')->paginate(10);


        return view('backend.smsmarketting.unit_sms_marketting',compact('smsMarketing','locations','cities','countries','departments','categories',
        'departments','courses','institutes','teaching_methods','subjects','studies','curriculams','templates'));
    }

    public function smsMarketingUnitFilter(Request $request)
    {
        $validated = $request->validate([
            'numbers' => 'required|string',
            'sms_body' => 'required|string|max:250',
            'title'    => 'nullable|string|max:30',
        ]);

        $rawNumbers = str_replace(["\r", "\n"], ',', $validated['numbers']);
        $numbers = array_filter(array_map('trim', explode(',', $rawNumbers)));

        if (empty($numbers)) {
            return response()->json(['message' => 'No valid numbers provided.'], 422);
        }

        $smsMarketing = new SmsMarketing();
        $smsMarketing->title = $request->title ?? null;
        $smsMarketing->user_type = 'unit';
        $smsMarketing->marketing_type = 'unit';
        $smsMarketing->status = 0;
        $smsMarketing->campain_status = 'pending';
        $smsMarketing->sms_body = $validated['sms_body'];
        $smsMarketing->query = json_encode($numbers);
        if ($request->input('send_now') == 1) {
            $smsMarketing->send_now = now()->addMinutes(2);
            $smsMarketing->send_latter = null;

        } else {
            $smsMarketing->send_now = null;
            $smsMarketing->send_latter = $request->input('send_later_time');

        }
        $smsMarketing->send_latter = $request->send_later_time;
        $smsMarketing->recurring = $request->recurring;
        $smsMarketing->save();

        return response()->json(['message' => 'SMS queued successfully.']);
    }

    public function smsMarketingUnitSendSms(Request $request)
    {
        $item = SmsMarketing::find($request->id);
        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item not found!'
            ], 404);
        }
        $item->status = $request->state;
        if ($request->state == 0) {
            $item->campain_status = 'deactive';
            MarketeingSms::where('marketing_id', $item->id)->forceDelete();

        } elseif ($request->state == 1) {
            $item->campain_status = 'accepted';
            $item->status = 1;
            try {
                $numbers = json_decode($item->query, true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                return response()->json(['message' => 'Invalid numbers format.'], 422);
            }
            if (!is_array($numbers)) {
                return response()->json(['message' => 'Invalid numbers format.'], 422);
            }
            $cleanedNumbers = array_unique(array_map('trim', $numbers));
            $item->updated_audience = count($cleanedNumbers);
            \Log::info('Cleaned Numbers: ', $cleanedNumbers);
            foreach ($cleanedNumbers as $number) {
                try {
                    MarketeingSms::create([
                        'user_type'    => $item->user_type,
                        'marketing_id' => $item->id,
                        'phone'        => $number,
                        'status'       => 0,
                        'sms_body'     => $item->sms_body,
                    ]);
                } catch (\Exception $e) {
                    \Log::error("Failed to create SMS for $number | " . $e->getMessage());
                }
            }
        }
        $item->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Status updated successfully!'
        ]);
    }

    public function smsMarketingDelete($id)
    {
        $marketting = SmsMarketing::find($id);

        if ($marketting) {
            $marketting->forceDelete();

            $sms = MarketeingSms::where('marketing_id', $id)->forceDelete();
            return response()->json([
                'status' => 'success',
                'message' => 'Notice deleted successfully!'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Notice not found!'
        ], 404);
    }




    // Popup Images
    public function popupImage()
    {
        $popupImages = PopupImage::orderBy('id', 'desc')->paginate(10);

        return view('backend.allpopupimage.index', compact('popupImages'));
    }

    public function popupImageSend(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'nullable|string|max:255',
            'click_type'      => 'required|in:popup,property',
            'placement_url'   => 'nullable',
            'navigate_link'   => 'nullable',
            'image'           => 'required|image|mimes:jpeg,png,gif|max:2048',
            'send_now'        => 'required|in:0,1',
            'send_later_time' => 'nullable|date',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        }

        // If sending later, validate timing
        if ($validated['send_later_time'] != null) {
            $sendLaterTime = Carbon::parse($validated['send_later_time']);
            if ($sendLaterTime->isPast()) {
                return response()->json(['message' => 'Send later time must be in the future.'], 422);
            }
            $validated['send_later_time'] = $sendLaterTime;
            $sendNow = null;
        } elseif ($validated['send_later_time'] == null) {
            $validated['send_later_time'] = null;
            $sendNow = 1;

        }
        // Save data
        PopupImage::create([
            'title'           => $validated['title'] ?? null,
            'send_later_time' => $sendLaterTime ?? null,
            'click_type'      => $validated['click_type'],
            'placement_url'   => $validated['placement_url'] ?? null,
            'navigate_link'   => $validated['navigate_link'] ?? null,
            'image'           => $imagePath,
            'send_now'        => $sendNow,
        ]);

        return response()->json(['success' => true, 'message' => 'Popup image saved successfully.']);
    }


    public function updateStatus(Request $request)
    {
        $item = PopupImage::find($request->id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item not found.']);
        }

        $item->status = $request->status ?? 0; // fallback to 0 if null
        $item->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.'
        ]);
    }

    public function popupItemDelete($id)
    {
        $popup = PopupImage::find($id);

        if ($popup) {
            if ($popup->image && Storage::disk('public')->exists($popup->image)) {
                Storage::disk('public')->delete($popup->image);
            }

            $popup->forceDelete();

            return response()->json([
                'status' => 'success',
                'message' => 'Popup deleted successfully!'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Popup not found!'
        ], 404);
    }





}