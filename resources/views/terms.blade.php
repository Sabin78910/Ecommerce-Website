{{-- resources/views/terms.blade.php --}}
@extends('layouts.app')

@section('website-content')
    <main class="pt-90">
        <section class="terms container my-5">
            <h2 class="page-title text-center mb-4">Terms &amp; Conditions</h2>

            <div class="row">
                <div class="col-12">
                    <div class="px-3 px-md-5">
                        <h4>1. Introduction</h4>
                        <p>Welcome to N &amp; S Handicrafts. By using our website, you agree to comply with and be bound by
                            these terms and conditions. Please read them carefully.</p>

                        <h4 class="mt-4">2. Definitions</h4>
                        <ul>
                            <li><strong>“Company”</strong> refers to N &amp; S Handicrafts.</li>
                            <li><strong>“Customer”</strong> means anyone who accesses, browses, or makes a purchase on our
                                site.</li>
                            <li><strong>“Products”</strong> means the items offered for sale through our website.</li>
                        </ul>

                        <h4 class="mt-4">3. Orders &amp; Payment</h4>
                        <p>All orders are subject to acceptance and availability. Prices are as listed on the site at the
                            time you place your order. We accept payments via Bank Transfer only before the delivery of the
                            products.</p>

                        <h4 class="mt-4">4. Shipping &amp; Delivery</h4>
                        <p>We ship nationwide within Nepal and internationally. Delivery times vary by location. You will
                            receive a tracking number once your order is dispatched.</p>

                        <h4 class="mt-4">5. Returns &amp; Refunds</h4>
                        <p>If you are not completely satisfied, you may return your purchase within 7 days for a full
                            refund. Items must be unused and in original packaging.</p>

                        <h4 class="mt-4">6. Intellectual Property</h4>
                        <p>All content on this site (text, images, logos) is owned by N &amp; S Handicrafts or used with
                            permission. You may not reproduce, distribute, or create derivative works without our consent.
                        </p>

                        <h4 class="mt-4">7. Limitation of Liability</h4>
                        <p>To the maximum extent permitted by law, N &amp; S Handicrafts shall not be liable for any
                            indirect, incidental, or consequential damages arising from your use of the site or purchase of
                            our products.</p>

                        <h4 class="mt-4">8. Governing Law</h4>
                        <p>These terms are governed by the laws of Nepal. Any dispute will be subject to the exclusive
                            jurisdiction of the courts of Kathmandu.</p>

                        <h4 class="mt-4">9. Changes to Terms</h4>
                        <p>We may update these terms at any time. The “Last Updated” date below reflects the most recent
                            changes.</p>

                        <h4 class="mt-4">10. Account Termination</h4>
                        <p>N &amp; S Handicrafts reserves the right to suspend or terminate any user account at our sole
                            discretion, without prior notice or liability, for any reason, including breach of these Terms
                            &amp; Conditions.</p>

                        <p class="text-muted small mt-4">Last Updated: {{ date('F j, Y') }}</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
