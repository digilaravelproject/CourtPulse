@extends('layouts.main')
@section('title', 'User Management')
@section('content')
<div class="min-h-screen pt-32 pb-20 bg-slate-50">
    <div class="max-w-[1500px] mx-auto px-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12 gap-6">
            <div>
                <h2 class="text-4xl font-black text-navy uppercase tracking-tighter">User Verification</h2>
                <div class="flex gap-4 mt-6">
                    @php $status = request('status', 'pending'); @endphp
                    <a href="?status=pending" class="px-6 py-2 rounded-full text-[0.65rem] font-black uppercase tracking-widest transition-all {{ $status === 'pending' ? 'bg-navy text-white shadow-lg shadow-navy/20' : 'bg-white text-slate-400 border border-slate-200 hover:border-navy hover:text-navy' }}">Pending Review</a>
                    <a href="?status=active" class="px-6 py-2 rounded-full text-[0.65rem] font-black uppercase tracking-widest transition-all {{ $status === 'active' ? 'bg-navy text-white shadow-lg shadow-navy/20' : 'bg-white text-slate-400 border border-slate-200 hover:border-navy hover:text-navy' }}">Active Users</a>
                </div>
            </div>
            <div class="bg-white p-2 rounded-xl border border-slate-200 flex items-center shadow-sm">
                <input type="text" placeholder="Search by name or email..." class="bg-transparent border-none px-4 py-2 text-sm font-bold text-navy outline-none w-64">
                <button class="bg-navy text-white p-2 rounded-lg hover:bg-blue transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-200">
                            <th class="px-8 py-5 text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.2em]">User Identity</th>
                            <th class="px-8 py-5 text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.2em]">Professional Role</th>
                            <th class="px-8 py-5 text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.2em]">Primary Association</th>
                            <th class="px-8 py-5 text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.2em]">Registration Date</th>
                            <th class="px-8 py-5 text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Verification</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-navy/5 text-navy flex items-center justify-center font-black text-sm border border-navy/10 group-hover:bg-navy group-hover:text-white transition-all">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(strrchr($user->name, " "), 1, 1)) ?: '' }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-navy uppercase tracking-tight">{{ $user->name }}</div>
                                        <div class="text-[0.65rem] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-[0.65rem] font-black uppercase tracking-widest text-blue bg-blue/5 border border-blue/10 px-2 py-1 rounded-md inline-block w-fit">{{ $user->role }}</span>
                                    @if($user->sub_role)
                                        <span class="text-[0.6rem] font-bold uppercase tracking-widest text-slate-400 mt-2">Specialization: {{ str_replace('_', ' ', $user->sub_role) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-xs font-black text-navy uppercase tracking-tight">{{ $user->court->name ?? 'Direct Network' }}</div>
                                <div class="text-[0.6rem] text-slate-400 uppercase tracking-widest mt-1 font-bold">{{ $user->court->city ?? 'All India' }}</div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-xs font-bold text-navy">{{ $user->created_at->format('d M, Y') }}</div>
                                <div class="text-[0.6rem] text-slate-400 font-black uppercase tracking-widest mt-1">{{ $user->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <button onclick="toggleVerify('{{ $user->id }}')" class="px-6 py-2.5 rounded-xl text-[0.6rem] font-black uppercase tracking-widest transition-all {{ $user->status === 'active' ? 'bg-slate-100 text-slate-400 hover:bg-red-50 hover:text-red-600' : 'bg-blue text-white shadow-lg shadow-blue/20 hover:bg-navy hover:shadow-navy/20' }}">
                                    {{ $user->status === 'active' ? 'Deactivate' : 'Verify & Activate' }}
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    <p class="text-slate-400 font-black uppercase tracking-[0.25em] text-xs">No users found in this category.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
            <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-200">
                {{ $users->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
async function toggleVerify(userId) {
    const action = 'change this user\'s status';
    if(!confirm(`Are you sure you want to ${action}?`)) return;
    
    try {
        const response = await fetch(`/admin/manage/users/${userId}/verify`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        if(data.success) {
            window.location.reload();
        } else {
            alert(data.message || 'Failed to update user status');
        }
    } catch (e) {
        console.error(e);
        alert('A network error occurred. Please try again.');
    }
}
</script>
@endsection
