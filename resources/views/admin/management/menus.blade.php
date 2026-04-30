@extends('layouts.main')
@section('title', 'Navigation Control Panel')
@section('content')
<div class="min-h-screen pt-32 pb-20 bg-slate-50">
    <div class="max-w-4xl mx-auto px-6">
        <div class="mb-16">
            <h2 class="text-4xl font-black text-navy uppercase tracking-tighter">Navigation Control</h2>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-3">Toggle global menu visibility and modify hierarchy labels</p>
        </div>

        <div class="space-y-6">
            @forelse($menus as $menu)
            <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/40 flex flex-col md:flex-row items-center justify-between gap-8 group transition-all hover:border-blue/30">
                <div class="flex items-center gap-6 w-full md:w-auto">
                    <div class="w-14 h-14 bg-navy/5 rounded-2xl flex items-center justify-center border border-navy/10 group-hover:bg-navy group-hover:text-white transition-all">
                        <span class="font-black text-xl tracking-tighter">{{ $menu->order }}</span>
                    </div>
                    <div>
                        <div class="text-[0.65rem] text-slate-400 font-black uppercase tracking-[0.2em] mb-1">Route / Endpoint</div>
                        <div class="text-sm font-black text-navy uppercase tracking-tight">{{ $menu->route }}</div>
                    </div>
                </div>
                
                <form action="{{ route('admin.manage.menus.update', $menu) }}" method="POST" class="flex flex-wrap items-center gap-6 w-full md:w-auto justify-between md:justify-end">
                    @csrf
                    @method('PATCH')
                    
                    <div class="flex flex-col gap-2 min-w-[200px]">
                        <label class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest ml-1">Menu Label</label>
                        <input type="text" name="label" value="{{ $menu->label }}" class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-navy outline-none focus:ring-2 focus:ring-blue transition-all">
                    </div>
                    
                    <div class="flex flex-col gap-2">
                        <label class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest ml-1">Visibility</label>
                        <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl p-1">
                            <button type="button" onclick="updateVisibility(this, 1)" class="px-4 py-2 rounded-lg text-[0.6rem] font-black uppercase tracking-widest transition-all {{ $menu->is_visible ? 'bg-navy text-white' : 'text-slate-400 hover:text-navy' }}">On</button>
                            <button type="button" onclick="updateVisibility(this, 0)" class="px-4 py-2 rounded-lg text-[0.6rem] font-black uppercase tracking-widest transition-all {{ !$menu->is_visible ? 'bg-navy text-white' : 'text-slate-400 hover:text-navy' }}">Off</button>
                            <input type="hidden" name="is_visible" value="{{ $menu->is_visible ? 1 : 0 }}">
                        </div>
                    </div>

                    <button type="submit" class="bg-blue/10 text-blue p-3 rounded-xl hover:bg-blue hover:text-white transition-all border border-blue/10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </button>
                </form>
            </div>
            @empty
            <div class="bg-white p-20 rounded-3xl border border-slate-200 text-center">
                <p class="text-slate-400 font-black uppercase tracking-widest text-xs">No menu items found in the configuration.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function updateVisibility(btn, value) {
    const container = btn.closest('.flex');
    const input = container.querySelector('input[name="is_visible"]');
    const buttons = container.querySelectorAll('button');
    
    input.value = value;
    buttons.forEach(b => {
        b.classList.remove('bg-navy', 'text-white');
        b.classList.add('text-slate-400');
    });
    
    btn.classList.remove('text-slate-400');
    btn.classList.add('bg-navy', 'text-white');
    
    // Auto-submit if needed or just keep value for submit button
    // btn.closest('form').submit(); 
}
</script>
@endsection
