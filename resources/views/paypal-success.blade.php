@extends('layouts.app')

@section('website-content')
<main class="pt-90">
    <div class="container">
        <h2 class="text-center">Processing Your Order...</h2>
        <p class="text-center">Please wait while we complete your order.</p>
        <form id="paypal-success-form" action="{{ route('cart.checkout.place.order') }}" method="POST">
            @csrf
            @foreach ($checkoutData as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <input type="hidden" name="payment_id" value="{{ $paymentId }}">
            <input type="hidden" name="payer_id" value="{{ $payerId }}">
        </form>
    </div>
</main>

@push('website-script')
<script>
    // Auto-submit the form
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('paypal-success-form').submit();
    });
</script>
@endpush
@endsection
