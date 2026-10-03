{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@push('website-styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
<style>
  :root{
    --brand:#0ea5e9; --brand-2:#0b74b5;
    --ink:#0f172a; --muted:#64748b; --soft:#f6f7fb; --card:#fff;
    --radius:16px; --shadow:0 10px 24px rgba(0,0,0,.08);
    --page-x: clamp(12px, 2vw, 24px);
  }

  html,body{max-width:100%;overflow-x:hidden}
  img{display:block;max-width:100%;height:auto}

  main{}
  .page{max-width:1620px;margin:0 auto;padding:24px var(--page-x)}
  .wrap{background:var(--card);border-radius:12px;box-shadow:var(--shadow)}

  .section{padding:28px var(--page-x)}
  @media(min-width:992px){ .section{padding:40px var(--page-x)} }
  .sec-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:18px}
  .title{margin:0;font-weight:800;color:var(--ink);letter-spacing:.2px}
  .btn-link{color:var(--brand);text-decoration:none;font-weight:600}
  .btn-link:hover{text-decoration:underline}

  /* ===== Cards ===== */
  .card{background:var(--card);border-radius:var(--radius);border:1px solid #e5e7eb;box-shadow:var(--shadow);transition:transform .16s ease, box-shadow .16s ease}
  .card:hover{transform:translateY(-2px);box-shadow:0 14px 34px rgba(0,0,0,.12)}
  .line-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}

  /* ===== Swiper ===== */
  .swiper-wrap{position:relative}
  .swiper{width:100%}
  .swiper--padded{padding-inline:56px}         /* room for arrows so they NEVER sit on top of slides */
  .carousel-nav{
    position:absolute;top:50%;transform:translateY(-50%);
    width:40px;height:40px;border-radius:999px;background:#fff;border:1px solid #e5e7eb;
    display:flex;align-items:center;justify-content:center;z-index:3;cursor:pointer;box-shadow:var(--shadow)
  }
  .carousel-prev{left:4px}
  .carousel-next{right:4px}
  .carousel-nav:hover{background:#f8fafc}
  /* Hide arrows on phones; swipe only */
  @media (max-width: 575.98px){ .carousel-nav{display:none} }

  /* Category */
  .cat-card{padding:12px;text-align:center}
  .cat-thumb{aspect-ratio:1/1;border-radius:12px;overflow:hidden;background:#fafafa}
  .cat-name{display:inline-block;margin-top:.6rem;font-weight:600;color:var(--ink);text-decoration:none}
  .cat-name:hover{color:var(--brand)}

  /* Product */
  .p-card{padding:10px}
  .p-thumb{aspect-ratio:4/5;border-radius:14px;overflow:hidden;background:#fafafa}
  .p-title a{color:var(--ink);text-decoration:none}
  .p-title a:hover{color:var(--brand)}
  .price{font-weight:800}
  .price s{color:#9ca3af;margin-right:.35rem}

  /* ===== Hot Deals header with compact countdown ===== */
  .deal-head{
    display:flex;align-items:center;gap:12px;flex-wrap:wrap
  }
  .deal-pill{
    display:inline-flex;align-items:center;gap:.55rem;
    padding:.4rem .8rem;border-radius:999px;border:1px solid #e5e7eb;background:#fff;
    font-weight:700;font-size:.95rem;color:var(--brand-2)
  }
  .deal-pill .sep{opacity:.35}
  .deal-pill small{font-weight:600;color:var(--muted)}
</style>
@endpush

@section('website-content')
<main>
  <div class="page">
    <div class="wrap">

      {{-- ================= CATEGORIES ================= --}}
      <section class="section" style="margin-top:15px;">
        <div class="sec-head">
            {{--
          <h2 class="title">You Might Like</h2>
          <a class="btn-link" href="{{ route('shop.index') }}">View All</a>
          
          --}}
          <h2 class="title" style="margin-right:.25rem">Categories</h2>
        </div>

        <div class="swiper-wrap">
          <div class="swiper swiper--padded js-swiper-slider" id="cats-swiper"
               data-settings='{
                 "autoplay":{"delay":4500},
                 "loop":true,
                 "slidesPerView":8,
                 "spaceBetween":20,
                 "breakpoints":{
                   "320":{"slidesPerView":2,"spaceBetween":12},
                   "576":{"slidesPerView":3,"spaceBetween":14},
                   "768":{"slidesPerView":4,"spaceBetween":18},
                   "992":{"slidesPerView":6,"spaceBetween":20},
                   "1200":{"slidesPerView":8,"spaceBetween":22}
                 }
               }'>
            <div class="swiper-wrapper">
              @foreach ($categories as $category)
                <div class="swiper-slide">
                  <div class="card cat-card h-100">
                    <div class="cat-thumb">
                      <img loading="lazy"
                           src="{{ asset('uploads/category_images') }}/{{ $category->image }}"
                           alt="{{ $category->name }}"
                           onerror="this.src='https://via.placeholder.com/300?text=Category'">
                    </div>
                    <a class="cat-name" href="{{ route('shop.index', ['categories' => $category->id]) }}">
                      {{ $category->name }}
                    </a>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <button id="cats-prev" class="carousel-nav carousel-prev" aria-label="Previous">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M15 18l-6-6 6-6" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
          <button id="cats-next" class="carousel-nav carousel-next" aria-label="Next">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
        </div>
      </section>

      {{-- ================= HOT DEALS ================= --}}
      <section class="section">
        <div class="sec-head">
          <div class="deal-head">
            <h2 class="title" style="margin-right:.25rem">Hot Deals</h2>
          </div>
          <a class="btn-link" href="{{ route('shop.index') }}">View All</a>
        </div>

        <div class="swiper-wrap">
          <div class="swiper swiper--padded js-swiper-slider" id="deals-swiper"
               data-settings='{
                 "autoplay":{"delay":5000},
                 "loop":false,
                 "slidesPerView":4,
                 "spaceBetween":20,
                 "breakpoints":{
                   "320":{"slidesPerView":2,"spaceBetween":12},
                   "576":{"slidesPerView":2,"spaceBetween":14},
                   "768":{"slidesPerView":3,"spaceBetween":18},
                   "992":{"slidesPerView":3,"spaceBetween":20},
                   "1200":{"slidesPerView":4,"spaceBetween":22}
                 }
               }'>
            <div class="swiper-wrapper">
              @foreach ($on_sale_products as $product)
                <div class="swiper-slide">
                  <div class="card p-card h-100">
                    <a class="p-thumb" href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                      <img loading="lazy"
                           src="{{ asset('uploads/products') }}/{{ $product->image }}"
                           alt="{{ $product->name }}"
                           onerror="this.src='https://via.placeholder.com/330x400?text=No+Image'">
                    </a>
                    <div class="p-3">
                      <h6 class="p-title mb-1 line-2">
                        <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                          {{ $product->name }}
                        </a>
                      </h6>
                      <div>
                        <span class="price">
                          @if ($product->sales_price)
                            <s>Rs. {{ $product->regular_price }}</s> <br>Rs. {{ $product->sales_price }}
                          @else
                            Rs. {{ $product->regular_price }}
                          @endif
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <button id="deals-prev" class="carousel-nav carousel-prev" aria-label="Previous">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M15 18l-6-6 6-6" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
          <button id="deals-next" class="carousel-nav carousel-next" aria-label="Next">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
        </div>
      </section>

      {{-- ================= FEATURED GRID ================= --}}
      <section class="section">
        <div class="sec-head">
          <h2 class="title">Featured Products</h2>
          <a class="btn-link" href="{{ route('shop.index') }}">Browse More</a>
        </div>

        <div class="row g-3 g-sm-4" style="padding-inline:var(--page-x)">
          @foreach ($featured_products as $product)
            <div class="col-6 col-md-4 col-lg-3">
              <div class="card p-card h-100">
                <a class="p-thumb" href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                  <img loading="lazy"
                       src="{{ asset('uploads/products') }}/{{ $product->image }}"
                       alt="{{ $product->name }}"
                       onerror="this.src='https://via.placeholder.com/330x400?text=No+Image'">
                </a>
                <div class="p-3">
                  <h6 class="p-title mb-1 line-2">
                    <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                      {{ $product->name }}
                    </a>
                  </h6>
                  <div>
                    <span class="price">
                      @if ($product->sales_price)
                        <s>Rs. {{ $product->regular_price }}</s> Rs. {{ $product->sales_price }}
                      @else
                        Rs. {{ $product->regular_price }}
                      @endif
                    </span>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </section>

    </div>
  </div>
</main>
@endsection

@push('website-scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
  // ===== Safe JSON parse
  const parseSettings = el => { try { return JSON.parse(el.dataset.settings||'{}'); } catch { return {}; } };

  // ===== Initialize swipers (with scoped nav)
  document.querySelectorAll('.js-swiper-slider').forEach(el=>{
    const opts = parseSettings(el);
    const wrap = el.closest('.swiper-wrap') || el.parentElement;
    const prev = wrap?.querySelector('.carousel-prev');
    const next = wrap?.querySelector('.carousel-next');
    if(prev && next){ opts.navigation = { prevEl: prev, nextEl: next }; }

    // If not enough slides, disable nav/loop for cleanliness
    const slides = el.querySelectorAll('.swiper-slide').length;
    if (slides <= 2) { opts.loop = false; }

    if(!opts.breakpoints){
      opts.breakpoints = {
        320:{slidesPerView:2, spaceBetween:12},
        768:{slidesPerView:3, spaceBetween:18},
        1200:{slidesPerView:4, spaceBetween:22}
      };
    }

    new Swiper(el, Object.assign({
      watchSlidesProgress:true,
      a11y:true,
      keyboard:{ enabled:true },
      grabCursor:true
    }, opts));
  });

  // ===== Compact countdown (Safari-safe). If date invalid, fallback 7 days.
  (function(){
    const pill = document.getElementById('deal-pill');
    if(!pill) return;

    function parseDateSafe(dateStr, timeStr){
      if(!dateStr){
        const d = new Date(); d.setDate(d.getDate()+7); d.setHours(23,59,59,0); return d;
      }
      const t = timeStr || '00:00:00';
      let d = new Date(`${dateStr}T${t}`);
      if(isNaN(d)) d = new Date(dateStr.replace(/-/g,'/') + ' ' + t);
      if(isNaN(d)){ const f = new Date(); f.setDate(f.getDate()+7); f.setHours(23,59,59,0); return f; }
      return d;
    }

    const end = parseDateSafe(pill.dataset.date, pill.dataset.time);
    const dEl = pill.querySelector('[data-d="d"]');
    const hEl = pill.querySelector('[data-d="h"]');
    const mEl = pill.querySelector('[data-d="m"]');
    const sEl = pill.querySelector('[data-d="s"]');

    const tick = ()=>{
      const now = new Date();
      let diff = Math.max(0, end - now);
      const d = Math.floor(diff/86400000); diff -= d*86400000;
      const h = Math.floor(diff/3600000);  diff -= h*3600000;
      const m = Math.floor(diff/60000);    diff -= m*60000;
      const s = Math.floor(diff/1000);

      dEl.textContent = String(d);
      hEl.textContent = String(h).padStart(2,'0');
      mEl.textContent = String(m).padStart(2,'0');
      sEl.textContent = String(s).padStart(2,'0');
    };
    tick(); setInterval(tick, 1000);
  })();
</script>
@endpush
