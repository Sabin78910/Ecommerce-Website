{{-- resources/views/about.blade.php --}}
@extends('layouts.app')

@section('website-content')
    <main class="pt-90">
        <section class="about-us container my-5">
            <h2 class="page-title text-center mb-4">About N & S Handicrafts</h2>

            <div class="row align-items-center">
                {{-- Hero image --}}
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="{{ asset('images/about-hero.png') }}" alt="About OnlineNepal"
                        class="img-fluid rounded shadow-sm">
                </div>

                {{-- Intro text --}}
                <div class="col-md-6">
                    <h4 class="mb-3">Who We Are</h4>
                    <p>
                        N & S Handicrafts was founded in 2022 with a simple mission: to bring the
                        best of Nepal’s craftsmanship and culture to your doorstep. From
                        handwoven pashminas to artisanal handicrafts, we partner directly with
                        local artisans to ensure quality, authenticity, and fair pricing.
                    </p>
                    <h4 class="mt-4 mb-3">Our Vision &amp; Mission</h4>
                    <p>
                        <strong>Vision:</strong> To be the #1 online destination for Nepali
                        goods worldwide, celebrating our heritage while empowering local
                        communities.<br>
                        <strong>Mission:</strong> Curate exceptional products, provide a
                        seamless shopping experience, and give back 5% of every sale to
                        grassroots cultural programs.
                    </p>
                </div>
            </div>
        </section>

        {{-- Team Section --}}
        <section class="team container my-5">
            <h3 class="text-center mb-4">Meet the Founders</h3>
            <div class="row">
                @php
                    $team = [
                        ['name' => 'Narayan Khanal', 'role' => 'Proprietor', 'img' => 'profile.jpg'],
                        ['name' => 'Anjan Khadka', 'role' => 'Co-Founder', 'img' => 'profile.jpg'],
                        ['name' => 'Rashila Khanal', 'role' => 'Co-Founder', 'img' => 'profile.jpg'],
                    ];
                @endphp

                @foreach ($team as $member)
                    <div class="col-sm-6 col-lg-4 text-center mb-4">
                        <img src="{{ asset('images/team/' . $member['img']) }}" alt="{{ $member['name'] }}"
                            class="rounded-circle mb-3" style="width:120px; height:120px; object-fit:cover;">
                        <h5 class="mb-1">{{ $member['name'] }}</h5>
                        <p class="text-muted">{{ $member['role'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Values / Why Choose Us --}}
        <section class="values bg-light py-5">
            <div class="container">
                <h3 class="text-center mb-4">Why Choose N &amp; S Handicrafts?</h3>

                <div class="row text-center">
                    <div class="col-md-4 mb-4">
                        <i class="fas fa-leaf fa-2x mb-2 text-dark"></i>
                        <h6>Eco-Friendly</h6>
                        <p class="small px-2">
                            Sustainable practices at every step—from sourcing to packaging.
                        </p>
                    </div>

                    <div class="col-md-4 mb-4">
                        <i class="fas fa-hands-helping fa-2x mb-2 text-dark"></i>
                        <h6>Authentic Craftsmanship</h6>
                        <p class="small px-2">
                            Hand-picked creations by local artisans, preserving centuries-old Nepali traditions.
                        </p>
                    </div>

                    <div class="col-md-4 mb-4">
                        <i class="fas fa-headset fa-2x mb-2 text-dark"></i>
                        <h6>24/7 Customer Support</h6>
                        <p class="small px-2">
                            Ready to assist via phone, email, or live chat—anytime, anywhere.
                        </p>
                    </div>

                    <div class="col-md-4 mb-4">
                        <i class="fas fa-smile-beam fa-2x mb-2 text-dark"></i>
                        <h6>Satisfaction Guarantee</h6>
                        <p class="small px-2">
                            Not happy? Return within 30 days for a full refund—no questions asked.
                        </p>
                    </div>

                    <div class="col-md-4 mb-4">
                        <i class="fas fa-truck fa-2x mb-2 text-dark"></i>
                        <h6>Fast Delivery</h6>
                        <p class="small px-2">
                            Nationwide shipping in Nepal, international dispatch in 2–4 days.
                        </p>
                    </div>

                    <div class="col-md-4 mb-4">
                        <i class="fas fa-check-circle fa-2x mb-2 text-dark"></i>
                        <h6>Quality Assurance</h6>
                        <p class="small px-2">
                            Every product undergoes rigorous quality checks before it reaches you.
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
