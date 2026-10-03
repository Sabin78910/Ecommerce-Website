<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment; // Switch to LiveEnvironment for production
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentReceivedMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class ControllerCart extends Controller
{

    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price, [
            'image' => $request->image // Store image in the options array
        ])->associate('App\Models\Product');
        return redirect()->back();
    }

    public function cart_quantity_increase($rowid)
    {
        $cart_item = Cart::instance('cart')->get($rowid);
        $product_qty = $cart_item->qty + 1;
        Cart::instance('cart')->update($rowid, $product_qty);
        return redirect()->back();
    }

    public function cart_quantity_decrease($rowid)
    {
        $cart_item = Cart::instance('cart')->get($rowid);
        $product_qty = $cart_item->qty - 1;
        Cart::instance('cart')->update($rowid, $product_qty);
        return redirect()->back();
    }

    public function cart_item_remove($rowid)
    {
        $cart_item = Cart::instance('cart')->remove($rowid);
        return redirect()->back();
    }

    public function cart_empty()
    {
        $cart_item = Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    public function coupons_apply_to_cart(Request $request)
    {
        $coupon_code = $request->coupon_code;
        if (isset($coupon_code)) {
            // Get the subtotal as a string
            $raw_subtotal = Cart::instance('cart')->subtotal(); // e.g., "100,000.00"

            // Remove commas
            $clean_subtotal = str_replace(',', '', $raw_subtotal); // Result: "100000.00"

            // Convert to a float
            $subtotal = (float) $clean_subtotal;
            $coupon = Coupon::where('code', $coupon_code)->where('expiry_date', '>=', Carbon::now())->where('cart_value', '<=', $subtotal)->first();
            if (!$coupon) {
                return redirect()->back()->with('error', 'Coupon Code is not valid for website!');
            } else {
                Session::put('coupon', [
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'cart_value' => $coupon->cart_value,
                ]);
                $this->discount_calculator();
                return redirect()->back()->with('success', 'Coupon code have been applied!');
            }
        } else {
            return redirect()->back()->with('error', 'Coupon code is not valid!');
        }
    }

    public function discount_calculator()
    {
        $discount_value = 0;
        if (Session::has('coupon')) {
            if (Session::get('coupon')['type'] == 'fixed') {
                $discount = Session::get('coupon')['value'];
            } else {
                $discount = (Session::get('coupon')['value'] * Cart::instance('cart')->subtotal()) / 100;
            }
            // Get the subtotal as a string
            $raw_subtotal = Cart::instance('cart')->subtotal(); // e.g., "100,000.00"

            // Remove commas
            $clean_subtotal = str_replace(',', '', $raw_subtotal); // Result: "100000.00"

            // Convert to a float
            $subtotal = (float) $clean_subtotal;
            $sub_total_after_discount = $subtotal - $discount;
            $tax_after_discount = ($sub_total_after_discount * config('cart.tax')) / 100;
            $total_after_discount = $sub_total_after_discount + $tax_after_discount;

            Session::put('discounts', [
                'discount' => number_format(floatval($discount), 2, '.', ''),
                'subtotal' => number_format(floatval($sub_total_after_discount), 2, '.', ''),
                'tax' => number_format(floatval($tax_after_discount), 2, '.', ''),
                'total' => number_format(floatval($total_after_discount), 2, '.', '')

            ]);
        }
    }

    public function delete_coupon_code()
    {
        Session::forget('discounts');
        Session::forget('coupon');
        return redirect()->back()->with('success', 'Coupon code have been removed!');
    }

   // ControllerCart.php

public function checkout()
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $userId = Auth::id();

    // Get all addresses; default first, then newest first
    $addresses = \App\Models\Address::where('user_id', $userId)
        ->orderByDesc('isdefault')
        ->orderBy('created_at', 'desc')
        ->get();

    // Keep BC: $address is still the default (or null)
    $address = $addresses->first();

    return view('checkout', compact('addresses', 'address'));
}


// ControllerCart.php

