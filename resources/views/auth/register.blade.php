@extends('layouts.main')

@section('title', 'Register - CourtPulse')

@section('content')
    <div class="min-h-screen bg-navy flex flex-col justify-center py-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Premium Background Effects -->
        <div class="absolute top-1/4 left-0 w-96 h-96 bg-blue/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue/5 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="sm:mx-auto sm:w-full sm:max-w-4xl relative z-10 text-center mb-8">
            <h2 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tighter leading-none mb-3">
                Create Your Account
            </h2>
            <p class="text-xs md:text-sm font-bold text-white/60 uppercase tracking-widest">
                Join India's Premier Legal Professional Network
            </p>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-4xl relative z-10">
            <div
                class="bg-navy2 py-10 px-6 sm:px-12 shadow-2xl sm:rounded-3xl border border-white/10 relative overflow-hidden">

                <!-- REGISTRATION FORM -->
                <form id="registration-form"
                    class="space-y-8 transition-all duration-500 @if(isset($showOtp) && $showOtp) hidden @endif">
                    @csrf

                    <!-- Role Selection (Compact Horizontal Cards) -->
                    <div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <!-- Professional -->
                            <label
                                class="role-card group relative flex items-center p-4 cursor-pointer rounded-2xl border border-white/10 transition-all duration-300 hover:border-blue/50 bg-white/5 has-checked:border-blue has-checked:bg-blue/10 has-checked:shadow-[0_0_20px_rgba(59,130,246,0.15)]">
                                <input type="radio" name="user_group" value="professional" class="sr-only peer"
                                    onchange="updateDynamicFields()" checked>
                                <div
                                    class="w-12 h-12 shrink-0 mr-4 rounded-xl bg-navy flex items-center justify-center text-white border border-white/10 peer-checked:bg-blue peer-checked:text-navy transition-colors shadow-lg">
                                    <i class="fas fa-balance-scale text-lg"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm font-black text-white uppercase tracking-tight mb-1">Professional</span>
                                    <span class="text-[10px] text-white/50 uppercase tracking-wider leading-tight">Advocate,
                                        CA/CS,<br>IP Agent</span>
                                </div>
                            </label>

                            <!-- Support -->
                            <label
                                class="role-card group relative flex items-center p-4 cursor-pointer rounded-2xl border border-white/10 transition-all duration-300 hover:border-blue/50 bg-white/5 has-checked:border-blue has-checked:bg-blue/10 has-checked:shadow-[0_0_20px_rgba(59,130,246,0.15)]">
                                <input type="radio" name="user_group" value="support" class="sr-only peer"
                                    onchange="updateDynamicFields()">
                                <div
                                    class="w-12 h-12 shrink-0 mr-4 rounded-xl bg-navy flex items-center justify-center text-white border border-white/10 peer-checked:bg-blue peer-checked:text-navy transition-colors shadow-lg">
                                    <i class="fas fa-user-clock text-lg"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-white uppercase tracking-tight mb-1">Support</span>
                                    <span class="text-[10px] text-white/50 uppercase tracking-wider leading-tight">Court &
                                        IP<br>Clerks</span>
                                </div>
                            </label>

                            <!-- Guest -->
                            <label
                                class="role-card group relative flex items-center p-4 cursor-pointer rounded-2xl border border-white/10 transition-all duration-300 hover:border-blue/50 bg-white/5 has-checked:border-blue has-checked:bg-blue/10 has-checked:shadow-[0_0_20px_rgba(59,130,246,0.15)]">
                                <input type="radio" name="user_group" value="guest" class="sr-only peer"
                                    onchange="updateDynamicFields()">
                                <div
                                    class="w-12 h-12 shrink-0 mr-4 rounded-xl bg-navy flex items-center justify-center text-white border border-white/10 peer-checked:bg-blue peer-checked:text-navy transition-colors shadow-lg">
                                    <i class="fas fa-globe text-lg"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-white uppercase tracking-tight mb-1">Guest</span>
                                    <span
                                        class="text-[10px] text-white/50 uppercase tracking-wider leading-tight">General<br>Access</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <hr class="border-white/5">

                    <!-- Dynamic 3-Column Grid Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-5 gap-y-6">

                        <!-- Full Name -->
                        <div>
                            <label class="block text-[11px] font-black text-white/70 uppercase tracking-widest mb-2">Full
                                Name <span class="text-blue">*</span></label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                <input type="text" name="name" required
                                    class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner"
                                    placeholder="e.g. Rajesh Kumar">
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-[11px] font-black text-white/70 uppercase tracking-widest mb-2">Email
                                Address <span class="text-blue">*</span></label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                <input type="email" name="email" required
                                    class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner"
                                    placeholder="name@example.com">
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-[11px] font-black text-white/70 uppercase tracking-widest mb-2">Phone
                                Number <span class="text-blue">*</span></label>
                            <div class="relative">
                                <i class="fas fa-phone-alt absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                <input type="text" name="phone" required maxlength="10"
                                    class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner"
                                    placeholder="10 Digit Mobile Number">
                            </div>
                        </div>

                        <!-- Identity Selection -->
                        <div id="sub-role-wrapper">
                            <label
                                class="block text-[11px] font-black text-white/70 uppercase tracking-widest mb-2">Specific
                                Identity <span class="text-blue">*</span></label>
                            <div class="relative">
                                <i class="fas fa-id-badge absolute left-4 top-1/2 -translate-y-1/2 text-white/30 z-10"></i>
                                <select name="sub_role" id="sub_role" required
                                    class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue appearance-none transition-colors shadow-inner relative z-0">
                                    <!-- Populated via JS -->
                                </select>
                                <i
                                    class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-white/30 text-xs pointer-events-none z-10"></i>
                            </div>
                        </div>

                        <!-- Create Password -->
                        <div>
                            <label class="block text-[11px] font-black text-white/70 uppercase tracking-widest mb-2">Create
                                Password <span class="text-blue">*</span></label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                <input type="password" name="password" required
                                    class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner"
                                    placeholder="Min. 8 characters">
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-[11px] font-black text-white/70 uppercase tracking-widest mb-2">Confirm
                                Password <span class="text-blue">*</span></label>
                            <div class="relative">
                                <i class="fas fa-shield-check absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                <input type="password" name="password_confirmation" required
                                    class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner"
                                    placeholder="Repeat password">
                            </div>
                        </div>

                        <!-- Experience -->
                        <div id="experience-wrapper">
                            <label
                                class="block text-[11px] font-black text-white/70 uppercase tracking-widest mb-2">Experience
                                Years (Optional)</label>
                            <div class="relative">
                                <i class="fas fa-briefcase absolute left-4 top-1/2 -translate-y-1/2 text-white/30"></i>
                                <input type="number" name="experience_years" id="experience_years" min="0"
                                    class="w-full pl-11 pr-4 py-3.5 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors shadow-inner"
                                    placeholder="e.g. 5">
                            </div>
                        </div>

                        <!-- Courts Custom Select Dropdown with Search -->
                        <div id="court-wrapper" class="col-span-1 md:col-span-2 relative">
                            <label class="block text-[11px] font-black text-white/70 uppercase tracking-widest mb-2">Select
                                Primary Courts (Optional)</label>

                            <!-- Trigger -->
                            <div id="court-trigger" class="relative cursor-pointer">
                                <i class="fas fa-gavel absolute left-4 top-1/2 -translate-y-1/2 text-white/30 z-10"></i>
                                <div
                                    class="w-full pl-11 pr-10 py-3.5 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold transition-colors shadow-inner flex items-center justify-between">
                                    <span id="court-selected-text" class="text-white/40 truncate font-normal">Select
                                        Courts...</span>
                                </div>
                                <i
                                    class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-white/30 text-xs pointer-events-none z-10"></i>
                            </div>

                            <!-- Dropdown Panel -->
                            <div id="court-dropdown"
                                class="absolute z-20 w-full mt-2 bg-navy border border-white/10 rounded-xl shadow-2xl hidden flex-col overflow-hidden">
                                <div class="p-3 border-b border-white/10 bg-navy relative">
                                    <i
                                        class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-white/30 text-xs"></i>
                                    <input type="text" id="court-search"
                                        class="w-full bg-white/5 border border-white/10 rounded-lg pl-9 pr-3 py-2 text-xs text-white focus:outline-none focus:border-blue transition-colors"
                                        placeholder="Type to search courts...">
                                </div>
                                <div class="max-h-52 overflow-y-auto p-2" id="court-options-list">
                                    @foreach($courts ?? [] as $court)
                                        <label
                                            class="flex items-center px-3 py-2 hover:bg-white/5 cursor-pointer rounded-lg transition-colors">
                                            <input type="checkbox" value="{{ $court?->id }}" data-name="{{ $court?->name }}"
                                                class="court-checkbox w-4 h-4 rounded border-white/20 bg-navy2 text-blue focus:ring-blue focus:ring-offset-navy transition-colors">
                                            <span
                                                class="ml-3 text-[11px] font-bold text-white/80 court-option-label">{{ $court?->name }}
                                                ({{ $court?->city }})</span>
                                        </label>
                                    @endforeach
                                    <div id="no-courts-found"
                                        class="hidden p-3 text-center text-xs text-white/40 font-bold">No courts found.
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden Select For Standard Form Submission -->
                            <select name="court_ids[]" id="court_ids" multiple class="hidden">
                                @foreach($courts ?? [] as $court)
                                    <option value="{{ $court?->id }}">{{ $court?->name }} ({{ $court?->city }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Error Container -->
                    <div id="form-errors"
                        class="hidden bg-red-500/10 border border-red-500/30 text-red-400 p-4 rounded-xl text-xs font-bold leading-relaxed">
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-white/5">
                        <button type="submit" id="btn-register"
                            class="w-full md:w-1/2 lg:w-1/3 mx-auto flex justify-center items-center py-4 px-6 rounded-xl text-xs font-black text-navy uppercase tracking-widest bg-blue hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-navy focus:ring-blue transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-[0_10px_20px_rgba(180,180,254,0.2)]">
                            <span>Register & Send OTP</span>
                            <i class="fas fa-arrow-right ml-3"></i>
                        </button>
                    </div>

                    <div class="text-center pt-2">
                        <p class="text-[10px] sm:text-xs font-bold text-white/50 uppercase tracking-widest">
                            Already have an account?
                            <a href="{{ route('login') }}"
                                class="text-blue hover:text-white transition-colors underline decoration-blue/30 underline-offset-4 ml-1">Login
                                Here</a>
                        </p>
                    </div>
                </form>

                <!-- OTP INLINE SECTION (Hidden Initially) -->
                <div id="otp-section"
                    class="@if(!isset($showOtp) || !$showOtp) hidden @endif space-y-8 animate-in fade-in zoom-in duration-500 py-8">
                    <div class="text-center">
                        <div
                            class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue/10 text-blue border border-blue/20 mb-5 shadow-[0_0_30px_rgba(180,180,254,0.15)]">
                            <i class="fas fa-shield-alt text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-2">Verify Your Email</h3>
                        <p class="text-xs md:text-sm font-bold text-white/60">We've sent a 6-digit code to <br><span
                                id="display-email"
                                class="text-blue mt-1 inline-block">{{ Auth::check() ? Auth::user()->email : '' }}</span>
                        </p>
                    </div>

                    <form id="otp-form" class="space-y-8 max-w-sm mx-auto">
                        @csrf
                        <div class="flex justify-center gap-2 sm:gap-3">
                            @for($i = 0; $i < 6; $i++)
                                <input type="text" maxlength="1" inputmode="numeric"
                                    class="otp-input w-12 h-14 sm:w-14 sm:h-16 text-center text-xl font-black text-white bg-navy border border-white/20 rounded-xl focus:border-blue focus:ring-1 focus:ring-blue outline-none transition-all shadow-inner"
                                    required>
                            @endfor
                        </div>
                        <input type="hidden" name="otp" id="otp_full">

                        <div id="otp-errors"
                            class="hidden text-center bg-red-500/10 border border-red-500/30 text-red-400 p-3 rounded-lg text-xs font-bold">
                        </div>

                        <button type="submit" id="btn-verify"
                            class="w-full flex justify-center items-center py-4 px-6 rounded-xl text-xs font-black text-navy uppercase tracking-widest bg-blue hover:bg-white transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-[0_10px_20px_rgba(180,180,254,0.2)]">
                            <span>Verify & Login</span>
                            <i class="fas fa-check-circle ml-3"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        // --- Dynamic Fields Logic ---
        const subRoles = {
            professional: [
                { value: 'advocate', label: 'Advocate' },
                { value: 'ca_cs', label: 'CA / CS' },
                { value: 'agent', label: 'IP Agent' }
            ],
            support: [
                { value: 'court_clerk', label: 'Court Clerk' },
                { value: 'ip_clerk', label: 'IP Clerk' }
            ]
        };

        function updateDynamicFields() {
            const group = document.querySelector('input[name="user_group"]:checked').value;
            const subRoleSelect = document.getElementById('sub_role');

            // Setup Grid Wrappers
            const wrappers = {
                subRole: document.getElementById('sub-role-wrapper'),
                exp: document.getElementById('experience-wrapper'),
                court: document.getElementById('court-wrapper')
            };

            // Reset Options
            subRoleSelect.innerHTML = '';

            // Fields that change requirement
            const expInput = document.getElementById('experience_years');

            if (group === 'guest') {
                // Hide specific fields
                wrappers.subRole.classList.add('hidden');
                wrappers.exp.classList.add('hidden');
                wrappers.court.classList.add('hidden');

                // Remove required checks
                subRoleSelect.removeAttribute('required');
                expInput.removeAttribute('required');
            } else {
                // Show base fields
                wrappers.subRole.classList.remove('hidden');
                wrappers.exp.classList.remove('hidden');
                wrappers.court.classList.remove('hidden');

                // Populate Dropdown
                subRoles[group].forEach(role => {
                    const opt = document.createElement('option');
                    opt.value = role.value;
                    opt.textContent = role.label;
                    subRoleSelect.appendChild(opt);
                });

                // Specific Identity is REQUIRED for Pro/Support
                subRoleSelect.setAttribute('required', 'required');

                // Exp is optional
                expInput.removeAttribute('required');
            }
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', updateDynamicFields);

        // --- Custom Court Select Dropdown Logic ---
        const courtTrigger = document.getElementById('court-trigger');
        const courtDropdown = document.getElementById('court-dropdown');
        const courtSearch = document.getElementById('court-search');
        const courtCheckboxes = document.querySelectorAll('.court-checkbox');
        const courtSelectedText = document.getElementById('court-selected-text');
        const courtNativeSelect = document.getElementById('court_ids');
        const noCourtsFound = document.getElementById('no-courts-found');

        courtTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            courtDropdown.classList.toggle('hidden');
            courtDropdown.classList.toggle('flex');
            if (!courtDropdown.classList.contains('hidden')) {
                courtSearch.focus();
            }
        });

        document.addEventListener('click', (e) => {
            if (!courtTrigger.contains(e.target) && !courtDropdown.contains(e.target)) {
                courtDropdown.classList.add('hidden');
                courtDropdown.classList.remove('flex');
            }
        });

        courtSearch.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            let visibleCount = 0;

            document.querySelectorAll('.court-option-label').forEach(label => {
                const text = label.textContent.toLowerCase();
                const parent = label.closest('label');
                if (text.includes(term)) {
                    parent.style.display = 'flex';
                    visibleCount++;
                } else {
                    parent.style.display = 'none';
                }
            });

            if (visibleCount === 0) {
                noCourtsFound.classList.remove('hidden');
            } else {
                noCourtsFound.classList.add('hidden');
            }
        });

        courtCheckboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                // Update native select
                const option = Array.from(courtNativeSelect.options).find(opt => opt.value === cb.value);
                if (option) option.selected = cb.checked;

                // Update text display
                const selected = Array.from(courtCheckboxes).filter(c => c.checked).map(c => c.dataset.name);
                courtSelectedText.classList.remove('text-white/40', 'font-normal');
                courtSelectedText.classList.add('text-white', 'font-bold');

                if (selected.length === 0) {
                    courtSelectedText.textContent = 'Select Courts...';
                    courtSelectedText.classList.remove('text-white', 'font-bold');
                    courtSelectedText.classList.add('text-white/40', 'font-normal');
                } else if (selected.length <= 2) {
                    courtSelectedText.textContent = selected.join(', ');
                } else {
                    courtSelectedText.textContent = `${selected.length} courts selected`;
                }
            });
        });

        // --- AJAX Registration Logic ---
        document.getElementById('registration-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const btn = document.getElementById('btn-register');
            const errDiv = document.getElementById('form-errors');

            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            btn.disabled = true;
            errDiv.classList.add('hidden');
            errDiv.innerHTML = '';

            try {
                const formData = new FormData(form);
                const response = await fetch("{{ route('register.post') }}", {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    document.getElementById('display-email').textContent = formData.get('email');
                    form.classList.add('hidden');
                    document.getElementById('otp-section').classList.remove('hidden');
                } else {
                    btn.innerHTML = '<span>Register & Send OTP</span><i class="fas fa-arrow-right ml-3"></i>';
                    btn.disabled = false;
                    errDiv.classList.remove('hidden');

                    if (data.errors) {
                        let errHtml = '<ul class="list-disc list-inside space-y-1">';
                        for (const [key, msgs] of Object.entries(data.errors)) {
                            errHtml += `<li>${msgs[0]}</li>`;
                        }
                        errHtml += '</ul>';
                        errDiv.innerHTML = errHtml;
                    } else {
                        errDiv.innerHTML = data.message || 'Registration failed. Please try again.';
                    }
                }
            } catch (error) {
                btn.innerHTML = '<span>Register & Send OTP</span><i class="fas fa-arrow-right ml-3"></i>';
                btn.disabled = false;
                errDiv.classList.remove('hidden');
                errDiv.innerHTML = 'A network error occurred. Please try again.';
            }
        });

        // --- OTP Input Logic ---
        const otpInputs = document.querySelectorAll('.otp-input');
        const hiddenOtp = document.getElementById('otp_full');

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
                updateFullOtp();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });

            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text').slice(0, 6);
                pasteData.split('').forEach((char, i) => {
                    if (otpInputs[index + i]) otpInputs[index + i].value = char;
                });
                updateFullOtp();
                if (otpInputs[index + pasteData.length]) {
                    otpInputs[index + pasteData.length].focus();
                } else {
                    otpInputs[otpInputs.length - 1].focus();
                }
            });
        });

        function updateFullOtp() {
            hiddenOtp.value = Array.from(otpInputs).map(i => i.value).join('');
        }

        // --- AJAX OTP Verification Logic ---
        document.getElementById('otp-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('btn-verify');
            const errDiv = document.getElementById('otp-errors');

            if (hiddenOtp.value.length < 6) {
                errDiv.classList.remove('hidden');
                errDiv.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i> Please enter all 6 digits.';
                return;
            }

            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...';
            btn.disabled = true;
            errDiv.classList.add('hidden');

            try {
                const formData = new FormData(e.target);
                const response = await fetch("{{ route('register.otp.verify.post') }}", {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    window.location.href = data.redirect;
                } else {
                    btn.innerHTML = '<span>Verify & Login</span><i class="fas fa-check-circle ml-3"></i>';
                    btn.disabled = false;
                    errDiv.classList.remove('hidden');
                    errDiv.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i> ' + (data.message || 'Invalid or Expired OTP.');
                }
            } catch (error) {
                btn.innerHTML = '<span>Verify & Login</span><i class="fas fa-check-circle ml-3"></i>';
                btn.disabled = false;
                errDiv.classList.remove('hidden');
                errDiv.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i> Verification failed. Try again.';
            }
        });
    </script>
@endsection