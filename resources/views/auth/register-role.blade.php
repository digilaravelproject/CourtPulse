@extends('layouts.auth')

@section('title', 'Choose Your Role')

@section('content')
<div class="glass p-8 rounded-3xl glow-shadow">
    <div class="text-center mb-10">
        <h1 class="text-2xl font-bold text-white mb-2">How will you use DockIt?</h1>
        <p class="text-muted text-sm px-6">Select the account type that best matches your professional profile.</p>
    </div>

    <form action="{{ route('register.role.store') }}" method="POST" class="space-y-4">
        @csrf
        
        <label class="block relative group cursor-pointer">
            <input type="radio" name="user_group" value="professional" class="peer hidden" required>
            <div class="p-6 rounded-2xl bg-white/5 border border-white/10 transition-all peer-checked:bg-accent/10 peer-checked:border-accent group-hover:bg-white/10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-accent/20 flex items-center justify-center text-accent">
                        <i class="bi bi-briefcase text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-white text-lg">Legal Professional</h3>
                        <p class="text-xs text-muted leading-relaxed">Advocates, IP Attorneys, CA, CS. Manage cases and delegate work.</p>
                    </div>
                    <div class="w-6 h-6 rounded-full border-2 border-white/20 flex items-center justify-center peer-checked:border-accent">
                        <div class="w-3 h-3 rounded-full bg-accent opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                </div>
            </div>
        </label>

        <label class="block relative group cursor-pointer">
            <input type="radio" name="user_group" value="support" class="peer hidden" required>
            <div class="p-6 rounded-2xl bg-white/5 border border-white/10 transition-all peer-checked:bg-accent/10 peer-checked:border-accent group-hover:bg-white/10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-400">
                        <i class="bi bi-people text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-white text-lg">Legal Support</h3>
                        <p class="text-xs text-muted leading-relaxed">Clerks, Agents, Ground Staff. Partner with professionals for execution.</p>
                    </div>
                    <div class="w-6 h-6 rounded-full border-2 border-white/20 flex items-center justify-center peer-checked:border-accent">
                        <div class="w-3 h-3 rounded-full bg-accent opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                    </div>
                </div>
            </div>
        </label>

        <div class="pt-6">
            <button type="submit" class="w-full bg-accent hover:bg-accent/90 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-accent/20">
                Continue to Profile
            </button>
        </div>
    </form>
</div>
@endsection
