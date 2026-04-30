@extends('layouts.main')

@section('title', 'Join CourtPulse — Select Your Professional Identity')

@section('content')
<div class="min-h-screen bg-white flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Abstract Background Element -->
    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-96 h-96 bg-blue/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-96 h-96 bg-navy/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-navy mb-6 shadow-xl shadow-navy/20">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
            </svg>
        </div>
        <h2 class="text-3xl font-black text-navy uppercase tracking-tighter leading-none mb-2">
            Professional Network
        </h2>
        <p class="text-sm font-bold text-muted uppercase tracking-widest">
            Select your category to begin
        </p>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-xl relative z-10">
        <div class="bg-white py-10 px-6 sm:px-12 shadow-[0_20px_50px_rgba(5,8,18,0.08)] sm:rounded-3xl border border-slate-100">
            <form action="{{ route('register.step1.post') }}" method="POST" id="role-form">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <!-- Professional Group -->
                    <label class="group relative flex flex-col p-5 cursor-pointer rounded-2xl border-2 transition-all hover:border-navy duration-300 border-slate-100 bg-slate-50/50 has-checked:border-navy has-checked:bg-white has-checked:shadow-lg has-checked:shadow-navy/5">
                        <input type="radio" name="user_group" value="professional" class="sr-only" required onchange="updateUI('professional')">
                        <div class="flex items-center justify-center w-10 h-10 mb-4 rounded-xl bg-navy text-white group-hover:scale-110 transition-transform shadow-md">
                            <i class="fas fa-user-tie text-sm"></i>
                        </div>
                        <span class="text-base font-black text-navy uppercase tracking-tight mb-1">Professional</span>
                        <span class="text-[10px] font-bold text-muted uppercase tracking-wider leading-relaxed">Advocates, CA, CS, or IP Agents.</span>
                        
                        <div class="absolute top-4 right-4 text-navy opacity-0 group-has-checked:opacity-100 transition-opacity">
                            <i class="fas fa-check-circle text-lg"></i>
                        </div>
                    </label>

                    <!-- Support Group -->
                    <label class="group relative flex flex-col p-5 cursor-pointer rounded-2xl border-2 transition-all hover:border-blue duration-300 border-slate-100 bg-slate-50/50 has-checked:border-navy has-checked:bg-white has-checked:shadow-lg has-checked:shadow-navy/5">
                        <input type="radio" name="user_group" value="support" class="sr-only" onchange="updateUI('support')">
                        <div class="flex items-center justify-center w-10 h-10 mb-4 rounded-xl bg-blue text-navy group-hover:scale-110 transition-transform shadow-md">
                            <i class="fas fa-users-cog text-sm"></i>
                        </div>
                        <span class="text-base font-black text-navy uppercase tracking-tight mb-1">Support</span>
                        <span class="text-[10px] font-bold text-muted uppercase tracking-wider leading-relaxed">Court Clerks or IP Clerks.</span>

                        <div class="absolute top-4 right-4 text-blue opacity-0 group-has-checked:opacity-100 transition-opacity">
                            <i class="fas fa-check-circle text-lg"></i>
                        </div>
                    </label>

                    <!-- Guest Group -->
                    <label class="group relative flex flex-col p-5 cursor-pointer rounded-2xl border-2 transition-all hover:border-slate-400 duration-300 border-slate-100 bg-slate-50/50 has-checked:border-navy has-checked:bg-white has-checked:shadow-lg has-checked:shadow-navy/5">
                        <input type="radio" name="user_group" value="guest" class="sr-only" onchange="updateUI('guest')">
                        <div class="flex items-center justify-center w-10 h-10 mb-4 rounded-xl bg-slate-200 text-navy group-hover:scale-110 transition-transform shadow-md">
                            <i class="fas fa-user-secret text-sm"></i>
                        </div>
                        <span class="text-base font-black text-navy uppercase tracking-tight mb-1">Guest</span>
                        <span class="text-[10px] font-bold text-muted uppercase tracking-wider leading-relaxed">General access or testing.</span>

                        <div class="absolute top-4 right-4 text-slate-400 opacity-0 group-has-checked:opacity-100 transition-opacity">
                            <i class="fas fa-check-circle text-lg"></i>
                        </div>
                    </label>
                </div>

                <!-- Sub-role Selection (Animated) -->
                <div id="sub-role-container" class="hidden space-y-4 pt-4 border-t border-slate-100 animate-in fade-in slide-in-from-top-2">
                    <h4 class="text-[10px] font-black text-muted uppercase tracking-[0.2em] mb-4">Choose Specific Identity</h4>
                    
                    <!-- Professionals Grid -->
                    <div id="professional-roles" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="relative flex items-center justify-center p-3 cursor-pointer rounded-xl border border-slate-200 transition-all hover:bg-slate-50 has-checked:border-navy has-checked:bg-navy has-checked:text-white">
                            <input type="radio" name="sub_role" value="advocate_practicing" class="sr-only">
                            <span class="text-xs font-black uppercase tracking-widest">Practicing Advocate</span>
                        </label>
                        <label class="relative flex items-center justify-center p-3 cursor-pointer rounded-xl border border-slate-200 transition-all hover:bg-slate-50 has-checked:border-navy has-checked:bg-navy has-checked:text-white">
                            <input type="radio" name="sub_role" value="advocate_non_practicing" class="sr-only">
                            <span class="text-xs font-black uppercase tracking-widest">Non-Practicing Advocate</span>
                        </label>
                        <label class="relative flex items-center justify-center p-3 cursor-pointer rounded-xl border border-slate-200 transition-all hover:bg-slate-50 has-checked:border-navy has-checked:bg-navy has-checked:text-white">
                            <input type="radio" name="sub_role" value="ca_cs" class="sr-only">
                            <span class="text-xs font-black uppercase tracking-widest">CA / CS</span>
                        </label>
                        <label class="relative flex items-center justify-center p-3 cursor-pointer rounded-xl border border-slate-200 transition-all hover:bg-slate-50 has-checked:border-navy has-checked:bg-navy has-checked:text-white">
                            <input type="radio" name="sub_role" value="agent" class="sr-only">
                            <span class="text-xs font-black uppercase tracking-widest">IP Agent</span>
                        </label>
                    </div>

                    <!-- Support Grid -->
                    <div id="support-roles" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="relative flex items-center justify-center p-3 cursor-pointer rounded-xl border border-slate-200 transition-all hover:bg-slate-50 has-checked:border-blue has-checked:bg-blue has-checked:text-navy">
                            <input type="radio" name="sub_role" value="court_clerk" class="sr-only">
                            <span class="text-xs font-black uppercase tracking-widest">Court Clerk</span>
                        </label>
                        <label class="relative flex items-center justify-center p-3 cursor-pointer rounded-xl border border-slate-200 transition-all hover:bg-slate-50 has-checked:border-blue has-checked:bg-blue has-checked:text-navy">
                            <input type="radio" name="sub_role" value="ip_clerk" class="sr-only">
                            <span class="text-xs font-black uppercase tracking-widest">IP Clerk</span>
                        </label>
                    </div>

                    <!-- Guest Message -->
                    <div id="guest-roles" class="hidden text-center py-4 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                        <p class="text-[10px] font-bold text-muted uppercase tracking-widest">No additional details required for Guest</p>
                    </div>
                </div>


                <div class="mt-10">
                    <button type="submit" class="w-full flex items-center justify-center gap-3 py-4 px-6 rounded-2xl bg-navy text-white font-black uppercase text-xs tracking-[0.2em] shadow-xl shadow-navy/20 hover:bg-black hover:scale-[1.02] active:scale-[0.98] transition-all group">
                        Next Phase
                        <i class="fas fa-chevron-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                    </button>
                    
                    <div class="mt-8 text-center border-t border-slate-50 pt-8">
                        <p class="text-xs font-bold text-muted uppercase tracking-widest">
                            Member already? 
                            <a href="{{ route('login') }}" class="text-navy hover:text-blue transition-colors underline decoration-blue/30 underline-offset-4 ml-1">Authenticate Here</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateUI(group) {
        const container = document.getElementById('sub-role-container');
        const profRoles = document.getElementById('professional-roles');
        const supportRoles = document.getElementById('support-roles');
        const guestRoles = document.getElementById('guest-roles');
        
        container.classList.remove('hidden');
        
        // Hide all first
        profRoles.classList.add('hidden');
        profRoles.classList.remove('grid');
        supportRoles.classList.add('hidden');
        supportRoles.classList.remove('grid');
        guestRoles.classList.add('hidden');

        if (group === 'professional') {
            profRoles.classList.remove('hidden');
            profRoles.classList.add('grid');
        } else if (group === 'support') {
            supportRoles.classList.remove('hidden');
            supportRoles.classList.add('grid');
        } else if (group === 'guest') {
            guestRoles.classList.remove('hidden');
        }
    }
</script>
@endsection
