@extends('layouts.app')
@section('website-content')
    <div
        style="max-width: 400px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center; font-family: Arial, sans-serif; background-color: #f4f4f9;">
        <!-- Animated Email Icon -->
        <div
            style="width: 100px; height: 100px; margin: 0 auto 20px auto; background-image: url('https://cdn-icons-png.flaticon.com/512/725/725643.png'); background-size: contain; background-repeat: no-repeat; animation: bounce 1.5s infinite;">
            <style>
                @keyframes bounce {

                    0%,
                    100% {
                        transform: translateY(0);
                    }

                    50% {
                        transform: translateY(-10px);
                    }
                }
            </style>
        </div>
        <!-- Success Message -->
        @if (session('success'))
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
        <h2 style="color: #333;">Forgot Password</h2>
        <form action="{{route('password.email')}}" method="POST" style="margin-top: 20px;">
            @csrf
            <label for="email" style="display: block; font-weight: bold; margin-bottom: 8px; color: #555;">Email
                Address</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email"
                style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">
            <button type="submit"
                style="width: 100%; padding: 10px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; transition: background 0.3s ease;">Send
                OTP</button>
        </form>
        <p class="message" style="text-align: center; font-size: 14px; color: #666; margin-top: 10px;">Enter your registered
            email to receive an OTP.</p>
    </div>
@endsection
