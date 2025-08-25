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
        .credentials {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .credentials p {
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
            <h1>Welcome to Our Platform!</h1>
        </div>
        <div class="content">
            <h2>Teacher Account Created</h2>
            <p>Dear {{ $Teacher->name }},</p>
            <p>We are pleased to inform you that your teacher account has been successfully created. You can now access our platform using the credentials provided below:</p>

            <div class="credentials">
                <h3>Your Login Credentials</h3>
                <p><strong>Email:</strong> {{ $Teacher->email }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
            </div>

            <p>For security reasons, we recommend changing your password after your first login.</p>

            <p>You can access the teacher portal by clicking the button below:</p>
            <a href="{{ config('app.url') }}/teacher/login" class="button">Login to Your Account</a>

            <p>If you have any questions or need assistance, please contact our support team at support@example.com.</p>

            <p>Welcome aboard, and we look forward to your contribution to our educational platform!</p>

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
