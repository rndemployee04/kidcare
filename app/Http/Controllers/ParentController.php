<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Child;
use App\Models\ParentBankAccount;
use App\Models\Payout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ParentController extends Controller
{
    // Controller uses middleware via the routes.php file
    // No need for constructor middleware definition here

    public function dashboard()
    {
        // Ensure only parent users can access
        if (!Auth::user() || !Auth::user()->isParent()) {
            abort(403, 'Unauthorized');
        }

        $parent = Auth::user()->parentProfile;

        // Get statistics
        $activeBookings = $parent->bookings()
            ->where(function ($query) {
                $query->where('status', 'confirmed')
                    ->orWhere('status', 'accepted');
            })->count();

        $completedBookings = $parent->bookings()->where('status', 'completed')->count();

        $bookings = Booking::with('parent.user')
            ->where('parent_id', $parent->id)
            ->where('status', 'confirmed')
            ->latest()
            ->get();

        $data = [
            'activeBookings' => $activeBookings,
            'completedBookings' => $completedBookings,
            'bookings' => $bookings
        ];

        return view('parent.dashboard', $data);
    }



    public function children()
    {
        $user = Auth::user();
        $children = Child::where('parent_id', $user->parentProfile->id)->get();
        return view('parent.children.index', compact('children'));
    }

    /**
     * Show payout summary and simulate transfer to bank for parent.
     */
    public function payout()
    {
        $parent = Auth::user()->parentProfile;
        $bookings = Booking::where('parent_id', $parent->id)
            ->whereNotNull('paid_at')
            ->where('status', 'completed')
            ->where('paid_out', false)
            ->get();

        $bank_detail = ParentBankAccount::where('parent_id', $parent->id)->first();
        $totalEarnings = $bookings->sum('amount');
        $platformFee = $totalEarnings > 0 ? round($totalEarnings * 0.2, 2) : 0; // 20% fee
        $transferable = $totalEarnings - $platformFee;
        $payouts = Payout::where('user_id', $parent->user_id)->get();
        $minimumAmountForPayout = 1000;
        $transferred = $bookings->isEmpty();

        return view('parent.payout', compact('totalEarnings', 'platformFee', 'transferable', 'transferred', 'bank_detail', 'payouts', 'minimumAmountForPayout'));
    }

    /**
     * Simulate the payout transfer action (MVP: just set a session flag)
     */
    public function transferPayout(Request $request)
    {
        $bank = json_decode($request->bank_details);
        $parent = Auth::user()->parentProfile;

        $payout = Payout::create([
            'user_id' => $parent->user_id,
            'amount' => $request->amount,
            'account_holder' => $bank->account_holder,
            'account_number' => $bank->account_number,
            'ifsc' => $bank->ifsc,
            'bank_name' => $bank->bank_name,
            'status' => 'paid',
        ]);

        // Mark the bookings as paid out
        $bookings = Booking::where('parent_id', $parent->id)
            ->whereNotNull('paid_at')
            ->where('status', 'completed')
            ->where('paid_out', false)
            ->get();

        Booking::whereIn('id', $bookings->pluck('id'))->update(['paid_out' => true]);

        $payout->save();

        return redirect()->route('parent.payout')->with('success', 'Payout transferred to your bank account!');
    }
}
