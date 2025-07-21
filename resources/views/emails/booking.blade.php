<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 30px; color: #333;">

    <div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="background-color: #4CAF50; color: white; padding: 20px 30px;">
            <h2 style="margin: 0;">📅 Booking Notification</h2>
        </div>

        <div style="padding: 30px;">
            @php
                $recipient = $recipient ?? null;
            @endphp

            @if($recipient && $recipient->id === $booking->parent->user_id)
                {{-- Email to Parent --}}
                <p style="font-size: 16px;">Dear <strong>{{ $booking->parent->user->name }}</strong>,</p>

                <p style="font-size: 15px; line-height: 1.6;">
                    You have received a new booking from PlayPal <strong>{{ $booking->playPal->user->name }}</strong>.
                </p>

            @elseif($recipient && $recipient->id === $booking->playPal->user_id)
                {{-- Email to PlayPal --}}
                <p style="font-size: 16px;">Dear <strong>{{ $booking->playPal->user->name }}</strong>,</p>

                <p style="font-size: 15px; line-height: 1.6;">
                    You have successfully booked Parent <strong>{{ $booking->parent->user->name }}</strong>.
                </p>
            @endif

            <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">

            <p style="font-size: 15px;"><strong>📌 Booking Details:</strong></p>
            <ul style="font-size: 15px; padding-left: 20px; line-height: 1.6;">
                <li><strong>Date:</strong> {{ $booking->created_at->format('Y-m-d') ?? 'N/A' }}</li>
                <li><strong>Time:</strong> {{ $booking->created_at->format('H:i A') ?? 'N/A' }}</li>
                <li><strong>Slot:</strong> {{ json_decode($booking->duration)->matched_slot ?? 'N/A' }}</li>
                <li><strong>Amount:</strong> ₹{{ $booking->amount }}</li>
            </ul>

            <p style="margin-top: 20px; font-size: 15px;">
                Please check your dashboard for more details and next steps.
            </p>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/dashboard') }}" style="display: inline-block; background-color: #4CAF50; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold;">Go to Dashboard</a>
            </div>
        </div>

        <div style="background-color: #f0f0f0; padding: 20px 30px; text-align: center; font-size: 13px; color: #888;">
             <p style="font-size: 13px; color: #888;">&copy; {{ now()->year }} Kid Care Platform. All rights reserved.</p>
        </div>
        
    </div>

</body>
</html>
