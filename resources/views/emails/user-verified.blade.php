<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Verified</title>
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
            background: linear-gradient(135deg, #1a5e3a 0%, #2d9f6a 100%);
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

        .success-badge {
            background: #f0fff6;
            border: 1px solid #b2f5d4;
            border-radius: 10px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
        }

        .success-badge .icon {
            font-size: 28px;
            flex-shrink: 0;
        }

        .success-badge p {
            font-size: 14px;
            color: #276749;
            font-weight: 600;
            margin: 0;
        }

        .btn {
            display: block;
            width: fit-content;
            margin: 30px auto;
            background: linear-gradient(135deg, #1a5e3a, #2d9f6a);
            color: #ffffff !important;
            text-decoration: none;
            padding: 13px 36px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            text-align: center;
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

            <div class="success-badge">
                <span class="icon">✅</span>
                <p>Your account has been successfully verified!</p>
            </div>

            <p class="message">
                Great news! Our administration team has reviewed your details and verified your account on Court Pulse.
                You can now access all the features available for a <strong>{{ ucfirst($user->role) }}</strong>.
            </p>

            <p class="message">
                Log in now to update your profile, browse connections, and grow your legal network.
            </p>

            <a href="{{ url('/login') }}" class="btn">Log In to Dashboard</a>
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
