@extends('layouts.app')
@section('website-content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="login-register container">
        <div style="width: 100px; height: 100px; margin: 0 auto 20px auto; position: relative;">
            <div style="width: 100px; height: 100px; background-color: #28a745; border-radius: 50%; animation: pulseRing 2s infinite; position: absolute; top: 0; left: 0; opacity: 0.5;"></div>
            <div style="width: 100px; height: 100px; background-image: url('https://cdn-icons-png.flaticon.com/512/747/747376.png'); background-size: contain; background-repeat: no-repeat; animation: profileRotate 1.5s infinite; position: relative;"></div>
        </div>
        <ul class="nav nav-tabs mb-5" id="login_register" role="tablist" style="justify-content: center;">
            <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore active" id="register-tab" data-bs-toggle="tab"
                   href="#tab-item-register" role="tab" aria-controls="tab-item-register" aria-selected="true"
                   style="color: #333; font-weight: bold;">Register</a>
            </li>
        </ul>
        <div class="tab-content pt-2" id="login_register_tab_content">
            <div class="tab-pane fade show active" id="tab-item-register" role="tabpanel" aria-labelledby="register-tab">
                <div class="register-form" style="background: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <form method="POST" action="{{ route('register') }}" name="register-form" class="needs-validation" novalidate="">
                        @csrf
                        <div class="form-floating mb-3">
                            <input class="form-control form-control_gray @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                   style="border: 1px solid #ccc; border-radius: 5px;">
                            <label for="name" style="color: #555;">Name</label>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control form-control_gray @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"
                                   style="border: 1px solid #ccc; border-radius: 5px;">
                            <label for="email" style="color: #555;">Email address *</label>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="mobile" type="text" class="form-control form-control_gray @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile"
                                   style="border: 1px solid #ccc; border-radius: 5px;">
                            <label for="mobile" style="color: #555;">Mobile *</label>
                            @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control form-control_gray @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"
                                   style="border: 1px solid #ccc; border-radius: 5px;">
                            <label for="password" style="color: #555;">Password *</label>
                            <span id="passwordHelp" class="text-muted" style="font-size: 12px; color: #888;">Must include at least 8 characters, 1 uppercase letter, 1 lowercase letter, and 1 number.</span>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="password-confirm" type="password" class="form-control form-control_gray" name="password_confirmation" required autocomplete="new-password"
                                   style="border: 1px solid #ccc; border-radius: 5px;">
                            <label for="password-confirm" style="color: #555;">Confirm Password *</label>
                            <span id="matchMessage" class="text-muted" style="font-size: 12px; color: #888;">Passwords must match.</span>
                        </div>

                        <div class="d-flex align-items-center mb-3 pb-2" style="font-size: 14px; color: #666;">
                            <p class="m-0">Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy.</p>
                        </div>

                        <button class="btn btn-primary w-100 text-uppercase" type="submit" style="background-color: #007bff; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; transition: background-color 0.3s;">Register</button>

                        <div class="customer-option mt-4 text-center" style="font-size: 14px; color: #666;">
                            <span class="text-secondary">Have an account?</span>
                            <a href="{{ route('login') }}" class="btn-text js-show-register" style="color: #007bff; text-decoration: none; font-weight: bold;">Login to your Account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<style>
        @keyframes fadeInSection {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes loginAnimation {
        0% {
            opacity: 0;
            transform: translateY(-100px) scale(0.9);
        }
        50% {
            opacity: 0.5;
            transform: translateY(20px) scale(1.02);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes lockRotate {
        0%, 100% {
            transform: scale(1) rotate(0deg);
        }
        50% {
            transform: scale(1.1) rotate(10deg);
        }
    }

    @keyframes pulseRing {
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

    @keyframes buttonFadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

</style>


@endsection
@push('website-script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password-confirm');
        const passwordHelp = document.getElementById('passwordHelp');
        const matchMessage = document.getElementById('matchMessage');

        // Password strength validation
        passwordInput.addEventListener('input', () => {
            const value = passwordInput.value;
            const strongPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;
            if (!strongPassword.test(value)) {
                passwordHelp.style.color = 'red';
            } else {
                passwordHelp.style.color = 'green';
            }
        });

        // Password match validation
        confirmPasswordInput.addEventListener('input', () => {
            if (passwordInput.value !== confirmPasswordInput.value) {
                matchMessage.style.color = 'red';
                matchMessage.textContent = 'Passwords do not match.';
            } else {
                matchMessage.style.color = 'green';
                matchMessage.textContent = 'Passwords match.';
            }
        });
    });
</script>
@endpush
