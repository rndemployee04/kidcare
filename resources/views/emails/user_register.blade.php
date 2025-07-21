<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome Email</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 30px;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="background-color: #4CAF50; color: white; padding: 20px;">
            <h2 style="margin: 0;">👋 Welcome, {{ $user->name }}!</h2>
        </div>

        <div style="padding: 30px; color: #333;">
            <p style="font-size: 16px;">Your account has been created successfully as a <strong>{{ ucfirst($user->role) }}</strong>.</p>

            <p style="font-size: 15px;">
                <strong>Email:</strong> {{ $user->email }}<br>
                <strong>Password:</strong> {{ $password }}
            </p>

            @if ($user->role === 'parent')
                <p style="font-size: 15px; margin-top: 20px;">
                    As a parent, you can now browse and book trusted care providers for your child. Start by completing your profile and adding your preferences.
                </p>
                <p><strong>Next Step:</strong> Fill in your child’s details and your personal details to begin taking bookings from Playpals.</p>

            @elseif ($user->role === 'playpal')
                <p style="font-size: 15px; margin-top: 20px;">
                    As a PlayPal, you can now start booking children of parents with your availability and preferences. Complete your profile and set your availability to get started.
                </p>
                <p><strong>Next Step:</strong> Verify your identity and complete your profile to start booking children.</p>

            @elseif ($user->role === 'carebuddy')
                <p style="font-size: 15px; margin-top: 20px;">
                    As a CareBuddy, you can start assisting children with learning and development. Please complete your professional profile and set your availability to get started.
                </p>
                <p><strong>Next Step:</strong> Verify your identity and complete your profile to start booking children.</p>
            @endif

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/login') }}" style="display: inline-block; background-color: #4CAF50; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px;">Log In Now</a>
            </div>

            <p style="font-size: 13px; color: #888;">&copy; {{ now()->year }} Kid Care Platform. All rights reserved.</p>
        </div>
    </div>

</body>
</html>
