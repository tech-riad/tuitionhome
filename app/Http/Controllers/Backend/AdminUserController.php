<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\Request;
Use App\Models\User;
use App\Models\UserLoginLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id','ASC')->get();
        $roles = Role::all();
        return view('backend.user.create_user',compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {

        $user = new User();
        $user->name = $request->user_name;
        $user->email = $request->user_email;
        $user->phone = $request->user_phone;
        $user->password = Hash::make($request->user_password);
        $user->role_id = $request->user_role;
        $user->save();
        return back()->with('message','User Create Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::find($id);
        // dd($users);
        return view('backend.user.user_view',compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit_user = User::find($id);
        return view('backend.user.create_user',compact('edit_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $user_id = $request->user_id;
        $user = User::find($user_id);
        $user->name = $request->user_name;
        $user->email = $request->user_email;
        $user->phone = $request->user_phone;
        $user->password = Hash::make($request->user_password);
        $user->role_id = $request->user_role;
        $user->update();
        return back()->with('message','User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return back()->with('message','User Delete Successfully!');
    }

    public function userActivity()
    {
        $activities = UserLoginLog::where('created_at', '>=', Carbon::now()->subDays(5))
                                    ->orderBy('id', 'desc')
                                    ->get();

        return view('backend.user.activities',compact('activities'));



    }

    public function userChangePassword(Request $request)
    {
        $changedCount = 0;

        User::whereNotIn('role_id', [1, 6])
            ->chunk(50, function ($users) use (&$changedCount) {
                foreach ($users as $user) {
                    $user->password = Hash::make('12345678');
                    $user->save();
                    $changedCount++;
                }
            });

        return back()->with('message', "{$changedCount} user passwords changed successfully!");
    }



}
