{{-- resources/views/contact.blade.php --}}
@extends('layouts.app')
@push('website-styles')
<link rel="stylesheet" href="{{ asset('vendor/intl-tel-input/build/css/intlTelInput.css') }}">
<style>
  .iti{display:block;width:100%}
  .iti__country-list{max-height:320px;z-index:2147483647}
</style>
@endpush


@section('website-content')
    <main class="pt-90">
        <section class="contact-us container my-5">
            <h2 class="page-title text-center mb-4">Contact Us</h2>

            <div class="row">
                {{-- Location, Contact Info & Map --}}
                <div class="col-md-4 mb-4">
                    <h5>Our Location</h5>
                    <p>123 Kathmandu St., Thamel<br>Kathmandu, Nepal</p>

                    <h5 class="mt-3">Phone</h5>
                    <p>
                        <a href="tel:+977123456789" class="text-secondary">+977-123456789</a>
                    </p>

                    <h5 class="mt-3">Email</h5>
                    <p>
                        <a href="mailto:info@a&amp;shandicraft.com" class="text-secondary">
                            info@a&amp;shandicraft.com
                        </a>
                    </p>

                    <h5 class="mt-4">Find Us on Map</h5>
                    <div class="ratio ratio-16x9 mb-3">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.0215086904577!2d85.30762587572623!3d27.716622176177214!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb190067a6f3ff%3A0x3ba66ce39f769f09!2sN%20%26%20S%20Handicraft!5e0!3m2!1sen!2snp!4v1748042098967!5m2!1sen!2snp"
                            style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                {{-- Contact Form --}}
                <div class="col-md-8">
                    <form id="contactForm" method="POST" action="{{ route('contact.store') }}" novalidate>
                        @csrf

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                            <div class="invalid-feedback">Please enter your name.</div>
                        </div>

                        {{-- Phone: ALL countries with flag + name + dial code (searchable).
                             Shows *local* number only; we enforce exactly 10 digits.
                             We submit hidden `phone` as E.164 (+code+number). --}}
                             <div class="mb-3">
                                <label for="phone_input" class="form-label">Phone Number *</label>
                                <input
                                  type="tel"
                                  id="phone_input"
                                  class="form-control"
                                  placeholder="9801234567"
                                  inputmode="numeric"
                                  maxlength="10"
                                  autocomplete="tel"
                                  required
                                >
                                <input type="hidden" id="phone" name="phone">
                                <div class="form-text">Pick your country by flag (type to search), then enter a <strong>10-digit</strong> number.</div>
                                <div class="invalid-feedback">Enter exactly 10 digits for the phone number.</div>
                              </div>
                              

                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject *</label>
                            <input type="text" id="subject" name="subject" class="form-control" required>
                            <div class="invalid-feedback">
                                Please enter a subject.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Your Query *</label>
                            <textarea id="message" name="message" rows="5" class="form-control" required></textarea>
                            <div class="invalid-feedback">
                                Please enter your query.
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('website-script')
<script src="{{ asset('vendor/intl-tel-input/build/js/intlTelInput.min.js') }}"></script>
<script src="{{ asset('vendor/intl-tel-input/build/js/utils.js') }}"></script>
<script>
  (function(){
    function init(){
      const form = document.getElementById('contactForm');
      const phoneInput = document.getElementById('phone_input');
      const hiddenPhone = document.getElementById('phone');
      if(!window.intlTelInput){ console.error('[phone] local intlTelInput not found'); return; }
      const iti = window.intlTelInput(phoneInput, {
        initialCountry: 'np',
        preferredCountries: ['np','in','us','gb'],
        separateDialCode: true,
        nationalMode: true,
        autoPlaceholder: 'aggressive',
      });
      const cleanAndLimit = () => {
        const d = phoneInput.value.replace(/\D/g,'').slice(0,10);
        if(phoneInput.value !== d) phoneInput.value = d;
      };
      const validatePhone = () => {
        cleanAndLimit();
        const ok = /^\d{10}$/.test(phoneInput.value);
        phoneInput.classList.toggle('is-valid', ok);
        phoneInput.classList.toggle('is-invalid', !ok);
        return ok;
      };
      phoneInput.addEventListener('input', validatePhone);
      phoneInput.addEventListener('blur', validatePhone);
      phoneInput.addEventListener('countrychange', validatePhone);

      form.addEventListener('submit', (e)=>{
        let ok = validatePhone();
        if(!ok){ e.preventDefault(); phoneInput.focus(); return; }
        hiddenPhone.value = iti.getNumber(); // +CCCXXXXXXXXXX
      });
    }
    if(document.readyState==='loading'){ document.addEventListener('DOMContentLoaded', init, {once:true}); } else { init(); }
  })();
</script>
@endpush
