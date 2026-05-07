<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection Update</title>
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
            <p class="text-blue-100 mt-2 opacity-90">Network Update</p>
        </div>

        <div class="p-8">
            <p class="text-lg text-slate-300">Hello <span class="text-white font-semibold">{{ $receiverName }}</span>,</p>

            @if($status === 'request')
                <p class="mt-4 text-slate-400 leading-relaxed">
                    <span class="text-blue-400 font-semibold">{{ $senderName }}</span> has sent you a connection request.
                </p>
                <div class="mt-8 text-center">
                    <a href="{{ route('connections.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-blue-900/20">
                        View Request
                    </a>
                </div>
            @else
                <p class="mt-4 text-slate-400 leading-relaxed">
                    Great news! <span class="text-green-400 font-semibold">{{ $senderName }}</span> has accepted your connection request.
                </p>
                <div class="mt-8 text-center">
                    <a href="{{ route('connections.index') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-green-900/20">
                        View Network
                    </a>
                </div>
            @endif
        </div>

        <div class="bg-[#0a0f18]/50 p-6 text-center border-t border-slate-800">
            <p class="text-xs text-slate-600">&copy; {{ date('Y') }} DockIt. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
