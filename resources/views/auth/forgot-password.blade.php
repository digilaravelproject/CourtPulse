@extends('layouts.main')

@section('title', 'Forgot Password - CourtPulse')

@section('content')
<div class="min-h-screen bg-navy flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <div class="absolute top-1/4 left-0 w-96 h-96 bg-blue/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue/5 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 text-center mb-8">
        <h2 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tighter leading-none mb-2">
            Recover Account
        </h2>
        <p class="text-xs md:text-sm font-bold text-white/60 uppercase tracking-widest">
            We will send a secure reset link to your email.
        </p>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
        <div class="bg-navy2 py-8 px-6 sm:px-10 shadow-2xl sm:rounded-3xl border border-white/10 relative overflow-hidden">

            @if(session('status'))
                <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/30 text-green-400 text-xs font-bold">
                    <p><i class="fas fa-check-circle mr-2"></i>{{ session('status') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold">
                    @foreach($errors->all() as $error)
                        <p><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="bg-blue/5 border border-blue/10 rounded-xl p-4 mb-6 flex items-start gap-3">
                <i class="fas fa-lightbulb text-blue mt-0.5"></i>
                <p class="text-[11px] text-white/70 font-semibold leading-relaxed">
                    Check your <strong class="text-blue">spam / junk folder</strong> if you don't receive the email within a few minutes. Link expires in 60 minutes.
                </p>
            </div>

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-1.5">Registered Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-white/40"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full pl-11 pr-4 py-4 bg-navy border border-white/10 rounded-xl text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors"
                            placeholder="name@example.com">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center items-center py-4 px-6 rounded-xl text-xs font-black text-navy uppercase tracking-widest bg-blue hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-navy focus:ring-blue transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        <i class="fas fa-paper-plane mr-2"></i>
                        <span>Send Reset Link</span>
                    </button>
                </div>
            </form>

            <div class="text-center pt-6 mt-6 border-t border-white/5">
                <p class="text-[10px] sm:text-xs font-bold text-white/50 uppercase tracking-widest">
                    Remember your password?
                    <a href="{{ route('login') }}" class="text-blue hover:text-white transition-colors underline decoration-blue/30 underline-offset-4 ml-1">Back to Login</a>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection
