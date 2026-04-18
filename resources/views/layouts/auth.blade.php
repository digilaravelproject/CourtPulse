<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Welcome') — DockIt</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: '#050812',
                        surface: '#0e1526',
                        accent: '#B4B4FE',
                        'accent-glow': 'rgba(180, 180, 254, 0.3)',
                        muted: '#94A3B8',
                    },
                    fontFamily: {
                        sans: ['Manrope', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            background-color: #050812;
            color: #CBD5E1;
            overflow-x: hidden;
        }
        .glass {
            background: rgba(14, 21, 38, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }
        .glow-shadow {
            box-shadow: 0 0 40px -10px rgba(180, 180, 254, 0.2);
        }
        input:focus { border-color: #B4B4FE !important; box-shadow: 0 0 0 3px rgba(180, 180, 254, 0.2); outline: none; }
        
        .logo-box {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: #B4B4FE;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            color: #050812;
            font-weight: 900;
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center p-4">
    
    {{-- Animated Background Objects --}}
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-accent/5 blur-[120px] rounded-full z-0"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[30%] h-[30%] bg-[#B4B4FE]/5 blur-[100px] rounded-full z-0"></div>

    <div class="w-full max-w-lg relative z-10">
        {{-- Logo Section --}}
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-3 mb-2 no-underline">
                <div class="logo-box">D</div>
                <span class="text-2xl font-black tracking-tight text-white no-underline">DockIt</span>
            </a>
            <p class="text-muted text-[0.6rem] font-black uppercase tracking-[0.2em]">India's Premium Legal Network</p>
        </div>

        @yield('content')
        
        <div class="mt-8 text-center text-[0.6rem] font-bold text-slate-700 uppercase tracking-widest">
            &copy; {{ date('Y') }} DockIt. ALL RIGHTS RESERVED.
        </div>
    </div>

    @stack('scripts')
</body>
</html>
