@extends('layouts.main')

@section('title', 'Register - CourtPulse')

@section('content')
    <div class="min-h-screen bg-navy flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Premium Background Effects -->
        <div class="absolute top-1/4 left-0 w-96 h-96 bg-blue/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue/5 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="sm:mx-auto sm:w-full sm:max-w-5xl relative z-10 text-center mb-6">
            <h2 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tighter leading-none mb-2">
                Create Your Account
            </h2>
            <p class="text-xs md:text-sm font-bold text-white/60 uppercase tracking-widest">
                Join India's Premier Legal Professional Network
            </p>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-5xl relative z-10">
            <div
                class="bg-navy2 py-8 px-6 sm:px-10 shadow-2xl sm:rounded-3xl border border-white/10 relative overflow-hidden">

                <!-- REGISTRATION FORM -->
                <form id="registration-form" class="space-y-6 transition-all duration-500 @if(isset($showOtp) && $showOtp) hidden @endif">
                    @csrf

                    <!-- Role Selection (Compact Horizontal Cards) -->
                    <div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <!-- Professional -->
                            <label
                                class="role-card group relative flex items-center p-3 cursor-pointer rounded-xl border border-white/10 transition-all duration-300 hover:border-blue/50 bg-white/5 has-checked:border-blue has-checked:bg-blue/10 has-checked:shadow-[0_0_15px_rgba(59,130,246,0.15)]">
                                <input type="radio" name="user_group" value="professional" class="sr-only peer"
                                    onchange="updateDynamicFields()" checked>
                                <div
                                    class="w-10 h-10 shrink-0 mr-3 rounded-lg bg-navy flex items-center justify-center text-white border border-white/10 peer-checked:bg-blue peer-checked:text-navy transition-colors shadow-lg">
                                    <i class="fas fa-balance-scale text-base"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="text-xs font-black text-white uppercase tracking-tight mb-0.5">Professional</span>
                                    <span class="text-[9px] text-white/50 uppercase tracking-wider">Advocate, CA/CS,
                                        IP</span>
                                </div>
                            </label>

                            <!-- Support -->
                            <label
                                class="role-card group relative flex items-center p-3 cursor-pointer rounded-xl border border-white/10 transition-all duration-300 hover:border-blue/50 bg-white/5 has-checked:border-blue has-checked:bg-blue/10 has-checked:shadow-[0_0_15px_rgba(59,130,246,0.15)]">
                                <input type="radio" name="user_group" value="support" class="sr-only peer"
                                    onchange="updateDynamicFields()">
                                <div
                                    class="w-10 h-10 shrink-0 mr-3 rounded-lg bg-navy flex items-center justify-center text-white border border-white/10 peer-checked:bg-blue peer-checked:text-navy transition-colors shadow-lg">
                                    <i class="fas fa-user-clock text-base"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-white uppercase tracking-tight mb-0.5">Support
                                        Staff</span>
                                    <span class="text-[9px] text-white/50 uppercase tracking-wider">Court & IP Clerks</span>
                                </div>
                            </label>

                            <!-- Guest -->
                            <label
                                class="role-card group relative flex items-center p-3 cursor-pointer rounded-xl border border-white/10 transition-all duration-300 hover:border-blue/50 bg-white/5 has-checked:border-blue has-checked:bg-blue/10 has-checked:shadow-[0_0_15px_rgba(59,130,246,0.15)]">
                                <input type="radio" name="user_group" value="guest" class="sr-only peer"
                                    onchange="updateDynamicFields()">
                                <div
                                    class="w-10 h-10 shrink-0 mr-3 rounded-lg bg-navy flex items-center justify-center text-white border border-white/10 peer-checked:bg-blue peer-checked:text-navy transition-colors shadow-lg">
                                    <i class="fas fa-globe text-base"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-white uppercase tracking-tight mb-0.5">Guest</span>
                                    <span class="text-[9px] text-white/50 uppercase tracking-wider">General Access</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <hr class="border-white/5">

                    <!-- Dynamic Seamless Grid Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-5 gap-y-4">

                        <!-- Specific Identity -->
                        <div id="sub-role-wrapper">
                            <label
                                class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-1.5">Specific
                                Identity <span class="text-blue">*</span></label>
                            <select name="sub_role" id="sub_role"
                                class="w-full px-3 py-3 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue appearance-none transition-colors">
                                <!-- Populated via JS -->
                            </select>
                        </div>

                        <!-- Full Name -->
                        <div>
                            <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-1.5">Full
                                Name <span class="text-blue">*</span></label>
                            <input type="text" name="name" required
                                class="w-full px-3 py-3 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors"
                                placeholder="e.g. Rajesh Kumar">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-1.5">Email
                                Address <span class="text-blue">*</span></label>
                            <input type="email" name="email" required
                                class="w-full px-3 py-3 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors"
                                placeholder="name@example.com">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-1.5">Phone
                                Number <span class="text-blue">*</span></label>
                            <input type="text" name="phone" required maxlength="10"
                                class="w-full px-3 py-3 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors"
                                placeholder="10 Digit Mobile Number">
                        </div>

                        <!-- Experience -->
                        <div id="experience-wrapper">
                            <label
                                class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-1.5">Experience
                                (Years) <span class="text-blue">*</span></label>
                            <input type="number" name="experience_years" id="experience_years" min="0"
                                class="w-full px-3 py-3 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors"
                                placeholder="e.g. 5">
                        </div>

                        <!-- Primary Court -->
                        <div id="court-wrapper">
                            <label
                                class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-1.5">Primary
                                Court <span class="text-blue">*</span></label>
                            <select name="court_id" id="court_id"
                                class="w-full px-3 py-3 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue appearance-none transition-colors">
                                <option value="">Select Primary Court</option>
                                @forelse($courts ?? [] as $court)
                                    <option value="{{ $court->id }}">{{ $court->name }} ({{ $court->city }})</option>
                                @empty
                                    <option value="">No courts available</option>
                                @endforelse
                            </select>
                        </div>

                        <!-- License/Bar Number -->
                        <div id="license-wrapper">
                            <label
                                class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-1.5">License/Bar
                                Number</label>
                            <input type="text" name="license_number" id="license_number"
                                class="w-full px-3 py-3 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors"
                                placeholder="e.g. MAH/1234/2020">
                        </div>

                        <!-- Create Password -->
                        <div>
                            <label
                                class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-1.5">Create
                                Password <span class="text-blue">*</span></label>
                            <input type="password" name="password" required
                                class="w-full px-3 py-3 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors"
                                placeholder="••••••••">
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label
                                class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-1.5">Confirm
                                Password <span class="text-blue">*</span></label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-3 py-3 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors"
                                placeholder="••••••••">
                        </div>

                        <!-- Core Practice Areas -->
                        <div id="capabilities-wrapper" class="col-span-1 md:col-span-2 lg:col-span-3">
                            <label class="block text-[10px] font-black text-white/70 uppercase tracking-widest mb-1.5">Core
                                Practice Areas</label>
                            <input type="text" name="capabilities" id="capabilities"
                                class="w-full px-3 py-3 bg-navy border border-white/10 rounded-lg text-white text-sm font-bold placeholder-white/30 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors"
                                placeholder="e.g. Criminal Law, Corporate, IPR">
                        </div>

                    </div>

                    <!-- Error Container -->
                    <div id="form-errors"
                        class="hidden bg-red-500/10 border border-red-500/50 text-red-400 p-3 rounded-lg text-xs font-bold">
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" id="btn-register"
                            class="w-full lg:w-1/3 mx-auto flex justify-center items-center py-3 px-6 rounded-xl text-xs font-black text-navy uppercase tracking-widest bg-blue hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-navy focus:ring-blue transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                            <span>Register & Send OTP</span>
                            <i class="fas fa-arrow-right ml-3"></i>
                        </button>
                    </div>

                    <div class="text-center pt-4 border-t border-white/5">
                        <p class="text-[10px] sm:text-xs font-bold text-white/50 uppercase tracking-widest">
                            Already have an account?
                            <a href="{{ route('login') }}"
                                class="text-blue hover:text-white transition-colors underline decoration-blue/30 underline-offset-4 ml-1">Login
                                Here</a>
                        </p>
                    </div>
                </form>

                <!-- OTP INLINE SECTION (Hidden Initially) -->
                <div id="otp-section" class="@if(!isset($showOtp) || !$showOtp) hidden @endif space-y-6 animate-in fade-in zoom-in duration-500 py-6">
                    <div class="text-center">
                        <div
                            class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-blue/10 text-blue border border-blue/20 mb-4">
                            <i class="fas fa-shield-alt text-xl"></i>
                        </div>
                        <h3 class="text-xl md:text-2xl font-black text-white uppercase tracking-tight mb-2">Verify Your
                            Email</h3>
                        <p class="text-xs md:text-sm font-bold text-white/60">We've sent a 6-digit code to <br><span
                                id="display-email" class="text-blue">{{ Auth::check() ? Auth::user()->email : '' }}</span></p>
                    </div>

                    <form id="otp-form" class="space-y-6 max-w-sm mx-auto">
                        @csrf
                        <div class="flex justify-center gap-2 sm:gap-3">
                            @for($i = 0; $i < 6; $i++)
                                <input type="text" maxlength="1" inputmode="numeric"
                                    class="otp-input w-12 h-14 sm:w-12 sm:h-14 text-center text-xl font-black text-white bg-navy border border-white/20 rounded-lg focus:border-blue focus:ring-1 focus:ring-blue outline-none transition-all"
                                    required>
                            @endfor
                        </div>
                        <input type="hidden" name="otp" id="otp_full">

                        <div id="otp-errors" class="hidden text-center text-red-400 text-xs font-bold"></div>

                        <button type="submit" id="btn-verify"
                            class="w-full flex justify-center items-center py-3 px-6 rounded-xl text-xs font-black text-navy uppercase tracking-widest bg-blue hover:bg-white transition-all transform hover:scale-[1.02] active:scale-[0.98]">
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
                { value: 'advocate_practicing', label: 'Practicing Advocate' },
                { value: 'advocate_non_practicing', label: 'Non-Practicing Advocate' },
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
                court: document.getElementById('court-wrapper'),
                license: document.getElementById('license-wrapper'),
                cap: document.getElementById('capabilities-wrapper')
            };

            // Reset Options
            subRoleSelect.innerHTML = '';

            if (group === 'guest') {
                // Hide specific fields
                wrappers.subRole.classList.add('hidden');
                wrappers.exp.classList.add('hidden');
                wrappers.court.classList.add('hidden');
                wrappers.license.classList.add('hidden');
                wrappers.cap.classList.add('hidden');

                // Remove required checks
                subRoleSelect.removeAttribute('required');
                document.getElementById('experience_years').removeAttribute('required');
                document.getElementById('court_id').removeAttribute('required');
            } else {
                // Show base fields
                wrappers.subRole.classList.remove('hidden');
                wrappers.exp.classList.remove('hidden');
                wrappers.court.classList.remove('hidden');

                // Add required checks
                subRoleSelect.setAttribute('required', 'required');
                document.getElementById('experience_years').setAttribute('required', 'required');
                document.getElementById('court_id').setAttribute('required', 'required');

                // Populate Dropdown
                subRoles[group].forEach(role => {
                    const opt = document.createElement('option');
                    opt.value = role.value;
                    opt.textContent = role.label;
                    subRoleSelect.appendChild(opt);
                });

                // Adjust specific Support vs Professional fields
                if (group === 'support') {
                    wrappers.license.classList.add('hidden');
                    wrappers.cap.classList.add('hidden');
                } else {
                    wrappers.license.classList.remove('hidden');
                    wrappers.cap.classList.remove('hidden');
                }
            }
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', updateDynamicFields);

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
                        let errHtml = '<ul class="list-disc list-inside">';
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
                errDiv.innerHTML = 'Please enter all 6 digits.';
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
                    errDiv.innerHTML = data.message || 'Invalid or Expired OTP.';
                }
            } catch (error) {
                btn.innerHTML = '<span>Verify & Login</span><i class="fas fa-check-circle ml-3"></i>';
                btn.disabled = false;
                errDiv.classList.remove('hidden');
                errDiv.innerHTML = 'Verification failed. Try again.';
            }
        });
    </script>
@endsection