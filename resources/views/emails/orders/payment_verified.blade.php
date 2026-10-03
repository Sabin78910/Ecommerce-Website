@component('mail::message')
    # Payment Verified

    Hi {{ $order->user->name }},

    Great news! We have confirmed your payment for **Order #{{ $order->id }}**:

    | Detail | Value |
    | ---------------- | ------------------------------------------ |
    | **Amount** | Rs. {{ number_format($order->paymentVerification->amount, 2) }}
    {{ $order->paymentVerification->currency }} |
    | **Verified At** | {{ $order->paymentVerification->created_at->format('F j, Y, g:i a') }} |

    Your order is now **processing**, and we will ship it within the next 1–3 business days. We’ll send you another email as
    soon as your package is on its way.

    Thanks for shopping with **N & S Handicrafts**!

    @component('mail::button', ['url' => route('user.order.details', $order->id)])
        View Your Order
    @endcomponent

    If you have any questions, just reply to this email.

    Thanks,<br>
    **N & S Handicrafts Team**
@endcomponent
