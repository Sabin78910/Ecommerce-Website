<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingDetail extends Model
{
    // The table name is the plural of the model, so no need to set $table

    protected $fillable = [
        'order_id',
        'courier_name',
        'tracking_id',
        'tracking_url',
    ];

    /**
     * Each ShippingDetail belongs to one Order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
