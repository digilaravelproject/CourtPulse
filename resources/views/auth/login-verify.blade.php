@extends('layouts.main')

@section('title', 'Verify Login - CourtPulse')

@section('content')
    <div class="min-h-screen bg-navy flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Premium Background Effects -->
        <div class="absolute top-1/4 left-0 w-96 h-96 bg-blue/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue/5 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 text-center mb-8">
            <div
                class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue/10 text-blue border border-blue/20 mb-6">
                <i class="fas fa-shield-alt text-2xl"></i>
            </div>
            <h2 class="text-3xl font-black text-white uppercase tracking-tighter leading-none mb-2">
                Security Verification
            </h2>
            <p class="text-xs md:text-sm font-bold text-white/60">
                Enter the 6-digit code sent to <br>
                <span class="text-blue mt-1 inline-block">{{ $email }}</span>
            </p>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
            <div
                class="bg-navy2 py-8 px-6 sm:px-10 shadow-2xl sm:rounded-3xl border border-white/10 relative overflow-hidden">

                @if($errors->any())
                    <div
                        class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold text-center">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('login.verify.submit') }}" method="POST" class="space-y-8">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="flex justify-center gap-2 sm:gap-3">
                        @for($i = 0; $i < 6; $i++)
                            <input type="text" maxlength="1" inputmode="numeric"
                                class="otp-input w-12 h-14 sm:w-14 sm:h-16 text-center text-xl font-black text-white bg-navy border border-white/20 rounded-xl focus:border-blue focus:ring-1 focus:ring-blue outline-none transition-all"
                                required>
                        @endfor
                    </div>
                    <input type="hidden" name="otp" id="otp_full">

                    <button type="submit"
                        class="w-full flex justify-center items-center py-4 px-6 rounded-xl text-xs font-black text-navy uppercase tracking-widest bg-blue hover:bg-white transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        <span>Verify & Secure Login</span>
                        <i class="fas fa-check-circle ml-3"></i>
                    </button>
                </form>

                <div class="text-center pt-6 mt-6 border-t border-white/5">
                    <p class="text-[10px] sm:text-xs font-bold text-white/50 uppercase tracking-widest">
                        Didn't receive the code?
                        <a href="{{ route('login') }}"
                            class="text-blue hover:text-white transition-colors underline decoration-blue/30 underline-offset-4 ml-1">Go
                            Back & Resend</a>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <script>
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
    </script>
@endsection