<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Enrollment Successful - Welcome to the Course!</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1);">

        <h1 style="color: #1e40af; text-align:center;">Congratulations {{ $enrollment->full_name }}! </h1>

        <p style="font-size:18px; text-align:center;">
            Your enrollment has been <strong style="color:#16a34a;">SUCCESSFULLY APPROVED</strong>!
            Welcome to <strong>{{ $enrollment->course->title }}</strong>!
        </p>

        <div style="background:#ecfdf5;padding:20px;border-radius:8px;border-left:5px solid #16a34a;margin:25px 0;">
            <p style="margin:0;font-size:16px;">
                You're all set and ready to start your learning journey with us!
            </p>
        </div>

        <hr style="border:1px dashed #ddd;margin:30px 0;">

        <p><strong>Full Name:</strong> {{ $enrollment->full_name }}</p>
        <p><strong>Email:</strong> {{ $enrollment->email }}</p>
        <p><strong>Temporary Password:</strong>
            <code style="background:#eee;padding:5px 12px;border-radius:5px;font-size:15px;">
                {{ $enrollment->plain_password }}
            </code>
        </p>

        <div style="margin:35px 0; text-align:center;">
            <a href="{{ url('/login') }}"
               style="background:#1e40af;color:white;padding:15px 40px;text-decoration:none;border-radius:50px;font-size:16px;font-weight:bold;">
                Login to Your Account
            </a>
        </div>

        <div style="background:#d1fae5;padding:20px;border-radius:10px;text-align:center;margin:30px 0;">
            <p style="margin:0 0 15px;font-size:17px;font-weight:bold;color:#065f46;">
                Join Our Official WhatsApp Community
            </p>
            <p style="margin:10px 0;">
                Stay updated, ask questions, and connect with your batch mates!
            </p>
            <a href="https://chat.whatsapp.com/FLf4C6wykkyF1fA9QjQIIQ"
               target="_blank"
               style="background:#25D366;color:white;padding:12px 30px;text-decoration:none;border-radius:50px;font-weight:bold;display:inline-block;">
                Join WhatsApp Group Now
            </a>
        </div>

        <p style="text-align:center;color:#6b7280;margin-top:40px;">
            We're excited to have you on board!<br>
            <strong>Finhedge Investment</strong>
        </p>
    </div>
</body>
</html>
