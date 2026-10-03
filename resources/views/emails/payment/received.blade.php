@component('mail::message')
    # Payment Received

    Hello {{ $order->user->name }},

    We have received your payment for **Order #{{ $order->id }}**.

    We will now verify your transaction. Once verified, we’ll begin processing and shipping your order. You’ll receive
    another email as soon as your payment is confirmed and your items are on the way.

    Thanks for shopping with us!
    **N & S Handicrafts Team**
@endcomponent
