<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Exports\ApplicationPaymentExport;
use App\Exports\ConfoirmJobExport;
use App\Exports\DueExport;
use App\Exports\DueExportDateWise;
use App\Exports\DueJobExport;
use App\Exports\PaymentExportDateWise;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\ApplicationPayment;
use App\Models\DeskNumber;
use App\Models\DuePayments;
use App\Models\ParentPersonalInfo;
use App\Models\Parents;
use App\Models\SocialMedia;
use App\Models\Tutor;
use App\Models\TutorConvertParent;
use App\Models\User;
use App\Models\WebSetting;
use Faker\Provider\UserAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;

class SettingController extends Controller
{
    public function index(){
        // dd('hi');
        return view('backend.setting.setting_sidenav');

    }
    public function websiteSetting(){
        $data = WebSetting::first();

        if ($data && isset($data->set_point_date)) {
            $data->set_point_date = \Carbon\Carbon::parse($data->set_point_date)->format('Y-m-d');
        }
        return view('backend.setting.website_setting',compact('data'));
    }

    public function smsSetting(){
        return view('backend.setting.sms_setting');
    }

    public function ReferenceTableSetting(){
        return view('backend.setting.reference_table_setting');
    }

    public function webMail(){
        return view('backend.setting.web_mail');
    }

