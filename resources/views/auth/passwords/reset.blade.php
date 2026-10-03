@extends('layouts.app')
@section('website-content')
<div style="max-width: 400px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center;">
    <!-- OTP Animation -->
    <div style="width: 100px; height: 100px; margin: 0 auto 20px auto; background-image: url('https://cdn-icons-png.flaticon.com/512/3583/3583124.png'); background-size: contain; background-repeat: no-repeat; animation: rotate-pulse 1.5s infinite;">
        <style>
            @keyframes rotate-pulse {
                0%, 100% {
                    transform: scale(1) rotate(0deg);
                }
                50% {
                    transform: scale(1.1) rotate(10deg);
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
    <h2 style="color: #333;">Verify OTP</h2>
    <form action="{{route('password.verifyOtp')}}" method="POST" style="margin-top: 20px;">
        @csrf
        <label for="otp" style="display: block; font-weight: bold; margin-bottom: 8px; color: #555;">OTP</label>
        <input type="text" id="otp" name="otp" required placeholder="Enter the OTP" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">
        
        <label for="email" style="display: block; font-weight: bold; margin-bottom: 8px; color: #555;">Email</label>
        <input type="email" id="email" name="email" required placeholder="Enter your email" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">

        <button type="submit" style="width: 100%; padding: 10px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; transition: background 0.3s ease;">Verify OTP</button>
    </form>
    <p style="text-align: center; font-size: 14px; color: #666; margin-top: 10px;">Enter the OTP sent to your email or phone.</p>
</div>
@endsection

