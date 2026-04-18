<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Manrope', sans-serif; background: #050812; color: #CBD5E1; padding: 40px; }
        .card { background: #0e1526; border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; padding: 32px; max-width: 500px; margin: auto; }
        .logo { font-size: 24px; font-weight: 800; color: #F8FAFC; margin-bottom: 24px; text-decoration: none; }
        .otp { font-size: 36px; font-weight: 800; color: #B4B4FE; letter-spacing: 8px; margin: 24px 0; text-align: center; }
        .footer { font-size: 12px; color: #94A3B8; margin-top: 32px; text-align: center; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">DockIt</div>
        <p>Hello {{ $name }},</p>
        <p>Your verification code for DockIt is:</p>
        <div class="otp">{{ $otp }}</div>
        <p>This code will expire in 10 minutes. If you did not request this, please ignore this email.</p>
        <div class="footer">
            &copy; {{ date('Y') }} DockIt. India's Legal Professional Network.
        </div>
    </div>
</body>
</html>