    public function paymentSetPoint(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'set_point_date' => 'required|date',
            ]);

            $setting = WebSetting::first();
            $setting->set_point_date = $request->set_point_date;
            $setting->update();

            return response()->json(['message' => 'Date saved successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Error saving date: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while saving the date'], 500);
        }
    }

    public function exportDueJob(Request $request)
    {
        return Excel::download(new DueJobExport, 'due_job_all.xlsx');
    }
    public function exportConfirmJob(Request $request)
    {
        return Excel::download(new ConfoirmJobExport, 'confirm_job_all.xlsx');
    }
    public function exportPayment(Request $request)
    {
        return Excel::download(new ApplicationPaymentExport, 'payment_all.xlsx');
    }
    public function exportDue(Request $request)
    {
        return Excel::download(new DueExport, 'due_all.xlsx');
    }
    public function exportData(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = ApplicationPayment::whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return Excel::download(new PaymentExportDateWise($data), 'payments_from_' . $startDate . '_to_' . $endDate . '.xlsx');
    }
    public function exportDateWise(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = DuePayments::whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return Excel::download(new DueExportDateWise($data), 'due_from_' . $startDate . '_to_' . $endDate . '.xlsx');
    }


    public function userAgent(Request $request)
    {
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 10);
        $userAgent = DeskNumber::orderBy('id', 'desc')->paginate(20);
        return view('backend.setting.user_agent',compact('userAgent','currentRoute','paginationLimit'));
    }

    public function userAgentAdd(Request $request)
    {
        $validated = $request->validate([
            'desk_number' => 'required|integer',
            'user_agent' => 'required|string|max:255',
        ]);

        // Save to database
        $userAgent = new DeskNumber();
        $userAgent->desk_number = $request->desk_number;
        $userAgent->user_agent = $request->user_agent;
        $userAgent->save();

        return response()->json(['status' => true, 'message' => 'User Agent added successfully!']);
    }

    public function convertParentIndex(Request $request)
    {

        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 10);
        $converted = TutorConvertParent::orderBy('id', 'desc')->paginate(20);
        return view('backend.setting.convert_parent',compact('currentRoute','paginationLimit','converted'));


    }

    public function convertTutorParent(Request $request)
    {
        try {
            $fromTutorId = $request->input('from_tutor_id');
            $toTutorId = $request->input('to_tutor_id');

            $tutors = Tutor::with([
                'tutor_personal_info',
            ])->whereBetween('id', [$fromTutorId, $toTutorId])->get();

            if ($tutors->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No tutors found in the specified range.'], 404);
            }

            $parentsCreated = [];
            foreach ($tutors as $tutor) {
                $existingParent = Parents::where('phone', $tutor->phone)->orWhere('email', $tutor->email)->exists();

                if ($existingParent) {
                    continue;
                }

                $parent = new Parents();
                $parent->name = $tutor->name;
                $parent->phone = $tutor->phone;
                $parent->email = Parents::where('email', $tutor->email)->exists() ? null : $tutor->email; // Ignore duplicate emails
                $parent->otp = rand(1234, 9999);
                $parent->phone_verified_at = now();
                $parent->password = Hash::make(123456);
                $parent->save();

                $parent->get_parent_unique_id();

                $parentsCreated[] = $parent;


                $parent = ParentPersonalInfo::updateOrCreate(
                    ['parents_id' => $parent->id],
                    [
                        'country_id'           => $tutor->tutor_personal_info->country_id,
                        'parents_id'           => $parent->id,
                        'city_id'              => $tutor->tutor_personal_info->city_id,
                        'location_id'          => $tutor->tutor_personal_info->location_id,
                        'gender'               => $tutor->gender ?? NULL,
                        'address_details'      => $tutor->tutor_personal_info->full_address ?? NULL,
                        'additional_phone'     => $tutor->tutor_personal_info->additional_phone ?? NULL,
                        'facebook_profile'     => $tutor->tutor_personal_info->facebook_profile ?? NULL,
                    ]
                );
            }

            $tutorConvert = new TutorConvertParent();
            $tutorConvert->from_tutor_id = $fromTutorId;
            $tutorConvert->to_tutor_id = $toTutorId;
            $tutorConvert->success = count($parentsCreated);
            $tutorConvert->action_by = Auth::user()->id;
            $tutorConvert->save();

            return response()->json([
                'success' => true,
                'message' => count($parentsCreated) . ' parents successfully created.',
                'data' => $parentsCreated,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    // For Manually Model Role Update
    public function modelRoleSetup(Request $request)
    {
        $users = User::where('role_id', $request->role_id)->get();

        $insertData = [];

        foreach ($users as $user) {
            $insertData[] = [
                'role_id' => $user->role_id,
                'model_id' => $user->id,
                'model_type' => 'App\Models\User',
            ];
        }

        DB::table('model_has_roles')->insertOrIgnore($insertData);

        session()->flash('success', 'Roles assigned successfully!');
        return redirect()->back();
    }

    public function socialMedia()
    {

        $socialmedia = SocialMedia::all();

        $roles = Role::all();
        return view('backend.setting.social_media',compact('socialmedia','roles'));
    }



    public function socialMediaAdd(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'roles' => 'nullable|array',
        ]);

        $data = $request->only('name', 'link');

        // Upload logo to R2
        if ($request->hasFile('logo')) {

            $file = $request->file('logo');

            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            Storage::disk('r2')->put(
                'logos/' . $fileName,
                file_get_contents($file->getRealPath())
            );

            $data['logo'] = $fileName;
        } else {
            $data['logo'] = null;
        }

        // Convert roles array to comma-separated string
        $data['roles'] = !empty($request->roles)
            ? implode(',', $request->roles)
            : null;

        SocialMedia::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Social media account added successfully',
        ]);
    }


    public function getSocialMedia($id)
    {
        $socialMedia = SocialMedia::find($id);

        if (!$socialMedia) {
            return response()->json([
                'success' => false,
                'message' => 'Not Found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $socialMedia->id,
                'name' => $socialMedia->name,
                'link' => $socialMedia->link,

                'logo' => $socialMedia->logo
                    ? Storage::disk('r2')->url('logos/' . $socialMedia->logo)
                    : null,

                'roles' => $socialMedia->roles,
            ]
        ]);
    }


    public function updateSocialMedia(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'roles' => 'nullable|array',
        ]);

        try {

            $socialMedia = SocialMedia::findOrFail($id);

            // Update name and link
            $socialMedia->name = $request->name;
            $socialMedia->link = $request->link;

            // Update logo
            if ($request->hasFile('logo')) {

                // Delete old logo from R2
                if (!empty($socialMedia->logo)) {

                    $oldLogoPath = 'logos/' . $socialMedia->logo;

                    if (Storage::disk('r2')->exists($oldLogoPath)) {
                        Storage::disk('r2')->delete($oldLogoPath);
                    }
                }

                // New logo
                $file = $request->file('logo');

                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Upload new logo to R2
                Storage::disk('r2')->put(
                    'social-media-logos/' . $fileName,
                    file_get_contents($file->getRealPath())
                );

                // Save only filename in database
                $socialMedia->logo = $fileName;
            }

            // Update roles
            $socialMedia->roles = !empty($request->roles)
                ? implode(',', $request->roles)
                : null;

            $socialMedia->save();

            return response()->json([
                'success' => true,
                'message' => 'Updated successfully',
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }




    public function destroy($id)
    {
        try {

            $socialMedia = SocialMedia::findOrFail($id);

            // Delete logo from R2
            if (!empty($socialMedia->logo)) {

                $logoPath = 'logos/' . $socialMedia->logo;

                if (Storage::disk('r2')->exists($logoPath)) {
                    Storage::disk('r2')->delete($logoPath);
                }
            }

            // Delete database record
            $socialMedia->delete();

            return response()->json([
                'success' => true,
                'message' => 'Social media account deleted successfully.'
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the account.',
                'error' => $e->getMessage()
            ], 500);
        }
    }




}
