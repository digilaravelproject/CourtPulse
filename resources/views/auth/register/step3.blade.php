@extends('layouts.main')

@section('title', 'Step 3: Professional Profile - CourtPulse')

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-slate-900 uppercase tracking-tight">
            Professional Profile
        </h2>
        <p class="mt-2 text-center text-sm text-slate-600">
            Tell us about your practice and expertise
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-xl">
        <div class="bg-white py-8 px-4 shadow-xl sm:rounded-2xl sm:px-10 border border-slate-100">
            <form action="{{ route('register.step3.post') }}" method="POST" class="space-y-6">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 rounded-r-lg">
                        <div class="flex">
                            <div class="shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700 font-bold">Registration Errors</p>
                                <ul class="list-disc list-inside text-xs text-red-600 mt-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Practice Experience (Years)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                <i class="fas fa-briefcase"></i>
                            </span>
                            <input type="number" name="experience_years" value="{{ old('experience_years') }}" required min="0" max="60"
                                class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-semibold transition-all" 
                                placeholder="e.g. 5">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Primary Court / Office</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                <i class="fas fa-gavel"></i>
                            </span>
                            <select name="court_id" required 
                                class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-semibold transition-all appearance-none">
                                <option value="">Select Primary Location</option>
                                @foreach($courts as $court)
                                    <option value="{{ $court->id }}" {{ old('court_id') == $court->id ? 'selected' : '' }}>
                                        {{ $court->name }} ({{ $court->city }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('reg_user_group') === 'professional')
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">License / Bar Council Number</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <i class="fas fa-id-card"></i>
                        </span>
                        <input type="text" name="license_number" value="{{ old('license_number') }}" 
                            class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-semibold transition-all" 
                            placeholder="e.g. MAH/1234/2020">
                    </div>
                </div>
                @endif

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Past Employers / Firm Name</label>
                    <div class="relative">
                        <span class="absolute top-3 left-3 text-slate-400">
                            <i class="fas fa-building"></i>
                        </span>
                        <textarea name="past_employers" rows="2" 
                            class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-semibold transition-all" 
                            placeholder="List previous law firms or companies you've worked with...">{{ old('past_employers') }}</textarea>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Core Capabilities / Areas of Practice</label>
                    <div class="relative">
                        <span class="absolute top-3 left-3 text-slate-400">
                            <i class="fas fa-star"></i>
                        </span>
                        <textarea name="capabilities" rows="2" 
                            class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-semibold transition-all" 
                            placeholder="e.g. Criminal Law, Corporate Tax, IPR Litigation...">{{ old('capabilities') }}</textarea>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        Complete My Profile <i class="fas fa-check-circle ml-2 mt-0.5"></i>
                    </button>
                    
                    <a href="{{ route('register.step2') }}" class="mt-4 block text-center text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Account Details
                    </a>
                </div>
            </form>
        </div>
        
        <div class="mt-8 text-center">
            <div class="inline-flex items-center space-x-2">
                <span class="w-2 h-2 rounded-full bg-slate-200"></span>
                <span class="w-2 h-2 rounded-full bg-slate-200"></span>
                <span class="w-8 h-2 rounded-full bg-indigo-600"></span>
                <span class="w-2 h-2 rounded-full bg-slate-200"></span>
            </div>
        </div>
    </div>
</div>
@endsection
