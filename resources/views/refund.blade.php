{{-- resources/views/refund.blade.php --}}
@extends('layouts.app')

@section('website-content')
    <main class="pt-90">
        <section class="refund-policy container my-5">
            <h2 class="page-title text-center mb-4">Refund &amp; Cancellation Policy</h2>

            <div class="row">
                <div class="col-12">
                    <div class="px-3 px-md-5">
                        <h4>1. Refund Policy</h4>
                        <p>If you are not completely satisfied with your purchase, you may request a full refund within
                            <strong>7 days</strong> of delivery. To be eligible:
                        <ul>
                            <li>Items must be unused, in original packaging, and in the same condition as received.</li>
                            <li>You must provide proof of purchase (order number, invoice).</li>
                        </ul>
                        </p>

                        <h4 class="mt-4">2. Cancellation Policy</h4>
                        <p>You may cancel an order without penalty within <strong>24 hours</strong> of placing it. After 24
                            hours, orders may have entered processing or shipping and cannot be cancelled online. To cancel:
                        <ul>
                            <li>Contact our support team at <a
                                    href="mailto:support@nshandicrafts.com">support@nshandicrafts.com</a> or call <a
                                    href="tel:+977123456789">+977-123-456789</a>.</li>
                            <li>Provide your order number and cancellation request.</li>
                        </ul>
                        </p>

                        <h4 class="mt-4">3. How to Request a Refund or Cancellation</h4>
                        <ol>
                            <li>Submit your request via email or phone within the time frame above.</li>
                            <li>Pack the item securely in its original packaging.</li>
                            <li>Ship the item to our return center (cost of return shipping is the customer’s responsibility
                                unless the item is defective).</li>
                            <li>Once received and inspected, refunds will be processed within <strong>5 business
                                    days</strong> to your original payment method.</li>
                        </ol>

                        <h4 class="mt-4">4. Exceptions &amp; Non-Refundable Items</h4>
                        <p>The following items are exempt from refunds or cancellations:
                        <ul>
                            <li>Custom or personalized products.</li>
                            <li>Items marked "Final Sale" at checkout.</li>
                            <li>Gift cards.</li>
                        </ul>
                        </p>

                        <p class="text-muted small mt-4">Last Updated: {{ date('F j, Y') }}</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
