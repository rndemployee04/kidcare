<?php

namespace App\Jobs;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckBookingCompletions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $now = Carbon::now();
        $today = Carbon::today();

        $bookings = Booking::where('status', 'accepted')->get();

        foreach ($bookings as $booking) {
            $duration = json_decode($booking->duration, true);
            if (!$duration || !isset($duration['type']))
                continue;

            $end = null;

            switch ($duration['type']) {
                case 'time':
                    if (isset($duration['start'], $duration['hours'])) {
                        $start = Carbon::parse(today()->format('Y-m-d') . ' ' . $duration['start']);
                        $end = $start->copy()->addHours((int) $duration['hours']);
                    }
                    break;

                case 'date':
                    if (isset($duration['end'])) {
                        $end = Carbon::parse($duration['end'])->endOfDay();
                    }
                    break;

                case 'week':
                    if (isset($duration['week'])) {
                        $start = Carbon::createFromFormat('o-\WW', $duration['week']);
                        $end = $start->copy()->addDays(6)->endOfDay();
                    }
                    break;
                case 'auto':
                    if (isset($duration['matched_slot'])) {
                        $slot = strtolower($duration['matched_slot']);

                        // Define slot end times (customize as needed)
                        $slotEndTimes = [
                            'morning' => '12:00:00',
                            'afternoon' => '16:00:00',
                            'evening' => '20:00:00',
                        ];

                        if (array_key_exists($slot, $slotEndTimes)) {
                            $end = Carbon::parse($today->format('Y-m-d') . ' ' . $slotEndTimes[$slot]);
                        }
                    }
                    break;
            }

            if ($end && $now->greaterThan($end)) {
                $booking->update(['status' => 'completed']);
                $booking->save();
                logger("Booking #{$booking->id} marked completed at {$now} (slot end: {$end})");
            }
        }
    }
}
