@extends('layouts.app')

@push('website-styles')
  {{-- Swiper & noUiSlider --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css">

  <style>
    /* --- Global polish --- */
    html, body { max-width:100%; overflow-x:hidden; }
    img{ display:block; max-width:100%; height:auto; }
    .rounded-16{ border-radius:16px; }
    .shadow-soft{ box-shadow:0 8px 24px rgba(0,0,0,.06); }
    .fw-600{ font-weight:600; }
    .text-muted-2{ color:#6b7280; }

    /* --- Layout spacing --- */
    .section-pad{ padding-top:1.5rem; padding-bottom:2rem; }
    @media (min-width: 1200px){ .section-pad{ padding-top:2rem; padding-bottom:2.5rem; } }

    /* --- Top controls row --- */
    .controls-bar{
      gap:.75rem;
    }
    .controls-bar .form-select, .controls-bar .form-control{
      min-height:40px;
      border-radius:10px;
    }
    .controls-bar .btn-filter{
      border-radius:10px;
    }

    /* --- Offcanvas filters (mobile) --- */
    .offcanvas-lg{
      --bs-offcanvas-width: 320px;
    }
    .filter-heading{
      font-size:1.05rem; letter-spacing:.02em;
    }
    .brand-list .list-item, .category-list .list-item{
      display:flex; align-items:center; justify-content:space-between;
      padding:.35rem .25rem; border-bottom:1px dashed #f0f0f0;
      font-size:.95rem;
    }

    /* --- Price slider --- */
    #price-range-slider{ margin:10px 6px 12px 6px; }
    .price-range__info{ font-size:.95rem; }

    /* --- Product grid & card --- */
    #products-grid.row{ --bs-gutter-x:1rem; --bs-gutter-y:1rem; }
    @media (min-width: 992px){ #products-grid.row{ --bs-gutter-x:1.25rem; --bs-gutter-y:1.25rem; } }

    .product-card{
      background:var(--bs-body-bg,#fff);
      border:1px solid rgba(0,0,0,.06);
      border-radius:18px;
      overflow:hidden;
      transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }
    .product-card:hover{
      transform:translateY(-2px);
      box-shadow:0 10px 28px rgba(0,0,0,.08);
      border-color:rgba(0,0,0,.08);
    }

    /* Image area */
    .pc__img-wrapper{
      position:relative;
      background:#f9fafb;
    }
    .pc__img{
      width:100%;
      aspect-ratio: 4 / 5; /* keeps consistent height; modern browsers */
      object-fit:cover;
      border-bottom:1px solid rgba(0,0,0,.06);
    }
    .pc__img-prev, .pc__img-next{
      position:absolute; top:50%; transform:translateY(-50%);
      z-index:3; display:flex; align-items:center; justify-content:center;
      width:34px; height:34px; border-radius:50%;
      background:rgba(255,255,255,.9); border:1px solid rgba(0,0,0,.08);
      cursor:pointer; opacity:0; transition:opacity .18s ease;
    }
    .pc__img-prev{ left:10px; }
    .pc__img-next{ right:10px; }
    .product-card:hover .pc__img-prev, .product-card:hover .pc__img-next{ opacity:1; }

    /* Add to cart */
    .pc__atc{
      left:12px; right:12px; bottom:12px;
      background:#111827; color:#fff; border-radius:12px; padding:.55rem 1rem;
      font-size:.9rem;
    }
    .pc__atc.btn-warning{ background:#f59e0b; color:#111827; }

    /* Info area */
    .pc__info{ padding:12px 14px 16px; }
    .pc__category{ color:#6b7280; font-size:.85rem; margin-bottom:4px; }
    .pc__title a{ text-decoration:none; color:inherit; }
    .pc__title{ font-size:1rem; line-height:1.35; margin-bottom:.35rem; min-height:2.6em; }
    .product-card__price .price{ font-size:1rem; }
    .product-card__price s{ color:#9ca3af; margin-right:.35rem; }

    /* Labels */
    .pc-labels{ pointer-events:none; padding:10px; }
    .pc-label{ display:inline-block; padding:.25rem .5rem; border-radius:999px; font-size:.75rem; }
    .pc-label_sale{ background:#ef4444; }

    /* View buttons */
    .js-cols-size{ border:none; background:transparent; padding:.25rem .5rem; border-radius:8px; }
    .js-cols-size.active{ background:#111827; color:#fff; }

    /* Make cards a bit larger on bigger screens */
    @media (min-width: 992px){
      .product-card .pc__title{ font-size:1.05rem; }
      .product-card .price{ font-size:1.05rem; }
    }
  </style>
@endpush

@section('website-content')
<main class="pt-90">
  <section class="section-pad container">
    <div class="row g-4">
      {{-- =================== SIDEBAR / OFFCANVAS FILTERS =================== --}}
      <div class="col-12 col-lg-3">
        <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
          <div class="offcanvas-header d-lg-none">
            <h5 class="offcanvas-title filter-heading" id="filterOffcanvasLabel">Filter Products</h5>
          </div>
          <div class="offcanvas-body">

            {{-- Categories --}}
            <div class="accordion" id="categories-list">
              <div class="accordion-item mb-4 pb-2">
                <h5 class="accordion-header" id="accordion-heading-1">
                  <button class="accordion-button p-0 border-0 fs-6 text-uppercase fw-600" type="button"
                          data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true"
                          aria-controls="accordion-filter-1">
                    Product Categories
                  </button>
                </h5>
                <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
                     aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
                  <div class="accordion-body px-0 pb-0 pt-3">
                    <ul class="list list-inline mb-0 category-list">
                      @foreach ($categories as $category)
                        <li class="list-item">
                          <label class="d-flex align-items-center gap-2 mb-0">
                            <input type="checkbox" name="categories" value="{{ $category->id }}" class="chk-category"
                              @if (in_array($category->id, $categories_filter)) checked @endif>
                            <span>{{ $category->name }}</span>
                          </label>
                          <span class="text-muted-2">{{ $category->products->count() }}</span>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            {{-- Brands --}}
            <div class="accordion" id="brand-filters">
              <div class="accordion-item mb-4 pb-2">
                <h5 class="accordion-header" id="accordion-heading-brand">
                  <button class="accordion-button p-0 border-0 fs-6 text-uppercase fw-600" type="button"
                          data-bs-toggle="collapse" data-bs-target="#accordion-filter-brand" aria-expanded="true"
                          aria-controls="accordion-filter-brand">
                    Brands
                  </button>
                </h5>
                <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0"
                     aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
                  <div class="accordion-body px-0 pb-0">
                    <ul class="list list-inline mb-0 brand-list">
                      @foreach ($brands as $brand)
                        <li class="list-item">
                          <label class="d-flex align-items-center gap-2 mb-0">
                            <input type="checkbox" name="brands" value="{{ $brand->id }}" class="chk-brand"
                              @if (in_array($brand->id, $brand_filter)) checked @endif>
                            <span>{{ $brand->name }}</span>
                          </label>
                          <span class="text-muted-2">{{ $brand->products->count() }}</span>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            {{-- Price --}}
            <div class="accordion" id="price-filters">
              <div class="accordion-item mb-1">
                <h5 class="accordion-header mb-2" id="accordion-heading-price">
                  <button class="accordion-button p-0 border-0 fs-6 text-uppercase fw-600" type="button"
                          data-bs-toggle="collapse" data-bs-target="#accordion-filter-price" aria-expanded="true"
                          aria-controls="accordion-filter-price">
                    Price
                  </button>
                </h5>

                <div id="accordion-filter-price" class="accordion-collapse collapse show border-0"
                     aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
                  <div id="price-range-slider"></div>

                  <div class="price-range__info d-flex align-items-center mt-2">
                    <div class="me-auto">
                      <span class="text-secondary">Min Price: </span>
                      <span class="price-range__min" id="min-price-display">Rs. {{ request('min', $minimum_price) }}</span>
                    </div>
                    <div>
                      <span class="text-secondary">Max Price: </span>
                      <span class="price-range__max" id="max-price-display">Rs. {{ request('max', $maximum_price) }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div> {{-- /offcanvas-body --}}
        </div>{{-- /offcanvas-lg --}}
      </div>

      {{-- =================== PRODUCT LIST =================== --}}
      <div class="col-12 col-lg-9">
        {{-- Breadcrumb + Controls (Search + PageSize + Sort + View + Filter button) --}}
        <div class="d-flex flex-wrap align-items-center justify-content-between controls-bar mb-3">
          <div class="breadcrumb mb-2 mb-md-0 d-none d-md-block">
            <a href="{{ route('home.index') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
            <span class="menu-link fw-medium px-1">/</span>
            <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
          </div>

          <div class="d-flex flex-wrap align-items-center ms-auto" style="gap:.5rem;">

            <select class="form-select w-auto border-0" aria-label="Page Size" id="pagesize" name="pagesize">
              <option value='12' {{ $size == 12 ? 'selected' : '' }}>Page Size</option>
              <option value='24' {{ $size == 24 ? 'selected' : '' }}>24</option>
              <option value='48' {{ $size == 48 ? 'selected' : '' }}>48</option>
              <option value='96' {{ $size == 96 ? 'selected' : '' }}>96</option>
            </select>

            <select class="form-select w-auto border-0" aria-label="Sort Items" id="orderby" name="orderby">
              <option value="-1" {{ $order == -1 ? 'selected' : '' }}>Default Sorting</option>
              <option value="1"  {{ $order == 1  ? 'selected' : '' }}>Alphabetically, A-Z</option>
              <option value="2"  {{ $order == 2  ? 'selected' : '' }}>Alphabetically, Z-A</option>
              <option value="3"  {{ $order == 3  ? 'selected' : '' }}>Price, low to high</option>
              <option value="4"  {{ $order == 4  ? 'selected' : '' }}>Price, high to low</option>
              <option value="5"  {{ $order == 5  ? 'selected' : '' }}>Date, old to new</option>
              <option value="6"  {{ $order == 6  ? 'selected' : '' }}>Date, new to old</option>
            </select>

            <div class="d-none d-lg-flex align-items-center ms-2">
              <span class="text-uppercase fw-medium me-1">View</span>
              <button class="js-cols-size {{ request('cols')==2 ? 'active' : '' }}" data-cols="2" type="button">2</button>
              <button class="js-cols-size {{ request('cols')==3 ? 'active' : '' }}" data-cols="3" type="button">3</button>
              <button class="js-cols-size {{ request('cols')==4 || !request()->has('cols') ? 'active' : '' }}" data-cols="4" type="button">4</button>
            </div>
          </div>
        </div>

        {{-- Products Grid --}}
        <div class="row row-cols-2 row-cols-md-3" id="products-grid">
          @foreach ($products as $product)
            @php
              $extraImages = array_values(array_filter(explode(',', (string)$product->images), fn($i)=>trim($i)!==''));
              $hasMultiple = count($extraImages) + 1 > 1;
            @endphp

            <div class="col product-card-wrapper">
              <div class="product-card">
                <div class="pc__img-wrapper position-relative">
                  <div class="swiper-container background-img js-swiper-slider">
                    <div class="swiper-wrapper">
                      <div class="swiper-slide">
                        <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                          <img loading="lazy"
                               src="{{ asset('uploads/products') }}/{{ $product->image }}"
                               alt="{{ $product->name }}" class="pc__img">
                        </a>
                      </div>
                      @foreach($extraImages as $image)
                        <div class="swiper-slide">
                          <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                            <img loading="lazy"
                                 src="{{ asset('uploads/products') }}/{{ trim($image) }}"
                                 alt="{{ $product->name }}" class="pc__img">
                          </a>
                        </div>
                      @endforeach
                    </div>

                    @if($hasMultiple)
                      <span class="pc__img-prev swiper-btn-prev">
                        <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                          <use href="#icon_prev_sm" />
                        </svg>
                      </span>
                      <span class="pc__img-next swiper-btn-next">
                        <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                          <use href="#icon_next_sm" />
                        </svg>
                      </span>
                    @endif
                  </div>

                  @if (Cart::instance('cart')->content()->where('id', $product->id)->count() > 0)
                    <a href="{{ route('cart.index') }}"
                       class="pc__atc btn position-absolute border-0 text-uppercase fw-medium btn-warning">
                      Go to Cart
                    </a>
                  @else
                    <form name="addtocart-form" method="POST" action="{{ route('cart.add') }}">
                      @csrf
                      <button type="submit"
                              class="pc__atc btn position-absolute border-0 text-uppercase fw-medium"
                              title="Add To Cart">
                        Add To Cart
                      </button>
                      <input type="hidden" name="id" value="{{ $product->id }}" />
                      <input type="hidden" name="name" value="{{ $product->name }}" />
                      <input type="hidden" name="image" value="{{ $product->image }}" />
                      <input type="hidden" name="quantity" value="1" />
                      <input type="hidden" name="price"
                             value="{{ $product->sales_price == '' ? $product->regular_price : $product->sales_price }}" />
                    </form>
                  @endif
                </div>

                <div class="pc__info position-relative">
                  <p class="pc__category mb-1">{{ $product->category->name }}</p>
                  <h6 class="pc__title">
                    <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">{{ $product->name }}</a>
                  </h6>
                  <div class="product-card__price d-flex align-items-center">
                    <span class="money price">
                      @if ($product->sales_price)
                        <s>Rs. {{ $product->regular_price }}</s> Rs. {{ $product->sales_price }}
                      @else
                        Rs. {{ $product->regular_price }}
                      @endif
                    </span>
                  </div>

                  {{-- Wishlist --}}
                  @if (Cart::instance('wishlist')->content()->where('id', $product->id)->count() > 0)
                    <form method="POST"
                          action="{{ route('wishlist.delete', ['rowId' => Cart::instance('wishlist')->content()->where('id', $product->id)->first()->rowId]) }}">
                      @csrf @method('DELETE')
                      <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 filled-heart"
                              title="Remove From Wishlist" type="submit" style="color:red;">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor"><use href="#icon_heart"/></svg>
                      </button>
                    </form>
                  @else
                    <form name="addtowishlist-form" method="POST" action="{{ route('wishlist.add') }}">
                      @csrf
                      <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0"
                              title="Add To Wishlist" type="submit">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none"><use href="#icon_heart"/></svg>
                      </button>
                      <input type="hidden" name="id" value="{{ $product->id }}" />
                      <input type="hidden" name="name" value="{{ $product->name }}" />
                      <input type="hidden" name="image" value="{{ $product->image }}" />
                      <input type="hidden" name="quantity" value="1" />
                      <input type="hidden" name="price"
                             value="{{ $product->sales_price == '' ? $product->regular_price : $product->sales_price }}" />
                    </form>
                  @endif
                </div>

                <div class="pc-labels position-absolute top-0 start-0 w-100 d-flex justify-content-end">
                  <span class="pc-label pc-label_sale text-white">-67%</span>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="divider my-3"></div>
        <div class="wgp-pagination d-flex align-items-center justify-content-between flex-wrap gap-2">
          {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
      </div>
    </div>
  </section>
</main>

{{-- Hidden filter form (kept intact) --}}
<form id="fliterform" method="GET" action="{{ route('shop.index') }}">
  <input type="hidden" name="page" value="{{ $products->currentPage() }}">
  <input type="hidden" name="size" id="size" value="{{ $size }}">
  <input type="hidden" name="order" id="order" value="{{ $order }}">
  <input type="hidden" name="brands" id="hdnbrands" value="{{ implode(',', $brand_filter) }}">
  <input type="hidden" name="categories" id="hdncategories" value="{{ implode(',', $categories_filter) }}">
  <input type="hidden" name="min" id="hdnminimum_price" value="{{ request('min', $minimum_price) }}">
  <input type="hidden" name="max" id="hdnmaximum_price" value="{{ request('max', $maximum_price) }}">
  <input type="hidden" name="cols" id="cols" value="{{ request('cols', 4) }}">
  <input type="hidden" name="q" id="qHidden" value="{{ request('q') }}">
</form>
@endsection

@push('website-script')
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js"></script>
<script>
(function(){
  // ======= Page Size & Sort =======
  document.getElementById('pagesize').addEventListener('change', function(){
    document.getElementById('size').value = this.value;
    // reset to first page when size changes
    document.querySelector('#fliterform input[name="page"]').value = 1;
    document.getElementById('fliterform').submit();
  });
  document.getElementById('orderby').addEventListener('change', function(){
    document.getElementById('order').value = this.value;
    document.querySelector('#fliterform input[name="page"]').value = 1;
    document.getElementById('fliterform').submit();
  });

  // ======= Search sync (optional) =======
  const q = document.getElementById('q');
  if(q){
    q.addEventListener('input', () => {
      document.getElementById('qHidden').value = q.value;
    });
  }

  // ======= Brand & Category filters =======
  function updateChecked(name, hiddenId){
    const vals = Array.from(document.querySelectorAll('input[name="'+name+'"]:checked')).map(i=>i.value).join(',');
    document.getElementById(hiddenId).value = vals;
    document.querySelector('#fliterform input[name="page"]').value = 1;
    document.getElementById('fliterform').submit();
  }
  document.querySelectorAll('input[name="brands"]').forEach(el=>{
    el.addEventListener('change', ()=>updateChecked('brands','hdnbrands'));
  });
  document.querySelectorAll('input[name="categories"]').forEach(el=>{
    el.addEventListener('change', ()=>updateChecked('categories','hdncategories'));
  });

  // ======= Price Slider (noUiSlider) =======
  const slider = document.getElementById('price-range-slider');
  const minPrice = Number({{ (int)$minimum_price }});
  const maxPrice = Number({{ (int)$maximum_price }});
  const selMin  = Number({{ (int)request('min', $minimum_price) }});
  const selMax  = Number({{ (int)request('max', $maximum_price) }});

  if(slider){
    noUiSlider.create(slider, {
      start: [selMin, selMax],
      connect: true,
      range: { 'min': minPrice, 'max': maxPrice },
      step: 100,
      format: {
        to: (v)=>Math.round(v),
        from: (v)=>Number(v)
      }
    });
    slider.noUiSlider.on('update', function(values){
      document.getElementById('min-price-display').innerText = 'Rs. ' + values[0];
      document.getElementById('max-price-display').innerText = 'Rs. ' + values[1];
    });
    slider.noUiSlider.on('change', function(values){
      document.getElementById('hdnminimum_price').value = values[0];
      document.getElementById('hdnmaximum_price').value = values[1];
      document.querySelector('#fliterform input[name="page"]').value = 1;
      document.getElementById('fliterform').submit();
    });
  }

  // ======= Swiper (one image per slide) =======
  document.querySelectorAll('.js-swiper-slider').forEach(function(el){
    const hasNav = el.querySelectorAll('.swiper-slide').length > 1;
    new Swiper(el, {
      slidesPerView: 1,
      spaceBetween: 0,
      loop: hasNav,
      navigation: hasNav ? {
        nextEl: el.querySelector('.swiper-btn-next'),
        prevEl: el.querySelector('.swiper-btn-prev'),
      } : {},
      // Resize observer keeps height clean
      observer: true,
      observeParents: true
    });
  });

  // ======= View: 2 / 3 / 4 columns =======
  const grid = document.getElementById('products-grid');
  const colBtns = document.querySelectorAll('.js-cols-size');
  function setCols(n){
    // Remove any previous row-cols-*
    ['row-cols-1','row-cols-2','row-cols-3','row-cols-4',
     'row-cols-md-1','row-cols-md-2','row-cols-md-3','row-cols-md-4',
     'row-cols-lg-1','row-cols-lg-2','row-cols-lg-3','row-cols-lg-4'].forEach(c=>grid.classList.remove(c));
    // Base class
    grid.classList.add('row');
    // Mobile always at least 2
    grid.classList.add('row-cols-2');
    // md / lg based on selection
    if(n==2){ grid.classList.add('row-cols-md-2','row-cols-lg-2'); }
    if(n==3){ grid.classList.add('row-cols-md-3','row-cols-lg-3'); }
    if(n==4){ grid.classList.add('row-cols-md-3','row-cols-lg-4'); }
    // UI state + submit preference to persist
    colBtns.forEach(b=>b.classList.remove('active'));
    document.querySelector('.js-cols-size[data-cols="'+n+'"]')?.classList.add('active');
    document.getElementById('cols').value = n;
    // No immediate submit; only when user changes other filters or reloads by pagination
  }
  colBtns.forEach(btn=>{
    btn.addEventListener('click', ()=>setCols(Number(btn.dataset.cols)));
  });
  // Initialize from query (default 4)
  setCols(Number('{{ request('cols', 4) }}'));
})();
</script>
@endpush
