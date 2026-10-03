@extends('layouts.app')

@section('website-content')
    <style>
        /* ===== Cart Page — scoped styles for this view ===== */
        :root{
            --c-bg:#f7f7f9;
            --c-card:#ffffff;
            --c-text:#111827;
            --c-muted:#6b7280;
            --c-border:#e5e7eb;
            --c-brand:#6a6e51; /* your theme */
        }
        .pt-90{padding-top:90px!important;}
        .cart-page{background:var(--c-bg);}
        .page-title{font-weight:800;letter-spacing:.3px;color:var(--c-text);margin-bottom:12px;}

        /* Stepper */
        .checkout-steps{display:grid;gap:10px;grid-template-columns:repeat(3,minmax(0,1fr));margin-bottom:18px;}
        .checkout-steps__item{display:flex;gap:10px;align-items:center;text-decoration:none;background:var(--c-card);border:1px solid var(--c-border);border-radius:12px;padding:10px 12px;color:var(--c-text);box-shadow:0 6px 18px rgba(17,24,39,.05);}
        .checkout-steps__item-number{display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:10px;font-weight:800;background:#eef2ff;color:#3730a3;}
        .checkout-steps__item-title span{font-weight:800;display:block;line-height:1.1;}
        .checkout-steps__item-title em{font-style:normal;color:var(--c-muted);font-size:.85rem;}
        .checkout-steps__item.active{border-color:var(--c-brand);box-shadow:0 10px 26px rgba(106,110,81,.18);}

        /* Cards / Table wrappers */
        .cart-wrap{background:var(--c-card);border:1px solid var(--c-border);border-radius:16px;box-shadow:0 10px 26px rgba(17,24,39,.06);overflow:hidden;}
        .cart-table{width:100%;table-layout:auto;border-collapse:separate;border-spacing:0;}
        .cart-table thead th{background:var(--c-brand);color:#fff;text-transform:uppercase;font-size:.85rem;letter-spacing:.3px;font-weight:800;border:none!important;padding:12px 14px;white-space:nowrap;}
        .cart-table tbody td{vertical-align:middle;padding:14px;border-top:1px solid var(--c-border)!important;color:var(--c-text);background:#fff;}
        .cart-row{transition:background .15s ease;}
        .cart-row:hover{background:#fafafa;}
        .cart-item{display:flex;gap:12px;align-items:center;}
        .cart-thumb{width:80px;height:80px;border-radius:12px;overflow:hidden;flex:0 0 auto;border:1px solid var(--c-border);background:#fff;}
        .cart-thumb img{width:100%;height:100%;object-fit:cover;display:block;}
        .cart-title{margin:0;font-weight:800;font-size:1rem;color:var(--c-text);line-height:1.25;}
        .cart-options{margin:6px 0 0;padding:0;list-style:none;color:var(--c-muted);font-size:.9rem;}
        .cart-price,.cart-subtotal{font-weight:800;}

        /* LOCK column widths to avoid overlap */
        .col-qty{min-width: 220px; width: 220px;}
        .col-sub{min-width: 160px;}
        .col-actions{min-width: 120px; width: 120px;}
        .cart-table td.col-qty, .cart-table th.col-qty,
        .cart-table td.col-sub, .cart-table th.col-sub,
        .cart-table td.col-actions, .cart-table th.col-actions{white-space:nowrap;}

        /* ===== Quantity control — NO OVERLAP ===== */
        .qty-control{
            display:grid;
            grid-template-columns:44px minmax(72px,1fr) 44px;
            align-items:center;
            gap:8px;
            max-width: 220px; /* prevents bleeding into subtotal */
        }
        .qty-control *{position:static!important;} /* neutralize theme absolute rules */
        .qty-control form{margin:0;}
        .qty-control__number{
            width:100%;
            height:44px;
            border:1px solid var(--c-border);
            border-radius:10px;
            text-align:center;
            font-weight:700;
            color:var(--c-text);
            background:#fff;
            -moz-appearance: textfield;
        }
        .qty-control__number::-webkit-outer-spin-button,
        .qty-control__number::-webkit-inner-spin-button{ -webkit-appearance: none; margin: 0; }
        .qty-btn{
            width:44px;height:44px;border-radius:10px;border:1px solid var(--c-border);
            background:#fff;color:#111;font-weight:900;font-size:18px;line-height:1;
            display:flex;align-items:center;justify-content:center;
            cursor:pointer;transition:background .15s ease, transform .05s ease;
        }
        .qty-btn:hover{background:#f3f4f6;}
        .qty-btn:active{transform:scale(.98);}

        /* Footer under table */
        .cart-table-footer{display:flex;gap:12px;flex-wrap:wrap;justify-content:space-between;align-items:center;padding:12px;border-top:1px solid var(--c-border);background:#fafafa;}
        .coupon-form{position:relative;display:flex;gap:8px;width:100%;max-width:520px;background:#fff;border:1px solid var(--c-border);border-radius:12px;padding:6px;}
        .coupon-form .form-control{border:none;outline:none;height:42px;border-radius:8px;background:transparent;}
        .coupon-form .btn-apply{white-space:nowrap;height:42px;border-radius:8px;border:1px solid var(--c-border);background:#fff;padding:0 14px;font-weight:700;}
        .coupon-form .btn-apply.remove{background:#ef4444;color:#fff;border-color:#ef4444;}
        .btn-clear{border:1px solid var(--c-border);background:#fff;color:#111;font-weight:700;height:42px;border-radius:10px;padding:0 14px;}
        .btn-clear:hover{background:#f3f4f6;}

        /* Totals card (sticky on lg) */
        .totals-wrap{background:var(--c-card);border:1px solid var(--c-border);border-radius:16px;box-shadow:0 10px 26px rgba(17,24,39,.06);}
        .shopping-cart__totals{padding:16px;}
        .shopping-cart__totals h3{font-weight:800;margin:4px 0 12px;}
        .cart-totals{width:100%;}
        .cart-totals th,.cart-totals td{padding:10px 0;border-bottom:1px dashed var(--c-border);color:var(--c-text);}
        .cart-totals th{font-weight:700;}
        .cart-totals tr:last-child th,.cart-totals tr:last-child td{border-bottom:none;}
        .btn-checkout{display:block;width:100%;height:48px;font-weight:800;letter-spacing:.2px;border-radius:12px;}
        .sticky-content{position:sticky;top:90px;}

        /* Mobile cards */
        .cart-mobile{display:grid;gap:12px;}
        .cm-card{display:grid;grid-template-columns:92px 1fr;gap:12px;border:1px solid var(--c-border);background:#fff;border-radius:16px;padding:12px;box-shadow:0 8px 22px rgba(17,24,39,.06);}
        .cm-title{margin:0 0 2px;font-weight:800;}
        .cm-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center;font-size:.95rem;}
        .cm-price,.cm-sub{font-weight:800;}
        .cm-actions{display:flex;gap:8px;flex-wrap:wrap;}
        .btn-remove{border:1px solid var(--c-border);background:#fff;color:#ef4444;font-weight:700;border-radius:10px;padding:8px 12px;}
        .btn-keep{border:1px solid var(--c-border);background:#fff;color:#111;font-weight:700;border-radius:10px;padding:8px 12px;}

        /* Mobile quantity safety */
        .cm-card .qty-control{
            grid-template-columns:36px minmax(56px,1fr) 36px;
            max-width: 168px;
            width:100%;
        }
        .cm-card .qty-btn{width:36px;height:36px;}
        .cm-card .qty-control__number{height:36px;}

        /* Empty state */
        .empty-state{background:#fff;border:1px solid var(--c-border);border-radius:16px;padding:26px 18px;text-align:center;box-shadow:0 10px 26px rgba(17,24,39,.06);}
        .empty-icon{width:56px;height:56px;border-radius:12px;background:#fff;border:1px solid var(--c-border);display:flex;align-items:center;justify-content:center;margin:0 auto 8px;}

        /* Layout */
        @media (min-width: 992px){.cart-grid{display:grid;grid-template-columns:minmax(0,1fr) 360px;gap:16px;}}
        @media (max-width: 767.98px){.cart-table__wrapper{display:none;}}
        @media (min-width: 768px){.cart-mobile{display:none;}}

        /* >>> Small right gap for the actions cell (desktop/tablet only) <<< */
        @media (min-width: 768px){
            .cart-table td.col-actions{ padding-right: 18px; } /* little breathing room on the right */
        }
    </style>

    <main class="pt-90 cart-page">
        <div class="mb-3"></div>

        <section class="shop-checkout container">
            <h2 class="page-title">Cart</h2>

            <div class="checkout-steps">
                <a href="javascript:void(0)" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Shopping Bag</span>
                        <em>Manage Your Items List</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Shipping & Checkout</span>
                        <em>Checkout Your Items List</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Confirmation</span>
                        <em>Review & Submit Your Order</em>
                    </span>
                </a>
            </div>

            <div class="cart-grid">
                <div>
                    @if ($items->count() > 0)
                        <!-- ===== Desktop / Tablet Table ===== -->
                        <div class="cart-wrap cart-table__wrapper mb-3">
                            <table class="cart-table">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th></th>
                                    <th>Price</th>
                                    <th class="col-qty">Quantity</th>
                                    <th class="col-sub">Subtotal</th>
                                    <th class="col-actions"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($items as $item)
                                    <tr class="cart-row">
                                        <td>
                                            <div class="cart-item">
                                                <div class="cart-thumb">
                                                    <img
                                                        src="{{ asset('uploads/products/' . ($item->options->image ?? '')) }}"
                                                        alt="{{ $item->name }}"
                                                        loading="lazy"
                                                        onerror="this.src='{{ asset('assets/images/placeholder.png') }}'">
                                                </div>
                                                <div>
                                                    <h4 class="cart-title">{{ $item->name }}</h4>
                                                    @if(!empty($item->options))
                                                        <ul class="cart-options">
                                                            @if(isset($item->options->color)) <li>Color: {{ $item->options->color }}</li> @endif
                                                            @if(isset($item->options->size))  <li>Size: {{ $item->options->size }}</li>  @endif
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td><span class="cart-price">Rs. {{ $item->price }}</span></td>

                                        <td class="col-qty">
                                            <div class="qty-control">
                                                <form method="POST" action="{{ route('cart.quantity.decrease', ['rowId' => $item->rowId]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="qty-btn" aria-label="Decrease quantity">−</button>
                                                </form>

                                                <input type="number" name="quantity" value="{{ $item->qty }}" min="1"
                                                       class="qty-control__number text-center" readonly>

                                                <form method="POST" action="{{ route('cart.quantity.increase', ['rowId' => $item->rowId]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="qty-btn" aria-label="Increase quantity">+</button>
                                                </form>
                                            </div>
                                        </td>

                                        <td class="col-sub"><span class="cart-subtotal">Rs. {{ $item->subTotal() }}</span></td>

                                        <td class="col-actions">
                                            <form method="POST" action="{{ route('cart.delete', ['rowId' => $item->rowId]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-remove">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="cart-table-footer">
                                @if (!Session::has('discounts'))
                                    <form action="{{ route('cart.apply.coupon') }}" method="POST" class="coupon-form">
                                        @csrf
                                        <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code">
                                        <button type="submit" class="btn-apply">APPLY COUPON</button>
                                    </form>
                                @else
                                    <form action="{{ route('cart.remove.coupon') }}" method="POST" class="coupon-form">
                                        @csrf
                                        @method('DELETE')
                                        <input class="form-control" type="text" name="coupon_code"
                                               value="@if (Session::has('coupon')) {{ Session::get('coupon')['code'] }} Applied! @endif" readonly>
                                        <button type="submit" class="btn-apply remove">REMOVE COUPON</button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('cart.clear') }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-clear" type="submit">Clear Cart</button>
                                </form>
                            </div>

                            <div class="p-3">
                                @if (Session::has('success'))
                                    <p class="text-success mb-0">{{ Session::get('success') }}</p>
                                @elseif(Session::has('error'))
                                    <p class="text-danger mb-0">{{ Session::get('error') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- ===== Mobile Cards ===== -->
                        <div class="cart-mobile mb-3">
                            @foreach ($items as $item)
                                <div class="cm-card">
                                    <div class="cart-thumb">
                                        <img
                                            src="{{ asset('uploads/products/' . ($item->options->image ?? '')) }}"
                                            alt="{{ $item->name }}"
                                            loading="lazy"
                                            onerror="this.src='{{ asset('assets/images/placeholder.png') }}'">
                                    </div>
                                    <div>
                                        <h5 class="cm-title">{{ $item->name }}</h5>
                                        @if(!empty($item->options))
                                            <div class="cm-row" style="color:var(--c-muted);">
                                                @if(isset($item->options->color)) <span>Color: {{ $item->options->color }}</span> @endif
                                                @if(isset($item->options->size))  <span>Size: {{ $item->options->size }}</span>  @endif
                                            </div>
                                        @endif

                                        <div class="cm-row">
                                            <span class="cm-price">Rs. {{ $item->price }}</span>
                                        </div>

                                        <div class="cm-row" style="gap:12px;">
                                            <span>Qty</span>
                                            <div class="qty-control">
                                                <form method="POST" action="{{ route('cart.quantity.decrease', ['rowId' => $item->rowId]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="qty-btn" aria-label="Decrease quantity">−</button>
                                                </form>

                                                <input type="number" class="qty-control__number text-center" value="{{ $item->qty }}" readonly>

                                                <form method="POST" action="{{ route('cart.quantity.increase', ['rowId' => $item->rowId]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="qty-btn" aria-label="Increase quantity">+</button>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="cm-row">
                                            <span class="cm-sub">Subtotal: Rs. {{ $item->subTotal() }}</span>
                                        </div>

                                        <div class="cm-actions">
                                            <form method="POST" action="{{ route('cart.delete', ['rowId' => $item->rowId]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-remove" style="margin-right: 5px;">Remove</button>
                                            </form>
                                            <a href="{{ route('shop.index') }}" class="btn-keep">Keep Shopping</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="cart-wrap p-3">
                                @if (!Session::has('discounts'))
                                    <form action="{{ route('cart.apply.coupon') }}" method="POST" class="coupon-form">
                                        @csrf
                                        <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code">
                                        <button type="submit" class="btn-apply">APPLY COUPON</button>
                                    </form>
                                @else
                                    <form action="{{ route('cart.remove.coupon') }}" method="POST" class="coupon-form mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <input class="form-control" type="text" name="coupon_code"
                                               value="@if (Session::has('coupon')) {{ Session::get('coupon')['code'] }} Applied! @endif" readonly>
                                        <button type="submit" class="btn-apply remove">REMOVE COUPON</button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('cart.clear') }}" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-clear w-100" type="submit">Clear Cart</button>
                                </form>

                                <div class="mt-2">
                                    @if (Session::has('success'))
                                        <p class="text-success mb-0">{{ Session::get('success') }}</p>
                                    @elseif(Session::has('error'))
                                        <p class="text-danger mb-0">{{ Session::get('error') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- ===== Empty State ===== -->
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg width="22" height="22" viewBox="0 0 20 20" aria-hidden="true">
                                    <use href="#icon_cart"></use>
                                </svg>
                            </div>
                            <h5 class="mb-1" style="font-weight:800;">Your cart is empty</h5>
                            <p class="mb-3" style="color:var(--c-muted);">Add items to get started.</p>
                            <a href="{{ route('shop.index') }}" class="btn btn-primary">Shop Now</a>
                        </div>
                    @endif
                </div>

                @if ($items->count() > 0)
                    <!-- ===== Totals / Checkout ===== -->
                    <div class="totals-wrap">
                        <div class="sticky-content">
                            <div class="shopping-cart__totals">
                                <h3>Cart Totals</h3>

                                @if (Session::has('discounts'))
                                    <table class="cart-totals">
                                        <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td class="text-end">Rs. {{ Cart::instance('cart')->subtotal() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Discount ({{ Session::get('coupon')['code'] }})</th>
                                            <td class="text-end">− Rs. {{ Session::get('discounts')['discount'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Subtotal After Discount</th>
                                            <td class="text-end">Rs. {{ Session::get('discounts')['subtotal'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pre-estimated VAT</th>
                                            <td class="text-end">Rs. {{ Session::get('discounts')['tax'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pre-estimated Total</th>
                                            <td class="text-end fw-bold">Rs. {{ Session::get('discounts')['total'] }}</td>
                                        </tr>
                                        <tr><th>Shipping</th><td class="text-end">Estimation needed</td></tr>
                                        <tr><th>Shipping VAT</th><td class="text-end">Estimation needed</td></tr>
                                        <tr><th>Final VAT</th><td class="text-end">Estimation needed</td></tr>
                                        <tr><th>Final Total</th><td class="text-end">Estimation needed</td></tr>
                                        </tbody>
                                    </table>
                                @else
                                    <table class="cart-totals">
                                        <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td class="text-end">Rs. {{ Cart::instance('cart')->subtotal() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pre-estimated VAT</th>
                                            <td class="text-end">Rs. {{ Cart::instance('cart')->tax() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pre-estimated Total</th>
                                            <td class="text-end fw-bold">Rs. {{ Cart::instance('cart')->total() }}</td>
                                        </tr>
                                        <tr><th>Shipping</th><td class="text-end">Estimation needed</td></tr>
                                        <tr><th>Shipping VAT</th><td class="text-end">Estimation needed</td></tr>
                                        <tr><th>Final VAT</th><td class="text-end">Estimation needed</td></tr>
                                        <tr><th>Final Total</th><td class="text-end">Estimation needed</td></tr>
                                        </tbody>
                                    </table>
                                @endif
                            </div>

                            <div class="p-3 pt-0">
                                <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-checkout">
                                    PROCEED TO CHECKOUT
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <div class="mb-4 pb-2"></div>
    </main>
@endsection

@push('website-script')
    <script>
        // No extra JS needed; +/- submit via forms already wired to your routes.
    </script>
@endpush
