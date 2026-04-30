@extends('layouts.main')

@section('title', 'Step 2: Account Credentials - CourtPulse')

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-slate-900 uppercase tracking-tight">
            Account Setup
        </h2>
        <p class="mt-2 text-center text-sm text-slate-600">
            Create your secure login credentials to continue
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl sm:rounded-2xl sm:px-10 border border-slate-100">
            <form action="{{ route('register.step2.post') }}" method="POST" class="space-y-5">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 rounded-r-lg">
                        <div class="flex">
                            <div class="shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    Please fix the following errors:
                                </p>
                                <ul class="list-disc list-inside text-xs text-red-600 mt-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Full Name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="name" value="{{ old('name') }}" required 
                            class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-semibold transition-all" 
                            placeholder="e.g. Adv. Rajesh Kumar">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                            class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-semibold transition-all" 
                            placeholder="name@example.com">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Phone Number</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <i class="fas fa-phone"></i>
                        </span>
                        <input type="text" name="phone" value="{{ old('phone') }}" required 
                            class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-semibold transition-all" 
                            placeholder="10 digit mobile number">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password" required 
                                class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-semibold transition-all" 
                                placeholder="••••••••">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Confirm</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                <i class="fas fa-shield-alt"></i>
                            </span>
                            <input type="password" name="password_confirmation" required 
                                class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-semibold transition-all" 
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        Next Step <i class="fas fa-arrow-right ml-2 mt-0.5"></i>
                    </button>
                    
                    <a href="{{ route('register.step1') }}" class="mt-4 block text-center text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Role Selection
                    </a>
                </div>
            </form>
        </div>
        
        <div class="mt-8 text-center">
            <div class="inline-flex items-center space-x-2">
                <span class="w-2 h-2 rounded-full bg-slate-200"></span>
                <span class="w-8 h-2 rounded-full bg-indigo-600"></span>
                <span class="w-2 h-2 rounded-full bg-slate-200"></span>
                <span class="w-2 h-2 rounded-full bg-slate-200"></span>
            </div>
        </div>
    </div>
</div>
@endsection
