@extends('layouts.app')
@section('website-content')
<div style="max-width: 400px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center;">
    <!-- Password Animation -->
    <div style="width: 100px; height: 100px; margin: 0 auto 20px auto; position: relative;">
        <div style="width: 100px; height: 100px; background-color: #007bff; border-radius: 50%; animation: pulse-ring 2s infinite; position: absolute; top: 0; left: 0; opacity: 0.5;"></div>
        <div style="width: 100px; height: 100px; background-image: url('https://cdn-icons-png.flaticon.com/512/3583/3583124.png'); background-size: contain; background-repeat: no-repeat; animation: password-rotate 1.5s infinite; position: relative;"></div>
        <style>
            @keyframes password-rotate {
                0%, 100% {
                    transform: scale(1) rotate(0deg);
                }
                50% {
                    transform: scale(1.1) rotate(10deg);
                }
            }
            @keyframes pulse-ring {
                0% {
                    transform: scale(1);
                    opacity: 0.5;
                }
                50% {
                    transform: scale(1.5);
                    opacity: 0.3;
                }
                100% {
                    transform: scale(2);
                    opacity: 0;
                }
            }
        </style>
    </div>
    <!-- Success Message -->
    @if(session('success'))
        <div style="color: green; text-align: center; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @error('email')
        <div style="color: red; text-align: center; margin-bottom: 15px;">
            {{ $message }}
        </div>
    @enderror
    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <h2 style="color: #333;">Reset Password</h2>
    <form action="{{route('password.reset')}}" method="POST" style="margin-top: 20px;">
        @csrf
        @method('PUT')
        <label for="email" style="display: block; font-weight: bold; margin-bottom: 8px; color: #555;">Email</label>
        <input type="email" id="email" name="email" required placeholder="Enter your email" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">

        <label for="new_password" style="display: block; font-weight: bold; margin-bottom: 8px; color: #555;">New Password</label>
        <input type="password" id="new_password" name="password" required placeholder="Enter new password" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">

        <label for="confirm_password" style="display: block; font-weight: bold; margin-bottom: 8px; color: #555;">Confirm New Password</label>
        <input type="password" id="confirm_password" name="password_confirmation" required placeholder="Confirm new password" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">

        <div id="password-message" style="color: red; font-size: 12px; text-align: left; margin-bottom: 15px; display: none;">Passwords do not match.</div>

        <button type="submit" style="width: 100%; padding: 10px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; transition: background 0.3s ease;">Reset Password</button>
    </form>
    <p style="text-align: center; font-size: 14px; color: #666; margin-top: 10px;">Enter your email and new password to reset your password.</p>
</div>
@endsection
@push('website-script')
<script>
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');
    const passwordMessage = document.getElementById('password-message');

    function validatePasswordStrength(password) {
        const strongPasswordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        return strongPasswordPattern.test(password);
    }

    function handlePasswordValidation() {
        const passwordValue = newPassword.value;
        const confirmValue = confirmPassword.value;

        if (!validatePasswordStrength(passwordValue)) {
            passwordMessage.textContent = "Password must be at least 8 characters long, include uppercase, lowercase, numbers, and special characters.";
            passwordMessage.style.display = "block";
            return;
        }

        if (passwordValue !== confirmValue) {
            passwordMessage.textContent = "Passwords do not match.";
            passwordMessage.style.display = "block";
            return;
        }

        passwordMessage.style.display = "none";
    }

    newPassword.addEventListener('input', handlePasswordValidation);
    confirmPassword.addEventListener('input', handlePasswordValidation);
</script>
@endpush
