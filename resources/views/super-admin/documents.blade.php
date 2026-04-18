@extends('layouts.super-admin')
@section('title', 'My Documents')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-slate-800">My Documents</h2>
    </div>

    <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 shadow-sm">
        <div class="w-20 h-20 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl">
            <i class="bi bi-shield-check"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Super Admin Account</h3>
        <p class="text-slate-500 max-w-sm mx-auto">
            As a Super Admin, your account does not require additional verification documents. You have full access to the system.
        </p>
        <div class="mt-8">
            <a href="{{ route('admin.documents') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-navy text-white rounded-xl font-bold text-sm hover:scale-105 transition-all shadow-lg shadow-navy/20">
                <i class="bi bi-eye"></i> Review User Documents
            </a>
        </div>
    </div>
</div>
@endsection
