{{-- resources/views/emails/shipping-details.blade.php --}}
@component('mail::message')
    # Good news — your order is on the way!

    **Order ID:** {{ $order->id }}

    **Courier:** {{ $order->shippingDetail->courier_name ?? '—' }}
    **Tracking ID:** {{ $order->shippingDetail->tracking_id ?? '—' }}
    @if ($order->shippingDetail->tracking_url)
        @component('mail::button', ['url' => $order->shippingDetail->tracking_url])
            View Tracking
        @endcomponent
    @endif

    Once you click the button, you’ll see live updates of your package’s journey.
    If you have any questions, just hit reply!

    Thank you for shopping with N &amp; S Handicrafts.
    We hope to serve you again soon.

    Regards,
    N &amp; S Handicrafts Team
@endcomponent
