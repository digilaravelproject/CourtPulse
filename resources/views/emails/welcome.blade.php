<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Court Pulse</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f0f4f8;
        }

        .wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .header {
            background: linear-gradient(135deg, #1a3c5e 0%, #2d6a9f 100%);
            padding: 36px 40px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .header p {
            color: rgba(255, 255, 255, 0.75);
            font-size: 13px;
            margin-top: 4px;
        }

        .body {
            padding: 40px;
        }

        .greeting {
            font-size: 16px;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .message {
            font-size: 14px;
            color: #4a5568;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .btn {
            display: block;
            width: fit-content;
            margin: 30px auto;
            background: linear-gradient(135deg, #D4AF37, #B5952F);
            color: #ffffff !important;
            text-decoration: none;
            padding: 13px 36px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            text-align: center;
        }

        .status-box {
            background: #f7fafd;
            border: 1px solid #dce8f5;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .status-box p {
            font-size: 14px;
            color: #2c3e50;
            margin: 0;
        }

        .footer {
            padding: 20px 40px 30px;
            text-align: center;
            border-top: 1px solid #e8edf3;
        }

        .footer p {
            font-size: 12px;
            color: #a0aec0;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <h1>⚖️ Court Pulse</h1>
            <p>Legal Professional Network</p>
        </div>

        <div class="body">
            <p class="greeting">Hello <strong>{{ $user->name }}</strong>,</p>

            <p class="message">
                Welcome to Court Pulse! We are thrilled to have you join our legal professional network. You have
                registered as a <strong>{{ ucfirst($user->role) }}</strong>.
            </p>

            <div class="status-box">
                @if ($user->role === 'guest')
                    <p>✅ <strong>Account Active:</strong> Your account is instantly active. You can log in right now to
                        start browsing advocates and clerks.</p>
                @else
                    <p>⏳ <strong>Pending Verification:</strong> Your profile is currently under review by our
                        administration team. Once your credentials and documents are verified, your account will be
                        activated and you will be notified.</p>
                @endif
            </div>

            <a href="{{ url('/login') }}" class="btn">Log In to Court Pulse</a>
        </div>

        <div class="footer">
            <p>
                This email was sent by Court Pulse.<br>
                &copy; {{ date('Y') }} Court Pulse. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>
