<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Connection Request</title>
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

        .card {
            background: #f7fafd;
            border: 1px solid #dce8f5;
            border-radius: 10px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 28px;
        }

        .avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #2d6a9f;
            color: #fff;
            font-size: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sender-info h2 {
            font-size: 17px;
            color: #1a3c5e;
            font-weight: 700;
        }

        .sender-info span {
            font-size: 13px;
            color: #6b7c93;
            text-transform: capitalize;
        }

        .message {
            font-size: 14px;
            color: #4a5568;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .btn {
            display: block;
            width: fit-content;
            margin: 0 auto;
            background: linear-gradient(135deg, #1a3c5e, #2d6a9f);
            color: #ffffff !important;
            text-decoration: none;
            padding: 13px 36px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            text-align: center;
        }

        .divider {
            border: none;
            border-top: 1px solid #e8edf3;
            margin: 32px 0;
        }

        .footer {
            padding: 20px 40px 30px;
            text-align: center;
        }

        .footer p {
            font-size: 12px;
            color: #a0aec0;
            line-height: 1.6;
        }

        .footer a {
            color: #2d6a9f;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        {{-- Header --}}
        <div class="header">
            <h1>⚖️ Court Pulse</h1>
            <p>Legal Professional Network</p>
        </div>

        {{-- Body --}}
        <div class="body">

            <p class="greeting">Hello <strong>{{ $receiver->name }}</strong>,</p>

            {{-- Sender Card --}}
            <div class="card">
                <div class="avatar">{{ strtoupper(substr($sender->name, 0, 1)) }}</div>
                <div class="sender-info">
                    <h2>{{ $sender->name }}</h2>
                    <span>{{ $sender->role }} • {{ $sender->city ?? 'Court Pulse Member' }}</span>
                </div>
            </div>

            <p class="message">
                <strong>{{ $sender->name }}</strong> has sent you a connection request on Court Pulse.<br><br>
                Professionals on Court Pulse connect with each other to expand their legal network.
                If you are interested, you can view and accept the request by clicking the button below.
            </p>

            <a href="{{ url('/') }}" class="btn">View & Accept Request</a>

            <hr class="divider">

            <p class="message" style="font-size:13px; color:#718096; text-align:center;">
                If you do not wish to connect, you can simply ignore this request.
            </p>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>
                This email was sent by Court Pulse.<br>
                &copy; {{ date('Y') }} Court Pulse. All rights reserved.
            </p>
        </div>

    </div>
</body>

</html>
