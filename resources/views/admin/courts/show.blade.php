@extends('layouts.admin')
@section('title', $court->name)
@section('page-title', 'Court Details')

@section('content')

    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('admin.courts.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium border border-slate-200
           rounded-lg hover:border-slate-400 bg-white text-slate-600 transition-all">
            <i class="bi bi-arrow-left"></i> Back to Courts
        </a>
        <a href="{{ route('admin.courts.edit', $court) }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold
           bg-gold hover:bg-gold-h text-navy rounded-lg transition-all shadow-sm shadow-gold/30">
            <i class="bi bi-pencil"></i> Edit Court
        </a>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

            @php
                $badgeColors = [
                    'supreme' => ['bg' => 'bg-red-100', 'text' => 'text-red-600', 'label' => 'text-red-700'],
                    'high' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'label' => 'text-purple-700'],
                    'district' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'label' => 'text-blue-700'],
                    'session' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600', 'label' => 'text-indigo-700'],
                    'civil' => ['bg' => 'bg-sky-100', 'text' => 'text-sky-600', 'label' => 'text-sky-700'],
                    'criminal' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-600', 'label' => 'text-orange-700'],
                    'family' => ['bg' => 'bg-pink-100', 'text' => 'text-pink-600', 'label' => 'text-pink-700'],
                    'consumer' => ['bg' => 'bg-teal-100', 'text' => 'text-teal-600', 'label' => 'text-teal-700'],
                ];
                $colors = $badgeColors[$court->type] ?? ['bg' => 'bg-amber-100', 'text' => 'text-amber-600', 'label' => 'text-amber-700'];
            @endphp

            {{-- Header --}}
            <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl shrink-0 {{ $colors['bg'] }} {{ $colors['text'] }}">
                    <i class="bi bi-building"></i>
                </div>
                <div class="flex-1">
                    <h2 class="font-display font-bold text-lg text-slate-800">{{ $court->name }}</h2>
                    <span class="inline-flex items-center text-[0.62rem] font-semibold px-2.5 py-1 mt-1 rounded-md font-mono uppercase tracking-wide {{ $colors['bg'] }} {{ $colors['label'] }}">
                        {{ $court->type_label }}
                    </span>
                </div>
                @if ($court->is_active)
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-100 text-green-700
                     font-mono text-[0.62rem] uppercase tracking-wide font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 text-slate-500
                     font-mono text-[0.62rem] uppercase tracking-wide font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactive
                    </span>
                @endif
            </div>

            {{-- Details Grid --}}
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                    <div
                        class="font-mono text-[0.57rem] uppercase tracking-wider text-slate-400 mb-1.5 flex items-center gap-1.5">
                        <i class="bi bi-geo-alt"></i> City
                    </div>
                    <div class="text-sm font-semibold text-slate-700">{{ $court->city }}</div>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                    <div
                        class="font-mono text-[0.57rem] uppercase tracking-wider text-slate-400 mb-1.5 flex items-center gap-1.5">
                        <i class="bi bi-map"></i> State
                    </div>
                    <div class="text-sm font-semibold text-slate-700">{{ $court->state }}</div>
                </div>

                @if ($court->pincode)
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                        <div
                            class="font-mono text-[0.57rem] uppercase tracking-wider text-slate-400 mb-1.5 flex items-center gap-1.5">
                            <i class="bi bi-hash"></i> PIN Code
                        </div>
                        <div class="text-sm font-semibold text-slate-700">{{ $court->pincode }}</div>
                    </div>
                @endif

                @if ($court->phone)
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                        <div
                            class="font-mono text-[0.57rem] uppercase tracking-wider text-slate-400 mb-1.5 flex items-center gap-1.5">
                            <i class="bi bi-telephone"></i> Phone
                        </div>
                        <div class="text-sm font-semibold text-slate-700">{{ $court->phone }}</div>
                    </div>
                @endif

                @if ($court->email)
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                        <div
                            class="font-mono text-[0.57rem] uppercase tracking-wider text-slate-400 mb-1.5 flex items-center gap-1.5">
                            <i class="bi bi-envelope"></i> Email
                        </div>
                        <div class="text-sm font-semibold text-slate-700 break-all">{{ $court->email }}</div>
                    </div>
                @endif

                @if ($court->address)
                    <div class="sm:col-span-2 bg-slate-50 border border-slate-200 rounded-lg p-4">
                        <div
                            class="font-mono text-[0.57rem] uppercase tracking-wider text-slate-400 mb-1.5 flex items-center gap-1.5">
                            <i class="bi bi-signpost"></i> Address
                        </div>
                        <div class="text-sm font-semibold text-slate-700">{{ $court->address }}</div>
                    </div>
                @endif

                <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                    <div
                        class="font-mono text-[0.57rem] uppercase tracking-wider text-slate-400 mb-1.5 flex items-center gap-1.5">
                        <i class="bi bi-calendar3"></i> Added On
                    </div>
                    <div class="text-sm font-semibold text-slate-700">{{ $court->created_at->format('d M Y') }}</div>
                </div>

                @if ($court->createdBy)
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                        <div
                            class="font-mono text-[0.57rem] uppercase tracking-wider text-slate-400 mb-1.5 flex items-center gap-1.5">
                            <i class="bi bi-person"></i> Added By
                        </div>
                        <div class="text-sm font-semibold text-slate-700">{{ $court->createdBy->name }}</div>
                    </div>
                @endif

            </div>

            {{-- Footer Actions --}}
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/60 flex items-center gap-3">
                <a href="{{ route('admin.courts.edit', $court) }}"
                    class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold
               bg-gold hover:bg-gold-h text-navy rounded-lg transition-all shadow-sm shadow-gold/30">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <form action="{{ route('admin.courts.destroy', $court) }}" method="POST"
                    onsubmit="return confirm('Deactivate {{ addslashes($court->name) }}?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold
                 border border-red-200 bg-red-50 hover:bg-red-500 hover:text-white hover:border-red-500
                 text-red-600 rounded-lg transition-all">
                        <i class="bi bi-x-lg"></i> Deactivate
                    </button>
                </form>
            </div>

        </div>
    </div>

@endsection
