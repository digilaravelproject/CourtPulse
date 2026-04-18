@extends('layouts.auth')

@section('title', 'Professional Profile')

@section('content')
<div class="glass p-8 rounded-3xl glow-shadow">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white mb-1">Professional Details</h1>
        <p class="text-muted text-sm">Fine-tune your profile to start connecting.</p>
    </div>

    <form action="{{ route('register.details.store') }}" method="POST" class="space-y-5">
        @csrf
        
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-muted mb-2">Primary Role</label>
                <select name="role" required class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-4 text-sm text-white focus:border-accent">
                    <option value="advocate" class="bg-dark">Advocate</option>
                    <option value="ip_attorney" class="bg-dark">IP Attorney</option>
                    <option value="ca" class="bg-dark">Chartered Accountant (CA)</option>
                    <option value="cs" class="bg-dark">Company Secretary (CS)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-muted mb-2">Experience (Years)</label>
                <input type="number" name="experience_years" min="0" required placeholder="5" 
                    value="{{ old('experience_years') }}"
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-4 text-sm text-white">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-muted mb-2">Bar Council / Member ID</label>
                <input type="text" name="license_number" placeholder="D/123/2020" 
                    value="{{ old('license_number') }}"
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-4 text-sm text-white">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-muted mb-2">City</label>
                <input type="text" name="city" required placeholder="New Delhi" 
                    value="{{ old('city', $user->city) }}"
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-4 text-sm text-white">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-muted mb-2">State</label>
                <input type="text" name="state" required placeholder="Delhi" 
                    value="{{ old('state', $user->state) }}"
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-4 text-sm text-white">
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-accent hover:bg-accent/90 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-accent/20">
                Complete Setup
            </button>
        </div>
    </form>
</div>
@endsection
