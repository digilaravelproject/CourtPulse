@extends('layouts.main')

@section('title', 'Step 4: Verify Your Account - CourtPulse')

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600 mb-6">
                <i class="fas fa-shield-alt text-2xl"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-900 uppercase tracking-tight">
                Verify Account
            </h2>
            <p class="mt-2 text-sm text-slate-600">
                We've sent a 6-digit verification code to<br>
                <span class="font-bold text-slate-900">{{ $user->email }}</span>
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl sm:rounded-2xl sm:px-10 border border-slate-100">
            <form action="{{ route('register.otp.verify') }}" method="POST" id="otp-form" class="space-y-6">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 rounded-r-lg">
                        <div class="flex">
                            <div class="shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <ul class="list-disc list-inside text-xs text-red-600">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex justify-between gap-2 sm:gap-4">
                    @for($i=0; $i<6; $i++)
                        <input type="text" 
                            name="otp_digits[]" 
                            maxlength="1" 
                            inputmode="numeric"
                            class="otp-input w-full h-14 sm:h-16 text-center text-2xl font-black text-indigo-600 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" 
                            required>
                    @endfor
                </div>
                
                <input type="hidden" name="otp" id="otp_full">

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        Verify & Activate Account <i class="fas fa-arrow-right ml-2 mt-0.5"></i>
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-xs text-slate-500 uppercase font-bold tracking-widest">
                    Didn't receive the code?
                </p>
                <button type="button" class="mt-2 text-sm font-bold text-indigo-600 hover:text-indigo-500 underline decoration-indigo-200 underline-offset-4 transition-all">
                    Resend Verification Code
                </button>
            </div>
        </div>

        <div class="mt-8 text-center">
            <div class="inline-flex items-center space-x-2">
                <span class="w-2 h-2 rounded-full bg-slate-200"></span>
                <span class="w-2 h-2 rounded-full bg-slate-200"></span>
                <span class="w-2 h-2 rounded-full bg-slate-200"></span>
                <span class="w-8 h-2 rounded-full bg-indigo-600"></span>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('.otp-input');
        const hidden = document.getElementById('otp_full');
        const form = document.getElementById('otp-form');

        inputs.forEach((input, index) => {
            // Handle typing
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                updateFullOtp();
            });

            // Handle backspace
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            // Handle paste
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text').slice(0, 6);
                pasteData.split('').forEach((char, i) => {
                    if (inputs[index + i]) {
                        inputs[index + i].value = char;
                    }
                });
                updateFullOtp();
                if (inputs[index + pasteData.length]) {
                    inputs[index + pasteData.length].focus();
                } else {
                    inputs[inputs.length - 1].focus();
                }
            });
        });

        function updateFullOtp() {
            hidden.value = Array.from(inputs).map(i => i.value).join('');
        }
    });
</script>
@endsection
