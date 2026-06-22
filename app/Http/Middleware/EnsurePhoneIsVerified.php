<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsurePhoneIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->role_id == 1 && is_null($user->phone_verified_at)) {
            return redirect()->route('employee.login')->with('message', 'Please verify your phone to access this page.');
        }

        return $next($request);
    }
}
