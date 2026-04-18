@extends('layouts.auth')

@section('title', 'Application for Support Role')

@section('content')
<div class="glass p-8 rounded-3xl glow-shadow">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white mb-1">Support Partner Program</h1>
        <p class="text-muted text-sm">Fill in your expertise and upload documents for verification.</p>
    </div>

    <form action="{{ route('register.details.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-muted mb-2">Category</label>
            <select name="sub_role" id="sub_role" required class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-4 text-sm text-white focus:border-accent">
                <option value="court_clerk" class="bg-dark">Court Clerk</option>
                <option value="ip_clerk" class="bg-dark">IP / Trademark Clerk</option>
                <option value="roc_clerk" class="bg-dark">RoC / MCA Clerk</option>
                <option value="advocate_support" class="bg-dark">Advocate (Support/Junior)</option>
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-muted mb-2">Experience (Years)</label>
                <input type="number" name="experience_years" min="0" required placeholder="3" 
                    value="{{ old('experience_years') }}"
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-4 text-sm text-white">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-muted mb-2">Primary City</label>
                <input type="text" name="city" required placeholder="New Delhi" 
                    value="{{ old('city') }}"
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-4 text-sm text-white">
            </div>
            
            <div class="col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-muted mb-2">State</label>
                <input type="text" name="state" required placeholder="Manipur" 
                    value="{{ old('state') }}"
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-4 text-sm text-white">
            </div>
        </div>

        <p class="mt-2 text-[10px] text-center text-muted">Next step: Document Verification.</p>

        <div class="pt-4">
            <button type="submit" id="submit_btn" class="w-full bg-accent hover:bg-accent/90 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-accent/20">
                Submit Application
            </button>
        </div>
    </form>
</div>
@endsection


