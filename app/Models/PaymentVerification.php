<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentVerification extends Model
{
    protected $fillable = [
        'order_id',
        'proof_of_payment',
        'currency',
        'amount',
    ];

    /**
     * Link back to the Order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
