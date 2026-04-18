@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
<div class="glass p-8 rounded-3xl glow-shadow">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white mb-2">Welcome Back</h1>
        <p class="text-muted text-sm">Sign in to your account via secure OTP.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('login.send-otp') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-muted mb-2">Email Address</label>
            <div class="relative">
                <i class="bi bi-envelope absolute left-4 top-1/2 -translate-y-1/2 text-muted"></i>
                <input type="email" name="email" required placeholder="rajesh@example.com" 
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-4 pl-11 pr-4 text-sm text-white transition-all">
            </div>
        </div>

        <button type="submit" class="w-full bg-accent hover:bg-accent/90 text-white font-bold py-4 rounded-xl shadow-lg shadow-accent/20 transition-all flex items-center justify-center gap-2 group">
            Send Login code
            <i class="bi bi-arrow-right transition-transform group-hover:translate-x-1"></i>
        </button>
    </form>

    <div class="mt-8 text-center pt-6 border-t border-white/5">
        <p class="text-xs text-muted">New to DockIt? <a href="{{ route('register') }}" class="text-accent font-semibold hover:underline">Create an account</a></p>
    </div>
</div>
@endsection
