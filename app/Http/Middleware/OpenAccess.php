<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\AccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class OpenAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $accessedUser = User::find($request->route('id'));

        if ($user->kelamin !== $accessedUser->kelamin) {
            $accessLog = AccessLog::where('accessor_id', $user->id)
                                ->where('accessed_id', $accessedUser->id)
                                ->first();
            if ($accessLog) {
                return response('Access Denied. You have already accessed this user.', 403);
            }
            return $next($request);
        } else {
            return response()->json('Failed to log access', 403);
        }
    }
}
