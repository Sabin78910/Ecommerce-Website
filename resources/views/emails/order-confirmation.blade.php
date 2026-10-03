<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Confirmation</title>
    </head>

    <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
        <main>
            <h2 style="text-align: center;">Order Received</h2>
            <p style="text-align: center;">
                Thank you for your order. Below are the details we have on record.
            </p>

            <div style="max-width: 600px; margin: 0 auto;">
                <h3>Your Order Details</h3>
                <p><strong>Order Number:</strong> {{ $order->id }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('F j, Y, g:i a') }}</p>

                <h4>Items:</h4>
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Product</th>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItem as $item)
                            <tr>
                                <td style="border: 1px solid #ddd; padding: 8px;">
                                    {{ $item->product->name }} x {{ $item->quantity }}
                                </td>
                                <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">
                                    Rs. {{ number_format((float) $item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h4>Summary:</h4>
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Subtotal</th>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">
                            Rs. {{ number_format((float) $order->subtotal, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Discount</th>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">
                            Rs. {{ number_format((float) $order->discount, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Pre-Estimated VAT</th>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">
                            Rs. {{ number_format((float) $order->pre_estimated_tax, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Pre-Estimated Total</th>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">
                            Rs. {{ number_format((float) $order->pre_estimated_total, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Shipping Charge</th>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">
                            Estimation Needed
                        </td>
                    </tr>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Shipping VAT</th>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">
                            Estimation Needed
                        </td>
                    </tr>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Final VAT</th>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">
                            Estimation Needed
                        </td>
                    </tr>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Final Total</th>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">
                            Estimation Needed
                        </td>
                    </tr>
                </table>

                <p style="text-align: center; color: #555; font-size: 0.9rem; line-height: 1.4;">
                    Final total will be quoted after we calculate shipping charges for your order.
                    You’ll receive the final quotation by email once the estimate is complete—
                    this may take <strong>1–3 working days</strong>. Thank you for shopping with us!
                </p>
            </div>
        </main>
    </body>

</html>
