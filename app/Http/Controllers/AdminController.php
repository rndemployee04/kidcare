<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Controller uses middleware via the routes.php file
    // No need for constructor middleware definition here

    public function dashboard()
    {
        // Ensure only admin users can access
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        $pendingUsers = User::where('verification_status', 'pending')
            ->where('registration_complete', 1)
            ->paginate(10, ['*'], 'pending_page');
        $approvedUsers = User::where('verification_status', 'approved')
            ->paginate(10, ['*'], 'approved_page');
        $rejectedUsers = User::where('verification_status', 'rejected')
            ->paginate(10, ['*'], 'rejected_page');

        return view('admin.dashboard', [
            'pendingUsers' => $pendingUsers,
            'approvedUsers' => $approvedUsers,
            'rejectedUsers' => $rejectedUsers
        ]);
    }
    
    public function approveUser($id)
    {
        // Ensure only admin users can access
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        $user = User::findOrFail($id);
        $user->verification_status = 'approved';
        $user->save();
        
        return redirect()->route('admin.dashboard')->with('success', 'User approved successfully.');
    }

    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->verification_status = 'rejected';
        $user->save();
        
        return redirect()->route('admin.dashboard')->with('error', 'User rejected.');
    }

    public function viewApplication($id)
    {
        // Ensure only admin users can access
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }
        $user = User::with(['careBuddy', 'parentProfile', 'playPal'])->findOrFail($id);
        return view('admin.view-application', compact('user'));
    }
}
