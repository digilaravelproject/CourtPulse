@extends('layouts.admin')
@section('title', 'Navigation Control')
@section('page-title', 'Menu Management')

@section('content')

    {{-- Page Header --}}
    <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-8 mb-10">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-lg text-white uppercase tracking-tight">Navigation Control Panel</h2>
                <p class="text-white/40 text-xs font-bold uppercase tracking-widest mt-2">Toggle global menu visibility and modify navigation labels</p>
            </div>
            <div class="flex items-center gap-3 text-white/30 text-xs font-black uppercase tracking-widest">
                <i class="fas fa-bars text-blue"></i>
                <span>{{ count($menus) }} Menu Items</span>
            </div>
        </div>
    </div>

    {{-- Menu Items --}}
    <div class="space-y-4">
        @forelse($menus as $menu)
            <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-8 flex flex-col lg:flex-row items-center justify-between gap-8 group hover:border-blue/20 transition-all duration-300">

                {{-- Left: Order & Route --}}
                <div class="flex items-center gap-6 w-full lg:w-auto">
                    <div class="w-14 h-14 rounded-2xl bg-blue/10 border border-blue/20 flex items-center justify-center text-blue font-black text-xl shrink-0 shadow-[0_0_15px_rgba(180,180,254,0.1)] group-hover:shadow-[0_0_20px_rgba(180,180,254,0.2)] transition-all">
                        {{ $menu->order }}
                    </div>
                    <div>
                        <div class="text-[0.6rem] text-white/30 font-black uppercase tracking-[0.2em] mb-1.5">Route / Endpoint</div>
                        <div class="text-sm font-black text-white uppercase tracking-tight">{{ $menu->route }}</div>
                    </div>
                </div>

                {{-- Right: Form Controls --}}
                <form action="{{ route('admin.manage.menus.update', $menu) }}" method="POST"
                    class="flex flex-wrap items-end gap-6 w-full lg:w-auto justify-between lg:justify-end">
                    @csrf
                    @method('PATCH')

                    {{-- Label Input --}}
                    <div class="flex flex-col gap-2 min-w-[200px]">
                        <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest ml-1">Menu Label</label>
                        <input type="text" name="label" value="{{ $menu->label }}"
                            class="bg-navy border border-white/10 rounded-xl px-4 py-3 text-sm font-bold text-white placeholder-white/20 outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner">
                    </div>

                    {{-- Visibility Toggle --}}
                    <div class="flex flex-col gap-2">
                        <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest ml-1">Visibility</label>
                        <div class="flex items-center bg-navy border border-white/10 rounded-xl p-1 shadow-inner">
                            <button type="button" onclick="updateVisibility(this, 1)"
                                class="px-5 py-2.5 rounded-lg text-[0.6rem] font-black uppercase tracking-widest transition-all {{ $menu->is_visible ? 'bg-green-500/20 text-green-400 border border-green-500/30 shadow-[0_0_10px_rgba(34,197,94,0.15)]' : 'text-white/30 hover:text-white/60 border border-transparent' }}">
                                <i class="fas fa-eye mr-1"></i> On
                            </button>
                            <button type="button" onclick="updateVisibility(this, 0)"
                                class="px-5 py-2.5 rounded-lg text-[0.6rem] font-black uppercase tracking-widest transition-all {{ !$menu->is_visible ? 'bg-red-500/20 text-red-400 border border-red-500/30 shadow-[0_0_10px_rgba(239,68,68,0.15)]' : 'text-white/30 hover:text-white/60 border border-transparent' }}">
                                <i class="fas fa-eye-slash mr-1"></i> Off
                            </button>
                            <input type="hidden" name="is_visible" value="{{ $menu->is_visible ? 1 : 0 }}">
                        </div>
                    </div>

                    {{-- Save Button --}}
                    <button type="submit"
                        class="flex items-center gap-2 px-6 py-3 text-xs font-black uppercase tracking-widest bg-blue/10 text-blue border border-blue/20 rounded-xl hover:bg-blue hover:text-navy transition-all shadow-[0_0_15px_rgba(180,180,254,0.1)]">
                        <i class="fas fa-check text-sm"></i> Save
                    </button>
                </form>
            </div>
        @empty
            <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-20 text-center">
                <div class="w-20 h-20 rounded-3xl bg-white/5 border border-white/10 flex items-center justify-center text-white/20 text-3xl mx-auto mb-4">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="font-black text-white/60 uppercase tracking-widest text-sm mb-1">No Menu Items</div>
                <div class="text-white/30 text-xs font-bold">No navigation items found in the configuration.</div>
            </div>
        @endforelse
    </div>

@endsection

@push('scripts')
<script>
function updateVisibility(btn, value) {
    const container = btn.closest('.flex.items-center');
    const input = container.querySelector('input[name="is_visible"]');
    const buttons = container.querySelectorAll('button');

    input.value = value;

    buttons.forEach(b => {
        // Reset all buttons
        b.className = 'px-5 py-2.5 rounded-lg text-[0.6rem] font-black uppercase tracking-widest transition-all text-white/30 hover:text-white/60 border border-transparent';
    });

    if (value === 1) {
        btn.className = 'px-5 py-2.5 rounded-lg text-[0.6rem] font-black uppercase tracking-widest transition-all bg-green-500/20 text-green-400 border border-green-500/30 shadow-[0_0_10px_rgba(34,197,94,0.15)]';
    } else {
        btn.className = 'px-5 py-2.5 rounded-lg text-[0.6rem] font-black uppercase tracking-widest transition-all bg-red-500/20 text-red-400 border border-red-500/30 shadow-[0_0_10px_rgba(239,68,68,0.15)]';
    }
}
</script>
@endpush
