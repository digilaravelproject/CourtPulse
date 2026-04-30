@extends('layouts.main')
@section('title', 'Court Registry Management')
@section('content')
<div class="min-h-screen pt-32 pb-20 bg-slate-50">
    <div class="max-w-[1500px] mx-auto px-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12 gap-6">
            <div>
                <h2 class="text-4xl font-black text-navy uppercase tracking-tighter">Court Registry</h2>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-3">Manage institutional coverage and location data</p>
            </div>
            <button onclick="document.getElementById('courtModal').classList.remove('hidden')" class="bg-blue text-white px-10 py-4 rounded-2xl text-[0.65rem] font-black uppercase tracking-widest hover:bg-navy transition-all transform hover:scale-105 shadow-xl shadow-blue/20">
                Register New Court
            </button>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-200">
                            <th class="px-8 py-5 text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.2em]">Institution Name</th>
                            <th class="px-8 py-5 text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.2em]">Hierarchy / Type</th>
                            <th class="px-8 py-5 text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.2em]">Location Details</th>
                            <th class="px-8 py-5 text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.2em]">Data Status</th>
                            <th class="px-8 py-5 text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($courts as $court)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="text-sm font-black text-navy uppercase tracking-tight group-hover:text-blue transition-colors">{{ $court->name }}</div>
                                <div class="text-[0.6rem] text-slate-400 font-bold uppercase tracking-widest mt-1">ID: #{{ str_pad($court->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-[0.6rem] font-black uppercase tracking-widest text-navy bg-slate-100 border border-slate-200 px-3 py-1 rounded-full">{{ $court->type }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-xs font-black text-navy uppercase tracking-tight">{{ $court->area }}</div>
                                <div class="text-[0.65rem] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $court->city }} — {{ $court->pincode }}</div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[0.55rem] font-black uppercase tracking-widest {{ $court->is_active ? 'bg-green-50 text-green-600 border border-green-100' : 'bg-red-50 text-red-600 border border-red-100' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $court->is_active ? 'bg-green-600 animate-pulse' : 'bg-red-600' }}"></span>
                                    {{ $court->is_active ? 'Live' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button class="p-2 text-slate-400 hover:text-navy transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-24 text-center text-slate-400 font-black uppercase tracking-widest text-xs">No courts registered in the database.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($courts->hasPages())
            <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-200">
                {{ $courts->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Court Modal -->
<div id="courtModal" class="fixed inset-0 bg-navy/80 backdrop-blur-md z-50 hidden flex items-center justify-center p-6">
    <div class="bg-white w-full max-w-xl rounded-3xl overflow-hidden shadow-2xl relative transform transition-all">
        <div class="bg-navy p-8 text-center relative">
            <button onclick="document.getElementById('courtModal').classList.add('hidden')" class="absolute top-6 right-6 text-white/40 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <h3 class="text-2xl font-black text-white uppercase tracking-tighter">Register Institution</h3>
            <p class="text-white/40 text-[0.65rem] font-bold uppercase tracking-[0.3em] mt-2">Database Registry Entry</p>
        </div>
        <div class="p-10">
            <form action="{{ route('admin.manage.courts.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="text-[0.65rem] font-black text-navy uppercase tracking-widest block mb-2">Institution / Court Name</label>
                    <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-4 text-navy font-bold focus:ring-2 focus:ring-blue outline-none transition-all" placeholder="e.g. Bombay High Court">
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-[0.65rem] font-black text-navy uppercase tracking-widest block mb-2">Category / Type</label>
                        <select name="type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-4 text-navy font-bold focus:ring-2 focus:ring-blue outline-none transition-all appearance-none">
                            <option value="Supreme Court">Supreme Court</option>
                            <option value="High Court">High Court</option>
                            <option value="District Court">District Court</option>
                            <option value="Tribunal">Tribunal</option>
                            <option value="ROC Office">ROC Office</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[0.65rem] font-black text-navy uppercase tracking-widest block mb-2">Location Pincode</label>
                        <input type="text" name="pincode" required maxlength="6" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-4 text-navy font-bold focus:ring-2 focus:ring-blue outline-none transition-all" placeholder="400001">
                    </div>
                </div>
                <div>
                    <label class="text-[0.65rem] font-black text-navy uppercase tracking-widest block mb-2">City / District</label>
                    <input type="text" name="city" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-4 text-navy font-bold focus:ring-2 focus:ring-blue outline-none transition-all" placeholder="Mumbai">
                </div>
                <div>
                    <label class="text-[0.65rem] font-black text-navy uppercase tracking-widest block mb-2">Complete Area / Address</label>
                    <textarea name="area" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-4 text-navy font-bold focus:ring-2 focus:ring-blue outline-none h-28 resize-none transition-all" placeholder="Fort, MG Road..."></textarea>
                </div>
                <button type="submit" class="w-full bg-blue text-white py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-navy transition-all shadow-lg shadow-blue/20">
                    Commit to Registry
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
