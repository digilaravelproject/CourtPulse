@extends('layouts.main')

@section('title', 'Set New Password - CourtPulse')

@section('content')
<div class="min-h-screen bg-navy flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <div class="absolute top-1/4 left-0 w-96 h-96 bg-blue/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue/5 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 text-center mb-8">
        <h2 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tighter leading-none mb-2">
            Secure Account
        </h2>
        <p class="text-xs md:text-sm font-bold text-white/60 uppercase tracking-widest">
            Create a strong new password
        </p>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
        <div class="bg-navy2 py-8 px-6 sm:px-10 shadow-2xl sm:rounded-3xl border border-white/10 relative overflow-hidden">

            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold">
                    @foreach($errors->all() as $error)
                        <p><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ request()->query('email', old('email')) }}">

                <!-- New Password -->
                <div>
                    <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-1.5">New Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-white/40"></i>
                        <input type="password" name="password" id="newPass" required oninput="checkStrength(this.value)"
                            class="w-full pl-11 pr-12 py-4 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors"
                            placeholder="Min. 8 Characters">
                        <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/40 hover:text-white" onclick="togglePass('newPass', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <!-- Strength Indicators -->
                    <div class="flex gap-1.5 mt-2">
                        <div class="h-1 flex-1 rounded-full bg-white/10 transition-colors duration-300" id="s1"></div>
                        <div class="h-1 flex-1 rounded-full bg-white/10 transition-colors duration-300" id="s2"></div>
                        <div class="h-1 flex-1 rounded-full bg-white/10 transition-colors duration-300" id="s3"></div>
                        <div class="h-1 flex-1 rounded-full bg-white/10 transition-colors duration-300" id="s4"></div>
                    </div>
                    <div class="text-[10px] font-bold text-white/50 mt-1 min-h-[16px]" id="strengthLabel"></div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-1.5">Confirm Password</label>
                    <div class="relative">
                        <i class="fas fa-shield-alt absolute left-4 top-1/2 -translate-y-1/2 text-white/40"></i>
                        <input type="password" name="password_confirmation" id="confirmPass" required oninput="checkMatch()"
                            class="w-full pl-11 pr-12 py-4 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors"
                            placeholder="Repeat new password">
                        <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/40 hover:text-white" onclick="togglePass('confirmPass', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="text-[10px] font-bold mt-1 min-h-[16px]" id="matchLabel"></div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center items-center py-4 px-6 rounded-xl text-xs font-black text-navy uppercase tracking-widest bg-blue hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-navy focus:ring-blue transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        <span>Update Password</span>
                        <i class="fas fa-check ml-3"></i>
                    </button>
                </div>
            </form>

            <div class="text-center pt-6 mt-6 border-t border-white/5">
                <a href="{{ route('login') }}" class="text-[10px] sm:text-xs font-bold text-white/50 uppercase tracking-widest hover:text-white transition-colors">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Login
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    function togglePass(id, btn) {
        const f = document.getElementById(id);
        const i = btn.querySelector('i');
        if (f.type === 'password') {
            f.type = 'text';
            i.classList.remove('fa-eye');
            i.classList.add('fa-eye-slash');
        } else {
            f.type = 'password';
            i.classList.remove('fa-eye-slash');
            i.classList.add('fa-eye');
        }
    }

    function checkStrength(val) {
        const colors = { 1: '#ef4444', 2: '#f97316', 3: '#eab308', 4: '#22c55e' };
        const labels = { 0: '', 1: 'Weak', 2: 'Fair', 3: 'Good', 4: 'Strong 💪' };

        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        [1, 2, 3, 4].forEach(i => {
            document.getElementById('s' + i).style.backgroundColor = i <= score ? colors[score] : 'rgba(255, 255, 255, 0.1)';
        });

        const lbl = document.getElementById('strengthLabel');
        lbl.textContent = labels[score];
        lbl.style.color = colors[score] || 'rgba(255, 255, 255, 0.5)';

        checkMatch();
    }

    function checkMatch() {
        const pw1 = document.getElementById('newPass').value;
        const pw2 = document.getElementById('confirmPass').value;
        const lbl = document.getElementById('matchLabel');

        if (!pw2) {
            lbl.textContent = '';
            return;
        }

        if (pw1 === pw2) {
            lbl.innerHTML = '<i class="fas fa-check text-green-400 mr-1"></i> Passwords match';
            lbl.style.color = '#4ade80';
        } else {
            lbl.innerHTML = '<i class="fas fa-times text-red-400 mr-1"></i> Passwords do not match';
            lbl.style.color = '#fca5a5';
        }
    }
</script>
@endsection
