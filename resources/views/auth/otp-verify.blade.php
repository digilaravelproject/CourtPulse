@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
<div class="glass p-8 rounded-3xl glow-shadow text-center">
    <div class="mb-6">
        <div class="w-16 h-16 bg-accent/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-accent/20">
            <i class="bi bi-shield-lock text-3xl text-accent"></i>
        </div>
        <h1 class="text-2xl font-bold text-white mb-2">Verify your Email</h1>
        <p class="text-muted text-sm">We've sent a 6-digit code to <span class="text-white font-medium">{{ $user->email }}</span></p>
    </div>

    @if($errors->any())
        <div class="mb-6 p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('otp.verify.submit') }}" method="POST" class="space-y-6">
        @csrf
        <div class="flex justify-between gap-2" id="otp-container">
            {{-- Standard input for mobile but we use a single input for simplicity with styling --}}
            <input type="text" name="otp" required maxlength="6" autofocus
                placeholder="0 0 0 0 0 0"
                class="w-full bg-white/5 border border-white/10 rounded-2xl py-5 text-center text-3xl font-bold tracking-[0.5em] text-white transition-all focus:border-accent">
        </div>

        <button type="submit" class="w-full bg-accent hover:bg-accent/90 text-white font-bold py-4 rounded-xl transition-all">
            Verify & Continue
        </button>
    </form>

    <div class="mt-8 flex flex-col gap-3">
        <form action="{{ route('otp.resend') }}" method="POST">
            @csrf
            <button type="submit" class="text-xs text-muted hover:text-white transition-colors">
                Didn't receive the code? <span class="text-accent font-semibold">Resend</span>
            </button>
        </form>
        <a href="{{ route('register') }}" class="text-xs text-muted hover:text-white">Change Email Address</a>
    </div>
</div>
@endsection
