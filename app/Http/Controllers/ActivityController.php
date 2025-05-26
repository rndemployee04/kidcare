<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class ActivityController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $activities = ActivityLog::where('causer_id', $user->id)
            ->with('causer')
            ->latest()
            ->paginate(15);

        return view('parent.activity', compact('activities'));
    }
}
