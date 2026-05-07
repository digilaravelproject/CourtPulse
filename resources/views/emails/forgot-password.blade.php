<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#0a0f18] text-white p-6">
    <div class="max-w-md mx-auto bg-[#161e2d] border border-blue-500/20 rounded-2xl overflow-hidden shadow-2xl">
        <div class="bg-linear-to-r from-blue-600 to-indigo-700 p-8 text-center">
            <h1 class="text-3xl font-bold tracking-tight">DockIt</h1>
            <p class="text-blue-100 mt-2 opacity-90">Password Recovery</p>
        </div>

        <div class="p-8 text-center">
            <p class="text-lg text-slate-300">Forgot your password?</p>
            <p class="mt-4 text-slate-400 leading-relaxed">
                No worries! Click the button below to reset your password. This link will expire in 60 minutes.
            </p>

            <div class="mt-8 mb-8">
                <a href="{{ $url }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-10 rounded-xl transition-all shadow-lg shadow-blue-900/20">
                    Reset Password
                </a>
            </div>

            <p class="text-sm text-slate-500">
                If you didn't request a password reset, you can safely ignore this email.
            </p>
        </div>

        <div class="bg-[#0a0f18]/50 p-6 text-center border-t border-slate-800">
            <p class="text-xs text-slate-600">&copy; {{ date('Y') }} DockIt. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
