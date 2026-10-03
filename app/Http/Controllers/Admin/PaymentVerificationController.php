<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentVerifiedMail;
use App\Models\Transaction;

class PaymentVerificationController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        // start with any verifications whose order.status = 'payment completed'
        $builder = PaymentVerification::with('order')
            ->whereHas('order', function ($query) {
                $query->where('status', 'payment completed');
            });

        // apply your search filter if supplied
        if ($q) {
            $builder->where(function ($query) use ($q) {
                $query->where('order_id', 'like', "%{$q}%")
                    ->orWhere('currency', 'like', "%{$q}%");
            });
        }

        $verifications = $builder
            ->latest()
            ->paginate(20)
            ->appends(['q' => $q]);

        return view('admin.payment-verifications.index', compact('verifications'));
    }


    public function show(PaymentVerification $verification)
    {
        // just dump the record
        return view('admin.payment-verifications.show', compact('verification'));
    }

    public function destroy(PaymentVerification $verification)
    {
        // also delete the file?
        Storage::disk('public')->delete($verification->proof_of_payment);
        $verification->delete();
        return redirect()
            ->route('admin.payment-verifications.index')
            ->with('status', 'Payment record deleted.');
    }

    /**
     * Mark a payment as verified, update related transaction,
     * and notify the customer by email.
     *
     * @param  \App\Models\PaymentVerification  $verification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(PaymentVerification $verification)
    {
        // 1) Update the order status
        $order = $verification->order;
        $order->status = 'payment_verified';
        $order->save();

        // 2) Also mark its transaction approved (if you have one-to-one)
        if ($order->transactions()->exists()) {
            $tx = $order->transactions()->latest()->first();
            $tx->status = 'approved';
            $tx->save();
        }

        // 3) Send “payment verified” email
        Mail::to($order->user->email)
            ->send(new PaymentVerifiedMail($order));

        // 4) Redirect back with a flash message
        return back()->with('status', 'Payment marked as verified and customer notified.');
    }
}
