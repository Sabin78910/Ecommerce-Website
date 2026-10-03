@extends('layouts.app')

@section('website-content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh; margin-top:130px;">
    <div class="card p-4 text-center shadow-lg" style="border-radius: 15px; max-width: 450px; width: 100%; background-color: white;">
        <!-- Animated Icon -->
        <div class="animation-container mb-4">
            <div class="icon-circle">
                <i class="fa fa-lock animated-lock"></i>
            </div>
        </div>
        <h2 class="animated fadeInDown mb-3" style="color: #007bff;">Verify Your OTP</h2>
        <p class="text-muted animated fadeInUp" style="font-size: 16px;">Enter the 6-digit code sent to your email or phone number.</p>
        <form id="otp-form" method="POST" action="{{ route('verify.otp.submit') }}" class="animated fadeInUp" style="animation-delay: 0.3s;">
            @csrf
            <div class="form-group d-flex justify-content-center mt-4">
                <!-- OTP Input Fields -->
                <div class="otp-input-container">
                    <input type="text" id="otp1" maxlength="1" class="form-control otp-input" required>
                    <input type="text" id="otp2" maxlength="1" class="form-control otp-input" required>
                    <input type="text" id="otp3" maxlength="1" class="form-control otp-input" required>
                    <input type="text" id="otp4" maxlength="1" class="form-control otp-input" required>
                    <input type="text" id="otp5" maxlength="1" class="form-control otp-input" required>
                    <input type="text" id="otp6" maxlength="1" class="form-control otp-input" required>
                </div>
            </div>
            <!-- Hidden Input to Collect OTP -->
            <input type="hidden" name="otp" id="otp" value="">

            @error('otp')
            <span class="text-danger d-block text-center">{{ $message }}</span>
            @enderror
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-block px-4 py-2">Verify</button>
            </div>
        </form>
        <div class="text-center mt-3">
            <p class="text-muted">Didn't receive the OTP?</p>
            <form method="POST" action="{{ route('resend.otp') }}">
                @csrf
                <button type="submit" class="btn btn-link text-primary">Resend OTP</button>
            </form>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .animation-container {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .icon-circle {
        width: 100px;
        height: 100px;
        background: #007bff;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
        animation: popIn 1s ease-in-out forwards;
    }

    .icon-circle i {
        color: white;
        font-size: 40px;
    }

    .otp-input-container {
        display: flex;
        gap: 15px;
    }

    .otp-input {
        width: 50px;
        height: 60px;
        text-align: center;
        font-size: 24px;
        border: 2px solid #ddd;
        border-radius: 8px;
        transition: all 0.3s ease;
        animation: slideIn 0.6s ease-in-out;
    }

    .otp-input:focus {
        border-color: #007bff;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        outline: none;
        transform: scale(1.05);
    }

    @keyframes popIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes slideIn {
        0% {
            transform: translateY(30px);
            opacity: 0;
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .animated-lock {
        animation: lockBounce 1.2s infinite alternate;
    }

    @keyframes lockBounce {
        0% {
            transform: translateY(-5px);
        }
        100% {
            transform: translateY(5px);
        }
    }
</style>
@endsection

@push('website-script')
<!-- JavaScript for OTP Input Behavior -->
<script>
    document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
        input.addEventListener('input', (e) => {
            if (e.target.value.length === e.target.maxLength && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
            collectOtp();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && !e.target.value && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });

    function collectOtp() {
        const otp = Array.from(document.querySelectorAll('.otp-input'))
            .map(input => input.value)
            .join('');
        document.getElementById('otp').value = otp;
    }
</script>
@endpush
