{{-- resources/views/admin/payment-verifications/show.blade.php --}}
@extends('layouts.admin')

@section('website-content')
    <div class="main-content-inner">
        <div class="main-content-wrap">

            {{-- Header & Breadcrumbs --}}
            <div class="flex items-center justify-between mb-27">
                <h2 class="page-title">Payment Verification #{{ $verification->id }}</h2>
                <ul class="breadcrumbs flex items-center gap10">
                    <li><a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><a href="{{ route('admin.payment-verifications.index') }}">
                            <div class="text-tiny">Verifications</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">View</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">

                {{-- Details --}}
                <dl class="row fs-5 mb-4">
                    <dt class="col-sm-3">Order ID:</dt>
                    <dd class="col-sm-9">{{ $verification->order_id }}</dd>

                    <dt class="col-sm-3">Amount:</dt>
                    <dd class="col-sm-9">
                        <strong>Rs. {{ number_format($verification->amount, 2) }}</strong>
                        <span class="text-muted">({{ $verification->currency }})</span>
                    </dd>

                    <dt class="col-sm-3">Uploaded At:</dt>
                    <dd class="col-sm-9">{{ $verification->created_at->format('F j, Y, g:i a') }}</dd>
                </dl>

                {{-- Actions --}}
                <div class="mb-4">
                    {{-- Download --}}
                    <a href="{{ asset('storage/' . $verification->proof_of_payment) }}" target="_blank"
                        class="btn btn-outline-secondary btn-lg me-2">
                        <i class="icon-download"></i> Download Proof
                    </a>

                    {{-- Verify Button --}}
                    @php
                        $isVerified = $verification->order->status === 'payment_verified';

                        // Full filesystem path and extension
                        $fullPath = \Storage::disk('public')->path($verification->proof_of_payment);
                        $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                    @endphp

                    <form action="{{ route('admin.payment-verifications.verify', $verification->id) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-lg" {{ $isVerified ? 'disabled' : '' }}>
                            <i class="icon-check-circle"></i>
                            {{ $isVerified ? 'Already Verified' : 'Mark as Verified' }}
                        </button>
                    </form>
                </div>

                {{-- Responsive Embed --}}
                <div class="ratio ratio-16x9 mb-4">
                    @if ($ext === 'pdf')
                        <iframe src="{{ asset('storage/' . $verification->proof_of_payment) }}"
                            style="border:1px solid #ccc;"></iframe>
                    @else
                        <img src='{{ asset("storage/{$verification->proof_of_payment}") }}' class='img-fluid rounded'
                            alt='Proof of payment'>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
