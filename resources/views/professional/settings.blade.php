@extends('professional.layouts.master')
@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- Left Column: Settings Options -->
    <div class="lg:col-span-8 space-y-6">
        <div class="bg-navy2 border border-white/5 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02]">
                <h3 class="text-lg font-bold text-white">Account Settings</h3>
            </div>
            <div class="p-6 space-y-8">
                <!-- Email Notifications -->
                <div>
                    <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-3">Email Notifications</label>
                    <div class="flex items-center gap-4 p-4 bg-white/[0.02] border border-white/5 rounded-xl hover:border-white/10 transition-colors">
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="emailNotif" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white/40 after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue peer-checked:after:bg-navy peer-checked:after:border-transparent"></div>
                        </div>
                        <label for="emailNotif" class="text-sm font-medium text-white/80 cursor-pointer">Receive email notifications for new connection requests</label>
                    </div>
                </div>

                <!-- Profile Visibility -->
                <div>
                    <label class="block text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mb-3">Profile Visibility</label>
                    <div class="flex items-center gap-4 p-4 bg-white/[0.02] border border-white/5 rounded-xl hover:border-white/10 transition-colors">
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="profileVisibility" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white/40 after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue peer-checked:after:bg-navy peer-checked:after:border-transparent"></div>
                        </div>
                        <label for="profileVisibility" class="text-sm font-medium text-white/80 cursor-pointer">Allow other users to find my profile in search</label>
                    </div>
                </div>

                <div class="h-px bg-white/5"></div>

                <!-- Danger Zone -->
                <div class="pt-2">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fas fa-exclamation-triangle text-red-400 text-xs"></i>
                        <h4 class="text-sm font-bold text-red-400 uppercase tracking-wider">Danger Zone</h4>
                    </div>
                    <div class="p-4 border border-red-500/20 bg-red-500/5 rounded-xl">
                        <button class="px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white text-xs font-bold rounded-lg transition-all flex items-center gap-2">
                            <i class="fas fa-trash"></i> Delete Account
                        </button>
                        <p class="text-white/40 text-[11px] mt-3 leading-relaxed">
                            Once you delete your account, all your connections, feedbacks, and profile data will be permanently removed. This action cannot be undone.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Help Info -->
    <div class="lg:col-span-4">
        <div class="bg-navy2 border border-white/5 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02]">
                <h3 class="text-lg font-bold text-white">Platform Guidelines</h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-lg bg-blue/10 flex items-center justify-center text-blue shrink-0">
                        <i class="fas fa-shield-alt text-sm"></i>
                    </div>
                    <div>
                        <h5 class="text-sm font-bold text-white mb-1">Privacy Rules</h5>
                        <p class="text-xs text-white/50 leading-relaxed">Your email and phone number are hidden from users you are not connected with.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-lg bg-blue/10 flex items-center justify-center text-blue shrink-0">
                        <i class="fas fa-link text-sm"></i>
                    </div>
                    <div>
                        <h5 class="text-sm font-bold text-white mb-1">Connection System</h5>
                        <p class="text-xs text-white/50 leading-relaxed">Once someone accepts your request, you can view their contact details and documents.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-lg bg-blue/10 flex items-center justify-center text-blue shrink-0">
                        <i class="fas fa-star-half-alt text-sm"></i>
                    </div>
                    <div>
                        <h5 class="text-sm font-bold text-white mb-1">Feedback</h5>
                        <p class="text-xs text-white/50 leading-relaxed">You can only give ratings and reviews to users in your active connections list.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
