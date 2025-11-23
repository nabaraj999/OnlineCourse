<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Approved</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
        <h1 style="color: #1e40af;">Congratulations {{ $enrollment->full_name }}!</h1>
        <p>Your enrollment for <strong>{{ $enrollment->course->title }}</strong> is <span style="color: green; font-weight: bold;">APPROVED</span>.</p>
        <hr>
        <p><strong>Email:</strong> {{ $enrollment->email }}</p>
        <p><strong>Password:</strong> <code style="background:#eee;padding:5px 10px;border-radius:5px;">{{ $enrollment->plain_password }}</code></p>
        <p style="margin-top:30px;">
            <a href="{{ url('/login') }}" style="background:#1e40af;color:white;padding:15px 30px;text-decoration:none;border-radius:50px;">
                Login Now
            </a>
        </p>
        <p>Thank you!<br>Code IT Nepal Team</p>
    </div>
</body>
</html>
