@extends('layouts.auth')

@section('title', 'Join Legal Professional Network')

@section('content')
<div class="glass p-8 rounded-3xl glow-shadow">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white mb-2">Create Account</h1>
        <p class="text-muted text-sm">Join the network of elite advocates and legal professionals.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.step1') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-muted mb-2">Full Name</label>
            <div class="relative">
                <i class="bi bi-person absolute left-4 top-1/2 -translate-y-1/2 text-muted"></i>
                <input type="text" name="name" required placeholder="Adv. Rajesh Kumar" 
                    value="{{ old('name') }}"
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 pl-11 pr-4 text-sm text-white transition-all">
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-muted mb-2">Email Address</label>
            <div class="relative">
                <i class="bi bi-envelope absolute left-4 top-1/2 -translate-y-1/2 text-muted"></i>
                <input type="email" name="email" required placeholder="rajesh@example.com" 
                    value="{{ old('email') }}"
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 pl-11 pr-4 text-sm text-white transition-all">
            </div>
            <p class="mt-1.5 text-[10px] text-muted">A 6-digit verification code will be sent to this email.</p>
        </div>

        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-muted mb-2">Mobile Number</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-muted font-medium text-sm">+91</span>
                <input type="text" name="phone" required placeholder="9876543210" maxlength="10"
                    value="{{ old('phone') }}"
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 pl-12 pr-4 text-sm text-white transition-all">
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-accent hover:bg-accent/90 text-white font-bold py-4 rounded-xl shadow-lg shadow-accent/20 transition-all flex items-center justify-center gap-2 group">
                Send Verification Code
                <i class="bi bi-arrow-right transition-transform group-hover:translate-x-1"></i>
            </button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="text-xs text-muted">Already have an account? <a href="{{ route('login') }}" class="text-accent font-semibold hover:underline">Sign In</a></p>
    </div>
</div>
@endsection
