@extends('layouts.admin')
@section('title', 'Contact Control')
@section('page-title', 'Contact Settings')

@section('content')

    {{-- Page Header --}}
    <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-8 mb-10">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-lg text-white uppercase tracking-tight">Contact Section Control Panel</h2>
                <p class="text-white/40 text-xs font-bold uppercase tracking-widest mt-2">
                    Manage office location info, contact numbers, general inquiry email boxes, and hours of operation.
                </p>
            </div>
            <div class="flex items-center gap-3 text-white/30 text-xs font-black uppercase tracking-widest">
                <i class="fas fa-telephone text-blue"></i>
                <span>Dynamic Config</span>
            </div>
        </div>
    </div>

    {{-- Settings Form --}}
    <form action="{{ route('admin.contact-settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
            
            {{-- Left column: Image and Badge --}}
            <div class="xl:col-span-4 space-y-8">
                
                {{-- Office Image & Title Card --}}
                <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-8 space-y-6">
                    <h3 class="font-black text-xs text-white uppercase tracking-widest border-b border-white/5 pb-4">
                        Office Preview
                    </h3>

                    {{-- Title --}}
                    <div class="flex flex-col gap-2">
                        <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest ml-1">Office Name</label>
                        <input type="text" name="office_title" value="{{ old('office_title', $settings->office_title) }}"
                            class="bg-navy border border-white/10 rounded-xl px-4 py-3 text-sm font-bold text-white placeholder-white/20 outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner w-full"
                            required>
                    </div>

                    {{-- Image upload & preview --}}
                    <div class="flex flex-col gap-2">
                        <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest ml-1">Cover Image</label>
                        
                        <div class="relative rounded-2xl overflow-hidden border border-white/10 aspect-video bg-navy flex items-center justify-center mb-2 group">
                            <img id="image-preview" src="{{ $settings->image_url }}" class="w-full h-full object-cover opacity-60 mix-blend-luminosity group-hover:opacity-85 transition-opacity" alt="Preview">
                            <div class="absolute inset-0 bg-gradient-to-t from-navy2 to-transparent opacity-80"></div>
                        </div>

                        <input type="file" name="office_image" id="office_image" accept="image/*" class="hidden" onchange="previewFile()">
                        <button type="button" onclick="document.getElementById('office_image').click()" 
                            class="w-full py-3 text-xs font-black uppercase tracking-widest bg-white/5 text-white/70 border border-white/10 rounded-xl hover:bg-white/10 hover:text-white transition-all text-center">
                            <i class="fas fa-upload mr-2"></i> Upload New Cover
                        </button>
                        <p class="text-[0.6rem] text-white/30 font-bold uppercase tracking-widest mt-1 text-center">PNG, JPG, WEBP (Max 5MB)</p>
                    </div>
                </div>

                {{-- Footer Badge --}}
                <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-8 space-y-6">
                    <h3 class="font-black text-xs text-white uppercase tracking-widest border-b border-white/5 pb-4">
                        Footer Highlight
                    </h3>
                    <div class="flex flex-col gap-2">
                        <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest ml-1">Sub-Text Badge</label>
                        <textarea name="footer_badge" rows="3"
                            class="bg-navy border border-white/10 rounded-xl px-4 py-3 text-sm font-bold text-white placeholder-white/20 outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner w-full resize-none"
                            required>{{ old('footer_badge', $settings->footer_badge) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Right column: Address, Phone, Email & Support --}}
            <div class="xl:col-span-8 space-y-8">
                
                {{-- Address & Hours Card --}}
                <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-8 space-y-6">
                    <h3 class="font-black text-xs text-white uppercase tracking-widest border-b border-white/5 pb-4">
                        Location & Operation Details
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Address Title --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest ml-1">Address Label</label>
                            <input type="text" name="address_title" value="{{ old('address_title', $settings->address_title) }}"
                                class="bg-navy border border-white/10 rounded-xl px-4 py-3 text-sm font-bold text-white placeholder-white/20 outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner w-full"
                                required>
                        </div>

                        {{-- Phone Title --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest ml-1">Phone Label</label>
                            <input type="text" name="phone_title" value="{{ old('phone_title', $settings->phone_title) }}"
                                class="bg-navy border border-white/10 rounded-xl px-4 py-3 text-sm font-bold text-white placeholder-white/20 outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner w-full"
                                required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Address Content --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest ml-1">Headquarters Address</label>
                            <textarea name="address_content" rows="4"
                                class="bg-navy border border-white/10 rounded-xl px-4 py-3 text-sm font-bold text-white placeholder-white/20 outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner w-full resize-none"
                                required>{{ old('address_content', $settings->address_content) }}</textarea>
                        </div>

                        {{-- Phone Details --}}
                        <div class="flex flex-col gap-2 justify-between">
                            <div class="flex flex-col gap-2">
                                <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest ml-1">Phone Number</label>
                                <input type="text" name="phone_number" value="{{ old('phone_number', $settings->phone_number) }}"
                                    class="bg-navy border border-white/10 rounded-xl px-4 py-3 text-sm font-bold text-white placeholder-white/20 outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner w-full"
                                    required>
                            </div>
                            <div class="flex flex-col gap-2 mt-3">
                                <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest ml-1">Hours of Operation</label>
                                <input type="text" name="phone_hours" value="{{ old('phone_hours', $settings->phone_hours) }}"
                                    class="bg-navy border border-white/10 rounded-xl px-4 py-3 text-sm font-bold text-white placeholder-white/20 outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner w-full"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- General Support & Emails --}}
                <div class="bg-navy2 rounded-3xl border border-white/5 shadow-2xl p-8 space-y-6">
                    <h3 class="font-black text-xs text-white uppercase tracking-widest border-b border-white/5 pb-4">
                        Inquiries & Support Channels
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Email Title --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest ml-1">Email Section Label</label>
                            <input type="text" name="email_title" value="{{ old('email_title', $settings->email_title) }}"
                                class="bg-navy border border-white/10 rounded-xl px-4 py-3 text-sm font-bold text-white placeholder-white/20 outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner w-full"
                                required>
                        </div>

                        {{-- Email 1 --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest ml-1">Support Email Box</label>
                            <input type="email" name="email_support" value="{{ old('email_support', $settings->email_support) }}"
                                class="bg-navy border border-white/10 rounded-xl px-4 py-3 text-sm font-bold text-white placeholder-white/20 outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner w-full">
                        </div>

                        {{-- Email 2 --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest ml-1">Info/General Email Box</label>
                            <input type="email" name="email_info" value="{{ old('email_info', $settings->email_info) }}"
                                class="bg-navy border border-white/10 rounded-xl px-4 py-3 text-sm font-bold text-white placeholder-white/20 outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner w-full">
                        </div>
                    </div>

                    {{-- Support text --}}
                    <div class="flex flex-col gap-2">
                        <label class="text-[0.6rem] font-black text-white/40 uppercase tracking-widest ml-1">Support Channel Description</label>
                        <textarea name="support_text" rows="3"
                            class="bg-navy border border-white/10 rounded-xl px-4 py-3 text-sm font-bold text-white placeholder-white/20 outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner w-full resize-none"
                            required>{{ old('support_text', $settings->support_text) }}</textarea>
                    </div>
                </div>

                {{-- Action Button --}}
                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="flex items-center gap-2 px-8 py-4 text-xs font-black uppercase tracking-widest bg-blue text-navy rounded-xl hover:bg-white transition-all shadow-[0_5px_20px_rgba(180,180,254,0.3)]">
                        <i class="fas fa-check text-sm"></i> <span>Save Contact Config</span>
                    </button>
                </div>

            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <script>
        function previewFile() {
            const preview = document.getElementById('image-preview');
            const file = document.getElementById('office_image').files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush
