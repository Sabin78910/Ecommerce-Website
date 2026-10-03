<?php
// app/Http/Controllers/Admin/ShippingDetailController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShippingDetailsMail;

class ShippingDetailController extends Controller
{
    /**
     * Update (or create) the shipping_detail record and email the customer.
     */
    public function update(Request $request, Order $order)
    {
        // 1) Validate incoming
        $data = $request->validate([
            'courier_name' => 'nullable|string|max:100',
            'tracking_id'  => 'nullable|string|max:100',
            'tracking_url' => 'nullable|url|max:255',
        ]);

        // 2) Write *only* to shipping_details table
        $order->shippingDetail()
            ->updateOrCreate(
                ['order_id' => $order->id],
                $data
            );

        // 3) Mark the order as “shipping”
        $order->status = 'shipping';
        $order->save();

        // 4) Email the customer
        Mail::to($order->user->email)
            ->send(new ShippingDetailsMail($order));

        return back()->with('success', 'Shipping details saved & emailed to customer.');
    }
}
