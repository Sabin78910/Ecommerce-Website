@extends('layouts.app')

@section('website-content')
    <style>
        /* ===== Wishlist Page — scoped styles ===== */
        :root {
            --wl-bg: #f7f7f9;
            --wl-card: #ffffff;
            --wl-text: #1f2937;
            --wl-muted: #6b7280;
            --wl-border: #e5e7eb;
            --wl-brand: #6a6e51; /* matches your theme */
            --wl-accent: #0d6efd;
            --wl-danger: #ef4444;
            --wl-warning: #f59e0b;
            --wl-success: #10b981;
        }

        .pt-90 { padding-top: 90px !important; }

        .wishlist-page {
            background: var(--wl-bg);
        }

        .wishlist-heading {
            display: flex;
            align-items: center;
            gap: .6rem;
            font-weight: 800;
            letter-spacing: .5px;
            color: var(--wl-text);
            margin-bottom: 1rem;
        }
        .wishlist-heading .heart {
            display: inline-flex;
            width: 40px; height: 40px; border-radius: 12px;
            align-items: center; justify-content: center;
            background: var(--wl-card);
            border: 1px solid var(--wl-border);
            box-shadow: 0 2px 10px rgba(17,24,39,.06);
        }

        .wishlist-wrap {
            border-radius: 16px;
            background: var(--wl-card);
            box-shadow: 0 8px 26px rgba(17,24,39,.06);
            border: 1px solid var(--wl-border);
            overflow: hidden;
        }

        /* Table (md and up) */
        .wishlist-table thead th {
            background: var(--wl-brand);
            color: #fff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .3px;
            font-size: .85rem;
            border: none !important;
            padding: 12px 16px;
        }
        .wishlist-table td {
            vertical-align: middle;
            padding: 14px 16px;
            color: var(--wl-text);
            border-color: var(--wl-border) !important;
        }
        .wishlist-table .item-cell {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .wishlist-thumb {
            width: 72px;
            height: 72px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--wl-border);
            background: #fff;
            flex: 0 0 auto;
        }
        .wishlist-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .wishlist-title {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.3;
            color: var(--wl-text);
        }
        .wishlist-price {
            font-weight: 800;
            color: var(--wl-text);
        }
        .wishlist-qty {
            font-weight: 600;
            color: var(--wl-muted);
        }

        /* Buttons */
        .btn-wl-cart {
            background: var(--wl-warning);
            border: none;
            color: #111827;
            font-weight: 700;
        }
        .btn-wl-cart:hover {
            filter: brightness(.95);
        }
        .btn-wl-remove {
            background: transparent;
            border: 1px solid var(--wl-border);
            color: var(--wl-danger);
            font-weight: 700;
        }
        .btn-wl-remove:hover {
            background: rgba(239, 68, 68, .06);
        }
        .btn-wl-clear {
            border: 1px solid var(--wl-border);
            background: #fff;
            color: var(--wl-text);
            font-weight: 700;
        }
        .btn-wl-clear:hover { background: #f3f4f6; }

        /* Empty state */
        .empty-state {
            background: var(--wl-card);
            border: 1px solid var(--wl-border);
            border-radius: 16px;
            padding: 32px 18px;
            text-align: center;
            box-shadow: 0 8px 26px rgba(17,24,39,.06);
        }
        .empty-state h5 {
            font-weight: 800;
            color: var(--wl-text);
        }
        .empty-state p { color: var(--wl-muted); }

        /* Card list (mobile) */
        .wishlist-cards .wl-card {
            display: grid;
            grid-template-columns: 84px 1fr;
            gap: 12px;
            border: 1px solid var(--wl-border);
            background: var(--wl-card);
            border-radius: 16px;
            padding: 12px;
            box-shadow: 0 6px 20px rgba(17,24,39,.06);
        }
        .wl-card + .wl-card { margin-top: 12px; }
        .wl-card .wl-meta {
            display: grid;
            grid-template-columns: 1fr;
            gap: 6px;
        }
        .wl-meta .wl-row {
            display: flex; flex-wrap: wrap; gap: 8px; align-items: center;
            font-size: .95rem;
        }
        .wl-actions {
            display: flex; gap: 8px; flex-wrap: wrap;
        }

        /* Utility */
        .shadow-soft { box-shadow: 0 8px 26px rgba(17,24,39,.06); }
        .badge-muted {
            background: #eef2ff; color: #3730a3; font-weight: 700;
            border: 1px solid #e5e7eb;
        }

        /* Spacing tweaks */
        .wishlist-topbar {
            display: flex; gap: 10px; flex-wrap: wrap;
            align-items: center; justify-content: space-between;
            margin-bottom: 12px;
        }

        /* Responsive switches */
        @media (max-width: 767.98px) {
            .wishlist-table-wrap { display: none; }
        }
        @media (min-width: 768px) {
            .wishlist-cards { display: none; }
        }
    </style>

    <main class="pt-90 wishlist-page">
        <div class="mb-3"></div>
        <section class="container">
            <div class="wishlist-topbar">
                <h2 class="wishlist-heading">
                    <span class="heart">
                        <svg width="18" height="18" viewBox="0 0 20 20" aria-hidden="true">
                            <use href="#icon_heart"></use>
                        </svg>
                    </span>
                    Wishlist
                </h2>

                @if ($items->count() > 0)
                    <form method="POST" action="{{ route('wishlist.clear') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-wl-clear">
                            Clear Wishlist
                        </button>
                    </form>
                @endif
            </div>

            @if (session('status'))
                <div class="alert alert-success shadow-soft mb-3">{{ session('status') }}</div>
            @endif

            @if ($items->count() > 0)
                <!-- ===== Desktop / Tablet: Table ===== -->
                <div class="wishlist-wrap wishlist-table-wrap table-responsive mb-4">
                    <table class="table wishlist-table mb-0">
                        <thead>
                            <tr>
                                <th style="width: 48%;">Product</th>
                                <th style="width: 14%;">Price</th>
                                <th style="width: 12%;">Quantity</th>
                                <th style="width: 26%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>
                                        <div class="item-cell">
                                            <div class="wishlist-thumb">
                                                <img
                                                    src="{{ asset('uploads/products/' . ($item->options->image ?? '')) }}"
                                                    alt="{{ $item->name }}"
                                                    loading="lazy"
                                                    onerror="this.src='{{ asset('assets/images/placeholder.png') }}'">
                                            </div>
                                            <div>
                                                <h4 class="wishlist-title">{{ $item->name }}</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="wishlist-price">Rs. {{ $item->price }}</span>
                                    </td>
                                    <td>
                                        <span class="wishlist-qty">x {{ $item->qty }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2">
                                            <form method="POST"
                                                  action="{{ route('wishlist.move.to.cart', ['rowId' => $item->rowId]) }}">
                                                @csrf
                                                <button class="btn btn-sm btn-wl-cart" type="submit">
                                                    Add to Cart
                                                </button>
                                            </form>

                                            <form method="POST"
                                                  action="{{ route('wishlist.delete', ['rowId' => $item->rowId]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-wl-remove js-remove">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- ===== Mobile: Cards ===== -->
                <div class="wishlist-cards mb-4">
                    @foreach ($items as $item)
                        <div class="wl-card">
                            <div class="wishlist-thumb">
                                <img
                                    src="{{ asset('uploads/products/' . ($item->options->image ?? '')) }}"
                                    alt="{{ $item->name }}"
                                    loading="lazy"
                                    onerror="this.src='{{ asset('assets/images/placeholder.png') }}'">
                            </div>

                            <div class="wl-meta">
                                <div class="wl-row">
                                    <h5 class="wishlist-title mb-0">{{ $item->name }}</h5>
                                </div>
                                <div class="wl-row">
                                    <span class="badge badge-muted">Rs. {{ $item->price }}</span>
                                    <span class="badge bg-light text-dark border">{{ $item->qty }} pcs</span>
                                </div>
                                <div class="wl-actions">
                                    <form method="POST"
                                          action="{{ route('wishlist.move.to.cart', ['rowId' => $item->rowId]) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-wl-cart" type="submit">
                                            Add to Cart
                                        </button>
                                    </form>

                                    <form method="POST"
                                          action="{{ route('wishlist.delete', ['rowId' => $item->rowId]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-wl-remove js-remove">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex gap-2 flex-wrap justify-content-between align-items-center mb-5">
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">
                        Continue Shopping
                    </a>

                    <a href="{{ route('cart.index') }}" class="btn btn-primary">
                        Go to Cart
                    </a>
                </div>
            @else
                <!-- ===== Empty state ===== -->
                <div class="empty-state">
                    <div class="d-flex flex-column align-items-center gap-2">
                        <div class="heart" style="width:56px;height:56px;">
                            <svg width="22" height="22" viewBox="0 0 20 20" aria-hidden="true">
                                <use href="#icon_heart"></use>
                            </svg>
                        </div>
                        <h5 class="mt-2 mb-1">Your wishlist is empty</h5>
                        <p class="mb-3">Save items you love and move them to cart anytime.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-primary">
                            Browse Products
                        </a>
                    </div>
                </div>
            @endif
        </section>
        <div class="mb-4 pb-2"></div>
    </main>
@endsection

@push('website-script')
    <script>
        // Submit the corresponding delete form for "Remove" buttons
        $(function () {
            $('.js-remove').on('click', function () {
                $(this).closest('form').submit();
            });
        });
    </script>
@endpush

