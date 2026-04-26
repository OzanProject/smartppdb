<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplyTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Default is already set in AppServiceProvider from global superadmin setting
        
        $schoolTimezone = null;

        // 1. Check if user is authenticated and belongs to a school (Admin/Staff/Applicant)
        if (auth()->check() && auth()->user()->school_id) {
            $schoolTimezone = auth()->user()->school->timezone ?? null;
        } 
        // 2. Check if visiting a public school route (e.g. /{school:slug}/pendaftaran)
        elseif ($request->route() && $request->route('school')) {
            $school = $request->route('school');
            if ($school instanceof \App\Models\School) {
                $schoolTimezone = $school->timezone;
            }
        }

        // Apply specific school timezone if found
        if ($schoolTimezone) {
            config(['app.timezone' => $schoolTimezone]);
            date_default_timezone_set($schoolTimezone);
        }
        
        return $next($request);
    }
}
