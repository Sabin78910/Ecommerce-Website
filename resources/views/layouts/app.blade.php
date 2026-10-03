<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="surfside media" />

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">

    @stack('website-styles')

    <style>
        /* Keep existing search layout intact */
        #box-content-search { max-width: 23%; }
        #box-content-search li { padding: 1px; border: 1px solid #ddd; border-radius: 1px; margin-bottom: 10px; background-color: #f9f9f9; }
        #box-content-search .product-item img { width: 150px; height: 150px; }
        #box-content-search .body-text { font-size: 14px; color: #333; text-decoration: none; }
        #box-content-search .divider { height: 0; background: #e0e0e0; margin: 1px 0; }

        @media (max-width: 575px){
            #box-content-search { display:block; padding:0; margin:0; list-style:none; }
            #box-content-search li { display:flex; flex-direction:column; align-items:center; width:100%; box-sizing:border-box; padding:12px 8px; border:1px solid #ddd; border-radius:4px; margin-bottom:12px; background:#f9f9f9; text-align:center; }
            #box-content-search .product-item img { width:40px; height:40px; object-fit:cover; margin-bottom:8px; }
            #box-content-search .body-text { font-size:16px; color:#333; line-height:1.3; text-decoration:none; margin-bottom:6px; }
            #box-content-search .divider { width:90%; height:1px; background:#e0e0e0; margin:8px 0; }
        }

        #header { padding-top:8px; padding-bottom:8px; }
        .logo__image { max-width:220px; }

        /* current page highlight */
        .navigation__link.active,
        .navigation__link[aria-current="page"]{
            font-weight:700;
            color:#111 !important;
            position:relative;
        }
        .navigation__link.active::after,
        .navigation__link[aria-current="page"]::after{
            content:""; position:absolute; left:0; right:0; bottom:-6px; height:2px; background:#111;
        }

        /* Mobile auth buttons */
        .mobile-auth-actions a,
        .mobile-auth-actions button{
            display:inline-flex; align-items:center; gap:.5rem;
            padding:.5rem .75rem; border-radius:.5rem; text-decoration:none;
            border:1px solid #ddd; background:#fff; color:#111; font-weight:600;
        }
        .mobile-auth-actions a:hover,
        .mobile-auth-actions button:hover{ background:#f3f4f6; }

        /* badge positions */
        .cart-amount,
        .wishlist-amount{
            top:-6px; right:-8px; background:#111; color:#fff; font-size:11px; line-height:1;
            min-width:18px; height:18px; border-radius:9px; display:flex; align-items:center; justify-content:center;
            padding:2px 5px;
        }
    </style>
</head>

@php
    // Real counts for cart and wishlist
    $cartCount = \Cart::instance('cart')->content()->count();
    $wishCount = \Cart::instance('wishlist')->content()->count();
@endphp

<body class="gradient-bg">

    <!-- VALID SVG SPRITE (no anchors inside) -->
    <svg class="d-none" aria-hidden="true" focusable="false">
        <!-- Menu icon -->
        <symbol id="icon_nav" viewBox="0 0 25 18">
            <rect width="25" height="2" />
            <rect y="8" width="20" height="2" />
            <rect y="16" width="25" height="2" />
        </symbol>

        <!-- Search -->
        <symbol id="icon_search" viewBox="0 0 20 20">
            <g clip-path="url(#clip0_6_7)">
                <path d="M8.80758 0C3.95121 0 0 3.95121 0 8.80758C0 13.6642 3.95121 17.6152 8.80758 17.6152C13.6642 17.6152 17.6152 13.6642 17.6152 8.80758C17.6152 3.95121 13.6642 0 8.80758 0ZM8.80758 15.9892C4.84769 15.9892 1.62602 12.7675 1.62602 8.80762C1.62602 4.84773 4.84769 1.62602 8.80758 1.62602C12.7675 1.62602 15.9891 4.84769 15.9891 8.80758C15.9891 12.7675 12.7675 15.9892 8.80758 15.9892Z" fill="currentColor"/>
                <path d="M19.7618 18.6122L15.1006 13.9509C14.783 13.6333 14.2686 13.6333 13.951 13.9509C13.6334 14.2683 13.6334 14.7832 13.951 15.1005L18.6122 19.7618C18.771 19.9206 18.9789 20 19.187 20C19.3949 20 19.603 19.9206 19.7618 19.7618C20.0795 19.4444 20.0795 18.9295 19.7618 18.6122Z" fill="currentColor"/>
            </g>
            <defs><clipPath id="clip0_6_7"><rect width="20" height="20" fill="white" /></clipPath></defs>
        </symbol>

        <!-- User -->
        <symbol id="icon_user" viewBox="0 0 20 20">
            <g clip-path="url(#clip0_6_29)">
                <path d="M10 11.2652C3.99077 11.2652 0.681274 14.108 0.681274 19.2701C0.681274 19.6732 1.00803 20 1.4112 20H18.5888C18.992 20 19.3187 19.6732 19.3187 19.2701C19.3188 14.1083 16.0093 11.2652 10 11.2652ZM2.16768 18.5402C2.45479 14.6805 5.08616 12.7251 10 12.7251C14.9139 12.7251 17.5453 14.6805 17.8326 18.5402H2.16768Z" fill="currentColor" />
                <path d="M10 0C7.23969 0 5.1582 2.12336 5.1582 4.93895C5.1582 7.83699 7.33023 10.1944 10 10.1944C12.6698 10.1944 14.8419 7.83699 14.8419 4.93918C14.8419 2.12336 12.7604 0 10 0ZM10 8.7348C8.13508 8.7348 6.61805 7.03211 6.61805 4.93918C6.61805 2.92313 8.04043 1.45984 10 1.45984C11.9283 1.45984 13.382 2.95547 13.382 4.93918C13.382 7.03211 11.865 8.7348 10 8.7348Z" fill="currentColor" />
            </g>
            <defs><clipPath id="clip0_6_29"><rect width="20" height="20" fill="white" /></clipPath></defs>
        </symbol>

        <!-- Cart -->
        <symbol id="icon_cart" viewBox="0 0 20 20">
            <path d="M17.6562 4.6875H15.2755C14.9652 2.05164 12.7179 0 10 0C7.28215 0 5.0348 2.05164 4.72445 4.6875H2.34375C1.91227 4.6875 1.5625 5.03727 1.5625 5.46875V19.2188C1.5625 19.6502 1.91227 20 2.34375 20H17.6562C18.0877 20 18.4375 19.6502 18.4375 19.2188V5.46875C18.4375 5.03727 18.0877 4.6875 17.6562 4.6875ZM10 1.5625C11.8548 1.5625 13.3992 2.91621 13.6976 4.6875H6.30238C6.60082 2.91621 8.14516 1.5625 10 1.5625ZM16.875 18.4375H3.125V6.25H4.6875V8.59375C4.6875 9.02523 5.03727 9.375 5.46875 9.375C5.90023 9.375 6.25 9.02523 6.25 8.59375V6.25H13.75V8.59375C13.75 9.02523 14.0998 9.375 14.5312 9.375C14.9627 9.375 15.3125 9.02523 15.3125 8.59375V6.25H16.875V18.4375Z" fill="currentColor" />
        </symbol>

        <!-- Heart / wishlist -->
        <symbol id="icon_heart" viewBox="0 0 20 20">
            <g clip-path="url(#clip0_6_54)">
                <path d="M18.3932 3.30806C16.218 1.13348 12.6795 1.13348 10.5049 3.30806L9.99983 3.81285L9.49504 3.30806C7.32046 1.13319 3.78163 1.13319 1.60706 3.30806C-0.523361 5.43848 -0.537195 8.81542 1.57498 11.1634C3.50142 13.3041 9.18304 17.929 9.4241 18.1248C9.58775 18.2578 9.78467 18.3226 9.9804 18.3226C9.98688 18.3226 9.99335 18.3226 9.99953 18.3223C10.202 18.3317 10.406 18.2622 10.575 18.1248C10.816 17.929 16.4982 13.3041 18.4253 11.1631C20.5371 8.81542 20.5233 5.43848 18.3932 3.30806ZM17.1125 9.98188C15.6105 11.6505 11.4818 15.0919 9.99953 16.3131C8.51724 15.0922 4.38944 11.6511 2.88773 9.98218C1.41427 8.34448 1.40044 6.01214 2.85564 4.55693C3.59885 3.81402 4.57488 3.44227 5.5509 3.44227C6.52693 3.44227 7.50295 3.81373 8.24616 4.55693L9.3564 5.66718C9.48856 5.79934 9.65516 5.87822 9.82999 5.90589C10.1137 5.96682 10.4216 5.88764 10.6424 5.66747L11.7532 4.55693C13.2399 3.07082 15.6582 3.07111 17.144 4.55693C18.5992 6.01214 18.5854 8.34448 17.1125 9.98188Z" fill="currentColor" />
            </g>
            <defs><clipPath id="clip0_6_54"><rect width="20" height="20" fill="white" /></clipPath></defs>
        </symbol>

        <!-- Home + Hanger (mobile footer) -->
        <symbol id="icon_home" viewBox="0 0 18 18">
            <path d="M17.6977 8.0467L16.1771 6.66115V2.06683C16.1771 1.77451 15.9401 1.53748 15.6477 1.53748H11.9874C11.6951 1.53748 11.4581 1.77447 11.4581 2.06683V2.36123L9.62165 0.687897C9.26717 0.364846 8.73262 0.364881 8.37828 0.687862L0.302275 8.04673C0.0183538 8.30548 -0.0754781 8.70415 0.0632483 9.06236C0.20201 9.42057 0.539861 9.652 0.924012 9.652H2.21386V17.025C2.21386 17.3173 2.45085 17.5544 2.7432 17.5544H7.16983C7.46215 17.5544 7.69917 17.3174 7.69917 17.025V12.5483H10.3008V17.025C10.3008 17.3174 10.5378 17.5544 10.8301 17.5544H15.2566C15.5489 17.5544 15.7859 17.3174 15.7859 17.025V9.65204H17.076C17.4601 9.65204 17.798 9.42057 17.9368 9.0624C18.0755 8.70415 17.9817 8.30548 17.6977 8.0467Z" fill="currentColor" />
        </symbol>

        <symbol id="icon_hanger" viewBox="0 0 18 18">
            <path d="M16.8037 12.0285L11.9362 9.10027C11.2525 8.68897 10.492 8.42791 9.70506 8.32972V7.59625C9.70506 7.18302 9.94168 6.79836 10.3225 6.59223C11.2687 6.08013 11.8258 5.09383 11.7763 4.01814C11.7108 2.59335 10.5588 1.43964 9.13226 1.37414C7.53307 1.30122 6.2246 2.5744 6.2246 4.14846C6.2246 4.53683 6.53949 4.85159 6.92772 4.85159C7.31609 4.85159 7.63085 4.53683 7.63085 4.14846C7.63085 3.37008 8.2778 2.74249 9.06758 2.77888C9.76659 2.81101 10.3394 3.38381 10.3715 4.08282C10.3961 4.61483 10.1208 5.10249 9.65302 5.35558C8.81778 5.80767 8.29881 6.66625 8.29881 7.59625V8.32931C7.51521 8.42654 6.75743 8.6854 6.07559 9.09341L1.20123 12.0104C0.461305 12.4532 0.000978114 13.2638 1.68088e-05 14.1261C-0.00149381 15.4906 1.1014 16.5962 2.46604 16.5979L15.5281 16.6131C16.8911 16.6131 17.9984 15.5074 18 14.147C18.001 13.2848 17.5426 12.4729 16.8037 12.0285ZM15.5299 15.2069L2.46782 15.1916C1.8817 15.191 1.40558 14.7137 1.40627 14.1278C1.40668 13.7566 1.60484 13.4076 1.92331 13.217L6.79767 10.3001C8.15613 9.48713 9.85324 9.48837 11.2113 10.3052L16.0789 13.2335C16.3968 13.4248 16.5942 13.7743 16.5938 14.1453C16.5931 14.7309 16.1165 15.2069 15.5311 15.2069H15.5299Z" fill="currentColor" />
        </symbol>

        <!-- Social -->
        <symbol id="icon_facebook" viewBox="0 0 9 15">
            <path d="M7.62891 8.31543L8.01172 5.7998H5.57812V4.15918C5.57812 3.44824 5.90625 2.79199 7 2.79199H8.12109V0.631836C8.12109 0.631836 7.10938 0.44043 6.15234 0.44043C4.15625 0.44043 2.84375 1.6709 2.84375 3.8584V5.7998H0.601562V8.31543H2.84375V14.4404H5.57812V8.31543H7.62891Z" fill="currentColor"/>
        </symbol>
        <symbol id="icon_twitter" viewBox="0 0 14 13">
            <path d="M12.5508 3.59668C13.0977 3.18652 13.5898 2.69434 13.9727 2.12012C13.4805 2.33887 12.9062 2.50293 12.332 2.55762C12.9336 2.20215 13.3711 1.65527 13.5898 0.97168C13.043 1.2998 12.4141 1.5459 11.7852 1.68262C11.2383 1.1084 10.5 0.780273 9.67969 0.780273C8.09375 0.780273 6.80859 2.06543 6.80859 3.65137C6.80859 3.87012 6.83594 4.08887 6.89062 4.30762C4.51172 4.1709 2.37891 3.02246 0.957031 1.2998C0.710938 1.70996 0.574219 2.20215 0.574219 2.74902C0.574219 3.7334 1.06641 4.6084 1.85938 5.12793C1.39453 5.10059 0.929688 4.99121 0.546875 4.77246V4.7998C0.546875 6.19434 1.53125 7.34277 2.84375 7.61621C2.625 7.6709 2.35156 7.72559 2.10547 7.72559C1.91406 7.72559 1.75 7.69824 1.55859 7.6709C1.91406 8.81934 2.98047 9.63965 4.23828 9.66699C3.25391 10.4326 2.02344 10.8975 0.683594 10.8975C0.4375 10.8975 0.21875 10.8701 0 10.8428C1.25781 11.6631 2.76172 12.1279 4.40234 12.1279C9.67969 12.1279 12.5508 7.78027 12.5508 3.97949C12.5508 3.84277 12.5508 3.7334 12.5508 3.59668Z" fill="currentColor"/>
        </symbol>
        <symbol id="icon_instagram" viewBox="0 0 14 13">
            <path d="M7.125 3.2959C5.375 3.2959 3.98047 4.71777 3.98047 6.44043C3.98047 8.19043 5.375 9.58496 7.125 9.58496C8.84766 9.58496 10.2695 8.19043 10.2695 6.44043C10.2695 4.71777 8.84766 3.2959 7.125 3.2959ZM7.125 8.49121C6.00391 8.49121 5.07422 7.58887 5.07422 6.44043C5.07422 5.31934 5.97656 4.41699 7.125 4.41699C8.24609 4.41699 9.14844 5.31934 9.14844 6.44043C9.14844 7.58887 8.24609 8.49121 7.125 8.49121ZM11.1172 3.18652C11.1172 2.77637 10.7891 2.44824 10.3789 2.44824C9.96875 2.44824 9.64062 2.77637 9.64062 3.18652C9.64062 3.59668 9.96875 3.9248 10.3789 3.9248C10.7891 3.9248 11.1172 3.59668 11.1172 3.18652Z" fill="currentColor"/>
        </symbol>
        <symbol id="icon_tiktok" viewBox="0 0 448 512">
            <path fill="currentColor" d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z" />
        </symbol>
        <symbol id="icon_youtube" viewBox="0 0 16 11">
            <path d="M15.0117 1.8584C14.8477 1.20215 14.3281 0.682617 13.6992 0.518555C12.5234 0.19043 7.875 0.19043 7.875 0.19043C7.875 0.19043 3.19922 0.19043 2.02344 0.518555C1.39453 0.682617 0.875 1.20215 0.710938 1.8584C0.382812 3.00684 0.382812 5.46777 0.382812 5.46777C0.382812 5.46777 0.382812 7.90137 0.710938 9.07715C0.875 9.7334 1.39453 10.2256 2.02344 10.3896C3.19922 10.6904 7.875 10.6904 7.875 10.6904C7.875 10.6904 12.5234 10.6904 13.6992 10.3896C14.3281 10.2256 14.8477 9.7334 15.0117 9.07715C15.3398 7.90137 15.3398 5.46777 15.3398 5.46777C15.3398 5.46777 15.3398 3.00684 15.0117 1.8584ZM6.34375 7.68262V3.25293L10.2266 5.46777L6.34375 7.68262Z" fill="currentColor" />
        </symbol>
    </svg>

    <!-- MOBILE HEADER -->
    <div class="header-mobile header_sticky">
        <div class="container d-flex align-items-center h-100">
            <a class="mobile-nav-activator d-block position-relative" href="#">
                <svg class="nav-icon" width="25" height="18" viewBox="0 0 25 18"><use href="#icon_nav"/></svg>
                <button class="btn-close-lg position-absolute top-0 start-0 w-100"></button>
            </a>

            <div class="logo">
                <a href="{{ route('home.index') }}">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Uomo" class="logo__image d-block" />
                </a>
            </div>

            <!-- Mobile account icon -->
            <a href="{{ Auth::check() ? (Auth::user()->usertype === 'admin' ? route('admin.index') : route('user.index')) : route('login') }}"
               class="header-tools__item ms-auto me-3">
                <svg class="d-block" width="20" height="20" viewBox="0 0 20 20"><use href="#icon_user"/></svg>
            </a>

            <!-- Mobile cart -->
            <a href="#" class="header-tools__item header-tools__cart js-open-aside"
               data-aside="cartDrawer"
               onclick="window.location='{{ route('cart.index') }}'; return false;">
                <svg class="d-block" width="20" height="20" viewBox="0 0 20 20"><use href="#icon_cart"/></svg>
                @if($cartCount > 0)
                    <span class="cart-amount d-block position-absolute js-cart-items-count">{{ $cartCount }}</span>
                @endif
            </a>
        </div>

        <nav class="header-mobile__navigation navigation d-flex flex-column w-100 position-absolute top-100 bg-body overflow-auto">
            <div class="container">
                <!-- MOBILE SEARCH (unchanged IDs/structure) -->
                <form action="#" method="GET" class="search-field position-relative mt-4 mb-3">
                    <div class="position-relative">
                        <input class="search-field__input w-100 border rounded-1" type="text"
                               name="search-keyword" placeholder="Search products" id="mobilesearch-input" />
                        <button class="btn-icon search-popup__submit pb-0 me-2" type="submit">
                            <svg class="d-block" width="20" height="20"><use href="#icon_search"/></svg>
                        </button>
                        <button class="btn-icon btn-close-lg search-popup__reset pb-0 me-2" type="reset"></button>
                    </div>
                    <div class="search-popup__results">
                        <ul id="box-content-search-mob"></ul>
                        <div class="search-result row row-cols-5"></div>
                    </div>
                </form>
            </div>

            <div class="container">
                <div class="overflow-hidden">
                    <ul class="navigation__list list-unstyled position-relative">
                        <!-- Account/Login in the nav list (mobile) -->
                        @guest
                            <li class="navigation__item">
                                <a href="{{ route('login') }}" class="navigation__link">
                                    <svg width="16" height="16" class="me-1 align-text-bottom"><use href="#icon_user"/></svg>
                                    Login
                                </a>
                            </li>
                            @if(Route::has('register'))
                                <li class="navigation__item">
                                    <a href="{{ route('register') }}" class="navigation__link">
                                        <i class="fa fa-user-plus me-1"></i> Register
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="navigation__item">
                                <a href="{{ Auth::user()->usertype === 'admin' ? route('admin.index') : route('user.index') }}"
                                   class="navigation__link">
                                    <svg width="16" height="16" class="me-1 align-text-bottom"><use href="#icon_user"/></svg>
                                    My Account
                                </a>
                            </li>
                        @endguest

                        <li class="navigation__item">
                            <a href="{{ route('home.index') }}" class="navigation__link {{ request()->routeIs('home.index') ? 'active' : '' }}" aria-current="{{ request()->routeIs('home.index') ? 'page' : 'false' }}">Home</a>
                        </li>
                        <li class="navigation__item">
                            <a href="{{ route('shop.index') }}" class="navigation__link {{ request()->routeIs('shop.index','shop.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('shop.index','shop.*') ? 'page' : 'false' }}">Shop</a>
                        </li>
                        <li class="navigation__item">
                            <a href="{{ route('cart.index') }}" class="navigation__link {{ request()->routeIs('cart.index') ? 'active' : '' }}" aria-current="{{ request()->routeIs('cart.index') ? 'page' : 'false' }}">Cart</a>
                        </li>
                        <li class="navigation__item">
                            <a href="{{ route('terms') }}" class="navigation__link {{ request()->routeIs('terms') ? 'active' : '' }}">Terms &amp; Policies</a>
                        </li>
                        <li class="navigation__item">
                            <a href="{{ route('refund') }}" class="navigation__link {{ request()->routeIs('refund') ? 'active' : '' }}">Refund &amp; Cancellation</a>
                        </li>
                        <li class="navigation__item">
                            <a href="{{ route('faqs') }}" class="navigation__link {{ request()->routeIs('faqs') ? 'active' : '' }}">FAQs</a>
                        </li>
                        <li class="navigation__item">
                            <a href="{{ route('contact') }}" class="navigation__link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a>
                        </li>
                        <li class="navigation__item">
                            <a href="{{ route('about') }}" class="navigation__link {{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-top mt-auto pb-2 pt-3">
                <!-- Bottom mobile auth actions -->
                @guest
                    <div class="container mobile-auth-actions d-flex align-items-center gap-2 mt-2 mb-3">
                        <a href="{{ route('login') }}"><svg width="18" height="18"><use href="#icon_user"/></svg><span>Login</span></a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"><i class="fa fa-user-plus"></i><span>Register</span></a>
                        @endif
                    </div>
                @else
                    <div class="container mobile-auth-actions d-flex align-items-center gap-2 mt-2 mb-3">
                        <a href="{{ Auth::user()->usertype === 'admin' ? route('admin.index') : route('user.index') }}"><svg width="18" height="18"><use href="#icon_user"/></svg><span>My Account</span></a>
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button type="submit"><i class="fa fa-sign-out-alt"></i><span>Logout</span></button>
                        </form>
                    </div>
                @endguest
            </div>
        </nav>
    </div>

    <!-- DESKTOP HEADER -->
    <header id="header" class="header header-fullwidth header-transparent-bg">
        <div class="container">
            <div class="header-desk header-desk_type_1">
                <div class="logo">
                    <a href="{{ route('home.index') }}">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Uomo" class="logo__image d-block" />
                    </a>
                </div>

                <nav class="navigation">
                    <ul class="navigation__list list-unstyled d-flex">
                        <li class="navigation__item">
                            <a href="{{ route('home.index') }}" class="navigation__link {{ request()->routeIs('home.index') ? 'active' : '' }}" aria-current="{{ request()->routeIs('home.index') ? 'page' : 'false' }}">Home</a>
                        </li>
                        <li class="navigation__item">
                            <a href="{{ route('shop.index') }}" class="navigation__link {{ request()->routeIs('shop.index','shop.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('shop.index','shop.*') ? 'page' : 'false' }}">Shop</a>
                        </li>
                        <li class="navigation__item">
                            <a href="{{ route('cart.index') }}" class="navigation__link {{ request()->routeIs('cart.index') ? 'active' : '' }}" aria-current="{{ request()->routeIs('cart.index') ? 'page' : 'false' }}">Cart</a>
                        </li>
                    </ul>
                </nav>

                <div class="header-tools d-flex align-items-center">
                    <!-- DESKTOP SEARCH (unchanged) -->
                    <div class="header-tools__item hover-container">
                        <div class="js-hover__open position-relative">
                            <a class="js-search-popup search-field__actor" href="#">
                                <svg class="d-block" width="20" height="20" viewBox="0 0 20 20"><use href="#icon_search"/></svg>
                                <i class="btn-icon btn-close-lg"></i>
                            </a>
                        </div>
                        <div class="search-popup js-hidden-content">
                            <form action="#" method="GET" class="search-field container">
                                <p class="text-uppercase text-secondary fw-medium mb-4">What are you looking for?</p>
                                <div class="position-relative">
                                    <input class="search-field__input search-popup__input w-100 fw-medium" type="text" name="search-keyword" placeholder="Search products" id="search-input" />
                                    <button class="btn-icon search-popup__submit" type="submit">
                                        <svg class="d-block" width="20" height="20"><use href="#icon_search"/></svg>
                                    </button>
                                    <button class="btn-icon btn-close-lg search-popup__reset" type="reset"></button>
                                </div>
                                <div class="search-popup__results">
                                    <ul id="box-content-search"></ul>
                                    <div class="search-result row row-cols-5"></div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @guest
                        <div class="header-tools__item hover-container">
                            <a href="{{ route('login') }}" class="header-tools__item" title="Login">
                                <svg class="d-block" width="20" height="20"><use href="#icon_user"/></svg>
                            </a>
                        </div>
                        @if (Route::has('register'))
                            <div class="header-tools__item hover-container ms-2">
                                <a href="{{ route('register') }}" class="header-tools__item" title="Register">
                                    <i class="fa fa-user-plus"></i>
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="header-tools__item hover-container">
                            <a href="{{ Auth::user()->usertype === 'admin' ? route('admin.index') : route('user.index') }}" class="header-tools__item">
                                <span class="pr-6px">{{ Auth::user()->name }}</span>
                                <svg class="d-block" width="20" height="20"><use href="#icon_user"/></svg>
                            </a>
                        </div>
                    @endguest

                    <a href="{{ route('wishlist.index') }}" class="header-tools__item header-tools__cart" title="Wishlist">
                        <svg width="20" height="20"><use href="#icon_heart"/></svg>
                        @if($wishCount > 0)
                            <span class="cart-amount d-block position-absolute js-cart-items-count">{{ $wishCount }}</span>
                        @endif
                    </a>

                    <a href="{{ route('cart.index') }}" class="header-tools__item header-tools__cart" title="Cart">
                        <svg class="d-block" width="20" height="20"><use href="#icon_cart"/></svg>
                        @if($cartCount > 0)
                            <span class="cart-amount d-block position-absolute js-cart-items-count">{{ $cartCount }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div style="height: 50px;"></div>
    @yield('website-content')

    <hr class="mt-5 text-secondary" />

    <!-- FOOTER -->
    <footer class="footer footer_type_2 bg-light pt-4">
        <div class="container">
            <span class="d-block text-center font-weight-bold my-2">
                ©2025–{{ date('Y') }} N &amp; S Handicrafts<br>All rights reserved.
            </span>

            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4 px-3 mb-4 mb-md-0">
                        <h6 class="font-weight-bold">Quick Links</h6>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('terms') }}" class="text-secondary">Terms &amp; Policies</a></li>
                            <li><a href="{{ route('refund') }}" class="text-secondary">Refund &amp; Cancellation</a></li>
                            <li><a href="{{ route('faqs') }}" class="text-secondary">FAQs</a></li>
                            <li><a href="{{ route('contact') }}" class="text-secondary">Contact Us</a></li>
                            <li><a href="{{ route('about') }}" class="text-secondary">About Us</a></li>
                        </ul>
                    </div>

                    <div class="col-12 col-md-4 px-3 mb-4 mb-md-0 text-center">
                        <h6 class="font-weight-bold">Follow Us</h6>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="https://facebook.com/YourPage" target="_blank" rel="noopener" class="text-secondary"><svg width="24" height="24"><use href="#icon_facebook" /></svg><span class="visually-hidden">Facebook</span></a></li>
                            <li class="list-inline-item"><a href="https://twitter.com/YourHandle" target="_blank" rel="noopener" class="text-secondary"><svg width="24" height="24"><use href="#icon_twitter" /></svg><span class="visually-hidden">Twitter</span></a></li>
                            <li class="list-inline-item"><a href="https://instagram.com/YourProfile" target="_blank" rel="noopener" class="text-secondary"><svg width="24" height="24"><use href="#icon_instagram" /></svg><span class="visually-hidden">Instagram</span></a></li>
                            <li class="list-inline-item"><a href="https://www.tiktok.com/@YourProfile" target="_blank" rel="noopener" class="text-secondary"><svg width="24" height="24"><use href="#icon_tiktok" /></svg><span class="visually-hidden">TikTok</span></a></li>
                            <li class="list-inline-item"><a href="https://youtube.com/YourChannel" target="_blank" rel="noopener" class="text-secondary"><svg width="24" height="24"><use href="#icon_youtube" /></svg><span class="visually-hidden">YouTube</span></a></li>
                        </ul>
                    </div>

                    <div class="col-12 col-md-4 px-3 text-md-end">
                        <h6 class="font-weight-bold">Our Location</h6>
                        <p class="mb-1"><a href="https://maps.app.goo.gl/Bk9a5XjuGUSDQdQNA" target="_blank" rel="noopener noreferrer" class="text-secondary">123 Kathmandu St., Thamel, Kathmandu, Nepal</a></p>
                        <p class="mb-1">Contact: <a href="tel:+977123456789" class="text-secondary">+977-123-456789</a></p>
                        <p class="mb-0">Email: <a href="mailto:info@handicraft.com" class="text-secondary">info@handicraft.com</a></p>
                    </div>
                </div>
            </div>
    </footer>

    <!-- MOBILE FOOTER QUICK NAV -->
    <footer class="footer-mobile container w-100 px-5 d-md-none bg-body">
        <div class="row text-center">
            <div class="col-4">
                <a href="{{ route('home.index') }}" class="footer-mobile__link d-flex flex-column align-items-center {{ request()->routeIs('home.index') ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 18 18"><use href="#icon_home" /></svg>
                    <span>Home</span>
                </a>
            </div>
            <div class="col-4">
                <a href="{{ route('shop.index') }}" class="footer-mobile__link d-flex flex-column align-items-center {{ request()->routeIs('shop.index','shop.*') ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 18 18"><use href="#icon_hanger" /></svg>
                    <span>Shop</span>
                </a>
            </div>
            <div class="col-4">
                <a href="{{ route('wishlist.index') }}" class="footer-mobile__link d-flex flex-column align-items-center">
                    <div class="position-relative">
                        <svg width="18" height="18" viewBox="0 0 20 20"><use href="#icon_heart" /></svg>
                        @if($wishCount > 0)
                            <span class="wishlist-amount d-block position-absolute js-wishlist-count">{{ $wishCount }}</span>
                        @endif
                    </div>
                    <span>Wishlist</span>
                </a>
            </div>
        </div>
    </footer>

    <div id="scrollTop" class="visually-hidden end-0"></div>
    <div class="page-overlay"></div>

    <!-- SCRIPTS (SEARCH LOGIC UNCHANGED) -->
    <script src="{{ asset('assets/js/plugins/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/swiper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/countdown.js') }}"></script>

    <script>
        $(function() {
            $("#search-input").on("keyup", function() {
                var searchQuery = $(this).val();
                if (searchQuery.length > 2) {
                    $.ajax({
                        type: "GET",
                        url: "/search",
                        data: { query: searchQuery },
                        dataType: 'json',
                        success: function(data) {
                            $("#box-content-search").html('');
                            $.each(data, function(index, item) {
                                var url = "{{ route('shop.product.details', ['product_slug' => 'product_slug_pls']) }}";
                                var link = url.replace('product_slug_pls', item.slug);
                                $("#box-content-search").append(`
                                    <li style="list-style: none; margin-bottom: 10px;">
                                        <div onclick="window.location.href='${link}'"
                                            style="display: flex; align-items: center; justify-content: space-between; border: 1px solid #ddd; border-radius: 5px; padding: 10px; background-color: #f9f9f9; cursor: pointer; transition: background-color 0.3s;">
                                            <div style="flex-shrink: 0; margin-right: 10px;">
                                                <img src="{{ asset('uploads/products') }}/${item.image}" alt="${item.name}"
                                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                                            </div>
                                            <div style="flex-grow: 1;">
                                                <span style="font-size: 14px; color: #333;">${item.name}</span>
                                            </div>
                                        </div>
                                    </li>
                                `);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching search results:", error);
                        }
                    });
                }
            });
        });

        $(function() {
            $("#mobilesearch-input").on("keyup", function() {
                var searchQuery = $(this).val();
                if (searchQuery.length > 2) {
                    $.ajax({
                        type: "GET",
                        url: "/search",
                        data: { query: searchQuery },
                        dataType: 'json',
                        success: function(data) {
                            $("#box-content-search-mob").html('');
                            $.each(data, function(index, item) {
                                var url = "{{ route('shop.product.details', ['product_slug' => 'product_slug_pls']) }}";
                                var link = url.replace('product_slug_pls', item.slug);
                                $("#box-content-search-mob").append(`
                                    <li style="list-style: none; margin-bottom: 10px;">
                                        <div onclick="window.location.href='${link}'"
                                            style="display: flex; align-items: center; justify-content: space-between; border: 1px solid #ddd; border-radius: 5px; padding: 10px; background-color: #f9f9f9; cursor: pointer; transition: background-color 0.3s;">
                                            <div style="flex-shrink: 0; margin-right: 10px;">
                                                <img src="{{ asset('uploads/products') }}/${item.image}" alt="${item.name}"
                                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                                            </div>
                                            <div style="flex-grow: 1;">
                                                <span style="font-size: 14px; color: #333;">${item.name}</span>
                                            </div>
                                        </div>
                                    </li>
                                `);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching search results:", error);
                        }
                    });
                }
            });
        });
    </script>

    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('website-script')
</body>
</html>

