{{-- resources/views/shop/checkout/order-received.blade.php --}}
@extends('layouts.app')

@push('website-styles')
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

  /* Stepper (same style you used on checkout) */
  .checkout-steps{display:grid;gap:10px;grid-template-columns:repeat(3,minmax(0,1fr));margin-bottom:18px}
  .checkout-steps__item{display:flex;gap:10px;align-items:center;text-decoration:none;background:var(--c-card);border:1px solid var(--c-border);border-radius:12px;padding:10px 12px;color:var(--c-text);box-shadow:0 6px 18px rgba(17,24,39,.05)}
  .checkout-steps__item-number{display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:10px;font-weight:800;background:#eef2ff;color:#3730a3}
  .checkout-steps__item-title span{font-weight:800;display:block;line-height:1.1}
  .checkout-steps__item-title em{font-style:normal;color:var(--c-muted);font-size:.85rem}
  .checkout-steps__item.active{border-color:var(--c-brand);box-shadow:0 10px 26px rgba(106,110,81,.18)}

  /* Two-column layout */
  .order-layout{display:grid;grid-template-columns:minmax(0,1fr);gap:16px}
  @media (min-width: 992px){ .order-layout{grid-template-columns:minmax(0,1fr) 420px} }

  /* Left column (message + top facts) */
  .left-card{
    background:var(--c-card);border:1px solid var(--c-border);border-radius:var(--radius);
    box-shadow:var(--shadow);padding:18px
  }
  .order-complete__message h3{font-weight:800;margin-top:12px;margin-bottom:6px}
  .order-complete__message p{color:var(--c-muted);margin:0}

  .info-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;margin-top:16px}
  @media (max-width:575.98px){ .info-grid{grid-template-columns:1fr} }
  .info-item{background:#fafafa;border:1px dashed var(--c-border);border-radius:12px;padding:12px}
  .info-item label{display:block;font-size:.8rem;color:var(--c-muted);margin-bottom:2px}
  .info-item span{font-weight:700}

  /* Right column (single card like checkout sidebar) */
  .order-sidebar{position:static}
  @media (min-width: 992px){ .order-sidebar{position:sticky; top:90px} }
  .order-card{
    background:var(--c-card);border:1px solid var(--c-border);border-radius:var(--radius);
    box-shadow:var(--shadow);overflow:visible
  }
  .order-card__section{padding:16px}
  .order-card__section + .order-card__section{border-top:1px solid var(--c-border)}
  .order-title{font-weight:800;margin:4px 0 8px}

  /* Tables (same as checkout) */
  .checkout-cart-items,
  .checkout-totals{width:100%}
  .checkout-cart-items{border-collapse:separate;border-spacing:0}
  .checkout-cart-items thead tr{background:var(--c-brand);color:#fff}
  .checkout-cart-items thead th{padding:12px;border:none;background:transparent;color:#fff}
  .checkout-cart-items thead th:first-child{border-top-left-radius:10px}
  .checkout-cart-items thead th:last-child{border-top-right-radius:10px}
  .checkout-cart-items tbody td,
  .checkout-totals td,.checkout-totals th{padding:10px 0;border-bottom:1px dashed var(--c-border);vertical-align:top}
  .checkout-cart-items tbody tr:last-child td{border-bottom:none}
  .checkout-totals tr:last-child td,.checkout-totals tr:last-child th{border-bottom:none}

  .final-note{
    margin:0;color:var(--c-muted);background:#f9fafb;border:1px dashed var(--c-border);
    border-radius:12px;padding:12px;overflow-wrap:anywhere
  }
</style>
@endpush

@section('website-content')
<main class="pt-90" style="background:var(--c-bg);">
  <div class="mb-4 pb-4"></div>

  <section class="shop-checkout container">
    <h2 class="page-title">Order Received</h2>

    <div class="checkout-steps">
      <a href="javascript:void(0)" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">01</span>
        <span class="checkout-steps__item-title"><span>Shopping Bag</span><em>Manage Your Items List</em></span>
      </a>
      <a href="javascript:void(0)" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">02</span>
        <span class="checkout-steps__item-title"><span>Shipping & Checkout</span><em>Checkout Your Items List</em></span>
      </a>
      <a href="javascript:void(0)" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">03</span>
        <span class="checkout-steps__item-title"><span>Confirmation</span><em>Review & Submit Your Order</em></span>
      </a>
    </div>

    <div class="order-layout">
      {{-- LEFT: success + quick facts --}}
      <div class="left-card">
        <div class="order-complete__message text-center">
          <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="40" cy="40" r="40" fill="#B9A16B" />
            <path d="M52.9743 35.7612c0-.4186-.1674-.8371-.4687-1.1384l-2.2768-2.2768a1.6 1.6 0 0 0-2.262-0l-11.0 10.999-4.922-4.939a1.61 1.61 0 0 0-2.262 0l-2.2768 2.2768a1.61 1.61 0 0 0 0 2.2768l6.0603 6.0603 2.2768 2.2768a1.61 1.61 0 0 0 2.2768 0l2.2767-2.2768 12.121-12.1205c.3013-.3014.4687-.7199.4687-1.1385Z" fill="#fff"/>
          </svg>
          <h3>Your order is completed!</h3>
          <p>Thank you. Your order has been received.</p>
        </div>

        <div class="info-grid">
          <div class="info-item">
            <label>Order Number</label>
            <span>#{{ $order->id }}</span>
          </div>
          <div class="info-item">
            <label>Date</label>
            <span>{{ $order->created_at->format('d M Y, g:i a') }}</span>
          </div>
          <div class="info-item">
            <label>Total</label>
            <span>Rs. {{ number_format($order->pre_estimated_total, 2) }}</span>
          </div>
          <div class="info-item">
            <label>Payment Method</label>
            <span>{{ $order->transactions->mode }}</span>
          </div>
        </div>
      </div>

      {{-- RIGHT: single card with everything (no overflow) --}}
      <aside class="order-sidebar">
        <div class="order-card">
          <div class="order-card__section">
            <h3 class="order-title">Order Details</h3>

            <table class="checkout-cart-items mb-3">
              <thead>
                <tr>
                  <th>PRODUCT</th>
                  <th class="text-end">SUBTOTAL</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($order->orderItem as $item)
                  <tr>
                    <td>{{ $item->product->name }} x {{ $item->quantity }}</td>
                    <td class="text-end">
                      Rs. {{ number_format((float) str_replace(',', '', $item->price) * $item->quantity, 2) }}
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>

            <table class="checkout-totals">
              <tbody>
                <tr>
                  <th>Subtotal</th>
                  <td class="text-end">Rs. {{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                  <th>Discount</th>
                  <td class="text-end">Rs. {{ number_format($order->discount, 2) }}</td>
                </tr>
                <tr>
                  <th>Pre-Estimated VAT</th>
                  <td class="text-end">Rs. {{ number_format($order->pre_estimated_tax, 2) }}</td>
                </tr>
                <tr>
                  <th>Pre-Estimated Total</th>
                  <td class="text-end fw-bold">Rs. {{ number_format($order->pre_estimated_total, 2) }}</td>
                </tr>
                <tr>
                  <th>Shipping Charge</th>
                  <td class="text-end">Estimation Needed</td>
                </tr>
                <tr>
                  <th>Shipping VAT</th>
                  <td class="text-end">Estimation Needed</td>
                </tr>
                <tr>
                  <th>Final VAT</th>
                  <td class="text-end">Estimation Needed</td>
                </tr>
                <tr>
                  <th>Final Total</th>
                  <td class="text-end">Estimation Needed</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="order-card__section">
            <p class="final-note text-center">
              Final total will be quoted after we calculate shipping charges for your order.
              You’ll receive the final quotation by email once the estimate is complete —
              this may take <strong>1–3 working days</strong>. Thank you for shopping with us!
            </p>
          </div>
        </div>
      </aside>
    </div>
  </section>
</main>
@endsection
