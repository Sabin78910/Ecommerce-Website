@extends('layouts.admin')
@section('website-content')
    <style>
        .text-danger {
            font-size: initial;
            line-height: 36px;
        }

        .alert {
            font-size: initial;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Settings</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Settings</div>
                    </li>
                </ul>
            </div>
            <section class="my-account container">
                <h2 class="page-title">Account Details</h2>
                <div class="col-lg-9">
                    <div class="page-content my-account__edit">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <div class="my-account__edit-form">
                            <form name="account_edit_form" action="{{ route('admin.updateDetails') }}" method="POST"
                                class="needs-validation" novalidate="">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" id="id" value="{{ $user->id }}" />
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" placeholder="Full Name"
                                                name="name" value="{{ $user->name }}" required="">
                                            <label for="name">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control" placeholder="Mobile Number"
                                                name="mobile" value="{{ $user->mobile }}" required="">
                                            <label for="mobile">Mobile Number</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating my-3">
                                            <input type="email" class="form-control" placeholder="Email Address"
                                                name="email" value="{{ $user->email }}" required="">
                                            <label for="account_email">Email Address</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my-3">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="my-account__edit-form">
                                <form name="account_edit_form" action="{{ route('admin.updatePassword') }}" method="POST"
                                    class="needs-validation" novalidate="">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" id="id" value="{{ $user->id }}" />
                                    <div class="col-md-12">
                                        <div class="my-3">
                                            <h5 class="text-uppercase mb-0">Password Change</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating my-3">
                                            <input type="password" class="form-control" id="old_password"
                                                name="old_password" placeholder="Old password" required="">
                                            <label for="old_password">Old password</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating my-3">
                                            <input type="password" class="form-control" id="new_password"
                                                name="new_password" placeholder="New password" required="">
                                            <label for="account_new_password">New password</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating my-3">
                                            <input type="password" class="form-control" cfpwd=""
                                                data-cf-pwd="#new_password" id="new_password_confirmation"
                                                name="new_password_confirmation" placeholder="Confirm new password"
                                                required="">
                                            <label for="new_password_confirmation">Confirm new password</label>
                                            <div class="invalid-feedback">Passwords did not match!</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my-3">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </div>
    </section>
    </main>
@endsection
@push('website-script')
    <script>
        document.querySelectorAll('form').forEach((form) => {
            form.addEventListener('submit', function(event) {
                // Check strong password
                const newPassword = form.querySelector('#new_password');
                const confirmPassword = form.querySelector('#new_password_confirmation');
                const oldPassword = form.querySelector('#old_password');

                if (newPassword && oldPassword && newPassword.value === oldPassword.value) {
                    event.preventDefault();
                    alert('New password cannot be the same as the old password!');
                    return;
                }

                if (newPassword && confirmPassword && newPassword.value !== confirmPassword.value) {
                    event.preventDefault();
                    alert('New password and confirmation do not match!');
                    return;
                }

                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    alert('Please fill all fields correctly.');
                }

                form.classList.add('was-validated');
            });
        });
    </script>
@endpush
