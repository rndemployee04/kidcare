<?php

namespace App\Http\Controllers\Carebuddy;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * Display a listing of the carebuddy's activities.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        $query = ActivityLog::where(function($q) use ($user) {
            $q->where('causer_type', 'App\\Models\\User')
              ->where('causer_id', $user->id);
        });

        if ($user->carebuddy) {
            $query->orWhere(function($q) use ($user) {
                $q->where('subject_type', 'App\\Models\\CareBuddy')
                  ->where('subject_id', $user->carebuddy->id);
            });
        }

        $activities = $query->with('causer')
                          ->latest()
                          ->paginate(15);

        return view('carebuddy.activity', compact('activities'));
    }
}
