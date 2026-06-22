<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\JobOfferServiceInterface;
use App\Models\Bookmark;
use App\Models\JobOffer;
use App\Models\Tutor;
use App\Traits\ApiResponse;
use App\Transformers\JobOfferResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class BookmarkController extends Controller
{

    use ApiResponse;
    private $jobOfferRepository;
    public function __construct(JobOfferServiceInterface $jobOfferRepository)
    {
        $this->jobOfferRepository = $jobOfferRepository;

    }
    public function getObjects(Request $request)
    {
        $requestFor = $request->input('request_for');

        if (!in_array($requestFor, ['parent', 'tutor'])) {
            return response()->json(['error' => 'Invalid request_for parameter'], 400);
        }

        $bookmarks = Bookmark::when($requestFor === 'parent', function ($query) {
                            return $query->where('parent_id', Auth::user()->id);
                        })
                        ->when($requestFor === 'tutor', function ($query) {
                            return $query->where('tutor_id', Auth::user()->id);
                        })
                        ->orderBy('id', 'desc')
                        ->paginate(12); // ✅ Pagination here

        $responseData = [];

        foreach ($bookmarks as $bookmark) {
            if ($bookmark->bookmark_type === 'job') {
                $job = $this->jobOfferRepository->single($bookmark->target_id)->first();
                if ($job) {
                    $responseData[] = [
                        'bookmark_id'   => $bookmark->id,
                        'bookmark_type' => $bookmark->bookmark_type,
                        'job_details'   => new JobOfferResource($job),
                    ];
                }
            } elseif ($bookmark->bookmark_type === 'tutor') {

                $tutor = Tutor::with([
                    'tutor_education.institutes',
                    'tutor_personal_info',
                    'tutor_prefered_locations.city'
                ])->find($bookmark->target_id);

                if (!$tutor) {
                    continue;
                }

                $tutorEducationHonours = $tutor->tutor_education->firstWhere('degree_name', 'honours');
                $tutorEducationHSC = $tutor->tutor_education->firstWhere('degree_name', 'hsc');

                $responseData[] = [
                    'bookmark_id'         => $bookmark->id,
                    'bookmark_type'       => $bookmark->bookmark_type,
                    'target_id'           => $bookmark->target_id,
                    'created_at'          => $bookmark->created_at,
                    'tutor_id'            => $tutor->id,
                    'unique_id'           => $tutor->unique_id,
                    'tutor_image'         => $tutor->image,
                    'tutor_name'          => $tutor->name,
                    'tutor_gender'        => $tutor->gender,
                    'is_premium'          => $tutor->is_premium,
                    'is_premium_pro'      => $tutor->is_premium_pro,
                    'is_premium_advance'  => $tutor->is_premium_advance,
                    'is_boost'            => $tutor->is_boost,
                    'is_active'            => $tutor->is_active,
                    'is_verified'         => $tutor->is_verified,
                    'is_featured'         => $tutor->is_featured,
                    'tutor_location'      => $tutor->tutor_prefered_locations->first()->city->name ?? null,
                    'tutor_university'    => $tutorEducationHonours->institutes->title ?? null,
                    'tutor_college'       => $tutorEducationHSC->institutes->title ?? null,
                    'tutor_profile'       => $tutor->getProfileComplete(),
                ];
            }
        }

        return response()->json([
            'data' => $responseData,
            'pagination' => [
                'total'        => $bookmarks->total(),
                'per_page'     => $bookmarks->perPage(),
                'current_page' => $bookmarks->currentPage(),
                'last_page'    => $bookmarks->lastPage(),
            ]
        ]);
    }


    public function addBookmark(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bookmark_type' => 'required|string',
            'target_id' => 'required|integer',
            'request_for' => 'required|in:parent,tutor',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        $bookmarkType = $request->input('bookmark_type');
        $targetId = $request->input('target_id');
        $requestFor = $request->input('request_for');

        $userId = auth()->user()->id;

        $query = Bookmark::query()
            ->where('bookmark_type', $bookmarkType)
            ->where('target_id', $targetId);

        if ($requestFor === 'parent') {
            $query->where('parent_id', $userId);
        } else {
            $query->where('tutor_id', $userId);
        }

        if ($query->exists()) {
            return response()->json(['status' => false, 'message' => 'Already added to bookmark']);
        }

        $bookmark = new Bookmark();
        if ($requestFor === 'parent') {
            $bookmark->parent_id = $userId;
        } else {
            $bookmark->tutor_id = $userId;
        }
        $bookmark->bookmark_type = $bookmarkType;
        $bookmark->target_id = $targetId;
        $bookmark->save();

        return response()->json(['status' => true, 'message' => 'Bookmark added successfully']);
    }

    public function removeBookmark(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bookmark_type' => 'required|string',
            'target_id' => 'required|integer',
            'request_for' => 'required|in:parent,tutor',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        $bookmarkType = $request->input('bookmark_type');
        $targetId = $request->input('target_id');
        $requestFor = $request->input('request_for');
        $userId = auth()->user()->id;

        $query = Bookmark::query()
                ->where('bookmark_type', $bookmarkType)
                ->where('target_id', $targetId);



        if ($requestFor === 'parent') {
            $query->where('parent_id', $userId);
        } elseif($requestFor === 'tutor') {
            $query->where('tutor_id', $userId);
        }
        $objects = $query->first();


        if (!$query->exists()) {
            return response()->json(['status' => false, 'message' => 'Nothing Found']);
        }else {
            $objects->delete();
            return response()->json(['status' => true, 'message' => 'Bookmark removed successfully']);
        }




    }



}
