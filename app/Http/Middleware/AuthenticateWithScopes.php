<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateWithScopes
{
    public function handle(Request $request, Closure $next, ...$scopes)
    {
        // Check if the user is authenticated
        if ($request->user()) {
            foreach ($scopes as $scope) {
                // Check if the user has each required scope
                if (!$request->user()->tokenCan($scope)) {
                    // User does not have the required scope
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
            }
            // User has all required scopes, proceed with the request
            return $next($request);
        }

        // User is not authenticated
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
