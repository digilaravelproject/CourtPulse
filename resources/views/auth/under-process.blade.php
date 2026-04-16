<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Under Review — Court Pulse</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --accent: #B4B4FE;
            --navy-deep: #0A1120;
            --navy-bg: #0F172A;
            --muted: #94A3B8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--navy-bg);
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .process-card {
            max-width: 600px;
            width: 100%;
            padding: 60px 40px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 32px;
            text-align: center;
            position: relative;
        }

        .icon-box {
            width: 100px;
            height: 100px;
            background: rgba(180, 180, 254, 0.1);
            border: 1px solid rgba(180, 180, 254, 0.3);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 32px;
            font-size: 3rem;
            color: var(--accent);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(180, 180, 254, 0.4); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 20px rgba(180, 180, 254, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(180, 180, 254, 0); }
        }

        .title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .message {
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 24px;
            background: rgba(180, 180, 254, 0.1);
            border: 1px solid rgba(180, 180, 254, 0.2);
            border-radius: 100px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 700;
            color: var(--accent);
        }

        .btn-logout {
            margin-top: 40px;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--muted);
            padding: 12px 30px;
            border-radius: 12px;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
        }
    </style>
</head>
<body>

    <div class="process-card">
        <div class="icon-box">
            <i class="bi bi-shield-lock"></i>
        </div>
        <h1 class="title">Application Under Review</h1>
        <p class="message">
            Thank you for completing your registration, <strong>{{ auth()->user()->name }}</strong>. 
            Our admin team is currently verifying your documents. You will receive an email once your account is activated.
        </p>
        
        <div class="status-badge">
            <span class="spinner-grow spinner-grow-sm"></span> Verification In Progress
        </div>

        <div class="d-flex flex-column align-items-center gap-3">
            <button onclick="location.reload()" class="btn btn-primary px-5 py-2.5 rounded-pill border-0 shadow-lg" style="background: var(--accent); color: var(--navy-deep); font-weight: 700;">
                <i class="bi bi-arrow-clockwise me-2"></i> Refresh Status
            </button>

            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn-logout border-0 bg-transparent">
                    <i class="bi bi-box-arrow-left me-2"></i> Log Out
                </button>
            </form>
        </div>
    </div>

    <script>
        // If they are active and somehow landed here, redirect them
        const status = "{{ auth()->user()->status }}";
        const role = "{{ auth()->user()->role }}";
        if (status === 'active') {
             const dashboard = (role === 'admin' || role === 'super_admin') ? '/admin/dashboard' : `/${role}/dashboard`;
             window.location.href = dashboard;
        }
    </script>

</body>
</html>
