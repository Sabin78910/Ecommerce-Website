@component('mail::message')
    # Shipping Estimate for Order #{{ $order->id }}

    Hello {{ $order->user->name }},

    We have calculated the shipping charges for your recent order. Below is the breakdown:

    @component('mail::table')
        | Description | Amount (Rs.) |
        |:------------------------|-------------:|
        | **Pre-Estimated Total** | {{ number_format($order->pre_estimated_total, 2) }} |
        | **Pre-Estimated VAT** | {{ number_format($order->pre_estimated_tax, 2) }} |
        | **Shipping Charge** | {{ number_format($order->shipping_charge, 2) }} |
        | **Shipping VAT** | {{ number_format($order->shipping_tax, 2) }} |
        | **Final VAT** | {{ number_format($order->tax, 2) }} |
        | **Grand Total** | {{ number_format($order->total, 2) }} |
    @endcomponent

    Please complete your payment via **bank transfer** using the details below:

    **Bank Name:** Your Bank
    **Account Name:** N &amp; S Handicrafts
    **Account Number:** 1234567890

    Once you’ve made the transfer, kindly upload your proof of payment here:

    @component('mail::button', ['url' => route('payment.verify', $order->id)])
        Upload Proof of Payment
    @endcomponent

    After we verify your payment, we will process and ship your order.

    Thanks for shopping with us!
    N &amp; S Handicrafts Team
@endcomponent
