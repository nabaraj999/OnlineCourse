<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
        }
        .details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .details p {
            margin: 10px 0;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 15px 0;
        }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1> Account Activated!</h1>
        </div>
        <div class="content">
            <h2>Account Activation Confirmation</h2>
            <p>Dear {{ $Teacher->name }},</p>
            <p>We are pleased to inform you that your teacher account has been activated. Below are your personal details as registered in our system:</p>

            <div class="details">
                <h3>Your Profile Details</h3>
                <p><strong>Name:</strong> {{ $Teacher->name }}</p>
                <p><strong>Email:</strong> {{ $Teacher->email }}</p>
                @if ($Teacher->phone)
                    <p><strong>Phone:</strong> {{ $Teacher->phone }}</p>
                @endif
                @if ($Teacher->address)
                    <p><strong>Address:</strong> {{ $Teacher->address }}</p>
                @endif
                @if ($Teacher->subject)
                    <p><strong>Subject:</strong> {{ $Teacher->subject }}</p>
                @endif
                @if ($Teacher->bio)
                    <p><strong>Bio:</strong> {{ $Teacher->bio }}</p>
                @endif
                @if ($Teacher->website)
                    <p><strong>Website:</strong> <a href="{{ $Teacher->website }}">{{ $Teacher->website }}</a></p>
                @endif
                @if ($Teacher->experience)
                    <p><strong>Experience:</strong> {{ $Teacher->experience }}</p>
                @endif
                <p><strong>Account Status:</strong> {{ ucfirst($Teacher->account_status) }}</p>
            </div>

            <p>You can now log in to the teacher portal using your existing credentials:</p>
            <a href="{{ config('app.url') }}/teacher/login" class="button">Login to Your Account</a>

            <p>If any of the details above are incorrect or need updating, please contact our support team at support@example.com.</p>

            <p>Thank you for joining our educational platform. We look forward to your contributions!</p>

            <p>Best regards,<br>
            The {{ config('app.name') }} Team</p>
        </div>
        <div class="footer">
            <p>This is an automated email, please do not reply directly to this message.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
