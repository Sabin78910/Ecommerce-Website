@extends('layouts.admin')
@section('website-content')
    <style>
        .table-transaction>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: #fff !important;
        }
    </style>
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Order Details</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Order Details:</div>
                    </li>
                </ul>
            </div>
            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Ordered Details</h5>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.orders') }}">Back</a>
                </div>
                <div class="table-responsive">
                    @if (Session::has('status'))
                        <p class="alert alert-success">{{ Session::get('status') }}</p>
                    @endif
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Order No: </th>
                            <td>{{ $order->id }}</td>
                            <th>Mobile: </th>
                            <td>+977{{ $order->phone }}</td>
                            <th>Zip Code: </th>
                            <td>{{ $order->zip }}</td>
                        </tr>
                        <tr>
                            <th>Order Date: </th>
                            <td>{{ $order->created_at }}</td>
                            <th>Delivered Date: </th>
                            <td>{{ $order->delivered_date }}</td>
                            <th>Canceled Date: </th>
                            <td>{{ $order->canceled_date }}</td>
                        </tr>
                        <tr>
                            <th>Order Status: </th>
                            <td colspan="5">
                                @if ($order->status == 'ordered')
                                    <span class="badge bg-secondary">Ordered</span>
                                @elseif($order->status == 'estimated')
                                    <span class="badge bg-info">Estimated</span>
                                @elseif($order->status == 'payment_completed')
                                    <span class="badge bg-primary">Payment Completed</span>
                                @elseif($order->status == 'payment_verified')
                                    <span class="badge bg-success">Payment Verified</span>
                                @elseif($order->status == 'processing')
                                    <span class="badge bg-warning text-dark">Processing</span>
                                @elseif($order->status == 'shipping')
                                    <span class="badge bg-info">Shipping</span>
                                @elseif($order->status == 'delivered')
                                    <span class="badge bg-success">Delivered</span>
                                @elseif($order->status == 'canceled')
                                    <span class="badge bg-danger">Canceled</span>
                                @elseif($order->status == 'returned')
                                    <span class="badge bg-danger">Returned</span>
                                @else
                                    <span
                                        class="badge bg-light text-dark">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">SKU</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Brand</th>
                                <th class="text-center">Options</th>
                                <th class="text-center">Return Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderItems as $item)
                                <tr>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{ asset('uploads/products') }}/{{ $item->product->image }}"
                                                alt="{{ $item->product->name }}" class="image">
                                        </div>
                                        <div class="name">
                                            <a href="{{ route('shop.product.details', ['product_slug' => $item->product->slug]) }}"
                                                target="_blank" class="body-title-2">{{ $item->product->name }}</a>
                                        </div>
                                    </td>
                                    <td class="text-center">Rs. {{ $item->price }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-center">{{ $item->product->SKU }}</td>
                                    <td class="text-center">{{ $item->product->category->name }}</td>
                                    <td class="text-center">{{ $item->product->brand->name }}</td>
                                    <td class="text-center">{{ $item->options }}</td>
                                    <td class="text-center">{{ $item->rstatus == 0 ? 'No' : 'YES' }}</td>
                                </tr>
                                <tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $orderItems->links('pagination::bootstrap-5') }}
                </div>
            </div>
            <div class="wg-box mt-5">
                <h5>Shipping Address</h5>
                <div class="my-account__address-item col-md-6">
                    <div class="my-account__address-item__detail">
                        <p>Name: {{ $order->name }}</p>
                        <p>Address: {{ $order->address }}</p>
                        <p>Locality: {{ $order->locality }}</p>
                        <p>Country: {{ $order->country }}</p>
                        <p>City: {{ $order->city }}, {{ $order->district }}, {{ $order->province }} ,
                            {{ $order->country }} </p>
                        <p>Landmark: {{ $order->landmark }}</p>
                        <p>Zip Code: {{ $order->zip }}</p>
                        <p>Mobile:+{{ $order->phone }}</p>
                    </div>
                </div>
            </div>
            <div class="wg-box mt-5">
                <h5>Transactions</h5>
                <table class="table table-striped table-bordered table-transaction">
                    <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td>Rs. {{ $order->subtotal }}</td>
                            <th>Tax</th>
                            <td>Rs. {{ $order->tax }}</td>
                            <th>Discount</th>
                            <td>Rs. {{ $order->discount }}</td>
                        </tr>
                        <tr>
                            <th>Pre-estimated Total</th>
                            <td>Rs. {{ $order->pre_estimated_total }}</td>
                            <th>Pre-estimated TAX</th>
                            <td>Rs. {{ $order->pre_estimated_tax }}</td>
                            <th>Shipping Cost</th>
                            <td>Rs. {{ $order->shipping_charge }}</td>
                        </tr>
                        <tr>
                            <th>Shipping Tax</th>
                            <td>Rs. {{ $order->shipping_tax }}</td>
                            <th>Estimated Tax</th>
                            <td>Rs. {{ $order->tax }}</td>
                            <th>Estimated Total</th>
                            <td>Rs. {{ $order->total }}</td>
                        </tr>
                        <tr>
                            <th>Payment Mode</th>
                            <td>{{ optional($transaction)->mode ?? '—' }}</td>
                            <th>Status</th>
                            <td>
                                @if (optional($transaction)->status ?? '-' == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif(optional($transaction)->status ?? '-' == 'declined')
                                    <span class="badge bg-danger">Declined</span>
                                @elseif(optional($transaction)->status ?? '-' == 'refunded')
                                    <span class="badge bg-secondary">Refunded</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="wg-box mt-5">
                <h5>Shipping & Totals Update</h5>

                <form id="shipping-update-form" method="POST" action="{{ route('admin.order.shipping.update') }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    {{-- Carry over pre-estimates --}}
                    <input type="hidden" id="pre_estimated_total" name="pre_estimated_total"
                        value="{{ $order->pre_estimated_total }}">

                    <input type="hidden" id="pre_estimated_tax" name="pre_estimated_tax"
                        value="{{ $order->pre_estimated_tax }}">

                    <div class="row gx-3 gy-3">

                        {{-- Shipping Charge --}}
                        <div class="col-md-3">
                            <label for="shipping_charge" class="form-label">Shipping Charge</label>
                            <input type="number" step="0.01" min="0" id="shipping_charge" name="shipping_charge"
                                class="form-control" value="{{ old('shipping_charge', $order->shipping_charge) }}"
                                required>
                        </div>

                        {{-- Shipping Tax --}}
                        <div class="col-md-3">
                            <label for="shipping_tax" class="form-label">Shipping Tax</label>
                            <input type="number" step="0.01" min="0" id="shipping_tax" name="shipping_tax"
                                class="form-control" value="{{ old('shipping_tax', $order->shipping_tax) }}" required>
                        </div>

                        {{-- Final Total Display + Hidden --}}
                        <div class="col-md-3">
                            <label class="form-label">Final Total</label>
                            <input type="text" id="final_total_display" class="form-control-plaintext" readonly>
                            <input type="hidden" id="final_total" name="final_total">
                        </div>

                        {{-- Final Tax Display + Hidden --}}
                        <div class="col-md-3">
                            <label class="form-label">Final Tax</label>
                            <input type="text" id="final_tax_display" class="form-control-plaintext" readonly>
                            <input type="hidden" id="final_tax" name="final_tax">
                        </div>

                        {{-- Submit --}}
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                Update Shipping & Totals
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="wg-box mt-5">
                <h5>Courier & Tracking</h5>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('admin.shipping-details.update', $order->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row gx-3 gy-3">
                        <div class="col-md-4">
                            <label class="form-label" for="courier_name">Courier Name</label>
                            <input type="text" id="courier_name" name="courier_name"
                                class="form-control @error('courier_name') is-invalid @enderror"
                                value="{{ old('courier_name', $order->shippingDetail->courier_name ?? '') }}">
                            @error('courier_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="tracking_id">Tracking ID</label>
                            <input type="text" id="tracking_id" name="tracking_id"
                                class="form-control @error('tracking_id') is-invalid @enderror"
                                value="{{ old('tracking_id', $order->shippingDetail->tracking_id ?? '') }}">
                            @error('tracking_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="tracking_url">Tracking URL</label>
                            <input type="url" id="tracking_url" name="tracking_url"
                                class="form-control @error('tracking_url') is-invalid @enderror"
                                value="{{ old('tracking_url', $order->shippingDetail->tracking_url ?? '') }}">
                            @error('tracking_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 text-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                Save & Email Shipping Info
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="wg-box mt-5">
                <h5>Order Status Update</h5>
                <form name="updateOrderStatus-form" id="updateOrderStatus-form" method="POST"
                    action="{{ route('admin.order.status.update') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="order_id" value="{{ $order->id }}" />
                    <div class="row">
                        <div class="col-md-3">
                            <label for="order_status" class="form-label">Order Status</label>
                            <select id="order_status" name="order_status" class="form-select">
                                <option value="ordered" {{ $order->status == 'ordered' ? 'selected' : '' }}>
                                    Ordered</option>
                                <option value="estimated" {{ $order->status == 'estimated' ? 'selected' : '' }}>
                                    Estimated</option>
                                <option value="payment_completed"
                                    {{ $order->status == 'payment_completed' ? 'selected' : '' }}>Payment Completed
                                </option>
                                <option value="payment_verified"
                                    {{ $order->status == 'payment_verified' ? 'selected' : '' }}>Payment Verified</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                    Processing</option>
                                <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>
                                    Shipping</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                    Delivered</option>
                                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>
                                    Canceled</option>
                                <option value="returned" {{ $order->status == 'returned' ? 'selected' : '' }}>
                                    Returned</option>
                            </select>

                            <button type="submit" class="btn btn-primary tf-button w208"
                                style="margin-top: 25px;">Update
                                Order Status</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('website-script')
    <script>
        (function() {
            // Grab elements
            const preTotalInput = document.getElementById('pre_estimated_total');
            const preTaxInput = document.getElementById('pre_estimated_tax');
            const scInput = document.getElementById('shipping_charge');
            const stInput = document.getElementById('shipping_tax');
            const ftHidden = document.getElementById('final_total');
            const fxHidden = document.getElementById('final_tax');
            const ftDisplay = document.getElementById('final_total_display');
            const fxDisplay = document.getElementById('final_tax_display');

            // Parse floats once
            const preTotal = parseFloat(preTotalInput.value) || 0;
            const preTax = parseFloat(preTaxInput.value) || 0;

            function recalc() {
                const sc = parseFloat(scInput.value) || 0;
                const st = parseFloat(stInput.value) || 0;
                const finalTotal = preTotal + sc;
                const finalTax = preTax + st;

                // Update hidden
                ftHidden.value = finalTotal.toFixed(2);
                fxHidden.value = finalTax.toFixed(2);

                // Update display
                ftDisplay.value = `Rs. ${finalTotal.toFixed(2)}`;
                fxDisplay.value = `Rs. ${finalTax.toFixed(2)}`;
            }

            // Wire up events
            scInput.addEventListener('input', recalc);
            stInput.addEventListener('input', recalc);

            // Initialize on load
            recalc();
        })();
    </script>
@endpush
