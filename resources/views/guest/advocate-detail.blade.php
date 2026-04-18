@extends('layouts.guest')
@section('title', 'Advocate Profile: ' . $user->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Left: Profile Card --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100 sticky top-24">
                <div class="bg-navy h-24 relative">
                    <div class="absolute -bottom-12 left-8">
                        <div class="w-24 h-24 rounded-2xl bg-white p-1 shadow-lg">
                            <div class="w-full h-full rounded-xl bg-slate-50 flex items-center justify-center font-bold text-slate-400 text-3xl border border-slate-100">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-16 pb-8 px-8">
                    <div class="flex items-center gap-2 mb-1">
                        <h1 class="text-2xl font-bold text-slate-800">{{ $user->name }}</h1>
                        <i class="bi bi-patch-check-fill text-blue-500" title="Verified Professional"></i>
                    </div>
                    <p class="text-slate-500 font-medium mb-4">Advocate</p>
                    
                    <div class="flex items-center gap-2 mb-6">
                        <div class="flex text-amber-400">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= round($avgRating) ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                        <span class="text-sm font-bold text-slate-700">{{ number_format($avgRating, 1) }}</span>
                        <span class="text-xs text-slate-400">({{ $feedbacks->count() }} reviews)</span>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                <i class="bi bi-envelope text-blue-600"></i>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-[0.65rem] text-slate-400 font-bold uppercase tracking-wider">Email Address</p>
                                <p class="text-sm text-slate-700 truncate">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                                <i class="bi bi-geo-alt text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-[0.65rem] text-slate-400 font-bold uppercase tracking-wider">Location</p>
                                <p class="text-sm text-slate-700">{{ $profile->city ?? 'Not specified' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center shrink-0">
                                <i class="bi bi-card-text text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-[0.65rem] text-slate-400 font-bold uppercase tracking-wider">Bar Council No.</p>
                                <p class="text-sm text-slate-700 font-mono">{{ $profile->bar_council_number ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <p class="text-[0.65rem] text-slate-400 font-bold uppercase tracking-wider mb-3">Practice Areas</p>
                        <div class="flex flex-wrap gap-2">
                            @if($profile && $profile->practice_areas)
                                @foreach($profile->practice_areas as $area)
                                    <span class="px-3 py-1 bg-slate-50 text-slate-600 text-xs font-semibold rounded-lg border border-slate-100">
                                        {{ $area }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-xs text-slate-400 italic">No areas specified</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Content --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Bio Card --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="bi bi-info-circle text-gold"></i> Professional Bio
                </h2>
                <div class="prose prose-slate max-w-none">
                    <p class="text-slate-600 leading-relaxed italic">
                        {{ $profile->bio ?? 'No biography has been added yet.' }}
                    </p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 pt-8 border-t border-slate-50">
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Experience</p>
                        <p class="font-bold text-slate-800">{{ $profile->experience_years ?? 0 }} Years</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Enrolled On</p>
                        <p class="font-bold text-slate-800">{{ $profile->enrollment_date ? $profile->enrollment_date->format('M Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 mb-1">High Court</p>
                        <p class="font-bold text-slate-800">{{ $profile->high_court ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Avg. Rating</p>
                        <p class="font-bold text-gold">{{ number_format($avgRating, 1) }}/5.0</p>
                    </div>
                </div>
            </div>

            {{-- Feedbacks --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 text-slate-500">
                <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="bi bi-chat-left-quote text-gold"></i> Professional Reviews
                </h2>

                <div class="space-y-6">
                    @forelse($feedbacks as $feedback)
                        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-white hover:border-gold/20 hover:shadow-lg transition-all">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center font-bold text-slate-300">
                                        {{ strtoupper(substr($feedback->giver->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-800">{{ $feedback->giver->name }}</h4>
                                        <p class="text-[0.65rem] text-slate-400 font-medium font-mono uppercase">{{ $feedback->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex text-amber-400 text-xs">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $feedback->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-sm text-slate-600 leading-relaxed italic">
                                "{{ $feedback->comment }}"
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="text-slate-200 mb-4">
                                <i class="bi bi-chat-dots text-6xl"></i>
                            </div>
                            <h3 class="text-slate-800 font-bold">No reviews yet</h3>
                            <p class="text-slate-500 text-sm">Be the first to leave a feedback for {{ $user->name }}!</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <div class="bg-navy rounded-3xl p-8 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl shadow-navy/20">
                <div>
                    <h3 class="text-xl font-bold mb-2">Want to connect with {{ $user->name }}?</h3>
                    <p class="text-slate-300 text-sm">Register an account or login to consult with this professional.</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('login') }}" class="px-8 py-3 rounded-xl bg-white text-navy font-bold text-sm hover:bg-slate-50 transition-all">Login</a>
                    <a href="{{ route('register') }}" class="px-8 py-3 rounded-xl bg-gold text-navy font-bold text-sm hover:scale-105 transition-all">Register Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
