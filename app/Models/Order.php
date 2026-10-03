<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transactions()
    {
        return $this->hasOne(Transaction::class);
    }

    public function paymentVerification()
    {
        return $this->hasOne(PaymentVerification::class);
    }

    /**
     * One order has one ShippingDetail.
     */
    public function shippingDetail()
    {
        return $this->hasOne(ShippingDetail::class);
    }

    // Allow mass assignment for these fields
    protected $fillable = [
        'user_id',
        'subtotal',
        'discount',
        'tax',
        'total',
        'locality',
        'name',
        'phone',
        'address',
        'city',
        'province',
        'district',
        'zip',
        'pre_estimated_tax',
        'pre_estimated_total',
        'shipping_charge',
        'shipping_tax',
        'country'
    ];
}
