{{-- resources/views/faqs.blade.php --}}
@extends('layouts.app')

@section('website-content')
    <main class="pt-90">
        <section class="faqs container my-5">
            <h2 class="page-title text-center mb-4">Frequently Asked Questions</h2>

            <div class="accordion" id="faqsAccordion">
                {{-- FAQ Item 1 --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqHeadingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapseOne" aria-expanded="false" aria-controls="faqCollapseOne">
                            How much does shipping cost?
                        </button>
                    </h2>
                    <div id="faqCollapseOne" class="accordion-collapse collapse" aria-labelledby="faqHeadingOne"
                        data-bs-parent="#faqsAccordion">
                        <div class="accordion-body">
                            We offer free shipping on all orders within Nepal. For international
                            orders, rates depend on destination and package weight—you’ll see
                            the exact cost at checkout.
                        </div>
                    </div>
                </div>

                {{-- FAQ Item 2 --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqHeadingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
                            What is your return policy?
                        </button>
                    </h2>
                    <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo"
                        data-bs-parent="#faqsAccordion">
                        <div class="accordion-body">
                            You can request a full refund within 7 days of delivery for unused
                            items in original packaging. See our <a href="{{ route('refund') }}">Refund &amp; Cancellation
                                Policy</a>
                            for full details.
                        </div>
                    </div>
                </div>

                {{-- FAQ Item 3 --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqHeadingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapseThree" aria-expanded="false" aria-controls="faqCollapseThree">
                            Which payment methods do you accept?
                        </button>
                    </h2>
                    <div id="faqCollapseThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree"
                        data-bs-parent="#faqsAccordion">
                        <div class="accordion-body">
                            We accept Bank Transfer (pre-shipment)
                            only.
                        </div>
                    </div>
                </div>

                {{-- FAQ Item 4 --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqHeadingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapseFour" aria-expanded="false" aria-controls="faqCollapseFour">
                            How can I track my order?
                        </button>
                    </h2>
                    <div id="faqCollapseFour" class="accordion-collapse collapse" aria-labelledby="faqHeadingFour"
                        data-bs-parent="#faqsAccordion">
                        <div class="accordion-body">
                            Once your order ships, we’ll email you a tracking number. You can
                            also view its status under <em>My Orders</em> in your account dashboard.
                        </div>
                    </div>
                </div>

                {{-- FAQ Item 5 --}}
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqHeadingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faqCollapseFive" aria-expanded="false" aria-controls="faqCollapseFive">
                            Do you accept custom or bulk orders?
                        </button>
                    </h2>
                    <div id="faqCollapseFive" class="accordion-collapse collapse" aria-labelledby="faqHeadingFive"
                        data-bs-parent="#faqsAccordion">
                        <div class="accordion-body">
                            Yes! For personalized or large-quantity requests, please
                            <a href="{{ route('contact') }}">contact us</a>. We’ll work with
                            you to create exactly what you need.
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
