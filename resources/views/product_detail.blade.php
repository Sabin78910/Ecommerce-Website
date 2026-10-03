@extends('layouts.app')

@section('website-content')
    <main class="pt-90">
        <div class="mb-md-1 pb-md-3"></div>

        <section class="product-single container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="product-single__media" data-media-type="vertical-thumbnail">
                        <div class="product-single__image">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide product-single__image-item">
                                        <img loading="lazy" class="h-auto"
                                            src="{{ asset('uploads/products/' . $product->image) }}" width="674"
                                            height="674" alt="{{ $product->name }}" />
                                        <a data-fancybox="gallery" href="{{ asset('uploads/products/' . $product->image) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_zoom" />
                                            </svg>
                                        </a>
                                    </div>
                                    @foreach (explode(',', $product->images) as $image)
                                        <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="h-auto"
                                                src="{{ asset('uploads/products/' . $image) }}" width="674"
                                                height="674" alt="{{ $product->name }}" />
                                            <a data-fancybox="gallery" href="{{ asset('uploads/products/' . $image) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_zoom" />
                                                </svg>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-prev">
                                    <svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_sm" />
                                    </svg>
                                </div>
                                <div class="swiper-button-next">
                                    <svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_sm" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="product-single__thumbnail">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide product-single__image-item">
                                        <img loading="lazy" class="h-auto"
                                            src="{{ asset('uploads/products/' . $product->image) }}" width="104"
                                            height="104" alt="" />
                                    </div>
                                    @foreach (explode(',', $product->images) as $image)
                                        <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="h-auto"
                                                src="{{ asset('uploads/products/' . $image) }}" width="104"
                                                height="104" alt="" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="d-flex justify-content-between mb-4 pb-md-2">
                        <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                            <a href="{{ route('home.index') }}"
                                class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                            <a href="{{ route('shop.index') }}"
                                class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                        </div>
                        <div
                            class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                            <a href="#" class="text-uppercase fw-medium">
                                <svg width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_prev_md" />
                                </svg>
                                <span class="menu-link menu-link_us-s">Prev</span>
                            </a>
                            <a href="#" class="text-uppercase fw-medium">
                                <span class="menu-link menu-link_us-s">Next</span>
                                <svg width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_next_md" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <h1 class="product-single__name">{{ $product->name }}</h1>

                    <div class="product-single__price">
                        <span class="current-price">
                            @if ($product->sales_price)
                                <s>Rs. {{ $product->regular_price }}</s> Rs. {{ $product->sales_price }}
                            @else
                                Rs. {{ $product->regular_price }}
                            @endif
                        </span>
                    </div>

                    <div class="product-single__short-desc">
                        <p>{{ $product->short_description }}</p>
                    </div>

                    @if (Cart::instance('cart')->content()->where('id', $product->id)->count() > 0)
                        <a href="{{ route('cart.index') }}" class="btn btn-warning mb-3">Go to Cart</a>
                    @else
                        <form name="addtocart-form" method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <div class="product-single__addtocart">
                                <div class="qty-control position-relative">
                                    <input type="number" name="quantity" value="1" min="1"
                                        class="qty-control__number text-center">
                                    <div class="qty-control__reduce">-</div>
                                    <div class="qty-control__increase">+</div>
                                </div>
                                <input type="hidden" name="id" value="{{ $product->id }}" />
                                <input type="hidden" name="name" value="{{ $product->name }}" />
                                <input type="hidden" name="image" value="{{ $product->image }}" />
                                <input type="hidden" name="price"
                                    value="{{ $product->sales_price == '' ? $product->regular_price : $product->sales_price }}" />
                                <button type="submit" class="btn btn-primary btn-addtocart" data-aside="cartDrawer">Add
                                    to Cart</button>
                            </div>
                        </form>
                    @endif

                    <div class="product-single__addtolinks">
                        @if (Cart::instance('wishlist')->content()->where('id', $product->id)->count() > 0)
                            <form name="removetowishlist-form" method="POST"
                                action="{{ route('wishlist.delete', ['rowId' => Cart::instance('wishlist')->content()->where('id', $product->id)->first()->rowId]) }}"
                                id="removetowishlist-form">
                                @csrf
                                @method('DELETE')
                                <a href="#" class="menu-link menu-link_us-s add-to-wishlist"
                                    onclick="event.preventDefault(); document.getElementById('removetowishlist-form').submit();"
                                    style="color: red;">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_heart" />
                                    </svg>
                                    <span>Remove From Wishlist</span>
                                </a>
                            </form>
                        @else
                            <form name="addtowishlist-form" id="addtowishlist-form" method="POST"
                                action="{{ route('wishlist.add') }}">
                                @csrf
                                <a href="#" class="menu-link menu-link_us-s add-to-wishlist"
                                    onclick="event.preventDefault(); document.getElementById('addtowishlist-form').submit();">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_heart" />
                                    </svg>
                                    <span>Add to Wishlist</span>
                                </a>
                                <input type="hidden" name="id" value="{{ $product->id }}" />
                                <input type="hidden" name="name" value="{{ $product->name }}" />
                                <input type="hidden" name="image" value="{{ $product->image }}" />
                                <input type="hidden" name="quantity" value="1" />
                                <input type="hidden" name="price"
                                    value="{{ $product->sales_price == '' ? $product->regular_price : $product->sales_price }}" />
                            </form>
                        @endif

                        <share-button class="share-button">
                            <button type="button"
                                class="menu-link menu-link_us-s to-share border-0 bg-transparent d-flex align-items-center"
                                data-bs-toggle="modal" data-bs-target="#shareModal">
                                <svg width="16" height="19" viewBox="0 0 16 19" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_sharing" />
                                </svg>
                                <span>Share</span>
                            </button>
                            <details id="Details-share-template__main" hidden>
                                <summary class="btn-solid pt-3.5 pb-3 px-5">+</summary>
                                <div id="Article-share-template__main"
                                    class="share-button__fallback flex items-center absolute top-full left-0 w-full px-2 py-4 bg-container shadow-theme border-t z-10">
                                    <div class="field grow mr-4">
                                        <label class="field__label sr-only" for="url">Link</label>
                                        <input type="text" class="field__input w-full" id="url"
                                            value="{{ url()->current() }}" placeholder="Link" onclick="this.select();"
                                            readonly>
                                    </div>
                                    <button class="share-button__copy">
                                        <svg class="icon icon-clipboard inline-block mr-1" width="11" height="13"
                                            viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2 1a1 1 0 011-1h7a1 1 0 011 1v9a1 1 0 01-1 1V1H2zM1 2a1 1 0 00-1 1v9a1 1 0 001 1h7a1 1 0 001-1V3a1 1 0 00-1-1H1zm0 10V3h7v9H1z"
                                                fill="currentColor" />
                                        </svg>
                                        <span class="sr-only">Copy link</span>
                                    </button>
                                </div>
                            </details>
                        </share-button>

                        <script src="{{ asset('js/details-disclosure.js') }}" defer></script>
                        <script src="{{ asset('js/share.js') }}" defer></script>
                    </div>

                    <div class="product-single__meta-info">
                        <div class="meta-item"><label>SKU:</label><span>{{ $product->SKU }}</span></div>
                        <div class="meta-item"><label>Categories:</label><span>{{ $product->category->name }}</span></div>
                        <div class="meta-item"><label>Tags:</label><span>{{ $product->brand->name }}</span></div>
                    </div>
                </div>
            </div>

            <div class="product-single__details-tab">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab"
                            href="#tab-description" role="tab" aria-controls="tab-description"
                            aria-selected="true">Description</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-description" role="tabpanel"
                        aria-labelledby="tab-description-tab">
                        <div class="product-single__description">
                            <h3 class="block-title mb-4">{{ $product->short_description }}</h3>
                            <p class="content">{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="products-carousel container">
            <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Related <strong>Products</strong></h2>
            <div id="related_products" class="position-relative">
                <div class="swiper-container js-swiper-slider"
                    data-settings='{
                "autoplay": false,
                "slidesPerView": 4,
                "slidesPerGroup": 4,
                "effect": "none",
                "loop": true,
                "pagination": {
                    "el": "#related_products .products-pagination",
                    "type": "bullets",
                    "clickable": true
                },
                "navigation": {
                    "nextEl": "#related_products .products-carousel__next",
                    "prevEl": "#related_products .products-carousel__prev"
                },
                "breakpoints": {
                    "320": {
                        "slidesPerView": 2,
                        "slidesPerGroup": 2,
                        "spaceBetween": 14
                    },
                    "768": {
                        "slidesPerView": 3,
                        "slidesPerGroup": 3,
                        "spaceBetween": 24
                    },
                    "992": {
                        "slidesPerView": 4,
                        "slidesPerGroup": 4,
                        "spaceBetween": 30
                    }
                }
            }'>
                    <div class="swiper-wrapper">
                        @foreach ($otherProducts as $other)
                            <div class="swiper-slide product-card">
                                <div class="pc__img-wrapper">
                                    <a href="{{ route('shop.product.details', ['product_slug' => $other->slug]) }}">
                                        <img loading="lazy" src="{{ asset('uploads/products/' . $other->image) }}"
                                            width="330" height="400" alt="{{ $other->name }}" class="pc__img">
                                        @foreach (explode(',', $other->images) as $image)
                                            <img loading="lazy" src="{{ asset('uploads/products/' . $image) }}"
                                                width="330" height="400" alt="{{ $other->name }}"
                                                class="pc__img pc__img-second">
                                        @endforeach
                                    </a>

                                    @if (Cart::instance('cart')->content()->where('id', $other->id)->count() > 0)
                                        <a href="{{ route('cart.index') }}"
                                            class="pc__atc btn anim_appear-bottom position-absolute border-0 text-uppercase fw-medium btn-warning mb-3">Go
                                            to Cart</a>
                                    @else
                                        <form name="addtocart-form" method="POST" action="{{ route('cart.add') }}">
                                            @csrf
                                            <button type="submit"
                                                class="pc__atc btn anim_appear-bottom position-absolute border-0 text-uppercase fw-medium"
                                                data-aside="cartDrawer">Add To Cart</button>
                                            <input type="hidden" name="id" value="{{ $other->id }}">
                                            <input type="hidden" name="name" value="{{ $other->name }}">
                                            <input type="hidden" name="image" value="{{ $other->image }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="price"
                                                value="{{ $other->sales_price == '' ? $other->regular_price : $other->sales_price }}">
                                        </form>
                                    @endif
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">{{ $other->category->name }}</p>
                                    <h6 class="pc__title"><a
                                            href="{{ route('shop.product.details', ['product_slug' => $other->slug]) }}">{{ $other->name }}</a>
                                    </h6>
                                    <div class="product-card__price d-flex">
                                        <span class="money price">
                                            @if ($product->sales_price)
                                                <s>Rs. {{ $other->regular_price }}</s> Rs. {{ $product->sales_price }}
                                            @else
                                                Rs. {{ $other->regular_price }}
                                            @endif
                                        </span>
                                    </div>

                                    @if (Cart::instance('wishlist')->content()->where('id', $other->id)->count() > 0)
                                        <button
                                            class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                            title="Remove From Wishlist" type="submit"
                                            style="background-color: red; color: white;">
                                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart" />
                                            </svg>
                                            <span>Remove From Wishlist</span>
                                        </button>
                                    @else
                                        <form name="addtowishlist-form" method="POST"
                                            action="{{ route('wishlist.add') }}">
                                            @csrf
                                            <button
                                                class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                                title="Add To Wishlist" type="submit">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                                <span>Add To Wishlist</span>
                                            </button>
                                            <input type="hidden" name="id" value="{{ $other->id }}">
                                            <input type="hidden" name="name" value="{{ $other->name }}">
                                            <input type="hidden" name="image" value="{{ $other->image }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="price"
                                                value="{{ $other->sales_price == '' ? $other->regular_price : $other->sales_price }}">
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div
                    class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_prev_md" />
                    </svg>
                </div>
                <div
                    class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_next_md" />
                    </svg>
                </div>

                <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
            </div>
        </section>
        <!-- Share URL Modal -->
        <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shareModalLabel">Share this page</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="shareUrl" class="form-label">Page URL</label>
                        <div class="input-group">
                            <input type="text" id="shareUrl" class="form-control" readonly>
                            <button class="btn btn-outline-secondary" type="button" id="copyShareUrl">Copy</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const shareModal = document.getElementById('shareModal');
                shareModal.addEventListener('show.bs.modal', function() {
                    document.getElementById('shareUrl').value = window.location.href;
                });

                document.getElementById('copyShareUrl').addEventListener('click', function() {
                    const input = document.getElementById('shareUrl');
                    input.select();
                    input.setSelectionRange(0, 99999); // for mobile
                    navigator.clipboard.writeText(input.value)
                        .then(() => {
                            // optional: give feedback
                            this.textContent = 'Copied!';
                            setTimeout(() => this.textContent = 'Copy', 2000);
                        })
                        .catch(() => {
                            alert('Could not copy, please copy manually.');
                        });
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="…"></script>

    </main>
@endsection
