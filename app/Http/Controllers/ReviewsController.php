<?php

namespace App\Http\Controllers;

use App\Models\CategoryReview;
use App\Models\Tutor;
use App\Models\TutorReview;
use App\Models\WebsiteReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ReviewsController extends Controller
{
    public function sendReviews(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => 'nullable',
            'tutor_id' => 'required|exists:tutors,id',
            'emp_id' => 'nullable',
            'rating' => 'required|integer|between:1,5',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        $existingReview = TutorReview::where('parent_id', Auth::user()->id)
            ->where('tutor_id', $request->tutor_id)
            ->first();

        if ($existingReview) {
            return response()->json(['status' => false, 'message' => 'You have already submitted a review for this tutor.']);
        }

        $reviews = new TutorReview();
        $reviews->tutor_id = $request->tutor_id;
        $reviews->parent_id = Auth::user()->id;
        $reviews->rating = $request->rating;
        $reviews->description = $request->description;
        $reviews->save();

        return response()->json(['status' => true, 'message' => 'Review added successfully!']);
    }
    public function sendCategoryReviews(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => 'nullable',
            'category_id' => 'required',
            'emp_id' => 'nullable',
            'rating' => 'required|integer|between:1,5',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        $existingReview = CategoryReview::where('parent_id', Auth::user()->id)
            ->where('category_id', $request->category_id)
            ->first();

        if ($existingReview) {
            return response()->json(['status' => false, 'message' => 'You have already submitted a review for this category.']);
        }

        $reviews = new CategoryReview();
        $reviews->category_id = $request->category_id;
        $reviews->parent_id = Auth::user()->id;
        $reviews->rating = $request->rating;
        $reviews->description = $request->description;
        $reviews->save();

        return response()->json(['status' => true, 'message' => 'Review added successfully!']);
    }

    public function tutorReviews(Request $request)
    {
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->pagination_limit;
        $reviews = TutorReview::orderBy('id','desc')->paginate($paginationLimit);

        return view('backend.reviews.tutor_reviews',compact('paginationLimit','reviews','currentRoute'));


    }
    public function tutorTrashReviews(Request $request)
    {
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->pagination_limit;
        $reviews = TutorReview::onlyTrashed()->orderBy('id', 'desc')->paginate($paginationLimit);


        return view('backend.reviews.trash_tutor_reviews',compact('paginationLimit','reviews','currentRoute'));


    }
    public function tutorReviewDelete(Request $request, $id)
    {
        $review = TutorReview::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->action_by = Auth::user()->id;

        $review->update();
        $review->delete();

        return redirect()->back()->with('message', 'Review sended to trash.');
    }
    public function tutorReviewRestore(Request $request, $id)
    {
        $review = TutorReview::withTrashed()->where('id', $id)->first();

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }
        $review->action_by = Auth::user()->id;

        $review->restore();

        return redirect()->back()->with('message', 'Review sended to trash.');
    }

    public function tutorReviewSearch(Request $request)
    {
        $currentRoute = \Route::currentRouteName();

        $paginationLimit = $request->pagination_limit ?? 10;

        $tutor = Tutor::where('unique_id', $request->search)->first();

        if (!$tutor) {
            return redirect()->back()->with('error', 'Tutor not found.');
        }

        $reviews = TutorReview::where('tutor_id', $tutor->id)
                            ->orderBy('id', 'desc')
                            ->paginate($paginationLimit);

        return view('backend.reviews.tutor_reviews', compact('paginationLimit', 'reviews', 'currentRoute'));
    }


    public function websiteReviews(Request $request)
    {
        $reviews = WebsiteReview::orderBy('id','desc')->paginate(30);
        return view('backend.setting.webreview.web_review',compact('reviews'));
    }
    public function websiteReviewsStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_type' => 'required|in:Tutor,Parent,Affiliate Partner',
            'gender' => 'required|in:Male,Female',
            'description' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $review = new WebsiteReview();
        $review->name = $request->name;
        $review->profession = $request->profession;
        $review->user_type = $request->user_type;
        $review->gender = $request->gender;
        $review->description = $request->description;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = $file->store('webreviews', 'public');
            $review->image = $filePath;
        }

        $review->save();

        return response()->json(['success' => true, 'message' => 'Review added successfully!']);
    }

    public function websiteReviewsedit($id)
    {
        $review = WebsiteReview::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $review
        ]);
    }



    public function websiteReviewsupdate(Request $request)
    {
        $review = WebsiteReview::findOrFail($request->id);

        $review->name = $request->name;
        $review->profession = $request->profession;
        $review->user_type = $request->user_type;
        $review->gender = $request->gender;
        $review->description = $request->description;

        if ($request->hasFile('image')) {
            // Delete Old Image
            if ($review->image) {
                Storage::delete("public/" . $review->image);
            }

            // Store New Image
            $filePath = $request->file('image')->store("webreviews", "public");
            $review->image = $filePath;
        }

        $review->save();

        return response()->json(['success' => true, 'message' => 'Review updated successfully!']);
    }


    public function changeStatus(Request $request)
    {
        $review            = WebsiteReview::find($request->id);
        $review->status = $review->status === 1 ? 0 : 1;
        $review->update();
        return response()->json(['status'=>'success','message'=> ' Status Changed Successfully']);



    }


}
