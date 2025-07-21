<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Status</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 30px;">

    <div style="max-width: 600px; margin: auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div style="background-color: #4CAF50; color: white; padding: 20px;">
            <h2 style="margin: 0;">📬 Booking Status Update</h2>
        </div>

        <div style="padding: 30px; color: #333;">
            <p style="font-size: 16px;">Hello <strong>{{ $playpal->user->name }}</strong>,</p>

            <p style="font-size: 15px;">Your booking with parent <strong>{{ $parent->user->name }}</strong> has a new update:</p>

            <ul style="list-style: none; padding-left: 0; font-size: 15px; line-height: 1.6;">
                <li><strong>Status:</strong> {{ ucfirst($status) }}</li>
                <li><strong>Date:</strong> {{ $booking->created_at->format('Y-m-d') ?? 'N/A' }}</li>
                <li><strong>Time:</strong> {{ $booking->created_at->format('H:i A') ?? 'N/A' }}</li>
                <li><strong>Slot:</strong> {{ json_decode($booking->duration)->matched_slot ?? 'N/A' }}</li>
                <li><strong>Amount:</strong> ₹{{ $booking->amount }}</li>
            </ul>

            <div style="margin-top: 20px;">
                @if($status === 'accepted')
                    <p style="color: green; font-weight: bold;">🎉 Great news! The parent has accepted your booking.</p>
                @elseif($status === 'rejected')
                    <p style="color: red; font-weight: bold;">😞 The parent has rejected your booking request.</p>
                @elseif($status === 'completed')
                    <p style="color: blue; font-weight: bold;">✅ The booking has been marked as completed. Thank you!</p>
                @else
                    <p>Status has changed.</p>
                @endif
            </div>

            <p style="margin-top: 20px;">You can view this booking and take further actions from your dashboard.</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/dashboard') }}" style="display: inline-block; padding: 12px 24px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Go to Dashboard</a>
            </div>

            <p style="font-size: 13px; color: #888;">&copy; {{ now()->year }} Kid Care Platform</p>
        </div>
    </div>

</body>
</html>
