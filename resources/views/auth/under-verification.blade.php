@extends('layouts.main')
@section('title', 'Under Verification')
@section('content')
<div class="min-h-screen pt-32 pb-20 bg-navy flex flex-col items-center justify-center text-center px-6 relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <rect width="100" height="100" fill="url(#grid)" />
        </svg>
    </div>

    <div class="w-24 h-24 bg-blue/10 rounded-full flex items-center justify-center mb-8 animate-pulse border border-blue/20">
        <svg class="w-12 h-12 text-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
        </svg>
    </div>
    
    <h2 class="text-4xl font-black text-white uppercase tracking-tighter mb-4">Account Under Verification</h2>
    <p class="text-slate-400 max-w-md mx-auto leading-relaxed mb-12 font-medium">
        Thank you for joining CourtPulse. To maintain the integrity of our network, all professional accounts are manually verified by our team.
    </p>
    
    <div class="space-y-4">
        <div class="bg-white/5 border border-white/10 px-8 py-6 rounded-2xl backdrop-blur-md">
            <span class="text-blue text-xs font-black uppercase tracking-[0.3em] block mb-2">Status</span>
            <span class="text-white font-black text-xl uppercase tracking-tighter">Pending Administrative Review</span>
        </div>
        <p class="text-slate-500 text-[0.65rem] uppercase tracking-[0.2em] font-black">Estimated time: 12-24 Hours</p>
    </div>
    
    <form action="{{ route('logout') }}" method="POST" class="mt-16">
        @csrf
        <button type="submit" class="text-slate-400 hover:text-white text-xs font-black uppercase tracking-[0.4em] transition-all border-b border-transparent hover:border-white/20 pb-2">
            Logout & Check Later
        </button>
    </form>
</div>
@endsection
