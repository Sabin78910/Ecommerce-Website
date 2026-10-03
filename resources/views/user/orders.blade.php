@extends('layouts.app')

@section('website-content')
<style>
  :root{
    --brand:#6a6e51;
    --brand-600:#5b5e45;
    --ink:#1f2937;
    --muted:#6b7280;
    --surface:#ffffff;
    --surface-2:#f8f9fa;
    --ring:#e5e7eb;
    --success:#22c55e;
    --danger:#ef4444;
    --warning:#f59e0b;
    --info:#0ea5e9;
    --primary:#3b82f6;
    --shadow:0 1px 2px rgba(0,0,0,.05), 0 8px 24px rgba(0,0,0,.06);
  }

  .page-wrap{
    background: linear-gradient(180deg, #fff, #fafafa);
    border-radius: 14px;
    box-shadow: var(--shadow);
    padding: clamp(14px, 2vw, 20px);
  }

  .page-title{
    font-weight: 700;
    color: var(--ink);
    letter-spacing: .2px;
    margin-bottom: .25rem;
  }

  .page-subtitle{
    color: var(--muted);
    font-size: .95rem;
  }

  .toolbar{
    gap: .75rem;
  }
  .form-control, .form-select{
    border-radius: 10px;
    border-color: var(--ring);
  }
  .form-control:focus, .form-select:focus{
    box-shadow: 0 0 0 .2rem rgba(59,130,246,.15);
  }

  /* Table */
  .orders-table thead th{
    background: var(--brand);
    color: #fff;
    border-color: var(--brand);
    font-weight: 600;
    vertical-align: middle;
  }
  .orders-table td, .orders-table th{
    padding: .8rem 1rem;
    vertical-align: middle;
  }
  .orders-table{
    border: 1px solid var(--ring);
    border-radius: 12px;
    overflow: hidden;
  }

  /* Badges (consistent palette) */
  .badge-status{ font-weight:600; padding:.5em .75em; border-radius:999px; }
  .badge-ordered{ background:#e5e7eb; color:#111827; }
  .badge-estimated{ background:#cffafe; color:#0c4a6e; }
  .badge-payment_completed{ background:#dbeafe; color:#1e3a8a; }
  .badge-payment_verified{ background:#dcfce7; color:#166534; }
  .badge-processing{ background:#fef9c3; color:#854d0e; }
  .badge-shipping{ background:#e0f2fe; color:#075985; }
  .badge-delivered{ background:#dcfce7; color:#166534; }
  .badge-canceled, .badge-returned{ background:#fee2e2; color:#7f1d1d; }
  .badge-other{ background:#f3f4f6; color:#111827; }

  /* Mobile stacked cards */
  @media (max-width: 991.98px){
    .orders-table thead{ display:none; }
    .orders-table tbody tr{
      display:block;
      background:#fff;
      border:1px solid var(--ring);
      border-radius:14px;
      margin-bottom: .9rem;
      box-shadow: var(--shadow);
      overflow:hidden;
    }
    .orders-table tbody td{
      display:flex; gap:12px; justify-content:space-between; align-items:center;
      border-bottom:1px dashed #eee;
      padding: .7rem .95rem;
    }
    .orders-table tbody td:last-child{ border-bottom:0; }
    .orders-table tbody td::before{
      content: attr(data-label);
      font-weight:600; color: var(--muted);
      min-width: 40%;
      text-align:left;
    }
    .table-actions a.btn{ width:100%; }
  }

  /* Tiny niceties */
  .chip{
    background: var(--surface-2);
    border: 1px solid var(--ring);
    border-radius: 999px;
    padding: .35rem .6rem;
    font-size: .75rem;
    color: var(--muted);
  }
  .empty{
    border: 2px dashed var(--ring);
    border-radius: 14px;
    padding: 2rem 1rem;
    background: #fff;
    text-align: center;
  }
  .empty h5{ color: var(--ink); font-weight: 700; }
  .empty p{ color: var(--muted); }
  .orderno{
    background:#111827; color:#fff; border-radius: .5rem;
    padding:.28rem .5rem; font-size:.78rem; font-weight:700;
  }
  .btn-soft{
    background:#f8fafc; border:1px solid var(--ring); color:#111827;
  }
  .btn-soft:hover{ background:#eef2f7; }
</style>

<main class="pt-90" style="padding-top:0">
  <div class="mb-4 pb-2"></div>

  <section class="my-account container">
    <div class="row g-3 g-lg-4">
      <div class="col-lg-2">
        @include('user.account_nav')
      </div>

      <div class="col-lg-10">
        <div class="page-wrap">
          <div class="d-flex flex-wrap align-items-end justify-content-between mb-3">
            <div>
              <h2 class="page-title mb-1">Orders</h2>
              <div class="page-subtitle">
                <span class="chip">Showing {{ $orders->count() }} of {{ $orders->total() }} orders</span>
              </div>
            </div>

            <div class="toolbar d-flex flex-wrap">
              <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                  <i class="fa fa-search"></i>
                </span>
                <input id="order-search" type="text" class="form-control border-start-0" placeholder="Search by Order #, name, phone…">
              </div>
              <select id="status-filter" class="form-select" style="min-width:180px">
                <option value="">All statuses</option>
                <option value="ordered">Ordered</option>
                <option value="estimated">Estimated</option>
                <option value="payment_completed">Payment Completed</option>
                <option value="payment_verified">Payment Verified</option>
                <option value="processing">Processing</option>
                <option value="shipping">Shipping</option>
                <option value="delivered">Delivered</option>
                <option value="canceled">Canceled</option>
                <option value="returned">Returned</option>
              </select>
            </div>
          </div>

          @if($orders->count() === 0)
            <div class="empty">
              <h5 class="mb-2">No orders yet</h5>
              <p class="mb-3">When you place an order, it will appear here with live status updates.</p>
              <a href="{{ route('shop.index') }}" class="btn btn-primary px-4">Start Shopping</a>
            </div>
          @else
            <div class="table-responsive">
              <table class="table table-striped table-bordered orders-table align-middle" id="orders-table">
                <thead>
                  <tr>
                    <th style="width: 90px">Order #</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Subtotal</th>
                    <th class="text-center">Discount</th>
                    <th class="text-center">Tax</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Order Date</th>
                    <th class="text-center">Items</th>
                    <th class="text-center">Delivered On</th>
                    <th class="text-center" style="width: 70px"></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($orders as $order)
                    @php
                      $status = $order->status;
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
                      $created = \Illuminate\Support\Carbon::parse($order->created_at)->format('d M Y, h:i A');
                      $delivered = $order->delivered_date ? \Illuminate\Support\Carbon::parse($order->delivered_date)->format('d M Y') : '—';
                      $itemsCount = method_exists($order,'orderItem') ? $order->orderItem->count() : (property_exists($order,'items_count') ? $order->items_count : '-');
                    @endphp

                    <tr
                      data-order-row
                      data-status="{{ $status }}"
                      data-search="{{ $order->id }} {{ strtolower($order->name) }} {{ $order->phone }}"
                    >
                      <td class="text-center" data-label="Order #">
                        <span class="orderno">#{{ $order->id }}</span>
                      </td>
                      <td class="text-center" data-label="Name">{{ $order->name }}</td>
                      <td class="text-center" data-label="Phone">{{ $order->phone }}</td>

                      <td class="text-center" data-label="Subtotal">Rs. {{ number_format((float)$order->subtotal, 2) }}</td>
                      <td class="text-center" data-label="Discount">Rs. {{ number_format((float)$order->discount, 2) }}</td>
                      <td class="text-center" data-label="Tax">Rs. {{ number_format((float)$order->tax, 2) }}</td>
                      <td class="text-center fw-semibold" data-label="Total">Rs. {{ number_format((float)$order->total, 2) }}</td>

                      <td class="text-center" data-label="Status">
                        <span class="badge badge-status {{ $statusClass }}">{{ $statusLabel }}</span>
                      </td>

                      <td class="text-center" data-label="Order Date">{{ $created }}</td>
                      <td class="text-center" data-label="Items">{{ $itemsCount }}</td>
                      <td class="text-center" data-label="Delivered On">{{ $delivered }}</td>

                      <td class="text-center table-actions" data-label="Action">
                        <div class="d-grid gap-2">
                          <a href="{{ route('user.order.details', ['order_id' => $order->id]) }}"
                             class="btn btn-primary btn-sm">
                            <i class="fa fa-eye me-1"></i> View
                          </a>

                          @if(in_array($status, ['estimated','payment_completed']) && Route::has('payment.verify'))
                            <a href="{{ route('payment.verify', ['order' => $order->id]) }}"
                               class="btn btn-soft btn-sm">
                              <i class="fa fa-receipt me-1"></i> Verify Payment
                            </a>
                          @endif
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3">
              <div class="text-muted small">
                Page {{ $orders->currentPage() }} of {{ $orders->lastPage() }}
              </div>
              <div>
                {{ $orders->links('pagination::bootstrap-5') }}
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>
</main>

@push('website-script')
<script>
  (function(){
    const q = document.getElementById('order-search');
    const s = document.getElementById('status-filter');
    const rows = Array.from(document.querySelectorAll('[data-order-row]'));

    function applyFilters(){
      const term = (q.value || '').toLowerCase().trim();
      const status = (s.value || '').trim();

      rows.forEach(tr=>{
        const matchText = tr.getAttribute('data-search') || '';
        const st = tr.getAttribute('data-status') || '';
        const textOk = !term || matchText.indexOf(term) !== -1;
        const statusOk = !status || st === status;
        tr.style.display = (textOk && statusOk) ? '' : 'none';
      });
    }

    q && q.addEventListener('input', applyFilters);
    s && s.addEventListener('change', applyFilters);
  })();
</script>
@endpush
@endsection
