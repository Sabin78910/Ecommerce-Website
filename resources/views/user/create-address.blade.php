{{-- resources/views/user/address_add.blade.php --}}
@extends('layouts.app')

@push('website-styles')
  {{-- Use UMD builds to avoid "export" parse errors --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/css/intlTelInput.css">
  <style>
    html,body{max-width:100%;overflow-x:hidden}
    .form-text{margin-top:.25rem}

    /* Country dropdown (Bootstrap-like; works with our lightweight JS) */
    .country-dropdown .dropdown-menu{width:100%;max-width:100%;z-index:2147483647}
    .country-dropdown .country-list{max-height:320px;overflow:auto}
    .country-item{display:flex;align-items:center;gap:.5rem;padding:.5rem .75rem;border-radius:.375rem;cursor:pointer}
    .country-item:hover,.country-item.active{background:#f1f3f5}
    .country-flag{width:1.25rem;text-align:center;flex:0 0 1.25rem}
    .country-name{flex:1 1 auto}

    /* intl-tel-input full width + locked dial style */
    .iti{display:block;width:100%}
    .iti__country-list{max-height:320px;z-index:2147483647}
    .phone-field .iti.iti--separate-dial-code .iti__selected-flag{
      background:#f8f9fa;border-right:1px solid #dee2e6;padding:0 12px;border-radius:.375rem 0 0 .375rem;
    }
    .phone-field .form-control{border-radius:0 .375rem .375rem 0}

    .is-invalid ~ .invalid-feedback{display:block}
  </style>
@endpush

@section('website-content')
  <div class="mb-4 pb-4"></div>
  <section class="my-account container">
    <h2 class="page-title">Address</h2>

    <div class="row">
      <div class="col-lg-3">
        @include('user.account_nav')
      </div>

      <div class="col-lg-9">
        <div class="page-content my-account__address">
          <div class="row">
            <div class="col-6">
              <p class="notice">The following addresses will be used on the checkout page by default.</p>
            </div>
            <div class="col-6 text-right">
              <a href="{{ route('user.address-details') }}" class="btn btn-sm btn-danger">Back</a>
            </div>
          </div>

          <div class="row">
            <div class="col-md-8">
              <div class="card mb-5">
                @if (session('success'))
                  <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                  <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="card-header">
                  <h5>Add New Address</h5>
                </div>

                <div class="card-body">
                  <form id="addressForm" action="{{ route('user.address.store') }}" method="POST" novalidate>
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ Auth::user()->id }}">

                    <div class="row mt-5">
                      {{-- NAME --}}
                      <div class="col-12">
                        <div class="form-floating my-3">
                          <input type="text" class="form-control" name="name" id="name" required value="{{ old('name') }}">
                          <label for="name">Full Name *</label>
                          @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                      </div>

                      {{-- COUNTRY (full row; shows dial code next to name) --}}
                      <div class="col-12">
                        <div class="my-3">
                          <label for="countryBtn" class="form-label mb-1">Country *</label>
                          <div class="dropdown w-100 country-dropdown">
                            <button class="btn btn-outline-secondary w-100 d-flex justify-content-between align-items-center"
                                    id="countryBtn" type="button" aria-expanded="false">
                              <span class="d-flex align-items-center">
                                <span class="country-flag me-2" id="countryFlag">🇳🇵</span>
                                <span id="countryName">Nepal</span>
                                <small class="text-muted ms-2" id="countryDialShown">+977</small>
                              </span>
                              <span aria-hidden="true">▾</span>
                            </button>

                            <div class="dropdown-menu p-2 shadow" aria-labelledby="countryBtn">
                              <input type="text" class="form-control mb-2" id="countrySearch" placeholder="Search country or code…">
                              <ul class="list-unstyled mb-0 country-list" id="countryList"></ul>
                            </div>
                          </div>

                          {{-- Hidden fields for backend (like checkout) --}}
                          <input type="hidden" name="country" id="country" value="{{ old('country') ?? 'Nepal' }}">
                          <input type="hidden" name="country_iso2" id="country_iso2" value="{{ old('country_iso2') ?? 'np' }}">
                          <input type="hidden" name="country_dial" id="country_dial" value="{{ old('country_dial') ?? '+977' }}">
                          @error('country') <span class="text-danger d-block mt-1">{{ $message }}</span> @enderror
                        </div>
                      </div>

                      {{-- PHONE (full row; locked dial code; hidden E.164) --}}
                      <div class="col-12">
                        <div class="my-3 phone-field">
                          <label for="phone_input" class="form-label mb-1">Phone Number *</label>
                          <input
                            type="tel"
                            class="form-control @error('phone') is-invalid @enderror"
                            id="phone_input"
                            placeholder="Phone number"
                            inputmode="numeric"
                            autocomplete="tel"
                            required
                            aria-describedby="phoneHelp">
                          <input type="hidden" id="phone" name="phone" value="{{ old('phone') }}">
                          <div class="invalid-feedback" id="phoneInvalidMsg">Please enter a valid phone number.</div>
                          <div id="phoneHelp" class="form-text">
                            Country code is added automatically and can’t be removed.
                          </div>
                          @error('phone') <span class="text-danger d-block mt-1">{{ $message }}</span> @enderror
                        </div>
                      </div>

                      {{-- REST OF ADDRESS (unchanged) --}}
                      <div class="col-md-4">
                        <div class="form-floating my-3">
                          <input type="text" class="form-control" name="zip" id="zip" required value="{{ old('zip') }}">
                          <label for="zip">Pincode *</label>
                          @error('zip') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-floating my-3">
                          <input type="text" class="form-control" name="province" id="province" required value="{{ old('province') }}">
                          <label for="province">Province *</label>
                          @error('province') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-floating my-3">
                          <input type="text" class="form-control" name="city" id="city" required value="{{ old('city') }}">
                          <label for="city">Town / City *</label>
                          @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-floating my-3">
                          <input type="text" class="form-control" name="address" id="address" required value="{{ old('address') }}">
                          <label for="address">House no, Building Name *</label>
                          @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-floating my-3">
                          <input type="text" class="form-control" name="locality" id="locality" required value="{{ old('locality') }}">
                          <label for="locality">Road Name, Area, Colony *</label>
                          @error('locality') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-floating my-3">
                          <input type="text" class="form-control" name="landmark" id="landmark" required value="{{ old('landmark') }}">
                          <label for="landmark">Landmark *</label>
                          @error('landmark') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-floating my-3">
                          <input type="text" class="form-control" name="district" id="district" required value="{{ old('district') }}">
                          <label for="district">District *</label>
                          @error('district') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="isdefault" name="isdefault">
                        <label class="form-check-label" for="isdefault">
                          Make as Default address
                        </label>
                      </div>
                    </div>

                    <div class="col-md-12 text-right">
                      <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                  </form>
                </div>{{-- /card-body --}}
              </div>{{-- /card --}}
            </div>{{-- /col-md-8 --}}
          </div>{{-- /row --}}
        </div>{{-- /page-content --}}
        <hr>
      </div>{{-- /col-lg-9 --}}
    </div>{{-- /row --}}
  </section>
@endsection

@push('website-script')
  {{-- UMD builds (fixes "export" error). Do NOT include utils.js separately except via utilsScript option. --}}
  <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/intlTelInput.min.js"></script>

  <script>
  (function(){
    function onReady(fn){ document.readyState!=='loading'?fn():document.addEventListener('DOMContentLoaded',fn); }
    onReady(initAddress);

    function iso2ToEmoji(iso2){
      if(!iso2) return '🏳️';
      return iso2.toUpperCase().replace(/./g,c=>String.fromCodePoint(127397+c.charCodeAt(0)));
    }

    function initAddress(){
      const form = document.getElementById('addressForm');
      if(!form) return;

      // Country UI
      const countryDropdown = document.querySelector('.country-dropdown');
      const countryBtn      = document.getElementById('countryBtn');
      const countryMenu     = countryDropdown?.querySelector('.dropdown-menu');
      const countryFlagEl   = document.getElementById('countryFlag');
      const countryNameEl   = document.getElementById('countryName');
      const countryDialShown= document.getElementById('countryDialShown');
      const countrySearch   = document.getElementById('countrySearch');
      const countryListEl   = document.getElementById('countryList');

      const countryHidden     = document.getElementById('country');
      const countryIso2Hidden = document.getElementById('country_iso2');
      const countryDialHidden = document.getElementById('country_dial');

      // Phone
      const phoneInput   = document.getElementById('phone_input');
      const hiddenPhone  = document.getElementById('phone');
      const phoneInvalid = document.getElementById('phoneInvalidMsg');

      // Lightweight dropdown (no Bootstrap dependency)
      if (countryBtn && countryMenu) {
        countryBtn.addEventListener('click', (e)=>{
          e.preventDefault();
          const open = countryMenu.classList.toggle('show');
          countryMenu.style.display = open ? 'block' : 'none';
          if (open) setTimeout(()=>countrySearch?.focus(), 0);
        });
        document.addEventListener('click', (e)=>{
          if (!countryDropdown.contains(e.target)) {
            countryMenu.classList.remove('show');
            countryMenu.style.display = 'none';
          }
        });
      }

      // ===== intl-tel-input =====
      if (!window.intlTelInput || !window.intlTelInputGlobals) {
        console.error('[phone] intl-tel-input not available (check CDN).');
        return;
      }

      const initialISO = (countryIso2Hidden?.value || 'np').toLowerCase();
      const iti = window.intlTelInput(phoneInput, {
        initialCountry: initialISO,
        preferredCountries: ['np','in','us','gb'],
        nationalMode: true,         // user types national number only
        separateDialCode: true,     // locked dial code box (visible)
        allowDropdown: false,       // we use our custom country dropdown above
        autoPlaceholder: 'aggressive',
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js"
      });
      window.__iti_address = iti; // debug helper

      // Rehydrate from old('phone') if present (E.164)
      @if(old('phone'))
        try { iti.setNumber(@json(old('phone'))); } catch(e){}
      @endif

      phoneInput.addEventListener('countrychange', ()=>{
        const c = iti.getSelectedCountryData();
        setCountryUI({name:c.name, iso2:c.iso2, dial:'+'+c.dialCode});
        if (iti.getNumberPlaceholder) phoneInput.placeholder = iti.getNumberPlaceholder();
        liveValidate();
      });

      // Build country list from plugin dataset
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
            <span class="text-muted">+${c.dialCode}</span>
          `;
          frag.appendChild(li);
        }
        countryListEl.innerHTML = '';
        countryListEl.appendChild(frag);
      }

      function setCountryUI({name, iso2, dial}){
        if(countryFlagEl) countryFlagEl.textContent = iso2ToEmoji(iso2);
        if(countryNameEl) countryNameEl.textContent = name;
        if(countryDialShown) countryDialShown.textContent = dial;
        if(countryHidden) countryHidden.value = name;
        if(countryIso2Hidden) countryIso2Hidden.value = iso2;
        if(countryDialHidden) countryDialHidden.value = dial;
      }

      // Seed UI
      (function seedUI(){
        const cur = allCountries.find(c=>c.iso2.toLowerCase()===initialISO)
                 || allCountries.find(c=>c.name===countryHidden?.value);
        if (cur) {
          setCountryUI({name:cur.name, iso2:cur.iso2, dial:'+'+cur.dialCode});
        } else {
          const c = iti.getSelectedCountryData();
          setCountryUI({name:c.name, iso2:c.iso2, dial:'+'+c.dialCode});
        }
      })();

      // Choose country → update ITI + close menu
      countryListEl?.addEventListener('click', (e)=>{
        const item = e.target.closest('.country-item');
        if(!item) return;
        const iso2 = item.dataset.iso2;
        const name = item.dataset.name;
        const dial = item.dataset.dial;
        setCountryUI({name, iso2, dial});
        iti.setCountry(iso2);
        if (countryMenu){
          countryMenu.classList.remove('show');
          countryMenu.style.display = 'none';
        }
      });

      // Filter countries
      countrySearch?.addEventListener('input', (e)=>{
        const needle = (e.target.value||'').trim().toLowerCase();
        countryListEl?.querySelectorAll('.country-item').forEach(item=>{
          const text = (item.dataset.name+' '+item.dataset.dial).toLowerCase();
          item.style.display = text.includes(needle)?'':'none';
        });
      });

      // Clean input & live validate
      phoneInput.addEventListener('input', (e)=>{
        const cleaned = e.target.value.replace(/[^\d\s-]/g,'');
        if (cleaned !== e.target.value) e.target.value = cleaned;
        liveValidate();
      });

      function liveValidate(){
        if (phoneInput.value.trim()===''){
          phoneInput.classList.remove('is-invalid');
          phoneInvalid.textContent = 'Please enter a valid phone number.';
          return;
        }
        const ok = iti.isValidNumber();
        phoneInput.classList.toggle('is-invalid', !ok);
        if (!ok) {
          const code = iti.getValidationError(); // 1 invalid country, 2 short, 3 long, 4 NaN
          const msgs = {1:'Invalid country code.',2:'Number is too short.',3:'Number is too long.',4:'Not a number.'};
          phoneInvalid.textContent = msgs[code] || 'Please enter a valid phone number.';
        } else {
          phoneInvalid.textContent = 'Please enter a valid phone number.';
        }
      }

      // Submit → send hidden E.164 (+<code><number>)
      form.addEventListener('submit', (e)=>{
        phoneInput.classList.remove('is-invalid');
        if (!iti.isValidNumber()) {
          e.preventDefault();
          liveValidate();
          phoneInput.focus();
          return;
        }
        hiddenPhone.value = iti.getNumber();
      });

      // If backend validation failed, focus phone
      @error('phone') phoneInput?.focus(); @enderror
    }
  })();
  </script>
@endpush
