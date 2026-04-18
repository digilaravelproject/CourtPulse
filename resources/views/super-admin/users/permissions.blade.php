@extends('layouts.super-admin')
@section('title', 'Manage Permissions: ' . $user->name)
@section('page-title', 'Permissions & Access Control')

@section('content')
    <div class="max-w-5xl mx-auto">
        
        {{-- User Summary Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center font-bold text-slate-400 text-xl border border-slate-100">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">{{ $user->name }}</h2>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                    <div class="flex gap-2 mt-2">
                        @foreach($user->getRoleNames() as $role)
                            <span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-600 text-[0.65rem] font-bold uppercase tracking-wider border border-blue-100">
                                {{ $role }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
            <a href="{{ route('super.users') }}" class="text-slate-400 hover:text-navy transition-colors">
                <i class="bi bi-x-lg text-lg"></i>
            </a>
        </div>

        <form action="{{ route('super.users.permissions.update', $user->id) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Left Side: Roles --}}
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100">
                            <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                                <i class="bi bi-shield-lock text-gold"></i> Assigned Roles
                            </h3>
                        </div>
                        <div class="p-6 space-y-3">
                            @foreach($roles as $role)
                                <label class="flex items-center justify-between p-3 rounded-xl border border-slate-100 hover:border-gold/30 hover:bg-slate-50/50 transition-all cursor-pointer group">
                                    <div class="flex items-center gap-3">
                                        <div class="relative flex items-center">
                                            <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                                                {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                                class="peer appearance-none w-5 h-5 border-2 border-slate-200 rounded-lg checked:bg-gold checked:border-gold transition-all cursor-pointer">
                                            <i class="bi bi-check-lg absolute text-white opacity-0 peer-checked:opacity-100 left-1 text-sm pointer-events-none"></i>
                                        </div>
                                        <span class="text-sm font-semibold text-slate-700 group-hover:text-navy transition-colors">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                                    </div>
                                    @if($role->name === 'super_admin')
                                        <i class="bi bi-patch-check-fill text-blue-500" title="Full System Access"></i>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-amber-50 rounded-2xl p-5 border border-amber-100">
                        <h4 class="text-amber-800 font-bold text-xs uppercase tracking-widest mb-2 flex items-center gap-2">
                            <i class="bi bi-exclamation-triangle"></i> Security Note
                        </h4>
                        <p class="text-amber-700 text-xs leading-relaxed">
                            Changes take effect on the next page load. Removing roles may prevent the professional from accessing critical features.
                        </p>
                    </div>
                </div>

                {{-- Right Side: Direct Permissions --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                            <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                                <i class="bi bi-key text-gold"></i> Direct Permissions
                            </h3>
                            <button type="button" onclick="selectAll('permissions[]')" class="text-[0.65rem] font-bold text-gold uppercase tracking-widest hover:underline">Select All</button>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($allPermissions as $permission)
                                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-50 hover:bg-slate-50 transition-all cursor-pointer group">
                                        <div class="relative flex items-center">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                                {{ $user->hasDirectPermission($permission->name) ? 'checked' : '' }}
                                                class="peer appearance-none w-5 h-5 border-2 border-slate-200 rounded-lg checked:bg-navy checked:border-navy transition-all cursor-pointer">
                                            <i class="bi bi-check-lg absolute text-white opacity-0 peer-checked:opacity-100 left-1 text-sm pointer-events-none"></i>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-semibold text-slate-700 group-hover:text-navy transition-colors">{{ ucfirst(str_replace(['.', '-', '_'], ' ', $permission->name)) }}</span>
                                            <span class="text-[0.65rem] text-slate-400 font-mono">{{ $permission->name }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="px-6 py-5 bg-slate-50/50 border-t border-slate-100 flex items-center justify-end gap-3">
                            <button type="reset" class="px-6 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-100 transition-all">
                                Reset Changes
                            </button>
                            <button type="submit" class="px-10 py-2.5 rounded-xl text-sm font-bold text-white shadow-xl shadow-navy/20 transition-all hover:-translate-y-0.5 active:translate-y-0" style="background:#0F172A">
                                Save Updates
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    function selectAll(name) {
        const checkboxes = document.querySelectorAll(`input[name="${name}"]`);
        checkboxes.forEach(cb => cb.checked = true);
    }
</script>
@endpush
