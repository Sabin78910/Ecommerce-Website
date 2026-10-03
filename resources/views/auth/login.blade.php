@extends('layouts.app')
@section('website-content')
    <main
        style="padding: 90px 20px; background: linear-gradient(to bottom right, #ffffff, #f7f9fc); min-height: 100vh; display: flex; justify-content: center; align-items: center;">
        <section class="login-register"
            style="width: 100%; max-width: 400px; padding: 30px 20px; background: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); animation: fadeInSection 1.2s ease; margin: 250px 0;">
            <div style="width: 100px; height: 100px; margin: 0 auto 20px auto; position: relative;">
                <div
                    style="width: 100px; height: 100px; background-color: #007bff; border-radius: 50%; animation: pulseRing 2s infinite; position: absolute; top: 0; left: 0; opacity: 0.5;">
                </div>
                <div
                    style="width: 100px; height: 100px; background-image: url('https://cdn-icons-png.flaticon.com/512/3064/3064197.png'); background-size: contain; background-repeat: no-repeat; animation: lockRotate 1.5s infinite; position: relative;">
                </div>
            </div>
            <ul class="nav nav-tabs" id="login_register" role="tablist" style="margin-bottom: 30px;">
                <li class="nav-item" role="presentation" style="flex: 1;">
                    <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#tab-item-login" role="tab"
                        aria-controls="tab-item-login" aria-selected="true"
                        style="display: block; text-align: center; padding: 10px; font-weight: bold; color: #495057; border: none; border-bottom: 2px solid transparent; transition: color 0.3s ease, border-bottom 0.3s ease;">
                        Login
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="login_register_tab_content" style="padding-top: 10px;">
                <div class="tab-pane fade show active" id="tab-item-login" role="tabpanel" aria-labelledby="login-tab">
                    <div class="login-form">
                        <form method="POST" action="{{ route('login') }}" name="login-form" class="needs-validation"
                            novalidate="" style="animation: loginAnimation 2s ease;">
                            @csrf
                            <div class="form-floating mb-3" style="position: relative;">
                                <input class="form-control" name="email" value="{{ old('email') }}" required
                                    autocomplete="email" autofocus
                                    style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 100%; font-size: 14px;">
                                <label for="email" style="font-size: 14px; color: #6c757d;">Email address *</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert" style="color: red; font-size: 12px;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div style="padding-bottom: 10px;"></div>

                            <div class="form-floating mb-3" style="position: relative;">
                                <input id="password" type="password" class="form-control" name="password" required
                                    autocomplete="current-password"
                                    style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 100%; font-size: 14px;">
                                <label for="password" style="font-size: 14px; color: #6c757d;">Password *</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert" style="color: red; font-size: 12px;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember"
                                    style="cursor: pointer;">
                                <label class="form-check-label" for="remember" style="cursor: pointer; color: #6c757d;">
                                    Remember Me
                                </label>
                            </div>

                            <button type="submit"
                                style="display: block; width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.3s ease; animation: buttonFadeIn 1.5s ease;">
                                Log In
                            </button>

                            <div class="customer-option" style="margin-top: 20px; text-align: center;">
                                <span style="color: #6c757d;">No account yet?</span>
                                <a href="{{ route('register') }}"
                                    style="color: #007bff; text-decoration: none; margin-left: 5px;">Create Account</a>
                                <br>
                                <span style="color: #6c757d;">Forgot Your Password?</span>
                                <a href="{{ route('forgot-password.email') }}"
                                    style="color: #007bff; text-decoration: none; margin-left: 5px;">Reset Password Now</a>
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

            0%,
            100% {
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

        .nav-link.active {
            color: #007bff;
            border-bottom: 2px solid #007bff;
        }

        .nav-link:hover {
            color: #0056b3;
            border-bottom: 2px solid #0056b3;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
@endsection
@push('website-script')
    @if (isset($_COOKIE['email']) && isset($_COOKIE['password']))
        <script>
            document.querySelector('[name="email"]').value = "{{ $_COOKIE['email'] }}";
            document.querySelector('[name="password"]').value = "{{ $_COOKIE['password'] }}";
            document.querySelector('#remember').checked = true;
        </script>
    @endif

    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            const rememberMe = document.querySelector('#remember').checked;
            if (rememberMe) {
                document.cookie =
                    `email=${document.querySelector('[name="email"]').value}; max-age=${15 * 24 * 60 * 60}; path=/;`;
                document.cookie =
                    `password=${document.querySelector('[name="password"]').value}; max-age=${15 * 24 * 60 * 60}; path=/;`;
            } else {
                document.cookie = 'email=; max-age=0; path=/;';
                document.cookie = 'password=; max-age=0; path=/;';
            }
        });
    </script>
@endpush
