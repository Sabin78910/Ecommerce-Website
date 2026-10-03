{{-- resources/views/checkout.blade.php --}}
@extends('layouts.app')

@push('website-styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/css/intlTelInput.css">
<style>
  :root{
    --c-bg:#f7f7f9;
    --c-card:#ffffff;
    --c-text:#111827;
    --c-muted:#6b7280;
    --c-border:#e5e7eb;
    --c-brand:#6a6e51;
    --radius:16px;
    --shadow:0 10px 26px rgba(17,24,39,.06);
  }
  html,body{max-width:100%;overflow-x:hidden}
  .pt-90{padding-top:90px!important}
  .shop-checkout{color:var(--c-text)}
  .page-title{font-weight:800;letter-spacing:.3px;margin-bottom:12px}

  /* Stepper */
  .checkout-steps{display:grid;gap:10px;grid-template-columns:repeat(3,minmax(0,1fr));margin-bottom:18px}
  .checkout-steps__item{display:flex;gap:10px;align-items:center;text-decoration:none;background:var(--c-card);border:1px solid var(--c-border);border-radius:12px;padding:10px 12px;color:var(--c-text);box-shadow:0 6px 18px rgba(17,24,39,.05)}
  .checkout-steps__item-number{display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:10px;font-weight:800;background:#eef2ff;color:#3730a3}
  .checkout-steps__item-title span{font-weight:800;display:block;line-height:1.1}
  .checkout-steps__item-title em{font-style:normal;color:var(--c-muted);font-size:.85rem}
  .checkout-steps__item.active{border-color:var(--c-brand);box-shadow:0 10px 26px rgba(106,110,81,.18)}

  /* Two-column layout */
  .checkout-form{display:grid;grid-template-columns:minmax(0,1fr);gap:16px}
  @media (min-width: 992px){.checkout-form{grid-template-columns:minmax(0,1fr) 380px}}

  /* Left column */
  .billing-info__wrapper{background:var(--c-card);border:1px solid var(--c-border);border-radius:var(--radius);box-shadow:var(--shadow);padding:16px}
  .billing-info__wrapper h4{font-weight:800;margin-bottom:8px}

  /* Address grid */
  .addr-grid .card{border-radius:.9rem;transition:box-shadow .18s ease,border-color .18s ease,transform .12s ease}
  .addr-grid .card:hover{transform:translateY(-1px)}
  .addr-grid .card.is-selected{box-shadow:0 0 0 .15rem #6a6e5133;border-color:#6a6e5166}
  .addr-grid .addr-radio{transform:translateY(2px);width:1.05rem;height:1.05rem}
  .border-dashed{border:2px dashed var(--c-border)}
  .card address{margin:0;font-style:normal}
  .card .badge{font-size:.7rem}

  /* Country dropdown */
  .country-dropdown .dropdown-menu{width:100%;max-width:100%;z-index:2147483647}
  .country-dropdown .country-list{max-height:320px;overflow:auto}
  .country-item{display:flex;align-items:center;gap:.5rem;padding:.5rem .75rem;border-radius:.5rem;cursor:pointer}
  .country-item:hover{background:#f6f7f9}
  .country-flag{width:1.25rem;text-align:center;flex:0 0 1.25rem}
  .country-name{flex:1 1 auto}
  .country-dial{display:none!important}
  .iti{display:block;width:100%}
  .iti__country-list{max-height:320px;z-index:2147483647}

  /* RIGHT column — unified card so nothing overflows */
  .order-sidebar{position:static}
  @media (min-width: 992px){ .order-sidebar{position:sticky; top:90px} }

  .order-card{
    background:var(--c-card);
    border:1px solid var(--c-border);
    border-radius:var(--radius);
    box-shadow:var(--shadow);
    overflow:visible;               /* never clip content */
  }
  .order-card__section{padding:16px}
  .order-card__section + .order-card__section{border-top:1px solid var(--c-border)}

  .order-title{font-weight:800;margin:4px 0 8px}

  /* Tables */
  .checkout-cart-items,
  .checkout-totals,.cart-totals{width:100%}
  .checkout-cart-items{border-collapse:separate;border-spacing:0}
  .checkout-cart-items thead tr{background:var(--c-brand);color:#fff}
  .checkout-cart-items thead th{padding:12px;border:none;background:transparent;color:#fff}
  .checkout-cart-items thead th:first-child{border-top-left-radius:10px}
  .checkout-cart-items thead th:last-child{border-top-right-radius:10px}
  .checkout-cart-items tbody td,
  .checkout-totals td,.checkout-totals th,
  .cart-totals td,.cart-totals th{padding:10px 0;border-bottom:1px dashed var(--c-border);vertical-align:top}
  .checkout-cart-items tbody tr:last-child td{border-bottom:none}
  .checkout-totals tr:last-child td,.checkout-totals tr:last-child th,
  .cart-totals tr:last-child td,.cart-totals tr:last-child th{border-bottom:none}

  .policy-text{
    background:#f9fafb;
    border:1px dashed var(--c-border);
    border-radius:12px;
    padding:12px;
    color:var(--c-muted);
    margin:0;
    overflow-wrap:anywhere;         /* wrap long words/numbers */
    word-break:normal;
  }
</style>
@endpush

@section('website-content')
<main class="pt-90" style="background:var(--c-bg);">
  <div class="mb-4 pb-4"></div>

  <section class="shop-checkout container">
    <h2 class="page-title">Shipping and Checkout</h2>

    <div class="checkout-steps">
      <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">01</span>
        <span class="checkout-steps__item-title"><span>Shopping Bag</span><em>Manage Your Items List</em></span>
      </a>
      <a href="javascript:void(0)" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">02</span>
        <span class="checkout-steps__item-title"><span>Shipping and Checkout</span><em>Checkout Your Items List</em></span>
      </a>
      <a href="javascript:void(0)" class="checkout-steps__item">
        <span class="checkout-steps__item-number">03</span>
        <span class="checkout-steps__item-title"><span>Confirmation</span><em>Review And Submit Your Order</em></span>
      </a>
    </div>

    @php
      $addresses = ($addresses ?? null) ?: ((isset($address) && $address) ? collect([$address]) : collect());
      $hasAddresses = $addresses->count() > 0;
      $forceShowNew = $errors->any() || old('name') || !$hasAddresses;
    @endphp

    <form id="checkout-form" action="{{ route('cart.checkout.place.order') }}" method="POST" novalidate>
      @csrf
      <input type="hidden" name="payment_id" id="payment_id">
      <input type="hidden" name="payer_id" id="payer_id">

      <div class="checkout-form">
        <!-- LEFT -->
        <div class="billing-info__wrapper">
          <div class="row"><div class="col-12 col-md-6"><h4>SHIPPING DETAILS</h4></div></div>

          @if($hasAddresses)
            <p class="text-muted small mb-2">Choose a saved address or use a new one.</p>
            <div class="row g-3 g-md-4 my-account__address-list mb-3 addr-grid" role="radiogroup" aria-label="Saved addresses">
              @foreach($addresses as $addr)
                <div class="col-12 col-md-6 col-xl-4">
                  <label class="w-100">
                    <div class="card h-100">
                      <div class="card-body small">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                          <div class="d-flex align-items-center gap-2">
                            <input type="radio" class="form-check-input addr-radio" name="address_id"
                                   value="{{ $addr->id }}" {{ (!$forceShowNew && $loop->first) ? 'checked' : '' }}>
                            <strong class="mb-0">{{ $addr->name }}</strong>
                          </div>
                          @if($addr->isdefault)<span class="badge bg-success">Default</span>@endif
                        </div>
                        <address class="text-secondary">
                          <div>{{ $addr->address }}</div>
                          @if($addr->locality)<div>{{ $addr->locality }}</div>@endif
                          <div>{{ $addr->city }}, {{ $addr->district }}, {{ $addr->province }}, {{ $addr->country }}</div>
                          @if($addr->landmark)<div>Landmark: {{ $addr->landmark }}</div>@endif
                          <div class="mt-1">ZIP: {{ $addr->zip }}</div>
                          <div class="mt-1">Mobile: {{ $addr->phone }}</div>
                        </address>
                      </div>
                    </div>
                  </label>
                </div>
              @endforeach

              <!-- Use new -->
              <div class="col-12 col-md-6 col-xl-4">
                <label class="w-100">
                  <div class="card h-100 border-dashed">
                    <div class="card-body d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center gap-2">
                        <input type="radio" class="form-check-input addr-radio" name="address_id"
                               value="" id="radioNewAddress" {{ $forceShowNew ? 'checked' : '' }}>
                        <span class="text-muted">Use a new address</span>
                      </div>
                      <span class="small text-muted">+</span>
                    </div>
                  </div>
                </label>
              </div>
            </div>
          @endif

          <!-- New address form -->
          <div id="newAddressFields" class="{{ $forceShowNew ? '' : 'd-none' }}">
            <div class="row gy-3 mt-1">
              <div class="col-12">
                <div class="form-floating">
                  <input type="text" class="form-control" id="name" name="name" {{ $forceShowNew ? 'required' : '' }} value="{{ old('name') }}" data-new-addr>
                  <label for="name">Full Name *</label>
                  @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>

              <div class="col-12">
                <label for="countryBtn" class="form-label mb-1">Country *</label>
                <div class="dropdown w-100 country-dropdown">
                  <button class="btn btn-outline-secondary w-100 d-flex justify-content-between align-items-center"
                          id="countryBtn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="d-flex align-items-center">
                      <span class="country-flag me-2" id="countryFlag">🇳🇵</span>
                      <span id="countryName">{{ old('country','Nepal') }}</span>
                    </span>
                    <span aria-hidden="true">▾</span>
                  </button>
                  <div class="dropdown-menu p-2 shadow" aria-labelledby="countryBtn">
                    <input type="text" class="form-control mb-2" id="countrySearch" placeholder="Search country…">
                    <ul class="list-unstyled mb-0 country-list" id="countryList"></ul>
                  </div>
                </div>
                <input type="hidden" name="country" id="country" value="{{ old('country','Nepal') }}" data-new-addr>
                <input type="hidden" name="country_iso2" id="country_iso2" value="{{ old('country_iso2','np') }}" data-new-addr>
                <input type="hidden" name="country_dial" id="country_dial" value="{{ old('country_dial','+977') }}" data-new-addr>
                @error('country') <span class="text-danger d-block mt-1">{{ $message }}</span> @enderror
              </div>

              <div class="col-12">
                <label for="checkout_phone_input" class="form-label mb-1">Phone Number *</label>
                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                       id="checkout_phone_input" placeholder="Phone number" inputmode="numeric"
                       autocomplete="tel" {{ $forceShowNew ? 'required' : '' }} data-new-addr>
                <input type="hidden" id="checkout_phone" name="phone" value="{{ old('phone') }}" data-new-addr>
                <div class="invalid-feedback" id="phoneInvalidMsg">Please enter a valid phone number.</div>
                <div class="form-text">Country code is added automatically and can’t be removed.</div>
                @error('phone') <span class="text-danger d-block mt-1">{{ $message }}</span> @enderror
              </div>

              <div class="col-sm-6 col-lg-4">
                <div class="form-floating">
                  <input type="text" class="form-control" id="zip" name="zip" {{ $forceShowNew ? 'required' : '' }} value="{{ old('zip') }}" data-new-addr>
                  <label for="zip">Pincode *</label>
                  @error('zip') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>

              <div class="col-sm-6 col-lg-4">
                <div class="form-floating">
                  <input type="text" class="form-control" id="province" name="province" {{ $forceShowNew ? 'required' : '' }} value="{{ old('province') }}" data-new-addr>
                  <label for="province">Province *</label>
                  @error('province') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>

              <div class="col-sm-6 col-lg-4">
                <div class="form-floating">
                  <input type="text" class="form-control" id="city" name="city" {{ $forceShowNew ? 'required' : '' }} value="{{ old('city') }}" data-new-addr>
                  <label for="city">Town / City *</label>
                  @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control" id="address" name="address" {{ $forceShowNew ? 'required' : '' }} value="{{ old('address') }}" data-new-addr>
                  <label for="address">House no, Building Name *</label>
                  @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control" id="locality" name="locality" {{ $forceShowNew ? 'required' : '' }} value="{{ old('locality') }}" data-new-addr>
                  <label for="locality">Road Name, Area, Colony *</label>
                  @error('locality') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>

              <div class="col-12">
                <div class="form-floating">
                  <input type="text" class="form-control" id="landmark" name="landmark" {{ $forceShowNew ? 'required' : '' }} value="{{ old('landmark') }}" data-new-addr>
                  <label for="landmark">Landmark *</label>
                  @error('landmark') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>

              <div class="col-12">
                <div class="form-floating">
                  <input type="text" class="form-control" id="district" name="district" {{ $forceShowNew ? 'required' : '' }} value="{{ old('district') }}" data-new-addr>
                  <label for="district">District *</label>
                  @error('district') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- RIGHT (unified card; no overflow) -->
        <aside class="order-sidebar">
          <div class="order-card">
            <div class="order-card__section">
              <h3 class="order-title">Your Order</h3>

              <table class="checkout-cart-items">
                <thead>
                  <tr>
                    <th>PRODUCT</th>
                    <th class="text-end">SUBTOTAL</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach (Cart::instance('cart')->content() as $item)
                    <tr>
                      <td>{{ $item->name }} x {{ $item->qty }}</td>
                      <td class="text-end">Rs. {{ $item->price }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

              @if (Session::has('discounts'))
                <table class="cart-totals">
                  <tbody>
                    <tr><th>Subtotal</th><td class="text-end">Rs. {{ Cart::instance('cart')->subtotal() }}</td></tr>
                    <tr><th>Discount ({{ Session::get('coupon')['code'] }})</th><td class="text-end">− Rs. {{ Session::get('discounts')['discount'] }}</td></tr>
                    <tr><th>Subtotal After Discount</th><td class="text-end">Rs. {{ Session::get('discounts')['subtotal'] }}</td></tr>
                    <tr><th>Shipping</th><td class="text-end">Free</td></tr>
                    <tr><th>VAT</th><td class="text-end">Rs. {{ Session::get('discounts')['tax'] }}</td></tr>
                    <tr><th>Total</th><td class="text-end fw-bold">Rs. {{ Session::get('discounts')['total'] }}</td></tr>
                  </tbody>
                </table>
              @else
                <table class="checkout-totals">
                  <tbody>
                    <tr><th>SUB TOTAL</th><td class="text-end">Rs. {{ Cart::instance('cart')->subtotal() }}</td></tr>
                    <tr><th>PRE ESTIMATION VAT</th><td class="text-end">Rs. {{ Cart::instance('cart')->tax() }}</td></tr>
                    <tr><th>PRE ESTIMATION TOTAL</th><td class="text-end fw-bold">Rs. {{ Cart::instance('cart')->total() }}</td></tr>
                    <tr><th>SHIPPING</th><td class="text-end">Estimation Needed</td></tr>
                    <tr><th>FINAL VAT</th><td class="text-end">Estimation Needed</td></tr>
                    <tr><th>FINAL TOTAL</th><td class="text-end">Estimation Needed</td></tr>
                  </tbody>
                </table>
              @endif
            </div>

            <div class="order-card__section">
              <p class="policy-text">
                Once you click <strong>Request Estimate</strong>, we will calculate shipping charges and VAT,
                then email you a final invoice within <strong>1–3 business days</strong>.
              </p>
            </div>

            <div class="order-card__section">
              <button type="submit" class="btn btn-primary w-100" id="btnEstimate">Request Estimate</button>
            </div>
          </div>
        </aside>
      </div>
    </form>
  </section>
</main>
@endsection

@push('website-script')
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js"></script>
<script>
(function () {
  function onReady(fn){ document.readyState!=='loading'?fn():document.addEventListener('DOMContentLoaded',fn); }
  document.addEventListener('turbo:load', initCheckout);
  onReady(initCheckout);

  function iso2ToEmoji(iso2){
    if(!iso2) return '🏳️';
    return iso2.toUpperCase().replace(/./g,c=>String.fromCodePoint(127397+c.charCodeAt(0)));
  }

  function initCheckout(){
    const form = document.getElementById('checkout-form');
    if(!form) return;

    const addrRadios = document.querySelectorAll('.addr-radio');
    const addrCards  = document.querySelectorAll('.addr-grid .card');
    function refreshSelectedCard(){
      addrCards.forEach(card => card.classList.remove('is-selected'));
      addrRadios.forEach(r => { if(r.checked){ r.closest('.card')?.classList.add('is-selected'); }});
    }
    addrRadios.forEach(r => r.addEventListener('change', refreshSelectedCard));
    refreshSelectedCard();

    const newBox    = document.getElementById('newAddressFields');
    const newFields = document.querySelectorAll('[data-new-addr]');
    addrRadios.forEach(r=>{
      r.addEventListener('change', ()=>{
        const usingNew = !r.value && r.checked;
        if(!newBox) return;
        newBox.classList.toggle('d-none', !usingNew);
        newFields.forEach(el=>{
          if (el.matches('input,select,textarea')) {
            if (usingNew) el.setAttribute('required','required');
            else el.removeAttribute('required');
          }
        });
      });
    });

    const countryBtn    = document.getElementById('countryBtn');
    const countryFlagEl = document.getElementById('countryFlag');
    const countryNameEl = document.getElementById('countryName');
    const countrySearch = document.getElementById('countrySearch');
    const countryListEl = document.getElementById('countryList');
    const countryHidden     = document.getElementById('country');
    const countryIso2Hidden = document.getElementById('country_iso2');
    const countryDialHidden = document.getElementById('country_dial');

    const phoneInput   = document.getElementById('checkout_phone_input');
    const hiddenPhone  = document.getElementById('checkout_phone');
    const phoneInvalid = document.getElementById('phoneInvalidMsg');

    let iti = null;
    const initialISO = (countryIso2Hidden?.value || 'np').toLowerCase();
    if (phoneInput && window.intlTelInput && window.intlTelInputGlobals && typeof window.intlTelInputGlobals.getCountryData==='function') {
      iti = window.intlTelInput(phoneInput, {
        initialCountry: initialISO,
        preferredCountries: ['np','in','us','gb'],
        nationalMode: true,
        separateDialCode: true,
        autoPlaceholder: 'aggressive',
        allowDropdown: false,
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js"
      });

      @if(old('phone'))
        try { iti.setNumber(@json(old('phone'))); } catch(e){}
      @endif

      phoneInput.addEventListener('countrychange', ()=>{
        const c = iti.getSelectedCountryData();
        setCountryUI({name:c.name, iso2:c.iso2, dial:'+'+c.dialCode});
        liveValidate();
      });
    }

    if (phoneInput) {
      phoneInput.addEventListener('input', (e)=>{
        const cleaned = e.target.value.replace(/[^\d\s-]/g,'');
        if (cleaned !== e.target.value) e.target.value = cleaned;
        liveValidate();
      });
    }

    let allCountries = [];
    if (window.intlTelInputGlobals?.getCountryData) {
      allCountries = window.intlTelInputGlobals.getCountryData()
        .map(c=>({name:c.name, iso2:c.iso2, dialCode:String(c.dialCode)}))
        .sort((a,b)=>a.name.localeCompare(b.name));
      const frag = document.createDocumentFragment();
      for(const c of allCountries){
        const li = document.createElement('li');
        li.className='country-item';
        li.dataset.iso2 = c.iso2;
        li.dataset.dial = '+'+c.dialCode;
        li.dataset.name = c.name;
        li.innerHTML = `
          <span class="country-flag">${iso2ToEmoji(c.iso2)}</span>
          <span class="country-name">${c.name}</span>
          <span class="country-dial">+${c.dialCode}</span>
        `;
        frag.appendChild(li);
      }
      countryListEl && (countryListEl.innerHTML='', countryListEl.appendChild(frag));
    }

    (function seedCountry(){
      if(!countryHidden || !countryIso2Hidden || !countryDialHidden) return;
      const iso2 = (countryIso2Hidden.value || 'np').toLowerCase();
      const cur  = allCountries.find(c=>c.iso2.toLowerCase()===iso2)
                || allCountries.find(c=>c.name===countryHidden.value);
      if(cur) setCountryUI({name:cur.name, iso2:cur.iso2, dial:'+'+cur.dialCode});
    })();

    countryListEl?.addEventListener('click', (e)=>{
      const item = e.target.closest('.country-item');
      if(!item) return;
      setCountryUI({name:item.dataset.name, iso2:item.dataset.iso2, dial:item.dataset.dial});
      iti && iti.setCountry(item.dataset.iso2);
      if(window.bootstrap?.Dropdown){
        window.bootstrap.Dropdown.getOrCreateInstance(countryBtn).hide();
      }
    });

    countrySearch?.addEventListener('input', (e)=>{
      const needle = (e.target.value||'').trim().toLowerCase();
      countryListEl?.querySelectorAll('.country-item').forEach(item=>{
        const text = (item.dataset.name+' '+item.dataset.dial).toLowerCase();
        item.style.display = text.includes(needle)?'':'none';
      });
    });
    countryBtn?.addEventListener('shown.bs.dropdown', ()=>{
      if (!countrySearch) return;
      countrySearch.value='';
      countryListEl?.querySelectorAll('.country-item').forEach(i=>i.style.display='');
      countrySearch.focus();
    });

    function setCountryUI({name, iso2, dial}){
      const flag = iso2ToEmoji(iso2);
      countryFlagEl && (countryFlagEl.textContent = flag);
      countryNameEl && (countryNameEl.textContent = name);
      countryHidden && (countryHidden.value = name);
      countryIso2Hidden && (countryIso2Hidden.value = iso2);
      countryDialHidden && (countryDialHidden.value = dial);
    }

    function liveValidate(){
      if (!iti || !phoneInput) return;
      if (phoneInput.value.trim()===''){
        phoneInput.classList.remove('is-invalid');
        phoneInvalid.textContent = 'Please enter a valid phone number.';
        return;
      }
      const ok = iti.isValidNumber();
      phoneInput.classList.toggle('is-invalid', !ok);
      if (!ok) {
        const code = iti.getValidationError();
        const msgs = {1:'Invalid country code.',2:'Number is too short.',3:'Number is too long.',4:'Not a number.'};
        phoneInvalid.textContent = msgs[code] || 'Please enter a valid phone number.';
      } else {
        phoneInvalid.textContent = 'Please enter a valid phone number.';
      }
    }

    form.addEventListener('submit', (e)=>{
      const chosen = document.querySelector('input.addr-radio:checked');
      const usingNew = !chosen || !chosen.value;
      if (usingNew && phoneInput) {
        if (iti) {
          phoneInput.classList.remove('is-invalid');
          if (!iti.isValidNumber()) {
            e.preventDefault();
            liveValidate();
            phoneInput.focus();
            return;
          }
          hiddenPhone.value = iti.getNumber();
        } else {
          const dial = (document.getElementById('country_dial')?.value || '').replace(/\s/g,'');
          const local = phoneInput.value.replace(/\D/g,'');
          const e164 = (dial.startsWith('+')?dial:'+'+dial) + local;
          if (!/^\+[1-9]\d{7,14}$/.test(e164)) {
            e.preventDefault();
            phoneInput.classList.add('is-invalid');
            phoneInput.focus();
            return;
          }
          hiddenPhone.value = e164;
        }
      }
    });

    @error('phone') document.getElementById('checkout_phone_input')?.focus(); @enderror
  }
})();
</script>
@endpush
