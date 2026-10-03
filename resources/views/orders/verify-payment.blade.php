@extends('layouts.app')

@section('website-content')
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Upload Proof of Payment</h2>
        <div class="row">
            <div class="col-lg-3">
                @include('user.account_nav')
            </div>
            <div class="col-lg-9">
                <div class="page-content">

                    @if ($alreadySubmitted)
                        <div class="alert alert-info">
                            You have already submitted proof of payment. We’ll notify you once it’s verified.
                        </div>
                    @else
                        <div class="mb-4">
                            <p class="notice">
                                Your estimated quotation for <strong>Order #{{ $order->id }}</strong> was emailed to you.
                                Please upload your proof of bank transfer below (PDF or image) along with the currency and
                                amount transferred.
                            </p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('payment.verify.submit', $order->id) }}"
                        enctype="multipart/form-data" class="row g-3">
                        @csrf

                        {{-- Proof of Payment --}}
                        <div class="col-md-6">
                            <label for="proof_of_payment" class="form-label">Proof of Payment</label>
                            <input type="file" name="proof_of_payment" id="proof_of_payment" class="form-control"
                                accept=".pdf,image/*" {{ $alreadySubmitted ? 'disabled' : 'required' }}>
                            @error('proof_of_payment')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Currency --}}
                        <div class="col-md-3">
                            <label for="currency" class="form-label">Currency</label>
                            <input type="text" name="currency" id="currency" class="form-control" maxlength="3"
                                placeholder="e.g. USD, NPR" {{ $alreadySubmitted ? 'disabled' : 'required' }}>
                            @error('currency')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Amount --}}
                        <div class="col-md-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control" step="0.01"
                                placeholder="0.00" {{ $alreadySubmitted ? 'disabled' : 'required' }}>
                            @error('amount')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary" {{ $alreadySubmitted ? 'disabled' : '' }}>
                                {{ $alreadySubmitted ? 'Already Submitted' : 'Submit Proof' }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection
