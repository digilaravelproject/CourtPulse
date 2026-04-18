@extends('layouts.auth')

@section('title', 'Verify Login')

@section('content')
<div class="glass p-8 rounded-3xl glow-shadow text-center">
    <div class="mb-6">
        <div class="w-16 h-16 bg-accent/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-accent/20">
            <i class="bi bi-key text-3xl text-accent"></i>
        </div>
        <h1 class="text-2xl font-bold text-white mb-2">Security Verification</h1>
        <p class="text-muted text-sm">Enter the code sent to <span class="text-white font-medium">{{ $email }}</span></p>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm italic">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('login.verify.submit') }}" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="flex justify-between gap-2">
            <input type="text" name="otp" required maxlength="6" autofocus
                placeholder="· · · · · ·"
                class="w-full bg-white/5 border border-white/10 rounded-2xl py-5 text-center text-3xl font-bold tracking-[0.5em] text-white transition-all focus:border-accent">
        </div>

        <button type="submit" class="w-full bg-accent hover:bg-accent/90 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-accent/20">
            Secure Sign In
        </button>
    </form>

    <div class="mt-8">
        <p class="text-xs text-muted">Didn't get it? <a href="{{ route('login') }}" class="text-accent font-semibold hover:underline">Resend code</a></p>
    </div>
</div>
@endsection
