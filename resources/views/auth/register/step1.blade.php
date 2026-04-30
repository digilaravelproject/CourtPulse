@extends('layouts.main')

@section('title', 'Join CourtPulse - Select Your Role')

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-slate-900">
            Join CourtPulse
        </h2>
        <p class="mt-2 text-center text-sm text-slate-600">
            Select your professional category to get started
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-xl">
        <div class="bg-white py-8 px-4 shadow-xl sm:rounded-2xl sm:px-10 border border-slate-100">
            <form action="{{ route('register.step1.post') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Professional Option -->
                    <label class="relative flex flex-col p-6 cursor-pointer rounded-xl border-2 transition-all hover:bg-indigo-50 border-slate-200 group has-checked:border-indigo-600 has-checked:bg-indigo-50/50">
                        <input type="radio" name="user_group" value="professional" class="sr-only" required onchange="toggleSubRoles('professional')">
                        <div class="flex items-center justify-center w-12 h-12 mb-4 rounded-lg bg-indigo-100 text-indigo-600 group-hover:scale-110 transition-transform">
                            <i class="fas fa-user-tie text-xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-900 mb-1">Professional</span>
                        <span class="text-sm text-slate-500">Advocates, CAs, CS, or IP Attorneys with independent practices.</span>
                        <div class="absolute top-4 right-4 text-indigo-600 opacity-0 group-has-checked:opacity-100">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                    </label>

                    <!-- Support Option -->
                    <label class="relative flex flex-col p-6 cursor-pointer rounded-xl border-2 transition-all hover:bg-indigo-50 border-slate-200 group has-checked:border-indigo-600 has-checked:bg-indigo-50/50">
                        <input type="radio" name="user_group" value="support" class="sr-only" onchange="toggleSubRoles('support')">
                        <div class="flex items-center justify-center w-12 h-12 mb-4 rounded-lg bg-indigo-100 text-indigo-600 group-hover:scale-110 transition-transform">
                            <i class="fas fa-users-cog text-xl"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-900 mb-1">Support / Clerk</span>
                        <span class="text-sm text-slate-500">Court Clerks, IP Clerks, or Administrative Support staff.</span>
                        <div class="absolute top-4 right-4 text-indigo-600 opacity-0 group-has-checked:opacity-100">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                    </label>
                </div>

                <!-- Sub-role Selection (Hidden by default) -->
                <div id="sub-role-container" class="hidden animate-in fade-in slide-in-from-top-4 duration-300">
                    <label class="block text-sm font-bold text-slate-700 mb-3" id="sub-role-label">Select Your Specific Role</label>
                    <div id="professional-roles" class="hidden grid-cols-2 gap-3">
                        <label class="relative flex items-center p-3 cursor-pointer rounded-lg border border-slate-200 hover:border-indigo-300 transition-all has-checked:border-indigo-600 has-checked:bg-indigo-50">
                            <input type="radio" name="sub_role" value="advocate" class="sr-only">
                            <span class="text-sm font-semibold text-slate-700">Advocate</span>
                        </label>
                        <label class="relative flex items-center p-3 cursor-pointer rounded-lg border border-slate-200 hover:border-indigo-300 transition-all has-checked:border-indigo-600 has-checked:bg-indigo-50">
                            <input type="radio" name="sub_role" value="ca" class="sr-only">
                            <span class="text-sm font-semibold text-slate-700">Chartered Accountant</span>
                        </label>
                        <label class="relative flex items-center p-3 cursor-pointer rounded-lg border border-slate-200 hover:border-indigo-300 transition-all has-checked:border-indigo-600 has-checked:bg-indigo-50">
                            <input type="radio" name="sub_role" value="cs" class="sr-only">
                            <span class="text-sm font-semibold text-slate-700">Company Secretary</span>
                        </label>
                        <label class="relative flex items-center p-3 cursor-pointer rounded-lg border border-slate-200 hover:border-indigo-300 transition-all has-checked:border-indigo-600 has-checked:bg-indigo-50">
                            <input type="radio" name="sub_role" value="ip_attorney" class="sr-only">
                            <span class="text-sm font-semibold text-slate-700">IP Attorney</span>
                        </label>
                    </div>

                    <div id="support-roles" class="hidden grid-cols-2 gap-3">
                        <label class="relative flex items-center p-3 cursor-pointer rounded-lg border border-slate-200 hover:border-indigo-300 transition-all has-checked:border-indigo-600 has-checked:bg-indigo-50">
                            <input type="radio" name="sub_role" value="court_clerk" class="sr-only">
                            <span class="text-sm font-semibold text-slate-700">Court Clerk</span>
                        </label>
                        <label class="relative flex items-center p-3 cursor-pointer rounded-lg border border-slate-200 hover:border-indigo-300 transition-all has-checked:border-indigo-600 has-checked:bg-indigo-50">
                            <input type="radio" name="sub_role" value="ip_clerk" class="sr-only">
                            <span class="text-sm font-semibold text-slate-700">IP Clerk</span>
                        </label>
                        <label class="relative flex items-center p-3 cursor-pointer rounded-lg border border-slate-200 hover:border-indigo-300 transition-all has-checked:border-indigo-600 has-checked:bg-indigo-50">
                            <input type="radio" name="sub_role" value="roc_clerk" class="sr-only">
                            <span class="text-sm font-semibold text-slate-700">ROC Clerk</span>
                        </label>
                        <label class="relative flex items-center p-3 cursor-pointer rounded-lg border border-slate-200 hover:border-indigo-300 transition-all has-checked:border-indigo-600 has-checked:bg-indigo-50">
                            <input type="radio" name="sub_role" value="advocate_support" class="sr-only">
                            <span class="text-sm font-semibold text-slate-700">Advocate Support</span>
                        </label>
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        Continue Registration <i class="fas fa-arrow-right ml-2 mt-0.5"></i>
                    </button>
                </div>
            </form>

            <script>
                function toggleSubRoles(group) {
                    const container = document.getElementById('sub-role-container');
                    const profRoles = document.getElementById('professional-roles');
                    const supportRoles = document.getElementById('support-roles');
                    
                    container.classList.remove('hidden');
                    
                    if (group === 'professional') {
                        profRoles.classList.remove('hidden');
                        supportRoles.classList.add('hidden');
                    } else {
                        profRoles.classList.add('hidden');
                        supportRoles.classList.remove('hidden');
                    }
                }
            </script>

            <div class="mt-6 text-center">
                <p class="text-sm text-slate-500">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 underline decoration-indigo-200 underline-offset-4">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
