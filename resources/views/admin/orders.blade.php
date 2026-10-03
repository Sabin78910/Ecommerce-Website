@extends('layouts.admin')

@section('website-content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Orders</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Orders</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form method="GET" action="{{ route('admin.orders') }}" class="form-search">
                            <fieldset class="name">
                                <input type="text" name="search" placeholder="Search by Order No, Name or Phone..."
                                    value="{{ old('search', $search ?? '') }}" >
                            </fieldset>
                            <div class="button-submit">
                                <button type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-wrap text-break" style="min-width:1200px;">
                            <thead>
                                <tr>
                                    <th style="width:70px">OrderNo</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Subtotal</th>
                                    <th class="text-center">Tax</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Discount</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Order Date</th>
                                    <th class="text-center">Total Items</th>
                                    <th class="text-center">Delivered On</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="text-center text-wrap text-break">
                                            {{ $order->id }}
                                        </td>
                                        <td class="text-center text-wrap text-break">
                                            {{ $order->name }}
                                        </td>
                                        <td class="text-center text-wrap text-break">
                                            +{{ $order->phone }}
                                        </td>
                                        <td class="text-center text-wrap text-break">
                                            Rs. {{ number_format((float) str_replace(',', '', $order->subtotal), 2) }}
                                        </td>
                                        <td class="text-center text-wrap text-break">
                                            Rs. {{ number_format((float) str_replace(',', '', $order->tax), 2) }}
                                        </td>
                                        <td class="text-center text-wrap text-break">
                                            Rs. {{ number_format((float) str_replace(',', '', $order->total), 2) }}
                                        </td>
                                        <td class="text-center text-wrap text-break">
                                            Rs. {{ number_format((float) str_replace(',', '', $order->discount), 2) }}
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $statusClasses = [
                                                    'ordered' => 'secondary',
                                                    'estimated' => 'info',
                                                    'payment_completed' => 'primary',
                                                    'payment_verified' => 'success',
                                                    'processing' => 'warning text-dark',
                                                    'shipping' => 'info',
                                                    'delivered' => 'success',
                                                    'canceled' => 'danger',
                                                    'returned' => 'danger',
                                                ];
                                                $class = $statusClasses[$order->status] ?? 'light text-dark';
                                                $label = ucwords(str_replace('_', ' ', $order->status));
                                            @endphp
                                            <span class="badge bg-{{ $class }}">
                                                {{ $label }}
                                            </span>
                                        </td>
                                        <td class="text-center text-wrap text-break">
                                            {{ $order->created_at }}
                                        </td>
                                        <td class="text-center text-wrap text-break">
                                            {{ $order->orderItem->count() }}
                                        </td>
                                        <td class="text-center text-wrap text-break">
                                            {{ $order->delivered_date ?? '—' }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.order.details', ['order_id' => $order->id]) }}">
                                                <div class="list-icon-function view-icon">
                                                    <div class="item eye">
                                                        <i class="icon-eye"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