public function order_place(Request $request)
{
    $user_id = Auth::id();

    // If the user selected an existing address, use it; otherwise validate/create new
    $addressId = $request->input('address_id');

    if ($addressId) {
        // Make sure it belongs to the current user
        $address = Address::where('user_id', $user_id)
            ->where('id', $addressId)
            ->firstOrFail();
    } else {
        // No selection => they’re submitting a new address (validate & create)
        $request->validate([
            'name'      => 'required|max:100',
            'address'   => 'required',
            'landmark'  => 'required',
            'phone'     => ['required','string','max:16','regex:/^\+[1-9]\d{1,14}$/'], // E.164
            'zip'       => 'required|numeric|digits:5',
            'province'  => 'required',
            'city'      => 'required',
            'locality'  => 'required',
            'district'  => 'required',
            'country'   => 'required',
        ]);

        $address = new Address();
        $address->fill($request->only([
            'name','address','landmark','phone','zip','province','city','locality','district','country'
        ]));
        $address->user_id   = $user_id;

        // If this is their first address, make it default; otherwise don’t change default
        $hasAny = Address::where('user_id', $user_id)->exists();
        $address->isdefault = $hasAny ? 0 : 1;

        $address->save();
    }

    // (unchanged) totals + order creation
    $this->amounts_at_checkout();

    $order = new Order();
    $order->fill([
        'user_id'           => $user_id,
        'subtotal'          => (float) str_replace(',', '', Session::get('checkout')['subtotal']),
        'discount'          => (float) str_replace(',', '', Session::get('checkout')['discount']),
        'pre_estimated_tax' => (float) str_replace(',', '', Session::get('checkout')['tax']),
        'pre_estimated_total'=> (float) str_replace(',', '', Session::get('checkout')['total']),
        'total'             => 0.00,
        'tax'               => 0.00,
        'shipping_charge'   => 0.00,
        'shipping_tax'      => 0.00,

        // copy from chosen address
        'locality' => $address->locality,
        'name'     => $address->name,
        'phone'    => $address->phone,
        'address'  => $address->address,
        'city'     => $address->city,
        'province' => $address->province,
        'district' => $address->district,
        'country'  => $address->country,
        'landmark' => $address->landmark,
        'zip'      => $address->zip,
    ]);
    $order->save();

    foreach (Cart::instance('cart')->content() as $item) {
        OrderItem::create([
            'product_id' => $item->id,
            'order_id'   => $order->id,
            'price'      => (float) str_replace(',', '', $item->price),
            'quantity'   => $item->qty,
        ]);
    }

    $transaction = new Transaction();
    $transaction->user_id = $user_id;
    $transaction->order_id = $order->id;
    $transaction->mode   = "bank transfer";
    $transaction->status = "pending";
    $transaction->save();

    Cart::instance('cart')->destroy();
    Session::forget(['checkout','coupon','discounts']);
    Session::put('order_id', $order->id);

    Mail::to($order->user->email)->send(new \App\Mail\OrderConfirmationMail($order->id));

    return redirect()->route('cart.confirmation.of.order');
}


    public function amounts_at_checkout()
    {
        if (!Cart::instance('cart')->content()->count() > 0) {
            Session::forget('checkout');
            return;
        }

        if (Session::has('coupon')) {
            Session::put('checkout', [
                'discount' => Session::get('discounts')['discount'],
                'tax' => Session::get('discounts')['tax'],
                'total' => Session::get('discounts')['total'],
                'subtotal' => Session::get('discounts')['subtotal']
            ]);
        } else {
            Session::put('checkout', [
                'discount' => 0,
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
                'subtotal' => Cart::instance('cart')->subtotal()
            ]);
        }
    }

    public function confirmation_of_order()
    {
        if (Session::has('order_id')) {
            $order = Order::find(Session::get('order_id'));
            return view('confirmation_of_order', compact('order'));
        }
        return redirect()->route('cart.index');
    }

    public function handlePayPal(Request $request)
    {
        // Save checkout data in the session
        Session::put('checkout_data', $request->all());

        // Example conversion logic
        $this->amounts_at_checkout();
        $nprAmount = Session::get('checkout')['total']; // Replace with your calculation
        $nprAmount = floatval(str_replace(',', '', $nprAmount)); // Clean and convert to float
        $conversionRate = 120; // 1 USD = 120 NPR
        $usdAmount = round($nprAmount / $conversionRate, 2);

        // PayPal client setup
        $clientId = config('services.paypal.client_id');
        $clientSecret = config('services.paypal.secret');
        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $client = new PayPalHttpClient($environment);

        // Create the order request
        $orderRequest = new OrdersCreateRequest();
        $orderRequest->prefer('return=representation');
        $orderRequest->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $usdAmount,
                    ],
                ]
            ],
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel'),
            ],
        ];

        try {
            // Create the PayPal order
            $response = $client->execute($orderRequest);

            // Get the approval URL
            foreach ($response->result->links as $link) {
                if ($link->rel === 'approve') {
                    return redirect()->away($link->href);
                }
            }

            return redirect()->back()->with('error', 'Unable to process payment. Please try again.');
        } catch (\Exception $ex) {
            logger()->error('PayPal Error', ['message' => $ex->getMessage()]);
            return redirect()->back()->with('error', 'Unable to process payment. Please try again.');
        }
    }



    public function paypalSuccess(Request $request)
    {
        $orderId = $request->get('token'); // PayPal uses `token` for the order ID

        if (!$orderId) {
            return redirect()->route('cart.index')->with('error', 'Payment failed or canceled.');
        }

        // PayPal client setup
        $clientId = config('services.paypal.client_id');
        $clientSecret = config('services.paypal.secret');
        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $client = new PayPalHttpClient($environment);

        // Capture the payment
        $captureRequest = new OrdersCaptureRequest($orderId);
        $captureRequest->prefer('return=representation');

        try {
            $response = $client->execute($captureRequest);

            if ($response->result->status === 'COMPLETED') {
                // Pass data to the view
                return view('paypal-success', [
                    'paymentId' => $orderId, // Use $orderId as the equivalent of $paymentId
                    'payerId' => $response->result->payer->payer_id, // Extract the payer_id
                    'checkoutData' => Session::get('checkout_data'), // Retrieve saved checkout data
                ]);
            }
        } catch (\Exception $ex) {
            logger()->error('PayPal Error', ['message' => $ex->getMessage()]);
            return redirect()->route('cart.index')->with('error', 'Payment verification failed.');
        }

        return redirect()->route('cart.index')->with('error', 'Payment verification failed.');
    }



    public function paypalCancel()
    {
        return redirect()->route('cart.index')->with('error', 'Payment canceled.');
    }

    /**
     * Display the form where a user can upload proof of payment.
     */
    public function showVerifyPaymentForm(Order $order)
    {
        // 1) Ownership check
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }

        // 2) See if they've already uploaded proof
        $alreadySubmitted = $order->paymentVerification()->exists();

        // 3) Pass that flag to the view
        return view('orders.verify-payment', [
            'order'            => $order,
            'alreadySubmitted' => $alreadySubmitted,
        ]);
    }

    /**
     * Handle the submission of proof‐of‐payment.
     */
    public function verifyPayment(Request $request, Order $order)
    {
        $data = $request->validate([
            'proof_of_payment' => 'required|file|mimes:jpg,png,pdf|max:2048',
            'currency'         => 'required|string|size:3',
            'amount'           => 'required|numeric|min:0',
        ]);

        // 1) Build a unique filename
        $file      = $request->file('proof_of_payment');
        $extension = $file->getClientOriginalExtension();
        $filename  = 'order-'
            . $order->id
            . '-'
            . time()
            . '-'
            . Str::random(8)
            . '.'
            . $extension;

        // 2) Store under storage/app/public/receipts
        $path = $file->storeAs('receipts', $filename, 'public');

        // 3) Create or update the payment_verifications record
        $order->paymentVerification()->updateOrCreate(
            ['order_id' => $order->id],
            [
                'proof_of_payment' => $path,
                'currency'         => strtoupper($data['currency']),
                'amount'           => $data['amount'],
            ]
        );

        // 4) Update the order status
        $order->status = 'payment_completed';
        $order->save();

        // 5) Send the “we received your payment” email
        Mail::to($order->user->email)
            ->send(new PaymentReceivedMail($order));

        return back()->with('success', 'Proof of payment uploaded! We’ll verify and process your order shortly.');
    }
}
