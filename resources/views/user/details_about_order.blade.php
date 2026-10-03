@extends('layouts.app')

@section('website-content')
<style>
  /* ========= Accessible Colors & Surfaces ========= */
  :root{
    --brand:#6a6e51;      /* Header bars / accents */
    --ink:#111827;        /* Main text (near-black) */
    --muted:#4b5563;      /* Secondary text */
    --ring:#e5e7eb;       /* Subtle borders */
    --surface:#ffffff;    /* Card/page bg */
    --surface-2:#f8fafc;  /* Pale background surface */
    --shadow:0 1px 2px rgba(0,0,0,.04), 0 10px 25px rgba(0,0,0,.06);

    --success:#16a34a;
    --danger:#dc2626;
    --warning:#f59e0b;
    --info:#0284c7;
    --primary:#2563eb;
  }

  /* Prevent theme gradients from washing out content */
  .gradient-bg .my-account, .my-account { color: var(--ink); }
  .my-account a { color: inherit; }

  .pt-90{padding-top:90px!important;}

  /* Page shell */
  .page-wrap{
    background:var(--surface)!important;
    color:var(--ink)!important;
    border:1px solid var(--ring);
    border-radius:16px;
    box-shadow:var(--shadow);
    padding:clamp(16px,2vw,24px);
  }
  .page-title{
    font-weight:800; letter-spacing:.2px; color:var(--ink); margin:0;
  }
  .page-subtitle{ color:var(--muted); font-size:.95rem; }

  /* Small chips with good contrast */
  .chip{
    display:inline-flex; align-items:center; gap:.5rem;
    background:var(--surface-2); color:var(--ink);
    border:1px solid var(--ring); border-radius:999px;
    padding:.35rem .6rem; font-size:.8rem;
  }
  .orderno{
    background:#111827; color:#fff; border-radius:.5rem;
    padding:.28rem .5rem; font-size:.78rem; font-weight:700;
  }

  /* Progress stepper (wraps nicely on mobile) */
  .stepper{
    display:flex; flex-wrap:wrap; gap:.6rem 1rem; padding:.75rem 0 .25rem 0;
  }
  .step{
    display:flex; align-items:center; gap:.6rem; color:var(--muted); font-weight:700;
    background:var(--surface-2); border:1px solid var(--ring); border-radius:999px; padding:.35rem .7rem;
  }
  .step .dot{
    width:20px; height:20px; border-radius:50%;
    border:2px solid var(--ring); background:#fff; display:grid; place-items:center;
    font-size:.75rem; line-height:1; color:var(--ink);
  }
  .step.done{ color:#14532d; }
  .step.done .dot{ background:#dcfce7; border-color:#86efac; }
  .step.current{ color:#0c4a6e; }
  .step.current .dot{ background:#e0f2fe; border-color:#7dd3fc; }
  .step.canceled{ color:#7f1d1d; }
  .step.canceled .dot{ background:#fee2e2; border-color:#fecaca; }

  /* Card */
  .cardx{
    background:#fff !important; color:var(--ink) !important;
    border:1px solid var(--ring); border-radius:14px;
    box-shadow:var(--shadow); overflow:hidden;
  }
  .cardx .cardx-h{
    padding:.85rem 1rem; border-bottom:1px solid var(--ring);
    font-weight:800; color:#fff; background:var(--brand);
  }
  .cardx .cardx-b{ padding: 1rem; }

  /* Status badges with clear contrast */
  .badge-status{ font-weight:800; padding:.5em .75em; border-radius:999px; }
  .badge-ordered{ background:#e5e7eb; color:#111827; }
  .badge-estimated{ background:#cffafe; color:#0c4a6e; }
  .badge-payment_completed{ background:#dbeafe; color:#1e3a8a; }
  .badge-payment_verified{ background:#dcfce7; color:#166534; }
  .badge-processing{ background:#fef9c3; color:#854d0e; }
  .badge-shipping{ background:#e0f2fe; color:#075985; }
  .badge-delivered{ background:#dcfce7; color:#166534; }
  .badge-canceled, .badge-returned{ background:#fee2e2; color:#7f1d1d; }
  .badge-other{ background:#f3f4f6; color:#111827; }

  /* Table → always white cards, strong headers, readable striping */
  .tablex{ border:1px solid var(--ring); border-radius:12px; overflow:hidden; background:#fff !important; }
  .tablex thead th{
    background:var(--brand)!important; color:#fff!important; border-color:var(--brand)!important;
    font-weight:700; vertical-align:middle;
  }
  .tablex td,.tablex th{ padding:.8rem 1rem; vertical-align:middle; color:var(--ink)!important; background:#fff; }
  .table-striped>tbody>tr:nth-of-type(odd)>*{
    --bs-table-accent-bg:#fafafa !important;
    color:var(--ink)!important;
  }
  .table-bordered>:not(caption)>*{ border-width:inherit; border-color:var(--ring); }

  /* Mobile table → stack into cards with SOLID white bg & borders */
  @media (max-width: 991.98px){
    .tablex thead{ display:none; }
    .tablex tbody tr{
      display:block; background:#fff!important; border:1px solid var(--ring);
      border-radius:14px; margin-bottom:.9rem; box-shadow:var(--shadow); overflow:hidden;
    }
    .tablex tbody td{
      display:flex; gap:12px; justify-content:space-between; align-items:center;
      border-bottom:1px dashed #eaeaea; padding:.8rem 1rem; background:#fff!important; color:var(--ink)!important;
    }
    .tablex tbody td:last-child{ border-bottom:0; }
    .tablex tbody td::before{
      content: attr(data-label);
      font-weight:700; color: var(--muted); min-width: 44%;
    }
  }

  .item-thumb{
    width:56px; height:56px; border-radius:10px; object-fit:cover;
    border:1px solid var(--ring); background:#fff;
  }
  .money{ white-space:nowrap; font-weight:800; color:var(--ink); }
  .muted{ color:var(--muted); }
  .btn-soft{
    background:#f8fafc; border:1px solid var(--ring); color:#111827; font-weight:600;
  }
  .btn-soft:hover{ background:#eef2f7; }
</style>

@php
  use Illuminate\Support\Carbon;

  $stages = ['ordered','estimated','payment_completed','payment_verified','processing','shipping','delivered'];
  $status = $order->status;
  $currentIndex = array_search($status, $stages);
  $isCanceled = in_array($status, ['canceled','returned']);
  $statusClass = match($status){
      'ordered'            => 'badge-ordered',
      'estimated'          => 'badge-estimated',
      'payment_completed'  => 'badge-payment_completed',
      'payment_verified'   => 'badge-payment_verified',
      'processing'         => 'badge-processing',
      'shipping'           => 'badge-shipping',
      'delivered'          => 'badge-delivered',
      'canceled'           => 'badge-canceled',
      'returned'           => 'badge-returned',
      default              => 'badge-other'
  };
  $statusLabel = ucfirst(str_replace('_',' ', $status));

  $orderDate = $order->created_at ? Carbon::parse($order->created_at)->format('d M Y, h:i A') : '—';
  $deliveredDate = $order->delivered_date ? Carbon::parse($order->delivered_date)->format('d M Y') : '—';
  $canceledDate = $order->canceled_date ? Carbon::parse($order->canceled_date)->format('d M Y') : '—';

  $currency = 'Rs.';
@endphp

<main class="pt-90" style="padding-top:0">
  <div class="mb-4 pb-2"></div>

  <section class="my-account container">
    <div class="row g-3 g-lg-4">
      <div class="col-lg-2">
        @include('user.account_nav')
      </div>

      <div class="col-lg-10">
        <div class="page-wrap">
          <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
              <h2 class="page-title">Order Details</h2>
              <div class="page-subtitle mt-1">
                <span class="chip"><strong>Order</strong> <span class="orderno">#{{ $order->id }}</span></span>
                <span class="chip"><strong>Placed</strong> {{ $orderDate }}</span>
                <span class="chip">
                  <strong>Status</strong>
                  <span class="badge badge-status {{ $statusClass }}">{{ $statusLabel }}</span>
                </span>
              </div>
            </div>
            <div class="d-flex flex-wrap gap-2">
              <a href="{{ route('user.orders') }}" class="btn btn-danger btn-sm">
                <i class="fa fa-arrow-left me-1"></i> Back to Orders
              </a>
              @if(in_array($status, ['estimated','payment_completed']) && Route::has('payment.verify'))
                <a href="{{ route('payment.verify', ['order' => $order->id]) }}" class="btn btn-primary btn-sm">
                  <i class="fa fa-receipt me-1"></i> Verify Payment
                </a>
              @endif
            </div>
          </div>

          {{-- Stepper --}}
          <div class="stepper mt-3">
            @if($isCanceled)
              <div class="step done"><span class="dot">✓</span> Ordered</div>
              <div class="step canceled"><span class="dot">!</span> {{ ucfirst($status) }}</div>
            @else
              @foreach($stages as $i => $label)
                @php
                  $cls = $i < $currentIndex ? 'done' : ($i === $currentIndex ? 'current' : '');
                @endphp
                <div class="step {{ $cls }}">
                  <span class="dot">{{ $i < $currentIndex ? '✓' : ($i === $currentIndex ? '•' : '') }}</span>
                  {{ ucfirst(str_replace('_',' ', $label)) }}
                </div>
              @endforeach
            @endif
          </div>

          {{-- SUMMARY + SIDEBAR --}}
          <div class="row g-3 mt-1">
            <div class="col-12 col-xl-8">
              <div class="cardx">
                <div class="cardx-h">Order Summary</div>
                <div class="cardx-b">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered tablex mb-0">
                      <thead>
                        <tr>
                          <th style="min-width:250px">Product</th>
                          <th class="text-center">Price</th>
                          <th class="text-center">Qty</th>
                          <th class="text-center">SKU</th>
                          <th class="text-center">Category</th>
                          <th class="text-center">Brand</th>
                          <th class="text-center">Options</th>
                          <th class="text-center">Return</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($orderItems as $item)
                          @php
                            $p = $item->product;
                            $price = number_format((float)$item->price, 2);
                            $rstatus = $item->rstatus == 0 ? 'No' : 'Yes';
                          @endphp
                          <tr>
                            <td data-label="Product">
                              <div class="d-flex align-items-center gap-3">
                                <img class="item-thumb" src="{{ asset('uploads/products') }}/{{ $p->image }}" alt="{{ $p->name }}">
                                <div class="min-w-0">
                                  <a href="{{ route('shop.product.details', ['product_slug' => $p->slug]) }}" target="_blank" class="text-decoration-none">
                                    <div class="fw-bold text-truncate" style="max-width:360px">{{ $p->name }}</div>
                                  </a>
                                  <div class="muted small">ID: {{ $p->id }}</div>
                                </div>
                              </div>
                            </td>
                            <td class="text-center" data-label="Price"><span class="money">{{ $currency }} {{ $price }}</span></td>
                            <td class="text-center" data-label="Qty">{{ $item->quantity }}</td>
                            <td class="text-center" data-label="SKU">{{ $p->SKU }}</td>
                            <td class="text-center" data-label="Category">{{ $p->category->name }}</td>
                            <td class="text-center" data-label="Brand">{{ $p->brand->name }}</td>
                            <td class="text-center" data-label="Options">{{ $item->options ?: '—' }}</td>
                            <td class="text-center" data-label="Return">{{ $rstatus }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>

                  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3">
                    <div class="text-muted small">
                      @if(method_exists($orderItems, 'currentPage'))
                        Page {{ $orderItems->currentPage() }} of {{ $orderItems->lastPage() }}
                      @endif
                    </div>
                    <div>
                      @if(method_exists($orderItems, 'links'))
                        {{ $orderItems->links('pagination::bootstrap-5') }}
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- Sidebar: Address & Totals --}}
            <div class="col-12 col-xl-4">
              <div class="cardx mb-3">
                <div class="cardx-h">Shipping Address</div>
                <div class="cardx-b">
                  <div class="d-flex flex-column gap-1">
                    <div><strong>Name:</strong> {{ $order->name }}</div>
                    <div><strong>Address:</strong> {{ $order->address }}</div>
                    <div><strong>Locality:</strong> {{ $order->locality }}</div>
                    <div><strong>City/Province:</strong> {{ $order->city }}, {{ $order->district }}, {{ $order->province }}</div>
                    <div><strong>Country:</strong> {{ $order->country }}</div>
                    <div><strong>Landmark:</strong> {{ $order->landmark }}</div>
                    <div><strong>Zip:</strong> {{ $order->zip }}</div>
                    <div><strong>Mobile:</strong> {{ $order->phone }}</div>
                  </div>
                </div>
              </div>

              <div class="cardx">
                <div class="cardx-h">Amounts & Tracking</div>
                <div class="cardx-b">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered tablex mb-3">
                      <tbody>
                        <tr>
                          <th>Subtotal</th>
                          <td class="text-end">{{ $currency }} {{ number_format((float)$order->subtotal,2) }}</td>
                        </tr>
                        <tr>
                          <th>Estimated Tax</th>
                          <td class="text-end">{{ $currency }} {{ number_format((float)$order->tax,2) }}</td>
                        </tr>
                        <tr>
                          <th>Discount</th>
                          <td class="text-end">{{ $currency }} {{ number_format((float)$order->discount,2) }}</td>
                        </tr>
                        <tr>
                          <th>Estimated Total</th>
                          <td class="text-end fw-bold">{{ $currency }} {{ number_format((float)$order->total,2) }}</td>
                        </tr>
                        <tr>
                          <th>Pre-est. Total</th>
                          <td class="text-end">{{ $currency }} {{ number_format((float)$order->pre_estimated_total,2) }}</td>
                        </tr>
                        <tr>
                          <th>Pre-est. Tax</th>
                          <td class="text-end">{{ $currency }} {{ number_format((float)$order->pre_estimated_tax,2) }}</td>
                        </tr>
                        <tr>
                          <th>Shipping Charge</th>
                          <td class="text-end">{{ $currency }} {{ number_format((float)$order->shipping_charge,2) }}</td>
                        </tr>
                        <tr>
                          <th>Shipping Tax</th>
                          <td class="text-end">{{ $currency }} {{ number_format((float)$order->shipping_tax,2) }}</td>
                        </tr>
                        <tr>
                          <th>Payment Mode</th>
                          <td class="text-end">{{ $transaction->mode ?? '—' }}</td>
                        </tr>
                        <tr>
                          <th>Payment Status</th>
                          <td class="text-end">
                            @php
                              $tstatus = $transaction->status ?? 'pending';
                              $tBadge = match($tstatus){
                                'approved' => 'bg-success',
                                'declined' => 'bg-danger',
                                'refunded' => 'bg-secondary',
                                default    => 'bg-warning text-dark'
                              };
                            @endphp
                            <span class="badge {{ $tBadge }}">{{ ucfirst($tstatus) }}</span>
                          </td>
                        </tr>
                        <tr>
                          <th>Courier</th>
                          <td class="text-end">{{ optional($order->shippingDetail)->courier_name ?? '—' }}</td>
                        </tr>
                        <tr>
                          <th>Tracking ID</th>
                          @php $trackingId = optional($order->shippingDetail)->tracking_id; @endphp
                          <td class="text-end">
                            @if($trackingId)
                              <span id="track-id" class="me-2">{{ $trackingId }}</span>
                              <button type="button" class="btn btn-sm btn-soft" id="btnCopyTrack" title="Copy">
                                <i class="fa fa-copy"></i>
                              </button>
                            @else
                              —
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th>Tracking URL</th>
                          @php $trackingUrl = optional($order->shippingDetail)->tracking_url; @endphp
                          <td class="text-end">
                            @if($trackingUrl)
                              <a href="{{ $trackingUrl }}" target="_blank" rel="noopener" class="btn btn-sm btn-primary">
                                Open Tracking
                              </a>
                            @else
                              —
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th>Delivered</th>
                          <td class="text-end">{{ $deliveredDate }}</td>
                        </tr>
                        <tr>
                          <th>Canceled</th>
                          <td class="text-end">{{ $canceledDate }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  @if ($order->status != 'canceled')
                    <form id="cancel-order-form" method="POST" action="{{ route('user.order.cancel') }}">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="order_id" value="{{ $order->id }}">
                      <input type="hidden" name="order_status" value="canceled">
                      <button type="submit" id="cancel-order" class="btn btn-danger w-100">
                        Cancel Order
                      </button>
                    </form>
                  @endif
                </div>
              </div>
            </div>
          </div>

          {{-- Meta: compact table with strong header background --}}
          <div class="cardx mt-3">
            <div class="cardx-h">Order Info</div>
            <div class="cardx-b">
              @if (Session::has('status'))
                <div class="alert alert-success mb-3">{{ Session::get('status') }}</div>
              @endif
              <div class="table-responsive">
                <table class="table table-bordered tablex mb-0">
                  <thead>
                    <tr>
                      <th>Field</th>
                      <th>Value</th>
                      <th>Field</th>
                      <th>Value</th>
                      <th>Field</th>
                      <th>Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Order No</td>
                      <td>#{{ $order->id }}</td>
                      <td>Mobile</td>
                      <td>{{ $order->phone }}</td>
                      <td>Zip Code</td>
                      <td>{{ $order->zip }}</td>
                    </tr>
                    <tr>
                      <td>Order Date</td>
                      <td>{{ $orderDate }}</td>
                      <td>Delivered Date</td>
                      <td>{{ $deliveredDate }}</td>
                      <td>Canceled Date</td>
                      <td>{{ $canceledDate }}</td>
                    </tr>
                    <tr>
                      <td>Order Status</td>
                      <td colspan="5">
                        <span class="badge badge-status {{ $statusClass }}">{{ $statusLabel }}</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div><!-- /page-wrap -->
      </div>
    </div>
  </section>
</main>
@endsection

@push('website-script')
<script>
  (function(){
    // Copy tracking ID (visual feedback)
    const copyBtn = document.getElementById('btnCopyTrack');
    if(copyBtn){
      copyBtn.addEventListener('click', function(){
        const el = document.getElementById('track-id');
        if(!el) return;
        const text = el.textContent.trim();
        navigator.clipboard.writeText(text).then(()=>{
          copyBtn.innerHTML = '<i class="fa fa-check"></i>';
          setTimeout(()=>copyBtn.innerHTML = '<i class="fa fa-copy"></i>', 1200);
        });
      });
    }

    // SweetAlert confirm OR native fallback
    const cancelBtn = document.getElementById('cancel-order');
    const form = document.getElementById('cancel-order-form');
    if(cancelBtn && form){
      cancelBtn.addEventListener('click', function(e){
        e.preventDefault();
        if (window.swal){
          swal({
            title: "Cancel this order?",
            text: "This action cannot be undone.",
            icon: "warning",
            buttons: {
              cancel: { text: "Keep Order", visible: true, closeModal: true },
              confirm: { text: "Yes, Cancel", value: true, visible: true, className: "btn-danger" }
            },
            dangerMode: true
          }).then(function(result){
            if(result){ form.submit(); }
          });
        } else {
          if(confirm("Cancel this order? This action cannot be undone.")){
            form.submit();
          }
        }
      });
    }
  })();
</script>
@endpush
