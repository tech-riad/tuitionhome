<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login()
    {
//        return "admin login";
        return view('auth.login');
    }
    public function emdash()
    {
        return "Employee Dashboard";
    }

    public function fahHBD()
    {
        return view('auth.hbd_template');
    }
    public function fahHBDT()
    {
        return view('auth.Birthday-master.index');
    }


}
