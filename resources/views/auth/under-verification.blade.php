@extends('layouts.main')

@section('title', 'Under Verification - CourtPulse')

@section('content')
    <div class="min-h-screen bg-navy flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Premium Background Effects -->
        <div class="absolute top-1/4 left-0 w-96 h-96 bg-blue/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue/5 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
            <div
                class="bg-navy2 py-10 px-6 sm:px-10 shadow-2xl sm:rounded-3xl border border-white/10 relative overflow-hidden text-center">

                <!-- Icon -->
                <div
                    class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-blue/10 text-blue border border-blue/20 mb-6 shadow-[0_0_30px_rgba(180,180,254,0.15)]">
                    <i class="fas fa-user-clock text-3xl"></i>
                </div>

                <!-- Headings -->
                <h2 class="text-2xl md:text-3xl font-black text-white uppercase tracking-tighter leading-none mb-3">
                    Verification Pending
                </h2>
                <p class="text-sm font-bold text-white/60 leading-relaxed max-w-sm mx-auto mb-8">
                    Your account is currently under review. Once verified by our team, you will be able to login and access
                    your dashboard.
                </p>

                <!-- Status Badge -->
                <div class="bg-white/5 border border-white/10 rounded-2xl py-4 px-6 mb-8 inline-block shadow-inner">
                    <span class="block text-[10px] font-black text-blue uppercase tracking-widest mb-1">Current
                        Status</span>
                    <span class="block text-sm font-black text-white uppercase tracking-wider">
                        <i class="fas fa-spinner fa-spin mr-2 text-blue"></i> Review In Progress
                    </span>
                </div>

                <!-- Logout Form -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex justify-center items-center py-4 px-6 rounded-xl text-xs font-black text-navy uppercase tracking-widest bg-blue hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-navy focus:ring-blue transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        <span>Logout & Check Later</span>
                    </button>
                </form>

                <div class="mt-6 border-t border-white/5 pt-6">
                    <p class="text-[10px] font-bold text-white/40 uppercase tracking-widest">
                        Estimated time: 12-24 Hours
                    </p>
                </div>

            </div>
        </div>
    </div>
@endsection